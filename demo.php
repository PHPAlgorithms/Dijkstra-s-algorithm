<?php

require_once(__DIR__ . '/vendor/autoload.php');

use PHPAlgorithms\Dijkstra;
use PHPAlgorithms\Dijkstra\Creator;

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

print_r($dijkstra->generateAll());

$dijkstra = new Dijkstra(function (Creator $creator) {
    $creator->addPoint('0')
            ->addRelation($creator->addPoint('1'), 10)
            ->addRelation($creator->addPoint('2'), 3);
    $creator->getPoint(2)
            ->addRelation($creator->getPoint(1), 5);
});

print_r($dijkstra->generateAll());
