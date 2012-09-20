<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Order
 *
 * @author luke
 */
class Aligent_Multishippingfix_Model_Order extends Mage_Sales_Model_Order {

    public function getIncrementId() {

        $trace = debug_backtrace();
        if (isset($trace[1])
                && isset($trace[1]['object'])
                && $trace[1]['object'] instanceof Mage_Payment_Model_Method_Abstract) {

            $foo = true;
        }
        return parent::getIncrementId();
    }

}

?>
