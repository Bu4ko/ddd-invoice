<?php declare(strict_types=1);

namespace Tests\unit\Modules\Invoices\Infrastructure\Mappers;

use App\Modules\Invoices\Infrastructure\Mappers\CompanyMapper;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Tests\unit\Modules\CreatesCompany;

class CompanyMapperTest extends TestCase
{
    use CreatesCompany;

    public function testFromCompanyToArray()
    {
        $company = $this->createCompany();

        $companyArray = CompanyMapper::fromCompanyToArray($company);

        self::assertEquals($companyArray, [
            'name' => $company->getName()->value(),
            'streetAddress' => $company->getStreetAddress()->value(),
            'city' => $company->getCity()->value(),
            'zipCode' => $company->getZipCode()->value(),
            'phone' => $company->getPhone()->value(),
            'emailAddress' => $company->getEmailAddress()->value(),
        ]);
    }

    public function testFromStdObjectToCompany()
    {
        $companyStdObject = new \stdClass();
        $companyStdObject->id = Uuid::uuid4()->toString();
        $companyStdObject->name = 'Name';
        $companyStdObject->street = '111 Street';
        $companyStdObject->city = 'City';
        $companyStdObject->zip = '43434';
        $companyStdObject->phone = '4443333';
        $companyStdObject->email = 'test@test.com';

        $company = CompanyMapper::fromStdObjectToCompany($companyStdObject);
        self::assertEquals($companyStdObject->id, $company->getId());
        self::assertEquals($companyStdObject->name, $company->getName()->value());
        self::assertEquals($companyStdObject->street, $company->getStreetAddress()->value());
        self::assertEquals($companyStdObject->city, $company->getCity()->value());
        self::assertEquals($companyStdObject->zip, $company->getZipCode()->value());
        self::assertEquals($companyStdObject->phone, $company->getPhone()->value());
        self::assertEquals($companyStdObject->email, $company->getEmailAddress()->value());
    }
}
