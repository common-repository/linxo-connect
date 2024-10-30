<?php
/**
 * The admin settings of the plugin.
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="wrap linxo-woo">

    <?php
        settings_errors();

        require LINXO_WOO_PLUGIN_PATH . 'admin/templates/page-settings/changelog.php';
        require LINXO_WOO_PLUGIN_PATH . 'admin/templates/page-settings/header.php';
        
        require LINXO_WOO_PLUGIN_PATH . 'admin/templates/page-settings/nav-tabs.php';
    ?>

    <div class="linxo-woo__tabs-content">
        
        <?php
            if ( file_exists(LINXO_WOO_PLUGIN_PATH . 'admin/templates/page-settings/tabs/' . $active_tab . '.php') ) {
                require LINXO_WOO_PLUGIN_PATH . 'admin/templates/page-settings/tabs/' . $active_tab . '.php';
            }
        ?>

    </div>

</div>