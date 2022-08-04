<?php

declare(strict_types=1);

use SmartpingApi\Model\Player\Player;
use SmartpingApi\SmartpingAPI;

uses()->group('player');

beforeEach(function() {
    $this->smartping = new SmartpingAPI('SW399', 'Sy2zMFb91P');
    $this->smartping->authenticate();
});

it('', function() {
    $result = $this->smartping->findPlayersByName('devaux');
    expect($result)
        ->toBeArray()
        ->and($result)->not()->toHaveCount(0)
        ->and($result[0])->toBeInstanceOf(Player::class);
})->skip();
