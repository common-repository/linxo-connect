<?php
/**
 * The admin settings page changelog
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="linxo-woo__changelog">

    <div class="linxo-woo__changelog__text">
        <div class="linxo-woo__changelog__icon"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/info-circle.svg');?></div>
        <div class="linxo-woo__changelog__title"><?php echo sprintf(/* translators: %s: num version */ esc_html__( "Linxo v%s", 'linxo-woo' ), esc_html(LINXO_WOO_VERSION) ); ?> -</div>
        <div class="linxo-woo__changelog__btn" id="JS-LINXO-changelog-open"><?php esc_html_e( "Latest version - What's new?", 'linxo-woo' ); ?></div>
    </div>

    <div class="linxo-woo__changelog__popup" id="JS-LINXO-changelog-popup">
        <div class="linxo-woo__changelog__popup__overlay" id="JS-LINXO-changelog-overlay"></div>
        <div class="linxo-woo__changelog__popup__content">
            <div class="linxo-woo__changelog__popup__content__header">
                <div class="linxo-woo__changelog__popup__content__header__title"><?php esc_html_e( "Latest version - What's new?", 'linxo-woo' ); ?></div>
                <div class="linxo-woo__changelog__popup__content__header__close" id="JS-LINXO-changelog-close"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/times.svg'); ?></div>
            </div>
            <div class="linxo-woo__changelog__popup__content__body">
                <?php
                    $lang = get_user_locale();
                    $lang = substr( $lang, 0, 2 );

                    if (file_exists(LINXO_WOO_PLUGIN_PATH . 'public/assets/txt/changelog-' . $lang . '.txt')) {
                        $changelog_text = linxo_woo_sanitize_svg(LINXO_WOO_PLUGIN_URL . 'public/assets/txt/changelog-' . $lang . '.txt');
                    } else {
                        $changelog_text = linxo_woo_sanitize_svg(LINXO_WOO_PLUGIN_URL . 'public/assets/txt/changelog.txt');
                    }
                    echo wp_kses_post( wpautop( wptexturize( $changelog_text ) ) );
                ?>
            </div>
        </div>
    </div>

</div>