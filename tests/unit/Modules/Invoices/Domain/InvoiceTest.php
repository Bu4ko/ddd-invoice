<?php declare(strict_types=1);

namespace Tests\unit\Modules\Invoices\Domain;

use App\Domain\Enums\StatusEnum;
use App\Domain\ValueObjects\DateValueObject;
use App\Domain\ValueObjects\InvoiceNumber;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\Product;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Tests\unit\Modules\CreatesCompany;
use Tests\unit\Modules\CreatesProduct;

class InvoiceTest extends TestCase
{
    use CreatesCompany, CreatesProduct;

    public function testGetTotalPrice()
    {
        $total = 0;
        $invoice = $this->getInvoice();
        $products = $invoice->getProducts();
        /** @var Product $product */
        foreach ($products as $product) {
            $total += $product->getTotal()->value();
        }

        self::assertEquals($invoice->getTotalPrice()->value(), $total);
    }

    public function testReject()
    {
        $invoice = $this->getInvoice();

        self::assertEquals($invoice->getStatus()->value, StatusEnum::DRAFT->value);
        $invoice->reject();
        self::assertEquals($invoice->getStatus()->value, StatusEnum::REJECTED->value);
        self::expectException(\LogicException::class);
        $invoice->approve();
    }

    public function testApproveSuccess()
    {
        $invoice = $this->getInvoice();

        self::assertEquals($invoice->getStatus()->value, StatusEnum::DRAFT->value);
        $invoice->approve();
        self::assertEquals($invoice->getStatus()->value, StatusEnum::APPROVED->value);
        self::expectException(\LogicException::class);
        $invoice->reject();
    }

    private function getInvoice(): Invoice
    {
        return new Invoice(
            Uuid::uuid4(),
            new InvoiceNumber('1'),
            new DateValueObject(Carbon::now()),
            new DateValueObject(Carbon::now()),
            $this->createCompany(),
            $this->createCompany(),
            $this->createProductCollection(),
            StatusEnum::DRAFT
        );
    }
}
