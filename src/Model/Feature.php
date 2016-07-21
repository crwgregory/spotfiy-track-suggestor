<?php
/**
 * Created by PhpStorm.
 * User: crwgr
 * Date: 7/20/2016
 * Time: 4:26 PM
 */

namespace Crwgregory\SpotifyTrackSuggester\Model;


class Feature
{
    public $id;

    public $danceability;

    public $energy;

    public $key;

    public $loudness;

    public $mode;

    public $speechiness;

    public $acousticness;

    public $instrumentalness;

    public $liveness;

    public $valence;

    public $tempo;

    public static function fromKMeans($data)
    {
        $self = new self();

        $self->danceability     = $data[0];
        $self->energy           = $data[1];
        $self->speechiness      = $data[2];
        $self->acousticness     = $data[3];
        $self->instrumentalness = $data[4];
        $self->liveness         = $data[5];
        $self->valence          = $data[6];

        return $self;
    }

    public static function fromSpotify($data)
    {
        $self = new self();

        foreach ($data as $k => $v) {

            if (property_exists($self, $k)) {

                $self->$k = $v;
            }
        }
        return $self;
    }

    public function getData()
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
        return $this->getData();
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
