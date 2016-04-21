<?php

class SomethingDigital_NavigationFeaturedImages_Model_Observer extends Mage_Catalog_Model_Observer
{
    /**
     * Recursively adds categories to top menu
     *
     * @param Varien_Data_Tree_Node_Collection|array $categories
     * @param Varien_Data_Tree_Node $parentCategoryNode
     * @param Mage_Page_Block_Html_Topmenu $menuBlock
     * @param bool $addTags
     */
    protected function _addCategoriesToMenu($categories, $parentCategoryNode, $menuBlock, $addTags = false)
    {
        $categoryModel  = Mage::getModel('catalog/category');
        $categoryHelper = Mage::helper('catalog/category');
        $flatHelper     = Mage::helper('catalog/category_flat');

        foreach ($categories as $category) {
            if (!$category->getIsActive()) {
                continue;
            }

            $nodeId = 'category-node-' . $category->getId();

            $categoryModel->setId($category->getId());
            if ($addTags) {
                $menuBlock->addModelTags($categoryModel);
            }

            $tree = $parentCategoryNode->getTree();
            $categoryData = array(
                'name' => $category->getName(),
                'id' => $nodeId,
                'url' => $categoryHelper->getCategoryUrl($category),
                'is_active' => $this->_isActiveMenuCategory($category),
                'nav_featured_image' => $category->getNavFeaturedImage(),
                'nav_featured_link' => $category->getNavFeaturedLink(),
                'nav_featured_text' => $category->getNavFeaturedText()
            );
            $categoryNode = new Varien_Data_Tree_Node($categoryData, 'id', $tree, $parentCategoryNode);
            $parentCategoryNode->addChild($categoryNode);

            if ($flatHelper->isEnabled() && $flatHelper->isBuilt(true)) {
                $subcategories = (array)$category->getChildrenNodes();
            } else {
                $subcategories = $category->getChildren();
            }

            $this->_addCategoriesToMenu($subcategories, $categoryNode, $menuBlock, $addTags);
        }
    }


    /**
     * Add featured related attributes
     *
     * @param Varien_Event_Observer $observer
     * @return SomethingDigital_Catalog_Model_Observer
     */
    public function addFeaturedRelatedAttributes(Varien_Event_Observer $observer)
    {
        $select = $observer->getEvent()->getSelect();
        $select->columns(array('nav_featured_image', 'nav_featured_link', 'nav_featured_text'), 'main_table');
        return $this;
    }
}
