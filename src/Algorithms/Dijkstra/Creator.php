<?php
namespace Algorithms\Dijkstra;

class Creator
{
    private $points = array();

    public function addPoint($point)
    {
        if (Point::checkPoint($point)) {
            $this->points[$point->getID()] = $point;

            return $point;
        } else {
            if (!isset($this->points[$point])) {
                $new_point = Point::create($point);

                $this->points[$point] = $new_point;

                return $new_point;
            } else {
                throw new CreatorException('Point was added earlier');
            }
        }
    }

    public function getPoint($point_id)
    {
        try {
            return $this->getPointOrFail($point_id);
        } catch(PointException $e) {
            return NULL;
        }
    }

    public function getPointOrFail($point_id)
    {
        if (isset($this->points[$point_id])) {
            return $this->points[$point_id];
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
