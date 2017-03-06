<?php

namespace AppBundle\Service\CultuurConnect;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class Server
 *
 * @package AppBundle\Service\CultuurConnect
 */
class Server {
    /**
     * @var string
     */
    private $hostname;
    /**
     * @var string
     */
    private $apiVersion;
    /**
     * @var string
     */
    private $authorization;
    /**
     * @var string
     */
    private $language;

    /**
     * @var array
     */
    private $params;

    /**
     * Server constructor.
     *
     * @param string $hostname
     * @param string $apiVersion
     * @param string $authorization
     * @param string $language
     */
    public function __construct($hostname, $authorization, $apiVersion = 'v0', $language = 'nl')
    {
        $this->setHostname($hostname);
        $this->setApiVersion($apiVersion);
        $this->setAuthorization($authorization);
        $this->setLanguage($language);
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @param string $hostname
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * @param string $apiVersion
     */
    public function setApiVersion($apiVersion)
    {
        $this->apiVersion = $apiVersion;
    }

    /**
     * @return string
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * @param string $authorization
     */
    public function setAuthorization($authorization)
    {
        $this->authorization = $authorization;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return array
     */
    public function getParams(array $params = [])
    {
        return array_merge([
            'authorization' => $this->getAuthorization(),
            'lang' => $this->getLanguage(),
        ], $params);
    }

    /**
     * @param string $apiPath
     * @param array $params
     * @param bool $onlyBodyResponse
     *
     * @return \Psr\Http\Message\ResponseInterface|string
     */
    public function get($apiPath, array $params=[], $onlyBodyResponse=true)
    {
        $urlFormat = 'http://%s/api/%s/%s';
        $url = sprintf($urlFormat, $this->getHostname(), $this->getApiVersion(), $apiPath);
        $client = new Client();
        try {
            $res = $client->request('GET', $url, array(
                'query' => $this->getParams($params)
            ));
            $result = $onlyBodyResponse ? (string)$res->getBody() : $res;
        } catch (ClientException $e) {
            $result = null;
        }

        return $result;
    }
}