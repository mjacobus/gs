<?php

class Gs_QueryBuilder_InsertTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Gs_QueryBuilder_Insert
     */
    protected $_o;

    public function setUp()
    {
        $this->_o = new Gs_QueryBuilder_Insert;
        $this->_o->getHelper()->setDoubleQuoted(true);
    }

    /**
     * @test
     */
    public function itIsAQueryBuilderAbstract()
    {
        $this->assertInstanceOf('Gs_QueryBuilder_Abstract', $this->_o);
    }


    /**
     * @test
     */
    public function itResolvesSql()
    {
        $this->_o->into('table_name')->values(
            array(
                'field_1' => 'some_value',
                'number'  => 1,
                'id'      => '2',
            )
        );

        $sql = 'INSERT INTO table_name (field_1, number, id) '
             . 'VALUES ("some_value", 1, 2)';
        $this->assertEquals($sql, $this->_o->toSql());
    }

    /**
     * @test
     */
    public function itResolvesSqlReplacingPlaceholders()
    {
        $this->_o->into('table_name')->values(
            array(
                'name' => ':name',
                'age'  => ':age',
            )
        );

        $sql = 'INSERT INTO table_name (name, age) VALUES ("foo", 18)';
        $this->assertEquals(
            $sql,
            $this->_o->toSql(
                array(
                    'name' => 'foo',
                    'age'  => 18
                )
            )
        );
    }
}
