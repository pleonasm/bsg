<?php
namespace Pleo\BSG\Entities;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $displayName;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $phone;

    /**
     * @param int $id
     * @param string $displayName
     * @param string $username
     * @param string $password
     * @param string $phone
     */
    public function __construct($id, $displayName, $username, $password, $phone)
    {
        $this->id = $id;
        $this->displayName = $displayName;
        $this->username = $username;
        $this->password = $password;
        $this->phone = $phone;
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function displayName()
    {
        return $this->displayName;
    }

    /**
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function password()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function phone()
    {
        return $this->phone;
    }
}
