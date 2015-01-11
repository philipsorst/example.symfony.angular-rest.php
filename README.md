symfony-angular-rest-example.php
================================

About
-----

This project demonstrates how to build a REST API with the Symfony Framework and how to run an AngularJS Application against it.

If you like this project, please donate. I am not paid for this work. Thank you.

[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=shoxrocks&url=http://sorst.net/github/symfony-angular-rest-example.php&title=Symfony Angular Rest Example&language=&tags=github&category=software)

[![Donate](http://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=W9NAXW8YAZ4D6&item_name=Symfony Angular Rest Example Donation&currency_code=EUR)

Prerequisites
-------------

* [Symfony 2.5 requirements](http://symfony.com/doc/current/reference/requirements.html)
* pdo_sqlite
* [Bower](http://bower.io)

Installation
------------

* Clone the repository and make sure ```web/``` dir is accessible by webserver.
* [Make sure var/cache/, var/data/ and var/logs/ are writeable for the web server](http://symfony.com/doc/current/book/installation.html#checking-symfony-application-configuration-and-setup). If you use Ubuntu and have ACL enabled you can use the ```bin/set-permissions``` script.
* Run ```bin/update-dev``` to run in dev mode or ```bin/install``` to run in prod mode.
* Create the database: Run ```bin/console doctrine:schema:create``` and ```bin/console doctrine:fixtures:load```

Further reading
---------------

* [Symfony Cookbook: How to Authenticate Users with API Key](http://symfony.com/doc/current/cookbook/security/api_key_authentication.html)