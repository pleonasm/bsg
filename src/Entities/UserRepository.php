<?php
namespace Pleo\BSG\Entities;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @param $username
     * @param $password
     * @return User|boolean Returns the User object on success or false on failure
     */
    public function authenticate($username, $password)
    {
        $result = $this->findBy(['username' => $username]);

        assert(!(count($result) > 1), "We should never have more than 1 record for a given username");

        if (count($result) === 0) {
            // TODO: insert fake hash here to stop ability to fish for valid usernames via timing
            return false;
        }

        /** @var User $result */
        $result = $result[0];
        if ($password === $result->password()) {
            return $result;
        }

        return false;
    }
}
