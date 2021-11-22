<?php

namespace ondrs\Hi;

use Nette\Caching\Cache;

use Nette\Caching\Storage;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Nette\Utils\Strings;

class Hi
{

    /** @var Cache */
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


    public function __construct(Storage $storage, SimpleCurl $simpleCurl = NULL)
    {
        $this->cache = new Cache($storage, str_replace('\\', '.', __CLASS__));

        $this->simpleCurl = $simpleCurl ?? new SimpleCurl;
    }


    /**
     * @param NULL|string $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }


    /**
     * @return NULL|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }


    /**
     * @param string $name
     * @return bool|\stdClass
     */
    public function mr(string $name)
    {
        return $this->to($name, self::GENDER_MALE);
    }


    /**
     * @param string $name
     * @return bool|\stdClass
     */
    public function ms(string $name)
    {
        return $this->to($name, self::GENDER_FEMALE);
    }


    /**
     * @return bool|\stdClass
     * @throws \Throwable
     */
    public function to(string $name, ?string $gender = NULL)
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

        return $this->cache->load($url, function ($dependencies) use ($url, $name) {

            $data = $this->simpleCurl->get($url);
            $json = self::parseJson($data);
            $result = FALSE;

            if ($json->success) {
                $result = $json->results[0];

                foreach ($json->results as $value) {
                    if (Strings::lower($value->nominativ) === $name) {
                        $result = $value;
                        break;
                    }
                }
            }

            $this->cache->save($url, $result, $dependencies);

            return $result;
        });
    }


    /**
     * @throws Exception
     */
    public static function parseJson(string $data): \stdClass
    {
        try {
            return Json::decode($data);
        } catch (JsonException $e) {
            throw new Exception($e->getMessage());
        }
    }

}
