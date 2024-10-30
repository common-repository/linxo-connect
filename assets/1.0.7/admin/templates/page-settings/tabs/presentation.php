<?php
/**
 * The admin settings page presentation tab
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="linxo-woo__tabs-content__tab">

    <div class="linxo-woo__tabs-content__presentation">

        <div class="linxo-woo__tabs-content__presentation__section flex">

            <div class="linxo-woo__tabs-content__presentation__section__left">

                <div class="linxo-woo__tabs-content__presentation__subtitle"><?php esc_html_e( 'Opt for a wire transfer', 'linxo-woo' ); ?></div>
                <div class="linxo-woo__tabs-content__presentation__title"><?php esc_html_e( 'smooth and secured', 'linxo-woo' ) ?> <span>!</span></div>

                <div class="linxo-woo__tabs-content__presentation__text">

                    <div class="linxo-woo__tabs-content__presentation__text__item">
                        <div class="linxo-woo__tabs-content__presentation__text__item__icon"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-right-golden.svg' ); ?></div>
                        <div class="linxo-woo__tabs-content__presentation__text__item__text"><?php esc_html_e( 'Easy purchasing process: fully automated bank transfer payment, with no need for the payer to enter an IBAN.', 'linxo-woo') ?></div>
                    </div>

                    <div class="linxo-woo__tabs-content__presentation__text__item">
                        <div class="linxo-woo__tabs-content__presentation__text__item__icon"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-right-golden.svg' ); ?></div>
                        <div class="linxo-woo__tabs-content__presentation__text__item__text"><?php esc_html_e( 'High payment limits (ideal for carts with significant amounts).', 'linxo-woo') ?></div>
                    </div>

                    <div class="linxo-woo__tabs-content__presentation__text__item">
                        <div class="linxo-woo__tabs-content__presentation__text__item__icon"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-right-golden.svg' ); ?></div>
                        <div class="linxo-woo__tabs-content__presentation__text__item__text"><?php esc_html_e( 'One of the most secured solutions available in the market.', 'linxo-woo') ?></div>
                    </div>

                    <div class="linxo-woo__tabs-content__presentation__text__item">
                        <div class="linxo-woo__tabs-content__presentation__text__item__icon"><?php echo linxo_woo_sanitize_svg(LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-right-golden.svg' ); ?></div>
                        <div class="linxo-woo__tabs-content__presentation__text__item__text"><?php esc_html_e( 'Lower transaction costs.', 'linxo-woo') ?></div>
                    </div>

                    <div class="linxo-woo__tabs-content__presentation__text__item">
                        <div class="linxo-woo__tabs-content__presentation__text__item__icon"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-right-golden.svg' ); ?></div>
                        <div class="linxo-woo__tabs-content__presentation__text__item__text"><?php esc_html_e( 'Immediate payment confirmation.', 'linxo-woo') ?></div>
                    </div>

                </div>

            </div>

            <div class="linxo-woo__tabs-content__presentation__section__right">
                <img src="<?php echo esc_url(LINXO_WOO_PLUGIN_URL . 'public/assets/img/presentation-1.jpg') ?>" alt="">
            </div>

        </div>

        <div class="linxo-woo__tabs-content__presentation__section">

            <div class="linxo-woo__tabs-content__presentation__subtitle"><?php esc_html_e( 'How does', 'linxo-woo' ); ?></div>
            <div class="linxo-woo__tabs-content__presentation__title"><?php esc_html_e( 'payment initiation', 'linxo-woo' ) ?> <span>?</span></div>

            <div class="linxo-woo__tabs-content__presentation__img">
                <img src="<?php echo esc_url($steps_image); ?>" alt="reassurance">
            </div>

        </div>

    </div>

</div>