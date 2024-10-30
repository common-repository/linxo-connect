<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<nav class="linxo-woo__nav-tabs nav-tab-wrapper">

    <?php foreach( $tabs_array as $tab_id => $tab_values ):

        $title   = $tab_values['title'] ?? '';
        ?>

        <a href="?page=<?php echo esc_html($page_slug); ?>&tab=<?php echo esc_html($tab_id); ?>" class="nav-tab <?php echo $tab_id == $active_tab ? 'nav-tab-active' : ''; ?>">
            <?php echo esc_html($title); ?>
        </a>
    <?php endforeach; ?>

</nav>