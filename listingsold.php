<?php
	//Setup
    session_start();
    include "DBTransactor/DBTransactorFactory.php";

	//Function to display listings
	function displayListingsTable() {
		$listings = DBTransactorFactory::build("Listings");
		$ListingArray = $listings->select(['*']);

		echo "<table class=\"table table-hover table-responsive table-bordered\">";
		echo "<thead><tr>";

		echo "<th>MLS#</th>";
		//echo "<th>Agent ID</th>";
		echo "<th>Price</th>";
		echo "<th>City</th>";
		echo "<th>State</th>";
		echo "<th>ZIP</th>";
		echo "<th>Address</th>";
		echo "<th>Square Footage</th>";
		echo "<th>Beds</th>";
		echo "<th>Baths</th>";
		echo "<th>Room Description</th>";
		echo "<th>Listing Description</th>";
		echo "<th>Additional Info</th>";
		echo "<th>Addidtional Details</th>";

		echo "</thead></tr><tbody>";

		foreach ($ListingArray as $listing) {
			//TODO: refactor into continue
			$rowIsGood = true; 
			if ($listing["price"] == "") {
				$rowIsGood = false; 
			}

			if ($rowIsGood) {
				echo "<tr>";

				//var_dump($listing);
				//TODO: Refactor into "in" keyword
				foreach ($listing as $key => $attribute) {
					if ($key == "Agents_listing_agent_id" || $key == "agent_only_info" || $key == "daily_hit_count" || $key == "hit_count") {
					} elseif($key == "room_desc" || $key == "listing_desc" || $key == "additional_info") {
						echo "<td><div>";
						echo substr($attribute, 0, 90);
						echo "...";
						echo "</div></td>";
					} else {
						echo "<td><div>";
						echo $attribute;
						echo "</div></td>";
					}
					
					
				}

				echo "<td><center><a class=\"btn btn-default\" href=\"detailedlisting.php?MLS=";
				echo $listing["MLS_number"];
				echo "\">";
				echo "Link";
				echo "</td></center></a>";

				echo "</tr>";
			}
			
		}
		echo "</tbody></table>";
	}

?>
<head>
	<!--Include javascript to make table sortable-->
	<script type="text/javascript">
		//taken from http://jsfiddle.net/zscQy/
		function sortTable(table, col, reverse) {
			var tb = table.tBodies[0], // use `<tbody>` to ignore `<thead>` and `<tfoot>` rows
				tr = Array.prototype.slice.call(tb.rows, 0), // put rows into array
				i;
			reverse = -((+reverse) || -1);
			tr = tr.sort(function (a, b) { // sort rows
				arg1 = a.cells[col].textContent.trim();
				arg2 = b.cells[col].textContent.trim();
				
				num1 = parseInt(arg1);
				num2 = parseInt(arg2);
				
				//Sort as numbers if both are numbers
				if (!(isNaN(num1) || isNaN(num2))) {
					if (num1 < num2) {
						return reverse * -1;
					} else if (num1 == num2) {
						return reverse * 0;
					} else {
						return reverse * 1;
					}
				}
			
				//Otherwise, sort as strings
				return reverse // `-1 *` if want opposite order
					* arg1.localeCompare(arg2);// using `.textContent.trim()` for test
			});
			for(i = 0; i < tr.length; ++i) tb.appendChild(tr[i]); // append each row in order
		}

		function makeSortable(table) {
			var th = table.tHead, i;
			th && (th = th.rows[0]) && (th = th.cells);
			if (th) i = th.length;
			else return; // if no `<thead>` then do nothing
			while (--i >= 0) (function (i) {
				var dir = 1;
				th[i].addEventListener('click', function () {sortTable(table, i, (dir = 1 - dir))});
			}(i));
		}

		function makeAllSortable(parent) {
			parent = parent || document.body;
			var t = parent.getElementsByTagName('table'), i = t.length;
			while (--i >= 0) makeSortable(t[i]);
		}

		window.onload = function () {makeAllSortable();};

	</script>
	<!--Page title-->
	<title>
		Listings
	</title>
	<style>
		td > div {
			max-height: 125px;
			overflow: overlay;
		}
	</style>
</head>
<body>
	<?php include "header.php"; ?>
	<div class="container-fluid">
		<h2>Listings</h2>
		<hr/>
		<?php displayListingsTable(); ?>
	</div>	
	<?php include "footer.php"; ?>
</body>