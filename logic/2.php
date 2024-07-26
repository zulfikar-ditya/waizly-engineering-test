<?php

/**
 * Calculate the minimum and maximum sums of an array of integers
 * 
 * @param array $arr An array of integers
 */
function miniMaxSum($arr): void
{
    $totalSum = array_sum($arr);

    // Initialize the min and max sums
    $minSum = PHP_INT_MAX;
    $maxSum = PHP_INT_MIN;

    // Loop through the array and calculate the sums
    foreach ($arr as $num) {
        $currentSum = $totalSum - $num;
        $minSum = min($minSum, $currentSum);
        $maxSum = max($maxSum, $currentSum);
    }

    echo $minSum . " " . $maxSum;
}

// Example usage:
$arr = [1, 2, 3, 4, 5];
miniMaxSum($arr);


/**
 * Calculate the ratio of positive, negative, and zero numbers in an array
 * 
 * @param array $arr An array of integers
 */
function plusMinus($arr): void
{
    // Count the number of positive, negative, and zero numbers
    $n = count($arr);
    $positiveCount = 0;
    $negativeCount = 0;
    $zeroCount = 0;

    // Loop through the array and count the numbers
    foreach ($arr as $num) {
        if ($num > 0) {
            $positiveCount++;
        } elseif ($num < 0) {
            $negativeCount++;
        } else {
            $zeroCount++;
        }
    }

    // Calculate the ratios
    $positiveRatio = number_format($positiveCount / $n, 6);
    $negativeRatio = number_format($negativeCount / $n, 6);
    $zeroRatio = number_format($zeroCount / $n, 6);

    echo $positiveRatio . "\n";
    echo $negativeRatio . "\n";
    echo $zeroRatio . "\n";
}

// Example usage:
$arr = [-4, 3, -9, 0, 4, 1];
plusMinus($arr);
