# Codeigniter Full-Stack Starter Kit

Codeigniter Full-Stack Starter Kit is a PHP starter template for Codeigniter4, the currently supported codeigniter web framework.

> Starting a new project from scratch sometimes can be tricky, from setting up, installations and so on. This starter kit template however gives you the starting point you need, it comes ready set for development with any kind of development environment currently supporting docker. You can use it to start your project of any kind, from blogging websites, customer projects or even your personal website.

If you are new to Codeigniter, please visit this [Link](https://codeigniter4.github.io/userguide/) to learn more about Codeigniter PHP web framework.

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
