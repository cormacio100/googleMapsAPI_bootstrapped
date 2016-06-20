var imageType;


function loadImage(imageType)
{
	var accordionImage=document.getElementById('accordionImage');
	
	if('1g'==imageType)
	{
		console.log('1g loading');
		
		accordionImage.innerHTML='1G Image';
	}
	if('2g'==imageType)
	{
		console.log('2g loading');
		
		accordionImage.innerHTML='2G Image';
	}
	if('3g'==imageType)
	{
		console.log('3g loading');
		
		accordionImage.innerHTML='3G Image';
	}
	if('4g'==imageType)
	{
		console.log('4g loading');
		
		accordionImage.innerHTML='4G Image';
	}
}


