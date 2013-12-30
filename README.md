
PhpRedmonBundle
===============

Redis monitoring Bundle

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/ringoteam/PhpRedmonBundle/badges/quality-score.png?s=e2745947ff9b9d71bbb53e7f8f744c1250c06b9e)](https://scrutinizer-ci.com/g/ringoteam/PhpRedmonBundle/)


## Installation 

### Using composer
```json
{
    "require": {
        "ringoteam/phpredmon-bundle": "dev-master"
    }
}
```
### Dependencies

* knplabs/knp-gaufrette-bundle
* predis/predis

## Configuration

First, define a gaufrette adapter named "phpredmon" like this (to store data)

```yaml

knp_gaufrette:
    adapters:
        phpredmon:
            local:
                directory: "%kernel.root_dir%/Resources/phpredmon/datas"
                create: true
    filesystems:
        phpredmon:
            adapter:    phpredmon
            alias:      phpredmon_filesystem
```

Then you can define log retention :

```yaml

ringo_php_redmon:
    log:
        days: 30
```

## Usage
TODO
## Log command
TODO



