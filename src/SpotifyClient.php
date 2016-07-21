<?php
/**
 * Created by PhpStorm.
 * User: crwgr
 * Date: 7/20/2016
 * Time: 3:03 PM
 */

namespace Crwgregory\SpotifyTrackSuggester;


use GuzzleHttp\Client;

class SpotifyClient
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * SpotifyClient constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.spotify.com/v1/'
        ]);
    }

    public function get($endpoint = '', $options = []) {
        return $this->client->get($endpoint, $options);
    }

    public function getAsync($endpoint = '', $options = []) {
        return $this->client->getAsync($endpoint, $options);
    }
}