<?php

namespace PHPAlgorithms\Dijkstra\Tests;

use PHPAlgorithms\Dijkstra;
use PHPAlgorithms\Dijkstra\Creator;
use PHPUnit_Framework_TestCase;

class PointTest extends PHPUnit_Framework_TestCase {
    public function testLabels()
    {
        $point0 = $point1
            = $point2
            = null;

        new Dijkstra(function (Creator $creator) use (&$point0, &$point1, &$point2) {
            $point0 = $creator->addPoint('point0');
            $point1 = $creator->addPoint('point1');
            $point2 = $creator->addPoint();
        });

        $this->assertTrue(isset($point0->label));
        $this->assertEquals('point0', $point0->label);
        $this->assertTrue(isset($point1->label));
        $this->assertEquals('point1', $point1->label);
        $this->assertTrue(isset($point2->label));
        $this->assertEmpty($point2->label);
    }
}
