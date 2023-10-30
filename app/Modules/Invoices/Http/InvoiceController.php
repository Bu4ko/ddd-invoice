<?php declare(strict_types=1);

namespace App\Modules\Invoices\Http;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Api\InvoicesFacadeInterface;
use  App\Modules\Invoices\Infrastructure\Mappers\InvoiceMapper;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;

final class InvoiceController extends Controller
{
    public function show(string $id, InvoicesFacadeInterface $invoicesFacade): JsonResponse
    {
        $invoiceId = Uuid::fromString($id);

        $invoice = $invoicesFacade->getInvoice($invoiceId);

        return response()->json(
            InvoiceMapper::fromEntityToArray($invoice)
        );
    }

    public function approve(string $id, InvoicesFacadeInterface $invoicesFacade): JsonResponse
    {
        $invoicesFacade->approve(Uuid::fromString($id));

        return response()->json(
            ['message' => 'Invoice has been approved']
        );
    }

    public function reject(string $id, InvoicesFacadeInterface $invoicesFacade): JsonResponse
    {
        $invoicesFacade->reject(Uuid::fromString($id));

        return response()->json(
            ['message' => 'Invoice has been rejected']
        );
    }
}
