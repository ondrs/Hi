<?php

namespace ondrs\Hi;

use Nette\Caching\Cache;
use Nette\Caching\Storages\FileStorage;
use Nette\Utils\FileSystem;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Nette\Utils\Strings;

class Hi
{

    /** @var \Nette\Caching\Cache */
    private $cache;
    
    /** @var SimpleCurl */
    private $simpleCurl;

    /** @var NULL|string */
    private $type;


    const API_URL = 'http://hi.ondraplsek.cz';

    const TYPE_NAME = 'name';
    const TYPE_SURNAME = 'surname';

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';


    /**
     * @param string $cacheDir
     * @param SimpleCurl|NULL $simpleCurl
     */
    public function __construct($cacheDir, SimpleCurl $simpleCurl = NULL)
    {
        FileSystem::createDir($cacheDir);
        
        $this->cache = new Cache(new FileStorage($cacheDir));
        
        $this->simpleCurl = $simpleCurl === NULL
            ? new SimpleCurl
            : $simpleCurl;
    }


    /**
     * @param NULL|string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


    /**
     * @return NULL|string
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
     * @param NULL|string $gender
     * @return bool|string
     */
    public function to($name, $gender = NULL)
    {
        $name = Strings::fixEncoding($name);
        $name = Strings::trim($name);
        $name = Strings::lower($name);

        $url = self::API_URL . '?name=' . urlencode($name);

        if ($this->type !== NULL) {
            $url .= '&type=' . urlencode($this->type);
        }

        if ($gender !== NULL) {
            $url .= '&gender=' . urlencode($gender);
        }

        return $this->cache->load($url, function ($dependencies) use ($url) {

            $data = $this->simpleCurl->get($url);
            $json = self::parseJson($data);

            $result = $json->success ? $json->results[0] : FALSE;

            $this->cache->save($url, $result, $dependencies);

            return $result;
        });
    }


    /**
     * @param string $data
     * @return \stdClass
     * @throws Exception
     */
    public static function parseJson($data)
    {
        try {
            return Json::decode($data);
        } catch (JsonException $e) {
            throw new Exception($e->getMessage());
        }
    }

}
