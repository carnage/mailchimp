<?php
/**
 * Created by JetBrains PhpStorm.
 * User: carnage
 * Date: 12/01/14
 * Time: 18:58
 * To change this template use File | Settings | File Templates.
 */

namespace MailChimp;

use Zend\Http\Client;
use Zend\Http\Headers;
use Zend\Http\Request;

/**
 * Class Api
 * @package MailChimp
 */
class Api
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $config = array(
        'apikey' => '',
        'baseuri' => ''
    );
    
    protected $campaigns;
    protected $ecomm;
    protected $folders;
    protected $gallery;
    protected $helper;
    protected $lists;
    protected $reports;
    protected $templates;
    protected $users;
    protected $vip;

    /**
     * @param Client $client
     * @return $this
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set configuration parameters for this Api caller
     *
     * @param  array|Traversable $options
     * @return Api
     * @throws \Exception
     */
    public function setOptions($options = array())
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        }
        if (!is_array($options)) {
            throw new \Exception('Config parameter is not valid');
        }

        /** Config Key Normalization */
        foreach ($options as $k => $v) {
            $this->config[str_replace(array('-', '_', ' ', '.'), '', strtolower($k))] = $v; // replace w/ normalized
        }

        return $this;
    }

    /**
     * Gets the Api key from config, removing the dc part if it exists
     *
     * @return string
     */
    public function getApiKey()
    {
        $apikey = $this->config['apikey'];
        if (strstr($this->config['apikey'],"-")) {
            list($apikey, $_) = explode("-", $this->config['apikey'], 2);
        }

        return $apikey;
    }

    /**
     * Gets the base uri, substituting in the data center from the api key if it exists
     *
     * @return string
     */
    public function getBaseUri()
    {
        if (strstr($this->config['apikey'],"-")){
            list($_, $dc) = explode("-",$this->config['apikey'],2);
        }
        if (empty($dc)) {
            $dc = "us1";
        }

        $baseUri = rtrim(str_replace('https://api', 'https://' . $dc . '.api', $this->config['baseuri']), '/') . '/';

        return $baseUri;
    }

    /**
     * Call an api method
     *
     * @param $method
     * @param $params
     * @return mixed
     * @throws \Exception
     */
    public function call($method, $params)
    {
        $params['apikey'] = $this->getApiKey();
        $params = json_encode($params);

        $client = $this->getClient();

        $uri = $this->getBaseUri() . $method . '.json';

        $headers = new Headers();
        $headers->addHeaderLine('Accept-Encoding', 'identity');
        $headers->addHeaderLine('Content-Type', 'application/json');
        $headers->addHeaderLine('Accept', '*/*');

        $request = new Request();
        $request->setHeaders($headers);
        $request->setUri($uri);
        $request->setMethod('POST');

        $request->setContent($params);

        $response = $client->dispatch($request);

        if ($response->isSuccess()) {
            return json_decode($response->getContent(), true);
        } else {
            /*@TODO throw a more useful exception*/
            throw new \Exception('Request Failed');
        }
    }

    /**
     * @return Api\Campaigns
     */
    public function campaigns()
    {
        if (is_null($this->campaigns)) {
            $this->campaigns = new Api\Campaigns($this);
        }    
        
        return $this->campaigns;
    }

    /**
     * @return Api\Ecomm
     */
    public function ecomm()
    {
        if (is_null($this->ecomm)) {
            $this->ecomm = new Api\Ecomm($this);
        }

        return $this->ecomm;
    }

    /**
     * @return Api\Folders
     */
    public function folders()
    {
        if (is_null($this->folders)) {
            $this->folders = new Api\Folders($this);
        }

        return $this->folders;
    }

    /**
     * @return Api\Gallery
     */
    public function gallery()
    {
        if (is_null($this->gallery)) {
            $this->gallery = new Api\Gallery($this);
        }

        return $this->gallery;
    }

    /**
     * @return Api\Helper
     */
    public function helper()
    {
        if (is_null($this->helper)) {
            $this->helper = new Api\Helper($this);
        }

        return $this->helper;
    }

    /**
     * @return Api\Lists
     */
    public function lists()
    {
        if (is_null($this->lists)) {
            $this->lists = new Api\Lists($this);
        }

        return $this->lists;
    }

    /**
     * @return Api\Reports
     */
    public function reports()
    {
        if (is_null($this->reports)) {
            $this->reports = new Api\Reports($this);
        }

        return $this->reports;
    }

    /**
     * @return Api\Templates
     */
    public function templates()
    {
        if (is_null($this->templates)) {
            $this->templates = new Api\Templates($this);
        }

        return $this->templates;
    }

    /**
     * @return Api\Users
     */
    public function users()
    {
        if (is_null($this->users)) {
            $this->users = new Api\Users($this);
        }

        return $this->users;
    }

    /**
     * @return Api\Vip
     */
    public function vip()
    {
        if (is_null($this->vip)) {
            $this->vip = new Api\Vip($this);
        }

        return $this->vip;
    }
}
