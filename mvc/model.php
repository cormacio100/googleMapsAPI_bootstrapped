<?php
/**
 * Function retrieves array of on air sites
 */
function retrieveOnAirSites($selectCounty)
{
	$siteArr=array();
	
	# create a Database object
	$db = new Database;
	
	# create the query
	$query="SELECT s.*, fe.firstName,fe.lastName, fe.teamRegion "; 
	$query.="FROM site s ";
	$query.="INNER JOIN fieldEngTeam fe ";
	$query.="ON s._fieldEngId = fe.fieldEngId ";
	
	if('ALL'!==$selectCounty)
	{
		$query.=" WHERE s.county='".$selectCounty."'";
		$query.=" AND s.onAir='Yes'";
	}
	else 
	{
		$query.=" WHERE s.onAir='Yes'";
	}	
	
	$query.=" ORDER BY s.county DESC";
	
	# submit and execute the query
	$siteArr=$db->getMultiRecords($query);
	
	# retrieve recordSet Object and check if successful
	if(!$siteArr===TRUE)
	{
		exit;
		header('Location: ./messageAlert&messageId=3');
	}
	
	# for each record retrieved find the list of hops on the same link
	for($i=0;$i<sizeof($siteArr);$i++)
	{
		# create second query to find the sites on the same link
		$query2="SELECT siteId, latitude,longitude FROM site ";
		$query2.="WHERE siteId IN (";
		$query2.="SELECT DISTINCT b_siteId FROM sitecluster ";
		$query2.="WHERE clusterId='".$siteArr[$i]['_clusterId']."'";
		$query2.=" AND b_siteId='".$siteArr[$i]['siteId']."'"; 
		$query2.=" OR hop9='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop8='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop7='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop6='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop5='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop4='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop3='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop3='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop2='".$siteArr[$i]['siteId']."'";
		$query2.=" OR a_siteId='".$siteArr[$i]['siteId']."'"; 
		$query2.=")";
		
		# submit and execute the query
		$siteArr[$i]['hopsArray']=$db->getMultiRecords($query2);
	}
	
	# housekeeping - destroy the db object
	$db->closeDbConnection();
	unset($db);
	
	# return result
	return $siteArr;
	
}

/**
 * Function submits query to retrieve the sites that are off air on the network
 */
function retrieveOffAirSites()
{
	
	$siteArr=null;	
	
	# create a Database object
	$db=new Database();
	
	# create the query
	$query="SELECT s.*, fe.firstName,fe.lastName, fe.teamRegion ";
	$query.="FROM site s ";
	$query.="INNER JOIN fieldEngTeam fe ";
	$query.="ON s._fieldEngId = fe.fieldEngId ";
	$query.="WHERE onAir='No' ";
	$query.="ORDER BY siteId ";

	# submit the query	
	$siteArr=$db->getMultiRecords($query);
	
	# retrieve recordSet Object and check if successful
	if(!$siteArr===TRUE)
	{
		exit;
		header('Location: ./messageAlert&messageId=3');
	}
	
	# for each record retrieved find the list of hops on the same link
	for($i=0;$i<sizeof($siteArr);$i++)
	{
		# create second query to find the sites on the same link
		$query2="SELECT siteId, latitude,longitude FROM site ";
		$query2.="WHERE siteId IN (";
		$query2.="SELECT DISTINCT b_siteId FROM sitecluster ";
		$query2.="WHERE clusterId='".$siteArr[$i]['_clusterId']."'";
		$query2.=" AND b_siteId='".$siteArr[$i]['siteId']."'"; 
		$query2.=" OR hop9='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop8='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop7='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop6='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop5='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop4='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop3='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop3='".$siteArr[$i]['siteId']."'";
		$query2.=" OR hop2='".$siteArr[$i]['siteId']."'";
		$query2.=" OR a_siteId='".$siteArr[$i]['siteId']."'"; 
		$query2.=")";
		
		# submit and execute the query
		$siteArr[$i]['hopsArray']=$db->getMultiRecords($query2);
	}
	
	# housekeeping - remove reference to object
	$db->closeDbConnection();
	unset($db);
	
	# return the array
	return $siteArr;
}

/**
 * Function submits query to retrieve the controllers n the network
 */
