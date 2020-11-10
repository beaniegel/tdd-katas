<?php


namespace jellybean;


use InvalidArgumentException;

class StringCalculator
{
    public function add(string $string): int
    {
        $numbers = \explode(",", $string);
        return \array_sum($numbers);
    }
}