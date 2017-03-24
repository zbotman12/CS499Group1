<?php
	//Setup
    session_start();
    include "DBTransactor/DBTransactorFactory.php";

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

<!-- Include bootstrap for table -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

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
			if (!isNaN(parseInt(arg1)) && !isNaN(parseInt(arg2))) {
				arg1 = parseInt(arg1);
				arg2 = parseInt(arg2);
				return reverse // `-1 *` if want opposite order
	            * (arg1 <= arg2);
			} else {
				return reverse // `-1 *` if want opposite order
	            * (arg1 // using `.textContent.trim()` for test
	                .localeCompare(arg2)
	               );
			}
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

<?php displayListingsTable(); ?>

<br/>
<p> Hello, world! </p>