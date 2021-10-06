<?php

namespace Jstewmc\UspsAddress;

trait Addressable
{
    private $street1;

    private $street2;

    private $city;

    private $state;

    private $zip;

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function getStreet1(): ?string
    {
        return $this->street1;
    }

    public function getStreet2(): ?string
    {
        return $this->street2;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function hasCity(): bool
    {
        return $this->city !== null;
    }

    public function hasState(): bool
    {
        return $this->state !== null;
    }

    public function hasStreet1(): bool
    {
        return $this->street1 !== null;
    }

    public function hasStreet2(): bool
    {
        return $this->street2 !== null;
    }

    public function hasZip(): bool
    {
        return $this->zip !== null;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function setStreet1(?string $street1): self
    {
        $this->street1 = $street1;

        return $this;
    }

    public function setStreet2(?string $street2): self
    {
        $this->street2 = $street2;

        return $this;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }
}
