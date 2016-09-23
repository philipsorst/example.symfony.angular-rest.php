example.symfony.angular-rest.php
================================

About
-----

This project demonstrates how to build a REST API with the Symfony Framework and how to run an AngularJS Application against it.

If you like this project, please donate. Thank you.

[![Build Status](https://travis-ci.org/philipsorst/example.symfony.angular-rest.php.svg?branch=master)](https://travis-ci.org/philipsorst/example.symfony.angular-rest.php)
[![Coverage Status](https://coveralls.io/repos/github/philipsorst/example.symfony.angular-rest.php/badge.svg)](https://coveralls.io/github/philipsorst/example.symfony.angular-rest.php)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=W9NAXW8YAZ4D6&item_name=example.symfony.angular-rest.php%20Donation&currency_code=EUR) 

Technologies
------------

* Symfony 3.1.*
* Doctrine
* FosUserBundle
* FosRestBundle ^2.1
* BraincraftedBootstrapBundle
* Angular 1.5

Prerequisites
-------------

* [Symfony 3.1 requirements](https://symfony.com/doc/3.1/reference/requirements.html)
* pdo_sqlite

Installation
------------

* Clone the repository and make sure ```web/``` dir is accessible by webserver.
* Run ```bin/update-dev``` to run in dev mode or ```bin/install``` to run in prod mode.
* Create the database: Run ```bin/console doctrine:schema:create``` and ```bin/console doctrine:fixtures:load```
* [Make sure var/cache/, var/data/ and var/logs/ are writeable for the web server](https://symfony.com/doc/current/setup/file_permissions.html). If you use Ubuntu and have ACL enabled you can use the ```bin/set-permissions``` script.

Further reading
---------------

* [Symfony Cookbook: How to Authenticate Users with API Key](http://symfony.com/doc/current/cookbook/security/api_key_authentication.html)
