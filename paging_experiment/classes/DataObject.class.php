<?php

/**
 * Class used to build JSON Output for updating Client
 */

class DataObject 
{
	public $objId;
	public $objLatitude;
	public $objLongitude;
	
	public function __construct($id,$latitude,$longitude)
	{
		$this->objId=$id;
		$this->objLatitude=$latitude;
		$this->objLongitude=$longitude;
	}
}