<?php
function fizzBuzz($start = 1, $stop = 100)
{
  $string = '';

  if($stop < $start || $start < 0 || $stop < 0) {
    throw new InvalidArgumentException;
  }

  for($i = $start; $i <= $stop; $i++) {
    if($i % 3 == 0 && $i % 5 == 0) {
      $string .= 'FizzBuzz';
      continue;
    }

    if($i % 3 == 0) {
      $string .= 'Fizz';
      continue;
    }

    if ($i % 5 == 0) {
      $string .= 'Buzz';
      continue;
    }

    $string .= $i;
  }

  return $string;
}