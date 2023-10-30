<?php declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Repository;

use App\Modules\Invoices\Domain\Invoice;
use Ramsey\Uuid\UuidInterface;

interface InvoiceRepositoryInterface
{
    public function find(UuidInterface $id): ?Invoice;

    public function saveStatusValue(Invoice $invoice): void;
}
