<?php

namespace Crwgregory\SpotifyTrackSuggester\Controller;


use Pagekit\Application as App;

class SpotifyTrackSuggesterController
{
    /**
     * @Route("/")
     * @Method("GET")
     */
    function indexAction()
    {
        return [
            '$view' => [
                'title' => __('Spotify Track Suggester'),
                'name' => 'spotify-track-suggester:views/index.php'
            ],
            '$data' => [
                'your' => 'data'
            ]
        ];
    }

    /**
     * @Route("/admin")
     * @Method("GET")
     * @Access( admin = true )
     */
    function adminAction()
    {
        return [
            '$view' => [
                'title' => __('Spotify Track Suggester'),
                'name' => 'spotify-track-suggester:views/admin/index.php'
            ],
            '$data' => [
                'your' => 'data'
            ]
        ];
    }

    /**
     * @Route("/settings")
     * @Method("GET")
     * @Access( admin = true )
     */
    function settingsAction()
    {
        return [
            '$view' => [
                'title' => __('Spotify Track Suggester Settings'),
                'name' => 'spotify-track-suggester:views/admin/settings.php'
            ],
            '$data' => [
                'config_default_array' => App::module('spotify-track-suggester')->config('default'),
                'foo' => App::module('spotify-track-suggester')->config('foo')
            ]
        ];
    }
}