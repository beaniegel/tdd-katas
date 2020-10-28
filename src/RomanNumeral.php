<?php

declare(strict_types=1);

namespace jellybean;


use InvalidArgumentException;

class RomanNumeral
{
    const THOUSANDS = 0;
    const HUNDREDS = 1;
    const TENS = 2;
    const ONES = 3;

    public function fromInteger(int $input) {
        $this->validateInput($input);

        $input = $this->partitionInput($input);
        $numeral = $this->convert($input[self::THOUSANDS], 'M');
        $numeral .= $this->convert($input[self::HUNDREDS], 'C', 'D', 'M');
        $numeral .= $this->convert($input[self::TENS], 'X', 'L', 'C');
        $numeral .= $this->convert($input[self::ONES], 'I', 'V', 'X');

        return $numeral;
    }

    private function validateInput(int $input)
    {
        if ($input <= 0 || $input >= 4000) {
            throw new InvalidArgumentException('Integer should be higher than 0 and lower than 4000');
        }
    }

    private function partitionInput(int $input, int $divider = 1000, array $partitionedInput = []): array
    {
        if ($divider === 1) {
            array_push($partitionedInput, $input);
            return $partitionedInput;
        }

        $partition = (int) floor($input / $divider);
        array_push($partitionedInput, $partition);

        return $this->partitionInput($input % $divider, $divider / 10, $partitionedInput);
    }

    private function convert(int $input, string $lowRoman, string $mediumRoman = '', string $highRoman = ''): string
    {
        $numeral = '';

        if ($input === 0) {
            return $numeral;
        }
        if ($input === 9) {
            return $lowRoman . $highRoman;
        }
        if ($input === 4) {
            return $lowRoman . $mediumRoman;
        }
        if ($input >= 5) {
          $numeral .= $mediumRoman;
          $input -= 5;
        }

        return $numeral . str_repeat($lowRoman, $input);
    }
}