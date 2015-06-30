# Dijkstra's algorithm

How to use:

```php
    <?php
    use algorithms;

    // Simple relations
    $relations=[
      1=>[
        [2,1],
        [4,2],
      ], # 1
      2=>[
        [1,1],
        [3,3],
        [4,3],
      ], # 2
      3=>[
        [2,3],
        [4,1],
        [5,5],
      ], # 3
      4=>[
        [1,2],
        [2,3],
        [3,1],
        [5,1],
      ], # 4
      5=>[
        [3,5],
        [4,1],
      ], # 5
    ]; # $relations

    $dijkstra=new dijkstra;
    $dijkstra->setRelations($relations);
    $generated=$dijkstra->generate();
```
