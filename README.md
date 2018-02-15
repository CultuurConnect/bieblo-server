# Bieblo Server

API server for fetching data from Cultuurconnect, storing it and providing it to the Bieblo client. 

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and 
testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

You will need an API key for bibliotheek.be for using the API. 
PHP >=5.5.9 with MySQL integration should be installed.

### Installing

Install composer and bower

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
npm install -g bower
```

Install project dependencies using Composer
```bash
composer install
```

Add database config & root api token

```bash
#app/config/parameters.yml

database_host: localhost
database_port: null
database_name: %YOUR_DB_NAME%
database_user: %YOUR_DB_USER%
database_password: %YOUR_DB_PASSWORD%

app.cc.root.authorization : %YOUR_API_KEY% 
```

Setup default database structure

```bash
# In project root execute
./reset-db.sh
```

Start developer server

```
php bin/console server:run
```

## Deployment

Setup server with NGINX configuration, for more information visit [Symfony documentation server configuration](http://symfony.com/doc/current/setup/web_server_configuration.html)

```
server {
    server_name domain.tld www.domain.tld;
    root /var/www/project/web;

    location / {
        # try to serve file directly, fallback to app.php
        try_files $uri /app.php$is_args$args;
    }

    # PROD
    location ~ ^/app\.php(/|$) {
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        # When you are using symlinks to link the document root to the
        # current version of your application, you should pass the real
        # application path instead of the path to the symlink to PHP
        # FPM.
        # Otherwise, PHP's OPcache may not properly detect changes to
        # your PHP files (see https://github.com/zendtech/ZendOptimizerPlus/issues/126
        # for more information).
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        # Prevents URIs that include the front controller. This will 404:
        # http://domain.tld/app.php/some-path
        # Remove the internal directive to allow URIs like this
        internal;
    }

    # return 404 for all other php files not matching the front controller
    # this prevents access to other php files you don't want to be accessible.
    location ~ \.php$ {
      return 404;
    }

    error_log /var/log/nginx/project_error.log;
    access_log /var/log/nginx/project_access.log;
}

```

## Built With
* [Symfony 3](https://github.com/symfony/symfony) - Symfony framework
* [Composer](https://github.com/composer/composer) - Dependency Management
* [Guzzle](https://github.com/guzzle/guzzle) - an extensible PHP HTTP client
* [StofDoctrineExtensionsBundle](https://github.com/stof/StofDoctrineExtensionsBundle) -  integration for DoctrineExtensions
* [DoctrineExtensions](https://github.com/Atlantic18/DoctrineExtensions) - Doctrine2 behavioral extensions

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/cultuurconnect/bieblo-server/tags). 

## Authors

* *Jonas Verhaert* - *Initial work* - [jVerhaert](https://github.com/jVerhaert)

See also the list of [contributors](https://github.com/cultuurconnect/bieblo-server/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
