<?php

/**
 * @see Gs_QueryBuilder_SetStatement
 */
require_once 'Gs/QueryBuilder/SetStatement.php';

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_SetStatementTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param Gs_QueryBuilder_SetStatement
     */
    protected $_o;

    public function setUp()
    {
        $this->_o = new Gs_QueryBuilder_SetStatement(new Gs_QueryBuilder);
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
    public function itCanConvertToSql()
    {
        $sql = 'SET name = "foo"';
        $this->_o->set(array('name' => 'foo'));
        $this->assertEquals($sql, $this->_o->toSql());

        $sql = 'SET name = "foo", age = 3';
        $this->_o->addSet('age', '3');
        $this->assertEquals($sql, $this->_o->toSql());
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
    public function itProvidesInterfaceToAddValuesToBeSet()
    {
        $this->_o->addSet('a', 'b')->addSets(
            array(
                'c' => 1,
                'd' => 2
            )
        );

        $params = array(
            'a' => 'b',
            'c' => 1,
            'd' => 2
        );

        $this->assertEquals($params, $this->_o->getParams());
    }

    /**
     * @test
     */
    public function itCanSetTheValues()
    {
        $params = array('r' => 1);

        $this->_o->set(array('c' => 1))->set($params);

        $this->assertEquals($params, $this->_o->getParams());
    }
}
