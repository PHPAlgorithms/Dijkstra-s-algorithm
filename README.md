# Dijkstra's algorithm [![Latest Stable Version](https://poser.pugx.org/phpalgorithms/dijkstra/v/stable)](https://packagist.org/packages/phpalgorithms/dijkstra) [![Build Status](https://travis-ci.org/PHPAlgorithms/Dijkstra-s-algorithm.svg?branch=master)](https://travis-ci.org/PHPAlgorithms/Dijkstra-s-algorithm) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PHPAlgorithms/Dijkstra-s-algorithm/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PHPAlgorithms/Dijkstra-s-algorithm/?branch=master) [![Code Climate](https://codeclimate.com/github/ventaquil/Dijkstra-s-algorithm/badges/gpa.svg)](https://codeclimate.com/github/ventaquil/Dijkstra-s-algorithm)
My implementation of famous the algorithm for finding the shortest paths in a graph. Discovered by Edsger Dijkstra.

### Composer
Use in your console

    composer require phpalgorithms/dijkstra

### How to use
#### Create connections between points

```php
    $dijkstra = new \PHPAlgorithms\Dijkstra(function (\PHPAlgorithms\Dijkstra\Creator $creator) {
        $creator->addPoint('start');

        $creator->addPoint('another one')
                ->addDoubleRelation($creator->getPoint(0), 10)
                ->addRelation($creator->addPoint(), 3);
    });
```

#### Generate paths from first point

```php
    [...]

    print_r($dijkstra->generate(0)); // \PHPAlgorithms\Dijkstra\Path object
```

#### Generate paths for all points

```php
    [...]

    print_r($dijkstra->generateAll()); // array of \PHPAlgorithms\Dijkstra\Path objects
```

#### Path object important parameters

```php
    [...]

    print_r($pathObj->distance); // how is the path long
    print_r($pathObj->nodes); // all points in this path
```
