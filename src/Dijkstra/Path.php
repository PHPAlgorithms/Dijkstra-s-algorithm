<?php

namespace PHPAlgorithms\Dijkstra;

use PHPAlgorithms\Dijkstra\Exceptions\PathException;

class Path {
    private $nodes = array();
    private $distance = 0;

    public function __get($name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        }

        return null;
    }

    public function addNode($point, $distance = 0)
    {
        if ($point instanceof Point) {
            $point = $point->id;
        }

        $this->nodes[] = $point;

        $this->checkDistance($distance);

        $this->distance += $distance;

        return $this;
    }

    public function checkDistance($distance)
    {
        if (!is_numeric($distance) && ($distance <= 0)) {
            throw new PathException('Distance must be numeric value greater than 0');
        }
    }

    public function copy(self $path)
    {
        $this->nodes = $path->nodes;
        $this->distance = $path->distance;

        return $this;
    }
}
