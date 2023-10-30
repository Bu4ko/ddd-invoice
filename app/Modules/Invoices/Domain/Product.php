<?php declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

use \App\Domain\Entities\Entity;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Price;
use App\Domain\ValueObjects\Quantity;
use Ramsey\Uuid\UuidInterface;

final class Product implements Entity
{
    private readonly Price $total;
    public function __construct(
        private readonly UuidInterface $id,
        private readonly Name $name,
        private readonly Quantity $quantity,
        private readonly Price $unitPrice
    ) {
        $this->total = new Price($unitPrice->value() * $quantity->value());
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }

    public function getUnitPrice(): Price
    {
        return $this->unitPrice;
    }

    public function getTotal(): Price
    {
        return $this->total;
    }
}
