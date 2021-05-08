<?php

namespace Smartceo\Allreviews\Plugin\Review\Block\Product;

class Review extends \Intenso\Review\Block\Product\Review {

  public function setTabTitle() {

	$_commentCount	 = $this->getCollectionSize();
	
	$last			 = substr(strval($_commentCount), -1);

	if ($last == '1') {
	  $commentLabel = "Отзыв";
	} else if (in_array($last, array("2", "3", "4"))) {
	  $commentLabel = "Отзыва";
	} else if (in_array($last, array("5", "6", "7", "8", "9"))) {
	  $commentLabel = "Отзывов";
	}


	$title = $this->getCollectionSize() ? __('%1  ' . $commentLabel,
										  '<span class="counter">' . $this->getCollectionSize() . '</span>') : __('Отзывы');
	$this->setTitle($title);
  }

}
