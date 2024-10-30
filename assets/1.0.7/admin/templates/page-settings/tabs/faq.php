<?php
/**
 * The admin settings page faq tab
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="linxo-woo__tabs-content__tab">

    <form action="" method="post" class="linxo-woo__tabs-content__tab__form">

        <div class="linxo-woo__tabs-content__tab__form__header">
            <div class="linxo-woo__tabs-content__tab__form__header__title">
                <div class="linxo-woo__tabs-content__tab__form__header__title__icon"><?php echo linxo_woo_sanitize_svg(LINXO_WOO_PLUGIN_URL . 'public/assets/svg/cogs.svg' ); ?></div>
                <div class="linxo-woo__tabs-content__tab__form__header__title__text"><?php esc_html_e( 'FAQ', 'linxo-woo'); ?></div>
            </div>
        </div>

        <div class="linxo-woo__tabs-content__tab__form__body">

            <div class="linxo-woo__tabs-content__tab__form__body__faq">

                <div class="linxo-woo__tabs-content__tab__form__body__faq__item">

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__header">
                        <h2 class="linxo-woo__tabs-content__tab__form__body__faq__item__header__title">
                            <span class="number">1</span>
                            <?php esc_html_e( "What is Linxo Connect Payments?", 'linxo-woo'); ?>
                        </h2>
                        <span class="linxo-woo__tabs-content__tab__form__body__faq__item__header__chevron"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-down.svg' ); ?></span>
                    </div>

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__body">
                        <div class="linxo-woo__tabs-content__tab__form__body__faq__item__answer">
                            <p class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__text">
                                <?php echo sprintf(/* translators: 1: link 2: tag html 3: link 4:tag html 5: link 6: tag html */ esc_html__( '%1$sLinxo Connect Payments%2$s solution is an \'automated bank transfer\' payment method. It is a payment method that e-commerce merchants can %3$sadd to their website\'s checkout page%4$s, to offer their customers an optimal and personalized payment experience (no need for customers to input IBAN or specify a label, and no impact on the credit card limit). The main benefits of %5$sLinxo Connect Payments%6$s are:', 'linxo-woo' ),
                                '<a href="https://linxoconnect.com/produits/payments/" target="_blank">', '</a>',
                                '<a href="https://linxoconnect.com/cas-usages/e-commerce/" target="_blank">', '</a>',
                                '<a href="https://linxoconnect.com/produits/payments/" target="_blank">', '</a>'); ?>
                            </p>
                            <ul class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__list">
                                <li><?php esc_html_e( "+30% to 40% increase in conversion rates", 'linxo-woo'); ?></li>
                                <li><?php esc_html_e( "Irrevocable transfer, funds received in less than 10 seconds", 'linxo-woo'); ?></li>
                                <li><?php esc_html_e( "0 bank commission rate", 'linxo-woo'); ?></li>
                                <li><?php esc_html_e( "Automatic and immediate back-office reconciliation with the transaction description.", 'linxo-woo'); ?></li>
                                <li><?php esc_html_e( "Easy payment process (no labels, amount, or IBAN to be entered by the customer)", 'linxo-woo'); ?></li>
                                <li><?php esc_html_e( "Secure payment (strong authentication from the payer's bank)", 'linxo-woo'); ?></li>
                            </ul>
                        </div>
                    </div>
                    
                </div>

                <div class="linxo-woo__tabs-content__tab__form__body__faq__item">

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__header">
                        <h2 class="linxo-woo__tabs-content__tab__form__body__faq__item__header__title">
                            <span class="number">2</span>
                            <?php esc_html_e( "How does Linxo Connect Payments work?", 'linxo-woo'); ?>
                        </h2>
                        <span class="linxo-woo__tabs-content__tab__form__body__faq__item__header__chevron"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-down.svg' ); ?></span>
                    </div>

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__body">
                        <div class="linxo-woo__tabs-content__tab__form__body__faq__item__answer">
                            <p class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__text">
                                <?php echo sprintf(/* translators: 1: link 2: tag html */ esc_html__( 'When a customer confirms their shopping cart and chooses to pay by bank transfer via %1$sLinxo Connect Payments%2$s :', 'linxo-woo' ),
                                '<a href="https://linxoconnect.com/produits/payments/" target="_blank">', '</a>'); ?>
                            </p>
                            <ol class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__list ol">
                                <li><?php esc_html_e( "He chooses \"Safe payment with Linxo Connect\" among the various payment options", 'linxo-woo'); ?></li>
                                <li><?php esc_html_e( "He is redirected to a secure interface to select his bank. Then, he will be automatically redirected to his banking portal to authenticate.", 'linxo-woo'); ?></li>
                                <li><?php esc_html_e( "Once authenticated with his bank, a summary of the transactions is displayed. He confirms it.", 'linxo-woo'); ?></li>
                                <li><?php esc_html_e( "The merchant receives an instant confirmation.", 'linxo-woo'); ?></li>
                            </ol>
                        </div>
                    </div>

                </div>

                <div class="linxo-woo__tabs-content__tab__form__body__faq__item">

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__header">
                        <h2 class="linxo-woo__tabs-content__tab__form__body__faq__item__header__title">
                            <span class="number">3</span>
                            <?php esc_html_e( "How soon can I expect to receive my payments?", 'linxo-woo'); ?>
                        </h2>
                        <span class="linxo-woo__tabs-content__tab__form__body__faq__item__header__chevron"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-down.svg' ); ?></span>
                    </div>

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__body">
                        <div class="linxo-woo__tabs-content__tab__form__body__faq__item__answer">
                            <p class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__text">
                                <?php esc_html_e( "Two possible scenarios :", 'linxo-woo' ); ?>
                            </p>
                            <ol class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__list">
                                <li><?php esc_html_e( "For \"standard\" bank transfer : Receipt of a SCT transfer is estimated to take between 1 to 2 business days (depending on the bank).", 'linxo-woo'); ?></li>
                                <li><?php esc_html_e( "For \"instant\" bank transfer : Funds received within 10 seconds. Please note that charges may apply depending on the bank's pricing policy.", 'linxo-woo'); ?></li>
                            </ol>
                        </div>
                    </div>

                </div>

                <div class="linxo-woo__tabs-content__tab__form__body__faq__item">

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__header">
                        <h2 class="linxo-woo__tabs-content__tab__form__body__faq__item__header__title">
                            <span class="number">4</span>
                            <?php esc_html_e( "Which versions of WordPress support the Linxo Connect Payments plugin?", 'linxo-woo'); ?>
                        </h2>
                        <span class="linxo-woo__tabs-content__tab__form__body__faq__item__header__chevron"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-down.svg' ); ?></span>
                    </div>

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__body">    
                        <div class="linxo-woo__tabs-content__tab__form__body__faq__item__answer">
                            <p class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__text">
                                <?php esc_html_e( "The plugin is compatible with WordPress versions 5.9 and above.", 'linxo-woo' ); ?>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="linxo-woo__tabs-content__tab__form__body__faq__item">

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__header">
                        <h2 class="linxo-woo__tabs-content__tab__form__body__faq__item__header__title">
                            <span class="number">5</span>
                            <?php esc_html_e( "Where can I find my sandbox and production ID and secret?", 'linxo-woo'); ?>
                        </h2>
                        <span class="linxo-woo__tabs-content__tab__form__body__faq__item__header__chevron"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-down.svg' ); ?></span>
                    </div>

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__body">    
                        <div class="linxo-woo__tabs-content__tab__form__body__faq__item__answer">
                            <p class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__text">
                                <?php echo sprintf(/* translators: 1: link 2: tag html */ esc_html__( 'To get your own Sandbox credentials, please contact Linxo Connect through the %1$scontact form%2$s Linxo Connect. Your Production credentials will then be provided to you by our technical teams.', 'linxo-woo' ),
                                '<a href="https://linxoconnect.com/contact/" target="_blank">', '</a>'); ?>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="linxo-woo__tabs-content__tab__form__body__faq__item">

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__header">
                        <h2 class="linxo-woo__tabs-content__tab__form__body__faq__item__header__title">
                            <span class="number">6</span>
                            <?php esc_html_e( "Can I test the functionality before the implementation in production ?", 'linxo-woo'); ?>
                        </h2>
                        <span class="linxo-woo__tabs-content__tab__form__body__faq__item__header__chevron"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-down.svg' ); ?></span>
                    </div>

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__body">    
                        <div class="linxo-woo__tabs-content__tab__form__body__faq__item__answer">
                            <p class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__text">
                                <?php esc_html_e( "It is possible to test Linxo Connect Payments. To do so, simply use your credentials in Sandbox mode. These credentials should be entered in: My Account > 'Sandbox' mode. This will allow you to test the payment solution without using your actual banking data.", 'linxo-woo' ); ?>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="linxo-woo__tabs-content__tab__form__body__faq__item">

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__header">
                        <h2 class="linxo-woo__tabs-content__tab__form__body__faq__item__header__title">
                            <span class="number">7</span>
                            <?php esc_html_e( "How to switch to production mode?", 'linxo-woo'); ?>
                        </h2>
                        <span class="linxo-woo__tabs-content__tab__form__body__faq__item__header__chevron"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-down.svg' ); ?></span>
                    </div>

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__body">    
                        <div class="linxo-woo__tabs-content__tab__form__body__faq__item__answer">
                            <p class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__text">
                                <?php esc_html_e( "To do so, all you need are your credentials in Production mode. These credentials should be entered in: My Account > 'Production' mode.", 'linxo-woo' ); ?>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="linxo-woo__tabs-content__tab__form__body__faq__item">

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__header">
                        <h2 class="linxo-woo__tabs-content__tab__form__body__faq__item__header__title">
                            <span class="number">8</span>
                            <?php esc_html_e( "Are there additional fees applied to my customers when they make a payment via bank transfer?", 'linxo-woo'); ?>
                        </h2>
                        <span class="linxo-woo__tabs-content__tab__form__body__faq__item__header__chevron"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-down.svg' ); ?></span>
                    </div>

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__body">    
                        <div class="linxo-woo__tabs-content__tab__form__body__faq__item__answer">
                            <p class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__text">
                                <?php esc_html_e( "The traditional bank transfer payment offered by Linxo Connect is completely free for the customer. In the case of an instant transfer, fees may apply (up to €1). These fees vary according to the pricing policy of the banking institutions. Those banking institutions are obligated to inform the customer. The customer's explicit and informed consent must be obtained before the payment is finalized.", 'linxo-woo' ); ?>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="linxo-woo__tabs-content__tab__form__body__faq__item">

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__header">
                        <h2 class="linxo-woo__tabs-content__tab__form__body__faq__item__header__title">
                            <span class="number">9</span>
                            <?php esc_html_e( "How can I track payments made through Linxo Connect Payments?", 'linxo-woo'); ?>
                        </h2>
                        <span class="linxo-woo__tabs-content__tab__form__body__faq__item__header__chevron"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-down.svg' ); ?></span>
                    </div>

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__body">    
                        <div class="linxo-woo__tabs-content__tab__form__body__faq__item__answer">
                            <p class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__text">
                                <?php esc_html_e( "Payment tracking is available directly in the WooCommerce dashboard. The WooCommerce plugin will provide you with information regarding the status and state of your payment. Order reconciliation is automatic.", 'linxo-woo' ); ?>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="linxo-woo__tabs-content__tab__form__body__faq__item">

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__header">
                        <h2 class="linxo-woo__tabs-content__tab__form__body__faq__item__header__title">
                            <span class="number">10</span>
                            <?php esc_html_e( "What will the payment button look like on the payment page?", 'linxo-woo'); ?>
                        </h2>
                        <span class="linxo-woo__tabs-content__tab__form__body__faq__item__header__chevron"><?php echo linxo_woo_sanitize_svg(LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-down.svg' ); ?></span>
                    </div>

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__body">    
                        <div class="linxo-woo__tabs-content__tab__form__body__faq__item__answer">
                            <p class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__text">
                                <?php esc_html_e( "The Linxo Connect Payments \"button\" will be automatically added to the list of other payment methods offered on your payment page, labeled as \"Secured payment with Linxo Connect\" with a Linxo Connect logo. By choosing this payment method, your customer will follow the payment process as explained in question 2 and will be automatically redirected to your e-commerce site after payment validation.", 'linxo-woo' ); ?>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="linxo-woo__tabs-content__tab__form__body__faq__item">

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__header">
                        <h2 class="linxo-woo__tabs-content__tab__form__body__faq__item__header__title">
                            <span class="number">11</span>
                            <?php esc_html_e( "If the customer encounters a transaction refusal, for example, due to an exceeded transfer limit, what message/information will be displayed for the merchant and what message will be displayed for the customer?", 'linxo-woo'); ?>
                        </h2>
                        <span class="linxo-woo__tabs-content__tab__form__body__faq__item__header__chevron"><?php echo linxo_woo_sanitize_svg(LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-down.svg' ); ?></span>
                    </div>
                    
                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__body">    
                        <div class="linxo-woo__tabs-content__tab__form__body__faq__item__answer">
                            <p class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__text">
                                <?php esc_html_e( "When the merchant initiates a payment order, he is then informed of the payment status. (\"Executed\" , \"Rejected\" or \"Cancelled\"). The final customer (the payer) is informed by email of the transaction's execution.", 'linxo-woo' ); ?>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="linxo-woo__tabs-content__tab__form__body__faq__item">

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__header">
                        <h2 class="linxo-woo__tabs-content__tab__form__body__faq__item__header__title">
                            <span class="number">12</span>
                            <?php esc_html_e( "How long are the data saved in Sandbox mode?", 'linxo-woo'); ?>
                        </h2>
                        <span class="linxo-woo__tabs-content__tab__form__body__faq__item__header__chevron"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-down.svg' ); ?></span>
                    </div>

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__body">    
                        <div class="linxo-woo__tabs-content__tab__form__body__faq__item__answer">
                            <p class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__text">
                                <?php esc_html_e( "In Sandbox mode, data is cleared every 3 months.", 'linxo-woo' ); ?>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="linxo-woo__tabs-content__tab__form__body__faq__item">

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__header">
                        <h2 class="linxo-woo__tabs-content__tab__form__body__faq__item__header__title">
                            <span class="number">13</span>
                            <?php esc_html_e( "I have a \"blocked account\" warning. What should I do?", 'linxo-woo'); ?>
                        </h2>
                        <span class="linxo-woo__tabs-content__tab__form__body__faq__item__header__chevron"><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/chevron-down.svg' ); ?></span>
                    </div>

                    <div class="linxo-woo__tabs-content__tab__form__body__faq__item__body">    
                        <div class="linxo-woo__tabs-content__tab__form__body__faq__item__answer">
                            <p class="linxo-woo__tabs-content__tab__form__body__faq__item__answer__text">
                                <?php echo sprintf(/* translators: 1: link 2: tag html */ esc_html__( 'A \'blocked account\' warning in your IBAN may indicate that supporting documents are missing from your file. Please contact %1$ssupport%2$s Linxo Connect.', 'linxo-woo' ),
                                '<a href="'.esc_url($header_contact_support).'" target="_blank">', '</a>'); ?>
                            </p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </form>

</div>