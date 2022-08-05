<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Player;

use SmartpingApi\Enum\Gender;
use SmartpingApi\Model\SmartpingObject;
use SmartpingApi\Service\PlayerAPI;
use Symfony\Component\Serializer\Annotation\SerializedName;

class SPIDPlayer extends SmartpingObject
{
    #[SerializedName('licence')]
    private string $licence;

    #[SerializedName('nom')]
    private string $lastname;

    #[SerializedName('prenom')]
    private string $firstname;

    #[SerializedName('nclub')]
    private string $clubName;

    #[SerializedName('club')]
    private string $clubCode;

    #[SerializedName('sexe')]
    private Gender $gender;

    #[SerializedName('echelon')]
    private string $level;

    #[SerializedName('place')]
    private int $place;

    #[SerializedName('points')]
    private float $points;

    public function __construct(
        string $licence,
        string $lastname,
        string $firstname,
        string $clubName,
        string $clubCode,
        string $gender,
        string $level,
        string $place,
        string $points
    ) {
        $this->licence = empty($licence) ? '' : $licence;
        $this->lastname = empty($lastname) ? '' : $lastname;
        $this->firstname = empty($firstname) ? '' : $firstname;
        $this->clubName = empty($clubName) ? '' : $clubName;
        $this->clubCode = empty($clubCode) ? '' : $clubCode;
        $this->gender = empty($gender) ? Gender::UNDEFINED : Gender::from($gender);
        $this->level = empty($level) ? '' : $level;
        $this->place = empty($place) ? 0 : (int) $place;
        $this->points = empty($points) ? 0.0 : (float) $points;
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

    public function gender(): Gender
    {
        return $this->gender;
    }

    public function level(): string
    {
        return $this->level;
    }

    public function place(): int
    {
        return $this->place;
    }

    public function points(): float
    {
        return $this->points;
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
     *     gender: string,
     *     level: string,
     *     place: int,
     *     points: float
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
            'gender' => $this->gender->value,
            'level' => $this->level,
            'place' => $this->place,
            'points' => $this->points
        ];
    }
}
