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

    public function capture($invoice) {
        // If this is a multishipping payment, then defer the capture until
        // the payment object has been cloned and added to the multishipping order.
        // Must do this, otherwise the capture occurs against the summary order
        // and the invoice is lost.
        if (is_null($this->getParentOrderIncrementId())) {
            return parent::capture($invoice);
        }
        return null;
    }
    
    public function multishippingfixCapture($invoice) {
        return parent::capture($invoice);
    }
    
}

?>
