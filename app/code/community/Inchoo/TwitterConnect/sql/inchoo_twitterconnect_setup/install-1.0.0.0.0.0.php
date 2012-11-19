<?php

$installer = $this;
$installer->startSetup();

$attributeCode = 'inchoo_twitterconnect_user';

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$entityTypeId     = $setup->getEntityTypeId('customer');
$attributeSetId   = $setup->getDefaultAttributeSetId($entityTypeId);
$attributeGroupId = $setup->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);

$setup->addAttribute('customer', $attributeCode, array(
    'input'         => 'text',
    'type'          => 'int',
    'label'         => 'Twitter User #ID',
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
));

$setup->addAttributeToGroup(
    $entityTypeId,
    $attributeSetId,
    $attributeGroupId,
    $attributeCode,
    '999'
);

$oAttribute = Mage::getSingleton('eav/config')->getAttribute('customer', $attributeCode);
$oAttribute->setData('used_in_forms', array('adminhtml_customer'));
$oAttribute->save();

$installer->endSetup();
