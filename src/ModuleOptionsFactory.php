<?php
/**
 * Created by PhpStorm.
 * User: keanor
 * Date: 03.10.16
 * Time: 12:00
 */
namespace Zaymigo\PassportClient;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ModuleOptionsFactory
 * @package Zaymigo\PassportClient
 */
class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ModuleOptions($this->getConfig($serviceLocator));
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return array
     */
    protected function getConfig(ServiceLocatorInterface $serviceLocator)
    {
        $globalConfig = $serviceLocator->get('Config');

        $config = [];

        if (array_key_exists('passport_client', $config)) {
            $config = $globalConfig['passport_client'];
        }

        return $config;
    }
}
