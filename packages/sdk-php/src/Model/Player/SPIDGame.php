<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Player;

use DateTimeImmutable;
use SmartpingApi\Helper\DateTimeHelpers;
use SmartpingApi\Model\SmartpingObject;
use Symfony\Component\Serializer\Annotation\SerializedName;

class SPIDGame extends SmartpingObject
{
    #[SerializedName('nom')]
    private string $opponentName;

    #[SerializedName('classement')]
    private int $opponentPointsRank;

    #[SerializedName('epreuve')]
    private string $contestName;

    #[SerializedName('victoire')]
    private bool $isVictory;

    #[SerializedName('forfait')]
    private bool $isForfeit;

    #[SerializedName('date')]
    private DateTimeImmutable $date;

    public function __construct(
        string $opponentName,
        string $opponentPointsRank,
        string $contestName,
        string $isVictory,
        string $isForfeit,
        string $date
    ) {
        $this->opponentName = empty($opponentName) ? '' : $opponentName;
        $this->opponentPointsRank = empty($opponentPointsRank) ? 0 : (int) $opponentPointsRank;
        $this->contestName = empty($contestName) ? '' : $contestName;
        $this->isVictory = !empty($isVictory) && $isVictory === 'V';
        $this->isForfeit = !empty($isForfeit) && $isForfeit === '1';
        $this->date = empty($date) ? DateTimeHelpers::createImmutable() : DateTimeHelpers::createImmutable($date, 'd/m/Y');
    }

    public function opponentName(): string
    {
        return $this->opponentName;
    }

    public function opponentPointsRank(): int
    {
        return $this->opponentPointsRank;
    }

    public function contestName(): string
    {
        return $this->contestName;
    }

    public function isVictory(): bool
    {
        return $this->isVictory;
    }

    public function isForfeit(): bool
    {
        return $this->isForfeit;
    }

    public function date(): DateTimeImmutable
    {
        return $this->date;
    }
}
