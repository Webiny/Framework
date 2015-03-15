<?php

namespace Webiny\Component\Bootstrap\Tests;

use Webiny\Component\Http\Request;

/**
 * Class BootstrapTest
 * @package Webiny\Component\Bootstrap\Tests
 */
class BootstrapTest extends \PHPUnit_Framework_TestCase
{
    public function setUp(){
        Request::getInstance()->setCurrentUrl('http://www.myapp.com/');
    }

    /**
     * @throws \Exception
     * @throws \Webiny\Component\Bootstrap\BootstrapException
     * @expectedExceptionMessage Unable to read app config file
     * @expectedException \Webiny\Component\Bootstrap\BootstrapException
     */
    public function testRunApplicationException()
    {
        \Webiny\Component\Bootstrap\Bootstrap::getInstance()->runApplication();
    }

    public function testInitializeEnvironment()
    {
        $b = \Webiny\Component\Bootstrap\Bootstrap::getInstance();
        $b->initializeEnvironment(__DIR__.'/DemoApp/');
        $this->assertInstanceOf('\Webiny\Component\Bootstrap\Environment', $b->getEnvironment());
    }

    public function testInitializeRouter()
    {
        $b = \Webiny\Component\Bootstrap\Bootstrap::getInstance();
        $b->initializeEnvironment(__DIR__.'/DemoApp/');
        $b->initializeRouter();
    }


    public function testGetEnvironment()
    {
        $env = \Webiny\Component\Bootstrap\Bootstrap::getInstance()->getEnvironment();
        $this->assertInstanceOf('\Webiny\Component\Bootstrap\Environment', $env);
    }
}