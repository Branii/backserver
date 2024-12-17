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

    .queryholderlist {
        width: 19%;
        margin-right: 5px;
        background-color: #FFF;
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

    .queryholderxx .optionlist {
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
    .table-wrapperuserlist::-webkit-scrollbar {
        width: 5px;
        /* Slimmer scrollbar width */
        height: 5px;
        /* Slimmer scrollbar height for horizontal scrolling */
    }

    .table-wrapperuserlist::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Lighter background for track */
        border-radius: 5px;
    }

    .table-wrapperuserlist::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Blue color for thumb */
        border-radius: 10px;
        cursor: pointer;
    }

    .table-wrapperuserlist::-webkit-scrollbar-thumb:hover {
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

    .tbl-headersUser {
        position: sticky;
        top: 0;
    }

    .sticky-headersUserlist {
        position: relative;
        bottom: 1px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
    }

    .bring-forward {
        z-index: 10 !important;
        background: white !important;
    }
    .send-back {
        position: absolute !important;
        z-index: 0 !important;
        width: 18.5% ;

    }
    li.name-items:first-child {
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}

li.name-items {
    color: #5a6a85;
    padding: 9px 12px;
}
li.name-items:last-child {
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;
}
.usr-res-wrapper {
    position: absolute;
    width: 17%;
    border-radius: 5px;
    max-height: fit-content;
    background: #fff;
    border: 1px solid #dfe5ef;
    display:none;
    z-index: 10;

}
li.name-items:hover {
    background: #0c2f6b !important;
    color: #fff;
}

.lot-res-wrapper {
    z-index: 6;
    position: absolute;
    background: white;
    width: 17.6%;
}
.startdate , .enddate {
    width: 19%;
}

.startdate {
    margin-right: 5px;
}

.get-subs-btn {
    cursor: pointer;
}

.btn-disabled {
    opacity: 0.5;
}
.btn {
    color: #03122b !important;
}
</style>

<div class="card w-100 position-relative overflow-hidden">

    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">Win/Loss Report</h4>
    </div>

    <div class="px-4 py-3 border-bottom pagerlist1">
        <span class="top-left-btn">
            <div  class="btn-group mb-2" role="group" aria-label="Basic example" style="padding:5px;width:97%;">

          
                <div>
          
 <input name="usernamelist" class="queryholderlist form-control bring-forward" id="wl-username" placeholder="Username" autocomplete="off" style="width:97%;"> <div class="usr-res-wrapper" style="width: 26.5%;"> <ul style="max-height: 403px;margin: 0px; overflow-y:auto;" id="user-list-wrapper"></ul> </div></div>



   <div>
  <input name="lotteryList" class="queryholderlist form-control" id="wl-lottery" placeholder="Lottery"
                    autocomplete="off" style="width:97%;" /> <div class="lot-res-wrapper" style="width: 27%;"> <ul style="max-height: 403px;margin: 0px; overflow-y:auto;" id="lot-list-wrapper"></ul> </div></div>
                  
                  <input type="date" name="startdate" class="form-control startdate"  
                    placeholder="Name" id="startdate" style="width: 30%;"/>


                <input type="date" name="enddate" class="form-control enddate" 
                    placeholder="Name" id="enddate" style="width: 30%;"/>



            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topplist-right" id="paginations" aria-label="Page navigation example">

            <div class="btn-group mb-2" role="group" aria-label="Basic example"
                style="border:solid 1px #eee;color:#bbb;background-color:#fff">

                <button type="button" class="btn bg-white-subtle btn-disabled back-btn" value="" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Back" data-bs-title="Back">
                    <i class="bx bxs-bx bx-chevron-left" style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle btn-disabled get-user-details-btn" value="" aria-label="Back" 
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Get User Details">
                    <i class='bx bxs-user' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle top-agents-btn" value="" aria-label="Get Top Agent"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Get Top Agent">
                    <i class='bx bxs-user-account' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle player wl-refreshlist" value="" aria-label="Refresh"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class='bx bx-refresh' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle fetch-user-win-loss" value="" aria-label="Search"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Search">
                    <i class='bx bx-check-double loaderlist' style="font-size:20px"></i>
                </button>

            </div>

        </span>

    </div>

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperuserlist" id="masklist" style="height:530px;overflow-y:scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered table-hover">
                <thead class="text-dark fs-4 tbl-headersUser">
                    <tr class="userlistheadrow">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Username</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Relationship</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Number of Bettors</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Number of Bet Tickets</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Rebate%</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Total Bet Amount</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Total Rebate Amount</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Total Valid Amount</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Total Win Amount</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Win/Loss</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Subs</h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="winLossDtholder" class="tbl-content">

                    <tr class="no-resultslist">
                        <td colspan="13">
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
                <button type="button" class="btn bg-white-subtle playerlist" value="startlist">
                    <i class='bx bx-chevrons-left' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playerlist" value="leftlist">
                    <i class='bx bx-chevron-left' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playerlist" value="rightlist">
                    <i class='bx bx-chevron-right' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playerlist" value="endlist">
                    <i class='bx bx-chevrons-right' style="font-size:20px"></i>
                </button>
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">

            <span id="paging_infolist" style="color:#aaa">---</span>

        </span>
        <span class="toplist-right" id="paginationlist" aria-label="Page navigation example">

            <!--Dynamic pagination-->

        </span>

    </div>

</div>

<div class="modal fade" id="dangerlist" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
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

<div id="addagentmodal" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Modal Header -->
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>Add Agent</div>
                        <i class="bx bx-message-square-x listclose" style="color:#868c87;font-size:25px;cursor:pointer;"></i>
                    </div>
                </div>

                <!-- Form -->
                <form id="agentform">


                    <!-- Username Field -->
                    <div class="form-floating mb-3">
                        <input name="agentname" type="text" class="form-control border " placeholder="Username" />
                        <label>
                            <i class="bx bx-user me-2 fs-4 text-infod"></i>
                            <span class="border-start  ps-3">Username</span>
                        </label>
                    </div>

                    <!-- Email Field -->
                    <div class="form-floating mb-3">
                        <input name="agentemail" type="email" class="form-control border border-infos" placeholder="Email" />
                        <label>
                            <i class="bx bx-envelope me-2 fs-4 text-infod"></i>
                            <span class="border-start  ps-3">Email address</span>
                        </label>
                    </div>

                    <!-- Password Field -->
                    <div class="form-floating mb-3">
                        <input name="agentpassword" type="password" class="form-control border border-infs" placeholder="Password" />
                        <label>
                            <i class="bx bx-lock me-2 fs-4 text-infoss"></i>
                            <span class="border-start  ps-3">Password</span>
                        </label>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="form-floating mb-3">
                        <input name="agentpassword1" type="password" class="form-control border border-infos" placeholder="Confirm Password" />
                        <label>
                            <i class="bx bx-lock me-2 fs-4 text-infos"></i>
                            <span class="border-start  ps-3">Confirm Password</span>
                        </label>
                    </div>

                    <!-- Rebate Field -->
                    <div class="form-floating mb-3">
                        <select name="agentrebate" class="form-select form-control border border-infos" id="usererebate">
                            <!-- \<option value="" disabled selected>Select Rebate</option> -->
                            <!-- Dynamically populated options -->
                        </select>
                        <label>
                            <i class="bx bx-list-ul me-2 fs-4 text-infos"></i>
                            <span class="border-start  ps-3">Rebate</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-md-flex align-items-center">
                        <div class="form-check">
                            <!-- <input type="checkbox" class="form-check-input" id="sf2" value="check" /> -->
                            <label class="form-check-label" for="sf2">Verify before submit</label>
                        </div>
                        <div class="mt-3 mt-md-0 ms-auto">
                            <button type="button" class="btn hstack gap-6 btnaddagent" style="border:solid 1px #ccc">
                                <i class="bx bx-send loaders"></i>
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

<div id="signup" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manage User Account</h5>
                <div><i class='bx bx-message-square-x tclose' style='color:#868c87;font-size:25px;cursor:pointer;'></i></div>
            </div>
            <div class="scrollable-container">
                <!-- User Profile Picture -->
                <div class="text-center mb-4">
                    <img src="<?php echo BASE_URL; ?>assets/images/profile/user-1.jpg" class="rounded-circle" width="120" height="120" alt="Profile Image">
                </div>

                <!-- Personal Details Section -->
                <div class="card border mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Personal Details</h4>
                        <form id="personalDetailsForm">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="userName" class="form-label">Your Name</label>
                                        <input type="text" class="form-control" id="userName" placeholder="Mathew Anderson">
                                    </div>
                                    <div class="mb-3">
                                        <label for="userLocation" class="form-label">Location</label>
                                        <select id="userLocation" class="form-select">
                                            <option selected>United Kingdom</option>
                                            <option value="1">United States</option>
                                            <option value="2">India</option>
                                            <option value="3">Russia</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="userEmail" placeholder="info@modernize.com">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="storeName" class="form-label">Store Name</label>
                                        <input type="text" class="form-control" id="storeName" placeholder="Maxima Studio">
                                    </div>
                                    <div class="mb-3">
                                        <label for="userCurrency" class="form-label">Currency</label>
                                        <select id="userCurrency" class="form-select">
                                            <option selected>India (INR)</option>
                                            <option value="1">US Dollar ($)</option>
                                            <option value="2">United Kingdom (Pound)</option>
                                            <option value="3">Russia (Ruble)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userPhone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="userPhone" placeholder="+91 12345 65478">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="userAddress" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="userAddress" placeholder="814 Howard Street, 120065, India">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Account Details Section -->
                <div class="card border">
                    <div class="card-body">
                        <h4 class="card-title">Account Details</h4>
                        <form id="accountDetailsForm">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="accountName" class="form-label">Your Name</label>
                                        <input type="text" class="form-control" id="accountName" placeholder="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="accountLocation" class="form-label">Location</label>
                                        <select id="accountLocation" class="form-select">
                                            <option selected>United Kingdom</option>
                                            <option value="1">United States</option>
                                            <option value="2">India</option>
                                            <option value="3">Russia</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="accountEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="accountEmail" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="accountStoreName" class="form-label">Store Name</label>
                                        <input type="text" class="form-control" id="accountStoreName" placeholder="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="accountCurrency" class="form-label">Currency</label>
                                        <select id="accountCurrency" class="form-select">
                                            <option selected>India (INR)</option>
                                            <option value="1">US Dollar ($)</option>
                                            <option value="2">United Kingdom (Pound)</option>
                                            <option value="3">Russia (Ruble)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="accountPhone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="accountPhone" placeholder="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="accountAddress" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="accountAddress" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="viewquota" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Modal Header -->
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-infos">Quota</h5>
                        <i class="bx bx-message-square-x listclose" style="color:#868c87;font-size:25px;cursor:pointer;"></i>
                    </div>
                </div>

                <!-- Form -->
                <form>
                    <input type="text" class="form-control userquotaid" hidden>
                    <div class="modal-body scrollable-container">
                        <div style="overflow: hidden;">
                            <table class="table table-hover table-bordered text-nowrap mb-0" id="quotatable">
                                <thead>
                                    <tr>
                                        <th class="font-weight-normal">Rebate(%)</th>
                                        <th class="font-weight-normal">Bonus Group</th>
                                        <th class="font-weight-normal">Quota Used</th>
                                        <th class="font-weight-normal">Quota Set</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data rows will go here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-md-flex align-items-center">
                        <div class="form-check">
                            <label class="form-check-label" for="sf2">Verify before submit</label>
                        </div>
                        <div class="mt-3 mt-md-0 ms-auto">
                            <button type="button" class="btn hstack gap-6 updatequotabtn" style="border:solid 1px #ccc">
                                <i class="bx bx-send loaderquota"></i>
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


