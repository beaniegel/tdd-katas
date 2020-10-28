<?php

declare(strict_types=1);

namespace jellybean;


use InvalidArgumentException;
use function PHPUnit\Framework\throwException;

class RomanNumeral
{
    const MULTIPLIER = [
        'ones' => 1,
        'tens' => 10,
        'hundreds' => 100
    ];

    const HUNDREDS = [
        100 => 'C',
        200 => 'CC',
        300 => 'CCC',
        400 => 'CD',
        500 => 'D',
        600 => 'DC',
        700 => 'DCC',
        800 => 'DCCC',
        900 => 'CM'
    ];

    const THOUSANDS = [
        1000 => 'M',
        2000 => 'MM',
        3000 => 'MMM'
    ];

    public function fromInteger(int $input) {
        $this->validateInput($input);
        $numeral = '';

        if ($input >= 100) {
            $numeral .= $this->convertHundreds($input, 100);
        }
        else if ($input >= 10) {
            $numeral .= $this->convertTens($input, 10);
        } else {
            $numeral .= $this->convertOnes($input, 1);
        }

        return $numeral;
    }

    private function validateInput(int $input)
    {
        if ($input <= 0 || $input >= 4000) {
            throw new InvalidArgumentException('Integer should be higher than 0 and lower than 4000');
        }
    }

    private function convertOnes(int $input)
    {
        $numeral = '';

        if ($input === 9) {
            return 'IX';
        }
        if ($input === 4) {
            return 'IV';
        }
        if ($input >= 5) {
          $numeral = 'V';
          $input -= 5;
        }

        $numeral .= str_repeat('I', $input);

        return $numeral;
    }

    private function convertTens(int $input)
    {
        $numeral = '';

        if ($input === 90) {
            return 'XC';
        }
        if ($input === 40) {
            return 'XL';
        }
        if ($input >= 50) {
            $numeral = 'L';
            $input -= 50;
        }

        $numeral .= str_repeat('X', $input / 10);

        return $numeral;
    }

    private function convertHundreds(int $input)
    {
        $numeral = '';

        if ($input === 900) {
            return 'CM';
        }
        if ($input === 400) {
            return 'CD';
        }
        if ($input >= 500) {
            $numeral = 'D';
            $input -= 500;
        }

        $numeral .= str_repeat('C', $input / 100);

        return $numeral;
    }
}