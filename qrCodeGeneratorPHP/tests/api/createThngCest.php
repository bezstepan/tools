<?php

use Helper\CurlHelper;
use Helper\CurlDataHelper;

class createThngCest
{
    private $key = "";

    public function createThng(AcceptanceTester $I, $encode = 1, $lenght = 15, $factory = ""){
        $url = $I->getUrl();
        $projectId = $I->getConfig("projectId");
        $page = $url . "thngs?withScopes=true&project=" . $projectId;
        $thng = self::generateThng($lenght);
        $this->key = $I->getConfig("trustedApiKey");
        $body = array(
            "identifiers" => ["gs1:21" => $thng], 
            "customFields" => [
                "test" => "purposes",
                "factory" => "$factory"
            ], 
            "tags" => [
                "$factory",
                "action:encodings"
            ],
            "name" => "testThng: ".$thng
        );
        
        $ch = CurlHelper::curlForThng(
                        $page, 
                        CurlDataHelper::basicHeader($I->getConfig("operatorApiKey")), 
                        CurlDataHelper::jsonFactory($body));
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        preg_match_all('("id":(.[0-9a-zA-Z]{24}))', $response, $matches);
        $thngId = trim($matches[1][0], '"');
        codecept_debug($thngId);

        $I->assertEquals(201, $httpCode);
        echo "\ncreating Thng: $thng";

        if( $encode != 0 )
            self::encodeThng($I, $thngId, $thng);

        return $thng;
    }

    private function generateThng($lenght){
        return substr(str_shuffle("xABCDEFGHIJKLMNOPQRSTUVWYZ0123456789"), 0, $lenght);
    }

    private function encodeThng($I, $thngId, $thng){
        $url = $I->getUrl();
        $page = $url . "thngs/$thngId/actions/encodings";
        $body = array(
            "type" => "encodings", 
            "location" => [
                            "position" => [
                                "type" => "Point",
                                "coordinates" => [13.4105300,52.5243700]
                            ]
                        ], 
            "locationSource" => "geoIp",
            "tags" => ["mobileTest", "encodings"]);
        $response = CurlHelper::curlResponse(
            $page, 
            CurlDataHelper::basicHeader($this->key), 
            CurlDataHelper::jsonFactory($body));
        
        echo "\nencoding Thng: $thng";
    }

}