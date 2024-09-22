<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Plugin;
use Grav\Common\Grav;
use Grav\Common\Page\Page;
use RocketTheme\Toolbox\Event\Event;

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
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
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
    public function onPluginsInitialized(): void
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        $this->enable([
            'onAssetsInitialized' => ['onAssetsInitialized', 0],
            'onPageContentProcessed' => ['onPageContentProcessed', 0]
        ]);
    }

    public function onAssetsInitialized(): void
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        // Don't proceed if there is no GTM Container ID
        $containerId = trim($this->config->get('plugins.gtm-plugin.container_id', ''));
        if (empty($containerId) ) {
            $this->grav['log']->info('Missing Container ID');
            return;
        }
        $headCode = $this->getHeadContainerCode($containerId);
        $this->grav['assets']->addInlineJs($headCode, null, "head");
        return;
    }

    public function onPageContentProcessed(Event $event)
    {
        $page = $event['page'];
        $config = $this->mergeConfig($page);
        // Don't proceed if there is no GTM Container ID
        $containerId = trim($this->config->get('plugins.gtm-plugin.container_id', ''));
        if (empty($containerId) ) {
            $this->grav['log']->info('Missing Container ID');
            return;
        }
        $bodyCode = $this->getBodyContainerCode($containerId);
            $page->setRawContent(
                preg_replace(
                    "/(<body.*?>)/is", 
                    "$1".$bodyCode, 
                    $page->getRawContent()
            ));
        return;
    }
    /**
     * Return the Google Tag Manager Head Tracking Code
     * @param string $gtmContainerId Global variable name for the GTM Container
     * @return string
     */
    private function getHeadContainerCode($gtmContainerId)
    {
        $code =
            "<!-- Google Tag Manager - Grav GTM Plugin -->
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{$gtmContainerId}');
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
            "<!-- Google Tag Manager (noscript) - Grav GTM Plugin -->
            <noscript><iframe src='https://www.googletagmanager.com/ns.html?id={$gtmContainerName}' height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->";

        return $code;
    }

}
