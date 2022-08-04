<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Contest\Team;

use SmartpingApi\Model\SmartpingObject;
use SmartpingApi\Service\TeamContestAPI;
use Symfony\Component\Serializer\Annotation\SerializedName;

class TeamPool extends SmartpingObject
{
    #[SerializedName('lien')]
    private string $link;

    #[SerializedName('libelle')]
    private string $name;

    private int $id;

    private int $divisionId;

    public function __construct(
        string $link,
        string $name
    ) {
        $this->link = empty($link) ? '' : $link;
        $this->name = empty($name) ? '' : $name;

        parse_str($link, $linkParts);

        $this->id = isset($linkParts['cx_poule']) ? (int) $linkParts['cx_poule'] : 0;
        $this->divisionId = isset($linkParts['D1']) ? (int) $linkParts['D1'] : 0;
    }

    public function link(): string
    {
        return $this->link;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function divisionId(): int
    {
        return $this->divisionId;
    }

    /**
     * @return TeamMatch[]
     */
    public function matches(): array
    {
        return TeamContestAPI::getTeamChampionshipMatchesForPool($this->divisionId, $this->id);
    }

    /**
     * @return TeamPoolRank[]
     */
    public function ranking(): array
    {
        return TeamContestAPI::getTeamChampionshipPoolRanking($this->divisionId, $this->id);
    }
}
