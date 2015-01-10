<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service;

use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\ApiKey;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Exception\ResourceNotFoundException;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Repository\ApiKeyRepository;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Util\SecureRandom;

class DoctrineUserService implements UserService
{

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var UserProviderInterface
     */
    protected $userProvider;

    /**
     * @var EncoderFactory
     */
    protected $encoderFactory;

    /**
     * @var ApiKeyRepository
     */
    protected $apiKeyRepository;

    public function __construct(
        UserRepository $userRepository,
        ApiKeyRepository $apiKeyRepository,
        UserProviderInterface $userProvider,
        EncoderFactory $encoderFactory
    ) {
        $this->userRepository = $userRepository;
        $this->userProvider = $userProvider;
        $this->encoderFactory = $encoderFactory;
        $this->apiKeyRepository = $apiKeyRepository;
    }

    /**
     * @return User[]
     */
    public function listUsers()
    {
        $users = $this->userRepository->findAll();

        return $users;
    }

    /**
     * @param integer $id
     *
     * @return User
     *
     * @throws ResourceNotFoundException
     */
    public function getUser($id)
    {
        $user = $this->userRepository->find($id);
        if (null === $user) {
            throw new ResourceNotFoundException();
        }

        return $user;
    }

    /**
     * @param $userName
     * @param $password
     *
     * @return mixed
     */
    public function createApiKey($userName, $password)
    {
        $user = $this->userProvider->loadUserByUsername($userName);
        $encoder = $this->encoderFactory->getEncoder($user);

        if ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
            $apiKey = $this->generateAndSaveApiKey($user);

            return $apiKey;
        }

        throw new AuthenticationException();
    }

    protected function generateAndSaveApiKey($user)
    {
        $generator = new SecureRandom();
        $key = bin2hex($generator->nextBytes(32));
        $apiKey = new ApiKey();
        $apiKey->setKey($key);
        $apiKey->setUser($user);

        $apiKey = $this->apiKeyRepository->save($apiKey);

        return $apiKey;
    }

    /**
     * @param string $apiKey
     *
     * @return User|null
     */
    public function findUserByApiKey($apiKey)
    {
        /** @var ApiKey $apiKey */
        $apiKey = $this->apiKeyRepository->findSingleBy(['key' => $apiKey]);
        if (null === $apiKey) {
            return null;
        }

        return $apiKey->getUser();
    }
}