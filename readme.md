Hi
==============

Czech names and surnames greeting generator API PHP wrapper.
Service is available at the url http://hi.ondraplsek.cz



Instalation
-----

composer.json

    "ondrs/hi": "dev-master"


Create a new Hi instance. You can specify if you are looking for a name or a surname. The constructor parameter is optional.

    $hi = new Hi(Hi::TYPE_SURNAME);

Call appropriate method (mr() or ms()) according to assumed gender.
If you are not sure about the gender, call the method to() on your instance.

    $greeting = $hi->mr('plšek');

You will receive an sdtClass object with 4 properties or a FALSE in the case that greeting generator have not been successful.

    stdClass(4) {
       nominativ => "Plšek" (6)
       vocativ => "Plšku" (6)
       type => "surname" (7)
       gender => "male" (4)
    }

In the application you can get your greeting via vocativ property.

    $greeting->vocativ;