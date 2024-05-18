# Website Free

Complet website hosted on a free server (for free).
It's a reproduction of Twitter with Vue.js and PHP.

## [Website](http://niels.ouvrard.free.fr/)

## Frontend

### Architecture

```sh
frontend/
├── babel.config.js
├── package-lock.json
├── package.json
│
├── public
│   ├── favicon.ico
│   ├── index.html
│   └── robots.txt
│
└── src
    ├── App.vue
    ├── main.ts
    │
    ├── assets
    │   └── logo.png
    │
    ├── components
    │   ├── PublicationCard.vue
    │   └── UserCard.vue
    │
    ├── router
    │   └── index.ts
    │
    ├── store
    │   └── index.ts
    │
    ├── types
    │   └── types.ts
    │
    └── views
        ├── AboutView.vue
        ├── HomeView.vue
        ├── LoginView.vue
        ├── MessageView.vue
        ├── MessagesView.vue
        ├── NotFoundView.vue
        ├── ProfileView.vue
        ├── PublicationsView.vue
        ├── RegisterView.vue
        ├── UserView.vue
        └── UsersView.vue
```

## Backend

### Architecture

```sh
backend/
├── Makefile
├── index.php
├── request.log
├── run_local.sh
│
├── routes
│   └── routes.php
│
├── utils
│   ├── db.php
│   ├── jwt.php
│   ├── response.php
│   └── tools.php
│
└── controllers
    ├── AuthController.php
    ├── MessagesController.php
    ├── PublicationsController.php
    ├── RelationshipsController.php
    └── UserController.php
```

## Features to add

### CI/CD

-   [ ] Add docker environments for frontend and backend

### Frontend

-   [ ] Add JWT token
-   [ ] Add a login / register / logout page
-   [ ] Add a profile page with is-admin bio profile picture location job ...
-   [ ] Add a chat page

### Backend

-   [ ] Add controllers for Message, Relationship
-   [ ] Better way to grab /{id} in routes

## Tools

[![Made with Vue 3](https://img.shields.io/badge/Made%20with-Vue-42b883.svg)](https://vuejs.org/)
[![Made with PHP 5.6.34](https://img.shields.io/badge/Made%20with-PHP-777BB4.svg)](https://www.php.net/)
[![Made with MySQL](https://img.shields.io/badge/Made%20with-MySQL-4479A1.svg)](https://www.mysql.com/)

<!-- [![Documentation](https://img.shields.io/badge/Documentation-Yes-brightgreen.svg)](https://rclovis.github.io/R-Type-Documentation/) -->

[<img alt="Deployed with FTP Deploy Action" src="https://img.shields.io/badge/Deployed With-FTP DEPLOY ACTION-%3CCOLOR%3E?style=for-the-badge&color=2b9348">](https://github.com/SamKirkland/FTP-Deploy-Action)
