<?php

namespace SnakeTn\CatalogPromotion\Entity;


class PromotionAction
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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
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
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return Promotion
     */
    public function getPromotion(): Promotion
    {
        return $this->promotion;
    }

    /**
     * @param Promotion $promotion
     */
    public function setPromotion(Promotion $promotion)
    {
        $this->promotion = $promotion;
    }


}
