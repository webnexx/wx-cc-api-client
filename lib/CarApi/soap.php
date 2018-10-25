<?php
namespace CarApi;

class Soap {
    protected $WSDLURL = "http://www.car-copy.com/ws/carapi/service.wsdl";
    protected $SOAPURL = "http://www.car-copy.com/ws/carapi/";

    protected $soapClient = null;
    protected $userAgent = null;
    protected $apiKey = null;

    protected function getSoapClient () {
        if (!$this->soapClient) {
            // define SSL options
            $opts = array(
                'http'=>array(
                    'user_agent' => $this->userAgent
                ),
                'ssl' => array(
                    'verify_peer'      => false,
                    'verify_peer_name' => false
                )
            );

            // connect and store
            $this->soapClient = new \SoapClient(
                $this->WSDLURL,
                array(
                    'compression'   => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
                    'location'      => $this->SOAPURL,
                    'encoding'      => 'utf-8',
                    'trace'         => 1,
                    'exception'     => 1,
                    'user_agent'    => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : $this->userAgent,
                    'stream_context' => stream_context_create($opts)
                )
            );

            $soap_header1 = new \SoapHeader(
                'http://www.carcopy.com/WS/WXApi/1.0/',
                'apikey',
                $this->apiKey
            );

            // set the apikey
            $this->soapClient->__setSoapHeaders(
                array($soap_header1)
            );
        }
    }

    public function __construct ($apiKey, $userAgent) {
        $this->userAgent = $userAgent;
        $this->apiKey = $apiKey;

        $this->getSoapClient();
    }

    public function __call($soapFunc, $arguments) {
        return call_user_func_array(
            array(
                $this->soapClient,
                $soapFunc
            ),
            $arguments
        );
    }
}