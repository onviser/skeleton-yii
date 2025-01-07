# Skeleton, Yii2

[Yii2](https://www.yiiframework.com/) is a framework for rapid development of small / medium projects in PHP.  
**Advantages**: fast, high development speed, good documentation, excellent debug panel, convenient operation with
assets.  
**Disadvantages**: complexity of configuration, use of anti-patterns (Singleton, Active Record), using outdated
technologies (jQuery).

## Difference from the basic version

1. Added the ability to work with .env file instead of the standard mechanism for working with config files in Yii2.
2. Added a console controller for user management (add, update, delete, list).
3. Added two layouts: for the public part of the site (frontend) and for the admin panel (backend).
4. Added two assets: for the public part of the site (frontend) and for the admin panel (backend).
5. Enabled session storage in the database.
6. Enabled log storage in the database.
7. ActiveForm is not used (it allowed to refuse jQuery).
8. Added customizable CAPTCHA (CaptchaWidget): you can customize the characters (for example, to use the national
   alphabet), you can customize the color of characters and background in the widget code.
9. Added bruteforce protection: the BlockerIp class allows you to limit the number of login attempts and feedback form
   submissions.
10. Logging is configured.

## Preparing for install

Hopefully you already have a LEMP or LAMP stack installed. I also hope you have a database server (MySQL or PostgreSQL) configured.  
I am using PHP (8.3) and MariaDB (10.6.16) installed in a docker environment.

## How to install

```
# Clone repository from GitHub:
git clone https://github.com/onviser/skeleton-yii.git

# Create an .env file, then set the database name, user, and password in the .env file, and set the COOKIE_VALIDATION_KEY parameter:
cd skeleton-yii
cp .env.example .env
nano .env

# Install the required dependencies via Composer:
composer install

# Run the migrations:
php yii migrate/up

# Create user:
php yii user/create
group_id: 1
email: admin@example.com
password:
User added.

# Try logging into the site:
http://skeleton-yii.local

# Try logging into the administration panel:
http://skeleton-yii.local/admin/
```

## PHPUnit

```
./vendor/bin/phpunit
```

## PHPStan

```
./vendor/bin/phpstan
```

## Contact

If you have any questions, [contact me](https://onviser.com/).