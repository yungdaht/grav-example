<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class CustomFormThanksPlugin
 * @package Grav\Plugin
 */
class CustomFormThanksPlugin extends Plugin
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

        if ($uri && $uri == '/custom-form') {
            $this->enable([
                'onPageContentRaw' => ['onPageContentRaw', 0]
            ]);
        }
    }

    private function printValues() {
        $name = $_POST['data']['name'];
        $email = $_POST['data']['email'];
        $bodyString = "<p>You entered \"$name\" as your name, and \"$email\" as your email.</p>";
        $content = $this->e['page']->getRawContent();

        $this->e['page']->setRawContent($content . "\n\n" . $bodyString);
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

        if (isset($_POST['data'])) {
            $this->printValues();
        }
    }
}
