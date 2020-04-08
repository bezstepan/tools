<?php

require_once __DIR__ . '/createProductCest.php';
require_once __DIR__ . '/createPurchaseOrderCest.php';
require_once __DIR__ . '/codesImageGen.php';

class generatePurchaseOrderCest
{
    public function generateMultProductPO(AcceptanceTester $I) {
        
        if ( $I->getConfig("purchaseOrderForMultProducts") != 1 ) 
            return;

        $imgGen = new codesImageGen();
        $products = array();
        $createPurchaseOrder = new createPurchaseOrderCest();

        for ( $i = 0; $i < 2; $i++) {
            $createProduct = new createProductCest();
            $product = $createProduct->createProduct($I, 12);
            $this->productTemp = substr($product, 2);
            $imgGen->makeBarCodeProduct12($this->productTemp);
            array_push($products, $product);
        }
        for ( $i = 0; $i < 2; $i++) {
            $createProduct = new createProductCest();
            $product = $createProduct->createProduct($I, 13);
            $this->productTemp = substr($product, 1);
            $imgGen->makeBarCodeProduct13($this->productTemp);
            array_push($products, $product);
        }
        $purchaseOrder = $createPurchaseOrder->createPurchaseOrder($I, $products);
        $imgGen->createPurchaseWithMultProducts($purchaseOrder, $products);
    }

    public function purchaseOrderForProduct($I, $product){

        $imgGen = new codesImageGen();
        $createPurchaseOrder = new createPurchaseOrderCest();

        $purchaseOrder = $createPurchaseOrder->createPurchaseOrder($I, $product);
        $imgGen->makeQrCodePurchaseOrder($purchaseOrder, $product);
    }
    
}

?>