function retrieveControllers()
{
	$recordSet=null;
	
	# create a Database object
	$db=new Database();
	
	# create first query
	$query='SELECT * FROM rnc ';
	
	# submit the query and record the result
	$recordSet['rnc']=$db->getMultiRecords($query);
	
	# retrieve recordSet Object and check if successful
	if(!$recordSet===TRUE)
	{
		exit;
		header('Location: ./messageAlert&messageId=3');
	}
	
	# second query
	$query2='SELECT * FROM bsc ';
	
	# submit the second query and record the result
	$recordSet['bsc']=$db->getMultiRecords($query2);
	
	# retrieve recordSet Object and check if successful
	if(!$recordSet===TRUE)
	{
		exit;
		header('Location: ./messageAlert&messageId=3');
	}
	
	# housekeeping - remove reference to object
	$db->closeDbConnection();
	unset($db);
	
	# return the array
	return $recordSet;
}

/**
 * Function checks for incidents raised against a particular email address
 */
function checkForFaultReports($email)
{
	$faultReportArr=array();
	
	# create the db object
	$db = new Database;
	
	# create the query
	$query="SELECT faultId FROM fault WHERE faultReportEmail='".$email."'";
	
	# submit the query fro execution. Expecting possibly mutliple results
	$faultReportArr = $db->getMultiRecords($query);
	
	# housekeeping - clear the reference to the Database object
	$db->closeDbConnection();
	unset($db);
	
	return $faultReportArr;
}

/**
 * Function retrieves fault report
 * 
 * @param $faultId - unique Identifier for fault
 * @return $faultReport - array containing contents of the fault report
 */
function getFaultReport($faultId)
{
	$faultReport=array();
	
	# create db object
	$db=new Database;
	
	# create the query
	$query="SELECT * FROM fault WHERE faultId='".$faultId."' LIMIT 1";
	
	# submit the query for execution. Expecting a single result
	$faultReport = $db->getSingleRecord($query);
	
	# housekeeping - clear the reference to the Database object
	$db->closeDbConnection();
	unset($db);
	
	return $faultReport;
}

/**
 * Function attemps to upload a fault report to the DB
 */
function createFaultReport($faultCounty,$faultAddress,$faultMsisdn,$faultType,$faultFrequency,$faultDateFrom,$faultDateTo,$faultLatitude,$faultLongitude,$faultDescription,$faultStatus,$faultUpdate,$faultReportEmail)
{

	# default administrator ID
	$_adminId=1;
	
	$resultArr=array();	# array to return result in
	
	$inserted=null;
	$newReportArr=array();
	
	# create the Database object
	$db=new Database;
	
	# create the query
	$query="INSERT INTO `googlemaps`.`fault` (`faultId`, `faultReportEmail`, `faultAddress`,`faultCounty`,  `faultMsisdn`, `faultType`, `faultFrequency`, `faultDescription`, `faultDateFrom`, `faultDateTo`, `faultLatitude`, `faultLongitude`, `faultStatus`, `faultUpdate`, `_adminId`) 
			VALUES (NULL,'".$faultReportEmail."','".$faultAddress."','".$faultCounty."','".$faultMsisdn."','".$faultType."','".$faultFrequency."','".$faultDescription."','".$faultDateFrom."','".$faultDateTo."','".$faultLatitude."','".$faultLongitude."','".$faultStatus."','".$faultUpdate."','".$_adminId."')";

	# submit and execute the query
	$inserted=$db->insertRecord($query);

	# check that record was created and then retrieve the new Fault Report ID
	if($inserted)
	{
		$query2="SELECT max(faultId) AS newFaultReportId FROM fault";
		
		# submit and execute the query
		$newReportArr=$db->getSingleRecord($query2);
		
		# check if an ID was returned and if so then add the boolean to it
		if(!empty($newReportArr))
		{
			# add the boolean to the result array
			$newReportArr['inserted']=$inserted;
		}
	}
	
	# housekeeping - destroy the db object
	$db->closeDbConnection();
	unset($db);
	
	# return result
	return $newReportArr;
}

/**
 * Function allows admin to update a fault report
 * 
 * @param $faultId, $faultStatus,$ faultUpdate
 * @return $updated - boolean value
 */
function updateFaultReport($faultId,$faultStatus,$faultUpdate)
{
	$updated=null;	
		
	# create the Database object
	$db = new Database;
	
	# create the query
	$query="UPDATE fault ";
	$query.=" SET faultStatus='".$faultStatus."',";
	$query.=" faultUpdate='".$faultUpdate."'";
	$query.=" WHERE faultId='".$faultId."'";

	# submit and execute the query
	$updated=$db->insertRecord($query);
	
	# housekeeping - destroy the db object
	$db->closeDbConnection();
	unset($db);
	
	# return result
	return $updated;
}

