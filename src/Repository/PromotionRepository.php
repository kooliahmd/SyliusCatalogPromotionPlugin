<?php

/*
 * This file is part of catalog promotion plugin for Sylius.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SnakeTn\CatalogPromotion\Repository;

use Doctrine\ORM\EntityRepository;
use SnakeTn\CatalogPromotion\Entity\Promotion;
use Sylius\Component\Core\Model\ChannelInterface;

class PromotionRepository extends EntityRepository
{
    /**
     * @param ChannelInterface $channel
     *
     * @return Promotion[]
     */
    public function findActiveByChannel(ChannelInterface $channel)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.startsAt IS NULL OR o.startsAt < :date')
            ->andWhere('o.endsAt IS NULL OR o.endsAt > :date')
            ->andWhere(':channel MEMBER OF o.channels')
            ->setParameter('channel', $channel)
            ->setParameter('date', new \DateTime())
            ->addOrderBy('o.priority', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $entity
     */
    public function add($entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }
}
