
	function isValid()
	{
		//alert("hello");
		var tester;
		tester = document.forms["scheduleForm"]["date"].value;
		//alert(tester.indexOf("/"));
		//alert(tester.substring(0,(tester.indexOf("/", 0))));
		if(isNaN(tester.substring(0,(tester.indexOf("/", 0)))))
		{	
			alert(tester.substring(0,(tester.indexOf("/", 0))));
			return false;
		}
		
		var tempIndex;
		tempIndex = tester.indexOf("/", 0)+1;
		
		if(isNaN(tester.substring(tempIndex,(tester.indexOf("/",tempIndex)))))
		{
			alert("Invalid Date: MM/DD/YYYY");
			return false;
		}
		var tempIndex2;
		tempIndex2 = tester.indexOf("/", tempIndex)+1;
		if(isNaN(tester.substring(tempIndex2,tester.length-1)))
		{
			alert("Invalid Date: MM/DD/YYYY");
			return false;
		}

		if((Number(tester.substring(0,(tester.indexOf("/", 0))))) > 12)
		{
			alert("Invalid Date: MM/DD/YYYY");
			return false;
		}
		if((Number(tester.substring(tempIndex,(tester.indexOf("/",tempIndex))))) > 31)
		{
			alert("Invalid Date: MM/DD/YYYY");
			return false;
		}		
		return true;	
	}
