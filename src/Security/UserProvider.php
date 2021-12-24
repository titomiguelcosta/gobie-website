<?php

namespace App\Security;

use App\Api\Gobie\Client;
use App\Entity\User;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private $client;
    private $token;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->token = null;
    }

    public function setToken(?string $token)
    {
        $this->token = $token;
    }

    public function loadUserByIdentifier(string $username): UserInterface
    {
        try {
            $data = $this->client->getUser($username, $this->token);
        } catch (ClientException $exception) {
            throw new UserNotFoundException();
        }

        $user = new User();
        $user->setId($data['id']);
        $user->setPath($data['@id']);
        $user->setEmail($data['email']);
        $user->setUsername($data['username']);
        $user->setPassword($data['password']);
        $user->setRoles($data['roles']);
        $user->setToken($this->token);

        return $user;
    }

    /**
     * Refreshes the user after being reloaded from the session.
     *
     * When a user is logged in, at the beginning of each request, the
     * User object is loaded from the session and then this method is
     * called. Your job is to make sure the user's data is still fresh by,
     * for example, re-querying for fresh User data.
     *
     * If your firewall is "stateless: true" (for a pure API), this
     * method is not called.
     *
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        return $user;
    }

    /**
     * Tells Symfony to use this provider for this User class.
     */
    public function supportsClass(string $class)
    {
        return User::class === $class;
    }
}
