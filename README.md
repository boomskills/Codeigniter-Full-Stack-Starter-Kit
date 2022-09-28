# Codeigniter Full-Stack Starter Kit

Codeigniter Full-Stack Starter Kit is a PHP starter template for Codeigniter4, the currently supported codeigniter web framework.

> Starting a new project from scratch sometimes can be tricky, from setting up, installations and so on. This starter kit template however gives you the starting point you need, it comes ready set for development with any kind of development environment currently supporting docker. You can use it to start your project of any kind, from blogging websites, customer projects or even your personal website.

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](http://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [the announcement](http://forum.codeigniter.com/thread-62615.html) on the forums.

The user guide corresponding to this version of the framework can be found
[here](https://codeigniter4.github.io/userguide/).

# Quick Start

Clone the repository.

```
git clone https://github.com/Holoog/Codeiginter-Full-Stack-Starter-Kit
```

## Next run

```
> composer install
```

Ensure composer is already installed on your system.

## Setup

Copy `env` to `.env`

## Next run

```
> php spark key:generate
```

# Development with Docker

To run the application locally, using docker, ensure docker is already installed on your system, run the following commands.

```
> docker-compose up –-build
```

or

```
> docker-compose up -d
```

## Next run:

```
> docker ps
```

Find the `container ID` of the `app` something like `boomskills/ci-fullstack-starter-kit`

## Next run

Login into the container by executing.

```
> docker exec -it CONTAINER-ID bash
```

# Migrations

Run the below commands while logged in docker.

```
> php spark migrate
```

```
> php spark db:seed DatabaseSeeder
```

## Home

Visit `http://localhost:2526` in the browser to view your application.

# Database

This starter kit already comes with phpmyadmin ready set up.\
visit `http://localhost:2527` in the browser to access the phpmyadmin dashboard.

Login credentials:\
`username:` db-codeigniter-fullstack-starter-kit-user\
`password:` secret

Ready for development with docker. Go ahead and build your ext big thing with codeigniter.

# About

Please note; this template is till under improvement, if you want to contributes, you are welcome to clone the repository and submit a pull request.

## Thanks to

[MyAuth](https://github.com/lonnieezell/myth-auth) The authentication library used.

## Server Requirements

PHP version 7.3 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)
