<?php

namespace SnakeTn\CatalogPromotion\Repository;

use Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ChannelInterface;

class PromotionRepository extends EntityRepository
{

    public function findActiveByChannel(ChannelInterface $channel)
    {
        $this->createQueryBuilder('o')
            ->andWhere('o.startsAt IS NULL OR o.startsAt < :date')
            ->andWhere('o.endsAt IS NULL OR o.endsAt > :date')
            ->andWhere(':channel MEMBER OF o.channels')
            ->setParameter('channel', $channel)
            ->setParameter('date',  new \DateTime())
            ->addOrderBy('o.priority', 'DESC')
            ->getResult();
    }
}
