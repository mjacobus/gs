<?php

/**
 * @see Gs_QueryBuilder_WhereStatement
 */
require_once 'Gs/QueryBuilder/WhereStatement.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_WhereStatementTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param Gs_QueryBuilder_WhereStatement
     */
    protected $_o;

    public function setUp()
    {
        $this->_o = new Gs_QueryBuilder_WhereStatement(new Gs_QueryBuilder);
        $this->_o->getBuilder()->getHelper()->setDoubleQuoted(true);
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
        $this->_o->addParam('1 = 1');
        $this->assertEquals('WHERE 1 = 1', $this->_o->toSql());

        $this->_o->addParam('2 = 2');
        $this->assertEquals('WHERE 1 = 1 AND 2 = 2', $this->_o->toSql());
    }

    /**
     * @test
     */
    public function itReturnsEmptyStringWhenNoParamIsGiven()
    {
        $this->assertEquals('', $this->_o->toSql());
    }

    /**
     * @test
     */
    public function itProvidesInterfaceToAddCondition()
    {
        $this->_o->addCondition('a', 'b')
            ->addCondition('x', 1)
            ->addCondition('y', 1, '!=')
            ->addCondition('c ILIKE "%a%"');

        $expectedParams = array(
            'a = "b"',
            'x = 1',
            'y != 1',
            'c ILIKE "%a%"'
        );

        $this->assertEquals($expectedParams, $this->_o->getParams());
    }

    /**
     * @test
     */
    public function itProvidesInterfaceToAddConditions()
    {
        $this->_o->addConditions(
            array(
                'a = "b"',
                array('x', 1),
                array('x', '2', '!=')
            )
        );

        $this->_o->addConditions(array( 'a' => '5'));

        $expectedParams = array(
            'a = "b"',
            'x = 1',
            'x != 2',
            'a = 5',
        );

        $this->assertEquals($expectedParams, $this->_o->getParams());
    }
}