/**
 * Function searches for faults associated with an email address
 * 
 * @param $faultReportEmail - email address
 * @return $faultArr - array 
 */
function retrieveFaultLocationsByEmail($faultReportEmail,$queryType)
{
	$faultArr=array();
    $query=null;

	
	# create a Database object
	$db = new Database;

    # create the query depending on where request came from. If $queryType is 'idList' the default query is overwritten
    $query = "SELECT faultId,faultStatus,faultMsisdn,faultType,faultLatitude,faultLongitude FROM fault";

    if('idList'==$queryType)
    {
        $query = "SELECT faultId FROM fault";
    }

	$query.=" WHERE faultStatus='open'";
	
	if('ALL'!=$faultReportEmail)
	{
		$query.=" AND faultReportEmail='".$faultReportEmail."'";
	}

   // echo $query;

	# submit and execute the query
	$faultArr=$db->getMultiRecords($query);
	
	# housekeeping - destroy the db object
	$db->closeDbConnection();
	unset($db);
	
	# return result
	return $faultArr;
}


/**
 * Function checks user against the fieldEngteam table to see if authentic 
 * 
 * @param - $fieldEngId - ID for individual field engineer
 * @return - $valid - boolean value
 * 
 */
/*function isValidEngineer($fieldEngId)
{
	$validArr=array();
	
	# create a Database object
	$db = new Database;
	
	# create the query
	$query="SELECT * FROM fieldEngTeam WHERE fieldEngId='".$fieldEngId."'";

	# submit and execute the query
	$validArr=$db->getSingleRecord($query);
	
	# housekeeping - destroy the db object
	$db->closeDbConnection();
	unset($db);
	
	# return result
	return $validArr;
}*/

/**
 * Function checks user against the admin table to see if authentic 
 * 
 * @param - $adminUserName - ID for individual user
 * @param - $adminPassword - Password for individual user
 * @return - $valid - boolean value
 * 
 */
function isValid($adminUserName,$adminPassword)
{
	$validArr=array();
	
	# create a Database object
	$db = new Database;
	
	# create the query
	$query="SELECT * FROM fieldEngTeam ";
	$query.="WHERE fieldEngId='".$adminUserName."' ";
	$query.="AND password='".$adminPassword."' ";
	
	
	# submit and execute the query
	$validArr=$db->getSingleRecord($query);
	
	# housekeeping - destroy the db object
	$db->closeDbConnection();
	unset($db);
	
	# return result
	return $validArr;
}

/**
 * Function used to update admin passwords - Not accessible from front end
 */
function updatePassword($userName)
{
	$success=false;
	
	# create a Database object
	$db = new Database;
	
	# create the query, with encryption
	$query="UPDATE `fieldengteam`
			SET password = '".md5('password1')."'
			WHERE fieldEngId='".$userName."'";

	# submit and execute the query
	$success=$db->updateRecord($query);
	
	# housekeeping - destroy the db object
	$db->closeDbConnection();
	unset($db);
	
	# return result
	return $success;
	}

 
