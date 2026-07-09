<?php

define('ADMIN_USER',      env('ADMIN_USER', 'admin'));
// Hash-ul parolei admin este citit din .env (ADMIN_PASS_HASH). Generează unul nou cu:
//   php -r "echo password_hash('parola-ta', PASSWORD_BCRYPT);"
define('ADMIN_PASS_HASH', env('ADMIN_PASS_HASH', '$2y$12$sMQKnkTIprhZmyoDTtyyEOygW52IxZbAczEwv3VTABKgEGicjrQoa'));
