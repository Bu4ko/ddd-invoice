<?php declare(strict_types=1);

namespace App\Modules\Invoices\Application\Listeners;

use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\Repository\InvoiceRepositoryInterface;

class InvoiceApprovedListener
{
    public function __construct(private readonly InvoiceRepositoryInterface $invoiceRepository)
    {
    }

    public function handle(EntityApproved $event): void
    {
        if (Invoice::class !== $event->approvalDto->entity) {
            return;
        }

        $invoice = $this->invoiceRepository->find($event->approvalDto->id);
        $invoice->approve();
        $this->invoiceRepository->saveStatusValue($invoice);
    }
}
