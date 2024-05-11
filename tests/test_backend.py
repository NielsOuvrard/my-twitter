import requests

def test_backend(url):
    response = requests.get(url)
    if response.status_code == 200:
        print("Backend is working properly.")
        print("Response:", response)
    else:
        print("There seems to be an issue with the backend.")

# Replace with your backend URL
test_backend("http://localhost:8000")
