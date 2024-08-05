# Bookstore Application

This is a demo application for a bookstore, built with PHP and MySQL, and containerized using Docker and Docker Compose.

## Prerequisites

- Docker
- Docker Compose

## Setup

1. Clone the repository:

    ```bash
    git clone git@github.com:filipkojic/BookStore.git
    cd bookstore
    ```

2. Create a `.env` file in the root directory with the following content:

    ```env
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=Bookstore
    DB_USERNAME=root
    DB_PASSWORD=123
    ```

**Note:** You can change `DB_DATABASE` and `DB_PASSWORD` to fit your requirements, but `DB_USERNAME` should remain as `root` unless you plan to create additional users in the MySQL container.

3. Pull the Docker image from Docker Hub:

    ```bash
    docker pull filipkojic99/bookstore_app:latest
    ```

4. Update the `docker-compose.yml` file to use the pulled image:

    ```yaml
    version: '3.8'

    services:
      app:
        image: filipkojic99/bookstore_app:latest
        ports:
          - "8081:80"
        depends_on:
          - db
        environment:
          - DB_HOST=${DB_HOST}
          - DB_PORT=${DB_PORT}
          - DB_DATABASE=${DB_DATABASE}
          - DB_USERNAME=${DB_USERNAME}
          - DB_PASSWORD=${DB_PASSWORD}
        volumes:
          - .:/var/www/html

      db:
        image: mysql:5.7
        environment:
          MYSQL_ROOT_PASSWORD: ${DB_PASSWORD}
          MYSQL_DATABASE: ${DB_DATABASE}
        ports:
          - "3307:3306"
        volumes:
          - db_data:/var/lib/mysql
          - ./init.sql:/docker-entrypoint-initdb.d/init.sql

    volumes:
      db_data:
    ```

5. Build and start the Docker containers:

    ```bash
    docker-compose up -d --build
    ```

6. Access the application in your web browser at [http://localhost:8081](http://localhost:8081).
