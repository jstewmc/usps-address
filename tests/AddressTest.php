<?php
namespace Jstewmc\UspsAddress;

class AddressTest extends \PHPUnit\Framework\TestCase
{
    public function testEqualsReturnsTrueWhenAddressIsEqual(): void
    {
        $address = new Address('foo');

        $this->assertTrue($address->equals($address));
    }

    public function testEqualsReturnsFalseWhenAddressIsNotEquals(): void
    {
        $address1 = new Address('foo');
        $address2 = new Address('bar');

        $this->assertFalse($address1->equals($address2));
    }

    public function testGetCityReturnsNullWhenCityIsNull(): void
    {
        $this->assertNull((new Address())->getCity());
    }

    public function testGetCityReturnsStringWhenCityIsNotNull(): void
    {
        $this->assertEquals('foo', (new Address(null, null, 'foo'))->getCity());
    }

    public function getGetStateReturnsNullWhenStateIsNull(): void
    {
        $this->assertNull((new Address())->getState());
    }

    public function testGetStateReturnsStringWhenStateIsNotNull(): void
    {
        $this->assertEquals('foo', (new Address(null, null, null, 'foo'))->getState());
    }

    public function testGetStreet1ReturnsNullWhenStreet1IsNull(): void
    {
        $this->assertNull((new Address())->getStreet1());
    }

    public function testGetStreet1ReturnsStringWhenStreet1IsNotNull(): void
    {
        $this->assertEquals('foo', (new Address('foo'))->getStreet1());
    }

    public function testGetStreet2ReturnsNullWhenStreet2IsNull(): void
    {
        $this->assertNull((new Address())->getStreet2());
    }

    public function testGetStreet2ReturnsStringWhenSteet2IsNotNull(): void
    {
        $this->assertEquals('foo', (new Address(null, 'foo'))->getStreet2());
    }

    public function testGetZipReturnsNullWhenZipIsNull(): void
    {
        $this->assertNull((new Address())->getZip());
    }

    public function testGetZipReturnsStringWhenZipIsNotNull(): void
    {
        $this->assertEquals('foo', (new Address(null, null, null, null, 'foo'))->getZip());
    }

    public function testHasCityReturnsFalseWhenCityIsNull(): void
    {
        $this->assertFalse((new Address())->hasCity());
    }

    public function testHasCityReturnsTrueWhenCityIsNotNull(): void
    {
        $this->assertTrue((new Address(null, null, 'foo'))->hasCity());
    }

    public function testHasStateReturnsFalseWhenStateIsNull(): void
    {
        $this->assertFalse((new Address())->hasState());
    }

    public function testHasStateReturnsTrueWhenStateIsNotNull(): void
    {
        $this->assertTrue((new Address(null, null, null, 'foo'))->hasState());
    }

    public function testHasStreet1ReturnsFalseWhenStreet1IsNull(): void
    {
        $this->assertFalse((new Address())->hasStreet1());
    }

    public function testHasStreet1ReturnsTrueWhenStreet1IsNotNull(): void
    {
        $this->assertTrue((new Address('foo'))->hasStreet1());
    }

    public function testHasStreet2ReturnsFalseWhenStreet2IsNull(): void
    {
        $this->assertFalse((new Address())->hasStreet2());
    }

    public function testHasStreet2ReturnsTrueWhenStreet2IsNotNull(): void
    {
        $this->assertTrue((new Address(null, 'foo'))->hasStreet2());
    }

    public function testHasZipReturnsFalseWhenZipIsNull(): void
    {
        $this->assertFalse((new Address())->hasZip());
    }

    public function testHasZipReturnsTrueWhenZipIsNotNull(): void
    {
        $this->assertTrue((new Address(null, null, null, null, 'foo'))->hasZip());
    }

    public function testNormalizeReturnsAddress(): void
    {
        $this->assertInstanceOf(Address::class, (new Address())->normalize());
    }

    public function testSetCityReturnsSelfWhenCityIsNull(): void
    {
        $address = new Address();

        $this->assertSame($address, $address->setCity(null));
    }

    public function testSetCityReturnsSelfWhenCityIsNotNull(): void
    {
        $address = new Address();

        $this->assertSame($address, $address->setCity('foo'));
    }

    public function testSetStateReturnsSelfWhenStateIsNull(): void
    {
        $address = new Address();

        $this->assertSame($address, $address->setState(null));
    }

    public function testSetStateReturnsSelfWhenStateIsNotNull(): void
    {
        $address = new Address();

        $this->assertSame($address, $address->setState('foo'));
    }

    public function testSetStreet1ReturnsSelfWhenStreet1IsNull(): void
    {
        $address = new Address();

        $this->assertSame($address, $address->setStreet1(null));
    }

    public function testSetStreet1ReturnsSelfWhenStreet1IsNotNull(): void
    {
        $address = new Address();

        $this->assertSame($address, $address->setStreet1('foo'));
    }

    public function testSetStreet2ReturnsSelfWhenStreet2IsNull(): void
    {
        $address = new Address();

        $this->assertSame($address, $address->setStreet2(null));
    }

    public function testSetStreet2ReturnsSelfWhenStreet2IsNotNull(): void
    {
        $address = new Address();

        $this->assertSame($address, $address->setStreet2('foo'));
    }

    public function testSetCityReturnsSelfWhenZipIsNull(): void
    {
        $address = new Address();

        $this->assertSame($address, $address->setZip(null));
    }

    public function testSetZipReturnsSelfWhenZipIsNotNull(): void
    {
        $address = new Address();

        $this->assertSame($address, $address->setZip('foo'));
    }
}
