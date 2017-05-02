<?php
	//Paperwork Utility
	//Nick Diliberti
	//May 2017

	if(session_id() == null) {
		session_start(); 
	}

	//var_dump($_SESSION);
	//var_dump($_POST);

	function dollarize($input) {
		$input = str_replace("$", "", $input);
		$input = str_replace(",", "", $input);
		setlocale(LC_MONETARY, 'en_US');
		$input = money_format('%i', $input);
		return "$" . str_replace("USD ", "", $input);

	}

	function dedollarize($input) {
		$input = str_replace("$", "", $input);
		$input = str_replace(",", "", $input);
		return $input;
	}

	//Taken from http://stackoverflow.com/questions/4708248/formatting-phone-numbers-in-php
	function phoneNumberize($phoneNumber) {
	    $phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);

	    if(strlen($phoneNumber) > 10) {
	        $countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
	        $areaCode = substr($phoneNumber, -10, 3);
	        $nextThree = substr($phoneNumber, -7, 3);
	        $lastFour = substr($phoneNumber, -4, 4);

	        $phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
	    }
	    else if(strlen($phoneNumber) == 10) {
	        $areaCode = substr($phoneNumber, 0, 3);
	        $nextThree = substr($phoneNumber, 3, 3);
	        $lastFour = substr($phoneNumber, 6, 4);

	        $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
	    }
	    else if(strlen($phoneNumber) == 7) {
	        $nextThree = substr($phoneNumber, 0, 3);
	        $lastFour = substr($phoneNumber, 3, 4);

	        $phoneNumber = $nextThree.'-'.$lastFour;
	    }

	    return $phoneNumber;
	}
?>

<!DOCTYPE html>
<head>
	<title>Paperwork Utility</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
		//Taken from http://stackoverflow.com/questions/149055/how-can-i-format-numbers-as-money-in-javascript
		function JSdollarize(input) {
			return "$" + input.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
		}

		//Sums columns in Sellers ECC
		$(window).on('load', function(){
			var debitSum = 0.0;
			var creditSum = 0.0;
			var length = $("#bigtable").find("tbody").find("tr").length;

			//TODO(?): Fix the misbehavior of the jQuery iterator to clean this up
			for(var i = 0; i <= length - 2; i++) {
				if ($("#bigtable").find("tbody").find("tr").find("td:nth-child(2)")[i].innerHTML != "") {
					debitSum += parseFloat($("#bigtable").find("tbody").find("tr").find("td:nth-child(2)")[i].innerHTML.trim().substring(1));
				}
				if ($("#bigtable").find("tbody").find("tr").find("td:nth-child(3)")[i].innerHTML != "") {
					creditSum += parseFloat($("#bigtable").find("tbody").find("tr").find("td:nth-child(3)")[i].innerHTML.trim().substring(1));
				}
			}

			if (!isNaN(debitSum)) {
				$("#debitTotal")[0].innerHTML = JSdollarize(debitSum);
			}
			if (!isNaN(creditSum)) {
				$("#creditTotal")[0].innerHTML = JSdollarize(creditSum);
			}
		});
	</script>
	<style>
		body {
			margin-left: 100px;
			margin-right: 100px;
		}
		
		#bigtable {
			width: 100%;
			border-collapse: collapse;
			border: 2px solid black;
		}

		#bigtable > tbody > tr > td:nth-child(2),
		#bigtable > tbody > tr > td:nth-child(3){
			text-align: right;
		}
		
		th {
			border: 2px solid black;
		}
		
		td {
			border-left: 2px solid black;
			border-right: 2px solid black;
			border-bottom: 1px solid black;
		}

		#loanTable {
			table-layout: fixed;
			width: 100%;
			border-collapse: collapse;
		}
		
		#loanTable > tbody > tr > td {
			border-left:none;
			border-right:none;
			border-top: 1px solid grey;
			border-bottom: 1px solid grey;
			word-break: break-word;
		}

		#rightCosts,
		#leftCosts {
			width: 45%;
			display: inline-block;
			vertical-align: top;
			text-align: right;
		}

		#loanTerms,
		#projectedPayments,
		#bottomCosts {
			text-align: right;
			clear: both;
		}

		#leftCosts {
			margin-right: 20px;
		}

		#rightCosts {
			margin-left: 20px;
			float: right;
		}

		.blockTitle {
			font-weight: bold;
		}
		
		.spacingRow {
			height: 21px;
		}
		
		.sigLabel {
			width: 20%;
			display: inline;
		}
		
		.noBorder {
			border: none;
		}
		
		.halfHeader {
			width: 45%;
			display: inline-block;
		}
		
		.left {
			text-align: left;

		}
		
		.right {
			text-align: right;
			float: right;
		}
	</style>
</head>
<body>

