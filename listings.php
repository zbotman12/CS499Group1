<?php
    include "DBTransactor/DBTransactorFactory.php";

    //Stolen and adapted from dataretriver.php
	function GetFilePathArrayVer2($MLS)
    {
        $FilePathArray = null;
        $dir = "Listing/photos/" .  $MLS . "/";
        if (is_dir($dir))
        {
            if ($dh = opendir($dir))
            {
                while (($file = readdir($dh)) !== false)
                {
                    if(!is_dir($dir . $file) && exif_imagetype($dir . $file))
                    {
                        if($FilePathArray == null)
                        {
                            $FilePathArray = array($dir . $file);
                        } else {
                            array_push($FilePathArray, $dir . $file);
                        }
                    }
                }
                closedir($dh);
                return $FilePathArray;
            }
        }
    }

    function getPic($MLS) {
    	$directories = GetFilePathArrayVer2($MLS);
	    echo "<img class=\"houseImg\" src=\"/";

    	if ($directories != null) {
	    	echo $directories[0]; //Use first picture
    	} else {
    		echo "Listing/noimage.png"; //Use filler picture
    	}

	    echo "\"</img>";
    }

    function getPrice($MLS) {
    	$listings = DBTransactorFactory::build("Listings");
		$ListingArray = $listings->select(["*"], ["MLS_number" => $MLS]);
		return $ListingArray[$MLS]["price"];
    }

    function getAgent($MLS) {
    	$listings = DBTransactorFactory::build("Listings");
    	$agents = DBTransactorFactory::build("Agents");

		$ListingArray = $listings->select(["*"], ["MLS_number" => $MLS]);
		$id = $ListingArray[$MLS]["Agents_listing_agent_id"];
		$AgentArray = $agents->select(["*"], ["agent_id" => $id]);

		return $AgentArray[$id]["first_name"] . " " . $AgentArray[$MLS]["last_name"];
    }

    function getAddress($MLS) {
    	$listings = DBTransactorFactory::build("Listings");
		$ListingArray = $listings->select(["*"], ["MLS_number" => $MLS]);
		return $ListingArray[$MLS]["address"];
    }

    //TODO: Refactor this
    function getCompany($MLS) {
    	$listings = DBTransactorFactory::build("Listings");
    	$agents = DBTransactorFactory::build("Agents");
        $Agencies = DBTransactorFactory::build("Agencies");

		$ListingArray = $listings->select(["*"], ["MLS_number" => $MLS]);
		$agentID = $ListingArray[$MLS]["Agents_listing_agent_id"];
		$AgentArray = $agents->select(["*"], ["agent_id" => $agentID]);
		$agencyID = $AgentArray[$agentID]["Agencies_agency_id"];
		$AgenciesArray = $Agencies->select(["*"], ["agency_id" => $agencyID]);

		return $AgenciesArray[$agencyID]["company_name"];
	}

    function getSqFootage($MLS) {
    	$listings = DBTransactorFactory::build("Listings");
		$ListingArray = $listings->select(["*"], ["MLS_number" => $MLS]);
		return $ListingArray[$MLS]["square_footage"];
    }

    function getDetailsLink($MLS) {
    	$toReturn = "";
    	$toReturn .= "<a class=\"btn btn-default\" href=\"detailedlisting.php?MLS=";
		$toReturn .= $MLS;
		$toReturn .= "\">";
		$toReturn .= "Details</a>";
		return $toReturn;
    }

    function createRow($MLS) {
    	echo "<div class=\"listing\">";
		echo getPic($MLS);
		echo "<div class=\"listing-text\">";
		echo "<div class=\"row\">";
		echo "<p class=\"left\">";
		echo getPrice($MLS);
		echo "</p>";
		echo "<p class=\"right\">";
		echo getAgent($MLS);
		echo "</p>";
		echo "</div>";
		echo "<div class=\"row\">";
		echo "<p class=\"left\">";
		echo getAddress($MLS);
		echo "</p>";
		echo "<p class=\"right\">";
		echo getCompany($MLS);
		echo "</p>";
		echo "</div>";
		echo "<div class=\"row\">";
		echo "<p class=\"left\">";
		echo getSqFootage($MLS);
		echo " sq. ft.";
		echo "</p>";
		echo "<p class=\"right\">";
		echo getDetailsLink($MLS);
		echo "</p>";
		echo "</div></div></div>";
    }

    function createAllRows() {
		$listings = DBTransactorFactory::build("Listings");
		$ListingArray = $listings->select(['*']);

		foreach ($ListingArray as $listing) {
			createRow($listing["MLS_number"]);
		}
    }
?>

<head>
	<style>
		.listing {
			overflow: hidden;
			height: 300px;
			margin: 10px;
		}

		.listing:hover {
			background-color: #eee;
		}

		.houseImg {
			height: 100%;
			display: inline;
			float: left;
		}

		.listing-text {
			width: 65%;
			height: 100%;
			display: block;
			float: right;
			padding: 10px;
		}

		.row {
			overflow: hidden;
			height: 30%;    
			margin: 10px;
			margin-top: 0px;
    		padding: 5px;
    		padding-right: 10px;
		}

		.left .right {
			width: 50%;
		}

		.left {
			float: left;
		}

		.right {
			float: right;
		}

	</style>
</head>

<body>
	<?php include "header.php"; ?>	
	<div class="container-fluid">
		<h2>Listings</h2>
		<hr/>
		<?php createAllRows(); ?>
	</div>
	<?php include "footer.php"; ?>
</body>