
<?php
/*
Plugin Name: WordPress Fast Plugin Installer
Author: Mayur Jobanputra
Description: A plugin to help you quickly install several plugins from WordPress repo URLs
Version: 1.0
*/

// Hook for adding admin menus
add_action('admin_menu', 'wpdev_plugin_preinstaller_menu');

// Action for the form submission
add_action('admin_post_install_plugins', 'wpdev_install_selected_plugins');

// Function to add a menu item for the plugin
function wpdev_plugin_preinstaller_menu() {
    add_menu_page('WordPress Fast Plugin Installer', 'Fast Plugin Installer', 'manage_options', 'fast-plugin-installer', 'wpdev_plugin_preinstaller_page');
}

// Function to display the plugin's admin page
function wpdev_plugin_preinstaller_page() {
    ?>
    <div class="wrap">
        <h1>WordPress Fast Plugin Installer</h1>
        <form action="<?php echo admin_url('admin-post.php'); ?>" method="post">
            <input type="hidden" name="action" value="install_plugins">

            <h2>Select plugins to install:</h2>
            <?php wpdev_list_plugins_to_install(); ?>

            <input type="submit" class="button button-primary" value="Install Selected Plugins">
        </form>
    </div>
    <?php
}

// List all plugins with checkboxes
function wpdev_list_plugins_to_install() {
    $plugin_urls = array(
        'https://wordpress.org/plugins/wordpress-seo/',
        'https://wordpress.org/plugins/duplicate-page/',
        'https://wordpress.org/plugins/wordpress-seo/',
        'https://wordpress.org/plugins/classic-editor/',
        'https://wordpress.org/plugins/worker/',
        'https://wordpress.org/plugins/elementor/',
        'https://wordpress.org/plugins/favicon-by-realfavicongenerator/',
        'https://wordpress.org/plugins/google-site-kit/',
        'https://wordpress.org/plugins/wp-mail-smtp/',
        'https://wordpress.org/plugins/fluent-crm/'
        // ... Add other plugin URLs here
    );

    foreach ($plugin_urls as $url) {
        $slug = wpdev_extract_slug_from_url($url);
        echo '<label><input type="checkbox" name="plugins[]" value="' . esc_attr($slug) . '"> ' . esc_html($slug) . '</label><br>';
    }
}

// Function to handle the form submission
function wpdev_install_selected_plugins() {
    if (isset($_POST['plugins']) && is_array($_POST['plugins'])) {
        foreach ($_POST['plugins'] as $slug) {
            if (!wpdev_is_plugin_installed($slug)) {
                wpdev_install_plugin($slug);
            }
        }
    }

    // Redirect back to the plugin page
    wp_redirect(admin_url('admin.php?page=fast-plugin-installer'));
    exit;
}

// Extract slug from URL
function wpdev_extract_slug_from_url($url) {
    // Parse the URL and get the path part
    $parts = parse_url($url);
    $path = isset($parts['path']) ? $parts['path'] : '';

    // Normalize the path to ensure it has a consistent format
    $path = trim($path, '/');

    // Search for the plugins directory in the path
    $pattern = '/wordpress\.org\/plugins\//';
    $path_parts = preg_split($pattern, $path);

    // If the split is successful, the last part should be the slug
    if (is_array($path_parts) && count($path_parts) > 1) {
        return end($path_parts);
    }

    // Return false if the slug could not be extracted
    return false;
}


// Check if a plugin is installed
function wpdev_is_plugin_installed($slug) {
    include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
    include_once ABSPATH . 'wp-admin/includes/plugin.php';

    $api = plugins_api('plugin_information', array('slug' => $slug));

    if (is_wp_error($api)) {
        return false;
    }

    $installed_plugins = get_plugins();

    foreach ($installed_plugins as $path => $plugin) {
        if (strpos($path, $slug) !== false) {
            return true;
        }
    }

    return false;
}

// Install a plugin
function wpdev_install_plugin($slug) {
    include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    include_once ABSPATH . 'wp-admin/includes/class-automatic-upgrader-skin.php';

    $upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());
    $upgrader->install("https://wordpress.org/plugins/{$slug}/latest.zip");
}
?>
