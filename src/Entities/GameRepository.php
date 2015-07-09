<?php
namespace Pleo\BSG\Entities;

use Doctrine\ORM\EntityRepository;

class GameRepository extends EntityRepository
{
    /**
     * @param string $title
     * @param User $owner
     * @param int $expansions
     * @param GamePlayer[] $players
     * @param bool $flush
     * @return Game
     */
    public function createGameUnsafe($title, User $owner, $expansions, array $players, $flush = true)
    {
        $id = mt_rand(1, mt_getrandmax());
        $game = new Game($id, $title, $owner, $expansions, $players);
        $this->_em->persist($game);
        if ($flush) {
            $this->_em->flush();
        }
        return $game;
    }
}
