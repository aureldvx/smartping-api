<?php

declare(strict_types=1);

use SmartpingApi\Model\Common\News;
use SmartpingApi\SmartpingAPI;

uses()->group('common');

beforeEach(function() {
    $this->smartping = new SmartpingAPI('SW399', 'Sy2zMFb91P');
});

it('should return true when authenticate', function () {
    expect($this->smartping->authenticate())->toBeTrue();
});

it('should return a list of all articles from federation', function() {
    $news = $this->smartping->getFederationNewsFeed();
    expect($news)
        ->toBeArray()
        ->and($news)->not()->toHaveCount(0)
        ->and($news[0])->toBeInstanceOf(News::class);
});
