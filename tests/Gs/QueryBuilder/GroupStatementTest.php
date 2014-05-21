<?php

/**
 * @see Gs_QueryBuilder_GroupStatement
 */
require_once 'Gs/QueryBuilder/GroupStatement.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_GroupStatementTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param Gs_QueryBuilder_GroupStatement
     */
    protected $_o;

    public function setUp()
    {
        $this->_o = new Gs_QueryBuilder_GroupStatement(new Gs_QueryBuilder);
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
        $this->assertEquals('GROUP BY foo', $this->_o->toSql());

        $this->_o->addParam('bar');
        $this->assertEquals('GROUP BY foo, bar', $this->_o->toSql());
    }

    /**
     * @test
     */
    public function itReturnsEmptyStringWhenNoParamIsGiven()
    {
        $this->assertEquals('', $this->_o->toSql());
    }
}
