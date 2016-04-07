<?php

namespace PHPAlgorithms;

use Closure;
use PHPAlgorithms\Dijkstra\Creator;
use PHPAlgorithms\Dijkstra\Exceptions\Exception;
use PHPAlgorithms\Dijkstra\Path;
use PHPAlgorithms\Dijkstra\Point;

class Dijkstra {
    private $points = array();

    public function __construct($function = null)
    {
        if (!is_null($function)) {
            $this->add($function);
        }
    }

    public function add($function)
    {
        if (!($function instanceof Closure)) {
            throw new Exception('Sent argument is not instance of Closure');
        }

        $creator = new Creator();
        $function($creator);

        if (empty($this->points)) {
            $this->points = $creator->dumpPoints();
        } else {
            $index = count($this->points);

            foreach ($creator->dumpPoints() as $point) {
                $this->points[$index] = $point;
                $point->id = $index;

                $index++;
            }
        }

        return $this;
    }

    public function generate($point)
    {
        if ($point instanceof Point) {
            $point = $point->id;
        }

        if (!isset($this->points[$point])) {
            throw new Exception("Point with id {$point} not exists");
        }

        $visited = array();
        $unvisited = array_keys($this->points);
        $paths = array();
        $previous = null;
        $relation = null;

        do {
            unset($unvisited[$point]);
            $visited[$point] = $point;

            if (!isset($paths[$point])) {
                $paths[$point] = (new Path())->addNode($point);
            }

            if (!is_null($previous)) {
                if (!isset($paths[$point])) {
                    $paths[$point]->copy($paths[$previous]);
                    $paths[$point]->addNode($point, $relation->distance);
                }
            }

            $relation = $this->getMinimalRelation($unvisited, $paths, $point);

            $this->updatePaths($paths, $point);

            $previous = $point;

            if (!is_null($relation)) {
                $point = $relation->to
                                  ->id;
            } else {
                $point = null;
            }
        } while (!is_null($point));

        return $paths;
    }

    public function generateAll()
    {
        $generated = array();

        foreach ($this->points as $index => $point) {
            $generated[$index] = $this->generate($point);
        }

        return $generated;
    }

    private function getMinimalRelation($unvisited, $paths, $point)
    {
        $minimalValue = INF;
        $minimalIndex = -1;

        foreach ($this->points[$point]->relations as $index => $relation) {
            if (($minimalValue > ($relation->distance + $paths[$point]->distance)) && isset($unvisited[$relation->to->id])) {
                $minimalIndex = $index;
                $minimalValue = $relation->distance + $paths[$point]->distance;
            }
        }

        if ($minimalIndex != -1) {
            return $this->points[$point]
                        ->relations[$minimalIndex];
        } else {
            return null;
        }
    }

    public function updatePaths(&$paths, $point)
    {
        foreach ($this->points[$point]->relations as $relation) {
            if (isset($paths[$relation->to->id])) {
                if ($paths[$relation->to->id]->distance > ($paths[$point]->distance + $relation->distance)) {
                    $paths[$relation->to->id]->copy($paths[$point])
                                             ->addNode($relation->to->id, $relation->distance);
                }
            } else {
                $paths[$relation->to->id] = new Path();
                $paths[$relation->to->id]->copy($paths[$point])
                                         ->addNode($relation->to->id, $relation->distance);
            }
        }
    }
}
