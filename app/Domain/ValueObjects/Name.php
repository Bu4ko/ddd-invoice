<?php declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class Name extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->ensureIsValidName($value);

        parent::__construct($value);
    }

    private function ensureIsValidName(string $name): void
    {
        if (strlen($name) === 0) {
            throw new InvalidArgumentException('Company name should not be empty');
        }
    }
}
