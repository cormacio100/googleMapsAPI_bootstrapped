<?php

Class Pager
{
	private $totalRecords;					# the total number of records. Useed for calulating the number of pages
	private $recordsPerPage=null;				# limiter value
	private $searchParam=null;
	private $outputHTML=null;
	private $totalPages=null;
	private $lastPageCount=null;
	private $selectCounty=null;
	private $url;
					
	public function __construct($totalRecords,$recordsPerPage,$searchParam,$url,$selectCounty)
	{
		$this->totalRecords=$totalRecords;
		$this->recordsPerPage=$recordsPerPage;
		$this->searchParam=$searchParam;
		$this->url=$url;
		$this->selectCounty=$selectCounty;
		
		# calculate the number of pages
		$this->calcNumPages();
		
		#calculate the number of records to display on the last Page
		$this->calcLastPageCount();
	
	}
	
	/**
	 * Function calculates the number of pages required
	 */
	private function calcNumPages()
	{
		$this->totalPages=ceil($this->totalRecords/$this->recordsPerPage);
	}
	
	/**
	 * Function calculates the number of records to display on the last page
	 */
	private function calcLastPageCount()
	{
		$this->lastPageCount=$this->totalRecords%$this->recordsPerPage;
	}	
	
	/**
	 * Function creates loops through the pages and sends flow to function to create aPager Link for each one and appends to a string
	 * 
	 * @return $this->outputHTML - String containing HTML links for each page
	 */
	public function getOutputHTML()
	{
		$startRecord=0;		# for the first page	
		
		# loop through pages and build the link for each
		for($pageNum=0;$pageNum<$this->totalPages;$pageNum++)
		{
			# create the link for the page
			$this->outputHTML.=$this->createLink($pageNum,$startRecord);
			
			#each iteration needs to increment the startRecord by the numbe rof records per page
			$startRecord+=$this->recordsPerPage;
		}
		
		return $this->outputHTML;
	}
	
	/**
	 * Function creates a link for each individual page
	 * 
	 * @return $linkText - html links
	 */
	private function createLink($pageNum,$startRecord)
	{
		# want to display page 1 instead of page 0
		$pageNum=$pageNum+1;

		$linkText='<a href="';
		$linkText.=$this->url;
		$linkText.='?searchParam='.$this->searchParam;
		$linkText.='&amp;selectCounty='.$this->selectCounty;
		$linkText.='&amp;startRecord='.$startRecord;
		$linkText.='&amp;recordsPerPage='.$this->recordsPerPage.'">';
		$linkText.=$pageNum.'</a> | ';

		return $linkText;
	}
}
