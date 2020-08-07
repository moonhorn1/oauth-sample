<?php declare(strict_types=1);
/**
 * @author Alexey Gorshkov <moonhorn33@gmail.com>
 */

namespace App\Controller;

use App\Entity\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Sign up controller
 */
class SignUp
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager Entity manager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request Request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        if ('OPTIONS' === $request->getMethod()) {
            return new JsonResponse();
        }

        if ('json' !== $request->getContentType()) {
            return new JsonResponse(json_encode([
                'success' => false,
                'data'    => sprintf('Only "application/json" content type allowed, "%s" provided', $request->getContentType()),
            ]), 400);
        }

        $data = json_decode($request->getContent(), true);

        if (!isset($data['username']) && !isset($data['password'])) {
            return new JsonResponse(json_encode([
                'success' => false,
                'data'    => 'The user data is invalid.',
            ]), 400);
        }

        try {
            $user = new User();
            $user
                ->setUsername($data['username'])
                ->setPassword(hash('gost', $data['password']));

            $this->em->persist($user);
            $this->em->flush();
        } catch (UniqueConstraintViolationException $exception) {
            return new JsonResponse(json_encode([
                'success' => false,
                'data'    => sprintf('User with username "%s" already exists.', $user->getUsername()),
            ]), 400);
        } catch (\Exception $exception) {
            return new JsonResponse(json_encode([
                'success' => false,
                'data'    => $exception->getMessage(),
            ]), 500);
        }

        return new JsonResponse(json_encode([
            'success' => true,
            'data'    => [
                'id'        => $user->getIdentifier(),
                'username'  => $user->getUsername(),
                'createdAt' => $user->getCreatedAt(),
            ],
        ]));
    }
}
