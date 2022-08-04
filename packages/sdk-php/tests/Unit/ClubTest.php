<?php

declare(strict_types=1);

use SmartpingApi\Model\Club\Club;
use SmartpingApi\Model\Club\ClubDetail;
use SmartpingApi\SmartpingAPI;

uses()->group('club');

beforeEach(function() {
    $this->smartping = new SmartpingAPI('SW399', 'Sy2zMFb91P');
});

it('should return a list of clubs for a department', function() {
    $list = $this->smartping->findClubsByDepartment('16');
    expect($list)
        ->toBeArray()
        ->and($list)->not()->toHaveCount(0)
        ->and($list[0])->toBeInstanceOf(Club::class);
});

it('should return a list of clubs for a postal code (with only one result)', function() {
    $list = $this->smartping->findClubsByPostalCode('16120');
    expect($list)
        ->toBeArray()
        ->and($list)->toHaveCount(1)
        ->and($list[0])->toBeInstanceOf(Club::class);
});

it('should return a list of clubs for a postal code (with multiple results)', function() {
    $list = $this->smartping->findClubsByPostalCode('33000');
    expect($list)
        ->toBeArray()
        ->and($list)->toHaveCount(3)
        ->and($list[0])->toBeInstanceOf(Club::class);
});

it('should return a list of clubs for a given city (with one result)', function() {
    $list = $this->smartping->findClubsByCity('angouleme');
    expect($list)
        ->toBeArray()
        ->and($list)->toHaveCount(1)
        ->and($list[0])->toBeInstanceOf(Club::class);
});

it('should return a list of clubs for a given city (with multiple result)', function() {
    $list = $this->smartping->findClubsByCity('bordeaux');
    expect($list)
        ->toBeArray()
        ->and($list)->toHaveCount(5)
        ->and($list[0])->toBeInstanceOf(Club::class);
});

it('should return a list of clubs for a given name (with one result)', function() {
    $list = $this->smartping->findClubsByName('castelnovien');
    expect($list)
        ->toBeArray()
        ->and($list)->toHaveCount(1)
        ->and($list[0])->toBeInstanceOf(Club::class);
});

it('should return a list of clubs for a given name (with multiple result)', function() {
    $list = $this->smartping->findClubsByName('chateauneuf');
    expect($list)
        ->toBeArray()
        ->and($list)->toHaveCount(6)
        ->and($list[0])->toBeInstanceOf(Club::class);
});

it('should return a club for a given code', function() {
    $result = $this->smartping->getClub('10160051');
    expect($result)->toBeInstanceOf(ClubDetail::class);
});

it('should return null for a invalid given code', function() {
    $result = $this->smartping->getClub('10169951');
    expect($result)->toBeNull();
});

it('should return details for a club found with a find method', function() {
    $list = $this->smartping->findClubsByName('castelnovien');
    expect($list)
        ->toBeArray()
        ->and($list)->toHaveCount(1)
        ->and($list[0])->toBeInstanceOf(Club::class);
    $details = $list[0]->details();
    expect($details)->toBeInstanceOf(ClubDetail::class);
});
