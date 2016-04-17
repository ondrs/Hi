<?php

namespace Test\ondrs\Hi;

use ondrs\Hi\SimpleCurl;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

class SimpleCurlTest extends TestCase
{

    function testGetReal()
    {
        $simpleCurl = new SimpleCurl;
        $response = $simpleCurl->get('https://www.google.com/');

        Assert::type('string', $response);
    }


    function testGetNOTReal()
    {
        $simpleCurl = new SimpleCurl;

        Assert::exception(function() use($simpleCurl) {
            $response = $simpleCurl->get('i-do-not-exists');
        }, 'ondrs\Hi\Exception');
    }

}


run(new SimpleCurlTest());
