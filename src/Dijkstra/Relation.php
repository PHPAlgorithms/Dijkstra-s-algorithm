<?php

namespace PHPAlgorithms\Dijkstra;

use PHPAlgorithms\Dijkstra\Exceptions\RelationException;
use PHPAlgorithms\GraphTools\AbstractLine;
use PHPAlgorithms\GraphTools\Traits\MagicGet;

class Relation extends AbstractLine {
    use MagicGet;

    private $distance;

    public function __construct($from, $to, $distance = null)
    {
        parent::__construct($from, $to);

        if (!is_null($distance)) {
            $this->setDistance($distance);
        }
    }

    public function setDistance($distance)
    {
        if (!is_numeric($distance) && ($distance <= 0)) {
            throw new RelationException('Distance must be numeric value greater than 0');
        }

        $this->distance = $distance;
    }
}
