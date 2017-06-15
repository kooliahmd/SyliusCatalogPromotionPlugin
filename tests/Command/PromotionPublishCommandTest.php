<?php

/*
 * This file is part of Sylius catalog promotion plugin.
 *
 * (c) Ahmed SnakeTn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\SnakeTn\CatalogPromotion\Command;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class PromotionPublishCommandTest extends WebTestCase
{

    public function test_execute()
    {
        $this->loadFixtureFiles([
            $this->getFixturePath('promotions'),
            $this->getFixturePath('products'),
        ]);
        $this->runCommand('sylius:catalog-promotion:publish');

    }

    public function getFixturePath($fileName)
    {
        return $this->getPhpUnitXmlDir() . $_SERVER['FIXTURES_DIR'] . '/' . $fileName . '.yml';
    }

}
