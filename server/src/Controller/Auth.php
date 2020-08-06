<?php declare(strict_types=1);
/**
 * @author Alexey Gorshkov <moonhorn33@gmail.com>
 */

namespace App\Controller;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Auth controller
 */
class Auth
{
    /**
     * @var \League\OAuth2\Server\AuthorizationServer
     */
    private $authorizationServer;

    /**
     * @var \Psr\Http\Message\ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var \Psr\Http\Message\StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * @param \League\OAuth2\Server\AuthorizationServer  $authorizationServer
     * @param \Psr\Http\Message\ResponseFactoryInterface $responseFactory
     * @param \Psr\Http\Message\StreamFactoryInterface   $streamFactory
     */
    public function __construct(
        AuthorizationServer $authorizationServer,
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->authorizationServer = $authorizationServer;
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request Request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $server = $this->authorizationServer;
        $response = $this->responseFactory->createResponse();

        try {
            return $server->respondToAccessTokenRequest($request, $response);
        } catch (OAuthServerException $exception) {

            return $exception->generateHttpResponse($response);
        } catch (\Exception $exception) {
            $body = $this->streamFactory->createStream($exception->getMessage());

            return $response->withStatus(500)->withBody($body);
        }
    }
}
