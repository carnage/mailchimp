<?php

namespace MailChimp\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use MailChimp\Api;

class ApiFactory extends AbstractFactory
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Api
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $client = $serviceLocator->get('MailChimp\HttpClient');

        $api = new Api();
        $api->setClient($client);
        $api->setOptions($this->getOptions($serviceLocator, 'api'));

        return $api;

    }

}
