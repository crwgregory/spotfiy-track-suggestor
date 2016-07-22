<?php
/**
 * Created by PhpStorm.
 * User: crwgr
 * Date: 7/21/2016
 * Time: 9:30 AM
 */

namespace Crwgregory\SpotifyTrackSuggester\Model;


use Pagekit\Application as App;

class Attributes
{

    protected $buffer = 0.1;

    public $danceability = [
        'min' => 1.0,
        'max' => 0.0
    ];

    public $energy = [
        'min' => 1.0,
        'max' => 0.0
    ];

    public $speechiness = [
        'min' => 1.0,
        'max' => 0.0
    ];

    public $acousticness = [
        'min' => 1.0,
        'max' => 0.0
    ];

    public $instrumentalness = [
        'min' => 1.0,
        'max' => 0.0
    ];

    public $liveness = [
        'min' => 1.0,
        'max' => 0.0
    ];

    public $valence = [
        'min' => 1.0,
        'max' => 0.0
    ];

    public $tempo = [
        'min' => 1.0,
        'max' => 0.0
    ];

    /**
     * Attributes constructor.
     * @param array $cluster
     * @param float $buffer
     */
    public function __construct($cluster, $buffer)
    {
        if ($cluster)
            $this->determineAttributes($cluster);

        $this->buffer = $buffer ?: App::module('spotify-track-suggester')->config('default_settings')['attribute_buffer'];
    }

    public function determineAttributes($cluster)
    {
        foreach ($cluster as $feature) {

            $feature = $feature->toArray(true);

            foreach ($feature as $key => $value) {

                if (property_exists($this, $key)) {

                    $prop = &$this->$key;

                    if ($prop['min'] > $value) {

                        $prop['min'] = $value;
                    }

                    if ($prop['max'] < $value) {

                        $prop['max'] = $value;
                    }
                }
            }
        }
    }

    public function getQuery()
    {
        $query = [];
        foreach ($this->toArray(true) as $name => $data) {
            $query['min_' . $name] = ($data['min'] - ($data['min'] * $this->buffer)) > 0.0 ?: $data['min'];
            $query['max_' . $name] = ($data['max'] + ($data['max'] * $this->buffer)) < 1.0 ?: $data['max'];
        }
        return $query;
    }

    public function getAttributes()
    {
        return [
            $this->danceability,
            $this->energy,
            $this->speechiness,
            $this->acousticness,
            $this->instrumentalness,
            $this->liveness,
            $this->valence
        ];
    }

    public function toArray($associative = false)
    {
        if ($associative) {
            return [
                'danceability' => $this->danceability,
                'energy' => $this->energy,
                'speechiness' => $this->speechiness,
                'acousticness' => $this->acousticness,
                'instrumentalness' => $this->instrumentalness,
                'liveness' => $this->liveness,
                'valence' => $this->valence
            ];
        }
        return $this->getAttributes();
    }
}
