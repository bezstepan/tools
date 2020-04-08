<?php

use Helper\CurlHelper;
use Helper\CurlDataHelper;

class createPurchaseOrderCest
{

    public function createPurchaseOrder(AcceptanceTester $I, $product, $factory = ""){
        $url = $I->getUrl();
        $page = $url . "purchaseOrders";
        $purchaseOrder = self::generatePurchaseOrder(14);
        $factory = $I->getConfig("factory");
        $thngsAmount = $I->getConfig("purchaseOrderAmountOfThngs");

        if ( is_array($product) ) 
            $body = self::getMultBody($purchaseOrder, $factory, $thngsAmount, $product);
        else 
            $body = self::getGeneralBody($purchaseOrder, $factory, $thngsAmount, $product);

        $response = CurlHelper::curlHttpCode(
                        $page, 
                        CurlDataHelper::basicHeader($I->getConfig("operatorApiKey")), 
                        CurlDataHelper::jsonFactory($body));

        $I->assertEquals(201, $response);
        if ( is_array($product) )
            echo "\ncreating purchase order: $purchaseOrder for mult product: $product[0], $product[1], $product[2], $product[3] ";
        else
            echo "\ncreating purchase order: $purchaseOrder for product: $product";
        return $purchaseOrder;
    }

    private function generatePurchaseOrder($lenght) {
        return substr(str_shuffle("0123456789"), 0, $lenght);
    }
    
    private function getGeneralBody($purchaseOrder, $factory, $thngsAmount, $product) {
        $body = array(
            "id" => $purchaseOrder,
            "version" => "1", 
            "status" => "open", 
            "purchaser" => "purchaser", 
            "description" => "test purposes", 
            "type" => "123", 
            "issueDate" => "2019-06-03", 
            "parties" => [
                    [
                        "id" => "gs1:01:996459",
                        "type" => "ship-to"
                    ],
                    [
                        "id" => "$factory",
                        "type" => "ship-from"
                    ],
                    [
                        "id" => "gs1:008:999997",
                        "type" => "supplier"
                    ],
                ], 
            "lines" => [
                    [
                      "id" => "00001",
                      "quantity" => $thngsAmount,
                      "exportDate" => "2019-06-02",
                      "deliveryDate" => "2019-06-09",
                      "product" => "gs1:01:" . (string) $product
                    ],
              ],
            "tags" => [
                  "tag1"
                ]
        );
        return $body;
    }

    private function getMultBody($purchaseOrder, $factory, $thngsAmount, $product) {
        $body = array(
            "id" => $purchaseOrder,
            "version" => "1", 
            "status" => "open", 
            "purchaser" => "purchaser", 
            "description" => "test purposes", 
            "type" => "123", 
            "issueDate" => "2019-06-03", 
            "parties" => [
                    [
                        "id" => "gs1:01:996459",
                        "type" => "ship-to"
                    ],
                    [
                        "id" => "$factory",
                        "type" => "ship-from"
                    ],
                    [
                        "id" => "gs1:008:999997",
                        "type" => "supplier"
                    ],
                ], 
            "lines" => [
                    [
                      "id" => "00001",
                      "quantity" => $thngsAmount,
                      "exportDate" => "2019-06-02",
                      "deliveryDate" => "2019-06-09",
                      "product" => "gs1:01:" . (string) $product[0]
                    ],
                    [
                        "id" => "00002",
                        "quantity" => $thngsAmount,
                        "exportDate" => "2019-06-09",
                        "deliveryDate" => "2019-06-10",
                        "product" => "gs1:01:" . (string) $product[1]
                    ],
                    [
                        "id" => "00003",
                        "quantity" => $thngsAmount,
                        "exportDate" => "2019-06-09",
                        "deliveryDate" => "2019-06-10",
                        "product" => "gs1:01:" . (string) $product[2]
                    ],
                    [
                        "id" => "00004",
                        "quantity" => $thngsAmount,
                        "exportDate" => "2019-06-09",
                        "deliveryDate" => "2019-06-10",
                        "product" => "gs1:01:" . (string) $product[3]
                    ],
              ],
            "tags" => [
                  "tag1"
                ]
        );
        return $body;
    }
}