<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Security;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolverInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * This is a workaround since Symfony does not handle InsufficientAuthenticationException with a 401 status code when
 * firewall has anonymous enabled.
 * See https://github.com/symfony/symfony/issues/8467
 */
class ExceptionListener
{

    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var AuthenticationTrustResolverInterface
     */
    protected $trustResolver;

    public function __construct(
        SecurityContextInterface $securityContext,
        AuthenticationTrustResolverInterface $trustResolver
    ) {
        $this->securityContext = $securityContext;
        $this->trustResolver = $trustResolver;
    }

    /**
     * Handles security related exceptions.
     *
     * @param GetResponseForExceptionEvent $event An GetResponseForExceptionEvent instance
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if ($exception instanceof AccessDeniedException) {
            $token = $this->securityContext->getToken();
            if (!$this->trustResolver->isFullFledged($token)) {
                $event->setException(new AccessDeniedHttpException($exception->getMessage(), $exception));
                $event->setResponse(new Response($exception->getMessage(), 401));
            }
        }
    }
}