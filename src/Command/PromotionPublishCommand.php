<?php

/*
 * This file is part of catalog promotion plugin for Sylius.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SnakeTn\CatalogPromotion\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class PromotionPublishCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('sylius:catalog-promotion:publish')
            ->setDescription('Publish promotion prices.')
            ->setHelp('This command allows you to parse the promotion rules and apply the promotion actions on the catalog.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $this->getContainer()->get('catalog-promotion.processor')->process();
    }
}
