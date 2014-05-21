<?php

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Gs_QueryBuilder_HelperTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param Gs_QueryBuilder_Helper
     */
    protected $_o;

    public function setUp()
    {
        $this->_o = new Gs_QueryBuilder_Helper;
        $this->_o->setDoubleQuoted(true);
    }

    /**
     * @test
     */
    public function itVerifiesIfValueIsNumber()
    {
        $this->assertTrue($this->_o->isNumber(1));
        $this->assertTrue($this->_o->isNumber('1'));
        $this->assertTrue($this->_o->isNumber('1.1'));
        $this->assertFalse($this->_o->isNumber('1.1a'));
        $this->assertFalse($this->_o->isNumber('a'));
        $this->assertFalse($this->_o->isNumber('1,2'));
    }

    /**
     * @test
     */
    public function itQuotesValueIfIsNecessary()
    {
        $this->assertEquals(1, $this->_o->quoteIfNecessary(1));
        $this->assertEquals('1', $this->_o->quoteIfNecessary('1'));
        $this->assertEquals('"a"', $this->_o->quoteIfNecessary('a'));
        $this->assertEquals(
            ':placeholder',
            $this->_o->quoteIfNecessary(':placeholder')
        );
    }

    /**
     * @test
     */
    public function itQuotesValue()
    {


        $this->assertEquals('"a"', $this->_o->quote('a'));
        $this->assertEquals('"abc"', $this->_o->quote('abc'));
        $this->assertEquals('"1"', $this->_o->quote('1'));
        $this->assertEquals('"a\"bc\""', $this->_o->quote('a"bc"'));
        $this->assertEquals('"a\'bc"', $this->_o->quote('a\'bc'));

        $this->_o->setDoubleQuoted(false);

        $this->assertEquals("'a'", $this->_o->quote('a'));
        $this->assertEquals("'abc'", $this->_o->quote('abc'));
        $this->assertEquals("'1'", $this->_o->quote('1'));
        $this->assertEquals("'a\'bc\''", $this->_o->quote("a'bc'"));
        $this->assertEquals("'a\'bc'", $this->_o->quote('a\'bc'));
    }

    /**
     * @test
     */
    public function itVerifiesIfValueIsPlaceholder()
    {
        $this->assertTrue($this->_o->isPlaceholder(':placeholder'));
        $this->assertTrue($this->_o->isPlaceholder(':placeHolder'));
        $this->assertTrue($this->_o->isPlaceholder(':place_Holder'));
        $this->assertFalse($this->_o->isPlaceholder('s:st'));
        $this->assertFalse($this->_o->isPlaceholder('string'));
        $this->assertFalse($this->_o->isPlaceholder('1'));
    }

    /**
     * @test
     */
    public function itCanConverValueToTheDbEquivalentValue()
    {
        $this->assertEquals('NULL', $this->_o->toDbValue(null));
        $this->assertEquals('FALSE', $this->_o->toDbValue(false));
        $this->assertEquals('TRUE', $this->_o->toDbValue(true));
        $this->assertEquals('"abc"', $this->_o->toDbValue('abc'));
        $this->assertEquals(
            ':placeholder',
            $this->_o->toDbValue(':placeholder')
        );

        $arrayValue = $this->_o->toDbValue(array('value' => '0000'));
        $this->assertEquals('0000', $arrayValue);
        $this->assertInternalType('string', $arrayValue);
    }

    /**
     * @test
     */
    public function itCanReplacePlaceholders()
    {
        $string =  'the name is :lastname, :name :lastname.';

        $expectedString = 'the name is Bond, James Bond.';

        $result = $this->_o->replacePlaceholders(
            $string,
            array(
                'name'     => 'James',
                'lastname' => 'Bond',
            ),
            false
        );
        $this->assertEquals($expectedString, $result);
    }

}
