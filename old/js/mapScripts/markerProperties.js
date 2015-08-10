// SCRIPT APPLIES PROPERTIES AND AND MARKER ICONS

/*
 * 	Function applies custom properties to each marker 
 */
function createCustomProperties(type,obj)
{
	// check type of marker
	if('fault'==type)
	{
		objMsisdn=obj.faultMsisdn;
		objFaultType=obj.faultType;
		objId=obj.objId;
		objLatitude=obj.objLatitude;
		objLongitude=obj.objLongitude;
		objType=type;
	}
	
	if('bsc'==type || 'rnc'==type)
	{
		objId=obj.objId;
		objLatitude=obj.objLatitude;
		objLongitude=obj.objLongitude;
		objMSC=obj.controllerMSC;
		objType=type;
	}
	
	if('site'==type || 'siteOffAir'==type)
	{
		objId=obj.objId;
		objLatitude=obj.objLatitude;
		objLongitude=obj.objLongitude;
		objName=obj.siteName;
		objCounty=obj.county;
		objOnAir=obj.onAir;
		objController='BSC '+obj._bsc+' RNC '+obj._rnc;
		objDCSRating=obj.dcsRating;
		objGSMRating=obj.gsmRating;
		objUSMRating=obj.usmRating;
		objLTERating=obj.lteRating;
		objTXNRating=obj.txnRating;
		objMPRN=obj.mprn;
		
		if('siteOffAir'==type)
		{
			objWentOffAir=obj.wentOffAir;
			objBackOnAir=obj.backOnAir;
		}
		
		objClusterId=obj._clusterId;
		objFieldEngId=obj._fieldEngId;
		objFirstName=obj.firstName;
		objLastName=obj.lastName;
		objTeamRegion=obj.teamRegion;
		objHopsArray=obj.hopsArray;	
	}
}

/*
 * Function retrieves relevant icon for marker
 */
function getIcon(type,obj)
{
	if('bsc'==type)
	{
		if('1'==obj.objId)
		{
			imgIcon='img/bsc1_icon.png';
		}
		else if('2'==obj.objId)
		{
			imgIcon='img/bsc2_icon.png';
		}				
		else if('3'==obj.objId)
		{
			imgIcon='img/bsc3_icon.png';
		}
		else if('4'==obj.objId)
		{
			imgIcon='img/bsc4_icon.png';
		}
		else if('5'==obj.objId)
		{
			imgIcon='img/bsc5_icon.png';
		}
		else if('6'==obj.objId)
		{
			imgIcon='img/bsc6_icon.png';
		}				
		else if('7'==obj.objId)
		{
			imgIcon='img/bsc7_icon.png';
		}
		else if('8'==obj.objId)
		{
			imgIcon='img/bsc8_icon.png';
		}
		else if('9'==obj.objId)
		{
			imgIcon='img/bsc9_icon.png';
		}
		else if('10'==obj.objId)
		{
			imgIcon='img/bsc10_icon.png';
		}				
		else if('11'==obj.objId)
		{
			imgIcon='img/bsc11_icon.png';
		}
		else if('12'==obj.objId)
		{
			imgIcon='img/bsc12_icon.png';
		}
		else if('13'==obj.objId)
		{
			imgIcon='img/bsc13_icon.png';
		}
		else if('14'==obj.objId)
		{
			imgIcon='img/bsc14_icon.png';
		}				
		else if('15'==obj.objId)
		{
			imgIcon='img/bsc15_icon.png';
		}
		else if('16'==obj.objId)
		{
			imgIcon='img/bsc16_icon.png';
		}
		else if('17'==obj.objId)
		{
			imgIcon='img/bsc17_icon.png';
		}				
		else if('18'==obj.objId)
		{
			imgIcon='img/bsc18_icon.png';
		}
		else if('19'==obj.objId)
		{
			imgIcon='img/bsc19_icon.png';
		}
		else if('20'==obj.objId)
		{
			imgIcon='img/bsc20_icon.png';
		}
		else if('21'==obj.objId)
		{
			imgIcon='img/bsc21_icon.png';
		}				
		else if('22'==obj.objId)
		{
			imgIcon='img/bsc22_icon.png';
		}
		else if('23'==obj.objId)
		{
			imgIcon='img/bsc23_icon.png';
		}
		else if('24'==obj.objId)
		{
			imgIcon='img/bsc24_icon.png';
		}
		else if('25'==obj.objId)
		{
			imgIcon='img/bsc25_icon.png';
		}				
		else if('26'==obj.objId)
		{
			imgIcon='img/bsc26_icon.png';
		}
		else 
		{
			imgIcon='img/bsc_icon.png';
		}
	}
	else if('rnc'==type)
	{
		if('1'==obj.objId)
		{
			imgIcon='img/rnc1_icon.png';
		}
		else if('2'==obj.objId)
		{
			imgIcon='img/rnc2_icon.png';
		}
		else if('3'==obj.objId)
		{
			imgIcon='img/rnc3_icon.png';
		}
		else if('4'==obj.objId)
		{
			imgIcon='img/rnc4_icon.png';
		}
		else if('5'==obj.objId)
		{
			imgIcon='img/rnc5_icon.png';
		}
		else
		{
			imgIcon='img/rnc_icon.png';
		}
	}
	else if('fault'==type)
	{
		imgIcon='img/fault_icon.png';
	}
	else if('site'==type)
	{
		if('Yes'==obj.onAir)	
		{
			imgIcon='img/onAir_icon.png';
		}
		else if('No'==obj.onAir)
		{
			imgIcon='img/offAir_icon.png';
		}		
	}

	return imgIcon;
}
