<style>
	.pagerlist {
		position: relative;
		/* Sets positioning context for absolute elements inside */
		padding: 20px;
		height: 80px;
		background-color: #f9f9f9;
	}

	.pagerlist {
		position: relative;
		/* Sets positioning context for absolute elements inside */
		padding: 20px;
		height: 80px;
		background-color: #f9f9f9;
	}

	.toplist-left-btn {
		position: absolute;
		top: 10px;
		/* Distance from the top */
		left: 10px;
		/* Distance from the left */
		padding: 5px 10px;
		/* background-color: #007bff; */
		color: white;
		border: none;
		border-radius: 5px;
		cursor: pointer;
	}

	.toplist-center {
		position: absolute;
		top: 50%;
		/* Vertically centers the button */
		left: 50%;
		/* Horizontally centers the button */
		transform: translate(-50%, -50%);
		/* Adjusts for button size */
		padding: 5px 15px;
		color: white;
		border: none;
		border-radius: 5px;
		cursor: pointer;
	}

	.toplist-right-btn {
		position: absolute;
		top: 10px;
		/* Distance from the top */
		right: 10px;
		/* Distance from the right */
		padding: 5px 10px;
		/* background-color: #28a745; */
		color: white;
		border: none;
		border-radius: 5px;
		cursor: pointer;
	}

	.topplist-right {
		position: absolute;
		top: 10px;
		/* Distance from the top */
		right: 10px;
		/* Distance from the right */
		padding: 5px 10px;
		/* background-color: #28a745; */
		color: white;
		border: none;
		border-radius: 5px;
		cursor: pointer;
	}

	.table-wrapperlist {
		overflow: hidden;
		/* Hide the default scrollbar */
		white-space: nowrap;
		max-width: 100%;
		/* Adjust based on your needs */
		margin-bottom: 10px;
		top: 0;
		left: 0;
		right: 0;
		height: 10px;
		background: rgb(38, 57, 77) 0px 20px 30px -10px;
		/* Ensure it doesn't interfere with content */
		z-index: 10;
	}

	.queryholderquota {
		width: 33%;
		margin-right: 5px;
		background-color: #FFF;
	}

	.queryholderlinks {
		width: 33%;
		position: absolute;
		background-color: #fff;
		color: #aaa;
		max-height: 300px;
		overflow-y: scroll;
		border-radius: 5px;
		padding: 10px;
		top: 90%;
		box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
		display: none;
	}

	.optionlink {
		text-align: left;
		border-bottom: solid 1px #eee;
		padding: 5px;
	}

	.optionlink:hover {
		background-color: #eee;
	}

	#userDropdownlist {
		max-height: 300px;
		overflow-y: scroll;
		overflow-x: hidden;
	}

	.no-resultslist {
		text-align: center;
		/* Center horizontally */
		vertical-align: middle;
		/* Center vertically */
		height: 20px;
		/* Set a minimum height to ensure centering */
		border: none;
	}

	.no-resultslist img {
		position: relative;
		top: 100px;

	}

	/* Custom Scrollbar for Webkit Browsers */
	.table-wrapperfinance::-webkit-scrollbar {
		width: 5px;
		/* Slimmer scrollbar width */
		height: 5px;
		/* Slimmer scrollbar height for horizontal scrolling */
	}

	.table-wrapperfinance::-webkit-scrollbar-track {
		background: #f1f1f1;
		/* Lighter background for track */
		border-radius: 5px;
	}

	.table-wrapperfinance::-webkit-scrollbar-thumb {
		background-color: #ccc;
		/* Blue color for thumb */
		border-radius: 10px;
		cursor: pointer;
	}

	.table-wrapperfinance::-webkit-scrollbar-thumb:hover {
		background-color: #aaa;
		/* Darker blue on hover */
	}

	.editable {
		/* cursor: pointer; */
		background-color: #f9f9f9;
	}

	.editable:focus {
		outline: 1px solid #ccc;
		background-color: #fff;
		/* Optional: Make it stand out */
	}

	.financeDropdowns {
    /* width: 23%; */
    position: absolute;
    background-color: #fff;
    color: #aaa;
    max-height: 300px;
    overflow-y: scroll;
    border-radius: 5px;
    padding: 10px;
    top: 90%;
    z-index: 9999;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    display: none;
  }

	.financeDropdown {
    width: 23%;
    position: absolute;
    background-color: #fff;
    color: #aaa;
    max-height: 300px;
    overflow-y: scroll;
    border-radius: 5px;
    padding: 10px;
    top: 90%;
    z-index: 9999;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    display: none;
  }

  .queryholderlistt {
    width: 29%;
    margin-right: 5px;
    background-color: #FFF;
  }

  /* Style for the scrollbar */
  .financeDropdown::-webkit-scrollbar {
    width: 3px;
    /* Width of the scrollbar */
  }

  .financeDropdown::-webkit-scrollbar-track {
    background: #f0f0f0;
    /* Background of the scrollbar track */
    border-radius: 5px;
    /* Rounded corners */
  }

  .financeDropdown::-webkit-scrollbar-thumb {
    background: #ccc;
    /* Color of the scrollbar handle */
    border-radius: 5px;
    /* Rounded corners */
  }

  .financeDropdown::-webkit-scrollbar-thumb:hover {
    background: #aaa;
    /* Darker handle color on hover */
  }

