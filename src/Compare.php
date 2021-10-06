<?php

namespace Jstewmc\UspsAddress;

class Compare
{
    private $normalize;

    public function __construct(?Normalize $normalize = null)
    {
        $this->normalize = $normalize ?: new Normalize();
    }

    public function __invoke(AddressInterface $address1, AddressInterface $address2): bool
    {
        $norm1 = ($this->normalize)($address1);
        $norm2 = ($this->normalize)($address2);

        $hash1 = $this->hash($norm1);
        $hash2 = $this->hash($norm2);

        return $hash1 == $hash2;
    }

    private function hash(AddressInterface $address): string
    {
        return md5(
            (string)$address->getStreet1().
            (string)$address->getStreet2().
            (string)$address->getCity().
            (string)$address->getState().
            (string)$address->getZip()
        );
    }
}
