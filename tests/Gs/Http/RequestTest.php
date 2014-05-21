<?php

require_once 'Gs/Http/Request.php';

class Gs_Http_RequestTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param Gs/Request
     */
    protected $_o;
    protected $_server = array('foo_server' => 'bar');
    protected $_post   = array('foo_post' => 'bar');
    protected $_get    = array('foo_get' => 'bar');

    public function setUp()
    {
        $this->_o = new Gs_Http_Request(
            $this->_server,
            $this->_post,
            $this->_get
        );
    }

    /**
     * @test
     */
    public function itCanGetTheServerVars()
    {
        $this->assertEquals($this->_server, $this->_o->getServer());
        $this->assertEquals('bar', $this->_o->getServer('foo_server'));
        $this->assertNull($this->_o->getServer('undefined'));
        $this->assertEquals('bar', $this->_o->getServer('undefined', 'bar'));
    }

    /**
     * @test
     */
    public function itCanGetThePostVars()
    {
        $this->assertEquals($this->_post, $this->_o->getPost());
        $this->assertEquals('bar', $this->_o->getPost('foo_post'));
        $this->assertNull($this->_o->getPost('undefined'));
        $this->assertEquals('bar', $this->_o->getPost('undefined', 'bar'));
    }

    /**
     * @test
     */
    public function itCanGetTheGetVars()
    {
        $this->assertEquals($this->_get, $this->_o->getGet());
        $this->assertEquals('bar', $this->_o->getGet('foo_get'));
        $this->assertNull($this->_o->getGet('undefined'));
        $this->assertEquals('bar', $this->_o->getGet('undefined', 'bar'));
    }

    /**
     * @test
     */
    public function itCanGetParams()
    {
        $this->_o = new Gs_Http_Request(
            array(),
            array('a' => 'a'),
            array('a' => 'b', 'c' => 'c')
        );
        $this->assertEquals('a', $this->_o->getParam('a'));
        $this->assertEquals('c', $this->_o->getParam('c'));
        $this->assertEquals('x', $this->_o->getParam('y', 'x'));
    }

    /**
     * @test
     */
    public function itCanGetAllParams()
    {
        $this->_o = new Gs_Http_Request(
            array(),
            array('a' => 'a'),
            array('a' => 'b', 'c' => 'c')
        );

        $expectedParams = array(
            'a' => 'a',
            'c' => 'c'
        );

        $this->assertEquals($expectedParams, $this->_o->getParams());
    }

    /**
     * @test
     */
    public function itCanGetRequestMethod()
    {
        $this->_o = new Gs_Http_Request(array('REQUEST_METHOD' => 'GET'));
        $this->assertEquals('GET', $this->_o->getMethod());
    }

    /**
     * @test
     */
    public function itCanCheckIfRequestIsPost()
    {
        $this->_o = new Gs_Http_Request(array('REQUEST_METHOD' => 'POST'));
        $this->assertTrue($this->_o->isPost());

        $this->_o = new Gs_Http_Request(array('REQUEST_METHOD' => 'GET'));
        $this->assertFalse($this->_o->isPost());
    }

    /**
     * @test
     */
    public function itCanCheckIfRequestIsAjax()
    {
        $this->_o = new Gs_Http_Request(
            array('HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest')
        );

        $this->assertTrue($this->_o->isAjax());

        $this->_o = new Gs_Http_Request();
        $this->assertFalse($this->_o->isAjax());
    }
}
