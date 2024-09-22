# Gtm Plugin Plugin

The **Gtm Plugin** Plugin is an extension for [Grav CMS](https://github.com/getgrav/grav). Installs Google Tag Manager code and updates the dataLayer without any changes to code.

## Installation

Installing the Gtm Plugin plugin can be done in one of three ways: The GPM (Grav Package Manager) installation method lets you quickly install the plugin with a simple terminal command, the manual method lets you do so via a zip file, and the admin method lets you do so via the Admin Plugin.

### GPM Installation (Preferred)

To install the plugin via the [GPM](https://learn.getgrav.org/cli-console/grav-cli-gpm), through your system's terminal (also called the command line), navigate to the root of your Grav-installation, and enter:

    bin/gpm install gtm-plugin

This will install the Gtm Plugin plugin into your `/user/plugins`-directory within Grav. Its files can be found under `/your/site/grav/user/plugins/gtm-plugin`.

### Manual Installation

To install the plugin manually, download the zip-version of this repository and unzip it under `/your/site/grav/user/plugins`. Then rename the folder to `gtm-plugin`. You can find these files on [GitHub](https://github.com/jaymurphy1997/grav-plugin-gtm-plugin) or via [GetGrav.org](https://getgrav.org/downloads/plugins).

You should now have all the plugin files under

    /your/site/grav/user/plugins/gtm-plugin
	
> NOTE: This plugin is a modular component for Grav which may require other plugins to operate, please see its [blueprints.yaml-file on GitHub](https://github.com/jaymurphy1997/grav-plugin-gtm-plugin/blob/main/blueprints.yaml).

### Admin Plugin

If you use the Admin Plugin, you can install the plugin directly by browsing the `Plugins`-menu and clicking on the `Add` button.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/gtm-plugin/gtm-plugin.yaml` to `user/config/plugins/gtm-plugin.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
```

```yaml
GTM Container ID: ""
```

* GTM Container ID: Fill in with the GTM Container ID from Google Tag Manager (typically of the form "GTM-.*")

Note that if you use the Admin Plugin, a file with your configuration named gtm-plugin.yaml will be saved in the `user/config/plugins/`-folder once the configuration is saved in the Admin.

## Usage
First you will need to create a Google Tag Manager container.  Follow the steps below:
1. Sign in to your [Google Tag Manager account](https://analytics.google.com/).
2. Select the **Admin** tab.
3. Select an account from the dropdown in the _ACCOUNT_ column.
4. Select a Container from the dropdown in the _CONTAINER_ column.
5. In the upper right hand of the _WORKSPACE_ _OVERVIEW_, click the link starting with "GTM-" - copy this full string - it is your **GTM CONTAINER ID** 
6. Copy the **GTM CONTAINER ID** (a string like _GTM-XXXXXXX_)

Now add this Container ID to the Grav Gtm Plugin

1. Login to your Grav CMS Admin
2. Click on the Plugins menu on the left side of your Admin panel.
3. Click on the "Gtm Plugin" link.
4. Enable the plugin
5. Add the Container ID to the "GTM Container ID" plugin field.
6. Click on the Save button (upper right hand corner).

## Credits

Inspired by the Grav Ganalytics Plugin, John Linhart (admin@escope.cz), Christian Worreschk (cw@marsec.de)
https://github.com/escopecz/grav-ganalytics Thanks!

## To Do

- [ ] Allow different 'dataLayer' names
- [ ] Add website and page information to the dataLayer to allow marketing tag capture and future analysis

