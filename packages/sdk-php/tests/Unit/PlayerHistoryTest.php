<?php

declare(strict_types=1);

use SmartpingApi\Model\Player\PlayerRankHistory;
use SmartpingApi\Model\Player\RankedGame;
use SmartpingApi\SmartpingAPI;

uses()->group('player_history');

beforeEach(function() {
    $this->smartping = new SmartpingAPI('SW399', 'Sy2zMFb91P');
    $this->smartping->authenticate();
});

it('should return an array of history ranks for a given licence', function() {
    $result = $this->smartping->getPlayerRankHistory('1610533');
    expect($result)
        ->toBeArray()
        ->and($result)->not()->toHaveCount(0)
        ->and($result[0])->toBeInstanceOf(PlayerRankHistory::class);
});

it('should return an array of history games from ranking base for a given licence', function() {
    $result = $this->smartping->getPlayerGameHistoryOnRankingBase('1610533');
    expect($result)
        ->toBeArray()
        ->and($result)->not()->toHaveCount(0)
        ->and($result[0])->toBeInstanceOf(RankedGame::class);
});
