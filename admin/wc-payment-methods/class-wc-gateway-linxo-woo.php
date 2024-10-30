<?php
if (! defined('ABSPATH')) {
    exit;
}

class Linxo_Woo_WC_Gateway extends WC_Payment_Gateway
{

    const LINXO_WOO_ORDER_LINXO_ID    = 'linxo_woo_order_linxo_id';
    const LINXO_WOO_PAYMENT_METHOD = 'linxo_woo';

    protected static $instance = array();
    private $create_order_class;
    private $get_order_realtime_class;
    private $wc_order_data_class;
    private $get_specific_order_class;
    private $create_alias_class;
    private $put_order_closed_class;

    /**
     * Get instance of this class
     */
    public static function get_instance($class)
    {

        if (empty(self::$instance[$class])) {

            self::$instance[$class] = new static();
        }

        return self::$instance[$class];
    }

    /**
     * The class construct
     */
    public function __construct()
    {

        $this->create_order_class       = new Linxo_Woo_Create_Order();
        $this->get_order_realtime_class = new Linxo_Woo_Get_Order_Realtime();
        $this->wc_order_data_class      = new Linxo_Woo_WC_Order_Data();
        $this->get_specific_order_class = new Linxo_Woo_Get_Specific_Order();
        $this->create_alias_class       = new Linxo_Woo_Create_Alias();
        $this->put_order_closed_class   = new Linxo_Woo_Put_Order_Closed();

        $this->id                       = 'linxo_woo';
        $this->title                    = esc_html__('Payment with Linxo Connect', 'linxo-woo');
        $this->description              = $this->the_description();
        $this->method_title             = esc_html__('Linxo Connect', 'linxo-woo');
        $this->has_fields               = false;
        $this->icon                     = LINXO_WOO_PLUGIN_URL . 'public/assets/svg/linxo-icon-security.svg';
        $this->supports                   = array();
    }

    /**
     * Init hooks
     */
    public function init_hooks()
    {
        add_action('woocommerce_api_' . strtolower(get_class($this)), array($this, 'api_call'));
    }

