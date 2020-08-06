<?php declare(strict_types=1);
/**
 * @author Alexey Gorshkov <moonhorn33@gmail.com>
 */

namespace App\Controller;

use App\Repository\UserRepository;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Profile controller
 */
class Profile
{
    /**
     * @var \League\OAuth2\Server\ResourceServer
     */
    private $resourceServer;

    /**
     * @var \Psr\Http\Message\ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var \Psr\Http\Message\StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * @var \App\Repository\UserRepository
     */
    private $userRepository;

    /**
     * @param \League\OAuth2\Server\ResourceServer       $resourceServer  Resource server
     * @param \Psr\Http\Message\ResponseFactoryInterface $responseFactory Response factory
     * @param \Psr\Http\Message\StreamFactoryInterface   $streamFactory   Stream factory
     * @param \App\Repository\UserRepository             $userRepository  User repository
     */
    public function __construct(
        ResourceServer $resourceServer,
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        UserRepository $userRepository
    ) {
        $this->resourceServer = $resourceServer;
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request Request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->responseFactory->createResponse();

        if ('OPTIONS' === $request->getMethod()) {
            return $response;
        }

        try {
            $request = $this->resourceServer->validateAuthenticatedRequest($request);

            $user = $this->userRepository->find($request->getAttribute('oauth_user_id'));
            $userData = [
                'username' => $user->getUsername(),
                'createdAt' => $user->getCreatedAt(),
            ];

            $body = $this->streamFactory->createStream(json_encode($userData));

            return $response->withStatus(200)->withBody($body);
        } catch (OAuthServerException $exception) {

            return $exception->generateHttpResponse($response);
        } catch (\Exception $exception) {
            $body = $this->streamFactory->createStream($exception->getMessage());

            return $response->withStatus(500)->withBody($body);
        }
    }
}
