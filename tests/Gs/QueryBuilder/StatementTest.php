<?php

/**
 * @see Gs_QueryBuilder_Statement
 */
require_once 'Gs/QueryBuilder/Statement.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_StatementTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param Gs_QueryBuilder_Statement $query
     */
    protected $_o;

    public function setUp()
    {
        $this->_o = new Gs_QueryBuilder_Statement(new Gs_QueryBuilder);
    }

    /**
     * @test
     */
    public function itSetQueryBuilderOnTheConstructor()
    {
        $this->assertInstanceOf('Gs_QueryBuilder', $this->_o->getBuilder());
    }

    /**
     * @test
     */
    public function itCanAddParamsOneByOne()
    {
        $this->_o->addParam('one')->addParam('two');
        $this->assertEquals(array('one', 'two'), $this->_o->getParams());
    }

    /**
     * @test
     */
    public function itCanAddCollectionOfParams()
    {
        $this->_o->addParam('one')->addParams(array('two', 'three'));
        $this->assertEquals(
            array('one', 'two', 'three'),
            $this->_o->getParams()
        );
    }

    /**
     * @test
     */
    public function itCanSetParams()
    {
        $this->_o->addParam('one')->setParams(array('two', 'three'));
        $this->assertEquals(array('two', 'three'), $this->_o->getParams());
    }

    /**
     * @test
     */
    public function itCanResetParams()
    {
        $this->_o->addParam('one')->addParam('two')->reset();
        $this->assertEquals(array(), $this->_o->getParams());
    }

    /**
     * @test
     */
    public function itsStringVersionIsEmpty()
    {
        $this->assertEquals('', $this->_o);
    }
}
