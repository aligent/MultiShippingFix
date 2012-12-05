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

    private static $_inMultishippingfixCapture = false;

    public function capture($invoice) {
        // If this is a multishipping payment, then defer the capture until
        // the payment object has been cloned and added to the multishipping order.
        // Must do this, otherwise the capture occurs against the summary order
        // and the invoice is lost.
        if (self::$_inMultishippingfixCapture && !is_null($this->getParentOrderIncrementId()) && !is_null($invoice)) {
            // capture() called for a child payment
            $invoice->setIsPaid(true);
            $this->pay($invoice);
            return $this;
        } elseif (is_null($this->getParentOrderIncrementId())) {
            // capture() called for the summary payment
            return parent::capture($invoice);
        }
        return null;
    }

    public function multishippingfixCapture($invoice) {
        self::$_inMultishippingfixCapture = true;
        return parent::capture($invoice);
        self::$_inMultishippingfixCapture = false;
    }
}
