<?php

namespace Test\ondrs\Hi;

use ondrs\Hi\Hi;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

class HiRelevanceTest extends TestCase
{

    function tearDown()
    {
        \Mockery::close();
    }


    function testTo()
    {
        $simpleCurl = \Mockery::mock('ondrs\Hi\SimpleCurl')
            ->shouldReceive('get')
            ->andReturn(file_get_contents(__DIR__ . '/data.relevance.json'))
            ->getMock();

        $iStorage = \Mockery::mock('Nette\Caching\IStorage')
            ->shouldReceive('read')
            ->shouldReceive('lock')
            ->shouldReceive('remove')
            ->shouldReceive('write')
            ->shouldReceive('read')
            ->getMock();

        $hi = new Hi($iStorage, $simpleCurl);


        $result = $hi->to('věra');

        Assert::same('Věro', $result->vocativ);
    }


    function testParseJson()
    {
        $parsed = Hi::parseJson(file_get_contents(__DIR__ . '/data.json'));
        Assert::type('stdClass', $parsed);

        Assert::exception(function () {
            Hi::parseJson('!!');
        }, 'ondrs\Hi\Exception');
    }


}


run(new HiRelevanceTest());
