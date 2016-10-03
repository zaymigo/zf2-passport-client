<?php
/**
 * Created by PhpStorm.
 * User: keanor
 * Date: 03.10.16
 * Time: 11:49
 */
namespace Zaymigo\PassportClient;

use Zend\Http\Client;
use Zend\Stdlib\AbstractOptions;

/**
 * Class ModuleOptions
 * @package Zaymigo\PassportClient
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * Хост сервера проверки паспорта
     *
     * @var string
     */
    protected $host = '127.0.0.1';

    /**
     * Порт сервера проверки паспорта
     *
     * @var int
     */
    protected $port = 80;

    /**
     * Класс для клиента
     *
     * @var string
     */
    protected $client = Client::class;

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param string $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }
}
