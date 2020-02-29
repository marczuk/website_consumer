# Webiste consumer application
==============================

It is a test CLI application to consume a website videx and get product list

Technologies:
PHP / Symfony 5.0.4 / PHPUnit

Requirements
------------

  * PHP 7.2.5 or higher;
  * and the [usual Symfony application requirements][1].
  
Usage
-----
To run application: 
```bash
$ composer install
$ php bin/console app:consume-videx-website
```

Tests
-----

Execute this command to run tests:

```bash
$ cd my_project/
$ ./bin/phpunit
```


[1]: https://symfony.com/doc/current/reference/requirements.html