<?php

namespace Jstewmc\UspsAddress;

interface AddressInterface
{
    public function getCity(): ?string;

    public function getState(): ?string;

    public function getStreet1(): ?string;

    public function getStreet2(): ?string;

    public function getZip(): ?string;

    public function hasCity(): bool;

    public function hasState(): bool;

    public function hasStreet1(): bool;

    public function hasStreet2(): bool;

    public function hasZip(): bool;

    public function setCity(?string $city): self;

    public function setState(?string $state): self;

    public function setStreet1(?string $street1): self;

    public function setStreet2(?string $street2): self;

    public function setZip(?string $zip): self;
}
