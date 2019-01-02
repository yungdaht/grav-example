<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;
use function GuzzleHttp\json_decode;
use Abraham\TwitterOAuth\TwitterOAuth;

require "/var/www/grav-admin/vendor/twitteroauth/autoload.php";

/**
 * Class TwitterSigninPlugin
 * @package Grav\Plugin
 */
class TwitterSigninPlugin extends Plugin
{
    //get auth tokens
    private $timestamp = '1545667254';
    private $nonce = 'EdruewXqd1X';
    private $oauthSignature = 'r%2Fk9tyCSzhhWKM6C1tdtOXlVxos%3D';

    // get user details
    private $userDetailsTimestamp = '1545667866';
    private $userDetailNonce = 'SwMVt0OTLeo';
    private $userDetailsOauthSignature = 'JGsp0rWVqoOYDxOu9Q8iNjnyBfM%3D';

    // get access token
    private $accessTokenTimestamp = '1545169194';
    private $accessTokenNonce = '7aTmTH5KOTG';
    private $accessTokenSignature = 'Ekzmj2qRvRzkjGQvk1h9Cl%2BJI38%3D';

    private $consumerKey = 'zVL1brWkhWtgBduOh6BHmmGPL';
    private $consumerSecret = '2SfUsmICRRizZo51OiCMK98UwBXei1jKsFpBMVD8CFYYhtcQqv';
    private $accessKey = '919914776-dSciZXj0FPdCYMgMJK0p7dteD8zkd3AW7iwbv3Hi';
    private $accessSecret = 'NSFgBE0MLGeZyIbB2SuhYHrE5lLwhaGfmcmnKTBq6FYMw';
    private $serverAccessTokensArr = array();
    private $serverAccessTokens = '';
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
            "Authorization: OAuth oauth_consumer_key=\"$this->consumerKey\",oauth_token=\"$this->accessKey\",oauth_signature_method=\"HMAC-SHA1\",oauth_timestamp=\"$this->timestamp\",oauth_nonce=\"$this->nonce\",oauth_version=\"1.0\",oauth_signature=\"$this->oauthSignature\"",
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

    private function logException($error) {
      echo '<pre>';
      print_r($error->getMessage());
      echo "\r\n";
      echo '</pre>';
      exit;
    }

    private function getAuthenticationToken($token) {
      try {
        $valsArr = explode('&', $token);
        $tokenArr = explode('=', $valsArr[0]);

        if (isset($tokenArr[1])) {
          return $tokenArr[1];
        } else {
          throw new \Exception("Authorization token unavailable.  Server response: " . $token);
        }
      } catch (\Exception $e) {
        $this->logException($e);
      }
    }

    private function redirectUser($token) {
        header("Location: https://api.twitter.com/oauth/authenticate?oauth_token=$token");
        die();
    }

    private function authorizeUser() {
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
            "Authorization: OAuth oauth_consumer_key=\"$this->consumerKey\",oauth_token=" . $_GET['oauth_token'] . ",oauth_signature_method=\"HMAC-SHA1\",oauth_timestamp=\"$this->accessTokenTimestamp\",oauth_nonce=\"$this->accessTokenNonce\",oauth_version=\"1.0\",oauth_signature=\"$this->accessTokenSignature\"",
            "Content-Type: application/x-www-form-urlencoded",
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

    private function setUserToken() {
        $tokenArr = explode('=', $this->serverAccessTokensArr[0]);

        if (isset($tokenArr[1])) {
            $this->userToken = $tokenArr[1];
        } else {
            throw new \Exception("User token unavailable.");
        }
    }

    private function userSecretRetrieved() {
        $secretArr = explode('=', $this->serverAccessTokensArr[1]);

        if (isset($secretArr[1])) {
            $this->userSecret = $secretArr[1];
        } else {
            throw new \Exception("User secret unavailable.");
        }
    }

    private function setUserSecret() {
        if (isset($this->serverAccessTokensArr[1])) {
            $this->userSecretRetrieved();
        } else {
            throw new \Exception("No user secret returned.");
        };
    }

    private function setAccessTokens() {
        try {
            $this->serverAccessTokensArr = explode('&', $this->serverAccessTokens);
            $this->setUserToken();
            $this->setUserSecret();
        } catch (\Exception $e) {
            $this->logException($e);
        }
    }

    private function getUsername() {
        $serverAccessTokensArr = explode('&', $this->serverAccessTokens);
        $nameArr = explode('=', $serverAccessTokensArr[3]);

        return $nameArr[1];
    }

    private function getUserDetails() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.twitter.com/1.1/account/verify_credentials.json",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => array(
            "Authorization: OAuth oauth_consumer_key=\"$this->consumerKey\",oauth_token=\"$this->userToken\",oauth_signature_method=\"HMAC-SHA1\",oauth_timestamp=\"$this->userDetailsTimestamp\",oauth_nonce=\"$this->userDetailNonce\",oauth_version=\"1.0\",oauth_signature=\"$this->userDetailsOauthSignature\"",
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

    private function getPersonalDataString() {
        $userDetails = $this->getUserDetails();

        return $userDetails;
    }

    private function addUserDetails($userDetails) {
        $userData = json_decode($userDetails);
        $userName = $userData->name;
        $screenName = $userData->screen_name;
        $city = $userData->location;
        $followers = $userData->followers_count;

        return "Thanks for logging in, $userName/$screenName.  How's life in $city?  $followers followers... nice!";
    }

    private function appendContent() {
      $username = $this->getUsername();
      $userData = $this->getPersonalDataString();
      $content = $this->e['page']->getRawContent();
      $updatedText = $this->addUserDetails($userData);

      $this->e['page']->setRawContent($updatedText . "\n\n" . $content);
    }

    private function userAuthorized() {
        $this->serverAccessTokens = $this->getAccessToken();

        $this->setAccessTokens();

        $connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $this->userToken, $this->accessSecret);
        // $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);
        $content = $connection->get("account/verify_credentials");

        echo '<pre>';
        print_r($content);
        echo "\r\n";
        echo '</pre>';
        exit;

        $this->appendContent();
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

        $connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $this->accessKey, $this->accessSecret);
        $content = $connection->get("account/verify_credentials");
        // $connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $this->accessKey, $this->accessSecret);
        // // $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);
        // $content = $connection->get("account/verify_credentials");

        // echo '<pre>';
        // print_r($content);
        // echo "\r\n";
        // echo '</pre>';
        // exit;

        // $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => "nMznkpFRTMCuNMsmALzel9FgPlmWQDWg"]);
        echo '<pre>';
        // print_r($connection);
        print_r($content);
        // print_r($access_token);
        echo "\r\n";
        echo '</pre>';
        exit;


        if (isset($_GET['oauth_token'])) {
            $this->userAuthorized();
        } else {
            $this->authorizeUser();
        }
    }
}
