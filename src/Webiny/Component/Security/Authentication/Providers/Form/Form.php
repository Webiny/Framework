<?php
/**
 * Webiny Framework (http://www.webiny.com/framework)
 *
 * @copyright Copyright Webiny LTD
 */

namespace Webiny\Component\Security\Authentication\Providers\Form;

use Webiny\Component\Config\ConfigObject;
use Webiny\Component\Http\HttpTrait;
use Webiny\Component\Security\Authentication\Providers\AuthenticationInterface;
use Webiny\Component\Security\Authentication\Providers\Login;
use Webiny\Component\Security\Token\Token;
use Webiny\Component\Security\User\AbstractUser;

/**
 * Form authentication provider.
 * Use this provider if you have a HTML login form for your users to sign in.
 *
 * @package         Webiny\Component\Security\Authentication\Providers\Form
 */
class Form implements AuthenticationInterface
{

    use HttpTrait;

    /**
     * This method is triggered on the login submit page where user credentials are submitted.
     * On this page the provider should create a new Login object from those credentials, and return the object.
     * This object will be then validated by user providers.
     *
     * @param ConfigObject $config Firewall config
     *
     * @return Login
     */
    public function getLoginObject(ConfigObject $config)
    {
        // Fetch data from payload object as a fallback
        $payloadUsername = $this->httpRequest()->payload('username', '');
        $payloadPassword = $this->httpRequest()->payload('password', '');
        $payloadRememberMe = $this->httpRequest()->payload('rememberme', false);

        // Now try fetching data from POST as main source
        $payloadUsername = $this->httpRequest()->post('username', $payloadUsername);
        $payloadPassword = $this->httpRequest()->post('password', $payloadPassword);
        $payloadRememberMe = $this->httpRequest()->post('rememberme', $payloadRememberMe);

        // If 'rememberme' is set - get remember me duration from Firewall config
        $rememberMe = $payloadRememberMe ? $config->get('RememberMe', false, true) : false;

        return new Login($payloadUsername, $payloadPassword, $rememberMe);
    }

    /**
     * This callback is triggered after we validate the given login data from getLoginObject, and the data IS NOT valid.
     * Use this callback to clear the submit data from the previous request so that you don't get stuck in an
     * infinitive loop between login page and login submit page.
     */
    public function invalidLoginProvidedCallback()
    {
        // nothing to do...post data is not forwarded so we don't have to clear it
    }

    /**
     * This callback is triggered after we have validated user credentials and have created a user auth token.
     *
     * @param AbstractUser $user
     */
    public function loginSuccessfulCallback(AbstractUser $user)
    {
        // nothing to do
    }

    /**
     * This callback is triggered when the system has managed to retrieve the user from the stored token (either session)
     * or cookie.
     *
     * @param AbstractUser $user
     * @param Token        $token
     *
     * @return mixed
     */
    public function userAuthorizedByTokenCallback(AbstractUser $user, Token $token)
    {
        // nothing to do
    }

    /**
     * Logout callback is called when user auth token was deleted.
     */
    public function logoutCallback()
    {
        // nothing to do
    }
}