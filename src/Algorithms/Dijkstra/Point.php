<?php
namespace Algorithms\Dijkstra;

class Point {
  private $id;
  private $distances=array();

  public function __construct($point_id){
    $point_id=$this::validate($point_id);

    $this->id=$point_id;

    return $this;
  } # __construct()

  public static function create($point_id){
    return new self($point_id);
  } # create()

  public static function checkPoint($point){
    if($point instanceof self){
      return TRUE;
    } # if()
    else{
      return FALSE;
    } # else
  } # checkPoint

  public static function validate($point){
    if(is_int($point)){
      return $point;
    } # if()
    elseif(self::checkPoint($point)){
      return $point->getID();
    } # elseif()
    else{
      throw new PointException('Wrong data sent');
    } # else
  } # validate()

  public function addRelation($point,$distance){
    $point=$this::validate($point);

    $this->distances[$point]=$distance;

    return $this;
  } # addRelation()

  public function getDinstances(){
    $distances=array();

    foreach($this->distances as $point_id=>$distance){
      $distances[]=[$point_id,$distance];
    } # foreach()

    return $distances;
  } # getDistances();

  public function distanceTo($point){
    $point=$this::validate($point);

    if(isset($this->distances[$point])){
      return $this->distances[$point];
    } # if()
    else{
      return FALSE;
    } # else
  } # distanceTo()

  public function getID(){
    return $this->id;
  } # getID()
} # Point
