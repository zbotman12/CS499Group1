<?php 
	//Paperwork
	//Nick Diliberti
	//May 2017

	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";

	function getPrice($MLS) {
		$listings = DBTransactorFactory::build("Listings");
		$ListingArray = $listings->select(["*"], ["MLS_number" => $MLS]);
		$ListingArray[$MLS]["price"] = str_replace("$", "", $ListingArray[$MLS]["price"]);
		$ListingArray[$MLS]["price"] = number_format($ListingArray[$MLS]["price"]);
		return $ListingArray[$MLS]["price"];
    }

    function getAddress($MLS) {
    	$listings = DBTransactorFactory::build("Listings");
		$ListingArray = $listings->select(["*"], ["MLS_number" => $MLS]);
		return $ListingArray[$MLS]["address"] . ", " . $ListingArray[$MLS]["zip"] ;
    }
?>

<!--TODO: Add number of grievances to request for repairs-->

<head>
	<title>Paperwork</title>
</head>
<body>
	<?php include "Helpers/header.php"; ?>
	
	<!--Header-overriding styling + scripts-->
	<style>
		label {
			width: 50%;
		}
		
		label + .radio-inline {
			margin-left: 0;
		}

		label > p {
			font-weight: normal;
			display: inline;
			margin-left: 5px;
		}

		.radio-inline {
			display: inline !important;
		}

		h4 {
			text-decoration: underline;
		}

		.sumCheckbox {
			display: inline;
		}
	</style>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script>
		$(document).ready(function() {
			//Set togglers
			$('.toggler').bind('click', function(){
				$(this).html($(this).html() == 'Collapse Form' ? 'Expand Form' : 'Collapse Form');
			});

			//Set datepickers
			$('.datepicker').datepicker();

			//Set element disablers
			$("label[for='financing']").next().click(function(){
				$("input[name='financeDays']").prop('disabled', true);
				$("input[name='financeDays']")[0].value = "";
			});
			$("label[for='financing']").next().next().click(function(){
				$("input[name='financeDays']").prop('disabled', false);
			});
			$("label[for='appraisal']").next().click(function(){
				$("input[name='appraisalDays']").prop('disabled', true);
				$("input[name='appraisalDays']")[0].value = "";
			});
			$("label[for='appraisal']").next().next().click(function(){
				$("input[name='appraisalDays']").prop('disabled', false);
			});
			$("label[for='inspection']").next().click(function(){
				$("input[name='inspectionDays']").prop('disabled', true);
				$("input[name='inspectionDays']")[0].value = "";
				$("input[name='sellerInspectionLimit']").prop('disabled', true);
				$("input[name='sellerInspectionLimit']")[0].value = "";
			});
			$("label[for='inspection']").next().next().click(function(){
				$("input[name='inspectionDays']").prop('disabled', false);
				$("input[name='sellerInspectionLimit']").prop('disabled', false);
			});
		});
	</script>
	
	<div class="container-fluid">
	
		<h2>Paperwork Utility</h2>
		<hr/>
		
		<p>The following forms will generate paperwork based on the information you give.  Leaving a field blank will leave it as a write-in entry in the document.</p>

		<h3>Buyer Estimated Closing Costs</h3>
		<button name="BECCtoggle" type="button" class="btn btn-info toggler" data-toggle="collapse" data-target="#BECC">
			Expand Form
		</button>
		<div id = "BECC" class="collapse container-fluid">
			<form name="BECCForm" action="/paperworkUtility.php" method="post">
				<div class="form-group col-lg-6">
					<label for="date">Date</label>
					<input name="date" class="datepicker"/>
					<br/>
				
					<label for="buyer">Buyer Name(s): </label>
					<input name="buyer" placeholder="John Smith"/>
					<br/>

					<label for="address">Property Address</label>
					<input name="address" placeholder="123 Main Street" value=
					<?php 
						echo "\"";
						if((isset($_GET["MLS"]))) {
							echo getAddress(($_GET["MLS"]));
						}
						echo "\"";
					?>
					/>
					<br/>

					<label for="cost">Cost of Property</label>
					<input name="cost" placeholder="$100,000"/ value=
					<?php 
						echo "\"";
						if((isset($_GET["MLS"]))) {
							echo getPrice(($_GET["MLS"]));
						}
						echo "\"";
					?>
					/>
					<br/>

					<br/>
					<h4>Loan</h4>

					<label for="loanTerm">Loan Term</label>
					<input name="loanTerm" placeholder="30 years"/>
					<br/>

					<label for="loanPurpose">Loan Purpose</label>
					<input name="loanPurpose" placeholder="Purchase"/>
					<br/>

					<label for="loanType">Interest Type</label>
					<input name="loanType" placeholder="Fixed Rate"/>
					<br/>

					<label for="loanArchetype">Loan Type</label>
					<label class="radio-inline"><input type="radio" name="loanArchetype" value="Conventional">Conventional</label>
					<label class="radio-inline"><input type="radio" name="loanArchetype" value="FHA">FHA</label>
					<label class="radio-inline"><input type="radio" name="loanArchetype" value="VA">VA</label>
					<br/>

					<label for="loanID">Loan ID#</label>
					<input name="loanID" placeholder="123456789"/>
					<br/>

					<label for="rateLock">Rate Lock</label>
					<input name="rateLock" placeholder="Until April 1st"/>
					<br/>

					<label for="loanAmmount">Loan Ammount</label>
					<input name="loanAmmount" placeholder="$"/>
					<br/>

					<label for="interestRate">Interest Rate</label>
					<input name="interestRate" placeholder="%"/>
					<br/>

					<label for="monthlyPrincipal">Monthly Principal & Interest</label>
					<input name="monthlyPrincipal" placeholder="$"/>
					<br/>

					<label for="prepayment">Prepayment Penalty</label>
					<input name="prepayment" placeholder="$3,000 if paid off during the first 2 years"/>
					<br/>

					<label for="balloonPayment">Balloon Payment</label>
					<input name="balloonPayment" placeholder=""/>
					<br/>

					<br/>
					<h4>Projected Monthly Payments</h4>

					<label for="pincialAndInterest">Principal & Interest</label>
					<input name="pincialAndInterest" placeholder="$"/>
					<br/>

					<label for="mortgageInsurance">Mortgage Insurance</label>
					<input name="mortgageInsurance" placeholder="$"/>
					<br/>

					<label for="etimEscrow">Estimated Escrow</label>
					<input name="etimEscrow" placeholder="$"/>
					<br/>

					<label for="taxesEtc">Taxes, Insurance, and Assessments</label>
					<input name="taxesEtc" placeholder="$200 Per Month"/>
					<br/>

					<br/>
					<h4>Closing Costs</h4>

					<br/>
					<p style="font-style: italic;">Origination Charges</p>
					<label for="appFee">Application Fee</label>
					<input name="appFee" placeholder="$"/>
					<br/>
					<label for="underFee">Underwriting Fee</label>
					<input name="underFee" placeholder="$"/>
					<br/>

					<br/>
					<p style="font-style: italic;">Servcies You Cannot Shop For</p>
					<label for="appraisalFee">Appraisal Fee</label>
					<input name="appraisalFee" placeholder="$"/>
					<br/>
					<label for="creditReportFee">Credit Report Fee</label>
					<input name="creditReportFee" placeholder="$"/>
					<br/>
					<label for="floodDetFee">Flood Determination Fee</label>
					<input name="floodDetFee" placeholder="$"/>
					<br/>
					<label for="floodMonFee">Flood Monitoring Fee</label>
					<input name="floodMonFee" placeholder="$"/>
					<br/>
					<label for="taxMonFee">Tax Monitoring Fee</label>
					<input name="taxMonFee" placeholder="$"/>
					<br/>
					<label for="taxStatFee">Tax Status Research Fee</label>
					<input name="taxStatFee" placeholder="$"/>
					<br/>

					<br/>
					<p style="font-style: italic;">Services You Can Shop For</p>
					<label for="pestFee">Pest Inspection Fee</label>
					<input name="pestFee" placeholder="$"/>
					<br/>
					<label for="surveyFee">Survey Fee</label>
					<input name="surveyFee" placeholder="$"/>
					<br/>
					<label for="titleBinder">Title -- Insurance Binder</label>
					<input name="titleBinder" placeholder="$"/>
					<br/>
					<label for="titlePolicy">Title -- Lender's Title Policy</label>
					<input name="titlePolicy" placeholder="$"/>
					<br/>
					<label for="titleSettlement">Title -- Settlement Agent-Free</label>
					<input name="titleSettlement" placeholder="$"/>
					<br/>
					<label for="titleSearch">Title -- Title Search</label>
					<input name="titleSearch" placeholder="$"/>
					<br/>

					<br/>
					<p style="font-style: italic;">Taxes and Government Fees</p>
					<label for="recordingFee">Recording Fees and Other Taxes</label>
					<input name="recordingFee" placeholder="$"/>
					<br/>
					<label for="transferFee">Transfer Taxes</label>
					<input name="transferFee" placeholder="$"/>
					<br/>

					<br/>
					<p style="font-style: italic;">Prepaids</p>
					<label for="ownerInsurance">Homewoner's Insurance Preium</label>
					<input name="ownerInsurance" placeholder="$"/>
					<br/>
					<label for="mortgagePremium">Mortgage Insurance Preium</label>
					<input name="mortgagePremium" placeholder="$"/>
					<br/>
					<label for="prepaidInterest">Prepaid Interest</label>
					<input name="prepaidInterest" placeholder="$"/>
					<br/>
					<label for="propTaxes">Property Taxes</label>
					<input name="propTaxes" placeholder="$"/>
					<br/>

					<br/>
					<p style="font-style: italic;">Escrow Payment at Closing</p>
					<label for="escrowOwner">Homeowner's Insurance</label>
					<input name="escrowOwner" placeholder="$"/>
					<br/>
					<label for="escrowMortgage">Mortgage Insurance</label>
					<input name="escrowMortgage" placeholder="$"/>
					<br/>
					<label for="propertyTaxes">Property Taxes</label>
					<input name="propertyTaxes" placeholder="$"/>
					<br/>

					<br/>
					<p style="font-style: italic;">Other</p>
					<label for="ownerTitle">Owner's Title Policy</label>
					<input name="ownerTitle" placeholder="$"/>
					<br/>

					<label for="lenderCredits">Lender Credits</label>
					<input name="lenderCredits" placeholder="$"/>
					<br/>

					<br/>
					<p style="font-style: italic;">Payments Made</p>
					<label for="costsFinanced">Closing Costs Financed</label>
					<input name="costsFinanced" placeholder="$"/>
					<br/>
					<label for="downPayment">Down Payment/Funds From Borrower</label>
					<input name="downPayment" placeholder="$"/>
					<br/>
					<label for="depositPayment">Deposit</label>
					<input name="depositPayment" placeholder="$"/>
					<br/>
					<label for="borrowerFunds">Funds for Borrower</label>
					<input name="borrowerFunds" placeholder="$"/>
					<br/>
					<label for="sellerCredits">Seller Credits</label>
					<input name="sellerCredits" placeholder="$"/>
					<br/>
					<label for="otherCredits">Adjustments and Other Credits</label>
					<input name="otherCredits" placeholder="$"/>
					<br/>

					<br/>
					<h4>Other Considerations</h4>

					<label for="assumption">Assumption</label>
					<label class="radio-inline"><input type="radio" name="assumption" value="yes">Under Certain Conditions</label>
					<label class="radio-inline"><input type="radio" name="assumption" value="no">No</label>
					<br/>

					<label for="latePayment">Late Payment</label>
					<input name="latePayment" placeholder="5% of monthly principal"/>
					<br/>

					<label for="servicing">Servicing</label>
					<label class="radio-inline"><input type="radio" name="servicing" value="yes">By Lender</label>
					<label class="radio-inline"><input type="radio" name="servicing" value="no">By Other</label>
					<br/>

					<br/>
					<input type="submit" value="Generate Form" class="btn btn-default"/>
					<input type="reset" value="Reset Fields" class="btn btn-default"/>
					<input name="formType" value="buyerClosingCosts" type="hidden"/>
				</div>
			</form>
		</div>

		<h3>Seller Estimated Closing Costs</h3>
		<!--TODO: jQ toggle text on click-->
		<button name="ECCtoggle" type="button" class="btn btn-info toggler" data-toggle="collapse" data-target="#ECC">
			Expand Form
		</button>
		<div id = "ECC" class="collapse container-fluid"> 
			<form name="SCform" action="/paperworkUtility.php" method="post">
				<div class="form-group col-lg-6">
				
					<label for="date">Date</label>
					<input name="date" class="datepicker"/>
					<br/>
				
					<!--TODO: Pull this from MLS-->
					<label for="address">Property Address</label>
					<input name="address" placeholder="123 Main Street" value=
					<?php 
						echo "\"";
						if((isset($_GET["MLS"]))) {
							echo getAddress(($_GET["MLS"]));
						}
						echo "\"";
					?>
					/>
					<br/>
					
					<label for="seller">Seller Name(s)</label>
					<input name="seller" placeholder="Nick Diliberti"/>
					<br/>
					
					<label for="buyer">Buyer Name(s): </label>
					<input name="buyer" placeholder="John Smith"/>
					<br/>
					
					<!--TODO: Pull from MLS-->
					<label for="cost">Cost of Property</label>
					<input name="cost" placeholder="$100,000" value=
					<?php 
						echo "\"";
						if((isset($_GET["MLS"]))) {
							echo getPrice(($_GET["MLS"]));
						}
						echo "\""
					?>
					/>
					<br/>
					
					<label for="taxes">Taxes</label>
					<input name="taxes" placeholder="$"/>
					<br/>
					
					<label for="buyerComission">Comission paid to buyer's agent</label>
					<input name="buyerComission" placeholder="$"/>
					<br/>
					
					<label for="listingComission">Comission paid to listing agent</label>
					<input name="listingComission" placeholder="$"/>
					<br/>

					<label for="paidToSeller">Ammount paid to seller</label>
					<input name="paidToSeller" placeholder="$"/>
					<br/>
					
					<br/>
					<h4>Payoff Loan</h4>
					
					<label for="loanPrincipal">Principal Balance</label>
					<input name="loanPrincipal" placeholder="$"/>
					<br/>
					
					<label for="loanInterest">Interest on Payoff</label>
					<input name="loanInterest" placeholder="$"/>
					<br/>
					
					<label for="loanStatement">Statement/Forwarding Fee</label>
					<input name="loanStatement" placeholder="$"/>
					<br/>
					
					<label for="loanReconveyance">Reconveyance Fee</label>
					<input name="loanReconveyance" placeholder="$"/>
					<br/>
					
					<label for="loanRecording">Recording Fee</label>
					<input name="loanRecording" placeholder="$"/>
					<br/>
					
					<label for="loanWire">Wire Fee</label>
					<input name="loanWire" placeholder="$"/>
					<br/>
					
					<br/>
					<h4>Title/Escrow Charges</h4>
					
					<label for="escrowNotary">Notary Fee</label>
					<input name="escrowNotary" placeholder="$"/>
					<br/>
					
					<label for="escrowWire">Wire Transfer Fee</label>
					<input name="escrowWire" placeholder="$"/>
					<br/>
					
					<label for="escrowCounty">County Documentary Transfer Tax</label>
					<input name="escrowCounty" placeholder="$"/>
					<br/>
					
					<label for="escrowRecord">Record Order of Approval</label>
					<input name="escrowRecord" placeholder="$"/>
					<br/>
					
					<br/>
					<h4>Disbursements Paid</h4>
					
					<label for="disInvoice">Required Invoice</label>
					<input name="disInvoice" placeholder="$"/>
					<br/>
					
					<label for="disRe">Reimbursements</label>
					<input name="disRe" placeholder="$"/>
					<br/>
					
					<label for="disCoordination">Escrow Coordination Fee</label>
					<input name="disCoordination" placeholder="$"/>
					<br/>
					<!-- 
					<br/>
					<h4>Additional Fees</h4> -->

					<!-- TODO: Add JS way to add arbitrary additional fees then JSON it
					<p style="font-style: italic;">Under development</p>
					<br/> -->

					<label for="">Leave Sum Fields Blank</label>
					<label class="sumCheckbox"><input type="checkbox" name ="leaveSumBlank"></label>
					<br/>
					<br/>
					
					<input type="submit" value="Generate Form" class="btn btn-default"/>
					<input type="reset" value="Reset Fields" class="btn btn-default"/>
					<input name="formType" value="closingCosts" type="hidden"/>
				</div>
			</form>
		</div>
		<br/>
		
		<h3>Sales Contract</h3>
		<!--TODO: jQ toggle text on click-->
		<button name="SCtoggle" type="button" class="btn btn-info toggler" data-toggle="collapse" data-target="#SC">
			Expand Form
		</button>
		<div id = "SC" class="collapse container-fluid"> 
			<form name="SCform" action="/paperworkUtility.php" method="post">
				<div class="form-group col-lg-6">
					
					<br/>
					<h4>Subjects</h4>

					<!--TODO: Dynamic value based on current date-->
					<label for="date">Date</label>
					<input name="date" class="datepicker"/>
					<br/>
					
					<!--TODO: Pull this from MLS-->
					<label for="address">Property Address</label>
					<input name="address" placeholder="123 Main Street" value=
					<?php 
						echo "\"";
						if((isset($_GET["MLS"]))) {
							echo getAddress(($_GET["MLS"]));
						}
						echo "\"";
					?>
					/>
					<br/>
					
					<label for="seller">Seller Name(s)</label>
					<input name="seller" placeholder="Nick Diliberti"/>
					<br/>
					
					<label for="buyer">Buyer Name(s): </label>
					<input name="buyer" placeholder="John Smith"/>
					<br/>
					
					
					<br/>
					<h4>Pricing</h4>

					<!--TODO: Dynamic value based on MLS-->
					<label for="price">Purchase Price</label>
					<input name="price" placeholder="$100,000"/>
					<br/>
					
					<label for="deposit">Deposit</label>
					<input name="deposit" placeholder="$10,000"/>
					<br/>
					
					<label for="sellerCost">Seller's Closing Cost</label>
					<input name="sellerCost" placeholder="$1,000"/>
					<br/>
					
					<label for="buyerCost">Buyer's Closing Cost</label>
					<input name="buyerCost" placeholder="$1,000"/>
					<br/>
					
					<label for="financing">Financing</label>
					<label class="radio-inline"><input type="radio" name="financing" value="cash">Cash</label>
					<label class="radio-inline"><input type="radio" name="financing" value="loan">Loan/Mortgage</label>
					<br/>
					
					<label for="financeDays">Days until proof of funds required</label>
					<input name="financeDays" placeholder="7"/>
					<br/>
					
					<br/>
					<h4>Posession</h4>

					<label for="delivery">Delivery</label>
					<label class="radio-inline"><input type="radio" name="delivery" value="atClosing">At Closing</label>
					<label class="radio-inline"><input type="radio" name="delivery" value="viaOA">Via  Agreement</label>
					<br/>
					
					<br/>
					<h4>Repairs</h4>

					<label for="appraisal">Appraisal</label>	
					<label class="radio-inline"><input type="radio" name="appraisal" value="notReq">Not Required</label>
					<label class="radio-inline"><input type="radio" name="appraisal" value="req">Required</label>
					<br/>
					
					<!--TODO: Disable when not required-->
					<label for="appraisalDays">Days until appraisal required</label>
					<input name="appraisalDays" placeholder="7"/>
					<br/>
					
					<label for="inspection">Inspection & Repairs</label>	
					<label class="radio-inline"><input type="radio" name="inspection" value="notReq">As-Is</label>
					<label class="radio-inline"><input type="radio" name="inspection" value="req">Required</label>
					<br/>
					
					<!--TODO: Disable when not required-->
					<label for="inspectionDays">Days until inspection required</label>
					<input name="inspectionDays" placeholder="7"/>
					<br/>
					
					<!--TODO: Disable when not required-->
					<label for="sellerInspectionLimit">Maximum seller will pay for repairs</label>
					<input name="sellerInspectionLimit" placeholder="$1,000"/>
					<br/>
					
					
					<br/>
					<h4>Insurance</h4>

					<label for="">Title Insurance</label>
					<label><input type="checkbox" name ="MTI"><p>Mortgagee Title Insurance</p></label>
					<label><input type="checkbox" name ="OTI"><p>Owner's Title Insurance</p></label>
					<label><input type="checkbox" name ="OI"><p>Other</p></label>
					<br/>
					
					<!--TODO: Disable when not required-->
					<label for="otherInsurance">Other insurance</label>
					<input name="otherInsurance" placeholder="ABC Insurance..."/>
					<br/>

					<br/>
					<h4>Other</h4>

					<label for="lead">Lead-based paint disclosure</label>
					<label class="radio-inline"><input type="radio" name="lead" value="req">Required</label>
					<label class="radio-inline"><input type="radio" name="lead" value="notReq">Not Required</label>
					<br/>
					
					<label for="inclProp">Personal Property Included</label>
					<input name="inclProp" placeholder="Refrigerator..."/>
					<br/>
					
					<label for="closingDate">Closing Date</label>
					<input name="closingDate" class="datepicker"/>
					<br/>
					
					<label for="etc">Additional Provisions</label>
					<input name="etc" placeholder="None"/>
					<br/>
					<br/>
					
					<input type="submit" value="Generate Contract" class="btn btn-default"/>
					<input type="reset" value="Reset Fields" class="btn btn-default"/>
					<input name="formType" value="salesContract" type="hidden"/>
					<br/>
				</div>
			</form>
		</div>
		
		<h3>Request for Repairs</h3>
		<button name="RfRtoggle" type="button" class="btn btn-info toggler" data-toggle="collapse" data-target="#RfR">
			Expand Form
		</button>
		<div id = "RfR" class="collapse container-fluid"> 
			<form name="RfRform" action="/paperworkUtility.php" method="post">
				<div class="form-group col-lg-6">
				
					<label for="landlord">Landlord's Name</label>
					<input name="landlord" placeholder="John Doe"/>
					<br/>
					
					<label for="landlordAddress">Landlord's Address</label>
					<input name="landlordAddress" placeholder="123 Main Street"/>
					<br/>
					
					<label for="landlordResTele">Landlord's Residence Telephone</label>
					<input name="landlordResTele" placeholder="615-555-5555"/>
					<br/>
					
					<label for="landlordBusTele">Landlord's Business Telephone</label>
					<input name="landlordBusTele" placeholder="615-555-5555"/>
					<br/>
					
					<label for="tenant">Tenant's Name</label>
					<input name="tenant" placeholder="Bob Smith"/>
					<br/>
					
					<label for="tenantAddress">Tenant's Address</label>
					<input name="tenantAddress" placeholder="321 Side Street" value=
					<?php 
						echo "\"";
						if((isset($_GET["MLS"]))) {
							echo getAddress(($_GET["MLS"]));
						}
						echo "\"";
					?>
					/>
					<br/>
					
					<label for="tenantResTele">Tenant's Residence Telephone</label>
					<input name="tenantResTele" placeholder="615-555-5555"/>
					<br/>
					
					<label for="tenantBusTele">Tenant's Business Telephone</label>
					<input name="tenantBusTele" placeholder="615-555-5555"/>
					<br/>
					
					<label for="date">Date</label>
					<input name="date" class="datepicker"/>
					<br/>
					
					<!--TODO: Add JS way to add arbitrary additional fees then JSON it-->
					<!-- <label for="">Requests</label>
					<p style="font-style: italic;">Under development</p>
					<br/>
					<br/> -->
					
					<input type="submit" value="Generate Request" class="btn btn-default"/>
					<input type="reset" value="Reset Fields" class="btn btn-default" />
					<input name="formType" value="repairRequest" type="hidden"/>
				</div>
			</form>
		</div>
	</div>
	<br/>
	<?php include "Helpers/footer.php"; ?>
</body>