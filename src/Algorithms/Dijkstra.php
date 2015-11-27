<?php
namespace Algorithms;

class Dijkstra
{
    protected $points;
    protected $relations;

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
        $result = []; # Prepare results array

        # Analyze all relations
            foreach ($this->relations as $point => $relation) {
                # Prepare $points array by isset source point
                    $this->points = [
                        $point => [
                            0,
                            '',
                        ],
                    ];

                $this->dist($point, $point);
                $result[$point] = $this->points; # Copy $points content to results array
            }

        return $result;
    }

    private function dist($source, $point, &$visited = [])
    {
        $visited[$point] = true; # Set current point as visited

        # Prepare help variables
            $min_ptr = -1;
            $min = 0;

        # Analyzes point neighborhood
            foreach ($this->relations[$point] as $relation) {
                if ($relation[0] != $source) { # If current point is different than source
                    if (empty($visited[$relation[0]])) { # If current point is not visited
                        if ($min_ptr == -1) { # When minimal point is not finded
                            $min_ptr = $relation[0];
                            $min = $relation[1];
                        } else {
                            if ($min > $relation[1]) {
                                $min_ptr = $relation[0];
                                $min = $relation[1];
                            }
                        }
                    }

                    # Change the shortest way to current point
                        if (isset($this->points[$point][0])) {
                            $first_field = $this->points[$point][0];
                        } else {
                            $first_field = 0;
                        }

                        if (empty($this->points[$relation[0]])) {
                            $this->points[$relation[0]] = [
                                $first_field + $relation[1],
                                ((empty($this->points[$point][1])) ? $point : $this->points[$point][1]) . ':' . $relation[0],
                            ];
                        } else {
                            if ($this->points[$relation[0]][0] > ($this->points[$point][0] + $relation[1])) {
                                $this->points[$relation[0]] = [
                                    (isset($this->points[$point][0]) ? $this->points[$point][0] : 0) + $relation[1],
                                    (empty($this->points[$point][1]) ? null : $this->points[$point][1] . ':') . $relation[0],
                                ];
                            }
                        }
                }
            }

        # If isset unvisited point with minimal way go for it
            if ($min_ptr != -1) {
                $this->dist($source, $min_ptr, $visited);
            }
    }

    public function distances($point)
    {
        $this->dist($point, $point);
        return $this->points;
    }

    private static function validate($relations_array)
    {
        if (is_array($relations_array)) {
            $return = true;
            foreach ($relations_array as $relations) {
                $return = self::checkPointRelations($relations);
            }

            return $return;
        } else {
            return false;
        }
    }

    private static function checkPointRelations($relations)
    {
        if (is_array($relations)) {
            $return = true;

            foreach ($relations as $relation) {
                $return = self::checkSingleRelation($relation);
            }

            return $return;
        } else {
            return false;
        }
    }

    private static function checkSingleRelation($relation)
    {
        return (is_array($relation) && (count($relation) == 2) && isset($relation[0]) && isset($relation[1]));
    }
}
