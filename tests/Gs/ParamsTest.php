<?php

require_once 'Gs/Params.php';


/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_ParamsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Gs_Params
     */
    protected $_o;


    public function setUp()
    {
        $this->_o = new Gs_Params(
            array(
                'a' => 'Argentina',
                'b' => 'Brazil',
            )
        );
    }

    /**
     * @test
     */
    public function itCanGetAll()
    {
        $expectedParams = array(
            'a' => 'Argentina',
            'b' => 'Brazil',
        );

        $this->assertEquals($expectedParams, $this->_o->getAll());
        $this->assertEquals($expectedParams, $this->_o->get());
    }

    /**
     * @test
     */
    public function itCanGetParam()
    {
        $this->assertEquals('Argentina', $this->_o->get('a'));
        $this->assertEquals('Brazil', $this->_o->get('b'));
        $this->assertNull($this->_o->get('c'));
        $this->assertEquals('default', $this->_o->get('c', 'default'));
    }

    /**
     * @test
     */
    public function itCanCheckIfValueIsSet()
    {
        $this->assertTrue($this->_o->keyExists('a'));
        $this->assertFalse($this->_o->keyExists('c'));
        $this->assertTrue($this->_o->offsetExists('a'));
        $this->assertFalse($this->_o->offsetExists('c'));
    }

    /**
     * @test
     */
    public function itCanIterateObject()
    {
        $values = array();

        foreach ($this->_o as $value) {
            $values[] = $value;
        }

        $this->assertEquals(array('Argentina', 'Brazil'), $values);

        $values = array();

        foreach ($this->_o as $key => $value) {
            $values[$key] = $value;
        }

        $this->assertEquals($this->_o->getAll(), $values);
    }

    /**
     * @test
     */
    public function itCanBeAccessedAsArray()
    {
        $this->assertEquals('Argentina', $this->_o['a']);
        $this->assertNull($this->_o['c']);
    }

    /**
     * @test
     */
    public function itCanSetValueAsArray()
    {
        $this->_o['c'] = 'Cuba';
        $this->assertEquals('Cuba', $this->_o['c']);
    }

    /**
     * @test
     */
    public function canUnsetValue()
    {
        $this->_o->offsetUnset('a');
        $this->assertEquals(array('b' => 'Brazil'), $this->_o->getAll());
    }
}

