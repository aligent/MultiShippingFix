<?php

$installer = $this;
$installer->startSetup();

$installer->addAttribute(
        'order_payment',
        'parent_order_increment_id',
        array(
            'type' => 'varchar',
            'grid' => false
        )
);

$installer->endSetup();
