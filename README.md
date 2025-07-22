# **Description:**

"Teacher selector" is the platform with helps students to choose best teacher
according to rating, experience, hour rate, teacher's expertise and studying mode.
It connects students and experienced teachers from whole world!

# **Technologies:**
- PHP 8.3
- Nginx (upstream balancing)
- PostgreSQl
- Symfony 7 framework
- Docker

# **Install project:**
1) Build and run docker containers: docker compose up --build
2) Go to php-fpm container: docker exec -it fpm1 bash
3) install packages: composer i
4) Up migrations: php bin/console doctrine:migrations:migrate
5) Fill the table with test data: php bin/console doctrine:fixtures:load