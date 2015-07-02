<?php
namespace Pleo\BSG;

class Session
{
    /**
     * @var boolean
     */
    private $started;

    /**
     * @param string $key
     * @param mixed $val
     */
    public function set($key, $val)
    {
        if (!$this->started) {
            session_start();
            $this->started = true;
        }

        $_SESSION[$key] = $val;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (!$this->started) {
            session_start();
            $this->started = true;
        }

        if (!isset($_SESSION[$key])) {
            return $default;
        }

        return $_SESSION[$key];
    }
}
