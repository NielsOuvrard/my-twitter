import argparse
import requests
import unittest

from color import TextColor

class InvalidHTTPMethodError(Exception):
    pass

class TestBackend(unittest.TestCase):
    url = None
    data_user = None

    @classmethod
    def setUpClass(cls):
        response = cls.execute(cls, 'GET', 'publications')

        response = cls.execute(cls, 'POST', 'register', {
            "username": "string",
            "password": "string",
            "email": "string"
        })

        response = cls.execute(cls, 'POST', 'login', {
            "email": "string",
            "password": "string"
        })
        cls.data_user = response.json()
        print(f'create user {cls.data_user['user']}')

    @classmethod
    def tearDownClass(cls):
        # try:
        #     self.test_delete_user()
        # except:
        pass

    def setUp(self):
        print(f'running {self._testMethodName}')


    def execute(self, method, endpoint, data=None, token=None, log_error=True):
        headers = {}
        if token:
            headers['Authorization'] = f'Bearer {token}'
            # print(f'{headers=}')

        try:
            if method == "GET":
                response = requests.get(f"{self.url}/{endpoint}", headers=headers)
            elif method == "POST":
                response = requests.post(f"{self.url}/{endpoint}", json=data, headers=headers)
            elif method == "PUT":
                response = requests.put(f"{self.url}/{endpoint}", json=data, headers=headers)
            elif method == "DELETE":
                response = requests.delete(f"{self.url}/{endpoint}", headers=headers)
            else:
                raise InvalidHTTPMethodError(f"Error: Invalid HTTP method '{method}'")
            response.raise_for_status()

        except requests.exceptions.HTTPError as http_err:
            if log_error:
                print(f"HTTP error occurred: {http_err.response.text}")
            raise
        except Exception as err:
            if log_error:
                print(f"Other error occurred: {err}")
            raise

        return response

    def test_recreate_user(self):
        is_passing = False
        response = None
        try:
            response = self.execute('POST', 'register', {
                "username": "string",
                "password": "string",
                "email": "string"
            }, log_error=False)
        except:
            if response.status_code == 400: # should be 409: conflict, todo change it backend side
                is_passing = True

        self.assertTrue(is_passing, "User should be deleted, but it did not return the correct status.")

    def test_delete_user(self):
        self.execute('DELETE', f'users', token=self.data_user['token'])

    def test_redelete_user(self):
        is_passing = False

        response = self.execute('DELETE', f'users', token=self.data_user['token'])
        if response.status_code == 400:
            is_passing = True
        
        self.assertTrue(is_passing, "User should be deleted, but it did not return the correct status.")


class TestPublications(TestBackend):
    publication_id = None

    def test_create_publication(self):
        response = self.execute('POST', 'publications', token=self.data_user['token'])
        pub_id = response.json().get('id')  # Assuming response contains the created publication ID
        self.__class__.publication_id = pub_id

        response = self.execute('GET', 'publications')
        self.assertFalse(pub_id in response.json(), f"Publication {pub_id} not found in {response.json()}")


    def test_delete_publication(self):
        if self.__class__.publication_id:
            self.execute('DELETE', f'publications/{self.__class__.publication_id}', token=self.data_user['token'])

class TestMessages(TestBackend):
    message_id = None

    def test_create_message(self):
        response = self.execute('POST', f'messages/{self.data_user["id"]}', token=self.data_user['token'])
        self.__class__.message_id = response.json().get('id')  # Assuming response contains the created message ID

    def test_delete_message(self):
        if self.__class__.message_id:
            self.execute('DELETE', f'messages/{self.__class__.message_id}', token=self.data_user['token'])

    def test_get_last_users_messages(self):
        self.execute('GET', 'messages', token=self.data_user['token'])

    def test_get_messages(self):
        if self.__class__.message_id:
            self.execute('GET', f'messages/{self.__class__.message_id}', token=self.data_user['token'])


def suite(link):
    suite = unittest.TestSuite()
    TestBackend.url = link

    # # Test users
    # suite.addTest(TestBackend('test_recreate_user'))

    # # Test publications
    # suite.addTest(TestPublications('test_create_publication'))
    # suite.addTest(TestPublications('test_delete_publication'))

    # # Test messages
    # suite.addTest(TestMessages('test_create_message'))
    # suite.addTest(TestMessages('test_get_last_users_messages'))
    # suite.addTest(TestMessages('test_get_messages'))
    # suite.addTest(TestMessages('test_delete_message'))

    # Cleanup
    suite.addTest(TestBackend('test_delete_user'))
    # suite.addTest(TestBackend('test_redelete_user'))
    return suite


if "__main__" == __name__:
    parser = argparse.ArgumentParser(description='My-Twitter unit testing')
    parser.add_argument('--link', help='could change depending the environement', type=str, default='http://ouvrard.niels.free.fr/index.php?', dest='link')

    args = parser.parse_args()

    runner = unittest.TextTestRunner()
    runner.run(suite(args.link))
