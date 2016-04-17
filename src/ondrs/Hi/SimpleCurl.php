<?php

namespace ondrs\Hi;

class SimpleCurl
{
    
    private $opts = [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => 0,
    ];

    /**
     * @param string $url
     * @return string
     * @throws Exception
     */
    public function get($url)
    {
        $curl = curl_init($url);
        
        curl_setopt_array($curl, $this->opts);

        $resp = curl_exec($curl);

        if (!$resp) {
            throw new Exception(curl_error($curl), curl_errno($curl));
        }

        curl_close($curl);
        
        return $resp;
    }

}
