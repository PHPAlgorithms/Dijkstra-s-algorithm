<?php

/**
 * @author ventaquil <ventaquil@outlook.com>
 * @licence MIT
 */

namespace PHPAlgorithms\Dijkstra;

use PHPAlgorithms\Dijkstra\Exceptions\RelationException;
use PHPAlgorithms\GraphTools\AbstractLine;
use PHPAlgorithms\GraphTools\Traits\MagicGet;

class Relation extends AbstractLine {
    use MagicGet;

    /**
     * @var integer|null $distance Distance of relation. Defaults null.
     */
    private $distance;

    /**
     * Relation constructor.
     * 
     * @param Point $from Start object of relation.
     * @param Point $to End object of relation.
     * @param integer|null $distance Distance of relation. Must be greater than 0.
     */
    public function __construct($from, $to, $distance = null)
    {
        parent::__construct($from, $to);

        if (!is_null($distance)) {
            $this->setDistance($distance);
        }
    }

    /**
     * Method checks distance. If greater than 0 set sent argument as object parameter or throws exception otherwise.
     * 
     * @param integer $distance Distance of relation. Must be greater than 0.
     * @throws RelationException Method throws exception when $distance is less or equal to 0.
     */
    public function setDistance($distance)
    {
        if (!is_numeric($distance) && ($distance <= 0)) {
            throw new RelationException('Distance must be numeric value greater than 0');
        }

        $this->distance = $distance;
    }
}