<?php 
	if ($_POST["formType"] == "buyerClosingCosts") {
?>

	<center>
		<h2>Estimated Closing Costs</h2>
	</center>

	<h3>Loan Estimate</h3>
	<hr/>

	<!--Left side-->
	<div class="halfHeader left">
		<b>Date Issued</b>
		<?php 
			if ($_POST["date"] == "") {
				echo "______________________";
			} else {
				echo $_POST["date"]; 
			}
		?>
		<br/>
		<b>Applicants</b>
		<?php 
			if ($_POST["buyer"] == "") {
				echo "______________________";
			} else {
				echo $_POST["buyer"]; 
			}
		?>
		<br/>
		<b>Property</b>
		<?php 
			if ($_POST["address"] == "") {
				echo "______________________";
			} else {
				echo $_POST["address"]; 
			}
		?>
		<br/>
		<b>Sale Price</b>
		<?php 
			if ($_POST["cost"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["cost"]); 
			}
		?>
		<br/>
	</div>

	<!--Right side-->
	<div class="halfHeader right">
		<b>Loan Term</b>
		<?php 
			if ($_POST["loanTerm"] == "") {
				echo "______________________";
			} else {
				echo ($_POST["loanTerm"]); 
			}
		?>
		<br/>
		<b>Purpose</b>
		<?php 
			if ($_POST["loanPurpose"] == "") {
				echo "______________________";
			} else {
				echo $_POST["loanPurpose"]; 
			}
		?>
		<br/>
		<b>Product</b>
		<?php 
			if ($_POST["loanType"] == "") {
				echo "______________________";
			} else {
				echo ($_POST["loanType"]); 
			}
		?>
		<br/>
		<b>Loan Type</b>
		<?php 
			if ($_POST["loanArchetype"] == "") {
				echo "______________________";
			} else {
				echo ($_POST["loanArchetype"]); 
			}
		?>
		<br/>
		<b>Loan ID#</b>
		<?php 
			if ($_POST["loanID"] == "") {
				echo "______________________";
			} else {
				echo ($_POST["loanID"]); 
			}
		?>
		<br/>
		<b>Rate Lock</b>
		<?php 
			if ($_POST["rateLock"] == "") {
				echo "______________________";
			} else {
				echo ($_POST["rateLock"]); 
			}
		?>
		<br/>
	</div>	

	<div id="loanTerms">
		<p style="font-style: italic; text-align: left;">Loan Terms</p>
		<b>Loan Amount</b>
		<?php 
			if ($_POST["loanAmmount"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["loanAmmount"]); 
			}
		?>
		<br/>
		<b>Interest Rate</b>
		<?php 
			if ($_POST["interestRate"] == "") {
				echo "______________________";
			} else {
				echo ($_POST["interestRate"]); 
			}
		?>
		<br/>
		<b>Monthly Principal & Interest</b>
		<?php 
			if ($_POST["monthlyPrincipal"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["monthlyPrincipal"]); 
			}
		?>
		<br/>
		<b>Prepayment Penalty</b>
		<?php 
			if ($_POST["prepayment"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["prepayment"]); 
			}
		?>
		<br/>
		<b>Balloon Payment</b>
		<?php 
			if ($_POST["balloonPayment"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["balloonPayment"]); 
			}
		?>
		<br/>
	</div>

	<div id="projectedPayments">
		<p style="font-style: italic; text-align: left;">Projected Payments</p>
		<b>Princial & Interest</b>
		<?php 
			if ($_POST["pincialAndInterest"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["pincialAndInterest"]); 
			}
		?>
		<br/>
		<b>Mortgage Insurance</b>
		<?php 
			if ($_POST["balloonPayment"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["balloonPayment"]); 
			}
		?>
		<br/>
		<b>Estimated Escrow</b>
		<?php 
			if ($_POST["etimEscrow"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["etimEscrow"]); 
			}
		?>
		<br/>
		<b>Estimated Total Montly Payment</b>
		<?php 
			if ($_POST["pincialAndInterest"] != "" &&
				$_POST["balloonPayment"] != "" &&
				$_POST["etimEscrow"] != "") {
					echo dollarize(dedollarize($_POST["pincialAndInterest"]) +
						dedollarize($_POST["balloonPayment"]) +
						dedollarize($_POST["etimEscrow"]));
			} else {
				echo "______________________";
			}
		?>
		<br/>
		<b>Estimated Taxes, Insurance, and Assessments</b>
		<?php 
			if ($_POST["taxesEtc"] == "") {
				echo "______________________";
			} else {
				echo ($_POST["taxesEtc"]); 
			}
		?>
		<br/>
	</div>

	<br/>
	<h3>Additional Loan Considerations</h3>
	<hr/>
	<table id="loanTable">
		<tr style="border-top: none;">
			<td style="border-top: none;"><b>Appraisal</b></td>
			<td style="border-top: none;">
			The lender may order an appraisal to determine the property's value and charge the buyer for this appraisal.  The lender will promptly give the buyer a copy of any appraisal, even if the loan does not close.  The buyer may pay for an additional appriasal at his own cost. 
			</td>
		</tr>
		<tr>
			<td><b>Assumption</b></td>
			<td>
			If the buyer transfers this property to another person, the lender
			<br/>
			[<?php if ($_POST["assumption"] == "yes") {
				echo "X";
			} else {
				echo "&nbsp&nbsp";
			}
			?>] will allow, under certain conditions, the new buyer to assume this loan on the original terms
			<br/>
			[<?php if ($_POST["assumption"] == "no") {
				echo "X";
			} else {
				echo "&nbsp&nbsp";
			}
			?>] will not allow assumptions of this loan on the original terms
			</td>
		</tr>
		<tr>
			<td><b>Homewowner's Insurance</b></td>
			<td>
			This loan requires homeowner's insurance on the property, which the buyer may obtain from a company of his choice that the lender finds acceptable.
			</td>
		</tr>
		<tr>
			<td><b>Late Payment</b></td>
			<td>
				<?php if ($_POST["latePayment"] != "") {
					echo $_POST["latePayment"];
				} else {
					echo "______________________________________________________________________________________________________________________________________________________________________________";
				}
				?>
			</td>
		</tr>
		<tr>
			<td><b>Refinancing</b></td>
			<td>
			Refinancing this loan will depend on the buyer's future financial situation, the property value, and market conditions.  The buyer might not be able to refinance this loan. 
			</td>
		</tr>
		<tr style="border-bottom: none;">
			<td style="border-bottom: none;"><b>Servicing</b></td>
			<td style="border-bottom: none;">
				The lender intends
				<br/>
				[<?php if ($_POST["servicing"] == "yes") {
					echo "X";
				} else {
					echo "&nbsp&nbsp";
				}
				?>] to service this loan.  If so, the buyer will make payments to the lender.
				<br/>
				[<?php if ($_POST["servicing"] == "no") {
					echo "X";
				} else {
					echo "&nbsp&nbsp";
				}
				?>] will transfer servicing of this loan. 
			</td>
		</tr>
	</table>

	<br/>
	<h3>Closing Cost Details</h3>
	<hr/>

	<!--Left-->
	<div id="leftCosts">
		<p style="font-style: italic; text-align: left;">A. Origination Charges</p>
		<b>Application Fee</b>
		<?php 
			if ($_POST["appFee"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["appFee"]); 
			}
		?>		
		<br/>
		<b>Underwriting Fee</b>
		<?php 
			if ($_POST["underFee"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["underFee"]); 
			}
		?>
		<br/>

		<p style="font-style: italic; text-align: left;">B. Servcies You Cannot Shop For</p>
		<b>Appraisal Fee</b>
		<?php 
			if ($_POST["appraisalFee"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["appraisalFee"]); 
			}
		?>
		<br/>
		<b>Credit Report Fee</b>
		<?php 
			if ($_POST["creditReportFee"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["creditReportFee"]); 
			}
		?>
		<br/>
		<b>Flood Determination Fee</b>
		<?php 
			if ($_POST["floodDetFee"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["floodDetFee"]); 
			}
		?>
		<br/>
		<b>Flood Monitoring Fee</b>
		<?php 
			if ($_POST["floodMonFee"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["floodMonFee"]); 
			}
		?>
		<br/>
		<b>Tax Monitoring Fee</b>
		<?php 
			if ($_POST["taxMonFee"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["taxMonFee"]); 
			}
		?>
		<br/>
		<b>Tax Status Research Fee</b>
		<?php 
			if ($_POST["taxStatFee"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["taxStatFee"]); 
			}
		?>
		<br/>

		<p style="font-style: italic; text-align: left;">C. Servcies You Can Shop For</p>
		<b>Pest Inspection Fee</b>
		<?php 
			if ($_POST["pestFee"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["pestFee"]); 
			}
		?>
		<br/>
		<b>Survey Fee</b>
		<?php 
			if ($_POST["surveyFee"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["surveyFee"]); 
			}
		?>
		<br/>
		<b>Title -- Insurance Binder</b>
		<?php 
			if ($_POST["titleBinder"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["titleBinder"]); 
			}
		?>
		<br/>
		<b>Title -- Lender's Title Policy</b>
		<?php 
			if ($_POST["titlePolicy"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["titlePolicy"]); 
			}
		?>
		<br/>
		<b>Title -- Settlement Agent-Free</b>
		<?php 
			if ($_POST["titleSettlement"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["titleSettlement"]); 
			}
		?>
		<br/>
		<b>Title -- Title Search</b>
		<?php 
			if ($_POST["titleSearch"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["titleSearch"]); 
			}
		?>
		<br/>
	</div>

	<!--Right-->
	<div id="rightCosts">
		<p style="font-style: italic; text-align: left;">D. Total Loan Cost (A+B+C)</p>
		<b>Total</b>
		<?php 
			$dIsGood = $_POST["appFee"] != "" &&
				$_POST["underFee"] != "" &&
				$_POST["appraisalFee"] != "" &&
				$_POST["creditReportFee"] != "" &&
				$_POST["floodDetFee"] != "" &&
				$_POST["floodMonFee"] != "" &&
				$_POST["taxMonFee"] != "" &&
				$_POST["taxStatFee"] != "" &&
				$_POST["pestFee"] != "" &&
				$_POST["surveyFee"] != "" &&
				$_POST["titleBinder"] != "" &&
				$_POST["titlePolicy"] != "" &&
				$_POST["titleSettlement"] != "" &&
				$_POST["titleSearch"] != "";

			if ($dIsGood) {
					echo dollarize(dedollarize($_POST["appFee"]) +
				dedollarize($_POST["underFee"]) +
				dedollarize($_POST["appraisalFee"]) +
				dedollarize($_POST["creditReportFee"]) +
				dedollarize($_POST["floodDetFee"]) +
				dedollarize($_POST["floodMonFee"]) +
				dedollarize($_POST["taxMonFee"]) +
				dedollarize($_POST["taxStatFee"]) +
				dedollarize($_POST["pestFee"]) +
				dedollarize($_POST["surveyFee"]) +
				dedollarize($_POST["titleBinder"]) +
				dedollarize($_POST["titlePolicy"]) +
				dedollarize($_POST["titleSettlement"]) +
				dedollarize($_POST["titleSearch"]));
			} else {
				echo "______________________";
			}
		?>
		<br/>

		<p style="font-style: italic; text-align: left;">E. Taxes and Government Fees</p>
		<b>Recording Fees and Other Taxes</b>
		<?php 
			if ($_POST["recordingFee"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["recordingFee"]); 
			}
		?>
		<br/>
		<b>Transfer Taxes</b>
		<?php 
			if ($_POST["transferFee"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["transferFee"]); 
			}
		?>
		<br/>

		<p style="font-style: italic; text-align: left;">F. Prepaids</p>
		<b>Homewoner's Insurance Preium</b>
		<?php 
			if ($_POST["ownerInsurance"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["ownerInsurance"]); 
			}
		?>
		<br/>
		<b>Mortgage Insurance Preium</b>
		<?php 
			if ($_POST["mortgagePremium"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["mortgagePremium"]); 
			}
		?>
		<br/>
		<b>Prepaid Interest</b>
		<?php 
			if ($_POST["prepaidInterest"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["prepaidInterest"]); 
			}
		?>
		<br/>
		<b>Property Taxes</b>
		<?php 
			if ($_POST["propTaxes"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["propTaxes"]); 
			}
		?>
		<br/>

		<p style="font-style: italic; text-align: left;">G. Escrow Payment at Closing</p>
		<b>Homeowner's Insurance</b>
		<?php 
			if ($_POST["escrowOwner"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["escrowOwner"]); 
			}
		?>
		<br/>
		<b>Mortgage Insurance</b>
		<?php 
			if ($_POST["escrowMortgage"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["escrowMortgage"]); 
			}
		?>
		<br/>
		<b>Property Taxes</b>
		<?php 
			if ($_POST["propertyTaxes"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["propertyTaxes"]); 
			}
		?>
		<br/>

		<p style="font-style: italic; text-align: left;">H. Other</p>
		<b>Owner's Title Policy</b>
		<?php 
			if ($_POST["ownerTitle"] == "") {
				echo "______________________";
			} else {
				echo dollarize($_POST["ownerTitle"]); 
			}
		?>
		<br/>

		<p style="font-style: italic; text-align: left;">I. Total Other Costs (E + F + G + H)</p>
		<b>Total</b>
		<?php 
			 $iIsGood = $_POST["recordingFee"] != "" &&
				$_POST["transferFee"] != "" &&
				$_POST["ownerInsurance"] != "" &&
				$_POST["mortgagePremium"] != "" &&
				$_POST["prepaidInterest"] != "" &&
				$_POST["propTaxes"] != "" &&
				$_POST["escrowOwner"] != "" &&
				$_POST["escrowMortgage"] != "" &&
				$_POST["propertyTaxes"] != "";

			if ($iIsGood) {
				$sum = dedollarize($_POST["recordingFee"]) +
					dedollarize($_POST["transferFee"]) +
					dedollarize($_POST["ownerInsurance"]) +
					dedollarize($_POST["mortgagePremium"]) +
					dedollarize($_POST["prepaidInterest"]) +
					dedollarize($_POST["propTaxes"]) +
					dedollarize($_POST["escrowOwner"]) +
					dedollarize($_POST["escrowMortgage"]) +
					dedollarize($_POST["propertyTaxes"]);

				//Optional parameter
				if ($_POST["ownerTitle"] != "") {
					$sum += dedollarize($_POST["ownerTitle"]);
				}

				echo dollarize($sum);
			} else {
				echo "______________________";
			}
		?>

		<p style="font-style: italic; text-align: left;">J. Total Closing Costs</p>
		<b>D + I</b>
		<?php 
			// $dIsGood = $_POST["appFee"] != "" &&
			// 	$_POST["underFee"] != "" &&
			// 	$_POST["appraisalFee"] != "" &&
			// 	$_POST["creditReportFee"] != "" &&
			// 	$_POST["floodDetFee"] != "" &&
			// 	$_POST["floodMonFee"] != "" &&
			// 	$_POST["taxMonFee"] != "" &&
			// 	$_POST["taxStatFee"] != "" &&
			// 	$_POST["pestFee"] != "" &&
			// 	$_POST["surveyFee"] != "" &&
			// 	$_POST["titleBinder"] != "" &&
			// 	$_POST["titlePolicy"] != "" &&
			// 	$_POST["titleSettlement"] != "" &&
			// 	$_POST["titleSearch"] != "";

			// $iIsGood = $_POST["recordingFee"] != "" &&
			// 	$_POST["transferFee"] != "" &&
			// 	$_POST["ownerInsurance"] != "" &&
			// 	$_POST["mortgagePremium"] != "" &&
			// 	$_POST["prepaidInterest"] != "" &&
			// 	$_POST["propTaxes"] != "" &&
			// 	$_POST["escrowOwner"] != "" &&
			// 	$_POST["escrowMortgage"] != "" &&
			// 	$_POST["propertyTaxes"] != "";

			$jSum = 0;

			 if ($dIsGood && $iIsGood) {
			 	$jSum = dedollarize($_POST["appFee"]) +
					dedollarize($_POST["underFee"]) +
					dedollarize($_POST["appraisalFee"]) +
					dedollarize($_POST["creditReportFee"]) +
					dedollarize($_POST["floodDetFee"]) +
					dedollarize($_POST["floodMonFee"]) +
					dedollarize($_POST["taxMonFee"]) +
					dedollarize($_POST["taxStatFee"]) +
					dedollarize($_POST["pestFee"]) +
					dedollarize($_POST["surveyFee"]) +
					dedollarize($_POST["titleBinder"]) +
					dedollarize($_POST["titlePolicy"]) +
					dedollarize($_POST["titleSettlement"]) +
					dedollarize($_POST["titleSearch"]);

				$jSum += dedollarize($_POST["recordingFee"]) +
					dedollarize($_POST["transferFee"]) +
					dedollarize($_POST["ownerInsurance"]) +
					dedollarize($_POST["mortgagePremium"]) +
					dedollarize($_POST["prepaidInterest"]) +
					dedollarize($_POST["propTaxes"]) +
					dedollarize($_POST["escrowOwner"]) +
					dedollarize($_POST["escrowMortgage"]) +
					dedollarize($_POST["propertyTaxes"]);

				//Optional parameter
				if ($_POST["ownerTitle"] != "") {
					$jSum += dedollarize($_POST["ownerTitle"]);
				}

				echo dollarize($jSum);

			 } else {
				echo "______________________";
			 }
		?>
		<br/>
		<b>Lender Credits</b>
		<?php 
			if ($_POST["lenderCredits"] == "") {
				echo "______________________";
			} else {
				$jSum += dedollarize($_POST["lenderCredits"]);
				echo dollarize($_POST["lenderCredits"]); 
			}
		?>
		<br/>
	</div>

	<!--Center-->
	<div id="bottomCosts">
		<p style="font-style: italic; text-align: left;">
			<br/>
			<br/>
			<br/>
			Total Costs
		</p>
		<?php $totalCost = 0; ?>
		<b>Total Closing Costs (J) </b>
		<?php 
			if ($jSum == 0) {
				echo "______________________";
			} else {
				$totalCost += $jSum;
				echo dollarize($jSum); 
			}
		?>
		<br/>
		<b>Closing Costs Financed</b>
		<?php 
			if ($_POST["costsFinanced"] == "") {
				echo "______________________";
			} else {
				$totalCost -= dedollarize($_POST["costsFinanced"]);
				echo dollarize("-" . $_POST["costsFinanced"]); 
			}
		?>
		<br/>
		<b>Down Payment/Funds from Borrower</b>
		<?php 
			if ($_POST["downPayment"] == "") {
				echo "______________________";
			} else {
				$totalCost += dedollarize($_POST["downPayment"]);
				echo dollarize($_POST["downPayment"]); 
			}
		?>
		<br/>
		<b>Deposit</b>
		<?php 
			if ($_POST["depositPayment"] == "") {
				echo "______________________";
			} else {
				$totalCost -= dedollarize($_POST["depositPayment"]);
				echo dollarize("-" . $_POST["depositPayment"]); 
			}
		?>
		<br/>
		<b>Funds for Borrower</b>
		<?php 
			if ($_POST["borrowerFunds"] == "") {
				echo "______________________";
			} else {
				$totalCost += dedollarize($_POST["borrowerFunds"]);
				echo dollarize($_POST["borrowerFunds"]); 
			}
		?>
		<br/>
		<b>Seller Credits</b>
		<?php 
			if ($_POST["sellerCredits"] == "") {
				echo "______________________";
			} else {
				$totalCost += dedollarize($_POST["sellerCredits"]);
				echo dollarize($_POST["sellerCredits"]); 
			}
		?>
		<br/>
		<b>Adjustments and Other Credits</b>
		<?php 
			if ($_POST["otherCredits"] == "") {
				echo "______________________";
			} else {
				$totalCost -= dedollarize($_POST["otherCredits"]);
				echo dollarize("-" . $_POST["otherCredits"]); 
			}
		?>
		<br/>
		<br/>
		<span>
			<b>Total</b>
			<?php 
				$hIsGood = $jSum != 0 &&
					$_POST["costsFinanced"] != "" &&
					$_POST["downPayment"] != "" &&
					$_POST["depositPayment"] != "" &&
					$_POST["borrowerFunds"] != "" &&
					$_POST["sellerCredits"] != "" &&
					$_POST["otherCredits"] != "";

				if ($hIsGood) {
					echo dollarize($totalCost);
				} else {
					echo "______________________";
				}
			?>
		</span>
		<br/>
	</div>


<?php } ?>

