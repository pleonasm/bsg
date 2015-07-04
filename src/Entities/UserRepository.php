<?php
namespace Pleo\BSG\Entities;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function newUserUnsafe($displayName, $username, $password, $phone, $flush = true)
    {
        $id = mt_rand(1, mt_getrandmax());
        $user = new User($id, $displayName, $username, $password, $phone);
        $this->_em->persist($user);
        if ($flush) {
            $this->_em->flush();
        }
    }

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
