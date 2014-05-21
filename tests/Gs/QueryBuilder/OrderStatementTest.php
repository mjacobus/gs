<?php

/**
 * @see Gs_QueryBuilder_OrderStatement
 */
require_once 'Gs/QueryBuilder/OrderStatement.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_OrderStatementTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param Gs_QueryBuilder_OrderStatement
     */
    protected $_o;

    public function setUp()
    {
        $this->_o = new Gs_QueryBuilder_OrderStatement(new Gs_QueryBuilder);
    }

    /**
     * @test
     */
    public function itSetQueryBuilderOnTheConstructor()
    {
        $this->assertInstanceOf('Gs_QueryBuilder_Statement', $this->_o);
    }

    /**
     * @test
     */
    public function itConvertsCorrectlyToString()
    {
        $this->_o->addParam('foo');
        $this->assertEquals('ORDER BY foo', $this->_o->toSql());

        $this->_o->addParam('bar DESC');
        $this->assertEquals('ORDER BY foo, bar DESC', $this->_o->toSql());
    }

    /**
     * @test
     */
    public function itReturnsEmptyStringWhenNoParamIsGiven()
    {
        $this->assertEquals('', $this->_o->toSql());
    }
}
