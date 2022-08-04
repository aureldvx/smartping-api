<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Player;

use SmartpingApi\Model\SmartpingObject;
use Symfony\Component\Serializer\Annotation\SerializedName;

class PlayerRankHistory extends SmartpingObject
{
    #[SerializedName('echelon')]
    private string $level;

    #[SerializedName('place')]
    private int $rank;

    #[SerializedName('point')]
    private float $points;

    #[SerializedName('saison')]
    private string $season;

    #[SerializedName('phase')]
    private int $phase;

    public function __construct(
        string $level,
        string $rank,
        float $points,
        string $season,
        int $phase
    ) {
        $this->level = empty($level) ? '' : $level;
        $this->rank = empty($rank) ? 0 : (int) $rank;
        $this->points = $points;
        $this->season = $season;
        $this->phase = $phase;
    }

    public function level(): string
    {
        return $this->level;
    }

    public function rank(): int
    {
        return $this->rank;
    }

    public function points(): float
    {
        return $this->points;
    }

    public function season(): string
    {
        return $this->season;
    }

    public function phase(): int
    {
        return $this->phase;
    }
}
