<?php 

namespace App\Libs;

class Format {

    public static function phone($phone) {
        if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $phone,  $matches ) ||
            preg_match( '/^(\d{3})(\d{3})(\d{4})$/', $phone,  $matches ) )
        {
            $result = '(' . $matches[1] . ') ' .$matches[2] . '-' . $matches[3];
            return $result;
        }
        return $phone;
    }
}