<?php declare(strict_types=1);
/**
 * @author Alexey Gorshkov <moonhorn33@gmail.com>
 */

namespace App\Repository;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

/**
 * Client repository
 */
class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getClientEntity($clientIdentifier)
    {
        // TODO: Implement getClientEntity() method.
    }

    /**
     * @inheritDoc
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        // TODO: Implement validateClient() method.
    }
}
