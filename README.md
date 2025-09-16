Hi
==============
[![Total Downloads](https://poser.pugx.org/ondrs/hi/downloads)](https://packagist.org/packages/ondrs/hi)
[![CircleCI](https://circleci.com/gh/ondrs/Hi/tree/master.svg?style=svg)](https://circleci.com/gh/ondrs/Hi/tree/master)
[![Latest Stable Version](https://poser.pugx.org/ondrs/hi/v/stable)](https://packagist.org/packages/ondrs/hi)

Czech names and surnames greeting generator API PHP wrapper.
Service is available at the url https://hi.ondraplsek.cz



Installation
-----

composer.json

    "ondrs/hi": "1.0.2"

Usage
-----

Create a new Hi instance and specify a caching storage where the downloaded content will be cached - you don't want to call the API for the same name again and again.
Additionally, you can set if you are looking for a name or a surname.

    $hi = new ondrs\Hi\Hi(new Nette\Caching\Storages\FileStorage('path/to/cache/dir'));
    $hi->setType(ondrs\Hi\Hi::TYPE_SURNAME)

Call appropriate method (mr() or ms()) according to assumed gender.
If you are not sure about the gender, call the method to().

    $greeting = $hi->mr('plšek');
    $greeting = $hi->to('plšek');

You will receive an sdtClass object with 4 properties or a FALSE in the case that greeting generator have not been successful.

    stdClass(4) {
       nominativ => "Plšek" (6)
       vocativ => "Plšku" (6)
       type => "surname" (7)
       gender => "male" (4)
    }

In the application you can get your greeting via vocativ property.

    $greeting->vocativ;
