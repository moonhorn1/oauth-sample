<?php declare(strict_types=1);
/**
 * @author Alexey Gorshkov <moonhorn33@gmail.com>
 */

namespace App\Repository;

use App\Entity\RefreshToken;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

/**
 * Refresh token repository
 */
class RefreshTokenRepository implements RefreshTokenRepositoryInterface
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
        $this->repository = $entityManager->getRepository(RefreshToken::class);
    }

    /**
     * @inheritDoc
     */
    public function getNewRefreshToken(): RefreshToken
    {
        return new RefreshToken();
    }

    /**
     * @inheritDoc
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity): void
    {
        $this->em->persist($refreshTokenEntity);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function revokeRefreshToken($tokenId)
    {
        $token = $this->repository->find($tokenId);

        if (null === $token) {
            return;
        }

        $this->em->remove($token);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        $token = $this->repository->find($tokenId);

        return null === $token;
    }
}
