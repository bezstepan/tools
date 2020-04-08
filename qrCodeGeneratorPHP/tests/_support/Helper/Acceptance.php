<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{
    private $BrowserModule = 'PhpBrowser';

    public function SetModule( $module )
    {
        $this->BrowserModule = $module;
    }

    public function getUrl($module='web'){

        $BrowserModuleArray = array('web' => $this->BrowserModule, 'php' => 'PhpBrowser');
        $uri = $this->getModule( $BrowserModuleArray[$module] )->_getUrl();

        return $uri;
    }

    public function pause()
    {
        echo "\n<ACHTUNG>The execution has been paused. Press ENTER to continue<ACHTUNG>\n";

        if (trim(fgets(STDIN)) != chr(13)) {
            return;
        }
    }
}
