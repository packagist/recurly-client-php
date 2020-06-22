<?php

/**
 * class Recurly_BillingInfo
 * @property string $account_code Account's unique code.
 * @property-write  string $token_id A token generated by Recurly.js
 * @property string $currency Currency in which invoices will be posted. Only applicable if this account is enrolled in a plan has a different currency than your site's default.
 * @property string $first_name First name
 * @property string $last_name Last name
 * @property string $mandate_reference A specific ID used in a payment system to show that an agreement was made between the customer and the merchant.
 * @property string $number Credit card number, spaces and dashes are accepted
 * @property int $month Expiration month
 * @property int $year Expiration year
 * @property string $address1 Address line 1, recommended for address validation
 * @property string $address2 Address line 2.
 * @property string $city City
 * @property string $state State
 * @property string $country Country, 2-letter ISO code STRONGLY RECOMMENDED
 * @property string $zip Zip or postal code, recommended for address validation
 * @property string $phone Phone number
 * @property string $company Customer's company
 * @property string $vat_number Customer's VAT Number
 * @property string $verification_value Security code or CVV, 3-4 digits STRONGLY RECOMMENDED
 * @property string $ip_address Customer's IP address when updating their Billing Information STRONGLY RECOMMENDED
 * @property-read string $ip_address_country Country of IP address, if known by Recurly
 * @property string $external_hpp_type Used to indicate payment made out of band via an external service (e.g. Adyen HPP).
 * @property string $gateway_token The token generated by the payment gateway (Vantiv for example). When using this attribute you must set gateway_code. Also, billing_info.month will be the month of the token's expiration instead of the card's expiration month, and billing_info.year will be the year of the token's expiration instead of the card's expiration year.
 * @property string $gateway_code The identifier for the gateway to use. This code can be found on the payment gateways page in the admin UI.
 * @property int $account_number Bank account number between 4 and 17 digits.
 * @property int $routing_number Must be a real U.S. bank account routing number. All routing numbers are 9 digits.
 * @property string $name_on_account The name associated with the bank account. This may be a person's full name or a business name.
 * @property string $account_type Either 'checking' or 'savings'
 * @property string $amazon_billing_agreement_id Amazon's billing agreement
 * @property string $braintree_payment_nonce Braintree's payment method nonce representing the Paypal billing agreement id. This is required when processing Paypal transactions through Braintree.
 * @property string $roku_billing_agreement_id Roku's CIB if billing through Roku
 * @property string $transaction_type Indicates type of resulting transaction. accepted_values: "moto".
 * @property-read string $first_six Credit card number, first six digits
 * @property-read string $last_four Credit card number, last four digits
 * @property string $card_type Visa, MasterCard, American Express, Discover, JCB, etc
 * @property-write string $three_d_secure_action_result_token_id An id returned by Recurly.js referencing the result of the 3DS authentication for PSD2
 * @property string $iban International bank account number developed to identify an overseas bank account
 * @property string $type The payment method type for a non-credit card based billing info. The value of `bacs` is the only accepted value (Bacs only)
 * @property string $sort_code Bank identifier code for UK based banks. Required for Bacs based billing infos. (Bacs only)
 */
class Recurly_BillingInfo extends Recurly_Resource
{
  /**
   * @param string $accountCode The account code
   * @param Recurly_Client $client Optional client for the request, useful for mocking the client
   * @return Recurly_BillingInfo|null
   * @throws Recurly_Error
   */
  public static function get($accountCode, $client = null) {
    return Recurly_Base::_get(Recurly_BillingInfo::uriForBillingInfo($accountCode), $client);
  }

  public function create() {
    $this->update();
  }

  /**
   * @throws Recurly_Error
   */
  public function update() {
    $this->_save(Recurly_Client::PUT, $this->uri());
  }

  /**
   * @throws Recurly_Error
   */
  public function delete() {
    return Recurly_Base::_delete($this->uri(), $this->_client);
  }

  /**
   * @param string $accountCode The account code
   * @param Recurly_Client $client Optional client for the request, useful for mocking the client
   * @return object Recurly_Resource or null
   * @throws Recurly_Error
   */
  public static function deleteForAccount($accountCode, $client = null) {
    return Recurly_Base::_delete(Recurly_BillingInfo::uriForBillingInfo($accountCode), $client);
  }

  /**
   * @throws Recurly_Error
   */
  protected function uri() {
    if (!empty($this->_href))
      return $this->getHref();
    else if (!empty($this->account_code))
      return Recurly_BillingInfo::uriForBillingInfo($this->account_code);
    else
      throw new Recurly_Error("'account_code' not specified.");
  }
  protected static function uriForBillingInfo($accountCode) {
    return self::_safeUri(Recurly_Client::PATH_ACCOUNTS, $accountCode, Recurly_Client::PATH_BILLING_INFO);
  }

  protected function getNodeName() {
    return 'billing_info';
  }
  protected function getWriteableAttributes() {
    return array(
      'first_name', 'last_name', 'mandate_reference', 'name_on_account', 'company', 'ip_address',
      'address1', 'address2', 'city', 'state', 'country', 'zip', 'phone',
      'vat_number', 'number', 'month', 'year', 'verification_value',
      'account_number', 'routing_number', 'account_type',
      'paypal_billing_agreement_id', 'amazon_billing_agreement_id', 'currency',
      'token_id', 'external_hpp_type', 'gateway_token', 'gateway_code',
      'braintree_payment_nonce', 'roku_billing_agreement_id',
      'three_d_secure_action_result_token_id', 'transaction_type', 'iban', 'sort_code', 'type'
    );
  }
}
