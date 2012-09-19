<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Multishipping
 *
 * @author luke
 */
class Aligent_Multishippingfix_Model_Type_Multishipping extends Mage_Checkout_Model_Type_Multishipping {

    // See Jim's Skype re: unit test for configs.
    
    public function createOrders() {
        return parent::createOrders();
    }
    
    public function _prepareOrder(Mage_Sales_Model_Quote_Address $address) {
        return parent::_prepareOrder($address);
    }
    
}

?>
