<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Player;

use DateTimeImmutable;
use SmartpingApi\Enum\Gender;
use SmartpingApi\Helper\DateTimeHelpers;
use SmartpingApi\Model\SmartpingObject;
use SmartpingApi\Service\PlayerAPI;
use Symfony\Component\Serializer\Annotation\SerializedName;

class RankedGame extends SmartpingObject
{
    #[SerializedName('idpartie')]
    private int $id;

    #[SerializedName('licence')]
    private string $licence;

    #[SerializedName('advlic')]
    private string $opponentLicence;

    #[SerializedName('vd')]
    private bool $isVictory;

    #[SerializedName('numjourn')]
    private int $roundIndex;

    #[SerializedName('codechamp')]
    private int $contestCode;

    #[SerializedName('date')]
    private DateTimeImmutable $date;

    #[SerializedName('advsexe')]
    private Gender $opponentGender;

    #[SerializedName('advnompre')]
    private string $opponentName;

    #[SerializedName('pointres')]
    private float $pointsEarned;

    #[SerializedName('coefchamp')]
    private float $contestCoefficient;

    #[SerializedName('advclaof')]
    private int $opponentPointsRank;

    public function __construct(
        string $id,
        string $licence,
        string $opponentLicence,
        string $isVictory,
        string $roundIndex,
        string $contestCode,
        string $date,
        string $opponentGender,
        string $opponentName,
        string $pointsEarned,
        string $contestCoefficient,
        string $opponentPointsRank
    ) {
        $this->id = empty($id) ? 0 : (int) $id;
        $this->licence = empty($licence) ? '' : $licence;
        $this->opponentLicence = empty($opponentLicence) ? '' : $opponentLicence;
        $this->isVictory = !empty($isVictory) && $isVictory === 'V';
        $this->roundIndex = empty($roundIndex) ? 0 : (int) $roundIndex;
        $this->contestCode = empty($contestCode) ? 0 : (int) $contestCode;
        $this->date = empty($date) ? DateTimeHelpers::createImmutable() : DateTimeHelpers::createImmutable($date, 'd/m/Y');
        $this->opponentGender = empty($opponentGender) ? Gender::UNDEFINED : Gender::from($opponentGender);
        $this->opponentName = empty($opponentName) ? '' : $opponentName;
        $this->pointsEarned = empty($pointsEarned) ? 0.0 : (float) $pointsEarned;
        $this->contestCoefficient = empty($contestCoefficient) ? 0.0 : (float) $contestCoefficient;
        $this->opponentPointsRank = empty($opponentPointsRank) ? 0 : (int) $opponentPointsRank;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function licence(): string
    {
        return $this->licence;
    }

    public function opponentLicence(): string
    {
        return $this->opponentLicence;
    }

    public function isVictory(): bool
    {
        return $this->isVictory;
    }

    public function roundIndex(): int
    {
        return $this->roundIndex;
    }

    public function contestCode(): int
    {
        return $this->contestCode;
    }

    public function date(): DateTimeImmutable
    {
        return $this->date;
    }

    public function opponentGender(): Gender
    {
        return $this->opponentGender;
    }

    public function opponentName(): string
    {
        return $this->opponentName;
    }

    public function pointsEarned(): float
    {
        return $this->pointsEarned;
    }

    public function contestCoefficient(): float
    {
        return $this->contestCoefficient;
    }

    public function opponentPointsRank(): int
    {
        return $this->opponentPointsRank;
    }

    public function player(): ?RankedPlayer
    {
        return PlayerAPI::getPlayerOnRankingBase($this->licence);
    }

    public function opponent(): ?RankedPlayer
    {
        return PlayerAPI::getPlayerOnRankingBase($this->opponentLicence);
    }
}
