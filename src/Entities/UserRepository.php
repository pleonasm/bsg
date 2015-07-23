<?php
namespace Pleo\BSG\Entities;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function newUserUnsafe($displayName, $username, $password, $phone, $flush = true)
    {
        $id = mt_rand(1, mt_getrandmax());
        $hashedPasswd = password_hash($password, PASSWORD_DEFAULT);

        if (!$hashedPasswd) {
            throw new \UnexpectedValueException('we dont like this password for some reason');
        }

        $user = new User($id, $displayName, $username, $hashedPasswd, $phone);
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
            password_verify($password, 'password');
            return false;
        }

        /** @var User $result */
        $result = $result[0];
        if (password_verify($password, $result->password())) {
            return $result;
        }

        return false;
    }

    /**
     * @param string $username
     * @return User|null $username
     */
    public function getByUsername($username)
    {
        return $this->findOneBy(['username' => $username]);
    }
}
