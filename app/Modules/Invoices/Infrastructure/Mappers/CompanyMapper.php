<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Mappers;

use App\Domain\ValueObjects\City;
use App\Domain\ValueObjects\EmailAddress;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Phone;
use App\Domain\ValueObjects\StreetAddress;
use App\Domain\ValueObjects\ZipCode;
use App\Modules\Invoices\Domain\Company;
use Ramsey\Uuid\Uuid;
use stdClass;

class CompanyMapper
{
    public static function fromStdObjectToCompany(stdClass $companyData): Company
    {
        return new Company(
            Uuid::fromString($companyData->id),
            new Name($companyData->name),
            new StreetAddress($companyData->street),
            new City($companyData->city),
            new ZipCode($companyData->zip),
            new Phone($companyData->phone),
            new EmailAddress($companyData->email)
        );
    }

    /**
     * @return array<string, mixed>
     */
    public static function fromCompanyToArray(Company $company): array
    {
        return [
            'name' => $company->getName()->value(),
            'streetAddress' => $company->getStreetAddress()->value(),
            'city' => $company->getCity()->value(),
            'zipCode' => $company->getZipCode()->value(),
            'phone' => $company->getPhone()->value(),
            'emailAddress' => $company->getEmailAddress()->value(),
        ];
    }
}
