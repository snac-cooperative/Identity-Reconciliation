# Identity Reconciliation Engine

This is a PHP prototype of the identity reconciliation engine.  The full engine is encapsulated under the reconciliation_engine namespace.  Two sample uses of the engine are provided in `index.php` which provides a web api with the "q" url parameter and `main.php` which uses a hard-coded name to search.

## Installation

The engine requires PHP5, which should be installed by default.  It also requires the php-curl module from the apt-get or yum repositories.  Once downloaded, in the `src/` directory, grab all the required packages using php composer:

    curl -s http://getcomposer.org/installer | php
    php composer.phar install --no-dev

The first line downloads and installs composer.  The second installs the packages required for ElasticSearch.  After these are completed, you can run the main test file with:

    php main.php

## Documentation

Full API documentation is available [here](http://hott.iath.virginia.edu/reconciliation_docs).

