<?php
/**
 * The admin settings page presentation tab
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="linxo-woo__tabs-content__tab">

    <div class="linxo-woo__tabs-content__presentation">

        <div class="linxo-woo__tabs-content__presentation__section ">
            <div class="linxo-woo__tabs-content__tab__form__body__info">
                <div class="linxo-woo__tabs-content__tab__form__body__info__icon"><?php echo linxo_woo_sanitize_svg(LINXO_WOO_PLUGIN_URL . 'public/assets/svg/info.svg'); ?></div>
                <div class="linxo-woo__tabs-content__tab__form__body__info__text">
                    <p><?php echo sprintf(/* translators: 1: tag html 2: tag html */ esc_html__('%1$sTo take full advantage of the features of your Linxo Connect Payments module and receive your login details, it is essential to sign up to a contract. If you have downloaded the Payments plugin directly from Wordpress/Woocommerce: %2$s', 'linxo-woo' ), '<b>', '</b>' ); ?></p>
                    <ul class="ul-disc">
                        <li><?php echo sprintf(esc_html__('Complete %1$sthis contact form%2$s', 'linxo-woo'), '<a href="https://linxoconnect.com/formulaire-plugin-cms/" target="_blank">', '</a>'); ?></li>
                        <li><?php echo esc_html_e('Complete the order form which will be sent to you by email', 'linxo-woo'); ?></li>
                        <li><?php echo esc_html_e('You will then receive your login details enabling you to configure the Payments plugin', 'linxo-woo' ); ?></li>
                    </ul>
                </div>
            </div>
        </div>

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