<?php

namespace Helper;
class CurlDataHelper extends \Codeception\Module
{
    private function getLine($jsonArray, $offerId)
    {
        foreach ($jsonArray['data'] as $key => $value) {
            if ($jsonArray['data'][$key]['id']==$offerId) {
                $line=$key;
            }   
        }
        return $line;
    }

//json helpers

    public function jsonFactory($array)
    {
        $json = json_encode($array, JSON_PRETTY_PRINT);
        return $json;
    }

//header helpers

    public function basicHeader($operatorApiKey)
    {
        $header = array(
            'Content-type: ' . 'application/json',
            'Accept: ' . 'application/json',
            'Authorization: ' . $operatorApiKey,
        );
        return $header;
    }

    
}
