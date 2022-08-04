<?php

declare(strict_types=1);

use SmartpingApi\Model\Player\Player;
use SmartpingApi\SmartpingAPI;

uses()->group('player_list');

beforeEach(function() {
    $this->smartping = new SmartpingAPI('SW399', 'Sy2zMFb91P');
    $this->smartping->authenticate();
});

it('should return an array or results for a given lastname', function() {
    $result = $this->smartping->findPlayersByName('devaux');
    expect($result)
        ->toBeArray()
        ->and($result)->not()->toHaveCount(0)
        ->and($result[0])->toBeInstanceOf(Player::class);
});

it('should return an array or results for a given lastname and firstname', function() {
    $result = $this->smartping->findPlayersByName('devaux', 'aurelien');
    expect($result)
        ->toBeArray()
        ->and($result)->not()->toHaveCount(0)
        ->and($result[0])->toBeInstanceOf(Player::class);
});

it('should return an array or results for a given lastname (only licensed for the current season)', function() {
    $result = $this->smartping->findPlayersByName('devaux', null , true);
    expect($result)
        ->toBeArray()
        ->and($result)->not()->toHaveCount(0)
        ->and($result[0])->toBeInstanceOf(Player::class);
});

it('should return an array or results for a given club', function() {
    $result = $this->smartping->findPlayersByClub('10160051');
    expect($result)
        ->toBeArray()
        ->and($result)->not()->toHaveCount(0)
        ->and($result[0])->toBeInstanceOf(Player::class);
});

it('should return an array or results for a given club (only licensed for the current season)', function() {
    $result = $this->smartping->findPlayersByClub('10160051', true);
    expect($result)
        ->toBeArray()
        ->and($result)->not()->toHaveCount(0)
        ->and($result[0])->toBeInstanceOf(Player::class);
});
