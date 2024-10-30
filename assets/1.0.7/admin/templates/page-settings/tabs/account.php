<?php
/**
 * The admin settings page account tab
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="linxo-woo__tabs-content__tab">

    <form action="" method="post" class="linxo-woo__tabs-content__tab__form">

        <div class="linxo-woo__tabs-content__tab__form__header">
            <div class="linxo-woo__tabs-content__tab__form__header__title">
                <div class="linxo-woo__tabs-content__tab__form__header__title__icon"><?php echo linxo_woo_sanitize_svg(LINXO_WOO_PLUGIN_URL . 'public/assets/svg/user.svg' ); ?></div>
                <div class="linxo-woo__tabs-content__tab__form__header__title__text"><?php esc_html_e( 'Authentication', 'linxo-woo'); ?></div>
            </div>
        </div>

        <div class="linxo-woo__tabs-content__tab__form__body">

            <table class="linxo-woo__tabs-content__tab__form__body__table form-table">

                <tr>
                    <th><?php esc_html_e( 'Mode', 'linxo-woo' ); ?></th>
                    <td>
                        <label>
                            <input type="radio" id="JS-LINXO-account-demo-sandbox" name="linxo_woo_account_demo_mode" value="1" <?php checked( $account_demo_mode, '1' ); ?>>
                            <?php esc_html_e( 'Sandbox', 'linxo-woo' ); ?>
                        </label>
                        <br>
                        <label>
                            <input type="radio" id="JS-LINXO-account-demo-production" name="linxo_woo_account_demo_mode" value="0" <?php checked( $account_demo_mode, '0' ); ?>>
                            <?php esc_html_e( 'Production', 'linxo-woo' ); ?>
                        </label>
                    </td>
                </tr>

            </table>

            <div class="linxo-woo__tabs-content__tab__form__body__info">
                <div class="linxo-woo__tabs-content__tab__form__body__info__icon"><?php echo linxo_woo_sanitize_svg(LINXO_WOO_PLUGIN_URL . 'public/assets/svg/info.svg'); ?></div>
                <div class="linxo-woo__tabs-content__tab__form__body__info__text">
                    <p><?php echo sprintf(	/* translators: 1: tag 2: tag */
                        esc_html__( '%1$sSandbox:%2$s To obtain your own Sandbox credentials, please contact Linxo Connect through the contact form:', 'linxo-woo' ), '<strong>', '</strong>' ); ?></p>
                    <p><a href="https://linxoconnect.com/contact/">https://linxoconnect.com/contact/</a><p>
                    <br>
                    <p><?php echo sprintf( /* translators: 1: tag 2: tag */esc_html__( '%1$sProduction:%2$s Your Production credentials will be subsequently communicated to you by our technical teams.', 'linxo-woo' ), '<strong>', '</strong>' ); ?></p>
                </div>
            </div>

            <table id="JS-LINXO-account-sandbox" class="linxo-woo__tabs-content__tab__form__body__table form-table" <?php echo $account_demo_mode === '0' ? 'style="display:none"' : '' ?>  >

                <tr>
                    <th><?php esc_html_e( "Sandbox ID", 'linxo-woo' ); ?></th>
                    <td>
                        <input type="text" name="linxo_woo_account_client_id_demo" value="<?php echo esc_attr( $account_client_id_demo ); ?>">
                    </td>
                </tr>

                <tr>
                    <th><?php esc_html_e( "Sandbox Secret", 'linxo-woo' ); ?></th>
                    <td>
                        <div class="password-input show">
                            <input type="password" name="linxo_woo_account_client_secret_demo" value="<?php echo esc_attr( $account_client_secret_demo ); ?>">
                            <span class="password-input__show"><?php linxo_woo_sanitize_svg(LINXO_WOO_PLUGIN_URL . 'public/assets/svg/eye-show.svg' ); ?></span>
                            <span class="password-input__hide"><?php linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/eye-hide.svg' ); ?></span>
                        </div>
                    </td>
                </tr>
                
            </table>

            <table id="JS-LINXO-account-prod" class="linxo-woo__tabs-content__tab__form__body__table form-table" <?php echo $account_demo_mode === '1' ? 'style="display:none"' : '' ?>>

                <tr>
                    <th><?php esc_html_e( "Production ID", 'linxo-woo' ); ?></th>
                    <td>
                        <input type="text" name="linxo_woo_account_client_id" value="<?php echo esc_attr( $account_client_id ); ?>">
                    </td>
                </tr>

                <tr>
                    <th><?php esc_html_e( "Production Secret", 'linxo-woo' ); ?></th>
                    <td>
                        <div class="password-input show">
                            <input type="password" name="linxo_woo_account_client_secret" value="<?php echo esc_attr( $account_client_secret ); ?>">
                            <span class="password-input__show"><?php linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/eye-show.svg' ); ?></span>
                            <span class="password-input__hide"><?php linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/eye-hide.svg' ); ?></span>
                        </div>
                    </td>
                </tr>
                
            </table>

        </div>

        <div class="linxo-woo__tabs-content__tab__form__footer">
            <?php wp_nonce_field( 'linxo_woo_admin_custom_settings', '_linxo_woo_admin_nonce' ); ?>
            <button type="submit" class="linxo-woo__tabs-content__tab__form__footer__test button button-primary" name="linxo_woo_account_test"><?php esc_html_e( "Save & Check credentials", 'linxo-woo' );?></button>
        </div>

    </form>

</div>
