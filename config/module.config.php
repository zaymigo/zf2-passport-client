<?php
/**
 * Created by PhpStorm.
 * User: keanor
 * Date: 03.10.16
 * Time: 11:48
 */
use Zaymigo\PassportClient\Module as PassportClientModule;
use Zaymigo\PassportClient\ModuleOptions;
use Zaymigo\PassportClient\ModuleOptionsFactory;
use Zaymigo\PassportClient\ServiceFactory;

return [
    'passport_client' => [
        'host' => '127.0.0.1',
        'port' => 80
    ],
    'service_manager' => [
        'factories' => [
            PassportClientModule::PASSPORT_SERVICE => ServiceFactory::class,
            ModuleOptions::class => ModuleOptionsFactory::class,
        ],
    ],
];
