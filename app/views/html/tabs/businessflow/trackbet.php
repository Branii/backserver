<style>
    .pagerlist {
        position: relative;
        /* Sets positioning context for absolute elements inside */
        padding: 20px;
        height: 80px;
        background-color: #f9f9f9;
    }

    .pagerlist1 {
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

    .table-wrappertrack {
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

    .queryholderlist {
        width: 19%;
        margin-right: 5px;
        background-color: #FFF;
    }

    .queryholderxxt {
        width: 19%;
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

    .queryholderxxt .optionlist {
        text-align: left;
        border-bottom: solid 1px #eee;
        padding: 5px;
    }

    .optionlist:hover {
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
    .table-wrappertrack::-webkit-scrollbar {
        width: 5px;
        /* Slimmer scrollbar width */
        height: 5px;
        /* Slimmer scrollbar height for horizontal scrolling */
    }

    .table-wrappertrack::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Lighter background for track */
        border-radius: 5px;
    }

    .table-wrappertrack::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Blue color for thumb */
        border-radius: 10px;
        cursor: pointer;
    }

    .table-wrappertrack::-webkit-scrollbar-thumb:hover {
        background-color: #aaa;
        /* Darker blue on hover */
    }

    .scrollable-container {
        max-height: 600px;
        /* Limit the container's height */
        overflow-y: auto;
        /* Enable vertical scrolling */
        overflow-x: hidden;
        /* Disable horizontal scrolling */
        padding: 10px;
        /* Optional padding for readability */
        /* border: 1px solid #ddd; */
        /* Optional: Add a border */
        background-color: #fff;
    }

    /* Customize the scrollbar */
    .scrollable-container::-webkit-scrollbar {
        width: 5px;
        /* Set scrollbar width */
    }

    .scrollable-container::-webkit-scrollbar-thumb {
        background-color: #888;
        /* Set thumb color */
        border-radius: 10px;
        /* Rounded corners for the thumb */
    }

    .scrollable-container::-webkit-scrollbar-thumb:hover {
        background-color: #555;
        /* Darker color on hover */
    }

    .scrollable-container::-webkit-scrollbar-track {
        background-color: #f1f1f1;
        /* Track background color */
        border-radius: 10px;
        /* Rounded corners for the track */
    }


 .tbl-trackhead {
    position: sticky;
    top: 0;
  }

  .sticky-trackhead {
    position: relative;
    bottom: 1px;
    background-color: red;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
  }
  .trackerhead {
    position: sticky;
    top: 0;
  }

  .sticky-trackerhead {
    position: relative;
    bottom: 1px;
    background-color: red;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
  }
  
  .trackdown {
        width: 19%;
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

    /* Style for the scrollbar */
    .trackdown::-webkit-scrollbar {
        width: 3px;
        /* Width of the scrollbar */
    }

    .trackdown::-webkit-scrollbar-track {
        background: #f0f0f0;
        /* Background of the scrollbar track */
        border-radius: 5px;
        /* Rounded corners */
    }

    .trackdown::-webkit-scrollbar-thumb {
        background: #ccc;
        /* Color of the scrollbar handle */
        border-radius: 5px;
        /* Rounded corners */
    }

    .trackdown::-webkit-scrollbar-thumb:hover {
        background: #aaa;
        /* Darker handle color on hover */
    }

    .custom-dropdown {
        position: relative;
        /* width: 20%; */
        /* max-width: 300px; */
        /* margin: 0 auto; */
    }

    .custom-dropdown select {
        width: 100%;
    }

    .custom-dropdown::after {
        position: absolute;
        /* right: 10px; */
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none; /* Prevent interaction with the arrow */
        font-size: 14px;
        color: #777;
    }

    .custom-dropdown select::-webkit-scrollbar {
        width: 3px; /* Width of the scrollbar */
    }

    .custom-dropdown select::-webkit-scrollbar-thumb {
        background: #ccc;
        /* Color of the scrollbar handle */
        border-radius: 5px;
        /* Rounded corners */
    }

    .custom-dropdown select::-webkit-scrollbar-thumb:hover {
        background: #aaa;
    }

    .custom-dropdown select::-webkit-scrollbar-track {
        background: #f0f0f0;
        /* Background of the scrollbar track */
        border-radius: 5px;
        /* Rounded corners */
    }

    .scrollable-container {
        max-height: 600px;
        /* Limit the container's height */
        overflow-y: auto;
        /* Enable vertical scrolling */
        overflow-x: hidden;
        /* Disable horizontal scrolling */
        padding: 10px;
        /* Optional padding for readability */
        /* border: 1px solid #ddd; */
        /* Optional: Add a border */
        background-color: #fff;
    }

    /* Customize the scrollbar */
    .scrollable-container::-webkit-scrollbar {
        width: 5px;
        /* Set scrollbar width */
    }

    .scrollable-container::-webkit-scrollbar-thumb {
        background-color: #888;
        /* Set thumb color */
        border-radius: 10px;
        /* Rounded corners for the thumb */
    }

    .scrollable-container::-webkit-scrollbar-thumb:hover {
        background-color: #555;
        /* Darker color on hover */
    }

    .scrollable-container::-webkit-scrollbar-track {
        background-color: #f1f1f1;
        /* Track background color */
        border-radius: 10px;
        /* Rounded corners for the track */
    }

    .arr {
        color: #909aa9;
        margin: 0px 1rem;
    }

</style>

<div class="card w-100 position-relative overflow-hidden">

    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"><?= $translator['Track Records']; ?></h4>
    </div>

    <div class="px-4 py-3 border-bottom pagerlist1">
        <span class="top-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding:5px;width:auto">

                <input type="text" id="trackinput" class="form-control queryholderlist usernames" placeholder="<?= $translator['Search Username']; ?>" />
                    <input name="usernames" type="hidden" class="userIdbet" />
                    <select class="form-control trackdown" size="5" style="display: none;" id="usertrackDropdown">
                        <!-- Options will be populated dynamically -->
                    </select>
                    <input name="usernames"  class="form-control queryholderlist clearitem"  id="trackcode" placeholder="<?=$translator['Search Track Id']?>"/>
                   <select name="recharge" class="form-control form-select queryholderlist trackstatus"
                    data-bs-placeholder="Select Type">
                    <option value="">-<?=$translator['Track Status']?>-</option>
                    <option value="1"><?= $translator['Running'];?></option>
                    <option value="2"><?= $translator['Self Stop Track'];?></option>
                    <option value="3"><?= $translator['Completed'];?></option>
                    <option value="4"><?= $translator['Stop If Win'];?></option>
                    <option value="5"><?= $translator['Stop If Not Win'];?></option>
                   </select>

                    <select name="lotteryname" class="form-control form-select queryholderlist tracklotery selectlottery" data-bs-placeholder="Select Type">

                    </select>

                   <select name="lotteryname" class="form-control form-select queryholderlist selectpartner"> 

                   </select>

                <input type="date" class="form-control queryholderlist startdatetrack"  aria-describedby="name"
                    placeholder="Name" />


                <input type="date" class="form-control queryholderlist enddatetrack"  aria-describedby="name"
                    placeholder="Name" />

            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topplist-right" id="paginations" aria-label="Page navigation example">

            <div class="btn-group mb-2" role="group" aria-label="Basic example"
                style="border:solid 1px #eee;color:#bbb;background-color:#fff">

                <!-- <button type="button" class="btn bg-white-subtle addagents" value="end" aria-label="Get Top Agent"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add Agent">
                    <i class='bx bxs-user-plus' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle gettopagent" value="end" aria-label="Get Top Agent"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Get Top Agent">
                    <i class='bx bxs-user-account' style="font-size:20px"></i>
                </button> -->
                <button type="button" class="btn bg-white-subtle player refreshtrack" value="right" aria-label="Refresh"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class='bx bx-refresh' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle executetrack" value="end" aria-label="Execute"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class='bx bx-check-double loadertrack' style="font-size:20px"></i>
                </button>

            </div>

        </span>

    </div>

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrappertrack" id="masktrack" style="height:530px;overflow-y:scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered table-hover">
                <thead class="text-dark fs-4 tbl-trackhead">
                    <tr class ="trackheadrow">
                    <th>
                    <h6 class="fs-4 fw-semibold mb-0">
                    <?= $translator['Tracking ID']; ?></h6>
                  </th>
                  <th>
                    <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Username'];?></h6>
                  </th>
                  <th>
                    <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Lottery Type'];?></h6>
                  </th>
                  <th>
                    <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Start Issue']; ?></h6>
                  </th>
                  <th>
                    <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Tracked/Total Issues']; ?></h6>
                  </th>
                  <th>
                    <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Bet Amount/Total Bet Amount']; ?></h6>
                  </th>
                 
                  <th>
                    <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Win/Loss']; ?></h6>
                  </th>
                  <th>
                    <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Track Rule']; ?></h6>
                  </th>
                  <th>
                    <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Time Zone/Hrs']; ?></h6>
                  </th>
                  <th>
                    <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Track Status']; ?></h6>
                  </th>
                
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0"><i class='bx bx-dots-vertical-rounded'></i></h6>
                    </th>
                    </tr>
                </thead>
                <tbody id="trackdataContainer">

                    <tr class="no-resultslist">
                        <td colspan="9">
                        <img src="<?php echo BASE_URL; ?>assets/images/notfound.png" class="dark-logo" alt="Logo-Dark" />
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
                <!-- <button type="button" class="btn bg-white-subtle playertrack" value="trackstart">
                    <i class='bx bx-chevrons-left' style="font-size:20px"></i>
                </button> -->
                <button type="button" class="btn bg-white-subtle playertrack" value="trackleft">
                    <i class='bx bx-chevron-left' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playertrack" value="trackright">
                    <i class='bx bx-chevron-right' style="font-size:20px"></i>
                </button>
                <!-- <button type="button" class="btn bg-white-subtle playertrack" value="trackend">
                    <i class='bx bx-chevrons-right' style="font-size:20px"></i>
                </button> -->
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <span id="paging_infotrack" style="color:#aaa">---</span>
        </span>
        <span class="top-right-btn" aria-label="Page navigation example">
            <select class="left-element form-control numrowstrack" style="font-size: 12px;">
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="500">500</option>
            </select>
            <span class="toplist-right" id="paginationtrack" aria-label="Page navigation example">
            <!--Dynamic pagination-->
            </span>
           
        </span>
       

    </div>

</div>



<!--manage user Quota -->

<div id="viewtrackmodal" class="modal fade" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-body">
     

        <div class="text-center mt-2 mb-4">
          <div class="d-flex justify-content-between">
            <div><?= $translator['Track Bet Info']; ?></div>
            <div><i class='bx bx-message-square-x tclose' style='color:#868c87;font-size:25px;cursor:pointer;' data-bs-dismiss="modal" aria-label="Close"></i></div>
          </div>
        </div>
        <div class="scrollable-container">
        <form>
          <div class="row">
            <div class="col-md-6">
              <table class="table table-bordered table-striped"> 
                <tbody id="rowtrack">
                </tbody>
              </table>
            </div>

            <div class="col-md-6">
              <table class="table table-bordered table-striped">
                <tbody id="rowtrack1">
                </tbody>
              </table>
            </div>

          </div>
        </form>
      <hr>
        <table class="table table-hover table-bordered text-nowrap mb-0 trackertable" id="track">
					<thead class="trackerhead">
						<tr class="trackerheasrow">
							<!-- <th class="font-weight-normal">#</th> -->
							<th class="font-weight-normal"><?=$translator['Draw Results']?></th>
							<th class="font-weight-normal"><?=$translator['Issue Number']?></th>
							<th class="font-weight-normal"><?=$translator['Multiplier']?></th>
							<th class="font-weight-normal"><?=$translator['Bet Amount']?></th>
							<th class="font-weight-normal"><?=$translator['Progress']?></th>
							<th class="font-weight-normal"><?=$translator['Track Status']?></th>

						</tr>
					</thead>
					<tbody id='trackbetTableBody'>

					</tbody>
					<!-- <td></td>
					<tr>
						<td colspan="3"></td>
						<td colspan="2"></td>
						<td colspan="">Total: <span class="totalBetAmountDisplay" style='margin-left:10px'></span></td>
						<td colspan="2"></td>
					</tr> -->
				</table>

      </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
