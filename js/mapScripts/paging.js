
window.onload=function() {
    /*
     *
     * Submit AJAX call and display on the page
     *
     * */
}
/*
* example taken from https://www.developphp.com/video/JavaScript/Ajax-Pagination-Tutorial-PHP-MySQL-Database-Results-Paged
* */


function request_page(pn)   /* pn = page number*/
{
    var results_box=document.getElementById("results_box");
    var pagination_controls=document.getElementById("pagination_controls");

    results_box.innerHTML="LOADING RESULTS..."

    /* AJAX part */
    var hr=new XMLHttpRequest();
    hr.open("POST","pagination_parser.php",true);
    hr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    hr.onreadystatechange=function(){
        if(hr.readyState==4 && hr.status==200)
        {
            var dataArray=hr.responseText.split("||");
            var html_output="";

            for(i=0; i<dataArray.length-1;i++)
            {
                var itemArray=dataArray[i].split("|");
                html_output +="ID: "+itemArray[0]+"- Testimonial from <b>"+itemArray[1]+"</b><hr>";
            }
            results_box.innerHTML=html_output;
        }
        hr.send("rpp="+rpp+"&last="+last+"&pn="+pn);
    }

    // change the pagination controls
    var paginationCtrls="";

    // only if there is more than 1 page worth of results give the user pagination controls
    if(last!=1)
    {
        if(pn>1)
        {
            paginationCtrls+='<button onclick="request_page('+(pn-1)+')">&lt;</button>';
        }
        paginationCtrls+='&nbsp; &nbsp <b>Page '+pn+' of '+last+'</b> &nbsp; &nbsp';

        if(pn!=last)
        {
            paginationCtrls+='<button onclick="request_page('+(pn+1)+')">&gt;</button>';
        }
    }
    pagination_controls.innerHTML=paginationCtrls;


}