<?php

namespace PHPAlgorithms\Dijkstra\Tests;

use PHPAlgorithms\Dijkstra;
use PHPAlgorithms\Dijkstra\Creator;
use PHPAlgorithms\Dijkstra\Exceptions\Exception;
use PHPUnit_Framework_TestCase;

class DijkstraTest extends PHPUnit_Framework_TestCase {
    public function testConstructor()
    {
        $dijkstra = new Dijkstra(function (Creator $creator) {
            $creator->addPoint();
            $creator->addPoint();
        });

        $all = $dijkstra->generateAll();

        $this->assertEquals(2, count($all));
        $this->assertEquals($all[0], $dijkstra->generate(0));
        $this->assertEquals($all[1], $dijkstra->generate(1));
        $this->assertArrayNotHasKey(2, $all);
    }

    public function testGenerate()
    {
        $point0 = $point1
                = null;

        $dijkstra = new Dijkstra(function (Creator $creator) use (&$point0, &$point1) {
            $point0 = $creator->addPoint();
            $point1 = $creator->addPoint();

            $creator->getPoint(0)
                    ->addDoubleRelation($creator->getPoint(1), 8);
        });

        try {
            $dijkstra->generate($point0);
            $exception = false;
        } catch (Exception $e) {
            $exception = true;
        }

        $this->assertFalse($exception);

        try {
            $dijkstra->generate($point1);
            $exception = false;
        } catch (Exception $e) {
            $exception = true;
        }

        $this->assertFalse($exception);

        try {
            $dijkstra->generate(2);
            $exception = false;
        } catch (Exception $e) {
            $exception = true;
        }

        $this->assertTrue($exception);

        try {
            $dijkstra->generate('string');
            $exception = false;
        } catch (Exception $e) {
            $exception = true;
        }

        $this->assertTrue($exception);

        try {
            $this->assertEquals(0, $dijkstra->generate(0)[0]->distance);
            $this->assertEquals(8, $dijkstra->generate(0)[1]->distance);

            $exception = false;
        } catch (Exception $e) {
            $exception = true;
        }

        $this->assertFalse($exception);

        try {
            $this->assertEquals(8, $dijkstra->generate(1)[0]->distance);
            $this->assertEquals(0, $dijkstra->generate(1)[1]->distance);

            $exception = false;
        } catch (Exception $e) {
            $exception = true;
        }

        $this->assertFalse($exception);

        try {
            $this->assertEquals($dijkstra->generate(0)[0]->distance, $dijkstra->generate($point0)[0]->distance);
            $this->assertEquals($dijkstra->generate(0)[1]->distance, $dijkstra->generate($point0)[1]->distance);

            $exception = false;
        } catch (Exception $e) {
            $exception = true;
        }

        $this->assertFalse($exception);

        try {
            $this->assertEquals($dijkstra->generate(1)[0]->distance, $dijkstra->generate($point1)[0]->distance);
            $this->assertEquals($dijkstra->generate(1)[1]->distance, $dijkstra->generate($point1)[1]->distance);

            $exception = false;
        } catch (Exception $e) {
            $exception = true;
        }

        $this->assertFalse($exception);
    }

