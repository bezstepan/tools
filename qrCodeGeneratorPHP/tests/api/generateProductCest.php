<?php

require_once __DIR__ . '/createProductCest.php';
require_once __DIR__ . '/generatePurchaseOrderCest.php';

class generateProductCest
{
    public function generateScopedEan8(AcceptanceTester $I) {
        for ( $i = 0; $i < $I->getConfig("ean8"); $i++) {
            self::generateProduct($I, 8);
        }
    }

    public function generateScopedUpca(AcceptanceTester $I) {
        for ( $i = 0; $i < $I->getConfig("upca"); $i++) {
            self::generateProduct($I, 12);
        }
    }

    public function generateScopedEan13(AcceptanceTester $I) {
        for ( $i = 0; $i < $I->getConfig("ean13"); $i++) {
            self::generateProduct($I, 13);
        }
    }

    public function generateNotScopedEan13(AcceptanceTester $I) {
        if ($I->getConfig("productNotAssignedToApp") == 1) {
            self::generateProduct($I, 13, 1);
        }
    }

    private function generateProduct($I, $length, $noScope = 0){

        $imgGen = new codesImageGen();
        $PO = new generatePurchaseOrderCest();
        $createProduct = new createProductCest();

        $product = $createProduct->createProduct($I, $length, $noScope);

        switch ($length) {
            case 8:
                $imgGen->makeBarCodeProduct8(substr($product, 6));
                break;
            case 12:
                $imgGen->makeBarCodeProduct12(substr($product, 2));
                break;
            case 13:
                $imgGen->makeBarCodeProduct13(substr($product, 1));
                break;
        }

        $PO->purchaseOrderForProduct($I, $product);
    }
    
}

?>