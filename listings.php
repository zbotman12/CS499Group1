<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";

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
    		$toReturn .= "Helpers/Images/noimage.png"; //Use filler picture
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

		return $AgentArray[$id]["first_name"] . " " . $AgentArray[$id]["last_name"];
    }
	
	//Returns the address of the listing
    function getAddress($MLS, $listings) {
		$ListingArray = $listings->select(["*"], ["MLS_number" => $MLS]);
		return $ListingArray[$MLS]["address"] . ", " . $ListingArray[$MLS]["zip"] ;
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
    	$toReturn .= "<a class=\"btn btn-default\" href=\"Listing/detailedListingDisplay.php?MLS=";
		$toReturn .= $MLS;
		$toReturn .= "\">";
		$toReturn .= "Details</a>";
		return $toReturn;
    }
?>

<head>
	<link href="/style/Listing.css" rel="stylesheet">
	<style>
		.listing {
			font-family: serif;
		}
	
		.pageNav {
			display: inline;
		}
		
	</style>
	<title>Listings</title>
	<script>
		$(document).on("click", ".clearButton", function () {
		    window.location.replace(<?php $_SERVER['SERVER_NAME'] + '/listings.php');
		});
	</script>
</head>

<body>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
	<div class="container-fluid">
		<h2>Listings</h2>
		<hr/>
		<!--Listing options form-->
		<form action="./listings.php" method="GET">
			<div class="form-group">
				<label for="sqftMin">Min Sq. Ft.</label>
				<input type="text" name="sqftMin" value="<?php echo $_GET["sqftMin"]; ?>"/>
				<label for="sqftMax">Max Sq. Ft.</label>
				<input type="text" name="sqftMax" value="<?php echo $_GET["sqftMax"]; ?>"/>
				<label for="priceMin">Min Price</label>
				<input type="text" name="priceMin" value="<?php echo $_GET["priceMin"]; ?>"/>
				<label for="priceMax">Max Price</label>
				<input type="text"  name="priceMax" value="<?php echo $_GET["priceMax"]; ?>"/>
				<label for="zipCode">ZIP Code</label>
				<input type="text" name="zipCode" value="<?php echo $_GET["zipCode"]; ?>"/>
				<button type="submit" class="btn btn-primary">Search</button>
				<button type="reset" value="Reset" class="btn btn-primary clearButton">Clear Filters</button>
				<input type="hidden" value="1" name="page"/>
			</div>
		</form>
		<!--Listings display loop-->
		<?php
			//Create DB Accessors
			$listings = DBTransactorFactory::build("Listings");
			$agents = DBTransactorFactory::build("Agents");
			$agencies = DBTransactorFactory::build("Agencies");
			
			//Get all listings
			$FULL_GET_SIZE = 6; //The size of $_GET when all fields have been sent
			$allListings = $listings->select(['MLS_number', 'square_footage', 'price', 'zip'], []);
			$listingsToDisplay = array();
			
            //Remove listings which do not meet search parameters
			if (count($_GET) == 0) { //No search parameters exist
				$listingsToDisplay = $allListings; 
			} else if (count($_GET) >= 1) {
				foreach ($allListings as $listing) {
					
					//Check square footage
					$sqft = $listing["square_footage"];
					$sqft = str_replace(",", "", $sqft);
					$sqft = intval($sqft);
					if ($sqft == 0) continue; //0 is the return value for failed conversion
					
					$sqftMin = intval($_GET['sqftMin']);
					$sqftMax = intval($_GET['sqftMax']);
					if ($sqftMin != 0) {
						if ($sqft < $sqftMin) continue;
					}
					if ($sqftMax != 0) {
						if ($sqft > $sqftMax) continue;
					}
					
					//Check price
					$price = $listing["price"];
					$price = str_replace("$", "", $price);
					$price = str_replace(",", "", $price);
					$price = intval($price);
					if ($price == 0) continue; //0 is the return value for failed conversion
					
					$priceMin = intval($_GET['priceMin']);
					$priceMax = intval($_GET['priceMax']);
					if ($priceMin != 0) {
						if ($price < $priceMin) continue;
					}
					if ($priceMax != 0) {
						if ($price > $priceMax) continue;
					}
					
					//Check zip code 
					$myZip = intval($listing["zip"]);
					if ($myZip == 0) continue; //0 is the return value for failed conversion
					
					$zipCode = intval($_GET['zipCode']);
					if ($zipCode != 0) {
						if ($myZip != $zipCode) continue;
					}
					
					//If the code has reached this line, the listing
					//does not violate any of the search parameters 
					$listingsToDisplay[$listing["MLS_number"]] = $listing;
				}
			}

			//Determine which indexes to display
			$RESULTS_PER_PAGE = 2;
			$num_results = count($listingsToDisplay);
			
			$start_idx = 0;
			if($_GET["page"] != null) {
				$start_idx = ($_GET["page"]-1) * $RESULTS_PER_PAGE; //pages are 1-based
			}
			
			$end_idx = $start_idx + $RESULTS_PER_PAGE - 1;
		    
            // Hey nick. Problem is in this line here. Michael
            //var_dump($listingsToDisplay);
			$listingsToDisplay = array_slice($listingsToDisplay, $start_idx, $RESULTS_PER_PAGE);
			
			//Begin iteration through all MLS numbers
            //echo "After slicing<br><br>";
            //var_dump($listingsToDisplay);
			
            foreach($listingsToDisplay as $listing) {
				$MLS = $listing["MLS_number"]
		?>
		<a  style="color:black" href= <?php echo "/Listing/detailedListingDisplay.php?MLS=" . $MLS; ?>>
		<div class="container-fluid listing">
			<div class="col-md-4">
				<?php echo createPic($MLS); ?>
			</div>
			<div class="col-sm-8 listing-address">
				<?php echo getAddress($MLS, $listings); ?>
			</div>
			<div class="col-md-8 listing-text">
				<div class="container-fluid listing-row">
					<div class="col-sm-6 col-xs-6">
						$<?php echo getPrice($MLS, $listings); ?>
					</div>
					<div class="col-sm-6 col-xs-6">
						<?php echo getAgent($MLS, $listings, $agents); ?>
						
					</div>
				</div>
				<div class="container-fluid listing-row2">
					<div class="col-sm-6 col-xs-6">
						<?php echo getSqFootage($MLS, $listings); ?> sq. ft. 
					</div>
					<div class="col-sm-6 col-xs-6">
						<?php echo getCompany($MLS, $listings, $agents, $agencies); ?>
						<?php //echo createDetailsLink($MLS); ?>
					</div>
				</div>
			</div>
		</div>
		</a>
		<?php 
			} //End iteration
		?>
		<!--End listings display loop-->
		
		<!--Navigation buttons-->
		<center>
			<?php if($start_idx > 0) { ?>
			<form action="./listings.php" method="GET" class="pageNav">
				<input type="hidden" name="sqftMin" value="<?php echo $_GET["sqftMin"]; ?>"/>
				<input type="hidden" name="sqftMax" value="<?php echo $_GET["sqftMax"]; ?>"/>
				<input type="hidden" name="priceMax" value="<?php echo $_GET["priceMax"]; ?>"/>
				<input type="hidden" name="priceMax" value="<?php echo $_GET["priceMax"]; ?>"/>
				<input type="hidden" name="zipCode" value="<?php echo $_GET["zipCode"]; ?>"/>
				<input type="hidden" name="page" value="<?php echo $_GET["page"] - 1; ?>"/>
				<button type="submit" class="btn btn-primary"><< Previous</button>
			</form>
			<?php } ?>
			
			<?php if($num_results > $end_idx + 1) { ?>
			<form action="./listings.php" method="GET" class="pageNav">
				<input type="hidden" name="sqftMin" value="<?php echo $_GET["sqftMin"]; ?>"/>
				<input type="hidden" name="sqftMax" value="<?php echo $_GET["sqftMax"]; ?>"/>
				<input type="hidden" name="priceMax" value="<?php echo $_GET["priceMax"]; ?>"/>
				<input type="hidden" name="priceMax" value="<?php echo $_GET["priceMax"]; ?>"/>
				<input type="hidden" name="zipCode" value="<?php echo $_GET["zipCode"]; ?>"/>
				<input type="hidden" name="page" value="<?php 
					if ($_GET["page"] != 0) echo $_GET["page"] + 1;
					else echo 2; 				
				?>"/>
				<button type="submit" class="btn btn-primary">Next >></button>
			</form>
			<?php } ?>
		</center>
		<br/>
	</div>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
