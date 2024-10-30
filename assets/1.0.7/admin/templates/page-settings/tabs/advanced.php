<?php
/**
 * The admin settings page advanced tab
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>


<div class="linxo-woo__tabs-content__tab">

    <form action="" method="post" class="linxo-woo__tabs-content__tab__form">

        <div class="linxo-woo__tabs-content__tab__form__header">
            <div class="linxo-woo__tabs-content__tab__form__header__title">
                <div class="linxo-woo__tabs-content__tab__form__header__title__icon"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/cogs.svg' ); ?></div>
                <div class="linxo-woo__tabs-content__tab__form__header__title__text"><?php esc_html_e( 'Payment settings', 'linxo-woo'); ?></div>
            </div>
        </div>

        <div class="linxo-woo__tabs-content__tab__form__body">

        <table class="linxo-woo__tabs-content__tab__form__body__table form-table">

            <tr>
                <th></th>
                <td>
                    <p class="linxo-woo__title"><?php esc_html_e( 'Advanced settings', 'linxo-woo' ); ?></p>
                </td>
            </tr>

            <tr>
                <th><?php esc_html_e( "Allow logs", 'linxo-woo' ); ?></th>
                <td>
                    <label class="linxo-woo__toggle">
                        <input type="hidden" name="linxo_woo_advanced_enable_logs" value="0">
                        <input type="checkbox" name="linxo_woo_advanced_enable_logs" value="1" <?php checked( $advanced_enable_logs, '1' ); ?>>
                        <span class="slider"></span>
                        <div class="text">
                            <span class="yes"><?php esc_html_e( 'Yes', 'linxo-woo' ); ?></span>
                            <span class="no"><?php esc_html_e( 'No', 'linxo-woo' ); ?></span>
                        </div>
                    </label>
                    
                    <?php if ( !empty( $log_files ) ): ?>

                        <div>
                            <p><?php echo sprintf( esc_html__( 'The minimum log file level will be set to Debug. You can access older files on your server, in the %s directory.', 'linxo-woo'), '<code>/wp-content/uploads/wc-logs</code>' ); ?></p>
                            <span class="download-btn">
                                <a id="JS-LINXO-account-button-dwn-log-file" href="javascript:void(0)" data-href="<?php echo wp_date( 'Y_m' ) . '_linxo_woo.log'; ?>">
                                    <?php esc_html_e( 'Click here to download the latest file', 'linxo-woo' ); ?>
                                    <span class="spinner" style="margin: 0;"></span>
                                </a>
                            </span>
                        </div>

                    <?php endif; ?>

                </td>
            </tr>

            </table>

            <table class="linxo-woo__tabs-content__tab__form__body__table form-table">
                <hr>
                <tr>
                    <th></th>
                    <td>
                        <p class="linxo-woo__title"><?php esc_html_e( 'Payment settings', 'linxo-woo' ); ?></p>
                    </td>
                </tr>
            </table>

            <div class="linxo-woo__tabs-content__tab__form__body__info">
                <div class="linxo-woo__tabs-content__tab__form__body__info__icon"><?php echo linxo_woo_sanitize_svg(LINXO_WOO_PLUGIN_URL . 'public/assets/svg/info.svg'); ?></div>
                <div class="linxo-woo__tabs-content__tab__form__body__info__text">
                    <p><?php echo sprintf(/* translators: 1: tag html 2: tag html */ esc_html__( '%1$sInstant transfer:%2$s Transfer received within 10 seconds, additional fees may apply depending on bank.', 'linxo-woo' ), '<b>', '</b>' ); ?></p>
                    <p><?php echo sprintf(/* translators: 1: tag html 2: tag html */ esc_html__( '%1$sStandard transfer:%2$s A standard transfer between 2 banks takes 1 to 2 business days.', 'linxo-woo' ), '<b>', '</b>' ); ?></p>
                </div>
            </div>

            <table class="linxo-woo__tabs-content__tab__form__body__table form-table">

                <tr>
                    <th><?php esc_html_e( 'Transfer type', 'linxo-woo' ); ?></th>
                    <td>
                        <label>
                            <input type="radio" name="linxo_woo_advanced_payment_type" value="classic" <?php checked( $advanced_payment_type, 'classic' ); ?>>
                            <?php esc_html_e( 'Standard', 'linxo-woo' ); ?>
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="linxo_woo_advanced_payment_type" value="instant" <?php checked( $advanced_payment_type, 'instant' ); ?>>
                            <?php esc_html_e( 'Instant', 'linxo-woo' ); ?>
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="linxo_woo_advanced_payment_type" value="both" <?php checked( $advanced_payment_type, 'both' ); ?>>
                            <?php esc_html_e( 'Both', 'linxo-woo' ); ?>
                        </label>
                    </td>
                </tr>

            </table>
            
            <table class="linxo-woo__tabs-content__tab__form__body__table form-table">

                <tr>
                    <th><?php esc_html_e( "Manual IBAN entry page", 'linxo-woo' ); ?></th>
                    <td>
                        <label class="linxo-woo__toggle">
                            <input type="hidden" name="linxo_woo_advanced_manual_entry_page_display" value="0">
                            <input type="checkbox" name="linxo_woo_advanced_manual_entry_page_display" value="1" <?php checked( $advanced_manual_entry_page_display, '1' ); ?>>
                            <span class="slider"></span>
                            <div class="text">
                                <span class="yes"><?php esc_html_e( 'Yes', 'linxo-woo' ); ?></span>
                                <span class="no"><?php esc_html_e( 'No', 'linxo-woo' ); ?></span>
                            </div>
                        </label>
                    </td>
                </tr>

            </table>

            <table class="linxo-woo__tabs-content__tab__form__body__table form-table">

                <tr>
                    <th><?php esc_html_e( "Enable IBAN storage", 'linxo-woo' ); ?></th>
                    <td>
                        <label class="linxo-woo__toggle">
                            <input type="hidden" name="linxo_woo_advanced_alias_storage_enabled" value="0">
                            <input type="checkbox" name="linxo_woo_advanced_alias_storage_enabled" value="1" <?php checked( $advanced_alias_storage_enabled, '1' ); ?>>
                            <span class="slider"></span>
                            <div class="text">
                                <span class="yes"><?php esc_html_e( 'Yes', 'linxo-woo' ); ?></span>
                                <span class="no"><?php esc_html_e( 'No', 'linxo-woo' ); ?></span>
                            </div>
                        </label>
                    </td>
                </tr>

            </table>

        </div>

        <div class="linxo-woo__tabs-content__tab__form__footer">
            <?php wp_nonce_field( 'linxo_woo_admin_custom_settings', '_linxo_woo_admin_nonce' ); ?>
            <button type="submit" class="linxo-woo__tabs-content__tab__form__footer__save button button-primary" name="linxo_woo_advanced_submit"><?php esc_html_e( "Save", 'linxo-woo' ); ?></button>
        </div>

    </form>

</div>