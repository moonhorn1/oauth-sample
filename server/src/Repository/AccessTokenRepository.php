<?php declare(strict_types=1);
/**
 * @author Alexey Gorshkov <moonhorn33@gmail.com>
 */

namespace App\Repository;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

/**
 * Access token repository
 */
class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        // TODO: Implement getNewToken() method.
    }

    /**
     * @inheritDoc
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        // TODO: Implement persistNewAccessToken() method.
    }

    /**
     * @inheritDoc
     */
    public function revokeAccessToken($tokenId)
    {
        // TODO: Implement revokeAccessToken() method.
    }

    /**
     * @inheritDoc
     */
    public function isAccessTokenRevoked($tokenId)
    {
        // TODO: Implement isAccessTokenRevoked() method.
    }
}
