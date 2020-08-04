<?php declare(strict_types=1);
/**
 * @author Alexey Gorshkov <moonhorn33@gmail.com>
 */

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Client fixtures
 */
class ClientFixtures extends Fixture
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        $client = new Client();

        $client
            ->setName('OAuth2 Sample Application')
            ->setClientId('saiquaex6ugeit6is8wie1caezie7wau')
            ->setClientSecret('jixi2ahloh3eethae7uuphai6ooph9pu');

        $manager->persist($client);

        $manager->flush();
    }
}
