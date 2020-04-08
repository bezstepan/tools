<?php

require_once __DIR__ . '/createThngCest.php';

class generateThngsCest
{
    public $encoded = 1;
    public $notEncoded = 0;
    public $length = 15;
    public $length14 = 14;
    public $length16 = 16;
    public $length24 = 24;
    public $factory = "";

    public function generateThngNotExists(AcceptanceTester $I) {
        if ($I->getConfig("thngNotFound") == 1) {
            self::generateThng($I, "notExists");
        }
    }

    public function generateNotEncodedThngs(AcceptanceTester $I) {
        for ( $i = 0; $i < $I->getConfig("notEncodedThngs"); $i++) {
            $this->factory = $I->getConfig("factory");
            self::generateThng($I, "notEncodedThngs");
        }
    }

    public function generateNon15Thngs(AcceptanceTester $I) {
        if ( $I->getConfig("not15thngs") == 1 ) {
            $this->factory = $I->getConfig("factory");
            self::generateThng($I, "non15");
        }
    }

    public function generateThngsAssignedToFactory(AcceptanceTester $I) {
        $this->factory = $I->getConfig("factory");
        for ( $i = 0; $i < $I->getConfig("thngsAssignedToFactory"); $i++)
            self::generateThng($I, "thngsAssignedToFactory");
    }

    public function generateThngsAssignedToAnotherFactory(AcceptanceTester $I) {
        $this->factory = $I->getConfig("dummyFactory");
        for ( $i = 0; $i < $I->getConfig("thngsAssignedToAnotherFactory"); $i++)
            self::generateThng($I, "thngsAssignedToAnotherFactory");
    }

    public function generate24ThngsEncoded(AcceptanceTester $I) {
        $this->factory = $I->getConfig("factory");
        for ( $i = 0; $i < $I->getConfig("24ThngsEncoded"); $i++)
            self::generateThng($I, "24ThngsEncoded");
    }

    public function generate24ThngsNotEncoded(AcceptanceTester $I) {
        $this->factory = $I->getConfig("factory");
        for ( $i = 0; $i < $I->getConfig("24ThngsNotEncoded"); $i++)
            self::generateThng($I, "24ThngsNotEncoded");
    }

    private function generateThng($I, $type){

        $imgGen = new codesImageGen();
        $createThng = new createThngCest();

        switch ($type) {
            case "notExists":
                $thng="AAAAABBBBBCCCCC";
                $imgGen->makeNotExistThng($thng);
                break;
            case "notEncodedThngs":
                $thng=$createThng->createThng($I, $this->notEncoded, $this->length, $this->factory);
                $imgGen->makeNotEncodedThng($thng, $this->length, $this->factory);
                break;
            case "non15":
                $thng=$createThng->createThng($I, $this->encoded, $this->length14, $this->factory);
                $imgGen->makeNon15Thngs($thng, $this->length14, $this->factory);
                $thng=$createThng->createThng($I, $this->encoded, $this->length16, $this->factory);
                $imgGen->makeNon15Thngs($thng, $this->length16, $this->factory);
                break;
            case "thngsAssignedToFactory":
                $thng=$createThng->createThng($I, $this->encoded, $this->length, $this->factory);
                $imgGen->makeThngsForFactory($thng, $this->length, $this->factory);
                break;
            case "thngsAssignedToAnotherFactory":
                $thng=$createThng->createThng($I, $this->encoded, $this->length, $this->factory);
                $imgGen->makeThngsForFactory($thng, $this->length, $this->factory);
                break;
            case "24ThngsEncoded":
                $thng=$createThng->createThng($I, $this->encoded, $this->length24, $this->factory);
                $imgGen->makeThngsForFactory($thng, $this->length24, $this->factory);
                break;
            case "24ThngsNotEncoded":
                $thng=$createThng->createThng($I, $this->notEncoded, $this->length24, $this->factory);
                $imgGen->makeNotEncodedThng($thng, $this->length24, $this->factory);
                break;
        }
    }
    
}

?>