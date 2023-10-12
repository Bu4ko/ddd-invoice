<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Repository;

use App\Modules\Invoices\Domain\Company;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\ProductsCollection;
use \App\Modules\Invoices\Domain\Repository\InvoiceRepositoryInterface;
use App\Modules\Invoices\Infrastructure\Mappers\CompanyMapper;
use App\Modules\Invoices\Infrastructure\Mappers\InvoiceMapper;
use App\Modules\Invoices\Infrastructure\Mappers\ProductMapper;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\UuidInterface;

final class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function find(UuidInterface $id): ?Invoice
    {
        $invoiceData = DB::table('invoices')
            ->where('id', '=', $id->toString())
            ->first();

        if (!$invoiceData) {
            throw new RecordsNotFoundException('Invoice was not found');
        }

        $company = $this->getCompanyData($invoiceData->company_id);
        $billedCompany = $this->getCompanyData($invoiceData->billed_company_id);
        $invoiceProducts = $this->getInvoiceProducts($id->toString());

        return InvoiceMapper::fromStdObjectToInvoice($invoiceData, $company, $billedCompany, $invoiceProducts);

        /** Could also extract data like this (with custom columns naming, but in this case mapping will be more
         * complicated. Also, could create eloquent models with relations and map models to entities and VOs as another
         * variant
         */
//        $invoiceData = DB::table('invoices')
//            ->select('*')
//            ->leftJoin('companies', 'invoices.company_id', '=', 'companies.id')
//            ->leftJoin('companies as billed_companies', 'invoices.billed_company_id', '=', 'billed_companies.id')
//            ->leftJoin('invoice_product_lines', 'invoices.id', '=', 'invoice_product_lines.invoice_id')
//            ->leftJoin('products', 'products.id', '=', 'invoice_product_lines.product_id')
//            ->where('invoices.id', '=', $id->toString())
//            ->get();
    }

    public function saveStatusValue(Invoice $invoice): void
    {
        DB::table('invoices')
            ->where('id', $invoice->getId()->toString())
            ->update(['status' => $invoice->getStatus()->value]);
    }

    private function getCompanyData(string $uuid): Company
    {
        $companyData = DB::table('companies')
            ->where('id', '=', $uuid)
            ->first();

        if (!$companyData) {
            throw new RecordsNotFoundException('Company was not found');
        }

        return CompanyMapper::fromStdObjectToCompany($companyData);
    }

    private function getInvoiceProducts(string $invoiceId): ProductsCollection
    {
        $invoiceProductsData = DB::table('invoice_product_lines')
            ->leftJoin('products', 'products.id', '=', 'invoice_product_lines.product_id')
            ->where('invoice_product_lines.invoice_id', '=', $invoiceId)
            ->get();

        return ProductMapper::fromCollectionToProductCollection($invoiceProductsData);
    }
}
