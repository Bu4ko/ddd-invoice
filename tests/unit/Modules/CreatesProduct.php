<?php declare(strict_types=1);

namespace Tests\unit\Modules;

use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Price;
use App\Domain\ValueObjects\Quantity;
use App\Modules\Invoices\Domain\Product;
use App\Modules\Invoices\Domain\ProductsCollection;
use Ramsey\Uuid\Uuid;

trait CreatesProduct
{
    public function createProduct(): Product
    {
        return new Product(
            Uuid::uuid4(),
            new Name('Product'),
            new Quantity(rand(1, 7)),
            new Price(rand(8, 20))
        );
    }

    public function createProductCollection(): ProductsCollection
    {
        $collection = new ProductsCollection();

        $num = rand (1, 5);
        for ($i = 0; $i < $num; $i++) {
            $collection->add($this->createProduct());
        }

        return $collection;
    }
}
