<?php declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class InvoiceNumber extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->ensureIsValidInvoiceNumber($value);

        parent::__construct($value);
    }

    private function ensureIsValidInvoiceNumber(string $invoiceNumber): void
    {
        if (strlen($invoiceNumber) === 0) {
            throw new InvalidArgumentException('Invoice number should not be empty');
        }
    }
}