    /**
     * Add the description content
     */
    public function the_description()
    {

        $current_language           = substr(get_locale(), 0, 2);
        $reassurance_image          = file_exists(LINXO_WOO_PLUGIN_PATH . 'public/assets/svg/reassurance/no-iban_' . $current_language . '.svg') ? LINXO_WOO_PLUGIN_URL . 'public/assets/svg/reassurance/no-iban_' . $current_language . '.svg' : LINXO_WOO_PLUGIN_URL . 'public/assets/svg/reassurance/no-iban_en.svg';

        ob_start();

?>

        <section class="lnx-additionnal linxo-woo">
            <div class="top_container d-flex gap-10">
                <div class="top_wrapper">
                    <div class="top_item bg-yellow-light d-flex">
                        <img class="top_img"
                            src="<?php echo esc_url($reassurance_image); ?>"
                            alt="<?php esc_attr_e('no iban', 'linxo-woo'); ?>"
                            width="62px" height="43px" />
                        <p class="text-bold text-blue text-top_item">
                            <?php esc_html_e('Simplified transfer (with pre-filled IBAN)', 'linxo-woo'); ?>
                        </p>
                    </div>
                </div>
                <div class="top_wrapper">
                    <div class="top_item top_item_last bg-yellow-light d-flex">
                        <img class="top_img"
                            src="<?php echo LINXO_WOO_PLUGIN_URL . 'public/assets/svg/reassurance/secure.svg'; ?>"
                            alt="<?php esc_attr_e('secure', 'linxo-woo'); ?>"
                            width="62px" height="43px" />
                        <p class="text-bold text-blue text-top_item">
                            <?php esc_html_e('Immediate and secure', 'linxo-woo'); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="bottom_wrapper">
                <div class="decoration"></div>
                <div class="bottom_item border-gray">
                    <p class="text-bold title text-blue">
                        <?php esc_html_e('How does it work?', 'linxo-woo'); ?>
                    </p>
                    <div class="d-flex step_1">
                        <div class="step text-bold bg-yellow">
                            <?php
                            esc_html_e('1', 'linxo-woo'); ?>
                        </div>
                        <div class="text_step text-blue">
                            <?php echo
                            sprintf(/* translators: tag html: link 2: tag html */esc_html__('Choose the bank %1$sfrom which you want to make the transfer%2$s and log in.', 'linxo-woo'), '<strong>', '</strong>'); ?>
                        </div>
                    </div>
                    <div class="d-flex step_2">
                        <div class="step text-bold bg-yellow">
                            <?php
                            esc_html_e('2', 'linxo-woo'); ?>
                        </div>
                        <div class="text_step text-blue">
                            <?php echo
                            sprintf(/* translators: tag html: link 2: tag html */esc_html__('%1$sConfirm the transfer%2$s, everything is pre-filled!', 'linxo-woo'), '<strong>', '</strong>'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <div class="d-flex flex-wrap footer_wrapper text-blue">
                    <p class="footer_text">
                        <?php echo
                        sprintf(/* translators: tag html: link 2: tag html */esc_html__('%1$sLinxo%2$s &nbsp; is a subsidiary of', 'linxo-woo'), '<strong>', '</strong>'); ?>
                    </p>
                    <img class="top_img footer_img"
                        src="<?php echo LINXO_WOO_PLUGIN_URL . 'public/assets/svg/reassurance/icon-ca.svg'; ?>"
                        alt="<?php esc_attr_e('no iban', 'linxo-woo'); ?>"
                        width="118px" height="15px" />
                </div>
            </div>
        </section>

        <?php

        return ob_get_clean();
    }

    /**
     * Display the correct state depend on the action attr
     */
    public function api_call()
    {

        $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : '';

        switch ($action) {
            case 'redirectFromPayment':
                $this->redirect_from_payment();
                break;
            case 'notification':
                $this->notification();
                break;
            case 'cancel_order':
                $this->cancel_order();
                break;
        }

        die();
    }

    /**
     * Redirect after the client click the checkout button
     */
    public function process_payment($order_id)
    {

        $order                    = wc_get_order($order_id);
        $customer_id            = $order->get_customer_id();
        $customer_email         = $order->get_billing_email();
        $customer_first_name    = $order->get_billing_first_name();
        $customer_last_name     = $order->get_billing_last_name();
        $advanced_payment_type  = linxo_woo_get_option('advanced_payment_type');

        if ($advanced_payment_type == 'instant') {
            $instant_payment = $this->create_order_class::LINXO_WOO_INSTANT_PAYMENT_EXPECTED;
        } elseif ($advanced_payment_type == 'both') {
            $instant_payment = $this->create_order_class::LINXO_WOO_INSTANT_PAYMENT_USER_CHOICE;
        } else {
            $instant_payment = $this->create_order_class::LINXO_WOO_INSTANT_PAYMENT_NO;
        }

        if (is_user_logged_in() && linxo_woo_get_option('advanced_alias_storage_enabled') === '1') {

            $user_reference = sprintf('C-%s', md5($customer_id . $customer_email));
            $this->create_order_class->set_user_reference($user_reference);
        }

        $this->create_order_class->set_instant_payment($instant_payment);
        $this->create_order_class->set_email($customer_email);
        $this->create_order_class->set_redirect_url(add_query_arg(array('action' => 'redirectFromPayment', 'wc_order' => $order_id), trailingslashit(site_url('wc-api/' . get_class($this)))));
        $this->create_order_class->set_amount($order->get_total());
        $this->create_order_class->set_currency($order->get_currency());
        $this->create_order_class->set_name($customer_first_name . ' ' . $customer_last_name);
        $this->create_order_class->set_schema($this->create_order_class::LINXO_WOO_SCHEMA_ALIAS);
        $this->create_order_class->set_alias_id(linxo_woo_get_default_alias());
        $products_count = 0;
        foreach ($order->get_items() as $item) {
            $products_count += $item->get_quantity();
        }
        $this->create_order_class->set_label(sprintf(esc_html__('Order ID %d : %d item(s)', 'linxo-woo'), $order_id, $products_count));
        $response = $this->create_order_class->send_order();

        if ($response) {

            $auth_url       = $response->auth_url ?? '';
            $linxo_order_id = $response->id ?? '';

            $auth_url = add_query_arg(array(
                'locale'        => get_locale(),
                'ask_for_iban'  => linxo_woo_get_option('advanced_manual_entry_page_display'),
                'ask_for_alias' => linxo_woo_get_option('advanced_alias_storage_enabled'),
                'cancel_url'    => urlencode(add_query_arg(array('action' => 'cancel_order', 'order_id' => $linxo_order_id), trailingslashit(site_url('wc-api/' . get_class($this))))),
            ), $auth_url);

            return array(
                'result'   => 'success',
                'redirect' => $auth_url
            );
        }

        return array(
            'result'   => 'failure',
            'redirect' => wc_get_checkout_url(),
            'message'  => esc_html__('Payment error: Please try again', 'linxo-woo')
        );
    }

    /**
     * Show the payment information for order in admin area
     */
    public function show_details_in_admin($order)
    {

        $order_linxo_id = $order->get_meta(self::LINXO_WOO_ORDER_LINXO_ID, true);

        if (empty($order_linxo_id)) {
            return;
        }

        $this->get_specific_order_class->set_order_id($order_linxo_id);
        $specific_order_response = $this->get_specific_order_class->get_order();

        if (!$specific_order_response) {

        ?>
            <div class="linxo-woo__empty">
                <p><?php esc_html_e('No transactions found for this order', 'linxo-woo'); ?></p>
            </div>
        <?php

        } else {

            $specific_order = $this->get_specific_order_class->admin_format($specific_order_response);
            $payer_iban     = $specific_order['payer']['iban'];
            if (strlen($payer_iban) > 8) {
                $payer_iban = substr($payer_iban, 0, 4) . str_repeat('X', strlen($payer_iban) - 8) . substr($payer_iban, -4);
            }

        ?>
            <div class="linxo-woo__info">

                <div class="linxo-woo__info__item">
                    <div class="linxo-woo__info__item__title"><?php esc_html_e('Status', 'linxo-woo') ?></div>
                    <div class="linxo-woo__info__item__content"><?php echo esc_html($specific_order['order']['status']); ?></div>
                </div>
                <div class="linxo-woo__info__item">
                    <div class="linxo-woo__info__item__title"><?php esc_html_e('ID', 'linxo-woo') ?></div>
                    <div class="linxo-woo__info__item__content"><?php echo esc_html($specific_order['order']['id']); ?></div>
                </div>
                <div class="linxo-woo__info__item">
                    <div class="linxo-woo__info__item__title"><?php esc_html_e('Amount', 'linxo-woo') ?></div>
                    <div class="linxo-woo__info__item__content"><?php echo esc_html($specific_order['order']['amount_text']); ?></div>
                </div>
                <div class="linxo-woo__info__item">
                    <div class="linxo-woo__info__item__title"><?php esc_html_e('Payment type', 'linxo-woo') ?></div>
                    <div class="linxo-woo__info__item__content"><?php echo esc_html($specific_order['order']['type_text']); ?></div>
                </div>
                <div class="linxo-woo__info__item">
                    <div class="linxo-woo__info__item__title"><?php esc_html_e('Date', 'linxo-woo') ?></div>
                    <div class="linxo-woo__info__item__content"><?php echo esc_html($specific_order['order']['creation_date']); ?></div>
                </div>

            </div>

            <div class="linxo-woo__data">

                <div class="linxo-woo__data__left">
                    <div class="linxo-woo__data__left__header">
                        <div class="linxo-woo__data__left__title"><?php esc_html_e('Payer details', 'linxo-woo'); ?></div>
                    </div>
                    <div class="linxo-woo__data__left__body">
                        <table>
                            <tbody>
                                <tr>
                                    <th><?php esc_html_e('Banking Institution', 'linxo-woo'); ?></th>
                                    <td>
                                        <img src="<?php echo esc_attr($specific_order['payer']['provider']['logo']); ?>">
                                        <?php echo esc_html($specific_order['payer']['provider']['name']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php esc_html_e('Scheme', 'linxo-woo'); ?></th>
                                    <td><?php echo esc_html($specific_order['payer']['schema']); ?></td>
                                </tr>
                                <tr>
                                    <th><?php esc_html_e('IBAN', 'linxo-woo'); ?></th>
                                    <td><?php echo esc_html($payer_iban); ?></td>
                                </tr>
                                <tr>
                                    <th><?php esc_html_e('Email', 'linxo-woo'); ?></th>
                                    <td><?php echo esc_html($specific_order['order']['email']); ?></td>
                                </tr>
                                <tr>
                                    <th><?php esc_html_e('Payer reference', 'linxo-woo'); ?></th>
                                    <td><?php echo esc_html($specific_order['order']['user_reference']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="linxo-woo__data__right">
                    <div class="linxo-woo__data__right__header">
                        <div class="linxo-woo__data__right__title"><?php esc_html_e('Payments details', 'linxo-woo'); ?></div>
                    </div>
                    <div class="linxo-woo__data__right__body">
                        <table>
                            <thead>
                                <tr>
                                    <th><?php esc_html_e('Date', 'linxo-woo'); ?></th>
                                    <th><?php esc_html_e('Label', 'linxo-woo'); ?></th>
                                    <th><?php esc_html_e('Amount', 'linxo-woo'); ?></th>
                                    <th><?php esc_html_e('Status', 'linxo-woo'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($specific_order['payments'] as $payment) : ?>
                                    <tr>
                                        <td><?php echo esc_html($payment['execution_date']); ?></td>
                                        <td><?php echo esc_html($payment['label']); ?></td>
                                        <td><?php echo esc_html($payment['amount_text']); ?></td>
                                        <td><?php echo esc_html($payment['status']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
<?php
        }
    }

    /**
     * Redirect from payment
     */
    private function redirect_from_payment()
    {

        $client_id      = isset($_GET['client_id']) ? sanitize_text_field($_GET['client_id']) : '';
        $order_linxo_id = isset($_GET['order_id']) ? sanitize_text_field($_GET['order_id']) : '';
        $wc_order_id    = isset($_GET['wc_order']) ? sanitize_text_field($_GET['wc_order']) : '';

        if (empty($client_id) || empty($order_linxo_id) || empty($wc_order_id)) {

            $message = sprintf(__CLASS__ . ':' . __FUNCTION__ . ": Redirect from payment failed due to missing data for order(%s).", $wc_order_id);
            linxo_woo_add_log($message, 'error');

            wc_add_notice(esc_html__('Payment error: Please try again', 'linxo-woo'), 'error', array('id' => 'linxo-woo'));
            $redirect_url = add_query_arg(array('action' => 'failed'), wc_get_checkout_url());
            wp_safe_redirect($redirect_url);
            die();
        }

        $order  = wc_get_order($wc_order_id);

        if ($order->get_payment_method() != self::LINXO_WOO_PAYMENT_METHOD) {
            $message = sprintf(__CLASS__ . ':' . __FUNCTION__ . ": Redirect from payment failed due to order(%s) not exist.", $wc_order_id);
            linxo_woo_add_log($message, 'error');

            wc_add_notice(esc_html__('Payment error: Please try again', 'linxo-woo'), 'error', array('id' => 'linxo-woo'));
            $redirect_url = add_query_arg(array('action' => 'failed'), wc_get_checkout_url());
            wp_safe_redirect($redirect_url);
            die();
        }

        if (!$order) {

            $message = sprintf(__CLASS__ . ':' . __FUNCTION__ . ": Redirect from payment failed due to order(%s) not exist.", $wc_order_id);
            linxo_woo_add_log($message, 'error');

            wc_add_notice(esc_html__('Payment error: Please try again', 'linxo-woo'), 'error', array('id' => 'linxo-woo'));
            $redirect_url = add_query_arg(array('action' => 'failed'), wc_get_checkout_url());
            wp_safe_redirect($redirect_url);
            die();
        }

        $this->get_order_realtime_class->set_order_id($order_linxo_id);
        $realtime_response  = $this->get_order_realtime_class->get_order();

        if (!$realtime_response) {
            wc_add_notice(esc_html__('Payment error: Please try again', 'linxo-woo'), 'error', array('id' => 'linxo-woo'));
            $redirect_url = add_query_arg(array('action' => 'failed'), wc_get_checkout_url());
            wp_safe_redirect($redirect_url);
            die();
        }

        $order->update_meta_data(self::LINXO_WOO_ORDER_LINXO_ID, $order_linxo_id);
        $order->save();

        if (linxo_woo_get_option('advanced_alias_storage_enabled') === '1') {
            if (isset($realtime_response->payer->schema)) {
                $this->create_alias_class->set_user_reference($realtime_response->user_reference);
                $this->create_alias_class->set_schema($realtime_response->payer->schema ?? '');
                $this->create_alias_class->set_iban($realtime_response->payer->iban ?? '');
                $this->create_alias_class->add_alias();
            }
        }

        $this->wc_order_data_class->set_order_data($realtime_response);
        $order_status   = $this->wc_order_data_class->get_order_status();
        $order_data     = $this->wc_order_data_class->get_order_data();

        if ($order_status) {

            $current_status = 'wc-' . $order->get_status();

            if ($current_status != $order_status) {
                $order->update_status($order_status);
            }
        }

        $validate_order = $order_data->validate_order ?? false;

        if ($validate_order) {

            $message = sprintf(__CLASS__ . ':' . __FUNCTION__ . ': Redirect from payment succed for order(%1$s) with status(%2$s).', $wc_order_id, $order_status);
            linxo_woo_add_log($message);

            WC()->cart->empty_cart();
            wp_redirect($order->get_checkout_order_received_url());
            die();
        } else {

            $message = sprintf(__CLASS__ . ':' . __FUNCTION__ . ": Redirect from payment failed for order(%s) with status(%s).", $wc_order_id, $order_data->order_status);
            linxo_woo_add_log($message, 'error');

            $order->update_status('failed');

            wc_add_notice(esc_html__('Your payment has expired or been rejected. Please make a new payment.', 'linxo-woo'), 'error', array('id' => 'linxo-woo'));
            $redirect_url = add_query_arg(array('action' => 'failed'), wc_get_checkout_url());
            wp_safe_redirect($redirect_url);
            exit;
        }
    }

    /**
     * Notification
     */
    private function notification()
    {

        $resource_type = isset($_GET['resource_type']) ? sanitize_text_field($_GET['resource_type']) : '';
        $resource_id   = isset($_GET['resource_id']) ? sanitize_text_field($_GET['resource_id']) : '';

        if ($resource_type !== 'orders' || empty($resource_id)) {
            $message = sprintf(__CLASS__ . ':' . __FUNCTION__ . ': Notification failed due to resource_type(%1$s) or empty resource_id(%2$s).', $resource_type, $resource_id);
            linxo_woo_add_log($message, 'error');
            return;
        }

        $args = array(
            'status'            => 'any',
            'limit'             => 1,
            'return'            => 'ids',
            'meta_key'          => self::LINXO_WOO_ORDER_LINXO_ID,
            'meta_value'        => $resource_id,
            'meta_compare'      => '='
        );
        $orders_ids = wc_get_orders($args);

        if (empty($orders_ids) || !is_array($orders_ids)) {
            $message = sprintf(__CLASS__ . ':' . __FUNCTION__ . ': Notification failed due to no match with wc_order, orders(%1$s) resource_type(%2$s) resource_id(%3$s).', wp_json_encode($orders_ids), $resource_type, $resource_id);
            linxo_woo_add_log($message, 'error');
            return;
        }

        $order_id = $orders_ids[0];
        $order    = wc_get_order($order_id);

        if ($order->get_payment_method() != self::LINXO_WOO_PAYMENT_METHOD) {
            return;
        }

        if (!$order) {
            $message = sprintf(__CLASS__ . ':' . __FUNCTION__ . ': Notification failed due to wc_get_order(), order_id(%1$s) resource_type(%2$s) resource_id(%3$s).', $order_id, $resource_type, $resource_id);
            linxo_woo_add_log($message, 'error');
            return;
        }

        $this->get_order_realtime_class->set_order_id($resource_id);
        $realtime_response  = $this->get_order_realtime_class->get_order();

        if (!$realtime_response) {
            return;
        }

        $this->wc_order_data_class->set_order_data($realtime_response);
        $order_status   = $this->wc_order_data_class->get_order_status();

        if ($order_status) {

            $current_status = 'wc-' . $order->get_status();

            if ($current_status != $order_status) {
                $order->update_status($order_status);
            }

            $message = sprintf(__CLASS__ . ':' . __FUNCTION__ . ': Notification succed for order(%1$s) with status(%2$s).', $order_id, $order_status);
            linxo_woo_add_log($message);
        }
    }

    /**
     * Cancel order
     */
    private function cancel_order()
    {

        $linxo_order_id = isset($_GET['order_id']) ? sanitize_text_field($_GET['order_id']) : '';

        $this->put_order_closed_class->set_linxo_order_id($linxo_order_id);
        $response = $this->put_order_closed_class->cancel_order();

        if ($response) {
            $message = sprintf(__CLASS__ . ':' . __FUNCTION__ . ": Linxo order closed with id(%s).", $linxo_order_id);
            linxo_woo_add_log($message);
        }

        wp_safe_redirect(wc_get_checkout_url());
        exit;
    }
}
