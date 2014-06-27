<?php

class Gs_Http_ActionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Gs_Http_Action
     */
    protected $_o;

    /**
     * @var Gs_Http_Response
     */
    protected $_response;

    /**
     * @var Gs_Http_Request
     */
    protected $_request;

    protected $_sever = array('server' => 'varable');

    public function setUp()
    {
        $this->_request  = new Gs_Http_Request;
        $this->_response = new Gs_Http_Response;
        $this->_o = new Gs_Http_Action($this->_request, $this->_response);
    }

    /**
     * @test
     */
    public function itCanExecuteAction()
    {
        $this->_o->execute();
    }

    /**
     * @test
     */
    public function itCanSetRequest()
    {
        $this->assertSame($this->_request, $this->_o->getRequest());
    }

    /**
     * @test
     */
    public function itCanSetResponse()
    {
        $this->assertSame($this->_response, $this->_o->getResponse());
    }
}
