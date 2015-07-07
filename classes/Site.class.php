<?php

/**
 * Class for Mobile Site Objects
 */
 
Class Site extends DataObject
{
	public $siteName;
	public $county;
	public $onAir;
	public $_bsc;
	public $_rnc;
	public $dcsRating;
	public $gsmRating;
	public $usmRating;
	public $lteRating;
	public $txnRating;
	public $mprn;
	public $wentOffAir;
	public $backOnAir;
	public $_clusterId;
	public $_fieldEngId;
	public $firstName;
	public $lastName;
	public $teamRegion;
	public $hopsArray;
	
	# constructor function 
	public function __construct($siteId,$siteName,$county,$latitude,$longitude,$onAir,$_bsc,$_rnc,$dcsRating,$gsmRating,$usmRating,$lteRating,$txnRating,$mprn,$wentOffAir,	$backOnAir,	$_clusterId,$_fieldEngId,$firstName,$lastName,$teamRegion,$hopsArray)
	{
		# pass common values to parent class
		parent::__construct($siteId,$latitude,$longitude);	
		
		# populate values for class object
		$this->siteName=$siteName;
		$this->county=$county;
		$this->onAir=$onAir;
		$this->_bsc=$_bsc;
		$this->_rnc=$_rnc;
		$this->dcsRating=$dcsRating;
		$this->gsmRating=$gsmRating;
		$this->usmRating=$usmRating;
		$this->lteRating=$lteRating;
		$this->txnRating=$txnRating;
		$this->mprn=$mprn;
		$this->wentOffAir=$wentOffAir;
		$this->backOnAir=$backOnAir;
		$this->_clusterId=$_clusterId;
		$this->_fieldEngId=$_fieldEngId;
		$this->firstName=$firstName;
		$this->lastName=$lastName;
		$this->teamRegion=$teamRegion;
		$this->hopsArray=$hopsArray;
	}
	

}