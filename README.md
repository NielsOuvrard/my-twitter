# My Twitter

### This is a reproduction of Twitter with Vue.js and PHP.

Vue 3 for the frontend.
PHP 5.6.34 for the backend (It's the version on the free server).
MySQL for the database.

Complet website hosted on a Free server (for free ofc).

[Link to my-twitter website](http://niels.ouvrard.free.fr/)

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
    │   └── [...].vue
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
        └── [...].vue
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
    └── [...].php
```

## Features to add

### CI/CD

- [ ] Add docker environments for frontend and backend

### Frontend

- [ ] Can comment / like publications
- [ ] Limit of characters shown in preview publications / messages
- [ ] Link search bar with backend
- [ ] Recent posts of users on their profile
- [ ] Individual page for publication
- [ ] Push to user / publication where you click
- [ ] Take in store data to avoid multiple fetch

- [ ] Refont like / comment esthetic
- [ ] Refont login / register esthetic

### Backend

- [ ] Fix 'getLastUsersMessages' route to avoid double users
- [ ] Better way to grab /{id} in routes
- [ ] Search bar route

## Tools

[![Made with Vue 3](https://img.shields.io/badge/Made%20with-Vue-42b883.svg)](https://vuejs.org/)
[![Made with PHP 5.6.34](https://img.shields.io/badge/Made%20with-PHP-777BB4.svg)](https://www.php.net/)
[![Made with MySQL](https://img.shields.io/badge/Made%20with-MySQL-4479A1.svg)](https://www.mysql.com/)

<!-- [![Documentation](https://img.shields.io/badge/Documentation-Yes-brightgreen.svg)](https://rclovis.github.io/R-Type-Documentation/) -->

[<img alt="Deployed with FTP Deploy Action" src="https://img.shields.io/badge/Deployed With-FTP DEPLOY ACTION-%3CCOLOR%3E?style=for-the-badge&color=2b9348">](https://github.com/SamKirkland/FTP-Deploy-Action)
