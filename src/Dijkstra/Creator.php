<?php

/**
 * @author ventaquil <ventaquil@outlook.com>
 * @licence MIT
 */

namespace PHPAlgorithms\Dijkstra;

use PHPAlgorithms\Dijkstra\Exceptions\CreatorException;

/**
 * Class Creator
 * @package PHPAlgorithms\Dijkstra
 */
class Creator {
    /**
     * @var Point[] $points Array of collected Point objects.
     */
    private $points = array();

    /**
     * Method adds Point to current object. Can set point's label.
     *
     * @param string|null $label Point's label.
     * @return Point Reference to created Point object.
     */
    public function addPoint($label = null)
    {
        $point = new Point($label);

        $this->points[] = $point;

        return $point;
    }

    /**
     * Method generates integer ids to collected points and drop them out.
     *
     * @return Point[] Array of Point objects.
     */
    public function dumpPoints()
    {
        foreach ($this->points as $index => $point) {
            $point->id = $index;
        }

        return $this->points;
    }

    /**
     * Method returns collected Point object by given $index value.
     *
     * @param integer $index Point's index.
     * @return Point|null Point object if element with $index value exists or null otherwise.
     */
    public function getPoint($index)
    {
        try {
            return $this->getPointOrFail($index);
        } catch (CreatorException $e) {
            return null;
        }
    }

    /**
     * Method search $points object parameter and try to find Point identifier.
     *
     * @param Point $point Point object which we want to find.
     * @return mixed Returns key of $point or false if key isn't exists.
     */
    public function getPointIndex(Point $point)
    {
        return array_search($point, $this->points);
    }

    /**
     * Method returns collected Point object by given $index value or throws exception if index does not exists.
     * 
     * @param integer $index Point's index.
     * @return Point Point object if element with $index value exists.
     * @throws CreatorException Method throws exception when point with $index doesn't exists.
     */
    public function getPointOrFail($index)
    {
        if (!isset($this->points[$index])) {
            throw new CreatorException("Point with index {$index} not exists");
        }

        return $this->points[$index];
    }

    /**
     * Method checks that sent Point object collected by current Creator object.
     * 
     * @param Point $point Point object which we want to check.
     * @return boolean True if $point isset in $points parameter or false otherwise.
     */
    public function searchPoint(Point $point)
    {
        return in_array($point, $this->points);
    }
}
