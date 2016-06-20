/*
 * SCRIPT HIDES AND DISPLAY THE SHOW MORE DETAILS SECTION
 */
var status = "less";

/* function toggles the div for extra detail */
function divToggle()
{
    var text="Here is some text that I want added to the HTML file";

    if (status == "less") 
    {
    	document.getElementById('toggleDiv').style.display = 'none';
        document.getElementById("showMoreLess").innerHTML = "Show More Details";
        status = "more";
    } 
    else if (status == "more") 
    {
        document.getElementById('toggleDiv').style.display = 'block';
        document.getElementById("showMoreLess").innerHTML = "Show Less Details";
        status = "less";
    }
}