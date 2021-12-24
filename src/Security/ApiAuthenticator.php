<?php

namespace App\Security;

use App\Api\Gobie\Client;
use App\Entity\User;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class ApiAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    use TargetPathTrait;

    private $userProvider;
    private $urlGenerator;
    private $csrfTokenManager;
    private $client;
    private $encoder;
    private $tokenStorage;

    public function __construct(
        UserProvider $userProvider,
        UrlGeneratorInterface $urlGenerator,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordHasherInterface $encoder,
        Client $client,
        TokenStorageInterface $tokenStorage
    ) {
        $this->userProvider = $userProvider;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->client = $client;
        $this->encoder = $encoder;
        $this->tokenStorage = $tokenStorage;
    }

    public function supports(Request $request): ?bool
    {
        return 'app_login' === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $user = $this->getUser($this->getCredentials($request));

        return new SelfValidatingPassport(new UserBadge($user->getUsername()));
    }

    public function createToken(Passport $passport, string $firewallName): TokenInterface
    {
        return new UsernamePasswordToken($passport->getUser(), $firewallName, $passport->getUser()->getRoles());
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $this->tokenStorage->setToken($token);

        return null;
        /*
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('project_list'));
        */
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return null;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->getLoginUrl());
    }

    private function getCredentials(Request $request): array
    {
        $credentials = [
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['username']
        );

        return $credentials;
    }

    private function getUser(array $credentials): User
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        try {
            $data = $this->client->auth($credentials['username'], $credentials['password']);
        } catch (ClientException $exception) {
            throw new CustomUserMessageAuthenticationException('Token invalid. Bad credentials.');
        }

        $this->userProvider->setToken($data['token']);

        /** @var User $user */
        $user = new User();
        $user->setId($data['id']);
        $user->setPath($data['@id']);
        $user->setRoles($data['roles']);
        $user->setToken($data['token']);
        $user->setEmail($data['email']);
        $user->setUsername($data['username']);

        return $user;
    }

    private function getLoginUrl(): string
    {
        return $this->urlGenerator->generate('app_login');
    }
}
