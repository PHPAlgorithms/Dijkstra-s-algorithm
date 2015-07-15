<?php
namespace algorithms;

class dijkstra {
    protected $points;
    protected $relations;

    /*
     * @arg^: (array) relations array
     * @desc: Method set relations if sent data is array, otherwise do nothing.
     */
    public function __construct($relations_array=NULL){
        if(!empty($relations_array)&&is_array($relations_array)){
            $this->setRelations($relations_array);
        } # if()
    } # __construct()

    /*
     * @arg: (array) relations array
     * @desc: Method put relations to $relations protected variable.
     */
    public function setRelations($relations_array){
        if(is_array($relations_array)){
            $this->relations=$relations_array;
        } # if()
    } # setRelations()

    /*
     * @ret: (array) array contains the shortest ways
     * @desc: Method analyze all relations from $relations variable.
     */
    public function generate(){
        $result=[]; # Prepare results array

        # Analyze all relations
            foreach($this->relations as $point=>$relation){
                # Prepare $points array by isset source point
                    $this->points=[
                        $point=>[
                            0,
                            '',
                        ], # []
                    ]; # $this->points

                $this->d($point,$point);
                $result[$point]=$this->points; # Copy $points content to results array
            } # foreach()

        return $result;
    } # generate()

    /*
     * @arg: (int) source point
     * @arg: (int) already analised point
     * @arg&^: (array) already visited points
     * @desc: Method analyzes current point, point neighborhood and go by minimum way to unvisited point.
     */
    public function d($source,$point,&$visited=[]){
        $visited[$point]=TRUE; # Set current point as visited

        # Prepare help variables
            $min_ptr=-1;
            $min=0;

        # Analyzes point neighborhood
            foreach($this->relations[$point] as $relation){
                if($relation[0]!=$source){ # If current point is different than source
                    if(empty($visited[$relation[0]])){ # If current point is not visited
                        if($min_ptr==-1){ # When minimal point is not finded
                            $min_ptr=$relation[0];
                            $min=$relation[1];
                        } # if()
                        else{
                            if($min>$relation[1]){
                                $min_ptr=$relation[0];
                                $min=$relation[1];
                            } # if()
                        } # else
                    } # if()

                    # Change the shortest way to current point
                        if(empty($this->points[$relation[0]])){
                            $this->points[$relation[0]]=[
                                $this->points[$point][0]+$relation[1],
                                ((empty($this->points[$point][1]))?$point:$this->points[$point][1]).':'.$relation[0],
                            ]; # $this->points[]
                        } # if()
                        else{
                            if($this->points[$relation[0]][0]>$this->points[$point][0]+$relation[1]){
                                $this->points[$relation[0]]=[
                                    $this->points[$point][0]+$relation[1],
                                    ((empty($this->points[$point][1]))?NULL:$this->points[$point][1].':').$relation[0],
                                ]; # $this->points[]
                            } # if()
                        } # else
                } # if()
            } # foreach()

        # If isset unvisited point with minimal way go for it
            if($min_ptr!=-1){
                $this->d($source,$min_ptr,$visited);
            } # if()
    } # d()
} # dijkstra
