<?php

namespace PHPAlgorithms\Dijkstra;

use PHPAlgorithms\Dijkstra\Exceptions\CreatorException;

class Creator {
    private $points = array();

    public function addPoint($label = null)
    {
        $point = new Point($label);

        $this->points[] = $point;

        return $point;
    }

    public function dumpPoints()
    {
        foreach ($this->points as $index => $point) {
            $point->id = $index;
        }

        return $this->points;
    }

    public function getPoint($index)
    {
        try {
            return $this->getPointOrFail($index);
        } catch (CreatorException $e) {
            return null;
        }
    }

    public function getPointIndex(Point $point)
    {
        return array_search($point, $this->points);
    }

    public function getPointOrFail($index)
    {
        if (!isset($this->points[$index])) {
            throw new CreatorException("Point with index {$index} not exists");
        }

        return $this->points[$index];
    }

    public function searchPoint(Point $point)
    {
        return in_array($point, $this->points);
    }
}
