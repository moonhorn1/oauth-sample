<?php declare(strict_types=1);
/**
 * @author Alexey Gorshkov <moonhorn33@gmail.com>
 */

namespace App\Repository;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

/**
 * Scope repository
 */
class ScopeRepository implements ScopeRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getScopeEntityByIdentifier($identifier)
    {
        // TODO: Implement getScopeEntityByIdentifier() method.
    }

    /**
     * @inheritDoc
     */
    public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null)
    {
        // TODO: Implement finalizeScopes() method.
    }
}
