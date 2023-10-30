<?php declare(strict_types=1);

namespace App\Domain\ValueObjects;

// As price stored as integer let's assume that we handle cents (as only currency is USD)
final class Price extends IntegerValueObject
{
}
