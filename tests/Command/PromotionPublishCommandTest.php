<?php

/*
 * This file is part of Sylius catalog promotion plugin.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Kooli\CatalogPromotion\Command;

use Kooli\CatalogPromotion\Command\PromotionPublishCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class PromotionPublishCommandTest extends KernelTestCase
{

    public function test_execute()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new PromotionPublishCommand());

        $command = $application->find('sylius:catalog-promotion:publish');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName()
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('yes man', $output);
    }

}
