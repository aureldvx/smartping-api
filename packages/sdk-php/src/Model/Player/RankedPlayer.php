<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Player;

use SmartpingApi\Model\SmartpingObject;
use SmartpingApi\Service\PlayerAPI;
use Symfony\Component\Serializer\Annotation\SerializedName;

class RankedPlayer extends SmartpingObject
{
    #[SerializedName('licence')]
    private string $licence;

    #[SerializedName('nom')]
    private string $lastname;

    #[SerializedName('prenom')]
    private string $firstname;

    #[SerializedName('club')]
    private string $clubName;

    #[SerializedName('nclub')]
    private string $clubCode;

    #[SerializedName('clast')]
    private int $pointsRank;

    public function __construct(
        string $licence,
        string $lastname,
        string $firstname,
        string $clubName,
        string $clubCode,
        string $pointsRank
    ) {
        $this->licence = empty($licence) ? '' : $licence;
        $this->lastname = empty($lastname) ? '' : $lastname;
        $this->firstname = empty($firstname) ? '' : $firstname;
        $this->clubName = empty($clubName) ? '' : $clubName;
        $this->clubCode = empty($clubCode) ? '' : $clubCode;
        $this->pointsRank = empty($pointsRank) ? 0 : (int) $pointsRank;
    }

    public function licence(): string
    {
        return $this->licence;
    }

    public function lastname(): string
    {
        return $this->lastname;
    }

    public function firstname(): string
    {
        return $this->firstname;
    }

    public function clubName(): string
    {
        return $this->clubName;
    }

    public function clubCode(): string
    {
        return $this->clubCode;
    }

    public function pointsRank(): int
    {
        return $this->pointsRank;
    }

    public function details(): ?PlayerDetails
    {
        return PlayerAPI::getPlayer($this->licence);
    }

    /**
     * @return array{
     *     licence: string,
     *     lastname: string,
     *     firstname: string,
     *     clubName: string,
     *     clubCode: string,
     *     pointsRank: int
     * }
     */
    public function normalize(): array
    {
        return [
            'licence' => $this->licence,
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'clubName' => $this->clubName,
            'clubCode' => $this->clubCode,
            'pointsRank' => $this->pointsRank,
        ];
    }
}
