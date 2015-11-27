# Dijkstra's algorithm
[![Latest Stable Version](https://poser.pugx.org/algorithms/dijkstra/v/stable)](https://packagist.org/packages/algorithms/dijkstra) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PHPAlgorithms/Dijkstra-s-algorithm/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PHPAlgorithms/Dijkstra-s-algorithm/?branch=master) [![Build Status](https://travis-ci.org/PHPAlgorithms/Dijkstra-s-algorithm.svg?branch=master)](https://travis-ci.org/PHPAlgorithms/Dijkstra-s-algorithm) [![Code Climate](https://codeclimate.com/github/PHPAlgorithms/Dijkstra-s-algorithm/badges/gpa.svg)](https://codeclimate.com/github/PHPAlgorithms/Dijkstra-s-algorithm)

## How to use
### Create connections between points
#### Array method

```php
    $relations = [
        1 => [ // point 1 relations
            [2, 1], // to point 2 - distance 1
            [4, 2], // to point 4 - distance 2
        ],
        2 => [ // point 2 relations
            [1, 1], // to point 1 - distance 1
            [3, 3], // to point 3 - distance 3
            [4, 3], // to point 4 - distance 3
        ],
        3 => [ // point 3 relations
            [2, 3], // to point 2 - distance 3
            [4, 1], // to point 4 - distance 1
            [5, 5], // to point 5 - distance 5
        ],
        4 => [ // point 4 relations
            [1, 2], // to point 1 - distance 2
            [2, 3], // to point 2 - distance 3
            [3, 1], // to point 3 - distance 1
            [5, 1], // to point 5 - distance 1
        ],
        5 => [ // point 5 relations
            [3, 5], // to point 3 - distance 5
            [4, 1], // to point 4 - distance 1
        ],
    ];
    $dijkstra = new Algorithms\Dijkstra($relations);
```

#### Creator method

```php
    $dijkstra = new Algorithms\Dijkstra(function (Algorithms\GraphTools\Creator $creator) {
        $point = $creator->addPoint(1)
                         ->addRelation(2, 5);
        $creator->addPoint(3)
                ->addRelation($point, 8)
                ->addRelation(2, 3);
    });
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

#### `private dist(int $source, int $point, array &$visited = array())`
Method generate the shortest ways from `$source` to other points. `$point` and `$visited` variables is help-variables. At start `$point` should be equal `$source`.

* * *

#### `public distances(int $point)`
Alias for `d(int $source, int $point, array &$visited = array())`.

* * *

#### `private static validate(array $relations_array)`
Method validates `$relations_array` and if wrong data sent (or array is not builded correctly) then returns false - otherwise true.

* * *

## Install from Composer

#### Execute

        composer require algorithms/dijkstra

After use by `Algorithms/Dijkstra` class.
