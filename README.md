RedmineApiBundle
================

[![Build Status](https://travis-ci.org/LimetecBiotechnologies/RedmineApiBundle.svg)](https://travis-ci.org/LimetecBiotechnologies/RedmineApiBundle)

This bundle integrate the [Redmine API Wrapper](https://github.com/kbsali/php-redmine-api) into your Symfony Project

## Step1: Install RedmineApiBundle

The preffered way to install this bundle is to rely on composer.

```json
{
    "require": {
        // ...
        "limetecbiotechnologies/redmineapibundle": "~1.0"
    }
}
```

## Step2: Enable the bundle

Finally, enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new LimetecBiotechnologies\RedmineApiBundle\RedmineApiBundle(),
    );
}
```

## Step3: Configure RedmineApiBundle

Add RedmineApiBundle settings in app/config/config.yml:

```yaml
redmine_api:
  clients:
    firstclient:
      token: your-api-token
      url: http://example.org/api/v3/
    secondclient:
      token: your-api-token
      url: http://example.com/api/v3/
```

The first client is defined automatically as your default client.

## Step4: Use the redmine api

you want to use the default client, you can easy getting the client by the "redmine_api" service-id.

```php
$api = $this->get('redmine_api');
$api->getApi('issue')->show($ticket);
```
 
If you want to get one of the other clients, you can getting the specific client by the "redmineapi.client.CLIENT_NAME" service id.

```php
$api = $this->get('redmineapi.client.secondclient');
$api->getApi('issue')->show($ticket);
```
