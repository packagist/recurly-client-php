<?php


class Recurly_PlanTest extends Recurly_TestCase
{
  function defaultResponses() {
    return array(
      array('GET', '/plans/silver', 'plans/show-200.xml'),
    );
  }

  public function testConstructor() {
    $client = new Recurly_Client;
    $plan = new Recurly_Plan(null, $client);

    $prop = new ReflectionProperty($plan, '_client');
    $prop->setAccessible(true);

    $this->assertSame($client, $prop->getValue($plan));
  }

  public function testGetPlan() {
    $plan = Recurly_Plan::get('silver', $this->client);

    $this->assertInstanceOf('Recurly_Plan', $plan);
    $this->assertInstanceOf('Recurly_Stub', $plan->add_ons);
    $this->assertEquals('https://api.recurly.com/v2/plans/silver/add_ons', $plan->add_ons->getHref());
    $this->assertEquals('silver', $plan->plan_code);
    $this->assertEquals(1303196400, $plan->created_at->getTimestamp());
    $this->assertEquals('https://api.recurly.com/v2/plans/silver', $plan->getHref());
    $this->assertEquals(15, $plan->trial_interval_length);
    $this->assertEquals('days', $plan->trial_interval_unit);
    $this->assertEquals(6, $plan->total_billing_cycles);
    $this->assertEquals("Setup Fee AC", $plan->setup_fee_accounting_code);
    $this->assertEquals(false, $plan->trial_requires_billing_info);

    $this->assertInstanceOf('Recurly_CurrencyList', $plan->unit_amount_in_cents);
    $this->assertEquals(1000, $plan->unit_amount_in_cents['USD']->amount_in_cents);
    $this->assertEquals(800, $plan->unit_amount_in_cents['EUR']->amount_in_cents);

    $this->assertInstanceOf('Recurly_CurrencyList', $plan->setup_fee_in_cents);
    $this->assertEquals(500, $plan->setup_fee_in_cents['USD']->amount_in_cents);
    $this->assertEquals(400, $plan->setup_fee_in_cents['EUR']->amount_in_cents);
    $this->assertTrue($plan->tax_exempt);
    $this->assertEquals('1234abcd', $plan->dunning_campaign_id);
  }

  public function testDeletePlan() {
    $this->client->addResponse('DELETE', '/plans/platinum', 'plans/destroy-204.xml');

    Recurly_Plan::deletePlan('platinum', $this->client);
  }

  public function testCreateXml() {
    $plan = new Recurly_Plan();
    $plan->plan_code = 'platinum';
    $plan->name = 'Platinum & Gold Plan';
    $plan->unit_amount_in_cents->addCurrency('USD', 1500);
    $plan->unit_amount_in_cents->addCurrency('EUR', 1200);
    $plan->setup_fee_in_cents->addCurrency('EUR', 500);
    $plan->trial_requires_billing_info = false;
    $plan->total_billing_cycles = 6;
    $plan->auto_renew = false;
    $plan->dunning_campaign_id = '1234abcd';

    $this->assertEquals(
      "<?xml version=\"1.0\"?>\n<plan><plan_code>platinum</plan_code><name>Platinum &amp; Gold Plan</name><unit_amount_in_cents><USD>1500</USD><EUR>1200</EUR></unit_amount_in_cents><setup_fee_in_cents><EUR>500</EUR></setup_fee_in_cents><total_billing_cycles>6</total_billing_cycles><trial_requires_billing_info>false</trial_requires_billing_info><auto_renew>false</auto_renew><dunning_campaign_id>1234abcd</dunning_campaign_id></plan>\n",
      $plan->xml()
    );
  }

  public function testUpdateXml() {
    $plan = Recurly_Plan::get('silver', $this->client);
    $plan->plan_code = 'platinum';
    $plan->name = 'Platinum Plan';
    $plan->unit_amount_in_cents->addCurrency('USD', 1500);
    $plan->unit_amount_in_cents->addCurrency('EUR', 1200);
    $plan->setup_fee_in_cents->addCurrency('EUR', 500);
    $plan->total_billing_cycles = NULL;
    $plan->tax_exempt = false;
    $plan->trial_requires_billing_info = false;
    $plan->tax_code = 'fake-tax-code';
    $plan->dunning_campaign_id = '1234abcd';

    $this->assertEquals(
      "<?xml version=\"1.0\"?>\n<plan><plan_code>platinum</plan_code><name>Platinum Plan</name><unit_amount_in_cents><USD>1500</USD><EUR>1200</EUR></unit_amount_in_cents><setup_fee_in_cents><USD>500</USD><EUR>500</EUR></setup_fee_in_cents><total_billing_cycles nil=\"nil\"></total_billing_cycles><tax_exempt>false</tax_exempt><tax_code>fake-tax-code</tax_code><trial_requires_billing_info>false</trial_requires_billing_info><dunning_campaign_id>1234abcd</dunning_campaign_id></plan>\n",
      $plan->xml()
    );
  }
}
