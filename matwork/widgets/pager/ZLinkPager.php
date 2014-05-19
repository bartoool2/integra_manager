<?php

class ZLinkPager extends CBasePager
{
	public $firstPageCssClass = 'first';

	public $lastPageCssClass = 'last';

	public $previousPageCssClass = 'previous';

	public $nextPageCssClass = 'next';

	public $internalPageCssClass = 'internal';

	public $hiddenPageCssClass = 'disabled';

	public $selectedPageCssClass = 'active';

	public $maxButtonCount = 10;
	
	public $nextPageLabel;

	public $prevPageLabel;

	public $firstPageLabel;

	public $lastPageLabel;
	
	public $showFirstLabel = false;
	
	public $showLastLabel = false;
	
	public $htmlOptions=array();
	
	public function init()
	{
		if ($this->nextPageLabel === null)
		{
			$this->nextPageLabel = Yii::t('matwork', 'Next');
		}
		
		if ($this->prevPageLabel === null)
		{
			$this->prevPageLabel=Yii::t('matwork', 'Previous');
		}
		
		if ($this->firstPageLabel === null)
		{
			$this->firstPageLabel = Yii::t('matwork', 'First');
		}
		
		if ($this->lastPageLabel === null)
		{
			$this->lastPageLabel = Yii::t('matwork', 'Last');
		}

		if (!isset($this->htmlOptions['class']))
		{
			$this->htmlOptions['class'] = 'pagination';
		}
	}
	
	public function run()
	{
		$buttons = $this->createPageButtons();
		
		if (!empty($buttons))
		{
			echo CHtml::tag('ul', $this->htmlOptions, implode("\n", $buttons));
		}
	}
	
	protected function createPageButtons()
	{
		if (($pageCount = $this->getPageCount()) <= 1)
		{
			return array();
		}

		list($beginPage, $endPage) = $this->getPageRange();
		
		$currentPage = $this->getCurrentPage(false);
		
		$buttons = array();

		if ($this->showFirstLabel)
		{
			$buttons[] = $this->createPageButton($this->firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
		}

		if (($page = $currentPage-1) < 0)
		{
			$page = 0;
		}
		$buttons[] = $this->createPageButton($this->prevPageLabel, $page, $this->previousPageCssClass, $currentPage <= 0, false);

		for($i = $beginPage; $i <= $endPage; ++$i)
		{
			$buttons[] = $this->createPageButton($i + 1, $i, $this->internalPageCssClass, false, $i == $currentPage);
		}

		
		if (($page = $currentPage + 1) >= $pageCount - 1)
		{
			$page = $pageCount - 1;
		}
		
		$buttons[] = $this->createPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);

		if ($this->showLastLabel)
		{
			$buttons[] = $this->createPageButton($this->lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
		}

		return $buttons;
	}
	
	protected function createPageButton($label, $page, $class, $hidden, $selected)
	{
		$class = null;
		
		if ($hidden || $selected)
		{
			$class .= ' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
		}
		
		return '<li class="'.$class.'">'.CHtml::link($label, $this->createPageUrl($page)).'</li>';
	}
	
	protected function getPageRange()
	{
		$currentPage = $this->getCurrentPage();
		
		$pageCount = $this->getPageCount();

		$beginPage = max(0, $currentPage - (int)($this->maxButtonCount/2));
		
		if (($endPage=$beginPage+$this->maxButtonCount-1) >= $pageCount)
		{
			$endPage = $pageCount - 1;
			$beginPage = max(0, $endPage - $this->maxButtonCount + 1);
		}
		return array($beginPage, $endPage);
	}
}