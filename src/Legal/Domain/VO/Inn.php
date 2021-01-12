<?php
declare(strict_types=1);

namespace Legal\Domain\VO;


use Legal\Domain\Exception\Inn\EmptyInnException;
use Legal\Domain\Exception\Inn\NoValidInnException;
use Legal\Domain\Exception\Inn\NoValidLengthInnException;

final class Inn
{
    private string $inn;


    public function __construct(string $inn) {
        if (empty($inn)) {
            throw new EmptyInnException($inn);
        }
        if (!in_array($inn_length = strlen($inn), [10, 12])) {
            throw new NoValidLengthInnException($inn);
        }
   $this->isInnValid($inn);

        $this->inn = $inn;
    }
    public function getInn(): string {
        return $this->inn;
    }

    /**
     * Проверяет количество символов (10 или 12) и контрольную сумму
     * @param string $inn
     * @return void
     */


    private function isInnValid(string $inn): void {
        $controlArray = [2, 4, 10, 3, 5, 9, 4, 6, 8];
        $givenInn = $inn;
        if (mb_strlen($inn, 'utf-8') === 10) {
            $inn = str_split($inn);
            $summ = array_map(function ($inn, $controlArray) {
                return $inn * $controlArray;
            }, $inn, $controlArray);
            $summArray = (array_sum($summ) % 11) % 10;
            if ($summArray !== (int)$inn[9]) {
                throw new NoValidInnException($givenInn);
            }
        }
    }

}