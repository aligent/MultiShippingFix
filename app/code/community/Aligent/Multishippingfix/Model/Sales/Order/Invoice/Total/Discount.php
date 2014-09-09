<?php

/**
 * Class Aligent_Multishippingfix_Model_Sales_Order_Invoice_Total_Discount
 * Adds fix for multishipping not adding discount to final payment capture
 */
class Aligent_Multishippingfix_Model_Sales_Order_Invoice_Total_Discount extends Mage_Sales_Model_Order_Invoice_Total_Discount {

    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
        parent::collect($invoice);

        /**
         * Check to see if an invoice has items, if not we can check for and add the discount amounts
         * from the order. This makes sure discounts from individual items are not missed out from the
         * summary orders created invoice.
         */

        if(!$invoice->getAllItems() && $invoice->getOrder()) {
            $totalDiscountAmount = abs($invoice->getOrder()->getDiscountAmount());
            $baseTotalDiscountAmount = abs($invoice->getOrder()->getBaseDiscountAmount());

            $invoice->setDiscountAmount($totalDiscountAmount);
            $invoice->setBaseDiscountAmount($baseTotalDiscountAmount);
            $invoice->setGrandTotal($invoice->getGrandTotal() - $totalDiscountAmount);
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() - $baseTotalDiscountAmount);
        }

        return $this;
    }
}