/**
 * function retrieves an array of all of the reported FAULTS or SITES that are open
 * 
 * @param $searchParam -  which table to search. Also used to build string for idType
 * @return $totalRecords - number of records for search
 */
 function getTotalRecordsNum($searchParam,$selectOption='ALL',$teamRegion='ALL')
 {
 	$totalRecordsNumArr=array();
	$totalRecords=0;
	
	# create parameter string
	$idType=$searchParam.'Id';
	
	# create a Database object
	$db = new Database;
	
	# create the query
	$query="SELECT COUNT(".$idType.") FROM ".$searchParam;

	# if calcualting total for sites admin page
	if('site'==$searchParam)
	{
       // echo '<br>searchParam is '.$searchParam;

       // echo '<br> selectOption is '.$selectOption;

      //  echo '<br> teamRegion is '.$teamRegion;

		# if a single county was chosen
		if('ALL'!==$selectOption)
        {

            /**
             * If searchParam is set to site and selectOption is not ALL
             * it is assumed that the selectOption is for county.
             * This would need further checks if extra options were a possibility.
             * Currently, it is not necessary
             */

			$query.=" WHERE county='".$selectOption."'";
		}
		else 
		{
			# if a particular region was chosen
			if('ALL'!=$teamRegion)
			{
				if('North Leinster'==$teamRegion)
				{
                   // echo '<br>Model: North Leinster';
					$query.=" WHERE county IN ('LH','MH','KE','WH','LD','CN','MN')";
				}
				if('South Leinster'==$teamRegion)
				{
                    //echo '<br>Model: South Leinster';

					$query.=" WHERE county IN ('WW','WX','LS','KK','CW','OY')";
				}
				if('South West'==$teamRegion)
				{
                   // echo '<br>Model: South West';

					$query.=" WHERE county IN ('TY','WD','CE','LK','CK','KY')";
				}
				if('North West'==$teamRegion)
				{
                    //echo '<br>Model: North West';

					$query.=" WHERE county IN ('LM','SO','RN','MO','GY','DL')";
				}
				if('Dublin'==$teamRegion)
				{
                    //echo '<br>Model: Dublin';
					$query.=" WHERE county IN ('DN')";
				}
			}			
		}

        //echo '<br>'.$query.'<br>';

		# submit and execute the query
		$totalRecordsNumArr=$db->getSingleRecord($query);
		
		$totalRecords=$totalRecordsNumArr['COUNT(siteId)'];
	}
	# if calculating total for fault admin page
	if('fault'==$searchParam)
	{
		if('North Leinster'==$teamRegion)
		{
			$query.=" WHERE faultCounty IN ('Louth','Meath','Kildare','WestMeath','Longford','Cavan','Monaghan')";
			$query.=" AND faultStatus='open'";
		}
		else if('South Leinster'==$teamRegion)
		{
			$query.=" WHERE faultCounty IN ('Wicklow','Wexford','Laois','Kilkenny','Carlow','Offaly')";
			$query.=" AND faultStatus='open'";
		}
		else if('South West'==$teamRegion)
		{
			$query.=" WHERE faultCounty IN ('Tipperary','Waterford','Clare','Limerick','Cork','Kerry')";
			$query.=" AND faultStatus='open'";
		}
		else if('North West'==$teamRegion)
		{
			$query.=" WHERE faultCounty IN ('Leitrim','Sligo','Roscommon','Mayo','Galway','Donegal')";
			$query.=" AND faultStatus='open'";
		}
		else if('Dublin'==$teamRegion)
		{
			$query.=" WHERE faultCounty='".$teamRegion."'";
			$query.=" AND faultStatus='open'";
		}
		else 
		{
			$query.=" WHERE faultStatus='open'";
		}

		# ADD TO QUERY IF A SELECTOPTION WAS INCLUDED
		if('ALL'!==$selectOption)
        {
            # check if the selectOption is an email address
            if(!filter_var($selectOption,FILTER_VALIDATE_EMAIL)===false)
            {
                $query.=" AND faultReportEmail='".$selectOption."'";
            }
        }

		# submit and execute the query
		$totalRecordsNumArr=$db->getSingleRecord($query);
		
		$totalRecords=$totalRecordsNumArr['COUNT(faultId)'];
	}

	# housekeeping - destroy the db object
	$db->closeDbConnection();
	unset($db);
	
	# return result
	return $totalRecords;
 }
 
 /**
 * function retrieves an array of all of the reported faults or sites that are open
 * 
 * @param $searchParam - site or fault
 * @return $recordsArr - array of records
 */
 function getPageRecords($searchParam,$startRecord=0,$recordsPerPage=0,$selectOption='ALL',$teamRegion)
 {
 	$recordsArr=array();
	
	# create a Database object
	$db = new Database;
	
	# create the query
	$query="SELECT * FROM ".$searchParam;
	
	# if search is performed by Site Page
	if('site'==$searchParam)
	{
		# check if search was narrowed down by county
		if('ALL'!==$selectOption)
		{
			$query.=" WHERE county='".$selectOption."'";
		}
		else
		{
			if('North Leinster'==$teamRegion)
			{
				$query.=" WHERE county IN ('LH','MH','KE','WH','LD','CN','MN')";
			}
			if('South Leinster'==$teamRegion)
			{
				$query.=" WHERE county IN ('WW','WX','LS','KK','CW','OY')";
			}
			if('South West'==$teamRegion)
			{
				$query.=" WHERE county IN ('TY','WD','CE','LK','CK','KY')";
			}
			if('North West'==$teamRegion)
			{
				$query.=" WHERE county IN ('LM','SO','RN','MO','GY','DL')";
			}
			if('Dublin'==$teamRegion)
			{
				$query.=" WHERE county IN ('DN')";
			}
		}	
	}
	else if('fault'==$searchParam)
	{
		if('North Leinster'==$teamRegion)
		{
			$query.=" WHERE faultCounty IN ('Louth','Meath','Kildare','WestMeath','Longford','Cavan','Monaghan')";
			$query.=" AND faultStatus='open'";
		}
		else if('South Leinster'==$teamRegion)
		{
			$query.=" WHERE faultCounty IN ('Wicklow','Wexford','Laois','Kilkenny','Carlow','Offaly')";
			$query.=" AND faultStatus='open'";
		}
		else if('South West'==$teamRegion)
		{
			$query.=" WHERE faultCounty IN ('Tipperary','Waterford','Clare','Limerick','Cork','Kerry')";
			$query.=" AND faultStatus='open'";
		}
		else if('North West'==$teamRegion)
		{
			$query.=" WHERE faultCounty IN ('Leitrim','Sligo','Roscommon','Mayo','Galway','Donegal')";
			$query.=" AND faultStatus='open'";
		}
		else if('Dublin'==$teamRegion)
		{
			$query.=" WHERE faultCounty IN ('Dublin')";
			$query.=" AND faultStatus='open'";
		}
		else
		{
			$query.=" WHERE faultStatus='open'";
		}
        # ADD TO QUERY IF A SELECTOPTION WAS INCLUDED
        if('ALL'!==$selectOption)
        {
            # check if the selectOption is an email address
            if(!filter_var($selectOption,FILTER_VALIDATE_EMAIL)===false)
            {
                $query.=" AND faultReportEmail='".$selectOption."'";
            }
        }

	}
		
	# pager Class adds limiters to page links. These are used to limit the range of records returned
	$query.=" LIMIT ".$startRecord.", ".$recordsPerPage;
	
	# submit and execute the query
	$recordsArr=$db->getMultiRecords($query);
	
	# housekeeping - destroy the db object
	$db->closeDbConnection();
	unset($db);
	
	# return result
	return $recordsArr;
 }
 
 /**
  * Update the site status and the other sites on the same link
  * 
  * Function builds a query that finds other sites on the same link in the same cluster
  * 
  * @param $siteId - the site 
  * @param $_clutserId - the cluster
  */
 function updateSiteCluster($siteId,$_clusterId,$onAir)
 {
 	$updateSuccessful=false;
	
 	# create the Databae Object
 	$db = new Database;
	
	# create the query to find other sites on the same link in the same site cluster
	$query="SELECT DISTINCT b_siteId FROM sitecluster ";
	$query.="WHERE clusterId='".$_clusterId."'";
	$query.=" AND a_siteId='".$siteId."'"; 
	$query.=" OR hop9='".$siteId."'";
	$query.=" OR hop8='".$siteId."'";
	$query.=" OR hop7='".$siteId."'";
	$query.=" OR hop6='".$siteId."'";
	$query.=" OR hop5='".$siteId."'";
	$query.=" OR hop4='".$siteId."'";
	$query.=" OR hop3='".$siteId."'";
	$query.=" OR hop3='".$siteId."'";
	$query.=" OR hop2='".$siteId."'";
	
	# submit and execute the query to return a list of sites
	$recordsArr=$db->getMultiRecords($query);
	
	# the initial siteId is not included in array so needs to be included now. Add it to end of array
	$recordsArr[]['b_siteId']=$siteId;

	# create a dateTime Format in case timestamps need to be used 
	$dateTimeFormat = 'Y-m-d H:i:s';
	
	# loop through array and update status of each site on the link
	for($i=0;$i<sizeOf($recordsArr);$i++)
	{
		# create the query
		$queryUpdate="UPDATE site SET onAir='".$onAir."'";
		
		# for timestamp
		$dateTimeObj = new DateTime();
		
		# if the site has gone off air create a timestamp for it
		if('No'==$onAir)
		{
			$queryUpdate.=", wentOffAir = '".$dateTimeObj->format($dateTimeFormat)."'";
		}
        else if('Yes'==$onAir)
		{
			$queryUpdate.=", backOnAir = '".$dateTimeObj->format($dateTimeFormat)."'";
		}
		
		$queryUpdate.=" WHERE siteId='".$recordsArr[$i]['b_siteId']."'";
		
		$updateSuccessful=$db->updateRecord($queryUpdate);
	}
	
	# housekeeping - destroy the db object
	$db->closeDbConnection();
	unset($db); 
	 
	# return whether the update was successful or not
	return $updateSuccessful;
 }

 
 