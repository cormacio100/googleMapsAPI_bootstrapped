var teamRegion;
var searchParam='site';
var selectCounty='ALL';     /* DEFAULT VALUE */
var startRecord;
var recordsPerPage;
var pageNum;

/**
 * Function received JSON content and parses it
 *
 * JSON content displays site list in a table
 */
function displaySiteDataInATable(stringJSON,callingFunction)
{
    var messageArray=JSON.parse(stringJSON);
    var i;
    var htmlPaging=null;
    var htmlTable=null;

    console.log('callingFunction is ' + callingFunction);

    // retrieve DIV where the pagination links will display
    var paging = document.getElementById('paging');

    // retrieve DIV where the table will be built
    var adminSitesTableDiv = document.getElementById('adminSitesTableDiv');

    // check the type of object that needs to be created
    if ('displayAdminSites' == callingFunction)
    {
        // retrieve the pager links from the messageArray and clear it from the array
        var paginationObj = messageArray.pop();

        htmlPaging += '<nav class="col-sm-12">';
        htmlPaging += '<ul class="pagination pagination-sm" id="pagerLinks">';
        htmlPaging += paginationObj.outputHTML;
        htmlPaging+='</ul>';
        htmlPaging+='</nav>';

        // add the paging link to the paging DIV
        paging.innerHTML=htmlPaging;

        // build the table string
        htmlTable += '<table class="table table-hover">';

        // loop through the JSON array and create an site Object for each
        for (i=0; i < messageArray.length; i++)
        {
            var siteObj = messageArray[i];
            htmlTable+='<tr>';
            htmlTable+='<td>';
            htmlTable+='<form method="POST" action="./adminUpdateSite" >';
            htmlTable+='<input type="submit" name="updateSite" value="update" class="btn btn-primary btn-xs">';
            htmlTable+='&nbsp;';
            htmlTable+='<label> On Air =</label>';
            htmlTable+='&nbsp;';
            htmlTable+='<select class="onAir" name="onAir">';
            if('Yes'==siteObj.onAir)
            {
                htmlTable += '<option value="Yes" selected>Yes</option>';
                htmlTable += '<option value="No">No</option>';
            }
            else
            {
                htmlTable += '<option value="Yes">Yes</option>';
                htmlTable += '<option value="No" selected>No</option>';
            }
            htmlTable+='</select>';
            htmlTable+='&nbsp;';
            htmlTable+='<label>Site ID:<span class="detail">'+siteObj.objId+'</span></label>';
            htmlTable+='&nbsp;';
            htmlTable+='<label>County:<span class="detail">'+siteObj.county+'</span></label>';
            htmlTable+='&nbsp;';
            htmlTable+='<label>Site Name:<span class="detail">'+siteObj.siteName+'</span></label>';
            htmlTable+='&nbsp;';
            htmlTable+='<label>County:<span class="detail">'+siteObj._bsc+'</span></label>';
            htmlTable+='&nbsp;';
            htmlTable+='<label>RNC:<span class="detail">'+siteObj._rnc+'</span></label>';
            htmlTable+='&nbsp;';
            htmlTable+='<label>Cluster:<span class="detail">'+siteObj._clusterId+'</span></label>';
            htmlTable+='&nbsp;';
            htmlTable+='<input type="hidden" name="siteId" value="'+siteObj.objId+'" >';
            htmlTable+='<input type="hidden" name="_clusterId" value="'+siteObj._clusterId+'">';
            htmlTable+='</td>';
            htmlTable+='</tr>';
        }
        htmlTable+='</table>';
    }
    adminSitesTableDiv.innerHTML = htmlTable;

}


/**
 * Retrieve and display a list of sites
 */
function displayAdminSites()
{
   // declare a datasource
    var dataSource='./retrieveAdminSites&selectCounty='+selectCounty;

    var callingFunction='displayAdminSites';

   requestJSON(dataSource,callingFunction);
}

/**
 * Function is used by FUNCTION displayCounties() to add options to select Menu
 */
function addOptionToSelect(countyArr)
{
    var optionsArr=[];

    for(i=0;i<countyArr.length;i++)
    {
        var option = document.createElement('option');
        option.text = countyArr[i];
        option.value = countyArr[i];
        optionsArr.push(option);
    }
    return optionsArr;
}

/**
 * Function looks at team region and then populates the SELECT box with relevant counties for that region
 */
function displayCounties()
{
    var optionsArr=[];      // declare an empty array to hold options...that are to be added
    var countyArr=[];

    var selectCounty=document.getElementById('selectCounty');

    /* determine the counties for each region and create option menu elements for them */
    if('Dublin' == teamRegion)
    {
        countyArr=['DN'];

        optionsArr=addOptionToSelect(countyArr);
    }
    else if('North Leinster' == teamRegion)
    {
        countyArr=['LH','MH','KE','WH','LD','CN','MN'];

        optionsArr=addOptionToSelect(countyArr);
    }
    else if('South Leinster' == teamRegion)
    {
        countyArr=['WW','WX','LS','KK','CW','OY'];

        optionsArr=addOptionToSelect(countyArr);
    }
    else if('North West'==teamRegion)
    {
        countyArr=['LM','SO','RN','MO','GY','DL'];

        optionsArr=addOptionToSelect(countyArr);
    }
    else if('South West'==teamRegion)
    {
        countyArr=['TY','WD','CE','LK','CK','KY'];

        optionsArr=addOptionToSelect(countyArr);
    }
    else
    {
        countyArr=['DN','LH','MH','KE','WH','LD','CN','MN','WW','WX','LS','KK','CW','OY','TY','WD','CE','LK','CK','KY','LM','SO','RN','MO','GY','DL'];

        optionsArr=addOptionToSelect(countyArr);
    }

    /* add the options to the select menu */
    for(var i=0; i<optionsArr.length;i++)
    {
        selectCounty.add(optionsArr[i]);
    }
}

/**
 * When the page loads
 */
window.onload=function()
{
    console.log('page loading');

    teamRegion=document.getElementById('teamRegion').innerHTML;

    // display the relevant counties for teamRegion in SELECT MENU
    displayCounties();

    var refineSearchBtn=document.getElementById('refineSearch');

    // create a listener for the refineSearch button
    refineSearchBtn.onclick=function()
    {
        // retrieve the selected County
        selectCounty=document.getElementById('selectCounty').value;

        // display the selected county on screen
        document.getElementById('displaySelectedCounty').innerHTML=selectCounty;

        console.log('selectCounty is '+selectCounty);
        displayAdminSites();
    }

    console.log('selectCounty is '+selectCounty);

    // when this changes need to update the displayed Admin Sites
    // retrieve and display a list of Sites
    displayAdminSites();
}