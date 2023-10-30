<?php declare(strict_types=1);

namespace Tests\unit\Domain\ValueObjects;

use App\Domain\ValueObjects\City;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CityTest extends TestCase
{

    public function testCreateCity()
    {
        $city = new City('Test');
        self::assertEquals('Test', $city->value());
        self::expectException(InvalidArgumentException::class);
        new City('Test1');
    }
}
