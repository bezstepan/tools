<?php

require_once __DIR__ . '/generateProductCest.php';
require_once __DIR__ . '/generatePurchaseOrderCest.php';
require_once __DIR__ . '/generateThngsCest.php';
require_once __DIR__ . '/codesImageGen.php';

class bulkCreationCest
{
    public function _before(AcceptanceTester $I){
        self::removeDirectory(getcwd().'/codes');
        if (!file_exists(getcwd().'/codes'))
        mkdir(getcwd().'/codes');
    }

    public function creating(AcceptanceTester $I) {
        
        $purchaseOrder = new generatePurchaseOrderCest();
        $product = new generateProductCest();
        $thng = new generateThngsCest();
        $imgGen = new codesImageGen();

        $purchaseOrder->generateMultProductPO($I);

        $product->generateScopedEan8($I);
        $product->generateScopedUpca($I);
        $product->generateScopedEan13($I);
        $product->generateNotScopedEan13($I);

        $thng->generateThngNotExists($I);
        $thng->generateNotEncodedThngs($I);
        $thng->generateNon15Thngs($I);
        $thng->generateThngsAssignedToFactory($I);
        $thng->generateThngsAssignedToAnotherFactory($I);
        $thng->generate24ThngsEncoded($I);
        $thng->generate24ThngsNotEncoded($I);
    }

    private function removeDirectory($dir) {
        if (is_dir($dir)) {
          $objects = scandir($dir);
          foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
              if (filetype($dir."/".$object) == "dir") 
                 rmdir($dir."/".$object); 
              else unlink   ($dir."/".$object);
            }
          }
          reset($objects);
          rmdir($dir);
        }
    }

}


?>
