[![Latest Stable Version](http://img.shields.io/packagist/v/pytonicis/seat-corp-mining-tax.svg?style=flat-square)]()
![](https://img.shields.io/badge/SeAT-5.0.x-blueviolet?style=flat-square)
![](https://img.shields.io/badge/License-GPLv3-blue.svg)

# Seat Corporation Mining Tax

This plugin provides an extension to calculate mining taxes within the corporation. It simplifies the handling of taxes and gives an overview of mined ores of each member. Some additional features will very helpful to control the mining part, like Corporation Mining Events, Mining Statistics, Corporation Moon's Statistics,..


## Installation Guide

### For non-Docker
```php
sudo -H -u www-data bash -c 'php artisan down'
sudo -H -u www-data bash -c 'composer require pyTonicis/seat-corp-mining-tax'
sudo -H -u www-data bash -c 'php artisan vendor:publish --force --all'
sudo -H -u www-data bash -c 'php artisan migrate'
sudo -H -u www-data bash -c 'php artisan seat:cache:clear'
sudo -H -u www-data bash -c 'php artisan config:cache'
sudo -H -u www-data bash -c 'php artisan route:cache'
sudo -H -u www-data bash -c 'php artisan up'
```
### For Docker

```
Edit your `.env` file,locate the line `SEAT_PLUGINS` and append `pyTonicis/seat-corp-mining-tax`
at the end.
```

Then , run `docker-compose up -d` to take effect.

### For non-Docker Update plugin

```php
sudo -H -u www-data bash -c 'php artisan down'
sudo -H -u www-data bash -c 'composer update pyTonicis/seat-corp-mining-tax'
sudo -H -u www-data bash -c 'php artisan migrate'
sudo -H -u www-data bash -c 'php artisan seat:cache:clear'
sudo -H -u www-data bash -c 'php artisan config:cache'
sudo -H -u www-data bash -c 'php artisan route:cache'
sudo -H -u www-data bash -c 'php artisan up'
```

### Plugin Setup
- Open Settings Page and select your Corporation Name (at global Settings)
- Set a valid Character Name in field "Contract Issuer" (at Contract Settings)


All other settings such as tax rate can be set as desired. For best tax result, 
u should set "Ore Valuation Price" to "Mineral Price". The Prices for minerals  are inaccurate.

If you want to use EvE Janice as a Price provider, you need to apply for a valid API Key and enter it in the field "Price Provider API Key" and select "Eve Janice as price provider.


### Fill Database with mining data

If you want to fetch some data from past months, you can generate tax data at console by hand eg.:

```php
sudo -H -u www-data bash -c 'php artisan tax:update 2023 10
```

### Permissions

There are three different types of permissions you can set for your Members. Access rights are to set in Access Manager of Seat. (Seat->Settings->Access Manager) 

#### Member

Allow access to overview and reprocessing tool

#### Manager

Allow access to manage tax contracts and tax calculator

#### Admin

Allows full access

### How to use the plugin?

Please read the **MANUAL.md** for more information about configuration and using the plugin.

If you need help, feel free to contact me via Discord: ```smasherjobs```

### Donations

If you would like to support my project, feel free to donate isk or plex to ```Smasher Jobs``` (in-game).

## Screenshots

**Overview (Dashboard)**

![Overview](https://i.imgur.com/sCy80pL.jpeg)

**Reprocessing**

![Refine](https://i.imgur.com/55wWf94.png)

**Corporation Mining Tax**

![Tax](https://i.imgur.com/ilu6CYP.png)

**Corporation Moon Minings** (Moons owned by Corporation)

![enter image description here](https://i.imgur.com/CBGBZ7a.png)