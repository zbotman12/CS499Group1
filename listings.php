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

	//Returns <img class="houseImg"> of the first pic in the listing's pic folder
    function createPic($MLS) {
    	$directories = GetFilePathArrayVer2($MLS);
		$toReturn = ""; 
	    $toReturn .= "<img class=\"houseImg\" src=\"/";

    	if ($directories != null) {
	    	$toReturn .= $directories[0]; //Use first picture
    	} else {
    		$toReturn .= "Listing/noimage.png"; //Use filler picture
    	}

	    $toReturn .= "\"</img>";
		
		return $toReturn;
    }

	//Returns the text of the listing's price
    function getPrice($MLS, $listings) {
		$ListingArray = $listings->select(["*"], ["MLS_number" => $MLS]);
		return $ListingArray[$MLS]["price"];
    }

	//Returns the first + last name of the listing's associated agnent
    function getAgent($MLS, $listings, $agents) {
		$ListingArray = $listings->select(["*"], ["MLS_number" => $MLS]);
		$id = $ListingArray[$MLS]["Agents_listing_agent_id"];
		$AgentArray = $agents->select(["*"], ["agent_id" => $id]);

		return $AgentArray[$id]["first_name"] . " " . $AgentArray[$MLS]["last_name"];
    }
	
	//Returns the address of the listing
    function getAddress($MLS, $listings) {
		$ListingArray = $listings->select(["*"], ["MLS_number" => $MLS]);
		return $ListingArray[$MLS]["address"];
    }

    //Returns the company associated with the listing's agent
    function getCompany($MLS, $listings, $agents, $agencies) {
		$ListingArray = $listings->select(["*"], ["MLS_number" => $MLS]);
		$agentID = $ListingArray[$MLS]["Agents_listing_agent_id"];
		$AgentArray = $agents->select(["*"], ["agent_id" => $agentID]);
		$agencyID = $AgentArray[$agentID]["Agencies_agency_id"];
		$AgenciesArray = $agencies->select(["*"], ["agency_id" => $agencyID]);

		return $AgenciesArray[$agencyID]["company_name"];
	}

	//Returns the square footage of the listing
    function getSqFootage($MLS, $listings) {
		$ListingArray = $listings->select(["*"], ["MLS_number" => $MLS]);
		return $ListingArray[$MLS]["square_footage"];
    }

	//Returns <a class="btn btn-default"> linking to the listing's detail page
    function createDetailsLink($MLS) {
    	$toReturn = "";
    	$toReturn .= "<a class=\"btn btn-default\" href=\"detailedlisting.php?MLS=";
		$toReturn .= $MLS;
		$toReturn .= "\">";
		$toReturn .= "Details</a>";
		return $toReturn;
    }
	
	
?>

<head>
	<title>Listings</title>
	<style>
		.listing {
			margin: 10px;
		}
		
		.listing:hover {
			background-color: #eee;
		}
		
		.houseImg {
			height: 300px;
			max-width: 100%;
		}
		
		.listing-text {
			padding-bottom: 0;
		}
		
		.listing-row {
			height: 100px;
			padding:10px;
		}
		
		.listing-p {
			height: 50px;
		}
	</style>
</head>

<body>
	<?php include "header.php"; ?>	
	<div class="container-fluid">
		<h2>Listings</h2>
		<hr/>
		<!--Listings display loop-->
		<?php
			//Create DB Accessors
			$listings = DBTransactorFactory::build("Listings");
			$agents = DBTransactorFactory::build("Agents");
			$agencies = DBTransactorFactory::build("Agencies");
			
			//Begin iteration through all MLS numbers
			$ListingArray = $listings->select(['MLS_number']);
			foreach($ListingArray as $listing) {
				$MLS = $listing["MLS_number"]
		?>
		<div class="container-fluid listing">
			<div class="col-md-4">
				<?php echo createPic($MLS); ?>
			</div>
			<div class="col-md-8 listing-text">
				<div class="container-fluid listing-row">
					<div class="col-sm-6 listing-p">
						<?php echo getPrice($MLS, $listings); ?>
					</div>
					<div class="col-sm-6 listing-p">
						<?php echo getAgent($MLS, $listings, $agents); ?>
					</div>
				</div>
				<div class="container-fluid listing-row">
					<div class="col-sm-6 listing-p">
						<?php echo getAddress($MLS, $listings); ?>
					</div>
					<div class="col-sm-6 listing-p">
						<?php echo getCompany($MLS, $listings, $agents, $agencies); ?>
					</div>
				</div>
				<div class="container-fluid listing-row">
					<div class="col-sm-6 listing-p">
						<?php echo getSqFootage($MLS, $listings); ?> sq. ft. 
					</div>
					<div class="col-sm-6 listing-p">
						<?php echo createDetailsLink($MLS); ?>
					</div>
				</div>
			</div>
		</div>
		<?php 
			} //End iteration
		?>
		<!--End listings display loop-->
	</div>
	<?php include "footer.php"; ?>
</body>