    public function testWithGraphs()
    {
        $dijkstra = new Dijkstra(function (Creator $creator) {
            $point0 = $creator->addPoint();
            $point1 = $creator->addPoint();
            $point2 = $creator->addPoint();
            $point3 = $creator->addPoint();
            $point4 = $creator->addPoint();

            $point0->addDoubleRelation($point1, 5)
                   ->addDoubleRelation($point3, 24);
            $point1->addDoubleRelation($point2, 8)
                   ->addDoubleRelation($point4, 18);
            $point2->addDoubleRelation($point3, 4);
            $point3->addDoubleRelation($point4, 8);
        });

        $dijkstra->add(function (Creator $creator) {
            $creator->addPoint()
                    ->addDoubleRelation($creator->addPoint(), 12);
        });

        $this->assertEquals(0, $dijkstra->generate(0)[0]->distance);
        $this->assertEquals(5, $dijkstra->generate(0)[1]->distance);
        $this->assertEquals(13, $dijkstra->generate(0)[2]->distance);
        $this->assertEquals(17, $dijkstra->generate(0)[3]->distance);
        $this->assertEquals(23, $dijkstra->generate(0)[4]->distance);
        $this->isFalse(isset($dijkstra->generate(0)[5]->distance));
        $this->isFalse(isset($dijkstra->generate(0)[6]->distance));

        $this->assertEquals(5, $dijkstra->generate(1)[0]->distance);
        $this->assertEquals(0, $dijkstra->generate(1)[1]->distance);
        $this->assertEquals(8, $dijkstra->generate(1)[2]->distance);
        $this->assertEquals(12, $dijkstra->generate(1)[3]->distance);
        $this->assertEquals(18, $dijkstra->generate(1)[4]->distance);
        $this->assertFalse(isset($dijkstra->generate(1)[5]));
        $this->assertFalse(isset($dijkstra->generate(1)[6]));

        $this->assertEquals(13, $dijkstra->generate(2)[0]->distance);
        $this->assertEquals(8, $dijkstra->generate(2)[1]->distance);
        $this->assertEquals(0, $dijkstra->generate(2)[2]->distance);
        $this->assertEquals(4, $dijkstra->generate(2)[3]->distance);
        $this->assertEquals(12, $dijkstra->generate(2)[4]->distance);
        $this->assertFalse(isset($dijkstra->generate(2)[5]));
        $this->assertFalse(isset($dijkstra->generate(2)[6]));

        $this->assertEquals(17, $dijkstra->generate(3)[0]->distance);
        $this->assertEquals(12, $dijkstra->generate(3)[1]->distance);
        $this->assertEquals(4, $dijkstra->generate(3)[2]->distance);
        $this->assertEquals(0, $dijkstra->generate(3)[3]->distance);
        $this->assertEquals(8, $dijkstra->generate(3)[4]->distance);
        $this->assertFalse(isset($dijkstra->generate(3)[5]));
        $this->assertFalse(isset($dijkstra->generate(3)[6]));

        $this->assertEquals(23, $dijkstra->generate(4)[0]->distance);
        $this->assertEquals(18, $dijkstra->generate(4)[1]->distance);
        $this->assertEquals(12, $dijkstra->generate(4)[2]->distance);
        $this->assertEquals(8, $dijkstra->generate(4)[3]->distance);
        $this->assertEquals(0, $dijkstra->generate(4)[4]->distance);
        $this->assertFalse(isset($dijkstra->generate(4)[5]));
        $this->assertFalse(isset($dijkstra->generate(4)[6]));

        $this->assertFalse(isset($dijkstra->generate(5)[0]));
        $this->assertFalse(isset($dijkstra->generate(5)[1]));
        $this->assertFalse(isset($dijkstra->generate(5)[2]));
        $this->assertFalse(isset($dijkstra->generate(5)[3]));
        $this->assertFalse(isset($dijkstra->generate(5)[4]));
        $this->assertEquals(0, $dijkstra->generate(5)[5]->distance);
        $this->assertEquals(12, $dijkstra->generate(5)[6]->distance);

        $this->assertFalse(isset($dijkstra->generate(6)[0]));
        $this->assertFalse(isset($dijkstra->generate(6)[1]));
        $this->assertFalse(isset($dijkstra->generate(6)[2]));
        $this->assertFalse(isset($dijkstra->generate(6)[3]));
        $this->assertFalse(isset($dijkstra->generate(6)[4]));
        $this->assertEquals(12, $dijkstra->generate(6)[5]->distance);
        $this->assertEquals(0, $dijkstra->generate(6)[6]->distance);

        $dijkstra = new Dijkstra(function (Creator $creator) {
            $creator->addPoint()
                    ->addRelation($creator->addPoint(), 8);
            $creator->addPoint()
                    ->addDoubleRelation($creator->getPoint(0), 10);
            $creator->addPoint()
                    ->addDoubleRelation($creator->getPoint(1), 8);
            $creator->addPoint()
                    ->addRelation($creator->getPoint(3), 2);
            $creator->getPoint(2)
                    ->addRelation($creator->getPoint(4), 3);
        });

        $this->assertEquals(8, $dijkstra->generate(0)[1]->distance);
        $this->assertEquals(10, $dijkstra->generate(0)[2]->distance);
        $this->assertEquals(16, $dijkstra->generate(0)[3]->distance);
    }
}
