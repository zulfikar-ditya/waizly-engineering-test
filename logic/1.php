<?php

/**
 * Calculate the minimum and maximum sums of an array of integers
 * 
 * @param array $arr An array of integers
 * @return void
 */
function miniMaxSum($arr): void
{
    sort($arr);

    // Calculate the minimum and maximum sums
    $minSum = array_sum(array_slice($arr, 0, 4));
    $maxSum = array_sum(array_slice($arr, 1));

    echo $minSum . " " . $maxSum;
}

$arr = [1, 3, 5, 7, 9];
miniMaxSum($arr);
