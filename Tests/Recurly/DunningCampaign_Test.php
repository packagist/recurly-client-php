<?php
require 'lib/recurly/dunning_campaign.php';
require 'lib/recurly/dunning_cycle.php';


class Recurly_DunningCampaignTest extends Recurly_TestCase
{

  function defaultResponses() {
    return array(
      array('GET', '/dunning_campaigns/1234abcd', 'dunning_campaigns/show-200.xml'),
    );
  }

  public function testGetDunningCampaigns() {
    $dunning_campaign = Recurly_DunningCampaign::get('1234abcd', $this->client);

    $this->assertEquals($dunning_campaign->id, '1234abcd');
    $this->assertEquals($dunning_campaign->code, 'code');
  }
}
