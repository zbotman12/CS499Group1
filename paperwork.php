<?php 
?>

<head>
	<!--TODO: Get info from MLS-->
	<!--TODO: Add JS form validation-->
	<!--TODO: Save in-progress to cookies?-->
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
	</style>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script>
		$(document).ready(function() {
			$('.toggler').bind('click', function(){
				$(this).html($(this).html() == 'Collapse Form' ? 'Expand Form' : 'Collapse Form');
			});
			$('.datepicker').datepicker();
		});
	</script>
	
	<div class="container-fluid">
	
		<h2>Paperwork Utility</h2>
		<hr/>
		
		<h3>Estimated Closing Costs</h3>
		<!--TODO: jQ toggle text on click-->
		<button name="ECCtoggle" type="button" class="btn btn-info toggler" data-toggle="collapse" data-target="#ECC">
			Expand Form
		</button>
		<div id = "ECC" class="collapse container-fluid"> 
			<form name="SCform" action="/paperworkUtility.php" method="post">
				<div class="form-group col-lg-6">
				
					<label for="date">Date:</label>
					<input name="date" class="datepicker"/>
					<br/>
				
					<!--TODO: Pull this from MLS-->
					<label for="address">Property Address:</label>
					<input name="address" placeholder="123 Main Street"/>
					<br/>
					
					<label for="seller">Seller Name(s):</label>
					<input name="seller" placeholder="Nick Diliberti"/>
					<br/>
					
					<label for="buyer">Buyer Name(s): </label>
					<input name="buyer" placeholder="John Smith"/>
					<br/>
					
					<!--TODO: Pull from MLS-->
					<label for="cost">Cost of Property:</label>
					<input name="cost" placeholder="$100,000"/>
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
					
					<br/>
					<h4>Payoff Loan</h4>
					<br/>
					
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
					<br/>
					
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
					<br/>
					
					<label for="disInvoice">Required Invoice</label>
					<input name="disInvoice" placeholder="$"/>
					<br/>
					
					<label for="disRe">Reimbursements</label>
					<input name="disRe" placeholder="$"/>
					<br/>
					
					<label for="disCoordination">Escrow Coordination Fee</label>
					<input name="disCoordination" placeholder="$"/>
					<br/>
					
					<br/>
					<h4>Additional Fees</h4>
					<br/>
					
					<!--TODO: Add JS way to add arbitrary additional fees then JSON it-->
					<p style="font-style: italic;">Under development</p>
					<br/>
					<br/>
					
					<input type="submit" value="Generate Form" class="btn btn-default"/>
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
					
					<!--TODO: Dynamic value based on current date-->
					<label for="date">Date:</label>
					<input name="date" class="datepicker"/>
					<br/>
					
					<!--TODO: Pull this from MLS-->
					<label for="address">Property Address:</label>
					<input name="address" placeholder="123 Main Street"/>
					<br/>
					
					<!--TODO: Figure out what this is-->
					<!--
					<label for="legDesc">Legal Description:</label>
					<input name="legDesc" placeholder=""/>
					<br/>
					-->
					
					<label for="seller">Seller Name(s):</label>
					<input name="seller" placeholder="Nick Diliberti"/>
					<br/>
					
					<label for="buyer">Buyer Name(s): </label>
					<input name="buyer" placeholder="John Smith"/>
					<br/>
					
					<!--TODO: Dynamic value based on MLS-->
					<label for="price">Purchase Price:</label>
					<input name="price" placeholder="$100,000"/>
					<br/>
					
					<label for="deposit">Deposit:</label>
					<input name="deposit" placeholder="$10,000"/>
					<br/>
					
					<label for="financing">Financing (select one):</label>
					<label class="radio-inline"><input type="radio" name="financing" value="cash">Cash</label>
					<label class="radio-inline"><input type="radio" name="financing" value="loan">Loan/Mortgage</label>
					<br/>
					
					<label for="financeDays">Days until proof of funds required:</label>
					<input name="financeDays" placeholder="7"/>
					<br/>
					
					<label for="appraisal">Appraisal (select one):</label>	
					<label class="radio-inline"><input type="radio" name="appraisal" value="notReq">Not Required</label>
					<label class="radio-inline"><input type="radio" name="appraisal" value="req">Required</label>
					<br/>
					
					<!--TODO: Disable when not required-->
					<label for="appraisalDays">Days until appraisal required:</label>
					<input name="appraisalDays" placeholder="7"/>
					<br/>
					
					<label for="inspection">Inspection & Repairs (select one):</label>	
						<label class="radio-inline"><input type="radio" name="inspection" value="notReq">As-Is</label>
						<label class="radio-inline"><input type="radio" name="inspection" value="req">Required</label>
					<br/>
					
					<!--TODO: Disable when not required-->
					<label for="inspectionDays">Days until inspection required:</label>
					<input name="inspectionDays" placeholder="7"/>
					<br/>
					
					<!--TODO: Disable when not required-->
					<label for="sellerInspectionLimit">Maximum seller will pay for repairs:</label>
					<input name="sellerInspectionLimit" placeholder="$1,000"/>
					<br/>
					
					<label for="lead">Lead-based paint disclosure (select one):</label>
					<label class="radio-inline"><input type="radio" name="lead" value="req">Required</label>
					<label class="radio-inline"><input type="radio" name="lead" value="notReq">Not Required</label>
					<br/>
					
					<label for="inclProp">Personal Property Included:</label>
					<input name="inclProp" placeholder="Refrigerator..."/>
					<br/>
					
					<!--TODO: Add date picker-->
					<!--TODO: Dynamic value based on today-->
					<label for="closingDate">Closing Date</label>
					<input name="closingDate" class="datepicker"/>
					<br/>
					
					<label for="">Title Inisurance (select all that apply)</label>
					<label><input type="checkbox" name ="MTI">Mortgagee Title Insurance</label>
					<label><input type="checkbox" name ="OTI">Owner's Title Insurance</label>
					<label><input type="checkbox" name ="OI">Other</label>
					<br/>
					
					<!--TODO: Disable when not required-->
					<label for="otherInsurance">Other insurance:</label>
					<input name="otherInsurance" placeholder="ABC Insurance..."/>
					<br/>
					
					<label for="sellerCost">Seller's Closing Cost:</label>
					<input name="sellerCost" placeholder="$1,000"/>
					<br/>
					
					<label for="buyerCost">Buyer's Closing Cost</label>
					<input name="buyerCost" placeholder="$1,000"/>
					<br/>
					
					<label for="etc">Additional Provisions:</label>
					<input name="etc" placeholder="None"/>
					<br/>
					<br/>
					
					<input type="submit" value="Generate Contract" class="btn btn-default"/>
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
				
					<label for="">Landlord's Name:</label>
					<input name="" placeholder="John Doe"/>
					<br/>
					
					<label for="">Landlord's Address:</label>
					<input name="" placeholder="123 Main Street"/>
					<br/>
					
					<label for="">Landlord's Residence Telephone:</label>
					<input name="" placeholder="615-555-5555"/>
					<br/>
					
					<label for="">Landlord's Business Telephone:</label>
					<input name="" placeholder="615-555-5555"/>
					<br/>
					
					<label for="">Tenant's Name:</label>
					<input name="" placeholder="Bob Smith"/>
					<br/>
					
					<label for="">Tenant's Address:</label>
					<input name="" placeholder="321 Side Street"/>
					<br/>
					
					<label for="">Tenant's Residence Telephone:</label>
					<input name="" placeholder="615-555-5555"/>
					<br/>
					
					<label for="">Tenant's Business Telephone:</label>
					<input name="" placeholder="615-555-5555"/>
					<br/>
					
					<label for="">Date:</label>
					<input name="" class="datepicker"/>
					<br/>
					
					<!--TODO: Add JS way to add arbitrary additional fees then JSON it-->
					<label for="">Requests:</label>
					<p style="font-style: italic;">Under development</p>
					<br/>
					<br/>
					
					<input type="submit" value="Generate Request" class="btn btn-default"/>
					<input name="formType" value="repairRequest" type="hidden"/>
				</div>
			</form>
		</div>
	</div>
	<br/>
	
	<?php include "Helpers/footer.php"; ?>
</body>