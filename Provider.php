<?php

namespace RikoDEV\Id;

use GuzzleHttp\RequestOptions;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    public const IDENTIFIER = 'RIKOID';

    /**
     * {@inheritdoc}
     */
    protected $scopes = [
        'openid',
        'profile',
        'email',
    ];

    /**
     * {@inheritdoc}
     */
    protected $scopeSeparator = ' ';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'https://id.riko.dev/oauth/v2/authorize',
            $state
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://id.riko.dev/oauth/v2/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(
            'https://id.riko.dev/oidc/v1/userinfo',
            [
                RequestOptions::HEADERS => [
                    'Authorization' => 'Bearer '.$token,
                ],
            ]
        );

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'       => $user['sub'],
            'nickname' => $user['name'],
            'name'     => $user['name'],
            'email'    => $user['email'] ?? null,
            'avatar'   => $user['picture'] ?? null,
        ]);
    }
}
