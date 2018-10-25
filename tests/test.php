<?php
namespace CarApi\tests\units;

require_once __DIR__ . '/../vendor/autoload.php';

use CarApi\Client as ApiClient;
use atoum;

class Client extends atoum {

    protected $apikey = '< YOUR API KEY >';

    public function testDoVehicleFilterView () {
        $this
            ->given($this->newTestedInstance($this->apikey))
            ->then
                ->object($this->testedInstance->doVehicleFilterView())
        ;
    }

    public function testDoVehicleFieldGroupView () {
        $this
            ->given($this->newTestedInstance($this->apikey))
            ->then
                ->object($this->testedInstance->doVehicleFieldGroupView())
        ;
    }

    public function testGetAvailableLanguages () {
        $this
            ->given($this->newTestedInstance($this->apikey))
            ->then
                ->object($this->testedInstance->getAvailableLanguages())
        ;
    }

    public function testGetLabelTranslations () {
        $this
            ->given($this->newTestedInstance($this->apikey))
            ->then
                ->object($this->testedInstance->getLabelTranslations())
        ;
    }

    public function testGetAvailableValueLabels () {
        $this
            ->given($this->newTestedInstance($this->apikey))
            ->then
                ->object($this->testedInstance->getAvailableValueLabels())
        ;
    }

    public function testGetValueTranslations () {
        $this
            ->given($this->newTestedInstance($this->apikey))
            ->then
                ->object($this->testedInstance->getValueTranslations('Emissionstd'))
        ;
    }
}