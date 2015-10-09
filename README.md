# Dijkstra's algorithm
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ventaquil/Dijkstra-s-algorithm/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ventaquil/Dijkstra-s-algorithm/?branch=master) [![Build Status](https://travis-ci.org/ventaquil/Dijkstra-s-algorithm.svg?branch=master)](https://travis-ci.org/ventaquil/Dijkstra-s-algorithm) [![Code Climate](https://codeclimate.com/github/ventaquil/Dijkstra-s-algorithm/badges/gpa.svg)](https://codeclimate.com/github/ventaquil/Dijkstra-s-algorithm)

## How to use
### Create connections between points
#### Array method

```php
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
```

#### Creator method

```php
  $dijkstra = new Algorithms\Dijkstra(function(Algorithms\Dijkstra\Creator $creator){
    $point = $creator->addPoint(1)
                     ->addRelation(2, 5);
    $creator->addPoint(3)
            ->addRelation($point, 8)
            ->addRelation(2, 3);
  }); # Algorithms\Dijkstra
```

### Generate distances
#### Generate from one point to others

```php
  var_dump($dijkstra->distances(1));
```

#### Generate routes all over the graph

```php
  var_dump($dijkstra->generate());
```

## API
### `Algorithms\Dijkstra` methods
#### `public __construct(array|null $relations = null)`
If `$relations` is not empty method execute `setRelations(array $relations)` method.

* * *

#### `public setRelations(array $relations)`
If `$relations` is valid array then `public $relations` has been assigned `$relations.`

If `$relations` is `Closure` object then function was executed. After execute `public createConnections(void)` method result has ben assigned to `public $relations`.

* * *

#### `public generate(void)`
Method generate the shortest ways between all points in `public $relations` array.

* * *

#### `private d(int $source, int $point, array &$visited = array())`
Method generate the shortest ways from `$source` to other points. `$point` and `$visited` variables is help-variables. At start `$point` should be equal `$source`.

* * *

#### `public distances(int $point)`
Alias for `d(int $source, int $point, array &$visited = array())`.

* * *

#### `private static validate(array $relations_array)`
Method validates `$relations_array` and if wrong data sent (or array is not builded correctly) then returns false - otherwise true.

* * *

### `Algorithms\Dijkstra\Creator` methods
#### `public addPoint(int|Algorithms\Dijkstra\Point $point)`
`$point` variable is point ID or `Algorithms\Dijkstra\Point` object.

Method adds point to current `Algorithms\Dijkstra\Creator` object.

* * *

#### `public getPointOrFail(int $point_id)`
Method get from currenct `Algorithms\Dijkstra\Creator` object point which ID is `$point_id`. If point exists return `Algorithms\Dijkstra\Point` object, otherwise throw `Algorithms\Dijkstra\PointException`.

* * *

#### `public getPoint(int $point_id)`
Method working like `getPointOrFail()` but when point not exists return `NULL`.

* * *

#### `public createConnections(void)`
Method returns `array` of relations between points in current `Algorithms\Dijkstra\Creator` object.

* * *

### `Algorithms\Dijkstra\Point` methods
#### `public __construct(int $point_id)`
Method creates new `Algorithms\Dijkstra\Point` object with `$point_id` ID. If `$point_id` is not int method throws `Algorithms\Dijkstra\PointException`.

* * *

#### `public static create(int $point_id)`
Method create new `Algorithms\Dijkstra\Point` object with `$point_id` as ID.

* * *

#### `static validate(int|Algorithms\Dijkstra\Point $point)`
Method check `$point` variable and return `$point` where it is an `int`, return point ID where it is the `Algorithms\Dijkstra\Point` object or throw `Algorithms\Dijkstra\PointException` otherwise.

* * *

#### `public addRelation(int|Algorithms\Dijkstra\Point $point, int $distance)`
Add value to private `$distances` array between current point and point which is equal `$point` or ID is equal `$point`. When `$point` variable is not an `int` or `Algorithms\Dijkstra\Point` object method throws `Algorithms\Dijkstra\PointException`.

* * *

#### `public getDinstances(void)`
Get all distances from this point to others which are connected with current.

* * *

#### `public distanceTo(int|Algorithms\Dijkstra\Point $point)`
Method returns distance to point which equal to `$point` or point ID is equal to `$point`.

* * *

#### `public getID(void)`
This method returns ID of current point.

* * *

## Install from Composer

#### Execute

    composer require algorithms/dijkstra

After use by `Algorithms/Dijkstra` class.
