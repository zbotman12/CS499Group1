<?php
	//Setup
    session_start();
    include "DBTransactor/DBTransactorFactory.php";

	//Function to get listings
	function displayListingsTable() {
		$listings = DBTransactorFactory::build("Listings");
		$ListingArray = $listings->select(['*']);

		echo "<table class=\"table table-bordered\">";
		echo "<thead><tr>";

		echo "<th>MLS#</th>";
		echo "<th>Agent ID</th>";
		echo "<th>Price</th>";
		echo "<th>City</th>";
		echo "<th>State</th>";
		echo "<th>ZIP</th>";
		echo "<th>Address</th>";
		echo "<th>Square Footage</th>";
		echo "<th># of Bedrooms</th>";
		echo "<th># of Bathrooms</th>";
		echo "<th>Room Description</th>";
		echo "<th>Listing Description</th>";
		echo "<th>Additional Info</th>";
		echo "<th></th>"; //TODO: Hide this column
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

				foreach ($listing as $attribute) {
					echo "<td>";
					echo $attribute;
					echo "</td>";
				}

				echo "<td><a href=\"detailedlisting.php?MLS=";
				echo $listing["MLS_number"];
				echo "\">";
				echo "Link";
				echo "</td></a>";

				echo "</tr>";
			}
			
		}
		echo "</tbody></table>";
	}

?>
<head>
	<!-- Include bootstrap for table -->
	<link rel="stylesheet" href="./style/bootstrap.min.css" >

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
</head>
<body>
	<?php displayListingsTable(); ?>
</body>