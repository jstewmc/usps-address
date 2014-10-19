<?php
/**
 * The file for the UspsAddressNormTest class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2014 Jack Clayton
 * @license    MIT License <http://opensource.org/licenses/MIT>
 */

use Jstewmc\UspsAddress\UspsAddressNorm;

/**
 * The UspsAddressNormTest class
 * 
 * @since  0.1.0
 */
class UspsAddressNormTest extends PHPUnit_Framework_TestCase
{
	/* !Data providers */
	
	/**
	 * Provides non-string values
	 */
	public function provideNonStringValues()
	{
		return array(
			array(true),
			array(1),
			array(1.0),
			array(array()),
			array(new StdClass())
		);
	}
	
	/**
	 * Provides non-string and non-integer values
	 */
	public function provideNonStringAndIntegerValues()
	{
		return array(
			array(true),
			array(1.0),
			array(array()),
			array(new StdClass())
		);
	}
	
	
	/* !normalizeCity() */
	
	/**
	 * normalizeCity() should throw an InvalidArgumentException if string is null
	 */
	public function testNormalizeCity_throwsInvalidArgumentException_ifStringIsNull()
	{
		$this->setExpectedException('InvalidArgumentException');
		UspsAddressNorm::normalizeCity(null);
		
		return;
	}
	
	/** 
	 * normalizeCity() should throw an InvalidArgumentException if string is not a string
	 *
	 * @dataProvider  provideNonStringValues
	 */
	public function testNormalizeCity_throwsInvalidArgumentException_ifStringIsNotAString($string)
	{
		$this->setExpectedException('InvalidArgumentException');
		UspsAddressNorm::normalizeCity($string);
		
		return;
	}
	
	/**
	 * normalizeCity() should return a string if given a string
	 */
	public function testNormalizeCity_returnsString()
	{
		return $this->assertEquals('foo bar', UspsAddressNorm::normalizeCity('foo bar'));
	}
	
	/**
	 * normalizeCity() should return a lower-cased string
	 */
	public function testNormalizeCity_returnsLowerString()
	{
		return $this->assertEquals('foo', UspsAddressNorm::normalizeCity('Foo'));
	}
	
	/**
	 * normalizeCity() should return a trimmed string
	 */
	public function testNormalizeCity_returnsTrimmedString()
	{
		return $this->assertEquals('foo', UspsAddressNorm::normalizeCity(' foo '));
	}


	/* !normalizeState() */
	
	/**
	 * normalizeState() should throw an InvalidArgumentException if string is null
	 */
	public function testNormalizeState_throwsInvalidArgumentException_ifStringIsNull()
	{
		$this->setExpectedException('InvalidArgumentException');
		UspsAddressNorm::normalizeState(null);
		
		return;
	}
	
	/** 
	 * normalizeState() should throw an InvalidArgumentException if string is not a string
	 *
	 * @dataProvider  provideNonStringValues
	 */
	public function testNormalizeState_throwsInvalidArgumentException_ifStringIsNotAString($string)
	{
		$this->setExpectedException('InvalidArgumentException');
		UspsAddressNorm::normalizeState($string);
		
		return;
	}
	
	/**
	 * normalizeState() should return a string if given a string
	 */
	public function testNormalizeState_returnsString()
	{
		return $this->assertEquals('foo', UspsAddressNorm::normalizeState('foo'));
	}
	
	/**
	 * normalizeState() should return a lower-case string
	 */
	public function testNormalizeState_returnsLowerString()
	{
		return $this->assertEquals('foo', UspsAddressNorm::normalizeState('Foo'));
	}
	
	/** 
	 * normalizeState() should return a trimmed string
	 */
	public function testNormalizeState_returnsTrimmedString()
	{
		return $this->assertEquals('foo', UspsAddressNorm::normalizeState(' foo '));
	}
	
	/**
	 * normalizeState() should return an un-abbreviated string without trailing period
	 */
	public function testNormalizeState_returnsUnabbreviatedString()
	{
		return $this->assertEquals('louisiana', UspsAddressNorm::normalizeState('LA.'));
	}
	
	
	/* !normalizeStreet() */
	
	/**
	 * normalizeStreet() should throw an InvalidArgumentException if string is null
	 */
	public function testNormalizeStreet_throwsInvalidArgumentException_ifStringIsNull()
	{
		$this->setExpectedException('InvalidArgumentException');
		UspsAddressNorm::normalizeStreet(null);
		
		return;
	}
	
