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

use Sylius\Component\Promotion\Model\ConfigurablePromotionElementInterface;
use Sylius\Component\Promotion\Model\PromotionInterface;

class PromotionAction implements ConfigurablePromotionElementInterface
{
    /** @var int */
    private $id;

    /** @var string|null */
    private $type;

    /** @var array|null */
    private $configuration;

    /** @var Promotion */
    private $promotion;

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getConfiguration(): ?array
    {
        return $this->configuration;
    }

    public function setConfiguration(?array $configuration): void
    {
        $this->configuration = $configuration;
    }

    public function getPromotion(): Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(Promotion $promotion): void
    {
        $this->promotion = $promotion;
    }
}
