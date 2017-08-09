<?php

namespace SnakeTn\CatalogPromotion\Entity;


use Sylius\Component\Promotion\Model\ConfigurablePromotionElementInterface;

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
    public function getType()
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
    public function getConfiguration()
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
    public function getPromotion()
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
