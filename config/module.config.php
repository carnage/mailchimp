<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'mailchimp' =>array(
        'http'=>array(
            //'adapter' => 'Zend\Http\Client\Adapter\Curl',
            'sslverifypeer' => false
        ),
        'api' => array(
            'api_key' => '',
            'base_uri' => 'https://api.mailchimp.com/2.0/'
        )
    ),

    'service_manager' => array(
        'factories' => array(
            'MailChimp\HttpClient' => 'MailChimp\Service\HttpClientFactory',
            'MailChimp\Api' => 'MailChimp\Service\ApiFactory',
        )
    ),

);