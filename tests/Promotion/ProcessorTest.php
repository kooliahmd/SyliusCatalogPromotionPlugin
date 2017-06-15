<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 6/14/17
 * Time: 6:48 PM
 */

namespace Tests\Kooli\CatalogPromotion\Promotion;


use Kooli\CatalogPromotion\Promotion\Checker\Rule\HasTaxonRuleChecker;
use Kooli\CatalogPromotion\Promotion\Processor;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Model\ProductTaxon;
use Sylius\Component\Core\Model\ProductVariant;
use Sylius\Component\Core\Model\Promotion;
use Sylius\Component\Core\Model\Taxon;
use Sylius\Component\Core\Repository\PromotionRepositoryInterface;
use Sylius\Component\Promotion\Model\PromotionRule;

class ProcessorTest extends TestCase
{
    /**
     * @var Processor
     */
    private $processor;
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $promotionRepository;

    public function setUp()
    {
        $this->promotionRepository = $this->createMock(PromotionRepositoryInterface::class);
        $this->processor = new Processor($this->promotionRepository);
        $this->processor->addRuleChecker('has_taxon', new HasTaxonRuleChecker());
    }

    public function test_process_case_eligible_to_one_promotion()
    {
        $product = new Product();
        $productVariant = new ProductVariant();
        $productVariant->setProduct($product);

        $taxon = new Taxon();
        $taxon->setCode('my-taxon');

        $productTaxon = new ProductTaxon();
        $productTaxon->setTaxon($taxon);

        $product->addProductTaxon($productTaxon);

        $rule = new PromotionRule();
        $rule->setType('has_taxon');
        $rule->setConfiguration(['taxons'=>['my-taxon']]);

        $promotion = new Promotion();
        $promotion->addRule($rule);

        $channel = new Channel();

        $this->promotionRepository->method('findActive')
            ->willReturn([$promotion]);

        $this->processor->process($productVariant, $channel);

    }

}
