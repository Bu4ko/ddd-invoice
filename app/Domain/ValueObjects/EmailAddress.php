<?php declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class EmailAddress extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->ensureIsValidEmailAddress($value);

        parent::__construct($value);
    }

    private function ensureIsValidEmailAddress(string $email): void
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Need to provide correct email');
        }
    }
}
