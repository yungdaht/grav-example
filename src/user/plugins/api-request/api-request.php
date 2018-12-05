<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class ApiRequestPlugin
 * @package Grav\Plugin
 */
class ApiRequestPlugin extends Plugin
{
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
        if ($uri && $uri == '/api-request') {
            $this->enable([
                'onPageContentRaw' => ['onPageContentRaw', 0]
            ]);
        }
    }

    private function makeRequest() {
        $client = new \GuzzleHttp\Client();

        $res = $client->request('GET', 'https://jsonplaceholder.typicode.com/posts' );
        $responseBody = $res->getBody();

        return $responseBody;
    }

    private function getUpdatedText($text) {
        $retString = '<ul>';

        foreach ($text as $k => $v) {
            $divString = "<li>ID: $v->id<br>Title: $v->title</li>";
            $retString = $retString . $divString;
        }

        $retString = $retString . '</ul>';

        return $retString;
    }

    /**
     * Do some work for this event, full details of events can be found
     * on the learn site: http://learn.getgrav.org/plugins/event-hooks
     *
     * @param Event $e
     */
    public function onPageContentRaw (Event $e)
    {
        $text = json_decode( $this->makeRequest() );
        $content = $e['page']->getRawContent();
        $updatedText = $this->getUpdatedText($text);
        $e['page']->setRawContent($content . "\n\n" . $updatedText);
    }
}
