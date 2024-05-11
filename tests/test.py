import requests
import json

def test_backend(url):
    expected = json.loads("""
                [
                {
                    "id": 1,
                    "username": "user1",
                    "email": "user1@example.com",
                    "created_at": "2024-05-11 12:38:05"
                },
                {
                    "id": 2,
                    "username": "user2",
                    "email": "user2@example.com",
                    "created_at": "2024-05-11 12:38:05"
                },
                {
                    "id": 3,
                    "username": "user3",
                    "email": "user3@example.com",
                    "created_at": "2024-05-11 12:38:05"
                },
                {
                    "id": 4,
                    "username": "user4",
                    "email": "user4@example.com",
                    "created_at": "2024-05-11 12:38:05"
                },
                {
                    "id": 5,
                    "username": "user5",
                    "email": "user5@example.com",
                    "created_at": "2024-05-11 12:38:05"
                }
                ]
                """)
    response = requests.get(url)
    if response.status_code == 200:
        if json.loads(response.text) == expected:
            print("Backend is working properly.")
        else:
            print("There seems to be an issue with the backend.")
    else:
        print("There seems to be an issue with the backend.")

# Replace with your backend URL
test_backend("http://localhost:8000")
