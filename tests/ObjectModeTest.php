<?php
class ObjectModeTest extends PHPUnit_Framework_TestCase {
  public function testMode(){
    // Require classes
    require_once('./src/Algorithms/Dijkstra.php');
    require_once('./src/Algorithms/Dijkstra/Creator.php');
    require_once('./src/Algorithms/Dijkstra/Point.php');

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

		$dijkstra=new \Algorithms\Dijkstra($relations); # Create new object with relations
    $new_dijkstra=new \Algorithms\Dijkstra(function(\Algorithms\Dijkstra\Creator $creator){
      $creator->addPoint(1)
              ->addRelation(2, 1)
              ->addRelation(4, 2);

      $creator->addPoint(2)
              ->addRelation(1, 1)
              ->addRelation(3, 3)
              ->addRelation(4, 3);

      $creator->addPoint(3)
              ->addRelation(2, 3)
              ->addRelation(4, 1)
              ->addRelation(5, 5);

      $creator->addPoint(4)
              ->addRelation(1, 2)
              ->addRelation(2, 3)
              ->addRelation(3, 1)
              ->addRelation(5, 1);

      $creator->addPoint(5)
              ->addRelation(3, 5)
              ->addRelation(4, 1);
    }); # $new_dijkstra
    $this->assertNotEmpty($new_dijkstra);

		$distances=$dijkstra->distances(1); # Distances from first point
		$new_distances=$new_dijkstra->distances(1); # Distances from first point
		$this->assertEquals($distances, $new_distances);

		$all_distances=$dijkstra->generate(); # All distances
		$new_all_distances=$new_dijkstra->generate(); # All distances
		$this->assertEquals($all_distances, $new_all_distances);
  } # testMode()
} # ObjectModeTest
