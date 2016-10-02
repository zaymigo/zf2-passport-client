<?php
/**
 * Created by PhpStorm.
 * User: keanor
 * Date: 02.10.16
 * Time: 21:32
 */
namespace Zaymigo\PassportClient;

use Zend\Http\Request;

/**
 * Class Client
 * @package Zaymigo\PassportClient
 */
class PassportList
{
    /**
     * Хост сервера
     *
     * @var string
     */
    protected $host;

    /**
     * Порт сервера
     *
     * @var int
     */
    protected $port;

    /**
     * Client constructor.
     *
     * @param string $host
     * @param int $port
     */
    public function __construct($host, $port)
    {
        $this->setHost($host);
        $this->setPort($port);
    }

    /**
     * Проверяем наличие паспорта в списке недействительных паспортов ФМС
     *
     * @param string $passport
     *
     * @return boolean
     */
    public function hasItem($passport)
    {
        $passport = str_replace([',', ' '], '', $passport);

        $response = $this->execute($this->createRequest('check', $passport));

        if ($response->getStatusCode() !== 200) {
            throw new Exception\RuntimeException('Unable process http request');
        }

        if ($response->getBody() === 'False') {
            return false; // Отсутствует в списке
        }

        if ($response->getBody() === 'True') {
            return true; // Присутствует в списке
        }

        throw new Exception\RuntimeException($response->getBody());
    }

    /**
     * @param Request $request
     * @return \Zend\Http\Response
     */
    protected function execute(Request $request)
    {
        return (new \Zend\Http\Client())->send($request);
    }

    /**
     * @param $method
     * @param $argument
     *
     * @return Request
     */
    protected function createRequest($method, $argument)
    {
        return (new Request())->setUri($this->buildUrl($method, $argument));
    }

    /**
     * @param $method
     * @param $argument
     *
     * @return string
     */
    protected function buildUrl($method, $argument)
    {
        return 'http://' .
            $this->host . ':' . $this->port .
            '/' . $method . '/' . $argument;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }
}
