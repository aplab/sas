<?php


namespace App\Service;


use Exception;

/**
 * Class PasswordGenerator
 * @package App\Service
 */
class PasswordGenerator
{
    /**
     * @var string
     * @noinspection SpellCheckingInspection
     */
    const ALGORITHM_CVCVCDCVCVC = 'CVCVCDCVCVC';

    /**
     * @var string
     * @noinspection SpellCheckingInspection
     */
    const ALGORITHM_VCVDDVCV = 'VCVDDVCV';

    /**
     * @var string
     * @noinspection SpellCheckingInspection
     */
    const ALGORITHM_RANDOM = 'RANDOM';

    /**
     * @var string
     * @noinspection SpellCheckingInspection
     */
    const ALGORITHM_RANDOM_EXTENDED = 'RANDOM_EXTENDED';

    /**
     * @var string
     * @noinspection SpellCheckingInspection
     */
    const ALGORITHM_DEFAULT = self::ALGORITHM_RANDOM;

    /**
     * @var int
     */
    const LENGTH_DEFAULT = 8;

    /**
     * @var int
     */
    private $lastPassLength;

    /**
     * @var bool
     */
    public $debug = false;

    /**
     * Сгенерировать пароль
     * vowel consonant algorithm
     *
     * @param string $algorithm
     * @param boolean $various_case
     * @param int $length
     * @return string
     * @throws Exception
     */
    public function generatePassword(
        string $algorithm = self::ALGORITHM_RANDOM,
        bool $various_case = true,
        int $length = self::LENGTH_DEFAULT
    ) : string
    {
        if ($length < self::LENGTH_DEFAULT) {
            throw new Exception('length should be greater or equal ' . self::LENGTH_DEFAULT);
        }
        /** @noinspection SpellCheckingInspection */
        $set[0] = 'bcdfghjkmnpqrstvwxyz';
        $set[3] = $set[0];
        $set[0] .= $various_case ? strtoupper($set[0]) : '';
        $set[3] .= $various_case ? strtoupper($set[0]) : '';
        /** @noinspection SpellCheckingInspection */
        $set[1] = 'aeiu';
        $set[3] .= $set[1];
        $set[1] .= $various_case ? strtoupper($set[1]) : '';
        $set[3] .= $various_case ? strtoupper($set[1]) : '';
        $set[2] = '23456789';
        $set[3] .= $set[2];
        $set[4] = $set[3] . '!@#$%^&*()_+-=.,:;';

        switch ($algorithm) {
            case self::ALGORITHM_VCVDDVCV :
                $algorithm = '10122101';
                break;

            case self::ALGORITHM_CVCVCDCVCVC :
                $algorithm = '01010201010';
                break;

            case self::ALGORITHM_RANDOM :
                $algorithm = str_repeat('3', $length);
                break;

            case self::ALGORITHM_RANDOM_EXTENDED :
                $algorithm = str_repeat('4', $length);
                break;

            default :
                $algorithm = self::ALGORITHM_DEFAULT;
                break;
        }
        if ($this->debug) {
            dump($algorithm);
        }
        $pass = '';
        for ($i = 0; $i < strlen($algorithm); $i++) {
            $num = intval($algorithm[$i]);
            $pass .= substr($set[$num], random_int(0, strlen($set[$num]) - 1), 1);
        }
        $this->lastPassLength = strlen($pass);
        return $pass;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getLastPassLength(): int
    {
        if (is_null($this->lastPassLength)) {
            throw new Exception('generate some one password first');
        }
        return $this->lastPassLength;
    }
}
