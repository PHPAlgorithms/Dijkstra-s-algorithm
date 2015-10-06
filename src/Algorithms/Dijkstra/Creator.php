<?php
namespace Algorithms\Dijkstra;

class Creator {
  private $points=array();

  public function addPoint($point){
    if(Point::checkPoint($point)){
      $this->points[$point->getID()] = $point;

      return $point;
    } # if()
    else{
      if(!isset($this->points[$point])){
        $new_point = Point::create($point);

        $this->points[$point] = $new_point;

        return $new_point;
      } # if()
      else{
        throw new CreatorException('Point was added earlier');
      } # else
    } # else
  } # addPoint()

  public function getPoint($point_id){
    try{
      return $this->getPointOrFail($point_id);
    } # try
    catch(PointException $e){
      return NULL;
    } # catch()
  } # getPoint()

  public function getPointOrFail($point_id){
    if(isset($this->points[$point_id])){
      return $this->points[$point_id];
    } # if()
    else{
      throw new PointException('Point not exists');
    } # else
  } # getPoint()

  public function createConnections(){
    $relations=array();

    foreach($this->points as $point_id => $point){
      $relations[$point_id] = $point->getDinstances();

      foreach($relations[$point_id] as $array_to_analyze){
        if(!isset($relations[$array_to_analyze[0]])){
          $relations[$array_to_analyze[0]] = array();
        } # if()
      } # foreach()
    } # foreach()

    return $relations;
  } # createConnections()
} # Creator
