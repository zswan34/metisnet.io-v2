<?php 

namespace App\Libs;

use Adldap\AdldapInterface;

class Ldap {

    protected static $ldap;

    public function __construct(AdldapInterface $ldap)
    {
        self::$ldap = $ldap;
    }

    public static function getListing()
    {
        //
    }

    public static function getByEmail($email) {
        return self::$ldap->search()->where('mail', $email)->first();
    }
}