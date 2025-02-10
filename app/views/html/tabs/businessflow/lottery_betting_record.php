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

    .table-wrapperlottery {
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

    .queryholderbet {
        width: 19%;
        margin-right: 5px;
        background-color: #fff;
    }

    .queryholderxx {
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

    .queryholderxx.optionlist {
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
    .table-wrapperlottery::-webkit-scrollbar {
        width: 5px;
        /* Slimmer scrollbar width */
        height: 5px;
        /* Slimmer scrollbar height for horizontal scrolling */
    }

    .table-wrapperlottery::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Lighter background for track */
        border-radius: 5px;
    }

    .table-wrapperlottery::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Blue color for thumb */
        border-radius: 10px;
        cursor: pointer;
    }

    .table-wrapperlottery::-webkit-scrollbar-thumb:hover {
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

    .tbl-header {
        position: sticky;
        top: 0;
    }

    .sticky-header {
        position: relative;
        bottom: 1px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
    }

    .userDropdownb {
        width: 16%;
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
    .userDropdownb::-webkit-scrollbar {
        width: 3px;
        /* Width of the scrollbar */
    }

    .userDropdownb::-webkit-scrollbar-track {
        background: #f0f0f0;
        /* Background of the scrollbar track */
        border-radius: 5px;
        /* Rounded corners */
    }

    .userDropdownb::-webkit-scrollbar-thumb {
        background: #ccc;
        /* Color of the scrollbar handle */
        border-radius: 5px;
        /* Rounded corners */
    }

    .userDropdownb::-webkit-scrollbar-thumb:hover {
        background: #aaa;
        /* Darker handle color on hover */
    }

    /* Dropdown item styling */
    .optionlist {
        padding: 5px;
        cursor: pointer;
    }

    .optionlist:hover {
        background-color: #f0f0f0;
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

    .tbl-headerbet {
    position: sticky;
    top: 0;
  }

  .sticky-headerbet {
    position: relative;
    bottom: 1px;
    background-color: red;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
  }
</style>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"><?= $translator['Lottery Betting Record']; ?></h4>
    </div>

    <div class="px-4 py-3 border-bottom pagerlist1">
        <form action="" class="betform">
            <span class="top-left-btn">
                <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: auto;">
                    <input type="text" id="myInput" class="form-control queryholderbet usernames" placeholder="Search usernames" />
                    <input name="usernames" type="hidden" class="userIdbet" />
                    <input type="text" id="lot-betID" class="form-control queryholderbet search-betID" placeholder="Search BetID" />
                    <select class="form-control userDropdownb" size="5" style="display: none;" id="userlotteryDropdown">
                        <!-- Options will be populated dynamically -->
                    </select>
                    <div class="custom-dropdown">
                        <select name="lotteryname" class="form-control form-select queryholderbet typelottery selectlottery" data-bs-placeholder="Select Type"> 

                        </select>
                    </div>

                    <select name="betsate" class="form-control form-select queryholderbet betsate" data-bs-placeholder="Select Type">
                        <option value="">
                            -<?= $translator['State']; ?>
                            -
                        </option>
                        <option value="1"> <?= $translator['Settled']; ?></option>
                        <option value="2"><?= $translator['Unsettled']; ?></option>
                        <option value="4"> <?= $translator['Cancelled Bet']; ?></option>
                       
                       
                    </select>

                    <select name="betstatus" class="form-control form-select queryholderbet betstatus" data-bs-placeholder="Select Type">
                        <option value="">
                            -
                            <?= $translator['Bet Status']; ?>-
                        </option>
                        <option value="2"><?= $translator['Win']; ?></option>
                        <option value="3"><?= $translator['Loss']; ?></option>
                        <option value="5"><?= $translator['Pending']; ?></option>
                        <option value="6"><?= $translator['Void']; ?></option>
                        <option value="7"><?= $translator['Refund']; ?></option>
                    </select>

                    <input name="startdate" type="date" class="form-control queryholderbet startdates" aria-describedby="name" placeholder="Name" />

                    <input name="enddate" type="date" class="form-control queryholderbet enddates" aria-describedby="name" placeholder="Name" />

               
                </div>
            </span>
            <span class="toplist-center" aria-label=" navigation example">
                <!--enter is free-->
            </span>
            <span class="topplist-right" id="paginations" aria-label="Page navigation example">
                <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                    <button type="button" class="btn bg-white-subtle player betrefresh" value="right" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                        <i class="bx bx-refresh" style="font-size: 20px;"></i>
                    </button>
                    <button type="button" class="btn bg-white-subtle executebet" value="end" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                        <i class="bx bx-check-double loaderbet" style="font-size: 20px;"></i>
                    </button>
                </div>
            </span>
        </form>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperlottery" id="maskbet" style="height: 530px; overflow-y: scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered table-hover">
                <thead class="text-dark fs-4 tbl-headerbet">
                <tr class="headrowbet">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">
                                <?= $translator['Bet Order ID']; ?>
                            </h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Username']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Issue Number']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Lottery Type']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Game Model']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Game Type']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Bet Time']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Server Time']; ?></h6>
                        </th>
                                  <!-- <th>
                        <h6 class="fs-4 fw-semibold mb-0">Bet Type</h6>
                      </th> -->
                                  <!-- <th>
                        <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Prize']; ?></h6>
                      </th> -->
                       
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Unit Stake']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Multiplier']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Total Bet Amount']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Win Amount']; ?></h6>
                        </th>
                        <!-- <th>
                    <h6 class="fs-4 fw-semibold mb-0">Rebate Amount</h6>
                  </th> -->
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Win/Loss']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Status']; ?></h6>
                        </th>
                        <!-- <th>
                    <h6 class="fs-4 fw-semibold mb-0">IP</h6>
                  </th> -->
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class="bx bx-dots-vertical-rounded"></i></h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="lotterydataContainer">
                    <tr class="no-resultslist">
                        <td colspan="13">
                        <img src="<?php echo BASE_URL; ?>assets/images/notfound.png" class="dark-logo" alt="Logo-Dark" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="px-4 py-3 border-top pagerlist">
        <span class="toplist-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <!-- <button type="button" class="btn bg-white-subtle playerbet" value="betstart">
                    <i class="bx bx-chevrons-left" style="font-size: 20px;"></i>
                </button> -->
                <button type="button" class="btn bg-white-subtle playerbet" value="betleft">
                    <i class="bx bx-chevron-left" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playerbet" value="betright">
                    <i class="bx bx-chevron-right" style="font-size: 20px;"></i>
                </button>
                <!-- <button type="button" class="btn bg-white-subtle playerbet" value="betend">
                    <i class="bx bx-chevrons-right" style="font-size: 20px;"></i>
                </button> -->
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <span id="paging_infobet" style="color: #aaa;">---</span>
        </span>
        <span class="top-right-btn" aria-label="Page navigation example">
            <select class="left-element form-control numrowsbet" style="font-size: 12px;">
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="500">500</option>
            </select>
            <span class="toplist-right" id="paginationbet" class="right-element">
            <!-- paginationation -->
            </span>
           
        </span>
     
      
    </div>
</div>


<!--view bet modal -->

<div id="viewbetsmodal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between">
                        <div><?= $translator['Bet Info']; ?></div>
                        <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
                    </div>
                </div>

                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <tbody id="rowbet"></tbody>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <tbody id="rowbet1"></tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
