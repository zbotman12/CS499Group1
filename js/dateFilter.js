
	function isValid()
	{
		
		var tester;
		tester = document.forms["scheduleForm"]["date"].value;
	
	    if(tester.length != 10)
	    {
	    	alert("Invalid Date: MM/DD/YYYY");
			return false;
	    }
		
		var tempIndex;
		tempIndex = tester.indexOf("/", 0);
		
		if(tempIndex == -1)
		{
			alert("Invalid Date: MM/DD/YYYY");
			return false;
		}
		else
		{
			tempIndex = tempIndex + 1;
		}
		
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
		
		return isTimeValid();	
	}
	
	function isTimeValid()
	{
		var Stester;
		var Stester2;
		var Stester3;
		var Etester;
		var Etester2;
		var Etester3;
	
		
		Stester = document.forms["scheduleForm"]["startHour"].value;
		Stester2 = document.forms["scheduleForm"]["startMin"].value;
		Stester3 = document.forms["scheduleForm"]["startTime"].value;
		
		Etester = document.forms["scheduleForm"]["endHour"].value;
		Etester2 = document.forms["scheduleForm"]["endMin"].value;
		Etester3 = document.forms["scheduleForm"]["endTime"].value;
		
		Stester= parseInt(Stester);
		Etester= parseInt(Etester);
		
		if(Stester3 == "PM")
		{
			Stester = Stester + 12;
		}
		
		if(Etester3 == "PM")
		{
			Etester = Etester + 12;
		}
		
		switch(Stester2) {
	    case ":00":
	        break;
	    case ":15":
	        Stester= Stester+.15;
	        break;
	    case ":30":
	        Stester= Stester+.30;
	        break;
	    case ":45":
	        Stester= Stester+.45;
	        break;
	    default:
	        break;
		}
		
		switch(Etester2) {
	    case ":00":
	        break;
	    case ":15":
	        Etester= Etester+.15;
	        break;
	    case ":30":
	        Etester= Etester+.30;
	        break;
	    case ":45":
	        Etester= Etester+.45;
	        break;
	    default:
	        break;
		}
		if(Etester <= Stester)
		{
			alert("Invalid Start/End Time");
			return false;
		}
		
		return true;
	}
