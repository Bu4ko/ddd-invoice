<?php declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class Phone extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->ensureIsValidPhone($value);

        parent::__construct($value);
    }

    private function ensureIsValidPhone(string $phone): void
    {
        if (strlen($phone) === 0) {
            throw new InvalidArgumentException('Phone should not be empty');
        }
    }
}
