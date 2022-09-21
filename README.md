# Codeigniter Full-Stack Starter Kit

Codeigniter Full-Stack Starter Kit is a PHP starter template for Codeigniter4, the currently supported codeigniter web framework.

> Starting a new project from scratch sometimes can be tricky, from setting up, installations and so on. This starter kit template however gives you the starting point you need, it comes ready set for development with any kind of development environment currently supporting docker. You can use it to start your project of any kind, from blogging websites, customer projects or even your personal website.

If you are new to Codeigniter, please visit this link to learn more about Codeigniter PHP web framework.

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

# Development with Docker

To run the application locally, using docker, ensure docker is already installed on your system, run the following commands.

```
> docker-compose up –-build
```

or

```
> docker-compose up -d
```

The second command will run docker in the background, it may not be the best option when running the app for the first time as you may want to track the progress in case there will be some errors, so a recommended option is to run the first command.

## Next run:

```
> docker ps
```

Find the `container ID` of the `app` something like `codeigniter-fullstack-starter-kit`

## Next run

Login into the container by executing

```
> docker exec -it CONTAINER-ID bash
```

# Migrations

Run the below command while logged in docker.

```
> php spark migrate
```

## Home

Visit `http://localhost:2525` in the browser to view your application

# Database

This starter kit already comes with phpmyadmin ready set up.\
visit `http://localhost:2527` in the browser to access to phpmyadmin dashboard.

Login credentials:\
`username:` db-codeigniter-fullstack-starter-kit-user\
`password:` secret

Ready for development with docker.
