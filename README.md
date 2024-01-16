# How to Use the WordPress Fast Plugin Installer

The WordPress Fast Plugin Installer allows you to quickly and easily install WordPress plugins listed in a `pluginslist.txt` file. To use this tool, follow these steps:

IMPORTANT: This plugin is NOT ready yet! Still being developed.

## 1. Fork the Repository

Start by forking this repository to your own GitHub account. This allows you to maintain a personal list of plugins you wish to install.

## 2. Edit `pluginslist.txt`

In your forked repository, edit the `pluginslist.txt` file. This file should contain a list of plugin URLs you wish to install on your WordPress site. Add one URL per line. For example:

https://wordpress.org/plugins/wordpress-seo/
https://wordpress.org/plugins/classic-editor/

You can also include direct links to plugin ZIP files from GitHub releases if you want to install plugins hosted on GitHub. Note the repo needs to be public. 

## 3. Install and Activate the Plugin

Download the plugin from your forked repository and install it on your WordPress site. You can do this by navigating to your WordPress admin dashboard, going to `Plugins` > `Add New` > `Upload Plugin`, and uploading the ZIP file of the plugin.

After uploading, activate the plugin.

## 4. Visit the Admin Page

Once the plugin is activated, visit the newly added admin page in your WordPress dashboard. This page is typically listed under the `Plugins` menu and titled "Fast Plugin Installer."

On this page, you'll see a list of plugins from your `pluginslist.txt` file, each with a checkbox next to it. Select the plugins you wish to install and click the "Install Selected Plugins" button.

The plugin will automatically download and install the selected plugins to your WordPress site.

---

**Note**: Always ensure that you trust the source of any plugins you are installing, especially when installing from external sources like GitHub.
