<?php

namespace Jstewmc\UspsAddress;

class CompareTest extends \PHPUnit\Framework\TestCase
{
    private $sut;

    public function setUp(): void
    {
        $this->sut = new Compare();
    }

    public function testEqualsReturnsTrueWhenAddressesAreEqual(): void
    {
        $address = new Address('foo');

        $this->assertTrue($address->equals($address));
    }

    public function testEqualsReturnsTrueWhenAddressesAreEqualAfterNormalization(): void
    {
        $address = new Address('123 first STREET', 'apt. 456', 'BAr BaZ', '12345');
        $address = new Address('123 1st st.', 'apt 456', 'bar baz', '12345-6789');

        $this->assertTrue($address->equals($address));
    }

    public function testEqualsReturnsFalseWhenAddressesAreNotEqual(): void
    {
        $address1 = new Address('foo');
        $address2 = new Address('bar');

        $this->assertFalse($address1->equals($address2));
    }
}
