<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Mappers;

use App\Domain\Enums\StatusEnum;
use App\Domain\ValueObjects\DateValueObject;
use App\Domain\ValueObjects\InvoiceNumber;
use App\Modules\Invoices\Domain\Company;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\ProductsCollection;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use stdClass;

class InvoiceMapper
{
    public static function fromStdObjectToInvoice(
        stdClass $invoiceData,
        Company $company,
        Company $billedCompany,
        ProductsCollection $invoiceProducts
    ): Invoice {
        return new Invoice(
            Uuid::fromString($invoiceData->id),
            new InvoiceNumber($invoiceData->number),
            new DateValueObject(Carbon::createFromFormat('Y-m-d', $invoiceData->date)->startOfDay()),
            new DateValueObject(Carbon::createFromFormat('Y-m-d', $invoiceData->due_date)->startOfDay()),
            $company,
            $billedCompany,
            $invoiceProducts,
            StatusEnum::from($invoiceData->status)
        );
    }

    /**
     * @return array<string,mixed>
     */
    public static function fromEntityToArray(Invoice $invoice): array
    {
        return [
            'invoiceNumber' => $invoice->getInvoiceNumber()->value(),
            'invoiceDate' => $invoice->getInvoiceDate()->value()->format('d/m/Y'),
            'dueDate' => $invoice->getDueDate()->value()->format('d/m/Y'),
            'company' => CompanyMapper::fromCompanyToArray($invoice->getCompany()),
            'billedCompany' => CompanyMapper::fromCompanyToArray($invoice->getBilledCompany()),
            'products' => ProductMapper::fromProductCollectionToArray($invoice->getProducts()),
            'totalPrice' => $invoice->getTotalPrice()->value(),
        ];
    }
}
