<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Club;

use DateTimeImmutable;
use SmartpingApi\Helper\DateTimeHelpers;
use SmartpingApi\Model\SmartpingObject;
use Symfony\Component\Serializer\Annotation\SerializedName;

class ClubDetail extends SmartpingObject
{
    #[SerializedName('idclub')]
    private int $id;

    #[SerializedName('numero')]
    private string $code;

    #[SerializedName('nom')]
    private string $name;

    #[SerializedName('nomsalle')]
    private string $hallName;

    #[SerializedName('adressesalle1')]
    private string $hallAddress1;

    #[SerializedName('adressesalle2')]
    private ?string $hallAddress2;

    #[SerializedName('adressesalle3')]
    private ?string $hallAddress3;

    #[SerializedName('codepsalle')]
    private string $hallPostalCode;

    #[SerializedName('villesalle')]
    private string $hallCity;

    #[SerializedName('web')]
    private ?string $website;

    #[SerializedName('nomcor')]
    private string $contactLastname;

    #[SerializedName('prenomcor')]
    private string $contactFirstname;

    #[SerializedName('mailcor')]
    private ?string $contactMail;

    #[SerializedName('telcor')]
    private ?string $contactPhone;

    #[SerializedName('latitude')]
    private ?float $latitude;

    #[SerializedName('longitude')]
    private ?float $longitude;

    #[SerializedName('datevalidation')]
    private ?DateTimeImmutable $validatedAt;

    public function __construct(
        int $id,
        string $code,
        string $name,
        string $hallName,
        string $hallAddress1,
        ?string $hallAddress2,
        ?string $hallAddress3,
        string $hallPostalCode,
        string $hallCity,
        ?string $website,
        string $contactLastname,
        string $contactFirstname,
        ?string $contactMail,
        ?string $contactPhone,
        ?string $latitude,
        ?string $longitude,
        ?string $validatedAt
    ) {
        $this->id = empty($id) ? 0 : $id;
        $this->code = empty($code) ? '' : $code;
        $this->name = empty($name) ? '' : $name;
        $this->hallName = empty($hallName) ? '' : $hallName;
        $this->hallAddress1 = empty($hallAddress1) ? '' : $hallAddress1;
        $this->hallAddress2 = empty($hallAddress2) ? null : $hallAddress2;
        $this->hallAddress3 = empty($hallAddress3) ? null : $hallAddress3;
        $this->hallPostalCode = empty($hallPostalCode) ? '' : $hallPostalCode;
        $this->hallCity = empty($hallCity) ? '' : $hallCity;
        $this->website = empty($website) ? null : $website;
        $this->contactLastname = empty($contactLastname) ? '' : $contactLastname;
        $this->contactFirstname = empty($contactFirstname) ? '' : $contactFirstname;
        $this->contactMail = empty($contactMail) ? null : $contactMail;
        $this->contactPhone = empty($contactPhone) ? null : $contactPhone;
        $this->latitude = empty($latitude) ? null : (float) $latitude;
        $this->longitude = empty($longitude) ? null : (float) $longitude;
        $this->validatedAt = empty($validatedAt) ? null : DateTimeHelpers::createImmutable($validatedAt, 'd/m/Y');
    }

    public function id(): int
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function hallName(): string
    {
        return $this->hallName;
    }

    public function hallAddress1(): string
    {
        return $this->hallAddress1;
    }

    public function hallAddress2(): ?string
    {
        return $this->hallAddress2;
    }

    public function hallAddress3(): ?string
    {
        return $this->hallAddress3;
    }

    public function hallPostalCode(): string
    {
        return $this->hallPostalCode;
    }

    public function hallCity(): string
    {
        return $this->hallCity;
    }

    public function fullAddress(): string
    {
        $address = "{$this->hallName} - {$this->hallAddress1}";

        if ($this->hallAddress2) {
            $address .= " - {$this->hallAddress2}";
        }

        if ($this->hallAddress3) {
            $address .= " - {$this->hallAddress3}";
        }

        $address .= " - {$this->hallPostalCode} {$this->hallCity}";
        return $address;
    }

    public function website() : ?string
    {
        return $this->website;
    }

    public function contactLastname() : string
    {
        return $this->contactLastname;
    }

    public function contactFirstname() : string
    {
        return $this->contactFirstname;
    }

    public function contactMail() : ?string
    {
        return $this->contactMail;
    }

    public function contactPhone() : ?string
    {
        return $this->contactPhone;
    }

    public function latitude() : ?float
    {
        return $this->latitude;
    }

    public function longitude() : ?float
    {
        return $this->longitude;
    }

    public function validatedAt() : ?DateTimeImmutable
    {
        return $this->validatedAt;
    }
}
