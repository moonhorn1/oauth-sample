<?php declare(strict_types=1);
/**
 * @author Alexey Gorshkov <moonhorn33@gmail.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\ClientEntityInterface;

/**
 * Client entity
 *
 * @ORM\Entity
 */
class Client implements ClientEntityInterface
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(unique=true)
     */
    private $clientId;

    /**
     * @var string
     *
     * @ORM\Column(length=1024)
     */
    private $clientSecret;

    /**
     * @var string[]
     *
     * @ORM\Column(type="array", nullable=true)
     */
    private $redirectUri;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string $name Name
     *
     * @return Client
     */
    public function setName(string $name): Client
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $clientId Client id
     *
     * @return Client
     */
    public function setClientId(string $clientId): Client
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret Client secret
     *
     * @return Client
     */
    public function setClientSecret(string $clientSecret): Client
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    /**
     * @param string[] $redirectUri Redirect uri
     *
     * @return Client
     */
    public function setRedirectUri(array $redirectUri): Client
    {
        $this->redirectUri = $redirectUri;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIdentifier(): string
    {
        return $this->clientId;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getRedirectUri(): array
    {
        return $this->redirectUri;
    }

    /**
     * @inheritDoc
     */
    public function isConfidential()
    {
        return false;
    }
}
