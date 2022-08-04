<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Club;

use DateTimeImmutable;
use SmartpingApi\Enum\ClubType;
use SmartpingApi\Helper\DateTimeHelpers;
use SmartpingApi\Model\SmartpingObject;
use SmartpingApi\Service\ClubAPI;
use Symfony\Component\Serializer\Annotation\SerializedName;

class Club extends SmartpingObject
{
    #[SerializedName('idclub')]
    private int $id;

    #[SerializedName('numero')]
    private string $code;

    #[SerializedName('nom')]
    private string $name;

    #[SerializedName('validation')]
    private ?DateTimeImmutable $validatedAt;

    #[SerializedName('typeclub')]
    private ClubType $type;

    public function __construct(
        int $id,
        string $code,
        string $name,
        string $validatedAt,
        string $type
    ) {
        $this->id = empty($id) ? 0 : $id;
        $this->code = empty($code) ? '' : $code;
        $this->name = empty($name) ? '' : $name;
        $this->validatedAt = empty($validatedAt) ? null : DateTimeHelpers::createImmutable($validatedAt, 'd/m/y');
        $this->type = empty($type) ? ClubType::UNRESTRICTED : ClubType::from($type);
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

    public function validatedAt(): ?DateTimeImmutable
    {
        return $this->validatedAt;
    }

    public function type(): ClubType
    {
        return $this->type;
    }

    public function details(): ?ClubDetail
    {
        return ClubAPI::getClub($this->code);
    }
}
