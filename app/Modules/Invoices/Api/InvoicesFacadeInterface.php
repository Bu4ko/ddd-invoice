<?php declare(strict_types=1);

namespace App\Modules\Invoices\Api;

use App\Modules\Invoices\Domain\Invoice;
use Ramsey\Uuid\UuidInterface;

interface InvoicesFacadeInterface
{
    public function approve(UuidInterface $invoiceId): true;

    public function reject(UuidInterface $invoiceId): true;

    public function getInvoice(UuidInterface $uuid): ?Invoice;
}
