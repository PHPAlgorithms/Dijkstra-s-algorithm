<?php

/**
 * @author ventaquil <ventaquil@outlook.com>
 * @licence MIT
 */

namespace PHPAlgorithms;

use Closure;
use PHPAlgorithms\Dijkstra\Creator;
use PHPAlgorithms\Dijkstra\Exceptions\Exception;
use PHPAlgorithms\Dijkstra\Path;
use PHPAlgorithms\Dijkstra\Point;

class Dijkstra {
    /**
     * @var array
     */
    private $points = array();

    /**
     * Dijkstra constructor.
     *
     * @param Closure|null $function Anonymous function to create relations.
     */
    public function __construct($function = null)
    {
        if (!is_null($function)) {
            $this->add($function);
        }
    }

    /**
     * Method executes sent function and add result to $points parameter.
     *
     * @param Closure $function Anonymous function to create relations.
     * @return Dijkstra $this Reference to the same object.
     * @throws Exception Method throws exception when $function argument isn't a Closure object.
     */
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

    /**
     * Method search unvisited points in neighborhood of sent point.
     *
     * @param integer[] $visited Array of visited points' ids.
     * @param integer $point Point id.
     * @return boolean True when exists unvisited point in neighborhood or false otherwise.
     */
    private function existsUnvisitedInNeighborhood($visited, $point)
    {
        foreach ($this->points[$point]->relations as $relation) {
            if (!isset($visited[$relation->to->id])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Method generates path for given Point object or point id.
     *
     * @param Point|integer $point Point object or point identification number.
     * @return Path[] Array of Path objects.
     * @throws Exception Throws exception when sent point not isset in object's $point array.
     */
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

        while (!empty($unvisited) && !is_null($point)) {
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
                $point = $paths[$point]->nodes[0];

                if (!$this->existsUnvisitedInNeighborhood($visited, $point)) {
                    $point = null;
                }
            }
        };

        return $paths;
    }

    /**
     * Method generates paths for all defined points.
     *
     * @return Path[][] Two-dimensional array of Path objects.
     * @throws Exception Method throws exception when generate() method throws exception.
     */
    public function generateAll()
    {
        $generated = array();

        foreach ($this->points as $index => $point) {
            $generated[$index] = $this->generate($point);
        }

        return $generated;
    }

    /**
     * Method try to find minimal relation to another point from given point.
     * 
     * @param integer[] $unvisited Array of unvisited points' ids.
     * @param Path[] $paths Array of generated Path objects.
     * @param integer $point Point integer identifier.
     * @return Dijkstra\Relation|null Method returns Relation object or null when minimal relation wasn't found.
     */
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

    /**
     * Method updates existing Path object or create new if it's possible.
     * 
     * @param Path[] &$paths Array of generated Path[] objects. Given by reference.
     * @param integer $point Integer point identifier.
     */
    public function updatePaths(&$paths, $point)
    {
        foreach ($this->points[$point]->relations as $relation) {
            if (isset($paths[$relation->to->id])) {
                if ($paths[$relation->to->id]->distance > ($paths[$point]->distance + $relation->distance)) {
                    $paths[$relation->to->id]->copy($paths[$point])
                                             ->addNode($relation->to->id, $relation->distance);
                }
            } else {
                $paths[$relation->to->id] = (new Path())->copy($paths[$point])
                                                        ->addNode($relation->to->id, $relation->distance);
            }
        }
    }
}
