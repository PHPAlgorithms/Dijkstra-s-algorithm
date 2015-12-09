<?php
namespace Algorithms;

class Dijkstra
{
    protected $points = array();
    protected $relations;
    protected $generated = null;

    public function __construct($relations = null)
    {
        if (!empty($relations)) {
            $this->setRelations($relations);
        }
    }

    public function setRelations($relations)
    {
        if (self::validate($relations)) {
            $this->relations = $relations;
        } else {
            if (is_callable($relations) && ($relations instanceof \Closure)) {
                $creator = new GraphTools\Creator;
                call_user_func($relations, $creator);

                $this->relations = $creator->createConnections();
            }
        }
    }

    public function generate()
    {
        return DijkstraCache::loadMany($this->generated, function () {
            $results = []; # Prepare results array

            # Analyze all relations
            foreach ($this->relations as $point => $relation) {
                $results[$point] = DijkstraCache::loadOne($this->generated, $point, function () use ($point) {
                    return $this->distances($point);
                });
            }

            return $results;
        });
    }

    private function init($point)
    {
        $this->points = array();

        $this->points[$point] = DijkstraCache::loadOne($this->generated, $point, function () {
           return array(0, ''); 
        });
    }

    private function dist($source, $pointId, &$visited = [])
    {
        $visited[$pointId] = true; # Set current point as visited

        # Prepare help variables
        $min_ptr = -1;
        $min = 0;

        # Analyzes point neighborhood
        foreach ($this->relations[$pointId] as $relation) {
            if ($relation[0] != $source) { # If current point is different than source
                list($min_ptr, $min) = $this->setMinPtr($relation, $visited, $min_ptr, $min);

                # Change the shortest way to current point
                $distance = $this->getShortestDistance($pointId);

                $this->updatePoint($pointId, $relation, $distance);
            }
        }

        # If isset unvisited point with minimal way go for it
        if ($min_ptr != -1) {
            $this->dist($source, $min_ptr, $visited);
        }
    }

    private function getShortestDistance($pointId)
    {
        return isset($this->points[$pointId][0]) ? $this->points[$pointId][0] : 0;
    }

    private function setMinPtr($relation, $visited, $min_ptr, $min)
    {
        if (empty($visited[$relation[0]])) { # If current point is not visited
            if ($min_ptr == -1) { # When minimal point is not finded
                $min_ptr = $relation[0];
                $min = $relation[1];
            } elseif ($min > $relation[1]) {
                $min_ptr = $relation[0];
                $min = $relation[1];
            }
        }

        return array($min_ptr, $min);
    }

    private function updatePoint($pointId, $relation, $distance)
    {
        if (empty($this->points[$relation[0]])) {
            $this->points[$relation[0]] = [
                $distance + $relation[1],
                ((empty($this->points[$pointId][1])) ? $pointId : $this->points[$pointId][1]) . ':' . $relation[0],
            ];
        } else {
            if ($this->points[$relation[0]][0] > ($this->points[$pointId][0] + $relation[1])) {
                $this->points[$relation[0]] = [
                    (isset($this->points[$pointId][0]) ? $this->points[$pointId][0] : 0) + $relation[1],
                    (empty($this->points[$pointId][1]) ? null : $this->points[$pointId][1] . ':') . $relation[0],
                ];
            }
        }
    }

    public function distances($point)
    {
        return DijkstraCache::loadOne($this->generated, $point, function () use ($point) {
            $this->init($point);
            $this->dist($point, $point);
            return $this->points;
        });
    }

    public static function validate($relations_array)
    {
        $return = is_array($relations_array);

        if ($return) {
            foreach ($relations_array as $relations) {
                $return &= self::checkPointRelations($relations);
            }
        }

        return $return;
    }

    private static function checkPointRelations($relations)
    {
        $return = is_array($relations);

        if ($return) {
            foreach ($relations as $relation) {
                $return &= self::checkSingleRelation($relation);
            }
        }

        return $return;
    }

    private static function checkSingleRelation($relation)
    {
        return (is_array($relation) && (count($relation) == 2) && isset($relation[0]) && isset($relation[1]));
    }
}
