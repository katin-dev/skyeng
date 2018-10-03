<?php
/**
 * Суммирует большие числа, представленные строками
 * @param string $a
 * @param string $b
 * @return string
 * @throws Exception
 */
function sum_big_numbers($a, $b)
{
    if (!preg_match('/^\d+$/', $a)) throw new Exception('First argument is not a number');
    if (!preg_match('/^\d+$/', $b)) throw new Exception('Second argument is not a number');

    $lengthA = strlen($a);
    $lengthB = strlen($b);

    // Для удобства сделаем строки, предствляющие числа, одинаковой длины.
    // Для этого дополним их слева нулями
    if ($lengthA > $lengthB) {
        $b = str_repeat('0', $lengthA - $lengthB) . $b;
    } elseif($lengthA < $lengthB) {
        $a = str_repeat('0', $lengthB - $lengthA) . $a;
    }

    $a = '0' . $a;
    $b = '0' . $b;

    $length = strlen($a);

    $result = str_repeat('0', $length);

    $add = 0;
    for ($i = $length - 1; $i >= 0; $i--) {
        // сложим цифры текущего разряда
        $s = intval($a[$i]) + intval($b[$i]) + $add;

        // Надо ли перенести единичку в следующий разряд
        if ($s >= 10) {
            $add = 1;
            $s = $s - 10;
        } else {
            $add = 0;
        }

        $result[$i] = $s;
    }

    return ltrim($result, '0');
}
