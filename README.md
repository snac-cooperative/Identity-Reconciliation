# Identity Reconciliation Engine

This is a PHP prototype of the identity reconciliation engine.  The full engine is encapsulated under the reconciliation_engine namespace.  Two sample uses of the engine are provided in `index.php` which provides a web api with the "q" url parameter and `main.php` which uses a hard-coded name to search.

## Installation

The engine requires PHP5, which should be installed by default.  It also requires the php-curl module from the apt-get or yum repositories.  Once downloaded, in the `src/` directory, grab all the required packages using php composer:

    curl -s http://getcomposer.org/installer | php
    php composer.phar install --no-dev

The first line downloads and installs composer.  The second installs the packages required for ElasticSearch.  After these are completed, you can run the main test file with:

    php main.php


## API Documentation

Full API documentation is available [here](http://hott.iath.virginia.edu/reconciliation_docs).

## Elastic Search Requirements

Stages in the Reconciliation Engine that use Elastic Search require the following indices and types:

```
curl -XPUT "localhost:9200/_river/search_name/_meta" -d ' {  
    "type" : "jdbc",
    "jdbc" : {
        "url" : "jdbc:postgresql://localhost:5432/eaccpf",
        "user" : "snac",
        "password" : "snacsnac",
        "sql" : "select n.id, n.cpf_id,c.ark_id,n.original,off.original as official from name n left join cpf c on c.id = n.cpf_id left join name off on c.name_id = off.id",
        "index" : "snac",
        "type" : "search_name",
        "strategy" : "oneshot"
    }
}'

curl -XPUT "localhost:9200/_river/name_and_rels/_meta" -d ' {
    "type" : "jdbc",
    "jdbc" : {
        "url" : "jdbc:postgresql://localhost:5432/eaccpf",
        "user" : "snac",
        "password" : "snacsnac",
        "sql" : "select n.id, n.cpf_id,c.ark_id,n.original,off.original as official, rel.num_relations from name n left join cpf c on c.id = n.cpf_id left join name off on c.name_id = off.id left join (select cpf_id1 as cpf_id, count(*) as num_relations from cpf_relations group by cpf_id1) rel on n.cpf_id = rel.cpf_id;",
        "index" : "snac",
        "type" : "name_and_rels",
        "strategy" : "oneshot"
    }
}'

```