</style>

<div class="card w-100 position-relative overflow-hidden">

	<div class="px-4 py-3 border-bottom">
		<h4 class="card-title mb-0">Finance Fund Changes</h4>
	</div>

	<div class="px-4 py-3 border-bottom pagerlist">
		<span class="top-left-btn">
			<div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding:5px;width:auto">
          
        <input type="text" id="financeDropdown" class="form-control queryholderlistt usernames" placeholder="Search usernames">
        <input name ="usernames" type="hidden" class="userIdfinance">
        <select  class="form-control financeDropdown" size="5" style="display: none;">
          <!-- Options will be populated dynamically -->
        </select>

    

        <select name="betsate" class="form-control form-select queryholderlistt depositestate "
          data-bs-placeholder="Select Type">
          <option value="">-State-</option>
          <option value="1">Deposit</option>
          <option value="4">Withdrawal</option>
      
        </select>


        <input  name ="startdate" type="date" class="form-control queryholderlistt startfinance"  aria-describedby="name"
          placeholder="Name" />


        <input  name ="enddate" type="date" class="form-control queryholderlistt endfinance"  aria-describedby="name"
          placeholder="Name" />

            </div>
			<!-- <div class="input-group mb-3">
				<span class="input-group-text" id="basic-addon12" style="background-color:rgb(238,238,238,.4);border:solid 1px #ddd"><i class='bx bx-search' style="font-size:18px;"></i></span>
				<input type="text" class="form-control queryholder userrebate" placeholder="Enter Rebate (%)" aria-label="Username" aria-describedby="basic-addon1" />
			</div> -->
			

		</span>
		<span class="toplist-center" aria-label=" navigation example">
			<!--enter is free-->
		</span>
		<span class="topplist-right" id="paginations" aria-label="Page navigation example">

			<div class="btn-group mb-2" role="group" aria-label="Basic example"
				style="border:solid 1px #eee;color:#bbb;background-color:#fff">
				<!-- <i ' ></i> -->
				<button type="button" class="btn bg-white-subtle player" value="right" aria-label="Refresh"
					data-bs-toggle="modal" data-bs-target="#addfinancemodal" data-bs-placement="top" data-bs-title="deposite/withdrawal">
					<i class='bx bx-plus' style="font-size:20px"></i>
				</button>

				<button type="button" class="btn bg-white-subtle player refreshfiance" value="right" aria-label="Refresh"
					data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
					<i class='bx bx-refresh' style="font-size:20px"></i>
				</button>
				<button type="button" class="btn bg-white-subtle executefinance" value="end" aria-label="Execute"
					data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
					<i class='bx bx-check-double loaderfinance' style="font-size:20px"></i>
				</button>
			</div>

		</span>

	</div>

	<div class="card-body p-4">
		<div class="table-responsive mb-4 border rounded-1 table-wrapperfinance" id="maskfinance" style="height:530px;overflow-y:scroll;">
			<table class="table text-nowrap mb-0 align-middle table-bordered">
				<thead class="text-dark fs-4">
					<tr>

						<th>
							<h6 class="fs-4 fw-semibold mb-0">Username</h6>
						</th>
						<th>
							<h6 class="fs-4 fw-semibold mb-0">Level</h6>
						</th>
						<th>
							<h6 class="fs-4 fw-semibold mb-0"> Deposit/Withdrawal Type</h6>
						</th>
						<th>
							<h6 class="fs-4 fw-semibold mb-0">Transaction Amount</h6>
						</th>
						<th>
							<h6 class="fs-4 fw-semibold mb-0">Balance</h6>
						</th>
						<th>
							<h6 class="fs-4 fw-semibold mb-0">Transaction Time</h6>
						</th>
						<th>
							<h6 class="fs-4 fw-semibold mb-0">Reviews</h6>
						</th>
						<!-- <th>
                            <h6 class="fs-4 fw-semibold mb-0">Deposit Time</h6>
                        </th> -->
						<!-- <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class='bx bx-dots-vertical-rounded'></i></h6>
                        </th> -->
					</tr>
				</thead>
				<tbody id="financeContainer">

					<tr class="no-resultslist">
						<td colspan="9">
							<img src="<?php echo BASE_URL; ?>assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark" />
						</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
	<div class="px-4 py-3 border-top pagerlist">
		<span class="toplist-left-btn">
			<div class="btn-group mb-2" role="group" aria-label="Basic example"
				style="border:solid 1px #eee;color:#bbb;background-color:#fff">
				<button type="button" class="btn bg-white-subtle playerlinks" value="startlinks">
					<i class='bx bx-chevrons-left' style="font-size:20px"></i>
				</button>
				<button type="button" class="btn bg-white-subtle playerquota" value="leftlinks">
					<i class='bx bx-chevron-left' style="font-size:20px"></i>
				</button>
				<button type="button" class="btn bg-white-subtle playerquota" value="rightlinks">
					<i class='bx bx-chevron-right' style="font-size:20px"></i>
				</button>
				<button type="button" class="btn bg-white-subtle playerquota" value="endlinks">
					<i class='bx bx-chevrons-right' style="font-size:20px"></i>
				</button>
			</div>
		</span>
		<span class="toplist-center" aria-label=" navigation example">

			<span id="paging_infofinance" style="color:#aaa">---</span>

		</span>
		<span class="toplist-right" id="paginationfiance" aria-label="Page navigation example">

			<!--Dynamic pagination-->

		</span>

	</div>

