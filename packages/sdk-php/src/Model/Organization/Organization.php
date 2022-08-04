<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Organization;

use SmartpingApi\Enum\OrganizationType;
use SmartpingApi\Model\SmartpingObject;
use SmartpingApi\Service\OrganizationAPI;
use Symfony\Component\Serializer\Annotation\SerializedName;

class Organization extends SmartpingObject
{
    #[SerializedName('id')]
    private int $id;

    #[SerializedName('libelle')]
    private string $name;

    #[SerializedName('code')]
    private string $code;

    #[SerializedName('idPere')]
    private ?int $parentId;

    private OrganizationType $type;

    public function __construct(
        int $id,
        string $name,
        string $code,
        string $parentId
    ) {
        $this->id = empty($id) ? 0 : $id;
        $this->name = empty($name) ? '' : $name;
        $this->code = empty($code) ? '' : $code;
        $this->parentId = empty($parentId) ? null : (int) $parentId;
        $this->type = OrganizationType::from(substr($this->code(), 0, 1));
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function parentId(): ?int
    {
        return $this->parentId;
    }

    public function parentInstance(): ?self
    {
        if (is_null($this->parentId)) {
            return null;
        }

        return OrganizationAPI::getOrganization($this->parentId);
    }

    /**
     * @return self[]|null
     */
    public function children(): ?array
    {
        return OrganizationAPI::getOrganizationChildren($this->id);
    }

    public function normalize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'parentId' => $this->parentId ? (string) $this->parentId : '',
            'type' => $this->type->value,
        ];
    }
}
