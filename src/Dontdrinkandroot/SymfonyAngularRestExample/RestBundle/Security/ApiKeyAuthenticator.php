<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Security;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{

    /** @var UserService */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @inheritdoc
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        $apiKey = $token->getCredentials();

        $user = $this->userService->findUserByApiKey($apiKey);

        if (null === $user) {
            throw new AuthenticationException('Invalid API Key');
        }

        return new PreAuthenticatedToken(
            $user,
            $apiKey,
            $providerKey,
            $user->getRoles()
        );
    }

    /**
     * @inheritdoc
     */
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    /**
     * @inheritdoc
     */
    public function createToken(Request $request, $providerKey)
    {
        $apiKey = $request->query->get('apikey');
        if (null === $apiKey) {
            $apiKey = $request->headers->get('X-Api-Key');
        }

        if (null === $apiKey || 'null' === $apiKey) {
            return null;
        }

        return new PreAuthenticatedToken(
            'anon.',
            $apiKey,
            $providerKey
        );
    }

    /**
     * @inheritdoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response("Authentication Failed.", 403);
    }
}
