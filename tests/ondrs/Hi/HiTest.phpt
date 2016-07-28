<?php

namespace Test\ondrs\Hi;

use ondrs\Hi\Hi;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

class HiTest extends TestCase
{

    function tearDown()
    {
        \Mockery::close();
    }


    function testTo()
    {
        $simpleCurl = \Mockery::mock('ondrs\Hi\SimpleCurl')
            ->shouldReceive('get')
            ->andReturn(file_get_contents(__DIR__ . '/data.json'))
            ->getMock();

        $iStorage = \Mockery::mock('Nette\Caching\IStorage')
            ->shouldReceive('read')
            ->shouldReceive('lock')
            ->shouldReceive('remove')
            ->shouldReceive('write')
            ->shouldReceive('read')
            ->getMock();

        $hi = new Hi($iStorage, $simpleCurl);


        $result1 = $hi->to('plšek');
        $result2 = $hi->to('plšek');
        $result3 = $hi->to('plšek');
        $result4 = $hi->to('plšek');

        Assert::same('Plšku', $result2->vocativ);
        Assert::equal($result1, $result2);
        Assert::equal($result2, $result3);
        Assert::equal($result3, $result4);
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


run(new HiTest());
