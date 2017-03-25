<?php
    session_start();
    include "DBTransactor/DBTransactorFactory.php";

    //This function gets the listing data as an array for a listing with MLS number $_GET['MLS']
    function GetListingArray()
    { 
        if(!isset($_GET['MLS']))
        {
            echo "ERROR: You are trying to view a detailed listing without an MLS number in the URL.";
            exit();
        }

        $listings = DBTransactorFactory::build("Listings");

        if($ListingArray = $listings->select(['*'], ['MLS_number' => $_GET['MLS']]))
        {
            return $ListingArray[$_GET['MLS']];
        } else {
            echo "Error: Could not find MLS number in database. <br>"; //. mysqli_error($conn);
            return null;
        }
    }

    //This function returns an array of showing data arrays for a listing with MLS number $_GET['MLS']
    function GetShowingsArrays()
    {
        if(!isset($_GET['MLS']))
        {
            echo "ERROR: You are trying to view a detailed listing without an MLS number.";
            exit();
        }
        
        $showings = DBTransactorFactory::build("Showings");

        if($ShowingArrays = $showings->select(['*'], ['Listings_MLS_number' => $_GET['MLS']]))
        {
            return $ShowingArrays;
        } else {
            echo "No showings currently scheduled for this listing.<br>"; //. mysqli_error($conn);
            return null;
        }
    }

    function GetShowingData($columnName, $ShowingIndex)
    {
        $ShowingArrays = GetShowingsArrays();
        return $ShowingArrays[$ShowingIndex][$columnName];
    }

    function GetShowingsCount()
    {
        return count(GetShowingsArrays());
    }

    //This function gets the listing agent data as an array for a listing with MLS number $_GET['MLS']
    function GetAgentArray()
    { 
        $listingArray = GetListingArray();
        $Agents = DBTransactorFactory::build("Agents");

        if($agentArray = $Agents->select(['*'], ['agent_id' => $listingArray['Agents_listing_agent_id']]))
        {
            return $agentArray[$listingArray['Agents_listing_agent_id']];
        } else {
            echo "Error: Could not find listing agent in database. <br>" . mysqli_error($conn);
            return null;
        }
    }

    //This function gets the agency data as an array for a listing with MLS number $_GET['MLS']
    function GetAgencyArray()
    { 
        $agentArray = GetAgentArray();
        $Agencies = DBTransactorFactory::build("Agencies");

        if($agencyArray = $Agencies->select(['*'], ['agency_id' => $agentArray['Agencies_agency_id']]))
        {
            return $agencyArray[$agentArray['Agencies_agency_id']];
        } else {
            echo "Error: Could not find MLS number in database. <br>" . mysqli_error($conn);
            return null;
        }
    }

    //This function takes a column name and a table name and returns the value found within
    function GetData($index, $table)
    {
        switch ($table) 
        {   
            case 'Listings' : $Array = GetListingArray(); break;
            case 'Agents'   : $Array = GetAgentArray(); break;
            case 'Agencies' : $Array = GetAgencyArray(); break;
            default         : return null;
        }

        if($Array != null && count($Array) > 0)
        {
            return $Array[$index];
        } 
    }

    //This function returns an array of the filepaths to all photos for a listing with MLS number $_GET['MLS']
    function GetFilePathArray()
    { 
        if(!isset($_GET['MLS']))
        {
            echo "ERROR: You are trying to view a detailed listing without an MLS number in the URL.";
            exit();
        }
        $FilePathArray = null;
        $dir = "Listing/photos/" .  $_GET['MLS'] . "/";
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

    //USED FOR editPhotoUpload.
//This function returns an array of the filepaths to all photos for a listing with MLS number $_GET['MLS']
    function GetFilePathArrayVer2()
    { 
        if(!isset($_GET['MLS']))
        {
            echo "ERROR: You are trying to view a detailed listing without an MLS number in the URL.";
            exit();
        }
        $FilePathArray = null;
        $dir = "photos/" .  $_GET['MLS'] . "/";
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
?>
