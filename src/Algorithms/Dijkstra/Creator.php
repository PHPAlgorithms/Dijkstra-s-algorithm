<?php
namespace Algorithms\Dijkstra;

class Creator
{
    private $points = array();
    private $labels = array();

    private static function checkPointID($point)
    {
        if (is_int($point) && ($point > 0)) {
            return 'int';
        } else {
            return 'string';
        }
    }

    private function randNewID()
    {
        do {
            $rand = mt_rand();
        } while (isset($this->points[$rand]));

        return $rand;
    }

    private function createPointFromID($point_id, $label = null)
    {
        if (empty($label)) {
            $new_point = Point::create($point_id);
        } else {
            $new_point = Point::create($point_id, $label);
        }

        $this->points[$point_id] = $new_point;

        return $new_point;
    }

    public function addPoint($point)
    {
        if (Point::checkPoint($point)) {
            $id = $point->getID();

            $this->points[$id] = $point;

            $label = $point->getLabel();
            if (!empty($label)) {
                $this->labels[$label] = $id;
            }

            return $point;
        } elseif (self::checkPointID($point) == 'int') {
            if (!isset($this->points[$point])) {
                return self::createPointFromID($point);
            } else {
                throw new CreatorException('Point was added earlier');
            }
        } else {
            if (!isset($this->labels[$point])) {
                $id = $this->randNewID();

                $this->labels[$point] = $id;

                return self::createPointFromID($id);
            } else {
                throw new CreatorException('Point was added earlier');
            }
        }
    }

    public function getPoint($point_id)
    {
        try {
            return $this->getPointOrFail($point_id);
        } catch (PointException $e) {
            return NULL;
        }
    }

    public function getPointOrFail($point_id)
    {
        if (isset($this->points[$point_id])) {
            return $this->points[$point_id];
        } elseif (isset($this->labels[$point_id])) {
            return $this->points[$this->labels[$point_id]];
        } else {
            throw new PointException('Point not exists');
        }
    }

    public function createConnections()
    {
        $relations = array();

        foreach ($this->points as $point_id => $point) {
            $relations[$point_id] = $point->getDinstances();

            foreach ($relations[$point_id] as $array_to_analyze) {
                if (!isset($relations[$array_to_analyze[0]])) {
                    $relations[$array_to_analyze[0]] = array();
                }
            }
        }

        return $relations;
    }
}
