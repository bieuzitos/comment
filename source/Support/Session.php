<?php

namespace Source\Support;

use Source\Support\Message;

/**
 * Class Session
 * 
 * @package Source\Support
 */
class Session
{
    /**
     * @return void
     */
    public function __construct()
    {
        if (!session_id()) {
            session_start();
        }
    }

    /**
     * @param mixed $name
     * 
     * @return mixed|null
     */
    public function __get($name)
    {
        if (!empty($_SESSION[$name])) {
            return $_SESSION[$name];
        }

        return null;
    }

    /**
     * @param mixed $name
     * 
     * @return bool
     */
    public function __isset($name)
    {
        return $this->has($name);
    }

    /**
     * @param string $key
     * 
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @return object|null
     */
    public function all(): ?object
    {
        return (object)$_SESSION;
    }

    /**
     * @param string $key
     * @param mixed $value
     * 
     * @return Session
     */
    public function set(string $key, mixed $value): Session
    {
        $_SESSION[$key] = (is_array($value) ? (object)$value : $value);
        return $this;
    }

    /**
     * @param string $key
     * 
     * @return Session
     */
    public function unset(string $key): Session
    {
        unset($_SESSION[$key]);
        return $this;
    }

    /**
     * @return Session
     */
    public function regenerate(): Session
    {
        session_regenerate_id(true);
        return $this;
    }

    /**
     * @return Session
     */
    public function destroy(): Session
    {
        session_destroy();
        return $this;
    }

    /**
     * @return Message|null
     */
    public function flash(): Message|null
    {
        if ($this->has('flash')) {
            $flash = $this->flash;
            $this->unset('flash');
            return $flash;
        }

        return null;
    }
}
