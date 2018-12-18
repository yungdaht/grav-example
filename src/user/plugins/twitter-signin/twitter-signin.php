<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class TwitterSigninPlugin
 * @package Grav\Plugin
 */
class TwitterSigninPlugin extends Plugin
{
    private $userToken = '';
    private $userSecret = '';
    private $e = '';

    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        $uri = $this->grav['uri']->path();

        // Enable the main event we are interested in
        if ($uri && $uri == '/twitter-login') {
            $this->enable([
                'onPageContentRaw' => ['onPageContentRaw', 0]
            ]);
        }
    }

    private function getAuthServerTokens() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.twitter.com/oauth/request_token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => array(
            "Authorization: OAuth oauth_consumer_key=\"zVL1brWkhWtgBduOh6BHmmGPL\",oauth_token=\"919914776-dSciZXj0FPdCYMgMJK0p7dteD8zkd3AW7iwbv3Hi\",oauth_signature_method=\"HMAC-SHA1\",oauth_timestamp=\"1545156196\",oauth_nonce=\"uHvw8LiPhtU\",oauth_version=\"1.0\",oauth_signature=\"7z1OYr70VgCyhD8hgMufkZGq6qY%3D\"",
            "Postman-Token: 514aece1-c8bb-4c83-993a-540bd447446b",
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    private function getAuthenticationToken($token) {
      $valsArr = explode('&', $token);
      $tokenArr = explode('=', $valsArr[0]);
      $token = $tokenArr[1];

      return $token;
    }

    private function redirectUser($token) {
        header("Location: https://api.twitter.com/oauth/authenticate?oauth_token=$token");
        die();
    }

    private function authenticateUser() {
        $authServerTokens = $this->getAuthServerTokens();
        $authenticationToken = $this->getAuthenticationToken($authServerTokens);
        $userRedirect = $this->redirectUser($authenticationToken);
    }

    private function getAccessToken() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.twitter.com/oauth/access_token",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "oauth_verifier=" . $_GET['oauth_verifier'],
          CURLOPT_HTTPHEADER => array(
            "Authorization: OAuth oauth_consumer_key=\"zVL1brWkhWtgBduOh6BHmmGPL\",oauth_token=" . $_GET['oauth_token'] . ",oauth_signature_method=\"HMAC-SHA1\",oauth_timestamp=\"1545169194\",oauth_nonce=\"7aTmTH5KOTG\",oauth_version=\"1.0\",oauth_signature=\"Ekzmj2qRvRzkjGQvk1h9Cl%2BJI38%3D\"",
            "Content-Type: application/x-www-form-urlencoded",
            "Postman-Token: 997e06fd-5d20-4028-ac89-69562c798cf3",
            "cache-control: no-cache"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return "cURL Error #:" . $err;
        } else {
          return $response;
        }
    }

    private function setAccessTokens($serverAccessTokens) {
        $serverAccessTokensArr = explode('&', $serverAccessTokens);
        $tokenArr = explode('=', $serverAccessTokensArr[0]);
        $secretArr = explode('=', $serverAccessTokensArr[1]);

        $this->userToken = $tokenArr[1];
        $this->userSecret = $secretArr[1];
    }

    private function getUsername($serverAccessTokens) {
        $serverAccessTokensArr = explode('&', $serverAccessTokens);
        $nameArr = explode('=', $serverAccessTokensArr[3]);

        return $nameArr[1];
    }

    private function appendContent($serverAccessTokens) {
      $username = $this->getUsername($serverAccessTokens);
      $content = $this->e['page']->getRawContent();
      $updatedText = 'Thanks for logging in, ' . $username . '.';

      $this->e['page']->setRawContent($updatedText . "\n\n" . $content);
    }

    private function userAuthenticated() {
        $serverAccessTokens = $this->getAccessToken();

        $this->setAccessTokens($serverAccessTokens);
        $this->appendContent($serverAccessTokens);
    }

    /**
     * Do some work for this event, full details of events can be found
     * on the learn site: http://learn.getgrav.org/plugins/event-hooks
     *
     * @param Event $e
     */
    public function onPageContentRaw(Event $e)
    {
        $this->e = $e;

        if (isset($_GET['oauth_token'])) {
            $this->userAuthenticated();
        } else {
            $this->authenticateUser();
        }
    }
}
