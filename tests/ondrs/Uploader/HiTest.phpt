<?php


use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';


class HiTest extends Tester\TestCase
{

    /** @var \ondrs\Hi\Hi */
    private $hi;

    /** @var \Mockista\Mock */
    private $curlSender;


    function setUp()
    {
        $this->curlSender = \Mockista\mock('Kdyby\Curl\CurlSender');
        $this->hi = new \ondrs\Hi\Hi(TEMP_DIR, $this->curlSender);
    }


    function tearDown()
    {
        $this->curlSender->assertExpectations();
    }


    function testTo()
    {
        $response = \Mockista\mock('Kdyby\Curl\Response');
        $response->expects('getResponse')
            ->once()
            ->andReturn(file_get_contents(__DIR__ . '/data.json'));

        $this->curlSender->expects('send')
            ->once()
            ->andReturn($response);

        $result1 = $this->hi->to('plšek');
        $result2 = $this->hi->to('plšek');

        Assert::same('Plšku', $result2->vocativ);
        Assert::equal($result1, $result2);
    }


    function testParseJson()
    {
        $parsed = $this->hi->parseJson(file_get_contents(__DIR__ . '/data.json'));
        Assert::type('stdClass', $parsed);

        Assert::exception(function() {
            $this->hi->parseJson('!!');
        }, 'ondrs\Hi\Exception');
    }



}


run(new HiTest());
