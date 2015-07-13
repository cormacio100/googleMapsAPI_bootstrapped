
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

var searchParam;
var selectCounty;
var startRecord;
var recordsPerPage;
var pageNum;

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
 * When the page loads
 */
window.onload=function()
{
    console.log('page loading');

    displayAdminSites();
}