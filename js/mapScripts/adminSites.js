var teamRegion;
var searchParam;
var selectCounty;
var startRecord;
var recordsPerPage;
var pageNum;


/**
 * Function received JSON content and parses it
 */
function displaySiteDataInATable(stringJSON,callingFunction)
{
    var messageArray = JSON.parse(stringJSON);
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
        var paginationObj=messageArray.pop();

        htmlPaging+='<nav class="col-sm-12">';
        htmlPaging+='<ul class="pagination pagination-sm" id="pagerLinks">';
        htmlPaging+=paginationObj.outputHTML;
        htmlPaging+='</ul>';
        htmlPaging+='</nav>';

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
function displayAdminSites2(selectCounty,startRecord,recordsPerPage,pageNum)
{
    // declare a datasource
    var dataSource='./retrieveAdminSites&selectCounty='+selectCounty+'&startRecord='+startRecord+'&recordsPerPage='+recordsPerPage+'&pagenum='+pageNum;

    var callingFunction='displayAdminSites';

    requestJSON(dataSource,callingFunction);
}


/**
 * Retrieve and display a list of sites
 */
function displayAdminSites()
{
   // declare a datasource
   var dataSource='./retrieveAdminSites&selectCounty=DN&pagenum=1';

   var callingFunction='displayAdminSites';

   requestJSON(dataSource,callingFunction);
}

/**
 * Function is used by displayCounties function ot add options to select Menu
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

    /*var option=document.createElement('option');
    option.text = 'Test Option';
    option.value = 'Test Option';
    selectCounty.add(option);*/

   /* {% set dublin = 'Dublin' %}
    {% set northLeinster = 'North Leinster' %}
    {% set southLeinster = 'South Leinster' %}
    {% set northWest = 'North West' %}
    {% set southWest = 'South West' %}*/

    if('Dublin' == teamRegion)
    {
       /* var optionDN=document.createElement('option');
        optionDN.text='DN';
        optionDN.value='DN';
        optionsArr.push(optionDN);*/

        countyArr=['DN'];

        optionsArr=addOptionToSelect(countyArr);

    }
    else if('North Leinster' == teamRegion)
    {
        countyArr=['LH','MH','KE','WH','LD','CN','MN'];

        optionsArr=addOptionToSelect(countyArr);
    }

    for(var i=0; i<optionsArr.length;i++)
    {
        selectCounty.add(optionsArr[i]);
    }

/*<option value="LH">Louth</option>
<option value="MH">Meath</option>
<option value="KE">Kildare</option>
<option value="WH">Westmeath</option>
<option value="LD">Longford</option>
<option value="CN">Cavan</option>
<option value="MN">Monaghan</option>
{% elseif southLeinster == teamRegion %}
<option value="WW">Wicklow</option>
<option value="WX">Wexford</option>
<option value="LS">Laois</option>
<option value="KK">Kilkenny</option>
<option value="CW">Carlow</option>
<option value="OY">Offaly</option>
{% elseif southWest == teamRegion %}
<option value="TY">Tipperary</option>
<option value="WD">Waterford</option>
<option value="CE">Clare</option>
<option value="LK">Limerick</option>
<option value="CK">Cork</option>
<option value="KY">Kerry</option>
{% elseif northWest == teamRegion %}
<option value="LM">Leitrim</option>
<option value="SO">Sligo</option>
<option value="RN">Roscommon</option>
<option value="MO">Mayo</option>
<option value="GY">Galway</option>
<option value="DL">Donegal</option>
{% else %}
<option value="DN">Dublin</option>
<option value="LH">Louth</option>
<option value="MH">Meath</option>
<option value="KE">Kildare</option>
<option value="WH">Westmeath</option>
<option value="LD">Longford</option>
<option value="CN">Cavan</option>
<option value="MN">Monaghan</option>
<option value="WW">Wicklow</option>
<option value="WX">Wexford</option>
<option value="LS">Laois</option>
<option value="KK">Kilkenny</option>
<option value="CW">Carlow</option>
<option value="OY">Offaly</option>
<option value="TY">Tipperary</option>
<option value="WD">Waterford</option>
<option value="CE">Clare</option>
<option value="LK">Limerick</option>
<option value="CK">Cork</option>
<option value="KY">Kerry</option>
<option value="LM">Leitrim</option>
<option value="SO">Sligo</option>
<option value="RN">Roscommon</option>
<option value="MO">Mayo</option>
<option value="GY">Galway</option>
<option value="DL">Donegal</option>
{% endif %}*/
}

/**
 * When the page loads
 */
window.onload=function()
{
    console.log('page loading');

    teamRegion=document.getElementById('teamRegion').innerHTML;

    // display the relevant counties for teamRegion in select box
    displayCounties();

    displayAdminSites();
}