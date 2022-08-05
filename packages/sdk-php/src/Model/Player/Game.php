<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Player;

use DateTimeImmutable;
use SmartpingApi\Enum\Gender;
use SmartpingApi\Helper\DateTimeHelpers;
use SmartpingApi\Model\SmartpingObject;
use SmartpingApi\Service\PlayerAPI;

class Game extends SmartpingObject
{
    private ?int $id = null;

    private ?string $licence = null;

    private ?string $opponentLicence = null;

    private bool $isVictory = false;

    private ?int $roundIndex = null;

    private ?int $contestCode = null;

    private DateTimeImmutable $date;

    private ?Gender $opponentGender = null;

    private string $opponentName = '';

    private ?float $pointsEarned = null;

    private ?float $contestCoefficient = null;

    private int $opponentPointsRank = 0;

    private ?string $contestName = null;

    private ?bool $isForfeit = null;

    public function __construct(
        ?RankedGame $rankedGame = null,
        ?SPIDGame $spidGame = null,
    ) {
        $this->date = DateTimeHelpers::createImmutable();

        if ($rankedGame) {
            $this->id = $rankedGame->id();
            $this->licence = $rankedGame->licence();
            $this->opponentLicence = $rankedGame->opponentLicence();
            $this->isVictory = $rankedGame->isVictory();
            $this->roundIndex = $rankedGame->roundIndex();
            $this->contestCode = $rankedGame->contestCode();
            $this->date = $rankedGame->date();
            $this->opponentGender = $rankedGame->opponentGender();
            $this->opponentName = $rankedGame->opponentName();
            $this->pointsEarned = $rankedGame->pointsEarned();
            $this->contestCoefficient = $rankedGame->contestCoefficient();
            $this->opponentPointsRank = $rankedGame->opponentPointsRank();
        }

        if ($spidGame) {
            $this->opponentName = $spidGame->opponentName();
            $this->opponentPointsRank = $spidGame->opponentPointsRank();
            $this->contestName = $spidGame->contestName();
            $this->isVictory = $spidGame->isVictory();
            $this->isForfeit = $spidGame->isForfeit();
            $this->date = $spidGame->date();
        }
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function licence(): ?string
    {
        return $this->licence;
    }

    public function opponentLicence(): ?string
    {
        return $this->opponentLicence;
    }

    public function isVictory(): bool
    {
        return $this->isVictory;
    }

    public function isForfeit(): ?bool
    {
        return $this->isForfeit;
    }

    public function roundIndex(): ?int
    {
        return $this->roundIndex;
    }

    public function contestCode(): ?int
    {
        return $this->contestCode;
    }

    public function date(): DateTimeImmutable
    {
        return $this->date;
    }

    public function opponentGender(): ?Gender
    {
        return $this->opponentGender;
    }

    public function opponentName(): string
    {
        return $this->opponentName;
    }

    public function pointsEarned(): ?float
    {
        return $this->pointsEarned;
    }

    public function contestCoefficient(): ?float
    {
        return $this->contestCoefficient;
    }

    public function opponentPointsRank(): int
    {
        return $this->opponentPointsRank;
    }

    public function player(): ?RankedPlayer
    {
        if (!$this->licence) {
            return null;
        }

        return PlayerAPI::getPlayerOnRankingBase($this->licence);
    }

    public function opponent(): ?RankedPlayer
    {
        if (!$this->opponentLicence) {
            return null;
        }

        return PlayerAPI::getPlayerOnRankingBase($this->opponentLicence);
    }

    public function contestName(): ?string
    {
        return $this->contestName;
    }
}
