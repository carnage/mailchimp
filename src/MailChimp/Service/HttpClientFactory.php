<?php

namespace MailChimp\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Http\Client;

class HttpClientFactory extends AbstractFactory
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Client
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $client = new Client();
        $client->setOptions($this->getOptions($serviceLocator, 'http'));

        return $client;

    }

}
