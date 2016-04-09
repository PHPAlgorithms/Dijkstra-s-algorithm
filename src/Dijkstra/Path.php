<?php

/**
 * @author ventaquil <ventaquil@outlook.com>
 * @licence MIT
 */

namespace PHPAlgorithms\Dijkstra;

use PHPAlgorithms\Dijkstra\Exceptions\PathException;
use PHPAlgorithms\GraphTools\Traits\MagicGet;

/**
 * Class Path
 * @package PHPAlgorithms\Dijkstra
 * @property integer[] $nodes
 * @property integer $distance
 */
class Path {
    use MagicGet;

    /**
     * @var integer[] $nodes Added points' ids to current path.
     * @var integer $distance Distance of the path.
     */
    private $nodes = array();
    private $distance = 0;

    /**
     * Method adds node to end of current path.
     *
     * @param Point|integer $point Point object or point identifier.
     * @param integer $distance Distance between this node and the last one in path.
     * @return Path Reference to current object.
     * @throws PathException Method throws exception when checkDistance() method throws exception.
     */
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

    /**
     * Method checks given $distance value.
     *
     * @param integer $distance
     * @throws PathException Method throws exception when $distance is not numeric value or when $distance is less or equal to 0.
     */
    public function checkDistance($distance)
    {
        if (!is_numeric($distance) && ($distance <= 0)) {
            throw new PathException('Distance must be numeric value greater than 0');
        }
    }

    /**
     * Method copy data of given Path object to current class instance.
     *
     * @param Path $path Path object whose data we want to copy.
     * @return Path $this Reference to current object.
     */
    public function copy(self $path)
    {
        $this->nodes = $path->nodes;
        $this->distance = $path->distance;

        return $this;
    }
}
