<?php
/**
 * The file for the UspsAddressTest class
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2014 Jack Clayton
 * @license    MIT License <http://opensource.org/licenses/MIT>
 */

use Jstewmc\UspsAddress\UspsAddress;
use Jstewmc\UspsAddress\UspsAddressNorm;

/**
 * The UspsAddressTest class
 *
 */
class AddressTest extends PHPUnit_Framework_TestCase
{	
	/* !Test getters and setters */
	
	public function testCity()
	{
		$address = new UspsAddress();
		$address->setCity('foo');
		
		return $this->assertEquals('foo', $address->getCity());
	}
	
	public function testState()
	{
		$address = new UspsAddress();
		$address->setState('foo');
		
		return $this->assertEquals('foo', $address->getState());
	}
	
	public function testStreet1()
	{
		$address = new UspsAddress();
		$address->setStreet1('foo');
		
		return $this->assertEquals('foo', $address->getStreet1());
	}
	
	public function testStreet2()
	{
		$address = new UspsAddress();
		$address->setStreet2('foo');
		
		return $this->assertEquals('foo', $address->getStreet2());
	}
	
	public function testZip()
	{
		$address = new UspsAddress();
		$address->setZip('foo');
		
		return $this->assertEquals('foo', $address->getZip());
	}
	
	/* !Test magic methods */
	
	public function test__construct_returnsObject_ifNoParams()
	{
		$address = new UspsAddress();
		
		$this->assertNull($address->getStreet1());
		$this->assertNull($address->getStreet2());
		$this->assertNull($address->getCity());
		$this->assertNull($address->getState());
		$this->assertNull($address->getZip());
		
		return;
	}
	
	public function test__construct_returnsObject_ifParams()
	{
		$address = new UspsAddress('foo', 'bar', 'baz', 'qux', 'quux');
		
		$this->assertEquals('foo', $address->getStreet1());
		$this->assertEquals('bar', $address->getStreet2());
		$this->assertEquals('baz', $address->getCity());
		$this->assertEquals('qux', $address->getState());
		$this->assertEquals('quux', $address->getZip());
		
		return;
	}
	
	/* !equals() */
	
	/** 
	 * equals() should throw an InvalidArgumentException if $address is null
	 */
	public function testEquals_throwsInvalidArgumentException_ifAddressIsNull()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$address = new UspsAddress();
		$address->equals(null);
		
		return;
	}
	
	/** 
	 * equals() should throw an InvalidArgumentException if $address is not a UspsAddress
	 */
	public function testEquals_throwsInvalidArgumentException_ifAddressIsNotUspsAddress()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$address = new UspsAddress();
		$address->equals('foo');
		
		return;
	}
	
	/** 
	 * equals() should return true if two addresses are equal
	 */
	public function testEquals_returnsTrue_ifAddressesAreEqual()
	{
		$a = new UspsAddress('123 foo st', null, 'bar', 'baz', '12345');
		$b = new UspsAddress('123 foo st', null, 'bar', 'baz', '12345');
		
		return $this->assertTrue($a->equals($b));
	}
	
	/** 
	 * equals() should return false if two addresses are not equal
	 */
	public function testEquals_returnsFalse_ifAddressesAreNotEqual()
	{
		$a = new UspsAddress('123 foo st', null, 'bar', 'baz', '12345');
		$b = new UspsAddress('456 foo st', null, 'bar', 'baz', '12345');
		
		return $this->assertFalse($a->equals($b));
	}
	
	
	/* !getHash() */
	
	/**
	 * getHash() should return the hash for an empty string ('') if it's empty
	 */
	public function testGetHash_returnsString_ifAddressIsEmpty()
	{
		$address = new UspsAddress();
		$hash    = md5('');
		
		return $this->assertEquals($hash, $address->getHash());
	}
	
	/**
	 * getHash() should return the address hash if not empty
	 */
	public function testGetHash_returnsString_ifAddressIsNotEmpty()
	{
		$address = new UspsAddress('foo', 'bar', 'baz', 'qux', 'quux');
		$hash    = md5('foo'.'bar'.'baz'.'qux'.'quux');
		
		return $this->assertEquals($hash, $address->getHash());
	}
	
	/* !getNorm() */
	
	/**
	 * getNorm() should return an instance of a UspsAddressNorm if the address is empty
	 */
	public function testGetNorm_returnsObject_ifAddressIsEmpty()
	{
		$address = new UspsAddress();
		
		return $this->assertTrue($address->getNorm() instanceof UspsAddressNorm);
	}
	
	/**
	 * getNorm() should return an instance of a UspsAddressNorm if the address is not empty
	 */
	public function testGetNorm_returnsObject_ifAddressIsNotEmpty()
	{
		$address = new UspsAddress('foo', 'bar', 'baz', 'qux', 'quux');
		
		return $this->assertTrue($address->getNorm() instanceof UspsAddressNorm);
	}
}
