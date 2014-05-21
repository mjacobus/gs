<?php

class Gs_QueryBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var QueryBuilder
     */
    protected $_o;

    public function setUp()
    {
        $this->_o = new Gs_QueryBuilder();
        $this->_o->getHelper()->setDoubleQuoted(true);
    }

    /**
     * @test
     */
    public function
        itCanSetAddFieldsToTheSelectStatementAsStringAndReturnBuilder()
    {
        $object = Gs_QueryBuilder::factorySelect()->select('field')->select(array('one', 'two'));

        $this->assertEquals(
            array('field', 'one', 'two'),
            $object->getSelect()->getParams()
        );
    }

    /**
     * @test
     */
    public function itCanSetFromAsStringAndReturnBuilder()
    {
        $object = $this->_o->from('table');
        $this->assertSame($this->_o, $object);
        $this->assertEquals(array('table'), $this->_o->getFrom()->getParams());

        $object = $this->_o->from(array('table1', 'table2'));
        $this->assertEquals(
            array('table1', 'table2'),
            $this->_o->getFrom()->getParams()
        );
    }

    /**
     * @test
     */
    public function itCanConvertQueryToString()
    {
        $sql = 'SELECT a';
        $this->_o->select('a');
        $this->assertEquals($sql, $this->_o->toSql());

        $sql .= ' FROM table';
        $this->_o->from('table');
        $this->assertEquals($sql, $this->_o->toSql());

        $sql .= ' INNER JOIN table2';
        $this->_o->innerJoin('table2');
        $this->assertEquals($sql, $this->_o->toSql());

        $sql .= ' WHERE a = "b" AND b = 1';
        $this->_o->where('a', 'b')->where(array('b' => 1));
        $this->assertEquals($sql, $this->_o->toSql());

        $sql .= ' GROUP BY group1, group2';
        $this->_o->groupBy(array('group1'))->groupBy('group2');
        $this->assertEquals($sql, $this->_o->toSql());

        $sql .= ' ORDER BY foo, bar DESC';
        $this->_o->orderBy(array('foo', 'bar DESC'));
        $this->assertEquals($sql, $this->_o->toSql());
    }

    /**
     * @test
     */
    public function itGetSqlReplacingThePlaceHolders()
    {
        $this->_o->from('table')->where(
            array(
                'size > :min',
                'size < :max',
                'count != :min',
                'name = :name',
            )
        );

        $params = array(
            'min' => 10,
            'max' => 20,
            'name' => 'foo'
        );

        $sql = 'SELECT * FROM table WHERE size > 10 '
             . 'AND size < 20 AND count != 10 AND name = "foo"';

        $this->assertEquals($sql, $this->_o->toSql($params));
    }


    /**
     * @test
     */
    public function itAddsInnerJoin()
    {
        $this->_o->from('table')->innerJoin('t1')
            ->innerJoin('t2', 't1.id = t2.t1_id');

        $sql = 'INNER JOIN t1 INNER JOIN t2 ON t1.id = t2.t1_id';
        $this->assertEquals($sql, $this->_o->getJoins()->toSql());
    }

    /**
     * @test
     */
    public function itAddsLeftJoin()
    {
        $this->_o->from('table')->leftJoin('t1')
            ->leftJoin('t2', 't1.id = t2.t1_id');

        $sql = 'LEFT JOIN t1 LEFT JOIN t2 ON t1.id = t2.t1_id';
        $this->assertEquals($sql, $this->_o->getJoins()->toSql());
    }

    /**
     * @test
     */
    public function itCallsToSqlWhenConvertingToString()
    {
        $this->assertEquals($this->_o->toSql(), (string) $this->_o);
    }

    /**
     * @test
     */
    public function itProvidesInterfaceForAddingConditions()
    {
        $this->_o->where('a = 1')
            ->where('a', 'b')
            ->where('a', 'x', '!=')
            ->where(
                array(
                    'foo' => 'bar',
                    'foobar' => 'foo'
                )
            );

        $expectedParams = array(
            'a = 1',
            'a = "b"',
            'a != "x"',
            'foo = "bar"',
            'foobar = "foo"',
        );

        $this->assertEquals(
            $expectedParams,
            $this->_o->getWhere()->getParams()
        );
    }

    /**
     * @test
     */
    public function itProvidesInterfaceForAddingOrder()
    {
        $this->_o->orderBy('a')->orderBy(array('b', 'c'));

        $expectedParams = array( 'a', 'b', 'c');

        $this->assertEquals(
            $expectedParams,
            $this->_o->getOrder()->getParams()
        );
    }

    /**
     * @test
     */
    public function itProvidesInterfaceForAddingGroup()
    {
        $this->_o->groupBy('a')->groupBy(array('b', 'c'));

        $expectedParams = array( 'a', 'b', 'c');

        $this->assertEquals(
            $expectedParams,
            $this->_o->getGroup()->getParams()
        );
    }

    /**
     * @test
     */
    public function canFactorySelect()
    {
        $query = Gs_QueryBuilder::factorySelect(array('a', 'b'));
        $this->assertInstanceOf('PO\QueryBuilder\Select', $query);
        $this->assertEquals('SELECT a, b', $query->toSql());
    }

    /**
     * @test
     */
    public function canFactoryUpdate()
    {
        $query = Gs_QueryBuilder::update('table')->addSet('foo', 'bar');
        $this->assertInstanceOf('PO\QueryBuilder\Update', $query);
        $this->assertEquals("UPDATE table SET foo = 'bar'", $query->toSql());
    }

    /**
     * @test
     */
    public function canFactoryInsert()
    {
        $query = Gs_QueryBuilder::insert('table')
            ->values(array('foo' => 'bar'));

        $this->assertInstanceOf('PO\QueryBuilder\Insert', $query);
        $this->assertEquals(
            "INSERT INTO table (foo) VALUES ('bar')",
            $query->toSql()
        );
    }
}
