<?php
require_once(__DIR__.'/vendor/autoload.php');

// Simple relations
$relations = [
  1 => [ // point 1 relations
    [2, 1],  // to point 2 - distance 1
    [4, 2],  // to point 4 - distance 2
  ],  # 1
  2 => [ // point 2 relations
    [1, 1],  // to point 1 - distance 1
    [3, 3],  // to point 3 - distance 3
    [4, 3],  // to point 4 - distance 3
  ],  # 2
  3 => [ // point 3 relations
    [2, 3],  // to point 2 - distance 3
    [4, 1],  // to point 4 - distance 1
    [5, 5],  // to point 5 - distance 5
  ],  # 3
  4 => [ // point 4 relations
    [1, 2],  // to point 1 - distance 2
    [2, 3],  // to point 2 - distance 3
    [3, 1],  // to point 3 - distance 1
    [5, 1],  // to point 5 - distance 1
  ],  # 4
  5 => [ // point 5 relations
    [3, 5],  // to point 3 - distance 5
    [4, 1],  // to point 4 - distance 1
  ],  # 5
]; # $relations

$dijkstra = new Algorithms\Dijkstra($relations);
print_r($dijkstra->distances(1)); // all distances from point 1 to other points
print_r($dijkstra->generate()); // all distances from all points to all points
$relations = [
  1 => [ // point 1 relations
    [2, 1], // to point 2 - distance 1
  ],
  2 => [ // point 2 relations
    [3, 1], // to point 3 - distance 1
  ],
  3 => [ // point 3 relations
    [1, 1], // to point 1 - distance 1
  ],
  4 => [ // point 4 relations
    [5, 1], // to point 5 - distance 1
  ],
  5 => [ // point 5 relations
    [4, 1], // to point 5 - distance 1
  ],
];

$dijkstra = new Algorithms\Dijkstra($relations);
var_dump($dijkstra->distances(1)); // all distances from point 1 to other points
var_dump($dijkstra->generate()); // all distances from all points to all points

// Or set this relations in another way
$dijkstra=new Algorithms\Dijkstra(function(Algorithms\Dijkstra\Creator $creator){
  $creator->addPoint(1)
          ->addRelation(2, 1);
  
  $creator->addPoint(2)
          ->addRelation(3, 1);

  $creator->addPoint(3)
          ->addRelation(1, 1);

  $creator->addPoint(4)
          ->addRelation(5, 1);

  $creator->addPoint(5)
          ->addRelation(4, 1);
}); # Algorithms\Dijkstra
var_dump($dijkstra->distances(1));
var_dump($dijkstra->generate());

// You can also add points like that
new Algorithms\Dijkstra(function(Algorithms\Dijkstra\Creator $creator){
  $point = $creator->addPoint(1)
                   ->addRelation(2, 5);

  $creator->addPoint(3)
          ->addRelation($point, 8)
          ->addRelation(2, 3);
}); # Algorithms\Dijkstra
