<?php declare(strict_types=1);
/**
 * @author Alexey Gorshkov <moonhorn33@gmail.com>
 */

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;

/**
 * Access token
 *
 * @ORM\Entity
 */
class AccessToken implements AccessTokenEntityInterface
{
    use AccessTokenTrait;

    /**
     * @var string
     *
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
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $userIdentifier;

    /**
     * @var \App\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Client")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $client;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * @inheritDoc
     */
    public function getClient(): Client
    {
        return $this->client;
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
    public function getUserIdentifier(): ?string
    {
        return $this->userIdentifier;
    }

    /**
     * @inheritDoc
     */
    public function getScopes(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @inheritDoc
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @inheritDoc
     */
    public function setExpiryDateTime(DateTimeImmutable $dateTime)
    {
        $this->expiryDateTime = $dateTime;
    }

    /**
     * @inheritDoc
     */
    public function setUserIdentifier($identifier)
    {
        $this->userIdentifier = $identifier;
    }

    /**
     * @inheritDoc
     */
    public function setClient(ClientEntityInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function addScope(ScopeEntityInterface $scope)
    {
    }
}
