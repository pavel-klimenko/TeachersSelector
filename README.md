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


# **Install personal chat bundle:**

Bundle placed in the root directory like /PersonalChatBundle

1) Configure PersonalChatBundle repository in the main composer.json
   "repositories": [
       {
        "type": "path",
        "url": "./PersonalChatBundle",
        "options": {"symlink": true }
        }
   ],

2) Add "pavel-klimenko/personal-chat-bundle": ">=1", into "require" section
   in the main composer.json

3) Add PersonalChatBundle environmental variables to .env
   Example:
    CHAT_WEB_SOCKET_HOST='127.0.0.1'
    CHAT_WEB_SOCKET_PORT=8101
    CHAT_SERVER_HOST=nginx
    WS_SIGN_SECRET={secret string}

4) install the bundle: composer update pavel-klimenko/personal-chat-bundle

5) Add to config/packages/doctrine.yaml relation between project users and PersonalChatBundle participants
   to orm section

   orm:
       resolve_target_entities:
           PersonalChatBundle\Domain\Entity\ChatUserInterface: App\Domain\Entity\User

6) Add implements ChatUserInterface to User entity 
7) Sync Users and Chat participants executing console command:
   php bin/console personal-chat:sync-participants
8) Start Swoole websocket server 
   php bin/console personal-chat:ws-server-start
9) Start chat messages consumer:
   php bin/console messenger:consume personalChats -vv
10) Add to header link to the Chat bundle page
    <a class="...." href="{{ path('personal_chat_view') }}">{Custom chats page name}</a>