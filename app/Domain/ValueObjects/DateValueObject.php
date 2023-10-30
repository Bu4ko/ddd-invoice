<?php declare(strict_types=1);

namespace App\Domain\ValueObjects;

use \DateTimeInterface;

final class DateValueObject
{
    public function __construct(protected DateTimeInterface $value)
    {
    }

    final public function value(): DateTimeInterface
    {
        return $this->value;
    }
}
