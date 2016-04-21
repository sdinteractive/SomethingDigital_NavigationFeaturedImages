<?php
$installer = $this;
$installer->startSetup();

$this->addAttribute(Mage_Catalog_Model_Category::ENTITY, 'nav_featured_image', array(
    'type' => 'varchar',
    'backend' => 'catalog/category_attribute_backend_image',
    'label' => 'Navigation Featured Image',
    'input' => 'image',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => 1,
    'default' => '',
    'user_defined' => 1,
    'required' => 0,
    'sort_order' => 111,
    'group' => 'General Information'
));

$this->addAttribute(Mage_Catalog_Model_Category::ENTITY, 'nav_featured_link', array(
    'label' => 'Navigation Featured Link',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => 1,
    'default' => '',
    'user_defined' => 1,
    'required' => 0,
    'sort_order' => 112,
    'group' => 'General Information'
));

$this->addAttribute(Mage_Catalog_Model_Category::ENTITY, 'nav_featured_text', array(
    'label' => 'Navigation Featured Text',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => 1,
    'default' => '',
    'user_defined' => 1,
    'required' => 0,
    'sort_order' => 113,
    'group' => 'General Information'
));

//mark category flat tables as req. reindex
$process = Mage::getModel('index/indexer')->getProcessByCode('catalog_category_flat');
$process->changeStatus(Mage_Index_Model_Process::STATUS_REQUIRE_REINDEX);

$installer->endSetup();
