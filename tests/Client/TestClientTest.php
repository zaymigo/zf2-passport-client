<?php
namespace Zaymigo\PassportClientTests\Client;
use Zaymigo\PassportClient\Client\TestClient;
use Zend\Http\Request;

/**
 * Created by PhpStorm.
 * User: keanor
 * Date: 03.10.16
 * Time: 16:06
 */
class TestClientTest extends \PHPUnit_Framework_TestCase
{
    public function testSendWithNotExists()
    {
        $request = new Request();
        $request->setUri('http://somehost/check/2233445566');

        $client = new TestClient();
        $response = $client->send($request);

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals($response->getBody(), 'False');
    }

    public function testSendWithExists()
    {
        $request = new Request();
        $request->setUri('http://somehost/check/4233445566');

        $client = new TestClient();
        $response = $client->send($request);

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals($response->getBody(), 'True');
    }

    public function testSendWithError()
    {
        $request = new Request();
        $request->setUri('http://somehost/check/9233445566');

        $client = new TestClient();
        $response = $client->send($request);

        $this->assertEquals($response->getStatusCode(), 500);
    }
}
