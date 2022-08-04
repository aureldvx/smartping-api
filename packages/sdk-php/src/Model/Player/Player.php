<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Player;

use SmartpingApi\Enum\Gender;
use SmartpingApi\Model\SmartpingObject;

class Player extends SmartpingObject
{
    private string $licence;

    private string $lastname;

    private string $firstname;

    private string $clubName;

    private string $clubCode;

    private ?Gender $gender;

    private ?string $level;

    private ?int $place;

    private ?float $points;

    private ?int $pointsRank;

    public function __construct(
        ?SPIDPlayer $spidPlayer = null,
        ?RankedPlayer $rankedPlayer = null
    ) {
        $this->licence = $spidPlayer?->licence() ?? $rankedPlayer?->licence() ?? '';
        $this->firstname = $spidPlayer?->firstname() ?? $rankedPlayer?->firstname() ?? '';
        $this->lastname = $spidPlayer?->lastname() ?? $rankedPlayer?->lastname() ?? '';
        $this->clubName = $spidPlayer?->clubName() ?? $rankedPlayer?->clubName() ?? '';
        $this->clubCode = $spidPlayer?->clubCode() ?? $rankedPlayer?->clubCode() ?? '';
        $this->gender = $spidPlayer && in_array($spidPlayer->gender(), [Gender::MAN, Gender::WOMAN]) ? $spidPlayer->gender() : null;
        $this->level = $spidPlayer && !empty($spidPlayer->level()) ? $spidPlayer->level() : null;
        $this->place = $spidPlayer && !empty($spidPlayer->place()) ? $spidPlayer->place() : null;
        $this->points = $spidPlayer && !empty($spidPlayer->points()) ? $spidPlayer->points() : null;
        $this->pointsRank = $rankedPlayer?->pointsRank();
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

    public function gender(): ?Gender
    {
        return $this->gender;
    }

    public function level(): ?string
    {
        return $this->level;
    }

    public function place(): ?int
    {
        return $this->place;
    }

    public function points(): ?float
    {
        return $this->points;
    }

    public function pointsRank(): ?int
    {
        return $this->pointsRank;
    }

    /**
     * @return array{
     *     licence: string,
     *     lastname: string,
     *     firstname: string,
     *     clubName: string,
     *     clubCode: string,
     *     gender: string|null,
     *     level: string|null,
     *     place: int|null,
     *     points: float|null,
     *     pointsRank: int|null
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
            'gender' => $this->gender?->value,
            'level' => $this->level,
            'place' => $this->place,
            'points' => $this->points,
            'pointsRank' => $this->pointsRank
        ];
    }
}
