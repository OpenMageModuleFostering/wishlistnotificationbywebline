<?php
$installer = $this;
$installer->startSetup();
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('product_price_logs')};
CREATE TABLE {$this->getTable('product_price_logs')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `product_entity_id` int(11) unsigned NOT NULL,
  `old_price` decimal(12,4) NOT NULL,
  `new_price` decimal(12,4) NOT NULL,
  `created_time` timestamp NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
$installer->endSetup();
