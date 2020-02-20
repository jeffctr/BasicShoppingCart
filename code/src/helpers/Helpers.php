<?php
namespace Shopping\helpers;

class Helpers
{
    /**
     * Check that the number provided is a valid integer
     *
     * @param mixed $val
     * @return bool
     */
    static function checkNumber($val): bool
    {
        try {
            return is_int((int) $val);
        } catch (Exception $e) {
            return false;
        }
    }
}
