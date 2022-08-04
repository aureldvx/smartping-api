<?php

declare(strict_types=1);

use SmartpingApi\Model\Contest\Contest;
use SmartpingApi\Model\Contest\Division;
use SmartpingApi\Enum\ContestType;
use SmartpingApi\SmartpingAPI;

uses()->group('contest');

beforeEach(function() {
    $this->smartping = new SmartpingAPI('SW399', 'Sy2zMFb91P');
    $this->smartping->authenticate();
});

it('should return an array of contests', function() {
    $list = $this->smartping->findContests(1, ContestType::TEAM);
    expect($list)
        ->toBeArray()
        ->and($list)->not()->toHaveCount(0)
        ->and($list[0])->toBeInstanceOf(Contest::class);
});

it('should return an array of divisions for a given contest', function() {
    $list = $this->smartping->findDivisionsForContest(18, 8984, ContestType::INDIVIDUAL);
    expect($list)
        ->toBeArray()
        ->and($list)->not()->toHaveCount(0)
        ->and($list[0])->toBeInstanceOf(Division::class);
});

it('should return an array of divisions when access to divisions() member of contest', function() {
    $list = $this->smartping->findContests(18, ContestType::INDIVIDUAL);
    expect($list)
        ->toBeArray()
        ->and($list)->not()->toHaveCount(0)
        ->and($list[0])->toBeInstanceOf(Contest::class);

    $divisions = $list[0]->divisions();
    expect($divisions)
        ->toBeArray()
        ->and($divisions)->not()->toHaveCount(0)
        ->and($divisions[0])->toBeInstanceOf(Division::class);
});
