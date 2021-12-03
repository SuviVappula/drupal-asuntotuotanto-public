# Asuntotuotanto public drupal

Repository handles all interaction with the customers.

Project is built using [helfi-platform](https://github.com/City-of-Helsinki/drupal-helfi-platform).

## Related repositories
- [Asuntotuotanto](https://github.com/City-of-Helsinki/drupal-asuntotuotanto)
- [Asuntomyynti-react](https://github.com/City-of-Helsinki/asuntomyynti-react)
- [Drupal helfi-platform](https://github.com/City-of-Helsinki/drupal-helfi-platform)

## Environments

Env | Branch | Drush alias | URL
--- | ------ | ----------- | ---
development | * | - | http://asuntotuotanto-public.docker.so/
production | main | @main | TBD

## Requirements

You need to have these applications installed to operate on all environments:

- [Docker](https://github.com/druidfi/guidelines/blob/master/docs/docker.md)
- [Stonehenge](https://github.com/druidfi/stonehenge)
- For the new person: Your SSH public key needs to be added to servers

## Create and start the environment

For the first time (new project):

``
$ make new
``

And following times to create and start the environment:

``
$ make fresh
``

NOTE: Change these according of the state of your project.

## Login to Drupal container

This will log you inside the app container:

```
$ make shell
```
