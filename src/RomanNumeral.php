<?php

declare(strict_types=1);

namespace jellybean;

use function array_push;
use function floor;
use function str_repeat;
use InvalidArgumentException;

final class RomanNumeral
{
    private const THOUSANDS = 0;
    private const HUNDREDS = 1;
    private const TENS = 2;
    private const ONES = 3;

    private int $digit;
    private string $value;

    private function __construct(int $digit)
    {
        $this->validateInput($digit);

        $this->digit = $digit;
        $this->value = $this->convert();
    }

    public static function fromInteger(int $digit): self
    {
        return new self($digit);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function asDigit(): int
    {
        return $this->digit;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function validateInput(int $input): void
    {
        if ($input <= 0 || $input >= 4000) {
            throw new InvalidArgumentException('Integer should be higher than 0 and lower than 4000');
        }
    }

    private function convert(): string
    {
        $partitions = $this->partition($this->digit);

        $numeral = $this->convertPartition($partitions[self::THOUSANDS], 'M');
        $numeral .= $this->convertPartition($partitions[self::HUNDREDS], 'C', 'D', 'M');
        $numeral .= $this->convertPartition($partitions[self::TENS], 'X', 'L', 'C');
        $numeral .= $this->convertPartition($partitions[self::ONES], 'I', 'V', 'X');

        return $numeral;
    }

    /**
     * Takes $value and partitions it into [thousands, hundreds, tens, ones].
     * e.g.: 234 = [0,2,3,4]    1 = [0,0,0,1]       2325 = [2,3,2,5]
     *
     * @return int[]
     */
    private function partition(int $value, int $divider = 1000, array $partitions = []): array
    {
        if ($divider === 1) {
            array_push($partitions, $value);
            return $partitions;
        }

        $partition = (int) floor($value / $divider);
        array_push($partitions, $partition);

        $valueForNextPartition = $value % $divider;
        $dividerForNextPartition = $divider / 10;

        return $this->partition($valueForNextPartition, $dividerForNextPartition, $partitions);
    }

    private function convertPartition(int $partition, string $lowRoman, ?string $mediumRoman = null, ?string $highRoman = null): string
    {
        $numeral = '';

        if ($partition === 0) {
            return $numeral;
        }
        if ($partition === 4) {
            return $lowRoman . $mediumRoman;
        }
        if ($partition === 9) {
            return $lowRoman . $highRoman;
        }
        if ($partition >= 5) {
          $numeral .= $mediumRoman;
          $partition -= 5;
        }

        return $numeral . str_repeat($lowRoman, $partition);
    }
}
