<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use Respect\Validation\Validator;

/**
 * Class UserAccount
 * 
 * @package Source\Models
 */
class UserAccount extends DataLayer
{
    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct('user_account', ['username']);
    }

    /**
     * @return object|null
     */
    public static function account(): object|null
    {
        $session = session();
        if (!$session->has('USER_ACCOUNT')) {
            return null;
        }

        $user_account = (new UserAccount())->findById($session->USER_ACCOUNT);
        if (!Validator::notBlank()->validate($user_account)) {
            $session->unset('USER_ACCOUNT');
            $session->destroy();
            return null;
        }

        return $user_account;
    }
}
