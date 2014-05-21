<?php
require_once 'Gs/Http/Response.php';

class Gs_Http_ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Gs_Http_Response
     */
    protected $_o;

    public function setUp()
    {
        $this->_o = new Gs_Http_Response;
    }


    /**
     * @test
     */
    public function itCanAppendContentToBody()
    {
        $body = $this->_o->append('ha')->append('he')->getBody();
        $this->assertEquals('hahe', $this->_o->getBody());
    }

    /**
     * @test
     */
    public function itCanSetBody()
    {
        $body= $this->_o->setBody('body')->setBody('new body');
        $this->assertEquals('new body', $this->_o->getBody());
    }

}
