<?php
namespace Pleo\BSG\Entities;

use Doctrine\ORM\EntityRepository;

class GameRepository extends EntityRepository
{
    /**
     * @param string $title
     * @param User $owner
     * @param bool $flush
     * @return Game
     */
    public function createGameUnsafe($title, User $owner, $flush = true)
    {
        $id = mt_rand(1, mt_getrandmax());
        $game = new Game($id, $title, $owner);
        $this->_em->persist($game);
        if ($flush) {
            $this->_em->flush();
        }
        return $game;
    }
}
