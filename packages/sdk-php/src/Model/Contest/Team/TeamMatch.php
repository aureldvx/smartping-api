<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Contest\Team;

use SmartpingApi\Model\SmartpingObject;
use SmartpingApi\Service\TeamContestAPI;
use Symfony\Component\Serializer\Annotation\SerializedName;

class TeamMatch extends SmartpingObject
{
    #[SerializedName('libelle')]
    private string $name;

    #[SerializedName('equa')]
    private string $teamNameA;

    #[SerializedName('equb')]
    private string $teamNameB;

    #[SerializedName('scorea')]
    private int $teamScoreA;

    #[SerializedName('scoreb')]
    private int $teamScoreB;

    #[SerializedName('lien')]
    private string $link;

    private int $id;

    /**
     * @var array{
     *     is_retour: bool,
     *     phase: int,
     *     res_1: int,
     *     res_2: int,
     *     equip_1: string,
     *     equip_2: string,
     *     equip_id1: int,
     *     equip_id2: int
     * } $paramsToAccessToDetails
     */
    private array $paramsToAccessToDetails;

    public function __construct(
        string $name,
        string $teamNameA,
        string $teamNameB,
        int $teamScoreA,
        int $teamScoreB,
        string $link
    ) {
        $this->name = empty($name) ? '' : $name;
        $this->teamNameA = empty($teamNameA) ? '' : $teamNameA;
        $this->teamNameB = empty($teamNameB) ? '' : $teamNameB;
        $this->teamScoreA = empty($teamScoreA) ? 0 : $teamScoreA;
        $this->teamScoreB = empty($teamScoreB) ? 0 : $teamScoreB;
        $this->link = empty($link) ? '' : $link;

        parse_str($link, $linkParts);

        $this->paramsToAccessToDetails = [
            'is_retour' => isset($linkParts['is_retour']) && $linkParts['is_retour'],
            'phase' => isset($linkParts['phase']) ? (int) $linkParts['phase'] : 0,
            'res_1' => isset($linkParts['res_1']) ? (int) $linkParts['res_1'] : 0,
            'res_2' => isset($linkParts['res_2']) ? (int) $linkParts['res_2'] : 0,
            'equip_1' => isset($linkParts['equip_1']) ? (string) $linkParts['equip_1'] : '0',
            'equip_2' => isset($linkParts['equip_2']) ? (string) $linkParts['equip_2'] : '0',
            'equip_id1' => isset($linkParts['equip_id1']) ? (int) $linkParts['equip_id1'] : 0,
            'equip_id2' => isset($linkParts['equip_id2']) ? (int) $linkParts['equip_id2'] : 0,
        ];
        $this->id = isset($linkParts['renc_id']) ? (int) $linkParts['renc_id'] : 0;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function teamNameA(): string
    {
        return $this->teamNameA;
    }

    public function teamNameB(): string
    {
        return $this->teamNameB;
    }

    public function teamScoreA(): int
    {
        return $this->teamScoreA;
    }

    public function teamScoreB(): int
    {
        return $this->teamScoreB;
    }

    public function link(): string
    {
        return $this->link;
    }

    public function details(): ?TeamMatchDetails
    {
        return TeamContestAPI::getTeamChampionshipMatch($this->id, $this->paramsToAccessToDetails);
    }
}
