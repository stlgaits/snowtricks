# SnowTricks

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/a1e9427639b146e8a0f82186a19859d1)](https://app.codacy.com/gh/EstelleMyddleware/snowtricks?utm_source=github.com&utm_medium=referral&utm_content=EstelleMyddleware/snowtricks&utm_campaign=Badge_Grade_Settings)

Symfony blog project. Full documentation for the project is available [here](https://estellemyddleware.github.io/snowtricks/)

## Getting Started

This project was setup using [dunglas/symfony-docker](https://github.com/dunglas/symfony-docker)

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker-compose build --pull --no-cache` to build fresh images
3. Run `docker-compose up` (the logs will be displayed in the current shell)
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker-compose down --remove-orphans` to stop the Docker containers.

## Features of the Docker image

* Production, development and CI ready
* Automatic HTTPS (in dev and in prod!)
* HTTP/2, HTTP/3 and [Preload](https://symfony.com/doc/current/web_link.html) support
* Built-in [Mercure](https://symfony.com/doc/current/mercure.html) hub
* [Vulcain](https://vulcain.rocks) support
* PHP FPM and Caddy server

## Credits

Created by [Estelle Gaits](http://estellegaits.fr) as the sixth project of the Openclassrooms PHP / Symfony Apps Developer training course.
