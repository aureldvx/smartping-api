<?php

declare(strict_types=1);

use SmartpingApi\Model\Organization\Organization;
use SmartpingApi\Enum\OrganizationType;
use SmartpingApi\SmartpingAPI;

uses()->group('organization');

beforeEach(function() {
    $this->smartping = new SmartpingAPI('SW399', 'Sy2zMFb91P');
    $this->smartping->authenticate();
});

it('should return exactly 1 result for a federation query', function() {
    $list = $this->smartping->findOrganizationsByType(OrganizationType::FEDERATION);
    expect($list)
        ->toBeArray()
        ->and($list)->toHaveCount(1)
        ->and($list[0])->toBeInstanceOf(Organization::class);
});

it('should return exactly 7 results for a zone query', function() {
    $list = $this->smartping->findOrganizationsByType(OrganizationType::ZONE);
    expect($list)
        ->toBeArray()
        ->and($list)->toHaveCount(7)
        ->and($list[0])->toBeInstanceOf(Organization::class);
});

it('should return exactly 21 results for a league query', function() {
    $list = $this->smartping->findOrganizationsByType(OrganizationType::LEAGUE);
    expect($list)
        ->toBeArray()
        ->and($list)->toHaveCount(21)
        ->and($list[0])->toBeInstanceOf(Organization::class);
});

it('should return a result for a query with good orgType and orgId', function() {
    $result = $this->smartping->getOrganization(1);
    expect($result)->toBeInstanceOf(Organization::class);
});

it('should return the parent instance for organization with parentId', function() {
    $result = $this->smartping->getOrganization(131);
    expect($result)
        ->toBeInstanceOf(Organization::class)
        ->and($result->parentInstance())->toBeInstanceOf(Organization::class);
});

it('should return children instances for organization', function() {
    $result = $this->smartping->getOrganization(18);
    expect($result)->toBeInstanceOf(Organization::class);
    $children = $result->children();
    expect($children)
        ->toBeArray()
        ->and($children)->not()->toHaveCount(0)
        ->and($children[0])->toBeInstanceOf(Organization::class);
});
