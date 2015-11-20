<?php
namespace Algorithms\Dijkstra;

class Point
{
    private $id;
    private $distances = array();

    public function __construct($point_id)
    {
        if (is_int($point_id)) {
            $this->id = $point_id;
        } else {
            throw new PointException('Wrong data sent');
        }
    }

    public static function create($point_id)
    {
        return new self($point_id);
    }

    public static function checkPoint($point)
    {
        if ($point instanceof self) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function validate($point)
    {
        if (is_int($point)) {
            return $point;
        } elseif (self::checkPoint($point)) {
            return $point->getID();
        } else {
            throw new PointException('Wrong data sent');
        }
    }

    public function addRelation($point, $distance)
    {
        $point = $this::validate($point);

        $this->distances[$point] = $distance;

        return $this;
    }

    public function getDinstances()
    {
        $distances = array();

        foreach ($this->distances as $point_id => $distance) {
            $distances[] = [$point_id, $distance];
        }

        return $distances;
    }

    public function distanceTo($point)
    {
        $point = $this::validate($point);

        if (isset($this->distances[$point])) {
            return $this->distances[$point];
        } else {
            return FALSE;
        }
    }

    public function getID()
    {
        return $this->id;
    }
}
