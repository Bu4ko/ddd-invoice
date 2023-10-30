<?php declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class StreetAddress extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->ensureIsValidAddress($value);

        parent::__construct($value);
    }

    private function ensureIsValidAddress(string $address): void
    {
        if (!preg_match('/^\\d+ [a-zA-Z ]+$/', $address)) {
            throw new InvalidArgumentException('Need to provide correct address');
        }
    }
}