	/** 
	 * normalizeStreet() should throw an InvalidArgumentException if string is not a string
	 *
	 * @dataProvider  provideNonStringValues
	 */
	public function testNormalizeStreet_throwsInvalidArgumentException_ifStringIsNotAString($string)
	{
		$this->setExpectedException('InvalidArgumentException');
		UspsAddressNorm::normalizeStreet($string);
		
		return;
	}
	
	/** 
	 * normalizeStreet() should return a string if given a string
	 */
	public function testNormalizeStreet_returnsString()
	{
		return $this->assertEquals('foo', UspsAddressNorm::normalizeStreet('foo'));
	}
	
	/**
	 * normalizeStreet() should normalize a unit abbreviation (e.g., "apt") to its 
	 *     full-word equivalent (e.g., "apartment")
	 */
	public function testNormalizeStreet_returnsUnabbreviatedUnit()
	{
		return $this->assertEquals(
			'apartment 123', 
			UspsAddressNorm::normalizeStreet('apt 123')
		);
	}
	
	/** 
	 * normalizeStreet() should normalize a street suffix abbrevitation (e.g., "st") to
	 *     its full-word equivalent (e.g., "street")
	 */
	public function testNormalizeStreet_returnsUnabbreviatedSuffix()
	{
		return $this->assertEquals(
			'123 foo street',
			UspsAddressNorm::normalizeStreet('123 foo st')
		);
	}
	
	/**
	 * normalizeStreet() should normalize a compass direction (e.g., "n.") to its
	 *     full-word equivalent (e.g., "north")
	 */
	public function testNormalizeStreet_returnsUnabbreviatedDirection()
	{
		return $this->assertEquals(
			'123 north foo',
			UspsAddressNorm::normalizeStreet('123 n foo')
		);
	}
	
	/** 
	 * normalizeStreet() should return the numeric value of a numeric street number 
	 *     (e.g., "1")
	 */
	public function testNormalizeStreet_returnsNumericValue_ifStreetNumberIsNumber()
	{
		return $this->assertEquals(
			'123 1 street',
			UspsAddressNorm::normalizeStreet('123 1 st')
		);
	}
	
	/**
	 * normalizeStreet() should return the numeric value of a nominal street number 
	 *     in the ones (e.g., "one")
	 */
	public function testNormalizeStreet_returnsNumericValue_ifStreetNumberIsNominalOnes()
	{
		return $this->assertEquals(
			'123 1 street',
			UspsAddressNorm::normalizeStreet('123 one st')
		);
	}
	
	/** 
	 * normalizeStreet() should return the numeric value of a nominal street number
	 *     in the teens (e.g., "seventeen")
	 */
	public function testNormalizeStreet_returnsNumericValue_ifStreetNumberIsNominalTeens()
	{
		return $this->assertEquals(
			'123 17 street',
			UspsAddressNorm::normalizeStreet('123 seventeen st')
		);
	}
	
	/** 
	 * normalizeStreet() should return the numeric value of a nominal street number
	 *     in the tens (e.g., "twenty-one")
	 */
	public function testNormalizeStreet_returnsNumericValue_ifStreetNumberIsNominalTens()
	{
		return $this->assertEquals(
			'123 21 street',
			UspsAddressNorm::normalizeStreet('123 twenty-one st')
		);
	}
	
	/**
	 * normalizeStreet() should return the numeric value of a nominal street number 
	 *     in the hundreds (e.g., "one hundred one")
	 */
	public function testNormalizeStreet_returnsNumericValue_ifStreetNumberIsNominalHundredsWithoutAnd()
	{
		return $this->assertEquals(
			'123 101 street',
			UspsAddressNorm::normalizeStreet('123 one hundred one st')
		);
	}
	
	/**
	 * normalizeStreet() should return the numeric value of a nominal street number
	 *     in the hundreds with the word "and" (e.g. "one hundred and one")
	 */
	public function testNormalizeStreet_returnsNumericValue_ifStreetNumberIsNominalHundredsWithAnd()
	{
		return $this->assertEquals(
			'123 101 street',
			UspsAddressNorm::normalizeStreet('123 one hundred and one st')
		);
	}
	
	/**
	 * normalizeStreet() should return the numeric value of an ordinal street number in
	 *     the ones (e.g., "first")
	 */
	public function testNormalizeStreet_returnsNumericValue_ifStreetNumberIsOrdinalOnes()
	{
		return $this->assertEquals(
			'123 1 street',
			UspsAddressNorm::normalizeStreet('123 first st')
		);
	}
	
