<?php
    namespace CarApi;

    use CarApi\Cache as Cache;
    use CarApi\Soap as SoapClient;

    class Client {

        /**
         * constructor
         * - connects to carapi
         * - inits cache
         *
         * @param apiKey string
         * @param userAgent string
         */
        public function __construct($apiKey = null, $userAgent = 'apiuser') {
            if (!$apiKey) throw new \Exception('no carapi "apikey" given');

            // set used params
            $this->userAgent = $userAgent;
            $this->apiKey = $apiKey;

            // init carapi soap client
            $this->soapClient = new SoapClient($apiKey, $userAgent);

            // init file cache
            $this->cache = new Cache();
        }

        /**
         * fetch
         * handles the data fetching from the carapi soap client
         * with built in cache
         *
         * @param soapFuncName string
         * @param soapFuncParameters array
         */
        protected function fetch ($soapFuncName = '', $soapFuncParameters = array()) {
            if (!$soapFuncName) throw new \Exception('no soapFuncName given');

            // try to get data from cache
            $data = $this->cache->get($soapFuncName, $soapFuncParameters);

            if ($data) {
                return $data;
            }

            // refresh from server
            $response = call_user_func_array(
                array(
                    $this->soapClient,
                    $soapFuncName
                ),
                $soapFuncParameters
            );

            // set new response to cache
            $this->cache->set($soapFuncName, $soapFuncParameters, $response);

            return (object) $response;
        }

        /**
         *
         */
        public function doVehicleFilterView ($filter = null, $fields = array(), $start = 0, $limit = 30, $order = '',  $orderType = 'ASC') {
            return $this->fetch(__FUNCTION__, array(
                $filter,
                $fields,
                $start,
                $limit,
                $order,
                $orderType
            ));
        }

        /**
         *
         */
        public function doVehicleFieldGroupView ($fieldName = null, $filter = null) {
            return $this->fetch(__FUNCTION__, array(
                $fieldName,
                $filter
            ));
        }

        /**
         *
         */
        public function getAvailableLanguages ($language = 'de') {
            return $this->fetch(__FUNCTION__, array(
                $language
            ));
        }

        /**
         *
         */
        public function getLabelTranslations ($language = 'de') {
            return $this->fetch(__FUNCTION__, array(
                $language
            ));
        }

        /**
         *
         */
        public function getAvailableValueLabels ($language = 'de') {
            return $this->fetch(__FUNCTION__, array(
                $language
            ));
        }

        /**
         *
         */
        public function getValueTranslations ($label = null, $language = 'de') {
            return $this->fetch(__FUNCTION__, array(
                $label,
                $language
            ));
        }
    }