<?php
/**
 * Class represents reported faults. Used for generating JSON Output
 */
 
Class ReportedFault extends DataObject
{
	public $faultMsisdn;		// the mobile phone number
	public $faultType;
	
	# construtor function
	public function __construct($faultId,$faultMsisdn,$faultType,$faultLatitude,$faultLongitude)
	{
		# pass common values to parent class
		parent::__construct($faultId,$faultLatitude,$faultLongitude);	
		
		$this->faultMsisdn=$faultMsisdn;
		$this->faultType=$faultType;
			
	}
}
