<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Mappers;

use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Price;
use App\Domain\ValueObjects\Quantity;
use App\Modules\Invoices\Domain\Product;
use App\Modules\Invoices\Domain\ProductsCollection;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use stdClass;

class ProductMapper
{
    public static function fromStdObjectToProduct(stdClass $productData): Product
    {
        return new Product(
            Uuid::fromString($productData->id),
            new Name($productData->name),
            new Quantity($productData->quantity),
            new Price($productData->price)
        );
    }

    public static function fromCollectionToProductCollection(Collection $productsData): ProductsCollection
    {
        $productsCollection = new ProductsCollection();
        foreach ($productsData as $productData) {
            $productsCollection->add(self::fromStdObjectToProduct($productData));
        }

        return $productsCollection;
    }

    /**
     * @return array<string, mixed>
     */
    public static function fromProductCollectionToArray(ProductsCollection $productsCollection): array
    {
        $resultArray = [];
        /** @var Product $product */
        foreach ($productsCollection as $product) {
            $product = [
                'name' => $product->getName()->value(),
                'quantity' => $product->getQuantity()->value(),
                'unitPrice' => $product->getUnitPrice()->value(),
                'total' => $product->getTotal()->value()
            ];
            $resultArray[] = $product;
        }

        return $resultArray;
    }
}
