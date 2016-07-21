<?php

namespace Crwgregory\SpotifyTrackSuggester\Controller;


use Crwgregory\SpotifyTrackSuggester\Model\Attributes;
use Crwgregory\SpotifyTrackSuggester\Model\Feature;
use Crwgregory\SpotifyTrackSuggester\SpotifyClient;
use GuzzleHttp\Client;
use Pagekit\Application as App;
use KMeans\Space;
use GuzzleHttp\Promise;

class ApiController
{

    /**
     * @var SpotifyClient
     */
    protected $spotifyClient;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->guzzle = new Client();
        $this->spotifyClient = new SpotifyClient();
    }

    /**
     * @Route("/", methods="POST")
     * @Request({"token" = "string", "tracks" = "array", "groups" = "int", "buffer" = "float"})
     */
    function suggestAction($token = null, $tracks = [], $groups = null, $buffer = null)
    {

        $groups = $groups ?: App::module('spotify-track-suggester')->config('default_settings')['groups'];

        $response = $this->spotifyClient->get('audio-features', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ],
            'query' => [
                'ids' => join(',', $tracks)
            ]
        ]);

        $returnedFeatures = json_decode((string) $response->getBody(), true);

        $features = [];

        foreach ($returnedFeatures['audio_features'] as $returnedFeature) {
            $feature = Feature::fromSpotify($returnedFeature);
            $features[] = $feature;
        }

        $space = new Space(count($features[0]->getData()));

        foreach ($features as $feature)
            $space->addPoint($feature->getData(), ['id' => $feature->id]);

        $clusters = $space->solve($groups, Space::SEED_DASV);

        $requests = [];

        foreach ($clusters as $cluster) {

            $ids = [];
            $groupFeatures = [];
            $data = $cluster->toArray();

            $points = $data['points'];

            foreach ($points as $point) {

                $groupFeatures[] = Feature::fromKMeans($point['coordinates']);

                $ids[] = $point['data']['id'];
            }

            $attributes = new Attributes($groupFeatures, $buffer);

            $options = [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ],
                'query' => [
                    'seed_tracks' => join(',', count($ids) > 5 ? array_slice($ids, 0, 5) : $ids),
                    $attributes->getQuery()
                ]
            ];

            $requests[] = $this->spotifyClient->getAsync('recommendations', $options);
        }

        $results = Promise\unwrap($requests);

        $recommendations = [];

        foreach ($results as $result) {
            $recommendations[] = json_decode((string) $result->getBody());
        }

        return [
            'recommendations' => $recommendations
        ];
    }
}
