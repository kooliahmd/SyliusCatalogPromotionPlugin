<?php

namespace SnakeTn\CatalogPromotion\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Resource\Model\ResourceInterface;

class Promotion implements ResourceInterface
{
    private $id;
    private $code;
    private $name;
    private $description;
    private $priority;
    private $exclusive;
    private $startsAt;
    private $endsAt;
    private $createdAt;
    private $updatedAt;

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
    public function getCode()
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

    /**
     * @return \Sylius\Component\Core\Model\ChannelPricingInterface[]
     */
    public function getChannels()
    {
        return $this->channels;
    }



    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }



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

    public function addAction(PromotionAction $action)
    {
        $this->actions->add($action);
    }

    public function addRule(PromotionRule $rule)
    {
        $this->rules->add($rule);
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


}
