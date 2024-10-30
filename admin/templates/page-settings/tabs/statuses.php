<?php
/**
 * The admin settings page statuses tab
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="linxo-woo__tabs-content__tab">

    <form action="" method="post" class="linxo-woo__tabs-content__tab__form">

        <div class="linxo-woo__tabs-content__tab__form__header">
            <div class="linxo-woo__tabs-content__tab__form__header__title">
                <div class="linxo-woo__tabs-content__tab__form__header__title__icon"><?php echo linxo_woo_sanitize_svg(LINXO_WOO_PLUGIN_URL . 'public/assets/svg/cogs.svg' ); ?></div>
                <div class="linxo-woo__tabs-content__tab__form__header__title__text"><?php esc_html_e( 'Order Statuses', 'linxo-woo'); ?></div>
            </div>
        </div>

        <div class="linxo-woo__tabs-content__tab__form__body">

            <div class="linxo-woo__tabs-content__tab__form__body__info">
                <div class="linxo-woo__tabs-content__tab__form__body__info__icon"><?php echo linxo_woo_sanitize_svg(LINXO_WOO_PLUGIN_URL . 'public/assets/svg/info.svg'); ?></div>
                <div class="linxo-woo__tabs-content__tab__form__body__info__text">
                    <p><?php esc_html_e( 'Default fields are ready-to-use, but you can adjust them according to your needs. However, please note that changing the statuses will affect WordPress\'s automated actions. For instance, the "Payment accepted" order status triggers an email to your customer to confirm his order.', 'linxo-woo' ); ?></p>
                </div>
            </div>

            <table class="linxo-woo__tabs-content__tab__form__body__table form-table">

                <tr>
                    <th><?php esc_html_e( "Payer authenticated", 'linxo-woo' ); ?></th>
                    <td>
                        <select name="linxo_woo_statuses_authorized_status">
                            <?php foreach ( $statuses_authorized_status_select as $status_id => $status_name ): ?>
                                <option value="<?php echo esc_attr($status_id); ?>" <?php selected( $statuses_authorized_status, $status_id ); ?> ><?php echo esc_html($status_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th><?php esc_html_e( "Payment accepted", 'linxo-woo' ); ?></th>
                    <td>
                        <select name="linxo_woo_statuses_captured_status">
                            <?php foreach ( $statuses_captured_status_select as $status_id => $status_name ): ?>
                                <option value="<?php echo esc_attr($status_id); ?>" <?php selected( $statuses_captured_status, $status_id ); ?> ><?php echo esc_html($status_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th><?php esc_html_e( "Payment cancelled", 'linxo-woo' ); ?></th>
                    <td>
                        <select name="linxo_woo_statuses_cancelled_status">
                            <?php foreach ( $statuses_cancelled_status_select as $status_id => $status_name ): ?>
                                <option value="<?php echo esc_attr($status_id); ?>" <?php selected( $statuses_cancelled_status, $status_id ); ?> ><?php echo esc_html($status_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th><?php esc_html_e( "Payment rejected", 'linxo-woo' ); ?></th>
                    <td>
                        <select name="linxo_woo_statuses_error_status">
                            <?php foreach ( $statuses_error_status_select as $status_id => $status_name ): ?>
                                <option value="<?php echo esc_attr($status_id); ?>" <?php selected( $statuses_error_status, $status_id ); ?> ><?php echo esc_html($status_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

            </table>

        </div>

        <div class="linxo-woo__tabs-content__tab__form__footer">
            <?php wp_nonce_field( 'linxo_woo_admin_custom_settings', '_linxo_woo_admin_nonce' ); ?>
            <button type="submit" class="linxo-woo__tabs-content__tab__form__footer__save button button-primary" name="linxo_woo_statuses_submit"><?php esc_html_e( "Save", 'linxo-woo' ); ?></button>
        </div>

    </form>

</div>