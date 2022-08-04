<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Contest\Team;

use SmartpingApi\Model\Club\ClubDetail;
use SmartpingApi\Model\SmartpingObject;
use SmartpingApi\Service\ClubAPI;
use Symfony\Component\Serializer\Annotation\SerializedName;

class TeamPoolRank extends SmartpingObject
{
    #[SerializedName('poule')]
    private string $poolName;

    #[SerializedName('clt')]
    private int $rank;

    #[SerializedName('equipe')]
    private string $teamName;

    #[SerializedName('joue')]
    private int $totalPlayed;

    #[SerializedName('pts')]
    private int $score;

    #[SerializedName('numero')]
    private string $clubCode;

    public function __construct(
        string $poolName,
        int $rank,
        string $teamName,
        int $totalPlayed,
        int $score,
        string $clubCode
    ) {
        $this->poolName = empty($poolName) ? '' : $poolName;
        $this->rank = empty($rank) ? 0 : $rank;
        $this->teamName = empty($teamName) ? '' : $teamName;
        $this->totalPlayed = empty($totalPlayed) ? 0 : $totalPlayed;
        $this->score = empty($score) ? 0 : $score;
        $this->clubCode = empty($clubCode) ? '' : $clubCode;
    }

    public function poolName(): string
    {
        return $this->poolName;
    }

    public function rank(): int
    {
        return $this->rank;
    }

    public function teamName(): string
    {
        return $this->teamName;
    }

    public function totalPlayed(): int
    {
        return $this->totalPlayed;
    }

    public function score(): int
    {
        return $this->score;
    }

    public function clubCode(): string
    {
        return $this->clubCode;
    }

    public function club(): ?ClubDetail
    {
        return ClubAPI::getClub($this->clubCode);
    }
}
