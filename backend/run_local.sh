#!/bin/bash

export DB_USERNAME=root
export DB_PASSWORD=password
export DB_SERVERNAME=127.0.0.1
export JWT_SECRET_KEY=secret

php -S localhost:8000 -t .
