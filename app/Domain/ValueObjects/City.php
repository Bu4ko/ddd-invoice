<?php declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class City extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->ensureIsValidCity($value);

        parent::__construct($value);
    }

    private function ensureIsValidCity(string $city): void
    {
        if (!preg_match('/^[a-zA-Z ]+$/', $city)) {
            throw new InvalidArgumentException('Need to provide correct city');
        }
    }
}
