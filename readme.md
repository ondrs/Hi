Hi
==============

Czech names and surnames greeting generator API PHP wrapper.
Service is available at the url http://hi.ondraplsek.cz



Instalation
-----

composer.json

    "ondrs/hi": "dev-master"


Create a new Hi instance. You can spacify if you are looking for a name or a surname. The constructor parameter is optional.
So if you are not sure, leave it blank.

    $hi = new Hi(Hi::TYPE_SURNAME);

And get your greeting

    $greeting = $hi->getGreeting('plšek');

You will receive an sdtClass object with 4 properties or a FALSE in the case that greeting generator have not been successful.

    stdClass(4) {
       nominativ => "Plšek" (6)
       vocativ => "Plšku" (6)
       type => "surname" (7)
       sex => "male" (4)
    }

In the application you can get your greeting via vocativ property.

    $greeting->vocativ;