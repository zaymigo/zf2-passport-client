<?php
/**
 * Created by PhpStorm.
 * User: keanor
 * Date: 03.10.16
 * Time: 11:55
 */
namespace Zaymigo\PassportClient;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ServiceFactory
 * @package Zaymigo\PassportClient
 */
class ServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Service($this->getModuleOptions($serviceLocator));
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return ModuleOptions
     */
    protected function getModuleOptions(ServiceLocatorInterface $serviceLocator)
    {
        return $serviceLocator->get(ModuleOptions::class);
    }
}
