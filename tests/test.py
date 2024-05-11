import requests
import json

expected_list_users = """
[
    {
        "id": 1,
        "username": "user1",
        "email": "user1@example.com"
    },
    {
        "id": 2,
        "username": "user2",
        "email": "user2@example.com"
    },
    {
        "id": 3,
        "username": "user3",
        "email": "user3@example.com"
    },
    {
        "id": 4,
        "username": "user4",
        "email": "user4@example.com"
    },
    {
        "id": 5,
        "username": "user5",
        "email": "user5@example.com"
    }
]
"""

class TestBackend():
    def __init__(self):
        self.url = "http://localhost:8000"

    def show_diff(self, expected, actual):
        print("Expected:")
        print(expected)
        print("Actual:")
        print(actual)

    def execute(self, method, endpoint, data=None):
        if method == "GET":
            response = requests.get(f"{self.url}/{endpoint}")
        elif method == "POST":
            response = requests.post(f"{self.url}/{endpoint}", json=data)
        elif method == "PUT":
            response = requests.put(f"{self.url}/{endpoint}", json=data)
        elif method == "DELETE":
            response = requests.delete(f"{self.url}/{endpoint}")
        else:
            print("Error: Invalid HTTP method.")
            return

        return response
    
    def test(self, method, endpoint, data=None, expected=None):
        response = self.execute(method, endpoint, data)

        if response.status_code == 200:
            try:
                response_data = json.loads(response.text)
            except json.JSONDecodeError:
                print("Error: Response is not a valid JSON.")
                print(response.text)
                return
            if response_data == expected:
                print("Backend is working properly.")
            else:
                print("Error: Backend is not returning the expected data.")
                self.show_diff(expected, response_data)
        else:
            print("Error: Backend is not reachable.")

    def test_list_users(self):
        self.test("GET", "users", expected=json.loads(expected_list_users))

    def test_create_user(self):
        data = {
            "username": "john.doe",
            "email": "john.doe@example.com",
            "password": "password"
        }
        self.test("POST", "users", data=data, expected=json.loads("{ 'message': 'User created successfully.' }"))

if __name__ == '__main__':
    test = TestBackend()
    test.test_list_users()
    # test.test_create_user()
