<?php

/**
 * Calculate the staircase of a given size
 * 
 * @param int $n The size of the staircase
 */
function timeConversion($s): string
{
    // Extract hour, minute, second, and AM/PM indicator
    $parts = explode(':', $s);
    $hour = (int)$parts[0];
    $minute = $parts[1];
    $second = substr($parts[2], 0, 2);
    $ampm = substr($parts[2], 2);

    // Handle 12 AM case
    if ($hour == 12 && $ampm == 'AM') {
        $hour = 0;
    }

    // Handle PM case
    if ($ampm == 'PM' && $hour != 12) {
        $hour += 12;
    }

    // Format the time in 24-hour format
    return sprintf('%02d:%s:%s', $hour, $minute, $second);
}

timeConversion('12:00:00AM');
timeConversion('12:00:00PM');
timeConversion('01:00:00PM');
timeConversion('01:00:00AM');
