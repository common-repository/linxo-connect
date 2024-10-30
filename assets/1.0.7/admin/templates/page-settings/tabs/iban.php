<?php
/**
 * The admin settings page iban tab
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="linxo-woo__tabs-content__tab">

    <form action="" method="post" class="linxo-woo__tabs-content__tab__form">

        <div class="linxo-woo__tabs-content__tab__form__header">
            <div class="linxo-woo__tabs-content__tab__form__header__title">
                <div class="linxo-woo__tabs-content__tab__form__header__title__icon"><?php echo linxo_woo_sanitize_svg(LINXO_WOO_PLUGIN_URL . 'public/assets/svg/cogs.svg' ); ?></div>
                <div class="linxo-woo__tabs-content__tab__form__header__title__text"><?php esc_html_e( 'Authorized accounts', 'linxo-woo'); ?></div>
            </div>
        </div>

        <div class="linxo-woo__tabs-content__tab__form__body">

            <div id="JS-LINXO-iban-accounts" class="linxo-woo__iban__accounts">

                <?php
                    $iban_active_account    = linxo_woo_get_default_alias();
                    $this->get_list_aliases_class->set_user_reference( sprintf('M-%s', md5(linxo_woo_get_client_id())));
                    $aliases_response   = $this->get_list_aliases_class->get_list();

                    if ( $aliases_response ) {

                        ?>
                            <div class="linxo-woo__iban__accounts__list">
            
                                <?php
                                    
                                    $aliases_list   = $aliases_response->aliases ?? array();
                                    $payer          = array();
                                    foreach ( $aliases_list as $alias_item ) {
                                        $payer[] = array(
                                            'schema'    => $alias_item->account->schema,
                                            'iban'      => $alias_item->account->iban,
                                        );
                                    }
                                    $this->get_list_providers_class->set_payer( $payer );
                                    $providers_response = $this->get_list_providers_class->get_providers();
                                    $providers          = $providers_response->result ?? array();
            
                                    foreach ( $aliases_list as &$item ) {

                                        if (!$providers) {
                                            $provider = new \stdClass();
                                            $provider->name = '-';
                                            $provider->logo = '';
                                            $item->provider = $provider;
                                        } else {
                                            foreach ($providers as $provider) {
                                                if ($provider->payer->iban !== $item->account->iban) {
                                                    continue;
                                                }
                                                $provider_obj = $provider->providers[0];
                                                $provider = new \stdClass();
                                                $provider->name = $provider_obj->name;
                                                $provider->logo = $provider_obj->logo_url;
                                                $item->provider = $provider;
                                            }
                                        }

                                        $authorize_account_list = $this->get_list_authorize_account_class->get_list();
                                        if ( !empty($authorize_account_list->_embedded) &&
                                            !empty($authorize_account_list->_embedded->authorized_account) ) {
                                            foreach ($authorize_account_list->_embedded->authorized_account as $authorize_account){
                                                if(empty($authorize_account->identification->iban)||
                                                    ($authorize_account->identification->iban != $item->account->iban)){
                                                    continue;
                                                }
                                                $item->service_level = $authorize_account->service_level;
                                                $item->idAuthorizeAccount = $authorize_account->id;
                                            }
                                        } else {
                                            $item->service_level = '';
                                        }
                                    }
            
                                    if ( !empty( $aliases_list ) ) {
            
                                        foreach ( $aliases_list as $alias_item ) {
            
                                            $iban = $alias_item->account->iban ?? '';
                                            if ( strlen($iban) > 8 ) {
                                                $iban = substr($iban, 0, 4) . str_repeat('X', strlen($iban) - 8) . substr($iban, -4);
                                            }
            
                                            ?>
                                                <div class="linxo-woo__iban__accounts__list__item">
                                                    <div class="linxo-woo__iban__accounts__list__item__header">
                                                        <div class="linxo-woo__iban__accounts__list__item__title"><?php echo esc_html($alias_item->label??''); ?></div>
                                                    </div>
                                                    
                                                    <?php if ( isset($alias_item->service_level) && $alias_item->service_level === 'NONE' ): ?>
                                                    <div class="linxo-woo__iban__accounts__list__item__error">
                                                        <div class="linxo-woo__iban__accounts__list__item__error__content">
                                                            <?php echo sprintf(/* translators: 1: link 2: tag html */ esc_html__('This account is blocked, please contact Linxo Connect %1$ssupport%2$s', 'linxo-woo'), '<a href="mailto:assistance@linxoconnect.com">', '</a>' ); ?>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>

                                                    <div class="linxo-woo__iban__accounts__list__item__body">
                                                        <div class="linxo-woo__iban__accounts__list__item__body__item">
                                                            <div class="linxo-woo__iban__accounts__list__item__body__item__title"><?php esc_html_e( 'Banking Institution', 'linxo-woo' ); ?></div>
                                                            <div class="linxo-woo__iban__accounts__list__item__body__item__value"><?php echo esc_html($alias_item->provider->name??''); ?></div>
                                                            <div class="linxo-woo__iban__accounts__list__item__body__item__img"><img src="<?php echo esc_attr($alias_item->provider->logo??''); ?>"></div>
                                                        </div>
                                                        <div class="linxo-woo__iban__accounts__list__item__body__item">
                                                            <div class="linxo-woo__iban__accounts__list__item__body__item__title"><?php esc_html_e( 'Scheme', 'linxo-woo' ); ?></div>
                                                            <div class="linxo-woo__iban__accounts__list__item__body__item__value"><?php echo esc_html($alias_item->account->schema??''); ?></div>
                                                        </div>
                                                        <div class="linxo-woo__iban__accounts__list__item__body__item">
                                                            <div class="linxo-woo__iban__accounts__list__item__body__item__title"><?php esc_html_e( 'IBAN', 'linxo-woo' ); ?></div>
                                                            <div class="linxo-woo__iban__accounts__list__item__body__item__value"><?php echo esc_html($iban); ?></div>
                                                        </div>
                                                        <div class="linxo-woo__iban__accounts__list__item__body__item">
                                                            <div class="linxo-woo__iban__accounts__list__item__body__item__title"><?php esc_html_e( 'Beneficiary reference', 'linxo-woo' ); ?></div>
                                                            <div class="linxo-woo__iban__accounts__list__item__body__item__value"><?php echo esc_html($alias_item->user_reference??''); ?></div>
                                                        </div>
                                                        <div>
                                                            <input type="hidden" name="linxo_woo_authorize_account_id" value="<?php echo esc_attr($alias_item->idAuthorizeAccount??'') ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="linxo-woo__iban__accounts__list__item__footer">
                                                        <button class="linxo-woo__iban__accounts__list__item__footer__delete button" type="submit" name="linxo_woo_iban_delete" value="<?php echo esc_attr($alias_item->id??'') ?>"><?php esc_html_e( 'Delete', 'linxo-woo' ); ?></button>
                                                        <?php if( isset($alias_item->id) && $alias_item->id === $iban_active_account ): ?>
                                                            <span class="linxo-woo__iban__accounts__list__item__footer__default-text" >
                                                                <span><?php echo linxo_woo_sanitize_svg( LINXO_WOO_PLUGIN_URL . 'public/assets/svg/check-mark.svg' ); ?></span>
                                                                <span><?php esc_html_e( 'Current beneficiary', 'linxo-woo') ?></span>
                                                            </span>
                                                        <?php else: ?>
                                                            <button class="linxo-woo__iban__accounts__list__item__footer__default-btn button" type="submit" name="linxo_woo_iban_default" value="<?php echo esc_attr($alias_item->id??'') ?>"><?php esc_html_e( 'Use as beneficiary', 'linxo-woo' ); ?></button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php
                                        }
            
                                    } else {
            
                                        ?>
                                            <div class="linxo-woo__iban__accounts__list__empty">
                                                <p><?php esc_html_e( 'No authorized accounts found.', 'linxo-woo') ?></p>
                                                <p><?php esc_html_e('Please add a first beneficiary account.', 'linxo-woo') ?></p>
                                            </div>
                                        <?php
            
                                    }
                                ?>
            
                            </div>
            
                            <div class="linxo-woo__iban__accounts__actions">
                                <button id="JS-LINXO-iban-add-new-btn" class="linxo-woo__iban__accounts__actions__add button button-primary" type="button"><?php esc_html_e( 'Add a beneficiary', 'linxo-woo' ); ?></button>
                            </div>
                        <?php

                    } else {

                        ?>
                            <div class="linxo-woo__iban__accounts__list__empty">
                                <p><?php esc_html_e( 'Please Add a valid Client ID and Client Secret.', 'linxo-woo') ?></p>
                            </div>
                        <?php
                    }
                ?>

            </div>

            <div id="JS-LINXO-iban-add-new" style="display: none;">

                <table class="linxo-woo__tabs-content__tab__form__body__table form-table">

                    <tr>
                        <th><?php esc_html_e( 'Select your type', 'linxo-woo' ); ?></th>
                        <td>
                            <label>
                                <input type="radio" id="JS-LINXO-iban-type-company" name="linxo_woo_iban_type" value="<?php echo esc_attr($iban_type_company) ?>" <?php checked( true ); ?>>
                                <?php esc_html_e( 'Company', 'linxo-woo' ); ?>
                            </label>
                            <br>
                            <label>
                                <input type="radio" id="JS-LINXO-iban-type-person" name="linxo_woo_iban_type" value="<?php echo esc_attr($iban_type_person) ?>">
                                <?php esc_html_e( 'Individual', 'linxo-woo' ); ?>
                            </label>
                        </td>
                    </tr>
    
                </table>
    
                <table id="JS-LINXO-iban-add-new-company" class="linxo-woo__tabs-content__tab__form__body__table form-table">
    
                    <tr>
                        <th><?php esc_html_e( "Company name", 'linxo-woo' ); ?></th>
                        <td>
                            <input type="text" name="linxo_woo_iban_company_name">
                        </td>
                    </tr>

                    <tr>
                        <th><?php esc_html_e( "SIREN or SIRET number", 'linxo-woo' ); ?></th>
                        <td>
                            <input type="text" name="linxo_woo_iban_company_national_identification">
                        </td>
                    </tr>

                    <tr>
                        <th><?php esc_html_e( "Country", 'linxo-woo' ); ?></th>
                        <td>
                            <select name="linxo_woo_iban_company_country">
                                <?php foreach ( $iban_countries as $country_key => $country_name ) : ?>
                                    <option value="<?php echo esc_attr($country_key) ?>" <?php selected($country_key, 'FR') ?> ><?php echo esc_html($country_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th><?php esc_html_e( "Name identifying account holder", 'linxo-woo' ); ?></th>
                        <td>
                            <input type="text" name="linxo_woo_iban_company_company_name">
                        </td>
                    </tr>

                    <tr>
                        <th><?php esc_html_e( "IBAN", 'linxo-woo' ); ?></th>
                        <td>
                            <input type="text" name="linxo_woo_iban_company_iban" class="JS-linxo-input-iban">
                        </td>
                    </tr>
    
                </table>
    
                <table id="JS-LINXO-iban-add-new-person" class="linxo-woo__tabs-content__tab__form__body__table form-table" style="display: none;">

                    <tr>
                        <th><?php esc_html_e( "First Name", 'linxo-woo' ); ?></th>
                        <td>
                            <input type="text" name="linxo_woo_iban_person_firstname">
                        </td>
                    </tr>
                    
                    <tr>
                        <th><?php esc_html_e( "Last Name", 'linxo-woo' ); ?></th>
                        <td>
                            <input type="text" name="linxo_woo_iban_person_surname">
                        </td>
                    </tr>

                    <tr>
                        <th><?php esc_html_e( "Date of birth", 'linxo-woo' ); ?></th>
                        <td>
                            <input type="date" name="linxo_woo_iban_person_birth_date">
                        </td>
                    </tr>

                    <tr>
                        <th><?php esc_html_e( "City of birth", 'linxo-woo' ); ?></th>
                        <td>
                            <input type="text" name="linxo_woo_iban_person_birth_city">
                        </td>
                    </tr>

                    <tr>
                        <th><?php esc_html_e( "Country", 'linxo-woo' ); ?></th>
                        <td>
                            <select name="linxo_woo_iban_person_birth_country">
                                <?php foreach ( $iban_countries as $country_key => $country_name ) : ?>
                                    <option value="<?php echo esc_attr($country_key) ?>" <?php selected($country_key, 'FR') ?> ><?php echo esc_html($country_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th><?php esc_html_e( "Name identifying account holder", 'linxo-woo' ); ?></th>
                        <td>
                            <input type="text" name="linxo_woo_iban_person_name">
                        </td>
                    </tr>

                    <tr>
                        <th><?php esc_html_e( "IBAN", 'linxo-woo' ); ?></th>
                        <td>
                            <input type="text" name="linxo_woo_iban_person_iban" class="JS-linxo-input-iban">
                        </td>
                    </tr>
    
                </table>

            </div>

        </div>
        
        <div id="JS-LINXO-iban-footer" class="linxo-woo__tabs-content__tab__form__footer" style="display: none;">
            <?php wp_nonce_field( 'linxo_woo_admin_custom_settings', '_linxo_woo_admin_nonce' ); ?>
            <button type="submit" class="linxo-woo__tabs-content__tab__form__footer__save button button-primary" name="linxo_woo_iban_submit"><?php esc_html_e( "Add", 'linxo-woo' ); ?></button>
        </div>

    </form>

</div>