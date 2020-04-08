<?php

require getcwd().'/vendor/autoload.php';
use Endroid\QrCode\QrCode;

class codesImageGen {

    public function makeBarCodeProduct13($data)
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        file_put_contents("codes/product-EAN13-$data.jpg", $generator->getBarcode($data, $generator::TYPE_EAN_13));
        echo "\nGenerating barcode for EAN13 product = $data";
    }

    public function makeBarCodeProduct12($data)
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        file_put_contents("codes/product-UPCA-$data.jpg", $generator->getBarcode($data, $generator::TYPE_UPC_A));
        echo "\nGenerating barcode for UPCA product = $data";
    }

    public function makeBarCodeProduct8($data)
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        file_put_contents("codes/product-EAN8-$data.jpg", $generator->getBarcode($data, $generator::TYPE_EAN_8));
        echo "\nGenerating barcode for EAN8 product = $data";
    }

    public function makeQrCodePurchaseOrder($data, $product, $factory = "")
    {
        $qrCode = new QrCode($data);
        $qrCode->setSize('50');
        if ( $factory == "" )
            $qrCode->writeFile(getcwd()."/codes/po-$data-pr-$product.png");
        else 
            $qrCode->writeFile(getcwd()."/codes/po-$data-pr-$product-$factory.png");
        echo "\nGenerating QrCode for purchase order = $data assosiated with product = $product";
    }

    public function createPurchaseWithMultProducts($data, $products)
    {
        $qrCode = new QrCode($data);
        $qrCode->setSize('50');
        $product1 = $products[0];
        $product2 = $products[1];
        $product3 = $products[2];
        $product4 = $products[3];
        $qrCode->writeFile(getcwd()."/codes/po-$data-pr-$product1-$product2-$product3-$product4.png");
        echo "\nGenerating QrCode for purchase order = $data assosiated with product = $product1";
    }

    public function makeNotExistThng($thng) {
        $qrCode = new QrCode("https://j.tn.gg/$thng");
        $qrCode->setSize('150');

        $qrCode->writeFile(getcwd()."/codes/thng-non-existing-$thng.png");
        echo "\nGenerating Not existing thng = $thng";
    }

    public function makeNotEncodedThng($thng, $length, $factory) {
        $qrCode = new QrCode("https://j.tn.gg/$thng");
        $qrCode->setSize('150');

        $qrCode->writeFile(getcwd()."/codes/thng-notEncoded-$factory-$length-$thng.png");
        echo "\nGenerating QrCode for not encoded thng $length = $thng";
    }

    public function makeNon15Thngs($thng, $length, $factory) {
        $qrCode = new QrCode("https://j.tn.gg/$thng");
        $qrCode->setSize('150');

        $qrCode->writeFile(getcwd()."/codes/thng-not-15-encoded-$factory-$thng.png");
        echo "\nGenerating QrCode for $length chars encoded thng = $thng";
    }

    public function makeThngsForFactory($thng, $length, $factory) {
        $qrCode = new QrCode("https://j.tn.gg/$thng");
        $qrCode->setSize('150');

        $qrCode->writeFile(getcwd()."/codes/thng-encoded-$factory-$length-$thng.png");
        echo "\nGenerating QrCode for encoded thng $length = $thng";
    }
}