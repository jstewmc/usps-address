<?php

namespace Jstewmc\UspsAddress;

class NormalizeAddressTest extends \PHPUnit\Framework\TestCase
{
    private $sut;

    public function setUp(): void
    {
        $this->sut = new Normalize();
    }

    public function testInvokeNormalizesAddressWhenCityHasMixedCase(): void
    {
        $address = new Address(null, null, 'FOO');

        $expected = new Address(null, null, 'foo');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenCityHasWhitespace(): void
    {
        $address = new Address(null, null, '   foo   ');

        $expected = new Address(null, null, 'foo');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStateHasMixedCase(): void
    {
        $address = new Address(null, null, null, 'FOO');

        $expected = new Address(null, null, null, 'foo');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStateHasWhitespace(): void
    {
        $address = new Address(null, null, null, '   foo   ');

        $expected = new Address(null, null, null, 'foo');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStateIsAbbreviationWithoutTrailingPeriod(): void
    {
        $address = new Address(null, null, null, 'la');

        $expected = new Address(null, null, null, 'louisiana');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStateIsAbbreviationWithTrailingPeriod(): void
    {
        $address = new Address(null, null, null, 'la.');

        $expected = new Address(null, null, null, 'louisiana');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasSuffix(): void
    {
        $address = new Address('123 foo st');

        $expected = new Address('123 foo street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasDirection(): void
    {
        $address = new Address('123 n st');

        $expected = new Address('123 north street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasCardinalOne(): void
    {
        $address = new Address('123 one st');

        $expected = new Address('123 1 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasCardinalTeens(): void
    {
        $address = new Address('123 seventeen st');

        $expected = new Address('123 17 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasCardinalTens(): void
    {
        $address = new Address('123 twenty-one st');

        $expected = new Address('123 21 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasCardinalHundreds(): void
    {
        $address = new Address('123 one hundred one st');

        $expected = new Address('123 101 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasCardinalHundredsWithAnd(): void
    {
        $address = new Address('123 one hundred and one st');

        $expected = new Address('123 101 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasOrdinalOne(): void
    {
        $address = new Address('123 first st');

        $expected = new Address('123 1 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasOrdinalTeens(): void
    {
        $address = new Address('123 seventeenth st');

        $expected = new Address('123 17 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasOrdinalTens(): void
    {
        $address = new Address('123 twenty-first st');

        $expected = new Address('123 21 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasOrdinalHundreds(): void
    {
        $address = new Address('123 one hundred first st');

        $expected = new Address('123 101 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasOrdinalHundredsWithAnd(): void
    {
        $address = new Address('123 one hundred and first st');

        $expected = new Address('123 101 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasOneWithSuffix(): void
    {
        $address = new Address('123 1st st');

        $expected = new Address('123 1 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasTwoWithSuffix(): void
    {
        $address = new Address('123 2nd st');

        $expected = new Address('123 2 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasThreeWithSuffix(): void
    {
        $address = new Address('123 3rd st');

        $expected = new Address('123 3 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasFourWithSuffix(): void
    {
        $address = new Address('123 4th st');

        $expected = new Address('123 4 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasTeensWithSuffix(): void
    {
        $address = new Address('123 17th st');

        $expected = new Address('123 17 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasTensWithSuffix(): void
    {
        $address = new Address('123 21st st');

        $expected = new Address('123 21 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet1HasHundredsWithSuffix(): void
    {
        $address = new Address('123 101st st');

        $expected = new Address('123 101 street');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenStreet2HasUnit(): void
    {
        $address = new Address('apt 123');

        $expected = new Address('apartment 123');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenZipIsShort(): void
    {
        $address = new Address(null, null, null, null, '12345');

        $expected = new Address(null, null, null, null, '12345');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesAddressWhenZipIsLong(): void
    {
        $address = new Address(null, null, null, null, '1234567890');

        $expected = new Address(null, null, null, null, '12345');

        $this->assertEquals($expected, ($this->sut)($address));
    }

    public function testInvokeNormalizesFullAddress(): void
    {
        $address = new Address(
            '123 Foo St.',
            'Apt 456',
            'Baton ROUGE',
            'la.',
            '12345'
        );

        $expected = new Address(
            '123 foo street',
            'apartment 456',
            'baton rouge',
            'louisiana',
            '12345'
        );

        $this->assertEquals($expected, ($this->sut)($address));
    }
}
