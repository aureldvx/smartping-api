<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Contest;

use SmartpingApi\Enum\ContestType;
use SmartpingApi\Model\SmartpingObject;
use SmartpingApi\Service\ContestAPI;
use SmartpingApi\Service\OrganizationAPI;
use Symfony\Component\Serializer\Annotation\SerializedName;

class Contest extends SmartpingObject
{
    #[SerializedName('idepreuve')]
    private int $id;

    #[SerializedName('idorga')]
    private int $organizerId;

    #[SerializedName('libelle')]
    private string $name;

    #[SerializedName('typepreuve')]
    private ContestType $type;

    public function __construct(
        int $id,
        int $organizerId,
        string $name,
        string $type,
    ) {
        $this->id = empty($id) ? 0 : $id;
        $this->organizerId = empty($organizerId) ? 1 : $organizerId;
        $this->name = empty($name) ? '' : $name;
        $this->type = empty($type) ? ContestType::TEAM : ContestType::from($type);
    }

    public function id(): int
    {
        return $this->id;
    }

    public function organizerId(): int
    {
        return $this->organizerId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function type(): ContestType
    {
        return $this->type;
    }

    /**
     * @return Division[]
     */
    public function divisions(): array
    {
        $normalizedType = match($this->type) {
            ContestType::INDIVIDUAL, ContestType::CHAMPIONSHIP => ContestType::INDIVIDUAL,
            ContestType::TEAM, ContestType::MEN => ContestType::TEAM,
        };
        $organization = OrganizationAPI::getOrganization($this->organizerId);

        if (is_null($organization)) {
            return [];
        }

        $search = ContestAPI::findDivisionsForContest($organization->id(), $this->id, $normalizedType);

        if (count($search) > 0) {
            return $search;
        }

        $parentOrganization = $organization->parentInstance();
        if ($parentOrganization) {
            $search = ContestAPI::findDivisionsForContest($parentOrganization->id(), $this->id, $normalizedType);

            if (count($search) > 0) {
                return $search;
            }
        }

        return [];
    }
}
