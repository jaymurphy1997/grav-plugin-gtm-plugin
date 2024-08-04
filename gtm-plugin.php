<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Plugin;

/**
 * Class GtmPluginPlugin
 * @package Grav\Plugin
 */
class GtmPluginPlugin extends Plugin
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
    public static function getSubscribedEvents(): array
    {
        return [
            'onPluginsInitialized' => [
                // Uncomment following line when plugin requires Grav < 1.7
                // ['autoload', 100000],
                ['onAssetsInitialized', 0]
            ]
        ];
    }

    /**
     * Composer autoload
     *
     * @return ClassLoader
     */
    public function autoload(): ClassLoader
    {
        return require __DIR__ . '/vendor/autoload.php';
    }

    /**
     * Initialize the plugin
     */
    public function onAssetsInitialized(): void
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        // Enable the main events we are interested in
        $this->enable([
            // Put your main events here
        ]);

        // Don't proceed if there is no GTM Container ID
        $containerId = trim($this->config->get('plugins.gtm-plugin.container_id', ''));

        $headCode = $this->getHeadContainerCode($containerId);
        $this->grav['assets']->addInlineJs($headCode, null, "head");
 
        $bodyCode = $this->getBodyContainerCode($containerId);
        $this->grav['assets']->addInlineJs($bodyCode, null, "bottom");
    }

    /**
     * Return the Google Tag Manager Head Tracking Code
     * @param string $gtmContainerId Global variable name for the GTM Container
     * @return string
     */
    private function getHeadContainerCode($gtmContainerId)
    {
        $code =
            "<!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{$gtmContainerId}');</script>
            <!-- End Google Tag Manager -->";

        return $code;
    }

    /**
     * Return the Google Tag Manager Body Tracking Code
     * @param string $gtmContainerName Global variable name for the GTM Container
     * @return string
     */
    private function getBodyContainerCode($gtmContainerName)
    {
        $code =
            "<!-- Google Tag Manager (noscript) -->
            <noscript><iframe src='https://www.googletagmanager.com/ns.html?id={$gtmContainerName}'
            height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->";

        return $code;
    }

}
