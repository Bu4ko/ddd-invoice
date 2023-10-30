<?php declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

use \App\Domain\Entities\Entity;
use App\Domain\ValueObjects\City;
use App\Domain\ValueObjects\EmailAddress;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Phone;
use App\Domain\ValueObjects\StreetAddress;
use App\Domain\ValueObjects\ZipCode;
use Ramsey\Uuid\UuidInterface;

final class Company implements Entity
{
    public function __construct(
        private readonly UuidInterface $id,
        private readonly Name $name,
        private readonly StreetAddress $streetAddress,
        private readonly City $city,
        private readonly ZipCode $zipCode,
        private readonly Phone $phone,
        private readonly EmailAddress $emailAddress
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getStreetAddress(): StreetAddress
    {
        return $this->streetAddress;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function getZipCode(): ZipCode
    {
        return $this->zipCode;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getEmailAddress(): EmailAddress
    {
        return $this->emailAddress;
    }
}
