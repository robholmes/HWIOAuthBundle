<?php

/*
 * This file is part of the HWIOAuthBundle package.
 *
 * (c) Hardware.Info <opensource@hardware.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HWI\Bundle\OAuthBundle\OAuth\ResourceOwner;

use Buzz\Message\Response;
use HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * GitHubResourceOwner
 *
 * @author Geoffrey Bachelet <geoffrey.bachelet@gmail.com>
 * @author Alexander <iam.asm89@gmail.com>
 */
class StripeResourceOwner extends GenericOAuth2ResourceOwner
{
    protected $userContent;

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolverInterface $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'authorization_url'   => 'https://connect.stripe.com/oauth/authorize',
            'access_token_url'    => 'https://connect.stripe.com/oauth/token',
            'infos_url'           => 'blank',

            'use_commas_in_scope' => false,
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getUserInformation(array $accessToken, array $extraParameters = array())
    {
        if ($this->options['infos_url'] != 'blank') {
            return parent::getUserInformation($accessToken, $extraParameters);
        }

        $response = $this->getUserResponse();
        $response->setResourceOwner($this);
        $response->setResponse($this->userContent);
        $response->setOAuthToken(new OAuthToken($accessToken));

        return $response;
    }

    /**
     * {@inheritDoc}
     */
    public function getAccessToken(Request $request, $redirectUri, array $extraParameters = array())
    {
        $parameters = array_merge(array(
            'code'          => $request->query->get('code'),
            'grant_type'    => 'authorization_code',
            'client_id'     => $this->options['client_id'],
            'client_secret' => $this->options['client_secret'],
            'redirect_uri'  => $redirectUri,
        ), $extraParameters);

        $response = $this->doGetTokenRequest($this->options['access_token_url'], $parameters);
        $response = $this->getResponseContent($response);

        $this->validateResponseContent($response);

        $this->userContent = $response;

        //$this->storage->

        return $response;
    }
}
