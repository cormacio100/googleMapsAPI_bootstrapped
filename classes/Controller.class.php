<?php

/**
 * Class for Mobile Site Objects
 * 
 * Used when generating JSON output
 */
 
Class Controller extends DataObject
{
	public $controllerType;
	public $controllerMSC;

	# construtor function
		//Controller($controllerArr[$i]['controllerId'],$controllerArr[$i]['controllerType'],$controllerArr[$i]['controllerLatitude'],$controllerArr[$i]['controllerLongitude'],$controllerArr[$i]['controllerMSC']);
		
	public function __construct($controllerId,$controllerType,$controllerLatitude,$controllerLongitude,$controllerMSC)
	{
		# pass values to parent class
		parent::__construct($controllerId,$controllerLatitude,$controllerLongitude);	
			
		$this->controllerType=$controllerType;
		$this->controllerMSC=$controllerMSC;
	}

}