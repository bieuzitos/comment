<?php

use Source\Models\UserAccount;

use Respect\Validation\Validator;

/*
|--------------------------------------------------------------------------
| Session Start
|--------------------------------------------------------------------------
*/

$session = session();

/**
 * @return \Source\Support\Session
 */
function session(): \Source\Support\Session
{
    return new \Source\Support\Session();
}

/*
|--------------------------------------------------------------------------
| Session Login
|--------------------------------------------------------------------------
|
| Esta função é utilizada exclusivamente para fins de demonstração e NÃO 
| deve ser usada em ambiente de produção.
| 
| Ela atribui um ID de usuário aleatório à sessão, simbolizando o login 
| de um usuário fictício para propósitos de teste e demonstração.
|
*/

if (!session()->has('USER_ACCOUNT')) {
    session()->set('USER_ACCOUNT', mt_rand(1, 5));
}

/*
|--------------------------------------------------------------------------
| Session Notification
|--------------------------------------------------------------------------
*/

/**
 * @return string|null
 */
function flash(): string|null
{
    if ($flash = session()->flash()) {
        return $flash;
    }

    return null;
}

/*
|--------------------------------------------------------------------------
| Session Account
|--------------------------------------------------------------------------
*/

/**
 * @return bool
 */
function isLoggedIn(): bool
{
    if (Validator::notBlank()->validate(getAccount())) {
        return true;
    }

    return false;
}

/**
 * @return object|null
 */
function getAccount(): object|null
{
    return UserAccount::account();
}

/**
 * @return int|null
 */
function getAccountId(): int|null
{
    if (Validator::notBlank()->validate(getAccount())) {
        return getAccount()->id;
    }

    return null;
}

/**
 * @return string|null
 */
function getAccountUsername(): string|null
{
    if (Validator::notBlank()->validate(getAccount())) {
        return getAccount()->username;
    }

    return null;
}

/**
 * @return string|null
 */
function getAccountAvatar(string $username = null): string|null
{
    if (!Validator::notBlank()->validate($username)) {
        $username = getAccount()->username;
    }

    if (Validator::notBlank()->validate(getAccount())) {
        return 'https://www.gravatar.com/avatar/' . md5($username) . '?d=wavatar';
    }

    return null;
}
