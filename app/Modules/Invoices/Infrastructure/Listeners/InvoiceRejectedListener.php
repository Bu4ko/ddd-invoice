<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Listeners;

use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\Repository\InvoiceRepositoryInterface;

class InvoiceRejectedListener
{
    public function __construct(private readonly InvoiceRepositoryInterface $invoiceRepository)
    {
    }

    public function handle(EntityRejected $event): void
    {
        if (Invoice::class !== $event->approvalDto->entity) {
            return;
        }

        $invoice = $this->invoiceRepository->find($event->approvalDto->id);
        $invoice->reject();
        $this->invoiceRepository->saveStatusValue($invoice);
    }
}

