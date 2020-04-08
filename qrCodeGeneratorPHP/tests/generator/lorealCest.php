<?php

require getcwd().'/vendor/autoload.php';
use Endroid\QrCode\QrCode;
use Helper\CurlHelper;
use Helper\CurlDataHelper;


class generatorCest
{
    public $url = "";
    public $case = "03337875728492";
    public $bundle = "03337875728478";
    public function _before(AcceptanceTester $I){
        self::removeDirectory(getcwd().'/codes');
        if (!file_exists(getcwd().'/codes'))
        mkdir(getcwd().'/codes');
    }

    public function creating(AcceptanceTester $I) {

        $this->url = $I->getUrl();

        //generate and encode thngs
        for ( $i = 0; $i < $I->getConfig("thngs"); $i++) {
            self::thngs($I);
        }
        for ( $i = 0; $i < $I->getConfig("sscc"); $i++){
            self::ssccGen($I);
        }
        for ( $i = 0; $i < $I->getConfig("sgtinCase"); $i++){
            self::sgtinGen($I, $this->case);
        }
        for ( $i = 0; $i < $I->getConfig("sgtinBundle"); $i++){
            self::sgtinGen($I, $this->bundle);
        }

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

    private function thngs(AcceptanceTester $I){
        $page = $this->url . "thngs?withScopes=true&project=" . $I->getConfig("projectId");
        $thng = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);
        $product = $I->getConfig("product");
        $body = array(
            "identifiers" => ["gs1:21" => "$thng"], 
            "customFields" => [
                "test" => "test"
                ], 
            "name" => "$thng",
            "tags" => ["Loreal", "testing"],
            "product" => "$product"
        );
        
        //sending data to backend
        $ch = CurlHelper::curlForThng(
                        $page, 
                        CurlDataHelper::basicHeader($I->getConfig("operatorApiKey")), 
                        CurlDataHelper::jsonFactory($body));
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        //trimming data for encoding
        preg_match_all('("id":(.[0-9a-zA-Z]{24}))', $response, $matches);
        $thngId = trim($matches[1][0], '"');

        $I->assertEquals(201, $httpCode);
        echo "\ncreating Thng: $thng";
        
        //adding redirections
        $redirectionUrl = "https://tn.gg/redirections";
        $body = array(
            "defaultRedirectUrl" => "https://www.laroche-posay.fr",
            "evrythngId" => "$thngId",
            "type" => "thng"
        );
        $response = CurlHelper::curlResponse(
            $redirectionUrl, 
            CurlDataHelper::basicHeader($I->getConfig("operatorApiKey")), 
            CurlDataHelper::jsonFactory($body));
        echo "\nadding redirection to $thng";

        self::makeQrCodeThng($thng, $product);
    }

    private function ssccGen(AcceptanceTester $I) {

        $sscc = $I->generateEAN128(18);
        self::makeBarCodeSscc($sscc);

    }

    private function sgtinGen(AcceptanceTester $I, $variant) {
        $sgtinTemp = "01" . $variant . "21";
        $sgtin = $I->generateEAN128Gtin($sgtinTemp);
        self::makeBarCodeSgtin($sgtin, $variant);

    }

    private function makeQrCodeThng($thng, $product)
    {
        $qrCode = new QrCode("https://m.lrp.one/01/03337875696548/21/$thng");
        $qrCode->setSize('150');

        $qrCode->writeFile(getcwd()."/codes/$thng.png");

    }

    private function makeBarCodeSscc($data)
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        file_put_contents("codes/Sscc-$data.jpg", $generator->getBarcode($data, $generator::TYPE_CODE_128));
    }

    private function makeBarCodeSgtin($data, $variant)
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        if ($variant == $this->bundle)
            file_put_contents("codes/Sgtin-bundle-$data.jpg", $generator->getBarcode($data, $generator::TYPE_CODE_128));
        else
        file_put_contents("codes/Sgtin-case-$data.jpg", $generator->getBarcode($data, $generator::TYPE_CODE_128));
    }
}


?>
