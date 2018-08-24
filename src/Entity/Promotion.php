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
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\PromotionInterface;
use Sylius\Component\Promotion\Model\PromotionActionInterface;
use Sylius\Component\Promotion\Model\PromotionCouponInterface;
use Sylius\Component\Promotion\Model\PromotionRuleInterface;
use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Channel\Model\ChannelInterface;

/**
 * Class Promotion
 *
 * @package SnakeTn\CatalogPromotion\Entity
 */
class Promotion implements ResourceInterface, CodeAwareInterface, PromotionInterface
{
    use TimestampableTrait;
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $code;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $description;
    /**
     * @var int
     */
    private $priority = 0;
    /**
     * @var bool
     */
    private $exclusive = false;
    /**
     * @var
     */
    private $startsAt;
    /**
     * @var
     */
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

    /**
     * Promotion constructor.
     */
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
    public function getPriority(): int
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function isExclusive(): bool
    {
        return $this->exclusive;
    }

    /**
     * @return mixed
     */
    public function getStartsAt(): ?\DateTimeInterface
    {
        return $this->startsAt;
    }

    /**
     * @return mixed
     */
    public function getEndsAt(): ?\DateTimeInterface
    {
        return $this->endsAt;
    }


    /**
     * @return Collection
     */
    public function getChannels(): Collection
    {
        return $this->channels;
    }


    /**
     * @param ChannelInterface $channel
     */
    public function addChannel(ChannelInterface $channel): void
    {
        if (!$this->hasChannel($channel)) {
            $this->channels->add($channel);
        }
    }

    /**
     * @param ChannelInterface $channel
     */
    public function removeChannel(ChannelInterface $channel): void
    {
        if ($this->hasChannel($channel)) {
            $this->channels->removeElement($channel);
        }
    }

    /**
     * @param ChannelInterface $channel
     *
     * @return bool
     */
    public function hasChannel(ChannelInterface $channel): bool
    {
        return $this->channels->contains($channel);
    }

    /**
     * @return mixed
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }


    /**
     * @param PromotionActionInterface $action
     */
    public function addAction(PromotionActionInterface $action): void
    {
        $this->actions->add($action);
        $action->setPromotion($this);
    }


    /**
     * @param PromotionActionInterface $action
     */
    public function removeAction(PromotionActionInterface $action): void
    {
        $action->setPromotion(null);
        $this->actions->removeElement($action);
    }

    /**
     * @param PromotionRuleInterface $rule
     */
    public function addRule(PromotionRuleInterface $rule): void
    {
        if (!$this->rules->contains($rule)) {
            $this->rules->add($rule);
        }
        $rule->setPromotion($this);
    }


    /**
     * @param PromotionRuleInterface $rule
     */
    public function removeRule(PromotionRuleInterface $rule): void
    {
        $rule->setPromotion(null);
        $this->rules->removeElement($rule);
    }

    /**
     * @return ArrayCollection|PromotionAction[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    /**
     * @return ArrayCollection|PromotionRule[]
     */
    public function getRules(): Collection
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
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $exclusive
     */
    public function setExclusive(?bool $exclusive): void
    {
        $this->exclusive = $exclusive;
    }

    /**
     * @param mixed $startsAt
     */
    public function setStartsAt(?\DateTimeInterface $startsAt): void
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @param mixed $endsAt
     */
    public function setEndsAt(?\DateTimeInterface $endsAt): void
    {
        $this->endsAt = $endsAt;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority(?int $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return int|null
     */
    public function getUsageLimit(): ?int
    {
        // TODO: Implement getUsageLimit() method.
    }

    /**
     * @param int|null $usageLimit
     */
    public function setUsageLimit(?int $usageLimit): void
    {
        // TODO: Implement setUsageLimit() method.
    }

    /**
     * @return int
     */
    public function getUsed(): int
    {
        // TODO: Implement getUsed() method.
    }

    /**
     * @param int $used
     */
    public function setUsed(int $used): void
    {
        // TODO: Implement setUsed() method.
    }

    /**
     *
     */
    public function incrementUsed(): void
    {
        // TODO: Implement incrementUsed() method.
    }

    /**
     *
     */
    public function decrementUsed(): void
    {
        // TODO: Implement decrementUsed() method.
    }

    /**
     * @return bool
     */
    public function isCouponBased(): bool
    {
        // TODO: Implement isCouponBased() method.
    }

    /**
     * @param bool|null $couponBased
     */
    public function setCouponBased(?bool $couponBased): void
    {
        // TODO: Implement setCouponBased() method.
    }

    /**
     * @return Collection
     */
    public function getCoupons(): Collection
    {
        // TODO: Implement getCoupons() method.
    }

    /**
     * @param PromotionCouponInterface $coupon
     *
     * @return bool
     */
    public function hasCoupon(PromotionCouponInterface $coupon): bool
    {
        // TODO: Implement hasCoupon() method.
    }

    /**
     * @return bool
     */
    public function hasCoupons(): bool
    {
        // TODO: Implement hasCoupons() method.
    }

    /**
     * @param PromotionCouponInterface $coupon
     */
    public function addCoupon(PromotionCouponInterface $coupon): void
    {
        // TODO: Implement addCoupon() method.
    }

    /**
     * @param PromotionCouponInterface $coupon
     */
    public function removeCoupon(PromotionCouponInterface $coupon): void
    {
        // TODO: Implement removeCoupon() method.
    }

    /**
     * @return bool
     */
    public function hasRules(): bool
    {
        // TODO: Implement hasRules() method.
    }

    /**
     * @param PromotionRuleInterface $rule
     *
     * @return bool
     */
    public function hasRule(PromotionRuleInterface $rule): bool
    {
        // TODO: Implement hasRule() method.
    }

    /**
     * @return bool
     */
    public function hasActions(): bool
    {
        // TODO: Implement hasActions() method.
    }

    /**
     * @param PromotionActionInterface $action
     *
     * @return bool
     */
    public function hasAction(PromotionActionInterface $action): bool
    {
        // TODO: Implement hasAction() method.
    }
}

