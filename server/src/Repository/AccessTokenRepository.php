<?php declare(strict_types=1);
/**
 * @author Alexey Gorshkov <moonhorn33@gmail.com>
 */

namespace App\Repository;

use App\Entity\AccessToken;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

/**
 * Access token repository
 */
class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager Entity manager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $entityManager->getRepository(AccessToken::class);
    }

    /**
     * @inheritDoc
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $token = new AccessToken();

        $token->setClient($clientEntity);
        $token->setUserIdentifier($userIdentifier);

        return $token;
    }

    /**
     * @inheritDoc
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $this->em->persist($accessTokenEntity);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function revokeAccessToken($tokenId)
    {
        $token = $this->repository->find($tokenId);

        if (null === $token) {
            return;
        }

        $token->setRevoked(true);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function isAccessTokenRevoked($tokenId)
    {
        $token = $this->repository->find($tokenId);

        return null === $token || $token->isRevoked();
    }
}