</div>

<div class="modal fade" id="danger-finance" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content modal-filled " style="background-color:#F9F9F9">
			<div class="modal-body p-4">
				<div class="text-center text-danger">
					<i class="ti ti-hexagon-letter-x fs-7"></i>
					<h4 class="mt-2">Oh snap!</h4>
					<p class="mt-3" style="color:#aaa">
						All fields are required!
						Select one or more data fields to filter.
					</p>
					<button type="button" class="btn my-2" data-bs-dismiss="modal" style="background-color:#ddd">
						Okay
					</button>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>


<!-- Modal -->
<div id="addfinancemodal" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<!-- Modal Header -->
				<div class="text-center mt-2 mb-4">
					<div class="d-flex justify-content-between align-items-center">
						<div>Deposit/Withrawal</div>
						<i class="bx bx-message-square-x listclose" style="color:#868c87;font-size:25px;cursor:pointer;"></i>
					</div>
				</div>

				<!-- Form -->
				<form>


					<!-- Username Field -->
					<!-- Rebate Field -->
					<div class="form-floating mb-3">
						<select name="deposit" class="form-select form-control border border-infos depositt">
							<option value="1">Deposit</option>
							<option value="4">Withdrawal</option>
						</select>
						<label>
							<i class="bx bx-list-ul me-2 fs-4 text-infos"></i>
							<span class="border-start  ps-3">deposit/withrawal types</span>
						</label>
					</div>

					<div class="form-floating mb-3">
						<input type="text" id="financeinput" class="form-control" placeholder="Search usernames">
						<input type="hidden" class="userIdFields">
						<select name="usernames" class="form-control financeDropdowns" size="5" style="display: none;">
							<!-- Options will be populated dynamically -->
						</select>

						<label>
							<i class="bx bx-user me-2 fs-4 text-infod"></i>
							<span class="border-start  ps-3">Username</span>
						</label>
					</div>

					<div class="form-floating mb-3">
						<input name="agentname" type="text" class="form-control border amount" placeholder="Username" />
						<label>
							<i class="bx bx-money me-2 fs-4 text-infod"></i>
							<span class="border-start  ps-3">Enter Amount</span>
						</label>
					</div>

					<div class="form-floating mb-3">
						<input name="agentname" type="text" class="form-control border review" placeholder="Username" />
						<label>
							<i class="bx bx-message me-2 fs-4 text-infod"></i>
							<span class="border-start  ps-3">Reviews</span>
						</label>
					</div>


					<!-- Submit Button -->
					<div class="d-md-flex align-items-center">
						<div class="form-check">
							<!-- <input type="checkbox" class="form-check-input" id="sf2" value="check" /> -->
							<label class="form-check-label" for="sf2">Verify before submit</label>
						</div>
						<div class="mt-3 mt-md-0 ms-auto">
							<button type="button" class="btn hstack gap-6 addmoneybtn" style="border:solid 1px #ccc">
								<i class="bx bx-send loaderfinance"></i>
								Submit
							</button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
	<!-- /.modal-dialog -->
</div>