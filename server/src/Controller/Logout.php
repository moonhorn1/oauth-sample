<?php declare(strict_types=1);
/**
 * @author Alexey Gorshkov <moonhorn33@gmail.com>
 */

namespace App\Controller;

use App\Repository\AccessTokenRepository;
use App\Repository\RefreshTokenRepository;
use Defuse\Crypto\Key;
use Exception;
use League\OAuth2\Server\CryptTrait;
use League\OAuth2\Server\Exception\OAuthServerException;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Logout controller
 */
class Logout
{
    use CryptTrait;

    /**
     * @var \League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface
     */
    private $accessTokenRepository;

    /**
     * @var \League\OAuth2\Server\Entities\RefreshTokenEntityInterface
     */
    private $refreshTokenRepository;

    /**
     * @var string|Key|null
     */
    protected $encryptionKey;

    public function __construct(
        AccessTokenRepository $accessTokenRepository,
        RefreshTokenRepository $refreshTokenRepository,
        $encryptionKey
    ) {
        $this->accessTokenRepository = $accessTokenRepository;
        $this->refreshTokenRepository = $refreshTokenRepository;
        $this->encryptionKey = $encryptionKey;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request Request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $data = (array)$request->getParsedBody();

        if ('refresh_token' === $data['token_type_hint']) {
            $encryptedRefreshToken = $data['token'];

            $oldRefreshToken = $this->validateRefreshToken($encryptedRefreshToken, $data['client_id']);
            // Expire old tokens

            $this->accessTokenRepository->revokeAccessToken($oldRefreshToken['access_token_id']);
            $this->refreshTokenRepository->revokeRefreshToken($oldRefreshToken['refresh_token_id']);
        }

        return new Response();
    }

    /**
     * @param string $encryptedRefreshToken Refresh token
     * @param string $clientId              Client ID
     *
     * @return array
     */
    protected function validateRefreshToken(string $encryptedRefreshToken, string $clientId)
    {
        try {
            $refreshToken = $this->decrypt($encryptedRefreshToken);
        } catch (Exception $e) {
            throw OAuthServerException::invalidRefreshToken('Cannot decrypt the refresh token', $e);
        }

        $refreshTokenData = \json_decode($refreshToken, true);
        if ($refreshTokenData['client_id'] !== $clientId) {
            throw OAuthServerException::invalidRefreshToken('Token is not linked to client');
        }

        if ($refreshTokenData['expire_time'] < \time()) {
            throw OAuthServerException::invalidRefreshToken('Token has expired');
        }

        if ($this->refreshTokenRepository->isRefreshTokenRevoked($refreshTokenData['refresh_token_id']) === true) {
            throw OAuthServerException::invalidRefreshToken('Token has been revoked');
        }

        return $refreshTokenData;
    }
}
