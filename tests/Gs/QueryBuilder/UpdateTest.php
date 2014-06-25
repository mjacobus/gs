<?php

class Gs_QueryBuilder_UpdateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Gs_QueryBuilder_Update
     */
    protected $_o;

    public function setUp()
    {
        $this->_o = new Gs_QueryBuilder_Update();
        $this->_o->getHelper()->setDoubleQuoted(true);
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectUpdateStatement()
    {
        $this->assertInstanceOf(
            'Gs_QueryBuilder_UpdateStatement',
            $this->_o->getUpdate()
        );
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectSetStatement()
    {
        $this->assertInstanceOf(
            'Gs_QueryBuilder_SetStatement',
            $this->_o->getSet()
        );
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectWhereStatement()
    {
        $this->assertInstanceOf(
            'Gs_QueryBuilder_WhereStatement',
            $this->_o->getWhere()
        );
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectOrderStatement()
    {
        $this->assertInstanceOf(
            'Gs_QueryBuilder_OrderStatement',
            $this->_o->getOrder()
        );
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectLimitStatement()
    {
        $this->assertInstanceOf(
            'Gs_QueryBuilder_LimitStatement',
            $this->_o->getLimit()
        );
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectJoinsStatement()
    {
        $this->assertInstanceOf(
            'Gs_QueryBuilder_JoinStatement',
            $this->_o->getJoins()
        );
    }

    /**
     * @test
     */
    public function itCanOverrideTheHelperCorrectHelper()
    {
        $this->assertInstanceOf(
            'Gs_QueryBuilder_Helper',
            $this->_o->getHelper()
        );
    }

    /**
     * @test
     */
    public function itInitializesWithTheCorrectHelper()
    {
        $helper = new Gs_QueryBuilder_Helper();
        $options = array('helper' => $helper);
        $object = new Gs_QueryBuilder($options);
        $this->assertSame($helper, $object->getHelper());
    }

    /**
     * @test
     */
    public function itCanConvertQueryToString()
    {
        $sql = 'UPDATE table';
        $this->_o->table('table');
        $this->assertEquals($sql, $this->_o->toSql());

        $sql .= ' INNER JOIN table2';
        $this->_o->innerJoin('table2');
        $this->assertEquals($sql, $this->_o->toSql());

        $sql .= ' SET foo = "bar", age = 12';
        $this->_o->set(
            array(
                'foo' => 'bar',
                'age' => 12
            )
        );

        $this->assertEquals($sql, $this->_o->toSql());

        $sql .= ' WHERE a = "b" AND b = 1';
        $this->_o->where('a', 'b')->where(array('b' => 1));
        $this->assertEquals($sql, $this->_o->toSql());

        $sql .= ' ORDER BY foo, bar DESC';
        $this->_o->orderBy(array('foo', 'bar DESC'));
        $this->assertEquals($sql, $this->_o->toSql());

        $sql .= ' LIMIT 10';
        $this->_o->limit(10);
        $this->assertEquals($sql, $this->_o->toSql());

        $sql .= ', 2';
        $this->_o->limit(10, 2);
        $this->assertEquals($sql, $this->_o->toSql());
    }

    /**
     * @test
     */
    public function itGetSqlReplacingThePlaceHolders()
    {
        $this->_o->table('table')->set(
            array(
                'name' => ':name',
                'age'  => ':age'
            )
        );

        $sql = 'UPDATE table SET name = "foo", age = 12';
        $params = array(
            'name' => 'foo',
            'age' => 12
        );

        $this->assertEquals($sql, $this->_o->toSql($params));
    }


    /**
     * @test
     */
    public function itAddsInnerJoin()
    {
        $this->_o->innerJoin('t1')->innerJoin('t2', 't1.id = t2.t1_id');
        $sql = 'INNER JOIN t1 INNER JOIN t2 ON t1.id = t2.t1_id';
        $this->assertEquals($sql, $this->_o->getJoins()->toSql());
    }

    /**
     * @test
     */
    public function itAddsLeftJoin()
    {
        $this->_o->leftJoin('t1')->leftJoin('t2', 't1.id = t2.t1_id');
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
}
