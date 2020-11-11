<?php


namespace jellybean;


use InvalidArgumentException;

class StringCalculator
{
    public function add(string $string): int
    {
        $this->validateInput($string);
        $numbers = \explode(",", $string);
        return \array_sum($numbers);
    }

    private function validateInput(string $string): void
    {
        $invalidInput = \preg_match("/[^0-9,]+/", $string);

        if ($invalidInput) {
            throw new InvalidArgumentException('String should only contain numbers separated by a comma');
        }
    }
}