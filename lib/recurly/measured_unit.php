<?php

/**
 * Class Recurly_MeasuredUnit
 * @property int $id The unique identifier of the account.
 * @property string $name Unique internal name of the measured unit on your site.
 * @property string $display_name Display name for the measured unit. We recommend the singular version. (e.g. - GB, API Call, Email).
 * @property string $description Optional internal description.
 */
class Recurly_MeasuredUnit extends Recurly_Resource
{
  public function create() {
    $this->_save(Recurly_Client::POST, Recurly_Client::PATH_MEASURED_UNITS);
  }

  /**
   * @param $id
   * @param Recurly_Client $client Optional client for the request, useful for mocking the client
   * @return object
   * @throws Recurly_Error
   */
  public static function get($id, $client = null) {
    return Recurly_Base::_get(Recurly_MeasuredUnit::uriForMeasuredUnit($id), $client);
  }

  public function delete() {
    return Recurly_Base::_delete($this->uri(), $this->_client);
  }

  protected function uri() {
    if (!empty($this->_href))
      return $this->getHref();
    else
      return Recurly_MeasuredUnit::uriForMeasuredUnit($this->id);
  }
  protected static function uriForMeasuredUnit($id) {
    return self::_safeUri(Recurly_Client::PATH_MEASURED_UNITS, $id);
  }

  protected function getNodeName() {
    return 'measured_unit';
  }
  protected function getWriteableAttributes() {
    return array(
      'name', 'display_name', 'description'
    );
  }
}
