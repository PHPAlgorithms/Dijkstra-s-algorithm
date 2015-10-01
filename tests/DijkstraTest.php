<?php
class DijkstraTest extends PHPUnit_Framework_TestCase {
  public function testSingleDistance(){
    require_once('./src/Algorithms/Dijkstra.php'); # Require class

    $dijkstra=new \Algorithms\Dijkstra; # Create new object
    $this->assertNotEmpty($dijkstra);

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
    $this->assertNotEmpty($dijkstra);

		$distances=$dijkstra->distances(1); # Distances from first point
		$this->assertEquals(4,count($distances));
		$this->assertEquals(2,$distances[4][0]);
		$this->assertEquals('1:4:3',$distances[3][1]);

		$all_distances=$dijkstra->generate(); # All distances
		$this->assertEquals(5,count($all_distances));
		$this->assertEquals(5,count($all_distances[1]));
		$this->assertEquals(0,$all_distances[1][1][0]);
		$this->assertEquals('',$all_distances[1][1][1]);
		$this->assertEquals($distances[4][0],$all_distances[1][4][0]);
		$this->assertEquals($distances[3][1],$all_distances[1][3][1]);
  } # testSingleDistance()
} # DijkstraTest