<?php 
	if ($_POST["formType"] == "closingCosts") {
?>
	
	<center>
		<h2>Estimated Closing Costs Statement</h2>
	</center>
	
	<!--left header-->
	<div class="halfHeader left">
		<b>Buyer:</b>
		<?php 
			if ($_POST["buyer"] == "") {
				echo "______________________";
			} else {
				echo $_POST["buyer"];
			}
		?>
		<br/>
		
		<b>Seller:</b>
		<?php 
			if ($_POST["seller"] == "") {
				echo "______________________";
			} else {
				echo $_POST["seller"];
			}
		?>
	</div>
	
	<!--right header-->
	<div class="halfHeader right">
		<b>Date:</b>
		<?php 
			if ($_POST["date"] == "") {
				echo "______________________";
			} else {
				echo $_POST["date"];
			}
		?>
		<br/>
		
		<b>Property Address:</b>
		<?php 
			if ($_POST["address"] == "") {
				echo "______________________";
			} else {
				echo $_POST["address"];
			}
		?>
	</div>
	
	<hr/>
	
	<!--Big table-->
	<table id="bigtable">
		<tr>
			<th>Charge Title</th>
			<th>Debit</th>
			<th>Credit</th>
		</tr>
		<tr>
			<td>Cost of Property</td>
			<td></td>
			<td>
				<?php 
					if ($_POST["cost"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["cost"]);
					}
				?>
			</td>
		</tr>
		<tr>
			<td>Taxes</td>
			<td>
				<?php 
					if ($_POST["taxes"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["taxes"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		<tr>
			<td>Comission Paid to Buyer's Agent</td>
			<td>
				<?php 
					if ($_POST["seller"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["buyerComission"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		<tr>
			<td>Comission Paid to Listing Agent</td>
			<td>
				<?php 
					if ($_POST["listingComission"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["listingComission"]); 
					}
				?>	
			</td>
			<td></td>
		</tr>
		<tr class="spacingRow">
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td class="blockTitle">Payoff Loan:</td>
			<td></td>
			<td></td>
		</tr>
			<td>Principal Balance</td>
			<td>
				<?php 
					if ($_POST["loanPrincipal"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["loanPrincipal"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		</tr>
			<td>Interest on Payoff</td>
			<td>
				<?php 
					if ($_POST["loanInterest"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["loanInterest"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		</tr>
			<td>Statement/Forwarding Fee</td>
			<td>
				<?php 
					if ($_POST["loanStatement"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["loanStatement"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		</tr>
			<td>Reconveyance Fee</td>
			<td>
				<?php 
					if ($_POST["loanReconveyance"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["loanReconveyance"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		</tr>
			<td>Recording Fee</td>
			<td>
				<?php 
					if ($_POST["loanRecording"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["loanRecording"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		</tr>
			<td>Wire Fee</td>
			<td>
				<?php 
					if ($_POST["loanWire"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["loanWire"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		<tr class="spacingRow">
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td class="blockTitle">Title/Escrow Charges:</td>
			<td></td>
			<td></td>
		</tr>
		</tr>
			<td>Notary Fee</td>
			<td>
				<?php 
					if ($_POST["escrowNotary"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["escrowNotary"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		</tr>
			<td>Wire Transfer Fee</td>
			<td>
				<?php 
					if ($_POST["escrowWire"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["escrowWire"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		</tr>
			<td>County Documentary Transfer Tax</td>
			<td>
				<?php 
					if ($_POST["escrowCounty"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["escrowCounty"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		</tr>
			<td>Record Order of Approval</td>
			<td>
				<?php 
					if ($_POST["escrowRecord"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["escrowRecord"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		<tr class="spacingRow">
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td class="blockTitle">Disbursements Paid:</td>
			<td></td>
			<td></td>
		</tr>
		</tr>
			<td>Required Invoice</td>
			<td>
				<?php 
					if ($_POST["disInvoice"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["disInvoice"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		</tr>
			<td>Reimbursements</td>
			<td>
				<?php 
					if ($_POST["disRe"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["disRe"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		</tr>
			<td>Escrow Coordination Fee</td>
			<td><?php ; ?>
				<?php 
					if ($_POST["disCoordination"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["disCoordination"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		<tr class="spacingRow">
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Payment to Seller</td>
			<td>
				<?php 
					if ($_POST["paidToSeller"] == "") {
						echo "";
					} else {
						echo dollarize($_POST["paidToSeller"]);
					}
				?>
			</td>
			<td></td>
		</tr>
		<tr class="spacingRow">
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td><center>Totals</center></td>
			<?php if (!isset($_POST["leaveSumBlank"])) { ?>
				<td id="debitTotal" onload="calcDebit()"></td>
				<td id="creditTotal"></td>
			<?php } else { ?>
				<td></td>
				<td></td>
			<?php } ?> 
		</tr>
	</table>

	
<?php } ?>

<?php if ($_POST["formType"] == "salesContract") { ?>
	<center>
		<h1>Purcahse and Sale Agreement</h1>
	</center>
	
	<!--left header-->
	<div class="halfHeader left">
		<b>Buyer:</b> 
		<?php 
			if ($_POST["buyer"] == "") {
				echo "______________________";
			} else {
				echo $_POST["buyer"]; 
			}
		?>
		<br/>
		
		<b>Seller:</b> 
		<?php 
			if ($_POST["seller"] == "") {
				echo "______________________";
			} else {
				echo $_POST["seller"]; 
			}
		?>
	</div>
	
	<!--right header-->
	<div class="halfHeader right">
		<b>Date:</b> 
		<?php 
			if ($_POST["date"] == "") {
				echo "______________________";
			} else {
				echo $_POST["date"]; 
			}
		?>
		<br/>
		
		<b>Property Address:</b> 
		<?php 
			if ($_POST["address"] == "") {
				echo "______________________";
			} else {
				echo $_POST["address"]; 
			}
		?>
	</div>
	
	<hr/>
	
	<p>For mutual consideration received, the undersigned buyer hereby agrees to purchase and the undersigned seller hereby agrees to sell the real property stated herein with all improvements and subject to all easements, covenants, restrictions, and reservations of record:
	</p>
	
	<p>1. PURCHASE PRICE: The purchase price to be paid by the buyer shall be<br/>
	<?php 
		if ($_POST["price"] == "") {
			echo "______________________";
		} else {
			echo dollarize($_POST["price"]);
		}
	?>
	</p>
	
	<p>2. DEPOSIT: Buyer has tendered to the seller, escrow agent, or other appropriate party 
	
	<?php 
		if ($_POST["deposit"] == "") {
			echo "______________________";
		} else {
			echo dollarize($_POST["deposit"]);
		}
	?>
	, as a binder deposit/purchase deposit/earnest money deposit (which shall apply toward the purchase price) to bind this contract. If the binder deposit check is rejected by the financial institution upon which it is drawn, the seller may cancel this contract immediately. If the buyer defaults under the terms of this contract, the binder deposit shall be surrendered to the seller as liquidated damages, and not as penalty. If the buyer exercises any right stated below (or declared by law) to cancel this contract, the binder deposit shall be returned to the buyer within five (5) calendar days
	</p>
	
	<p>3. FINANCING:<br/>
	[<?php if ($_POST["financing"] == "cash") {
		echo "X";
	} else {
		echo "&nbsp&nbsp";
	}
	?>] The buyer is paying cash for the property.<br/>
	[<?php if ($_POST["loan"] == "loan") {
		echo "X";
	} else {
		echo "&nbsp&nbsp";
	}
	?>] The buyer is obtaining a loan/mortgage.<br/>
	Not later than
	<?php 
		if ($_POST["financeDays"] == "") {
			echo "____";
		} else {
			echo $_POST["financeDays"];
		}
	?>
	calendar days from the date this contract is fully endorsed (signed by all parties), the buyer shall provide the seller with proof of funds (if paying cash) or a lender's letter of pre-approval (if obtaining a loan). If the buyer does not provide the seller with such documentation, the seller shall have the right to cancel this contract, resulting in a return of the binder deposit to the buyer within five (5) calendar days.
	</p>
	
	<p>4. APPRAISAL:<br/>
	[<?php if ($_POST["appraisal"] == "notReq") {
		echo "X";
	} else {
		echo "&nbsp&nbsp";
	}
	?>] No appraisal is required or desired.<br/>

	[<?php if ($_POST["appraisal"] == "req") {
		echo "X";
	} else {
		echo "&nbsp&nbsp";
	}
	?>] The buyer (and/or buyer's lender) shall have 
	<?php 
		if ($_POST["appraisalDays"] == "") {
			echo "____";
		} else {
			echo $_POST["appraisalDays"];
		}
	?>
	calendar days (unless otherwise declared by law) from the date this contract is fully endorsed, to have an appraisal performed by a licensed/certified appraiser. If the contract purchase price exceeds the appraised value, the buyer shall have the right to cancel this contract. If the appraisal is not completed before the expiration of the time frame stated herein (or declared by law), the seller shall have the right to cancel this contract, resulting in a return of the binder deposit to the buyer.
	</p>
	
	<p>5. INSPECTION & REPAIRS:<br/>

	[<?php if ($_POST["inspection"] == "notReq") {
		echo "X";
	} else {
		echo "&nbsp&nbsp";
	}
	?>] The buyer accepts the property as is, where is, and with all faults.<br/>

	[<?php if ($_POST["inspection"] == "req") {
		echo "X";
	} else {
		echo "&nbsp&nbsp";
	}
	?>] The buyer shall have
	<?php 
		if ($_POST["inspectionDays"] == "") {
			echo "____";
		} else {
			echo $_POST["inspectionDays"];
		}
	?>
	calendar days (unless otherwise declared by law) from the date this contract is fully endorsed, to have professional inspections performed by licensed/certified inspectors or contractors. Inspection of the property may include, but is not limited to, general home inspection, survey, structural, termite, wood infestation, fungus, septic/sewer, mold, radon, and lead-based paint hazards. If the buyer does not present the seller any professional inspection reports identifying defective conditions before the expiration of the time frame stated herein (or declared by law), the property shall be consider in acceptable condition and the repair requirement below shall not apply.
	<br/> 
	<br/>
	Provided it will not exceed a cost of
	<?php 
		if ($_POST["sellerInspectionLimit"] == "") {
			echo "_______________________________________";
		} else {
			echo dollarize($_POST["sellerInspectionLimit"]);
		}
	?>
	, the seller agrees to correct/repair the defective condition(s) reported in any such professional inspection reports. If correction/repair of such defective condition(s) exceeds the amount stated herein and the parties cannot reach an agreement addressing such repair(s) to the satisfaction of the buyer, the buyer shall have the option to accept the property "as is" or cancel this contract.
		
	<p>6. IS A LEAD-BASED PAINT DISCLOSURE & PAMPHLET REQUIRED:<br/>
	<?php if ($_POST["lead"] == "req") echo "[X]YES"; else echo "[&nbsp&nbsp]YES";?> <br/>
	<?php if ($_POST["lead"] == "notReq") echo "[X]NO"; else echo "[&nbsp&nbsp]NO";?> <br/>
	This disclosure and pamphlet are federally mandated for properties built prior to 1978.</p>

	<p>7. PERSONAL PROPERTY: The following personal property shall be included in the sale in its "as is" condition:
	<br/>
	<?php 
		if ($_POST["inclProp"] == "") {
			echo "_______________________________________";
		} else {
			echo $_POST["inclProp"];
		}
	?>
	</p>
	
	<p>8. CLOSING: Closing shall be on or before
	<?php 
		if ($_POST["closingDate"] == "") {
			echo "_______________________________________";
		} else {
			echo $_POST["closingDate"];
		}
	?>
	.</p>

	
	<p>9. POSSESSION:<br/>
	[<?php if ($_POST["delivery"] == "atClosing") {
		echo "X";
	} else {
		echo "&nbsp&nbsp";
	}
	?>] Possession shall be delivered at closing.<br/>

	[<?php if ($_POST["delivery"] == "viaOA") {
		echo "X";
	} else {
		echo "&nbsp&nbsp";
	}
	?>] The buyer and seller will reach an accord on an occupancy agreement, detailing the terms for delivery of possession.
	</p>
	
	<p>10. MERCHANTABLE TITLE: At closing, the seller shall convey good and merchantable title via general warranty or other appropriate deed. The seller shall make all reasonable efforts to provide merchantable title. In the event that the title is unmerchantable, this contract shall be deemed canceled, resulting in a return of the binder deposit to the buyer within five (5) calendar days.
	</p>
	
	<p>11. TITLE INSURANCE: Title Insurance (or other "title evidence") to be issued in the form of:
	<br/>
	[<?php if(isset($_POST['MTI'])) echo "X"; else echo "&nbsp&nbsp"; ?>] Mortgagee Title Insurance<br/>
	[<?php if(isset($_POST['OTI'])) echo "X"; else echo "&nbsp&nbsp"; ?>] Owner's Title Insurance<br/>
	[<?php if(isset($_POST['OI'])) echo "X"; else echo "&nbsp&nbsp"; ?>] Other: <?php echo $_POST["otherInsurance"]; ?>
	</p>
	
	<p>12. SELLER'S CLOSING COST: The seller shall pay the following expenses relating to the closing of this transaction:
	
	<?php 
		if ($_POST["sellerCost"] == "") {
			echo "_______________________________________";
		} else {
			echo dollarize($_POST["sellerCost"]);
		}
	?>
	</p>
	
	<p>13. BUYER'S CLOSING COST: The buyer shall pay the following expenses relating to the closing of this transaction:
	<?php 
		if ($_POST["buyerCost"] == "") {
			echo "_______________________________________";
		} else {
			echo dollarize($_POST["buyerCost"]);
		}
	?>
	</p>
	
	<p>14. PRORATION: Property taxes, valorem taxes, association fees, and the like, shall be prorated at the time of closing.
	</p>
	
	<p style="word-wrap: break-word;">15. ADDITIONAL PROVISIONS: 
	
	<?php 
		if ($_POST["etc"] == "") {
			echo "____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________";
		} else {
			echo $_POST["etc"];
		}
	?>
	</p>
	
	<p>16. RISK OF LOSS: The seller agrees to keep hazard insurance on the structure until the sale of the property has been completed as provided herein.
	</p>
	
	<p>17. NO ASSIGNMENT: The buyer may not assign or transfer their rights or obligations under this contract or any interest herein.
	</p>
	
	<p>18. FAILURE TO INSIST ON STRICT PERFORMANCE: Party does not give up rights. If either party fails to enforce any clause or part of this contract, said party may enforce such clauses or parts at a later time without penalty.
	</p>
	
	<p>19. RIGHTS DECLARED BY LAW: If there is any conflict between this contract and any provisions of federal, state, or local laws, the rights declared by such law shall control, supersede and be superior to this contract.
	</p>
	
	<p>20. SEVERABILITY: If any portion of this contract is found to be invalid or unenforceable, the remainder of this contract will remain in full force and effect.
	</p>
	
	<p>21. ENTIRE AGREEMENT: This contract and any attachments signed by both parties constitute the entire agreement between buyer and seller and supersede all prior discussions, negotiations, and agreements between the buyer and the seller. Neither the buyer nor the seller (nor agent thereof) shall be bound by any understanding, agreement, promise, or representation, either expressed or implied, that is not specified in this contract or signed attachments.
	</p>
	
	<p>IF THIS DOCUMENT IS NOT CLEAR TO ANY PARTY, SEEK LEGAL ADVICE BEFORE SIGNING.</p>
	
	<p>
	<table>
	<tr>
		<td class="noBorder">Seller's Signature:</td>
		<td class="noBorder">_______________________________________</td>
	</tr>
	<tr>
		<td class="noBorder">Date:</td>
		<td class="noBorder">_______________________________________</td>
	</tr>
	</table>
	</p>
	
	<p>
	<table>
	<tr>
		<td class="noBorder">Buyer's Signature:</td>
		<td class="noBorder">_______________________________________</td>
	</tr>
	<tr>
		<td class="noBorder">Date:</td>
		<td class="noBorder">_______________________________________</td>
	</tr>
	</table>
	</p>
	
	
	<?php } ?>

	<?php if ($_POST["formType"] == "repairRequest") { ?>

	<center>
		<h1>Request for Repairs</h1>
	</center>

	<!--left side-->
	<div class="halfHeader left">
		<b>Tenant:</b> 
		<?php 
			if ($_POST["tenant"] == "") {
				echo "______________________";
			} else {
				echo $_POST["tenant"]; 
			}
		?>
		<br/>
		
		<b>Address:</b> 
		<?php 
			if ($_POST["tenantAddress"] == "") {
				echo "______________________";
			} else {
				echo $_POST["tenantAddress"]; 
			}
		?>
		<br/>

		<b>Home Telephone:</b> 
		<?php 
			if ($_POST["tenantResTele"] == "") {
				echo "__________________";
			} else {
				echo phoneNumberize($_POST["tenantResTele"]); 
			}
		?>
		<br/>

		<b>Business Telephone:</b> 
		<?php 
			if ($_POST["tenantBusTele"] == "") {
				echo "__________________";
			} else {
				echo phoneNumberize($_POST["tenantBusTele"]); 
			}
		?>
	</div>
	
	<!--right side-->
	<div class="halfHeader right">
		<b>Landlord:</b> 
		<?php 
			if ($_POST["landlord"] == "") {
				echo "______________________";
			} else {
				echo $_POST["landlord"]; 
			}
		?>
		<br/>
		
		<b>Address:</b> 
		<?php 
			if ($_POST["landlordAddress"] == "") {
				echo "______________________";
			} else {
				echo $_POST["landlordAddress"]; 
			}
		?>
		<br/>

		<b>Home Telephone:</b> 
		<?php 
			if ($_POST["landlordResTele"] == "") {
				echo "__________________";
			} else {
				echo phoneNumberize($_POST["landlordResTele"]); 
			}
		?>
		<br/>

		<b>Business Telephone:</b> 
		<?php 
			if ($_POST["landlordBusTele"] == "") {
				echo "__________________";
			} else {
				echo phoneNumberize($_POST["landlordBusTele"]);
			}
		?>
	</div>

	<hr/>

	<p>The tenant hereby requests attention towards the following issues with the property:</p>

	<!--TODO: Add JSON parser here-->

	<p style="word-wrap: break-word;">1.______________________________________________________________________________________________________________________________________________________________________________</p>
	<p style="word-wrap: break-word;">2.______________________________________________________________________________________________________________________________________________________________________________</p>
	<p style="word-wrap: break-word;">3.______________________________________________________________________________________________________________________________________________________________________________</p>
	<p style="word-wrap: break-word;">4.______________________________________________________________________________________________________________________________________________________________________________</p>
	<p style="word-wrap: break-word;">5.______________________________________________________________________________________________________________________________________________________________________________</p>
	<p style="word-wrap: break-word;">6.______________________________________________________________________________________________________________________________________________________________________________</p>
	<p style="word-wrap: break-word;">7.______________________________________________________________________________________________________________________________________________________________________________

	<p>
		<table>
			<tr>
				<td class="noBorder">Tenant's Signature:</td>
				<td class="noBorder">_______________________________________</td>
			</tr>
			<tr>
				<td class="noBorder">Date:</td>
				<td class="noBorder">
				<?php 
					if ($_POST["date"] == "") {
						echo "_______________________________________";
					} else {
						echo $_POST["date"]; 
					}
				?>
				</td>
			</tr>
		</table>
	</p>

	<?php } ?>
</body>