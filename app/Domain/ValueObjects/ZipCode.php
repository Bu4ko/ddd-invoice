<?php declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class ZipCode extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->ensureIsValidZipCode($value);

        parent::__construct($value);
    }

    private function ensureIsValidZipCode(string $zipCode): void
    {
        if (strlen($zipCode) === 0) {
            throw new InvalidArgumentException('Zip code should not be empty');
        }
    }
}
