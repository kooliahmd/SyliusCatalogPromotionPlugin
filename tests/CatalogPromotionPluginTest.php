<?php

/*
 * This file is part of catalog promotion plugin for sylius.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Kooli\CatalogPromotion;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CatalogPromotionPluginTest extends WebTestCase
{
    public function test_services_are_initializable()
    {
        /** @var ContainerInterface $container */
        $container = self::createClient()->getContainer();

        $services = $container->getServiceIds();

        $services = array_filter($services, function ($serviceId) {
            return 0 === strpos($serviceId, 'catalog-promotion.');
        });

        foreach ($services as $id) {
            $container->get($id);
        }
    }
}
