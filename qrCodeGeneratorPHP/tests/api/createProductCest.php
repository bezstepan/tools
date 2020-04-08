<?php

use Helper\CurlHelper;
use Helper\CurlDataHelper;

class createProductCest
{
    private $colors = array("Black6 N8 white16 123456789012345678901234567890", "White", "Red");
    private $sizes = array("Size5 N7 Size14 123456789012345678901234567890", "M", "L");


    public function createProduct(AcceptanceTester $I, $productLenght = 13, $noScope = 0){
        $url = $I->getUrl();
        if ($noScope == 0) 
            $page = $url . "products?withScopes=true&project=" . $I->getConfig("projectId");
        else
            $page = $url . "products?withScopes=true";
        //$product = $I->generateGtin($productLenght);
        $product = "1231231231";
        $body = array(
            "identifiers" => ["gs1:01" => $product],
            "customFields" => [
                "test" => "purposes",
                "size" => $this->sizes[mt_rand(0,2)],
                "colorDescription" => $this->colors[mt_rand(0,2)]
            ],
            "name" => "test: $product");

        $response = CurlHelper::curlHttpCode(
                        $page, 
                        CurlDataHelper::basicHeader($I->getConfig("operatorApiKey")), 
                        CurlDataHelper::jsonFactory($body));

        $I->assertEquals(201, $response);
        echo "\ncreating product: $product";
        return $product;
    }

}