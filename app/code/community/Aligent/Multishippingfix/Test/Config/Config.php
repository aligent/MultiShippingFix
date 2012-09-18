<?php

class Aligent_Multishippingfix_Test_Config_Config extends EcomDev_PHPUnit_Test_Case_Config {

    /**
     * Test classes are aliased correctly
     * 
     * @test
     */
    public function testClassAliases(){
        $this->assertModelAlias('multishippingfix/order_payment', 'Aligent_Multishippingfix_Model_Order_Payment');
        $this->assertModelAlias('multishippingfix/type_multishipping', 'Aligent_Multishippingfix_Model_Type_Multishipping');
    }
    
    public function testClassRewrites() {
        $this->assertModelAlias('checkout/type_multishipping', 'Aligent_Multishippingfix_Model_Type_Multishipping');
        $this->assertModelAlias('sales/order_payment', 'Aligent_Multishippingfix_Model_Order_Payment');
    }
    
}