<?php

Class Pager
{
	private $totalRecords;					# the total number of records. Useed for calulating the number of pages
	private $recordsPerPage=null;				# limiter value
	private $searchParam=null;
	private $outputHTML=null;
    private $prevPageHTML=null;
    private $nextPageHTML=null;
	private $totalPages=null;
	private $lastPageCount=null;
	private $selectCounty=null;
	private $activePage=null;
	private $startRecordArr=null;           # array to reference starting record against page number
	private $url;
					
	public function __construct($totalRecords,$recordsPerPage,$searchParam,$url,$selectCounty,$activePage=1)
	{
		$this->totalRecords=$totalRecords;
		$this->recordsPerPage=$recordsPerPage;
		$this->searchParam=$searchParam;
		$this->selectCounty=$selectCounty;
		$this->activePage=$activePage;
        $this->url=$url;

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

        $this->outputHTML.='<ul class="nav nav-tabs">';

		# loop through pages and build the link for each
		for($pageNum=0;$pageNum<$this->totalPages;$pageNum++)
		{
		    # add the pageNum and corresponding startRecord to array to be use for creating prev and next link
		    $this->startRecordArr[$pageNum+1]=$startRecord;

			# create the link for the page
			$this->outputHTML.=$this->createLink($pageNum,$startRecord);
			
			#each iteration needs to increment the startRecord by the numbe rof records per page
			$startRecord+=$this->recordsPerPage;
		}

        $this->outputHTML.='<ul>';




        # create the previous and next page links
        //$this->prevPageHTML.=$this->createPrevPageLink($this->activePage);
        //$this->nextPageHTML.=$this->createNextPageLink($this->activePage);

        # append the three navigation link strings
        //$this->outputHTML=$this->prevPageHTML.$this->outputHTML.$this->nextPageHTML;

        return $this->outputHTML;
	}

    /**
     * Function creates a dynamic link for the LEFT "PREVIOUS PAGE" arrow in the Pager Nav Menu
     */
     private function createPrevPageLink($activePage)
    {
        # initialise variables
        $prevPage=1;
        $linkText=null;
        $startRecord=0;

        $prevPage=--$activePage;

        # There is no page 0 so need to disable in that case
        if(0==$prevPage)
        {
            $linkText=' <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        }
        else
        {
            $linkText = '<li><a href="';
            $linkText .= $this->url;
            $linkText .= '?searchParam='.$this->searchParam;
            $linkText .= '&amp;selectCounty='.$this->selectCounty;
            $linkText .= '&amp;startRecord='.$this->startRecordArr[$prevPage];
            $linkText .= '&amp;recordsPerPage='.$this->recordsPerPage;
            $linkText .= '&amp;pageNum='.$prevPage.'"';
            $linkText .= 'aria-label="Previous">';
            $linkText .= '<span aria-hidden="true">&laquo;</span>';
            $linkText .= '<span class="sr-only">'.$prevPage.'</span>';
            $linkText .= '</a></li> ';
        }
        return $linkText;
    }

    /**
     * Function creates a dynamic link for the RIGHT "NEXT PAGE" arrow in the Pager Nav Menu
     */
    private function createNextPageLink($activePage)
    {
        # initialise variables
        $nextPage=1;
        $linkText=null;
        $startRecord=0;

        $nextPage=++$activePage;

        # There is no page 0 so need to disable in that case
        if($this->totalPages+1==$nextPage)
        {
            $linkText=' <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&raquo;</span></a></li>';
        }
        else
        {
            $linkText = '<li><a href="';
            $linkText .= $this->url;
            $linkText .= '?searchParam='.$this->searchParam;
            $linkText .= '&amp;selectCounty='.$this->selectCounty;
            $linkText .= '&amp;startRecord='.$this->startRecordArr[$nextPage];
            $linkText .= '&amp;recordsPerPage='.$this->recordsPerPage;
            $linkText .= '&amp;pageNum='.$nextPage.'"';
            $linkText .= 'aria-label="Previous">';
            $linkText .= '<span aria-hidden="true">&raquo;</span>';
            $linkText .= '<span class="sr-only">'.$nextPage.'</span>';
            $linkText .= '</a></li> ';
        }
        return $linkText;
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

        if($this->activePage==$pageNum)
        {
            $linkText = '<li class="active">';
        }
        else
        {
            $linkText = '<li>';
        }
		$linkText.='<a href="';
		$linkText.=$this->url;
		$linkText.='?searchParam='.$this->searchParam;
		$linkText.='&amp;selectCounty='.$this->selectCounty;
		$linkText.='&amp;startRecord='.$startRecord;
		$linkText.='&amp;recordsPerPage='.$this->recordsPerPage;
        $linkText.='&amp;pageNum='.$pageNum;
        $linkText.='" target="#'.$pageNum.'">';
		$linkText.=$pageNum;
		$linkText.='<span class="sr-only">'.$pageNum.'</span>';
		$linkText.='</a></li> ';

		return $linkText;
	}
}
