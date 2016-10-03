<?php
/**
 * Created by PhpStorm.
 * User: keanor
 * Date: 03.10.16
 * Time: 12:04
 */
namespace Zaymigo\PassportClientTests;

use ReflectionClass;
use ReflectionMethod;
use Zaymigo\PassportClient\Client\TestClient;
use Zaymigo\PassportClient\ModuleOptions;
use Zaymigo\PassportClient\Service;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Http\Response;

/**
 * Class ServiceTest
 * @package Zaymigo\PassportClientTests
 */
class ServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $options = new ModuleOptions();

        $mock = $this->getMockBuilder(Service::class)
            ->disableOriginalConstructor()
            ->setMethods(['setOptions'])
            ->getMock();

        $mock->expects($this->once())
            ->method('setOptions')
            ->with($options);

        $class = new ReflectionClass(Service::class);
        $this->assertTrue($class->isInstantiable());
        $method = $class->getConstructor();
        $method->invoke($mock, $options);
    }

    public function testIsValidValid()
    {
        $request = new Request();

        $response = new Response();
        $response->setStatusCode(200);
        $response->setContent('False');

        $mock = $this->getMockBuilder(Service::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute', 'createRequest'])
            ->getMock();

        $mock->expects($this->once())
            ->method('createRequest')
            ->with('check', '1234567890')
            ->willReturn($request);

        $mock->expects($this->once())
            ->method('execute')
            ->with($request)
            ->willReturn($response);

        $this->assertTrue(call_user_func([$mock, 'isValid'], '1234567890'));
    }

    public function testIsValidInvalid()
    {
        $request = new Request();

        $response = new Response();
        $response->setStatusCode(200);
        $response->setContent('True');

        $mock = $this->getMockBuilder(Service::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute', 'createRequest'])
            ->getMock();

        $mock->expects($this->once())
            ->method('createRequest')
            ->with('check', '1234567890')
            ->willReturn($request);

        $mock->expects($this->once())
            ->method('execute')
            ->with($request)
            ->willReturn($response);

        $this->assertFalse(call_user_func([$mock, 'isValid'], '1234567890'));
    }

    /**
     * @expectedException \Zaymigo\PassportClient\Exception\RuntimeException
     * @expectedExceptionMessage invalid length
     */
    public function testIsValidContentFailure()
    {
        $request = new Request();

        $response = new Response();
        $response->setStatusCode(200);
        $response->setContent('invalid length');

        $mock = $this->getMockBuilder(Service::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute', 'createRequest'])
            ->getMock();

        $mock->expects($this->once())
            ->method('createRequest')
            ->with('check', '1234567890')
            ->willReturn($request);

        $mock->expects($this->once())
            ->method('execute')
            ->with($request)
            ->willReturn($response);

        call_user_func([$mock, 'isValid'], '1234567890');
    }

    /**
     * @expectedException \Zaymigo\PassportClient\Exception\RuntimeException
     * @expectedExceptionMessage Unable process http request
     */
    public function testIsValidHttpFailure()
    {
        $request = new Request();

        $response = new Response();
        $response->setStatusCode(502);

        $mock = $this->getMockBuilder(Service::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute', 'createRequest'])
            ->getMock();

        $mock->expects($this->once())
            ->method('createRequest')
            ->with('check', '1234567890')
            ->willReturn($request);

        $mock->expects($this->once())
            ->method('execute')
            ->with($request)
            ->willReturn($response);

        call_user_func([$mock, 'isValid'], '1234567890');
    }

    public function testExecute()
    {
        $request = new Request();
        $response = new Response();

        $client = $this->getMockBuilder(Client::class)
            ->setMethods(['send'])
            ->getMock();

        $client->expects($this->once())
            ->method('send')
            ->with($request)
            ->willReturn($response);

        $mock = $this->getMockBuilder(Service::class)
            ->setMethods(['createClient'])
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())
            ->method('createClient')
            ->willReturn($client);

        $method = new ReflectionMethod(Service::class, 'execute');
        $method->setAccessible(true);
        $method->invoke($mock, $request);
    }

    public function testCreateRequest()
    {
        $mock = $this->getMockBuilder(Service::class)
            ->setMethods(['buildUrl'])
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())
            ->method('buildUrl')
            ->with('123', '333')
            ->willReturn('http://host:port/ggg/hhh');

        $method = new ReflectionMethod(Service::class, 'createRequest');
        $method->setAccessible(true);
        $request = $method->invoke($mock, '123', '333');

        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('http://host:port/ggg/hhh', $request->getUri()->toString());
    }

    public function testCreateClientWithDefaultClient()
    {
        $mock = $this->getMockBuilder(Service::class)
            ->setMethods(['getOptions'])
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())
            ->method('getOptions')
            ->willReturn(new ModuleOptions());

        $method = new ReflectionMethod(Service::class, 'createClient');
        $method->setAccessible(true);

        $client = $method->invoke($mock);
        $this->assertInstanceOf(Client::class, $client);
    }

    public function testCreateClientWithTestClient()
    {
        $mock = $this->getMockBuilder(Service::class)
            ->setMethods(['getOptions'])
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())
            ->method('getOptions')
            ->willReturn(new ModuleOptions(['client' => TestClient::class]));

        $method = new ReflectionMethod(Service::class, 'createClient');
        $method->setAccessible(true);

        $client = $method->invoke($mock);
        $this->assertInstanceOf(TestClient::class, $client);
    }

    public function testBuildUrl()
    {
        $options = $this->getMockBuilder(ModuleOptions::class)
            ->setMethods(['getHost', 'getPort'])
            ->getMock();

        $options->expects($this->once())
            ->method('getHost')
            ->willReturn('ggg');

        $options->expects($this->once())
            ->method('getPort')
            ->willReturn('hhh');

        $service = $this->getMockBuilder(Service::class)
            ->disableOriginalConstructor()
            ->setMethods(['getOptions'])
            ->getMock();

        $service->expects($this->any())
            ->method('getOptions')
            ->willReturn($options);

        $method = new ReflectionMethod(Service::class, 'buildUrl');
        $method->setAccessible(true);
        $url = $method->invoke($service, 'qqq', 'www');

        $this->assertEquals('http://ggg:hhh/qqq/www', $url);
    }
}
