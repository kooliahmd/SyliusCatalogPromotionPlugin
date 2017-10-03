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
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $configuration;

    /**
     * @var Promotion
     */
    private $promotion;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    /**
     * @param array $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return Promotion
     */
    public function getPromotion(): PromotionInterface
    {
        return $this->promotion;
    }

    /**
     * @param Promotion $promotion
     */
    public function setPromotion(Promotion $promotion = null)
    {
        $this->promotion = $promotion;
    }


}
