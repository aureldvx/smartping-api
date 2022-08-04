<?php

declare(strict_types=1);

use SmartpingApi\Model\Player\PlayerDetails;
use SmartpingApi\SmartpingAPI;

uses()->group('player');

beforeEach(function() {
    $this->smartping = new SmartpingAPI('SW399', 'Sy2zMFb91P');
    $this->smartping->authenticate();
});

it('return a PlayerDetails object for a given licence', function() {
    $result = $this->smartping->getPlayer('1610533');
    expect($result)
        ->toBeInstanceOf(PlayerDetails::class)
        ->and($result->id())->toBe(649948);

    $club = $result->club();
    expect($club)
        ->not()->toBeNull()
        ->and($club->id())->toBe(20160051);
});

it('return null for a wrong licence', function() {
    $result = $this->smartping->getPlayer('0000000');
    expect($result)->toBeNull();
});
