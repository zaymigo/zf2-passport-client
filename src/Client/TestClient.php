<?php
/**
 * Created by PhpStorm.
 * User: keanor
 * Date: 03.10.16
 * Time: 16:00
 */
namespace Zaymigo\PassportClient\Client;

use Zend\Http\Request;
use Zend\Http\Response;

/**
 * Class TestClient
 * @package Zaymigo\PassportClient\Client
 */
class TestClient
{
    public function send(Request $request)
    {
        $url_parts = explode('/', $request->getUriString());
        $passport = array_pop($url_parts);

        $response = new Response();

        if ($passport[0] == '2') {
            $response->setStatusCode(200);
            $response->setContent('False');

            return $response;
        }

        if ($passport[0] == '9') {
            $response->setStatusCode(500);

            return $response;
        }

        $response->setStatusCode(200);
        $response->setContent('True');

        return $response;
    }
}
