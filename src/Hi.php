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

    /** @var null|string */
    private $type;

    const TYPE_NAME = 'name';
    const TYPE_SURNAME = 'surname';

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';


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
     * @return bool|string
     */
    public function mr($name)
    {
        return $this->to($name, self::GENDER_MALE);
    }


    /**
     * @param string $name
     * @return bool|string
     */
    public function ms($name)
    {
        return $this->to($name, self::GENDER_FEMALE);
    }


    /**
     * @param string $name
     * @param null|string $gender
     * @return bool|string
     */
    public function to($name, $gender = NULL)
    {
        $url = $this->url . '?name=' . urlencode($name);

        if ($this->type !== NULL) {
            $url .= '&type=' . urlencode($this->type);
        }

        if ($gender !== NULL) {
            $url .= '&gender=' . urlencode($gender);
        }

        $json = $this->fetchUrl($url);

        if ($json->success) {
            return $json->results[0];
        } else {
            return FALSE;
        }

    }


    /**
     * @param string $url
     * @return \stdClass
     * @throws Exception
     */
    private function fetchUrl($url)
    {
        $response = @file_get_contents($url);

        if (!$response) {
            throw new Exception("Cannot fetch URL '$url'");
        }

        $json = @json_decode($response);

        if ($json) {
            return $json;
        } else {
            throw new Exception('Malformed JSON');
        }


    }

}


class Exception extends \Exception
{

}
