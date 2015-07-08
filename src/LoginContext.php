<?php
namespace Pleo\BSG;

use Pleo\BSG\Entities\User;
use Pleo\BSG\Entities\UserRepository;

class LoginContext
{
    const LOGIN_VAR = 'login';

    /**
     * @var Session
     */
    private $session;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var User|null
     */
    private $user;

    /**
     * @param Session $session
     * @param UserRepository $userRepository
     */
    public function __construct(Session $session, UserRepository $userRepository)
    {
        $this->session = $session;
        $this->userRepository = $userRepository;
    }

    /**
     * Returns the user who is logged in, or null if no user is logged in
     * @return User|null
     */
    public function currentUser()
    {
        if (is_null($this->user)) {
            $userId = $this->session->get(static::LOGIN_VAR, null);
            if (null === $userId) {
                return null;
            }
            assert((is_int($userId) && $userId > 0), "Since we're relying on other code to set this, we need to be sure it's correct (a positive integer)");
            $user = $this->userRepository->find($userId);
            if (!$user) {
                assert(false, "We should never have a session existing with a user id that isn't actually in the database...");
                return null;
            }
            $this->user = $user;
        }

        return $this->user;
    }
}
