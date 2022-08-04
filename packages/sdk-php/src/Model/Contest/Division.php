<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Contest;

use SmartpingApi\Model\SmartpingObject;
use Symfony\Component\Serializer\Annotation\SerializedName;

class Division extends SmartpingObject
{
    #[SerializedName('iddivision')]
    private int $id;

    #[SerializedName('libelle')]
    private string $name;

    public function __construct(
        int $id,
        string $name,
    ) {
        $this->id = empty($id) ? 0 : $id;
        $this->name = empty($name) ? '' : $name;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}
