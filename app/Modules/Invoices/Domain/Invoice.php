<?php declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

use \App\Domain\Aggregates\AggregateRoot;
use \App\Domain\Entities\Entity;
use App\Domain\Enums\StatusEnum;
use App\Domain\ValueObjects\DateValueObject;
use App\Domain\ValueObjects\InvoiceNumber;
use App\Domain\ValueObjects\Price;
use Ramsey\Uuid\UuidInterface;
use \LogicException;

final class Invoice implements AggregateRoot, Entity
{
    private readonly Price $totalPrice;

    public function __construct(
        private readonly UuidInterface $id,
        private readonly InvoiceNumber $invoiceNumber,
        private readonly DateValueObject $invoiceDate,
        private readonly DateValueObject $dueDate,
        private readonly Company $company,
        private readonly Company $billedCompany,
        private readonly ProductsCollection $products,
        private StatusEnum $status
    ) {
        $totalPrice = 0;
        /** @var Product $product */
        foreach ($products as $product) {
            $totalPrice += $product->getTotal()->value();
        }

        $this->totalPrice = new Price($totalPrice);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getInvoiceNumber(): InvoiceNumber
    {
        return $this->invoiceNumber;
    }

    public function getInvoiceDate(): DateValueObject
    {
        return $this->invoiceDate;
    }

    public function getDueDate(): DateValueObject
    {
        return $this->dueDate;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function getBilledCompany(): Company
    {
        return $this->billedCompany;
    }

    public function getProducts(): ProductsCollection
    {
        return $this->products;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getTotalPrice(): Price
    {
        return $this->totalPrice;
    }

    public function approve(): void
    {
        // Need to check here as it's part of domain business logic
        $this->checkInvoiceStatus();
        $this->status = StatusEnum::APPROVED;
    }

    public function reject(): void
    {
        // Need to check here as it's part of domain business logic
        $this->checkInvoiceStatus();
        $this->status = StatusEnum::REJECTED;
    }

    private function checkInvoiceStatus(): void
    {
        if ($this->status === StatusEnum::APPROVED || $this->status === StatusEnum::REJECTED) {
            throw new LogicException('approval status is already assigned');
        }
    }
}
