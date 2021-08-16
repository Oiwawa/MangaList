<?php

namespace App\Service;
use Jikan\MyAnimeList\MalClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService {

    private $client;

    /**
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getMangaData()
    {

        return  $stats;
    }
}