<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Common;

use SmartpingApi\Model\SmartpingObject;
use Symfony\Component\Serializer\Annotation\SerializedName;

class Initialization extends SmartpingObject
{
    #[SerializedName('appli')]
    private bool $authorized;

    public function __construct(int $authorized)
    {
        $this->authorized = (bool) $authorized;
    }

    public function authorized(): bool
    {
        return $this->authorized;
    }
}
