<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidSin implements Rule
{
    /**
     * source: https://github.com/pear/Validate_CA/blob/master/Validate/CA.php
     * Validates a number according to Luhn check algorithm
     *
     * This function checks given number according Luhn check
     * algorithm. It is published on several places, see links:
     *
     * @param string $number number to check
     *
     * @return bool    TRUE if number is valid, FALSE otherwise
     * @access protected
     * @static
     * @link http://www.webopedia.com/TERM/L/Luhn_formula.html
     * @link http://www.merriampark.com/anatomycc.htm
     * @link http://hysteria.sk/prielom/prielom-12.html#3 (Slovak language)
     * @link http://www.speech.cs.cmu.edu/~sburke/pub/luhn_lib.html (Perl lib)
     */
    private function luhn(string $number): bool
    {
        $len_number = strlen($number);
        $sum = 0;
        for ($k = $len_number % 2; $k < $len_number; $k += 2) {
            if ((intval($number[$k]) * 2) > 9) {
                $sum += (intval($number[$k]) * 2) - 9;
            } else {
                $sum += intval($number[$k]) * 2;
            }
        }
        for ($k = ($len_number % 2) ^ 1; $k < $len_number; $k += 2) {
            $sum += intval($number[$k]);
        }

        return ($sum % 10) ? false : true;
    }

    /**
     * source: https://github.com/pear/Validate_CA/blob/master/Validate/CA.php
     * Validates a Canadian social insurance number (SIN)
     *
     * For unification between country-based validation packages,
     * this method is named ssn()
     *
     * @param string $ssn        number to validate
     * @param int    $expiryDate expiry date for SIN starting
     *                           with a 9 (UNIX timestamp)
     *
     * @return bool
     * @link http://www.hrsdc.gc.ca/en/hip/lld/cesg/promotersection/files/Interface_Transaction_Standards_V301_English.pdf
     */
    private function ssn(string $ssn, int $expiryDate = null): bool
    {
        // remove any dashes, spaces, returns, tabs or slashes
        $ssn = str_replace(array('-', '/', ' ', "\t"), '', trim($ssn));
        // Basic checking
        if (($len = strlen($ssn)) != 9
            || strspn($ssn, '0123456789') != $len
            || ($ssn[0] == '9' && $expiryDate <= time())
            || $ssn[0] == '0' || $ssn[0] == '8'
        ) {
            return false;
        }

        return $this->luhn($ssn);
    }

    public function passes($attribute, $value)
    {
        return $this->ssn($value);
    }

    public function message()
    {
        return 'Invalid SIN.';
    }
}
