<?php declare(strict_types=1);
/**
 * @author Alexey Gorshkov <moonhorn33@gmail.com>
 */

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

/**
 * Refresh
 *
 * @ORM\Entity
 */
class RefreshToken implements RefreshTokenEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\Column
     */
    private $identifier;

    /**
     * @var DateTimeImmutable|null
     *
     * @ORM\Column(type="datetime_immutable")
     */
    private $expiryDateTime;

    /**
     * @var \App\Entity\AccessToken|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\AccessToken")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE", referencedColumnName="identifier")
     */
    private $accessToken;

    /**
     * @inheritDoc
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @inheritDoc
     */
    public function setIdentifier($identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @inheritDoc
     */
    public function getExpiryDateTime(): DateTimeImmutable
    {
        return $this->expiryDateTime;
    }

    /**
     * @inheritDoc
     */
    public function setExpiryDateTime(DateTimeImmutable $dateTime): void
    {
        $this->expiryDateTime = $dateTime;
    }

    /**
     * @inheritDoc
     */
    public function setAccessToken(AccessTokenEntityInterface $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @inheritDoc
     */
    public function getAccessToken(): AccessToken
    {
        return $this->accessToken;
    }
}
