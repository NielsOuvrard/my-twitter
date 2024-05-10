# Website Free

Complet website hosted on a free server (for free).

## [Website](http://ouvrard.niels.free.fr/)


## Frontend


### Architecture

```sh
./
├── README.md
├── api
│   └── ...
├── babel.config.js
├── package-lock.json
├── package.json
├── public
│   ├── favicon.ico
│   ├── img
│   │   └── icons
│   │       └── ...
│   ├── index.html
│   └── robots.txt
├── src
│   ├── App.vue
│   ├── assets
│   │   └── logo.png
│   ├── components
│   │   └── ...
│   ├── main.ts
│   ├── note.txt
│   ├── registerServiceWorker.ts
│   ├── router
│   │   └── index.ts
│   ├── shims-vue.d.ts
│   ├── store
│   │   └── index.ts
│   └── views
│       └── ...
├── tsconfig.json
└── vue.config.js
```

## Backend

### Architecture

(for now it's only an `index.php` file)

```sh
./api
├── index.php
├── app
│   ├── controller
│   │   ├── InteractionsController.php
│   │   ├── MessagesController.php
│   │   └── UsersController.php
│   ├── model
│   │   ├── Interaction.php
│   │   ├── Message.php
│   │   └── User.php
│   └── view
│       ├── interactions
│       │   ├── create.php
│       │   ├── edit.php
│       │   ├── index.php
│       │   └── show.php
│       ├── messages
│       │   ├── create.php
│       │   ├── edit.php
│       │   ├── index.php
│       │   └── show.php
│       └── users
│           ├── create.php
│           ├── edit.php
│           ├── index.php
│           └── show.php
├── config
│   └── database.php
└── vendor
    ├── .htaccess
    └── composer.json
```


## 🛠️ Tools

[![Made with Vue 3](https://img.shields.io/badge/Made%20with-Vue-42b883.svg)](https://vuejs.org/)
[![Made with PHP 5.6.34](https://img.shields.io/badge/Made%20with-PHP-777BB4.svg)](https://www.php.net/)
[![Made with MySQL](https://img.shields.io/badge/Made%20with-MySQL-4479A1.svg)](https://www.mysql.com/)
<!-- [![Documentation](https://img.shields.io/badge/Documentation-Yes-brightgreen.svg)](https://rclovis.github.io/R-Type-Documentation/) -->

[<img alt="Deployed with FTP Deploy Action" src="https://img.shields.io/badge/Deployed With-FTP DEPLOY ACTION-%3CCOLOR%3E?style=for-the-badge&color=2b9348">](https://github.com/SamKirkland/FTP-Deploy-Action)