	/**
	 * normalizeStreet() should return the numeric value of an ordinal street number in
	 *      the teens (e.g., "seventeenth")
	 */
	public function testNormalizeStreet_returnsNumericValue_ifStreetNumberIsOrdinalTeens()
	{
		return $this->assertEquals(
			'123 17 street',
			UspsAddressNorm::normalizeStreet('123 seventeenth st')
		);
	}
	
	/**
	 * normalizeStreet() should return the numeric value of an ordinal street number in
	 *      the tens (e.g., "twenty-first")
	 */
	public function testNormalizeStreet_returnsNumericValue_ifStreetNumberIsOrdinalTens()
	{
		return $this->assertEquals(
			'123 21 street',
			UspsAddressNorm::normalizeStreet('123 twenty-first st')
		);
	}
	
	/**
	 * normalizeStreet() should return the numeric value of an ordinal street number in
	 *      the hundreds (e.g., "one hundred first")
	 */
	public function testNormalizeStreet_returnsNumericValue_ifStreetNumberIsOrdinalHundredsWithoutAnd()
	{
		return $this->assertEquals(
			'123 101 street',
			UspsAddressNorm::normalizeStreet('123 one hundred first st')
		);
	}
	
	/** 
	 * normalizeStreet() should return the numeric value of an ordinal street number in 
	 *     the hundreds *with* "and" (e.g., "one hundred and first")
	 */
	public function testNormalizeStreet_returnsNumericValue_ifStreetNumberIsOrdinalHundredsWithAnd()
	{
		return $this->assertEquals(
			'123 101 street', 
			UspsAddressNorm::normalizeStreet('123 one hundred and first st')
		);
	}
	
	/** 
	 * normalizeStreet() should return the numeric value of a street number with an ordinal
	 *    suffix in the ones (e.g., "1st")
	 */
	public function testNormalizeStreet_returnsNumericValue_ifStreetNumberIsOrdinalSuffixOnes()
	{
		return $this->assertEquals(
			'123 1 street',
			UspsAddressNorm::normalizeStreet('123 1st st')
		);
	}
	
	/**
	 * normalizeStreet() should return the numeric value of a street number with an ordinal
	 *     suffix in the teens (e.g., "17th")
	 */
	public function testNormalizeStreet_returnsNumericValue_ifStreetNumberIsOrdinalSuffixTeens()
	{
		return $this->assertEquals(
			'123 17 street',
			UspsAddressNorm::normalizeStreet('123 17th st')
		);
	}
	
	/** 
	 * normalizeStreet() should return the numeric value of a street number with an ordinal
	 *     suffix in the tens (e.g., "21rst")
	 */
	public function testNormalizeStreet_returnsNumericValue_ifStreetNumberIsOrdinalSuffixTens()
	{
		return $this->assertEquals(
			'123 21 street',
			UspsAddressNorm::normalizeStreet('123 21st st')
		);
	}
	
	/** 
	 * normalizeStreet() should return the numeric value of a street number with an ordinal
	 *     suffix in the hundreds (e.g., "101st")
	 */
	public function testNormalizeStreet_returnsNumericValue_ifStreetNumberIsOrdinalSuffixHundreds()
	{
		return $this->assertEquals(
			'123 101 street',
			UspsAddressNorm::normalizeStreet('123 101st st')
		);
	}
	
	
	/* !normalizeZip() */
	
	/**
	 * normalizeZip() should throw an InvalidArgumentException if string is null
	 */
	public function testNormalizeZip_throwsInvalidArgumentException_ifStringIsNull()
	{
		$this->setExpectedException('InvalidArgumentException');
		UspsAddressNorm::normalizeZip(null);
		
		return;
	}
	
	/** 
	 * normalizeZip() should throw an InvalidArgumentException if string is not a string or integer
	 *
	 * @dataProvider  provideNonStringAndIntegerValues
	 */
	public function testNormalizeZip_throwsInvalidArgumentException_ifStringIsNotAString($string)
	{
		$this->setExpectedException('InvalidArgumentException');
		UspsAddressNorm::normalizeZip($string);
		
		return;
	}
	
	/** 
	 * normalizeZip() should return a string if given a string
	 */
	public function testZip_returnsString()
	{
		return $this->assertEquals('12345', UspsAddressNorm::normalizeZip('12345'));
	}
	
	/**
	 * normalizeZip() should return the first five characters of string
	 */
	public function testZip_returnsFirstFiveChars()
	{
		return $this->assertEquals('12345', UspsAddressNorm::normalizeZip('1234567890'));
	}
}
