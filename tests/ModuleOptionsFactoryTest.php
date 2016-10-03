<?php
/**
 * Created by PhpStorm.
 * User: keanor
 * Date: 03.10.16
 * Time: 16:32
 */
namespace Zaymigo\PassportClientTests;

use Zaymigo\PassportClient\ModuleOptionsFactory;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ModuleOptionsFactoryTest
 * @package Zaymigo\PassportClientTests
 */
class ModuleOptionsFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfig()
    {
        $serviceManager = $this->getMockBuilder(ServiceManager::class)
            ->setMethods(['get'])
            ->getMock();

        $serviceManager->expects($this->once())
            ->method('get')
            ->with('Config')
            ->willReturn([
                'asd',
                'passport_client' => [ 'host' => 1, 'port' => 2, 'client' => 3 ],
                'ggg'
            ]);

        $factory = new ModuleOptionsFactory();

        $method = new \ReflectionMethod(ModuleOptionsFactory::class, 'getConfig');
        $method->setAccessible(true);

        $result = $method->invoke($factory, $serviceManager);
        $this->assertEquals($result, [ 'host' => 1, 'port' => 2, 'client' => 3 ]);
    }
}