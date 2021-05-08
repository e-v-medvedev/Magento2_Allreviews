<?php

namespace Smartceo\Allreviews\Block;

class Allreviews extends \Magento\Framework\View\Element\Template {

  protected $_collectionFactory, $_request, $_objectManager;
  public $_imageHelperFactory;

  public function __construct(
  \Magento\Review\Model\ResourceModel\Review\CollectionFactory $collectionFactory,
  \Magento\Framework\App\Request\Http $request,
  \Magento\Framework\View\Element\Template\Context $context,
  array $data = [],
  \Magento\Store\Model\StoreManagerInterface $storeManager,
  \Magento\Catalog\Helper\ImageFactory $imageHelperFactory) {
	parent::__construct($context,
					 $data);
	$this->_collectionFactory	 = $collectionFactory;
	$this->_request				 = $request;
	$this->_storeManager		 = $storeManager;
	$this->_imageHelperFactory	 = $imageHelperFactory;
	$this->_objectManager		 = \Magento\Framework\App\ObjectManager::getInstance();
  }

  public function getRequest() {
	return $this->_request;
  }

  public function getObjectManager() {
	return $this->_objectManager;
  }

  /**
   * 
   * @return Intenso\Review\Model\ResourceModel\Review\Collection
   */
  public function getAllreviews() {
	//get values of current page. if not the param value then it will set to 1
	$page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;

	//get values of current limit. if not the param value then it will set to 10
	$pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 10;

	$_collection = $this->_collectionFactory->create();
	$_collection->setPageSize($pageSize);
	$_collection->setCurPage($page);

	$_collection->addStoreFilter($this->_storeManager->getStore()->getId())
		->addStatusFilter(\Magento\Review\Model\Review::STATUS_APPROVED)
		->setDateOrder();

	return $_collection;
  }

  protected function _prepareLayout() {
	parent::_prepareLayout();

	if ($this->getAllreviews()) {
	  $pager = $this->getLayout()->createBlock(
			  'Magento\Theme\Block\Html\Pager',
	 'allreviews.pager'
		  )->setAvailableLimit(array(10 => 10, 20 => 20, 30 => 30))->setShowPerPage(true)->setCollection(
		  $this->getAllreviews()
	  );
	  $this->setChild('pager',
				   $pager);
	  $this->getAllreviews()->load();
	}

	return $this;
  }

  public function getPagerHtml() {
	return $this->getChildHtml('pager');
  }

}
