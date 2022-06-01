# SnowTricks

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/30d28b33b7fd4fbb92d0a523cff172eb)](https://www.codacy.com/gh/EstelleMyddleware/snowtricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=EstelleMyddleware/snowtricks&amp;utm_campaign=Badge_Grade)
[![GitHub release (latest by date)](https://img.shields.io/github/v/release/EstelleMyddleware/snowtricks)](https://github.com/EstelleMyddleware/snowtricks)
![GitHub package.json dependency version (prod)](https://img.shields.io/github/package-json/dependency-version/EstelleMyddleware/snowtricks/bootstrap)
![GitHub repo size](https://img.shields.io/github/repo-size/EstelleMyddleware/snowtricks)
[![GitHub issues](https://img.shields.io/github/issues/EstelleMyddleware/snowtricks)](https://github.com/EstelleMyddleware/snowtricks/issues)
[![GitHub closed issues](https://img.shields.io/github/issues-closed/EstelleMyddleware/snowtricks)](https://github.com/EstelleMyddleware/snowtricks/issues?q=is%3Aissue+is%3Aclosed)
![GitHub last commit](https://img.shields.io/github/last-commit/EstelleMyddleware/snowtricks)
[![docsify](https://img.shields.io/badge/documented%20with-docsify-cc00ff.svg)](https://docsify.js.org/)

Symfony blog project. Full documentation for the project is available [here](https://estellemyddleware.github.io/snowtricks/)

## Getting Started

<!-- tabs:start -->

## **Install via Docker**

This project was setup using [dunglas/symfony-docker](https://github.com/dunglas/symfony-docker)

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker-compose build --pull --no-cache` to build fresh images
3. Run `docker-compose up` (the logs will be displayed in the current shell)
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker-compose down --remove-orphans` to stop the Docker containers.

### Building Node.js web assets

Open a shell inside the Node.js container and run the following commands to install & build web assets :

```bash
yarn install
yarn build
```

#### Loading the initial data (first 10 tricks)

Open a shell inside the NPHP container and run the following commands to load the inital data set :

```bash
 php bin/console doctrine:fixtures:load --append
```

### Features of the Docker image

* Production, development and CI ready
* Automatic HTTPS (in dev and in prod!)
* HTTP/2, HTTP/3 and [Preload](https://symfony.com/doc/current/web_link.html) support
* Built-in [Mercure](https://symfony.com/doc/current/mercure.html) hub
* [Vulcain](https://vulcain.rocks) support
* PHP FPM and Caddy server

### **Simple local web server**

#### Downloading the project

If you would like to install this project on your computer, you will first need to [clone the repo](https://github.com/EstelleMyddleware/snowtricks) of this project using Git.

At the root of your projet, you need to create a .env.local file (same level as .env) in which you need to configure the appropriate values for your blog to run. Specifically, you need to override the following variables :

```text
DATABASE_URL="mysql://root:password@localhost:3306/snowtricks"
ADMIN_EMAIL=youremail@example.com
ADMIN_PASSWORD=ChooseAStrongPersonalPasswordHere
ADMIN_USERNAME=youradminusername
 ```

#### Requirements

* PHP 8.1.4 or above
* yarn & Node.js
* [composer](https://getcomposer.org/download/)
* Download the [Symfony CLI](https://symfony.com/download).
* Run this command will guide you in cases there are missing extensions or parameters you need to tweek on your machine

```bash
symfony check:requirements  
```

#### Install dependencies

Before running the project, you need to run the following commands in order to install the appropriate dependencies.

```bash
composer install
```

#### Create a database

Now let's create our database. This will use the DATABASE_URL you've provided in .env.local file.

```bash
php bin/console doctrine:database:create
```

#### Generating the database schema

```bash
 php bin/console doctrine:schema:update --force
 ```

#### Loading the initial data (first 10 tricks, admin user, images & videos)

```bash
php bin/console doctrine:fixtures:load --append
```

#### Install & build web assets

```bash
yarn install
yarn build
```

Now you should be ready to launch the dev webserver using

```bash
symfony serve
```

The ```symfony serve``` command will start a PHP webserver.
You can now go to your localhost URL : <http://127.0.0.1:8000> where the blog should be displayed.

>NB: alternatively, if you do not wish to use the Symfony webserver, you can always use WAMP / Laragon / MAMP or a similar webserver suite.

<!-- tabs:end -->

## Credits

Created by [Estelle Gaits](http://estellegaits.fr) as the sixth project of the Openclassrooms PHP / Symfony Apps Developer training course.
