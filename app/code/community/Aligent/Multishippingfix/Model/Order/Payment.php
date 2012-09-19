<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Payment
 *
 * @author luke
 */
class Aligent_Multishippingfix_Model_Order_Payment extends Mage_Sales_Model_Order_Payment {

    public function place() {
        return parent::place();
    }
    
}

?>
