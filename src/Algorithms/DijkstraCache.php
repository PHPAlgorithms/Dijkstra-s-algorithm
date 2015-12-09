<?php
namespace Algorithms;

abstract class DijkstraCache
{
    protected static function cacheMany($currentData, $many)
    {
        if (empty($currentData)) {
            $currentData = $many();
        } else {
            foreach ($many() as $point => $tracks) {
                $currentData = self::cacheOne($currentData, $point, function () use ($tracks) {
                    return $tracks;
                });
            }
        }

        return $currentData;
    }

    protected static function cacheOne($currentData, $point, $one)
    {
        if (empty($currentData[$point])) {
            $currentData[$point] = $one();
        }

        return $currentData;
    }

    public static function loadMany(&$currentData, $callback)
    {
        return self::cacheMany($currentData, $callback);
    }

    public static function loadOne(&$currentData, $point, $callback)
    {
        $currentData = self::cacheOne($currentData, $point, $callback);

        return $currentData[$point];
    }
}
