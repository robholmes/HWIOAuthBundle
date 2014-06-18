<?php

/*
 * This file is part of the HWIOAuthBundle package.
 *
 * (c) Hardware.Info <opensource@hardware.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HWI\Bundle\OAuthBundle\OAuth\Response;

/**
 * Class parsing the properties by Stripe using given path options.
 *
 * @author Rob Holmes <email@robholmes.net>
 */
class StripeConnectResponse extends PathUserResponse
{
    /**
     * @var array
     */
    protected $paths = array(
        'token_type'                => 'token_type',
        'stripe_publishable_key'    => 'stripe_publishable_key',
        'scope'                     => 'scope',
        'livemode'                  => 'livemode',
        'stripe_user_id'            => 'stripe_user_id',
        'refresh_token'             => 'refresh_token',
        'access_token'              => 'access_token',
    );

    /**
     * {@inheritdoc}
     */
    public function getTokenType()
    {
        return $this->getValueForPath('token_type');
    }

    /**
     * {@inheritdoc}
     */
    public function getStripePublishableKey()
    {
        return $this->getValueForPath('stripe_publishable_key');
    }

    /**
     * {@inheritdoc}
     */
    public function getScope()
    {
        return $this->getValueForPath('scope');
    }

    /**
     * {@inheritdoc}
     */
    public function getLiveMode()
    {
        return $this->getValueForPath('livemode');
    }

    /**
     * {@inheritdoc}
     */
    public function getStripeUserId()
    {
        return $this->getValueForPath('stripe_user_id');
    }
}
