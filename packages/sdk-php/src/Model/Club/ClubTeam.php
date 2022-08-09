<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Club;

use SmartpingApi\Enum\ContestType;
use SmartpingApi\Model\Contest\Contest;
use SmartpingApi\Model\Contest\Division;
use SmartpingApi\Model\Contest\Team\TeamPool;
use SmartpingApi\Model\Organization\Organization;
use SmartpingApi\Model\SmartpingObject;
use SmartpingApi\Service\ContestAPI;
use SmartpingApi\Service\OrganizationAPI;
use SmartpingApi\Service\TeamContestAPI;
use Symfony\Component\Serializer\Annotation\SerializedName;

class ClubTeam extends SmartpingObject
{
    #[SerializedName('idequipe')]
    private int $id;

    #[SerializedName('libequipe')]
    private string $name;

    #[SerializedName('idepr')]
    private int $contestId;

    #[SerializedName('libepr')]
    private string $contestName;

    #[SerializedName('libdivision')]
    private string $divisionName;

    #[SerializedName('liendivision')]
    private string $divisionLink;

    private int $poolId;

    private int $divisionId;

    private int $organizerId;

    public function __construct(
        int $id,
        string $name,
        int $contestId,
        string $contestName,
        string $divisionName,
        string $divisionLink
    ) {
        $this->id = empty($id) ? 0 : $id;
        $this->name = empty($name) ? '' : $name;
        $this->contestId = empty($contestId) ? 0 : $contestId;
        $this->contestName = empty($contestName) ? '' : $contestName;
        $this->divisionName = empty($divisionName) ? '' : $divisionName;
        $this->divisionLink = empty($divisionLink) ? '' : $divisionLink;

        parse_str($divisionLink, $linkParts);

        $this->poolId = isset($linkParts['cx_poule']) ? (int) $linkParts['cx_poule'] : 0;
        $this->divisionId = isset($linkParts['D1']) ? (int) $linkParts['D1'] : 0;
        $this->organizerId = isset($linkParts['organisme_pere']) ? (int) $linkParts['organisme_pere'] : 0;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function contestId(): int
    {
        return $this->contestId;
    }

    public function contestName(): string
    {
        return $this->contestName;
    }

    public function divisionName(): string
    {
        return $this->divisionName;
    }

    public function divisionLink(): string
    {
        return $this->divisionLink;
    }

    public function poolId(): int
    {
        return $this->poolId;
    }

    public function divisionId(): int
    {
        return $this->divisionId;
    }

    public function organizerId(): int
    {
        return $this->organizerId;
    }

    public function contest(): ?Contest
    {
        $result = ContestAPI::findContests($this->organizerId, ContestType::TEAM);

        if (empty($result)) {
            return null;
        }

        $found = array_filter($result, fn ($c) => $c->id() === $this->contestId);
        $found = array_values($found);

        if (empty($found)) {
            return null;
        }

        return $found[0];
    }

    public function division(): ?Division
    {
        $result = ContestAPI::findDivisionsForContest($this->organizerId, $this->contestId, ContestType::TEAM);

        if (empty($result)) {
            return null;
        }

        $found = array_filter($result, fn ($c) => $c->id() === $this->divisionId);
        $found = array_values($found);

        if (empty($found)) {
            return null;
        }

        return $found[0];
    }

    public function pool(): ?TeamPool
    {
        $result = TeamContestAPI::getTeamChampionshipPoolsForDivision($this->divisionId);

        if (empty($result)) {
            return null;
        }

        $found = array_filter($result, fn ($c) => $c->id() === $this->poolId);
        $found = array_values($found);

        if (empty($found)) {
            return null;
        }

        return $found[0];
    }

    public function organizer(): ?Organization
    {
        return OrganizationAPI::getOrganization($this->organizerId);
    }
}
