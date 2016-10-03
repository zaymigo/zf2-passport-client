<?php
/**
 * Created by PhpStorm.
 * User: keanor
 * Date: 03.10.16
 * Time: 11:47
 */
namespace Zaymigo\PassportClient;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Class Module
 * @package Zaymigo\PassportClient
 */
class Module implements
    ConfigProviderInterface
{
    const PASSPORT_SERVICE = 'ZaymigoPassportService';

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
