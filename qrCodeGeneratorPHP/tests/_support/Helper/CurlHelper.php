<?php
/**
 * Created by PhpStorm.
 * User: agarifullin
 * Date: 05.07.2018
 * Time: 17:04
 */

namespace Helper;

class CurlHelper extends \Codeception\Module{
    public function curlResponse($url, $header, $body)
    {
        #region
        $ch = curl_init($url);

        $fh = fopen('tests/_output/curl_std_err.txt', 'w+');
       
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_POST => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_STDERR => $fh,
            CURLOPT_VERBOSE => true 
        );

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);
        #endregion
        
        return $response;
    }

    public function curlHttpCode($url, $header, $body)
    {
        #region
        $ch = curl_init($url);

        $fh = fopen('tests/_output/curl_std_err.txt', 'w+');
       
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_POST => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_STDERR => $fh,
            CURLOPT_VERBOSE => true 
        );

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        #endregion

        return $httpCode;
    }

    public function curlForThng($url, $header, $body)
    {
        #region
        $ch = curl_init($url);

        $fh = fopen('tests/_output/curl_std_err.txt', 'w+');
       
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_POST => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_STDERR => $fh,
            CURLOPT_VERBOSE => true 
        );

        curl_setopt_array($ch, $options);
        #endregion
        
        return $ch;
    }
}
