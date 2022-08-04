<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Player;

use SmartpingApi\Enum\Gender;
use SmartpingApi\Enum\LicenceType;
use SmartpingApi\Model\SmartpingObject;

class PlayerDetails extends SmartpingObject
{
    private int $id;

    private string $licence;

    private string $lastname;

    private string $firstname;

    private string $clubCode;

    private string $clubName;

    private Gender $gender;

    private LicenceType $licenceType;
}
