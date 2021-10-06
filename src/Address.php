<?php

namespace Jstewmc\UspsAddress;

class Address implements AddressInterface
{
    use Addressable;

    public function __construct(
        ?string $street1 = null,
        ?string $street2 = null,
        ?string $city = null,
        ?string $state = null,
        ?string $zip = null
    ) {
        $this->street1 = $street1;
        $this->street2 = $street2;
        $this->city    = $city;
        $this->state   = $state;
        $this->zip     = $zip;

        return;
    }

    public function equals(AddressInterface $address): bool
    {
        return (new Compare())($this, $address);
    }

    public function normalize(): Address
    {
        return (new Normalize())($this);
    }
}
