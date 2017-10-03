<?php

/*
 * This file is part of catalog promotion plugin for Sylius.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace SnakeTn\CatalogPromotion\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Channel\Model\ChannelInterface;

class Promotion implements ResourceInterface, CodeAwareInterface
{
    use TimestampableTrait;
    private $id;
    private $code;
    private $name;
    private $description;
    private $priority = 0;
    private $exclusive;
    private $startsAt;
    private $endsAt;

    /**
     * @var \Sylius\Component\Core\Model\ChannelPricingInterface[]
     */
    private $channels;

    /**
     * @var ArrayCollection|PromotionAction[]
     */
    private $actions;

    /**
     * @var ArrayCollection|PromotionRule[]
     */
    private $rules;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->channels = new ArrayCollection();
        $this->rules = new ArrayCollection();
        $this->actions = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @return mixed
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function isExclusive()
    {
        return $this->exclusive;
    }

    /**
     * @return mixed
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * @return mixed
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }


    public function getChannels()
    {
        return $this->channels;
    }


    public function addChannel(ChannelInterface $channel)
    {
        if (!$this->hasChannel($channel)) {
            $this->channels->add($channel);
        }
    }


    public function removeChannel(ChannelInterface $channel)
    {
        if ($this->hasChannel($channel)) {
            $this->channels->removeElement($channel);
        }
    }


    public function hasChannel(ChannelInterface $channel)
    {
        return $this->channels->contains($channel);
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }


    public function addAction(PromotionAction $action)
    {
        $this->actions->add($action);
        $action->setPromotion($this);
    }


    public function removeAction(PromotionAction $action)
    {
        $action->setPromotion(null);
        $this->actions->removeElement($action);
    }

    public function addRule(PromotionRule $rule)
    {
        $this->rules->add($rule);
        $rule->setPromotion($this);
    }


    public function removeRule(PromotionRule $rule)
    {
        $rule->setPromotion(null);
        $this->rules->removeElement($rule);
    }

    /**
     * @return ArrayCollection|PromotionAction[]
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @return ArrayCollection|PromotionRule[]
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param mixed $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $exclusive
     */
    public function setExclusive($exclusive)
    {
        $this->exclusive = $exclusive;
    }

    /**
     * @param mixed $startsAt
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @param mixed $endsAt
     */
    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }


}
