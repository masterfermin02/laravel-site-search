<?php

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use MeiliSearch\Client;
use Spatie\SiteSearch\Drivers\MeiliSearchDriver;
use Spatie\SiteSearch\Indexers\DefaultIndexer;
use Spatie\SiteSearch\Profiles\DefaultSearchProfile;
use Spatie\SiteSearch\SiteSearch;

it('can test', function () {
    $client = new Client('http://127.0.0.1:7700');

    $search = new MeiliSearchDriver($client, 'my-index');

    $results = $search
      //->update()
        ->search('bla');

    dd($results);
});

it('fetches html', function () {
    $content = strip_tags(file_get_contents('https://spatie.be'));

    $entries = array_map('trim', explode(PHP_EOL, $content));

    $entries = array_filter($entries);

    dd($entries);
});

it('has an indexer', function () {
    $body = file_get_contents('https://spatie.be');

    $indexer = new DefaultIndexer(
        new Uri('https://spatie.be'),
        new Response(body: $body),
    );

    dd($indexer->title(), $indexer->entries());
});

it('can crawl a site', function () {
    $client = new Client('http://127.0.0.1:7700');

    $driver = new MeiliSearchDriver($client, 'my-index');

    $driver->delete();

    $driver->create();

    $profile = new DefaultSearchProfile();

    $siteSearch = new SiteSearch($driver, $profile);

    $siteSearch->crawl('https://spatie.be');
});

it('can search', function() {
    $client = new Client('http://127.0.0.1:7700');

    $driver = new MeiliSearchDriver($client, 'my-index');

    $profile = new DefaultSearchProfile();

    $siteSearch = new SiteSearch($driver, $profile);

    dd($siteSearch->search('willem'));
});


