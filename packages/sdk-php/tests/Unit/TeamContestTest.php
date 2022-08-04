<?php

declare(strict_types=1);

use SmartpingApi\SmartpingAPI;

uses()->group('team_contest');

beforeEach(function() {
    $this->smartping = new SmartpingAPI('SW399', 'Sy2zMFb91P');
    $this->smartping->authenticate();
});

// it('should return an array of contests', function() {
//     $list = $this->smartping->findContests(1, ContestType::TEAM);
//     expect($list)
//         ->toBeArray()
//         ->and($list)->not()->toHaveCount(0)
//         ->and($list[0])->toBeInstanceOf(Contest::class);
// });
