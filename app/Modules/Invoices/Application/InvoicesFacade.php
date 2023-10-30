<?php declare(strict_types=1);

namespace App\Modules\Invoices\Application;

use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Api\InvoicesFacadeInterface;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\Repository\InvoiceRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class InvoicesFacade implements InvoicesFacadeInterface
{
    public function __construct(
        private ApprovalFacadeInterface $approvalFacade,
        private InvoiceRepositoryInterface $invoiceRepository
    ) {
    }

    public function approve(UuidInterface $invoiceId): true
    {
        $invoice = $this->invoiceRepository->find($invoiceId);
        return $this->approvalFacade->approve(new ApprovalDto($invoiceId, $invoice->getStatus(), Invoice::class));
    }

    public function reject(UuidInterface $invoiceId): true
    {
        $invoice = $this->invoiceRepository->find($invoiceId);
        return $this->approvalFacade->reject(new ApprovalDto($invoiceId, $invoice->getStatus(), Invoice::class));
    }

    public function getInvoice(UuidInterface $uuid): ?Invoice
    {
        return $this->invoiceRepository->find($uuid);
    }
}
