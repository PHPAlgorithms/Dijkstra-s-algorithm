<?php

namespace PHPAlgorithms\Dijkstra;

use PHPAlgorithms\Dijkstra\Exceptions\PointException;
use PHPAlgorithms\GraphTools\AbstractPoint;
use PHPAlgorithms\GraphTools\Traits\MagicGet;

class Point extends AbstractPoint
{
    use MagicGet;

    private $label = '';
    private $relations = array();

    public function __construct($label = null)
    {
        if (!is_null($label)) {
            $this->setLabel($label);
        }
    }

    public function __isset($name)
    {
        return isset($this->{$name});
    }

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

    private function addRelationObject(Relation $relation)
    {
        if (($this !== $relation->from) && ($this !== $relation->to)) {
            throw new PointException('Sent relation is not match to this point');
        }

        $this->relations[] = $relation;
    }

    private function addRelationPointDistance(Point $point, $distance)
    {
        $this->addRelationObject(new Relation($this, $point, $distance));
    }

    public function setLabel($label)
    {
        if (!is_string($label)) {
            throw new PointException('Label is not a string');
        }

        $this->label = $label;
    }
}
