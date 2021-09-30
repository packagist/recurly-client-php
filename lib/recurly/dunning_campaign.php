<?php

/**
 * Class Recurly_DunningCampaign
 * @property string $name The name of the Dunning Campaign.
 * @property string $code The unique dunning campaign identifier code. Only numbers, lowercase letters, dashes, pluses, and underscores can be used.
 * @property string $description An internal description to identify a dunning campaign.
 * @property boolean $default True if this will be your default Dunning Campaign.
 * @property array $dunning_cycles An array of Recurly_DunningCycle hashes.
 * @property DateTime $created_at When the Dunning Campaign was created.
 * @property DateTime $updated_at When the Dunning Campaign was last updated.
 * @property DateTime $deleted_at If the Dunning Campaign was deleted, this field will show the time at which that event occurred.
 */
class Recurly_DunningCampaign extends Recurly_Resource
{
  protected function getNodeName() {
    return 'dunning_campaign';
  }
  protected function getWriteableAttributes() {
    return array(
      'name', 'code', 'description', 'default',
      'dunning_cycles', 'created_at', 'updated_at', 'deleted_at'
    );
  }

  public function bulkUpdate($planCodes = []) {
    $this->_save(Recurly_Client::PUT, $this->uri() . '/bulk_update', $planCodes);
  }
}
