<?php

/**
 * @author ventaquil <ventaquil@outlook.com>
 * @licence MIT
 */

namespace PHPAlgorithms\Dijkstra;

use PHPAlgorithms\Dijkstra\Exceptions\PointException;
use PHPAlgorithms\GraphTools\AbstractPoint;
use PHPAlgorithms\GraphTools\Traits\MagicGet;

/**
 * Class Point
 * @package PHPAlgorithms\Dijkstra
 * @property string $label
 * @property Relation[] $relations
 */
class Point extends AbstractPoint
{
    use MagicGet;

    /**
     * @var integer|null $id Point identification number.
     * @var string $label Point label, defaults empty string.
     * @var Relation[] $relations Relations array, default is empty.
     */
    public $id;
    private $label = '';
    private $relations = array();

    /**
     * Point constructor.
     * 
     * @param string|null $label Point's label. Defaults null.
     */
    public function __construct($label = null)
    {
        if (!is_null($label)) {
            $this->setLabel($label);
        }
    }

    /**
     * Magic method isset.
     * 
     * @param string $name Name of parameter.
     * @return boolean Method returns true if parameter exists or false otherwise.
     */
    public function __isset($name)
    {
        return isset($this->{$name});
    }

    /**
     * @param Relation|Point Relation or Point object.
     * @param null|integer Distance to point, when first argument is a Point object.
     * @return Point $this Reference to the same object.
     * @throws PointException Throws exception when arguments aren't match.
     */
    public function addDoubleRelation()
    {
        switch (func_num_args()) {
            case 1:
                $arg = func_get_arg(0);

                $this->addRelation($arg);
                if ($arg->from === $this) {
                    $arg->to
                        ->addRelation($arg);
                } else {
                    $arg->from
                        ->addRelation($arg);
                }
                break;
            case 2:
                $this->addRelation(func_get_arg(0), func_get_arg(1));
                func_get_arg(0)->addRelation($this, func_get_arg(1));
                break;
            default:
                throw new PointException('Wrong arguments sent to addRelation() method');
        }

        return $this;
    }

    /**
     * @param Relation|Point Relation or Point object.
     * @param null|integer Distance to point, when first argument is a Point object.
     * @return Point $this Reference to the same object.
     * @throws PointException Throws exception when arguments aren't match.
     */
    public function addRelation()
    {
        switch (func_num_args()) {
            case 1:
                $this->addRelationObject(func_get_arg(0));
                break;
            case 2:
                $this->addRelationPointDistance(func_get_arg(0), func_get_arg(1));
                break;
            default:
                throw new PointException('Wrong arguments sent to addRelation() method');
        }

        return $this;
    }

    /**
     * @param Relation $relation
     * @throws PointException
     */
    private function addRelationObject(Relation $relation)
    {
        if (($this !== $relation->from) && ($this !== $relation->to)) {
            throw new PointException('Sent relation is not match to this point');
        }

        $this->relations[] = $relation;
    }

    /**
     * @param Point $point Another Point object to create a bidirectional relationship.
     * @param integer $distance Integer value of distance between points. Must be greater than 0.
     * @throws PointException
     */
    private function addRelationPointDistance(Point $point, $distance)
    {
        $this->addRelationObject(new Relation($this, $point, $distance));
    }

    /**
     * @param string $label New Point's label.
     * @throws PointException Throws exception when $label is not a string.
     */
    public function setLabel($label)
    {
        if (!is_string($label)) {
            throw new PointException('Label is not a string');
        }

        $this->label = $label;
    }
}
