<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ondrs
 * Date: 13.10.13
 * Time: 18:53
 * To change this template use File | Settings | File Templates.
 */

namespace ondrs\Hi;


class Hi 
{

    /** @var string */
    private $url = 'http://hi.ondraplsek.cz';

    /** @var null|string  */
    private $type;


    /**
     * @param null|string $type
     */
    public function __construct($type = NULL)
    {
        $this->type = $type;
    }


    /**
     * @param null|string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


    /**
     * @return null|string
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * @param string $name
     * @param string $sex
     * @return bool|\stdClass
     */
    public function getGreeting($name, $sex = NULL)
    {
        $url = $this->url . '?name=' . urlencode($name);

        if($this->type !== NULL)
            $url .= '&type=' . urlencode($this->type);

        if($sex === NULL)
            $sex = $this->detectSex($name);

        if($sex)
            $url .= '&sex=' . urlencode($sex);

        $json = $this->fetchUrl($url);

        if($json->success)
            return $json->results[0];
        else
            return FALSE;
    }


    /**
     * @param $name
     * @return bool|string
     * @throws Exception
     */
    public function detectSex($name)
    {
        $url = $this->url . '?name=' . urlencode($name);

        if($this->type !== NULL)
            $url .= '&type=' . urlencode($this->type);

        $json = $this->fetchUrl($url);

        if($json->success)
            return $json->results[0]->sex;
        else
            return FALSE;
    }


    /**
     * @param string $url
     * @return \stdClass
     * @throws Exception
     */
    private function fetchUrl($url)
    {
        $response = @file_get_contents($url);

        if(!$response)
            throw new Exception("Cannot fetch URL '$url'");

        $json = @json_decode($response);

        if($json)
            return $json;
        else
            throw new Exception('Malformed JSON');

    }

}


class Exception extends \Exception
{

}