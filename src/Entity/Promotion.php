<?php

namespace SnakeTn\CatalogPromotion\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Promotion
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
