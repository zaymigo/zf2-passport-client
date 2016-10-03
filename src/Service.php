<?php
/**
 * Created by PhpStorm.
 * User: keanor
 * Date: 02.10.16
 * Time: 21:32
 */
namespace Zaymigo\PassportClient;

use Zend\Http\Client;
use Zend\Http\Request;

/**
 * Class Client
 * @package Zaymigo\PassportClient
 */
class Service
{
    /**
     * Настройки
     *
     * @var ModuleOptions
     */
    protected $options;

    /**
     * Client constructor.
     *
     * @param ModuleOptions $options
     */
    public function __construct(ModuleOptions $options)
    {
        $this->setOptions($options);
    }

    /**
     * Проверяем наличие паспорта в списке недействительных паспортов ФМС,
     * возвращаем true если паспорт валиден (отсутствует в списке)
     *
     * @param string $passport
     *
     * @return boolean
     */
    public function isValid($passport)
    {
        $passport = str_replace([',', ' '], '', $passport);

        $response = $this->execute($this->createRequest('check', $passport));

        if ($response->getStatusCode() !== 200) {
            throw new Exception\RuntimeException('Unable process http request');
        }

        if ($response->getBody() === 'False') {
            return true; // Отсутствует в списке
        }

        if ($response->getBody() === 'True') {
            return false; // Присутствует в списке
        }

        throw new Exception\RuntimeException($response->getBody());
    }

    /**
     * @param Request $request
     * @return \Zend\Http\Response
     */
    protected function execute(Request $request)
    {
        return $this->createClient()->send($request);
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
     * @return Client
     */
    protected function createClient()
    {
        return new Client();
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
            $this->getOptions()->getHost() . ':' . $this->getOptions()->getPort() .
            '/' . $method . '/' . $argument;
    }

    /**
     * @return ModuleOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param ModuleOptions $options
     */
    public function setOptions(ModuleOptions $options)
    {
        $this->options = $options;
    }
}
