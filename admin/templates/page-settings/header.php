<?php
/**
 * The admin settings page header
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="linxo-woo__header">

    <div class="linxo-woo__header__logo">
        <img src="<?php echo esc_url(LINXO_WOO_PLUGIN_URL . 'public/assets/svg/linxo-logo.svg'); ?>"/>
    </div>
    
    <div class="linxo-woo__header__support">

        <div class="linxo-woo__header__support__contact">

            <div class="linxo-woo__header__support__contact__icon">
                <img src="<?php echo esc_url(LINXO_WOO_PLUGIN_URL . 'public/assets/svg/question-circle.svg'); ?>"/>
            </div>

            <div class="linxo-woo__header__support__contact__text">
                <p><b><?php esc_html_e( 'Do you have a question?', 'linxo-woo' ); ?></b></p>
                <p>
                    <a href="<?php echo esc_url($header_contact_support); ?>" target="_blank">
                        <?php esc_html_e( 'Contact us', 'linxo-woo' ); ?>
                    </a>
                </p>
            </div>
            
        </div>

        <div class="linxo-woo__header__support__buttons">
            <a class="linxo-woo__header__support__buttons__download" href="<?php echo esc_url($header_download_pdf); ?>" download>
                <?php esc_html_e( 'Download User guide', 'linxo-woo' ); ?>
            </a>
        </div>

    </div>

</div>