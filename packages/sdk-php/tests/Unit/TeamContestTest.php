<?php

declare(strict_types=1);

use SmartpingApi\Model\Contest\Team\TeamMatch;
use SmartpingApi\Model\Contest\Team\TeamMatchDetails;
use SmartpingApi\Model\Contest\Team\TeamPool;
use SmartpingApi\Model\Contest\Team\TeamPoolRank;
use SmartpingApi\SmartpingAPI;

uses()->group('team_contest');

beforeEach(function() {
    $this->smartping = new SmartpingAPI('SW399', 'Sy2zMFb91P');
    $this->smartping->authenticate();
});

it('should return an array of pools for a given division of team championship', function() {
    $list = $this->smartping->getTeamChampionshipPoolsForDivision(20894);
    expect($list)
        ->toBeArray()
        ->and($list)->not()->toHaveCount(0)
        ->and($list[0])->toBeInstanceOf(TeamPool::class)
        ->and($list[0]->divisionId())->toBe(20894);
})->skip();

it('should return an array of matches for a given division and pool of team championship', function() {
    $list = $this->smartping->getTeamChampionshipMatchesForPool(20894);
    expect($list)
        ->toBeArray()
        ->and($list)->not()->toHaveCount(0)
        ->and($list[0])->toBeInstanceOf(TeamMatch::class);
})->skip();

it('should return an array of ranks for a given division and pool of team championship', function() {
    $list = $this->smartping->getTeamChampionshipPoolRanking(20894);
    expect($list)
        ->toBeArray()
        ->and($list)->not()->toHaveCount(0)
        ->and($list[0])->toBeInstanceOf(TeamPoolRank::class);
})->skip();

it('should return a match for a given match id', function() {
    $result = $this->smartping->getTeamChampionshipMatch(20894);
    expect($result)->toBeInstanceOf(TeamMatchDetails::class);
})->skip();
