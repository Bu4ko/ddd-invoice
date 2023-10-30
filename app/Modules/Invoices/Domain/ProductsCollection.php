<?php declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

use \IteratorAggregate;
use \Traversable;
use \ArrayIterator;

final class ProductsCollection implements IteratorAggregate
{
    /**
     * @var Product[]
     */
    private array $list;

    public function __construct(Product ...$product)
    {
        $this->list = $product;
    }

    public function add(Product $product): void
    {
        $this->list[] = $product;
    }

    /**
     * @return Product[]
     */
    public function all(): array
    {
        return $this->list;
    }

    public function getIterator(): Traversable {
        return new ArrayIterator($this->list);
    }
}
