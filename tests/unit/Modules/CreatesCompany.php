<?php declare(strict_types=1);

namespace Tests\unit\Modules;

use App\Domain\ValueObjects\City;
use App\Domain\ValueObjects\EmailAddress;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Phone;
use App\Domain\ValueObjects\StreetAddress;
use App\Domain\ValueObjects\ZipCode;
use App\Modules\Invoices\Domain\Company;
use Ramsey\Uuid\Uuid;

trait CreatesCompany
{
    public function createCompany()
    {
        return new Company(
            Uuid::uuid4(),
            new Name('Company'),
            new StreetAddress('111 Street'),
            new City('City'),
            new ZipCode('244'),
            new Phone('5554344'),
            new EmailAddress('ttt@tt.com')
        );
    }
}
