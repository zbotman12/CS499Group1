
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
		
		return true;	
	}
	
	function isTimeValid(times, hour_keys)
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
		

		if(Stester <10)
		{
			var holdStart="0"+Stester+Stester2;
		}

		if(Etester<10)
		{
			var holdEnd="0"+Etester+Etester2;
		}

		if(Stester3=="AM" && Stester==12)
		{
			Stester=0;
			var holdStart="0"+Stester+Stester2;

		}

		if(Etester3=="AM" && Etester==12)
		{
			Etester=0;
			var holdEnd="0"+Etester+Etester2;

		}

		if(Stester3 == "PM" && Stester !=12)
		{
			Stester = Stester + 12;
			var holdStart=Stester+Stester2;
			
		}
		
		if(Etester3 == "PM" && Etester !=12)
		{
			Etester = Etester + 12;
			var holdEnd = Etester+Etester2;
		}

		if(Stester==12 && Stester3=="PM")
		{
			var holdStart=Stester+Stester2;
		}
		
		if(Etester==12 && Etester3=="PM")
		{
			var holdEnd=Etester+Etester2;
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
		
		var testIndex= hour_keys.indexOf(holdStart);

		if(times[hour_keys[testIndex]] == 0 || times[hour_keys[testIndex]]==3)
		{	
			var inc=1;
			while(hour_keys[testIndex+inc] != holdEnd && (testIndex+inc) < 95)
			{
				if(times[hour_keys[testIndex+inc]]>=1)
				{
					alert("ERROR: Schedule Overlap- Please Review Available");
					return false;
				}
				inc++;
			}
		}
		else
		{
			alert("ERROR: Schedule Overlap- Please Review Available");
				return false;	
		}
		return true;
	}

	
















