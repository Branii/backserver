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

  

    .queryholderuserlistz {
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

    .table-wrapperuserlist {
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

    .table-wrapperuserquota {
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

    /* Custom Scrollbar for Webkit Browsers */
    .table-wrapperuserquota::-webkit-scrollbar {
        width: 5px;
        /* Slimmer scrollbar width */
        height: 5px;
        /* Slimmer scrollbar height for horizontal scrolling */
    }

    .table-wrapperuserquota::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Lighter background for track */
        border-radius: 5px;
    }

    .table-wrapperuserquota::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Blue color for thumb */
        border-radius: 10px;
        cursor: pointer;
    }

    .table-wrapperuserquota::-webkit-scrollbar-thumb:hover {
        background-color: #aaa;
        /* Darker blue on hover */
    }

    .table-wrapperuserquota {
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

    .queryholderuserlist {
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
    .queryholderuserlist::-webkit-scrollbar {
        width: 3px;
        /* Width of the scrollbar */
    }

    .queryholderuserlist::-webkit-scrollbar-track {
        background: #f0f0f0;
        /* Background of the scrollbar track */
        border-radius: 5px;
        /* Rounded corners */
    }

    .queryholderuserlist::-webkit-scrollbar-thumb {
        background: #ccc;
        /* Color of the scrollbar handle */
        border-radius: 5px;
        /* Rounded corners */
    }

    .queryholderuserlist::-webkit-scrollbar-thumb:hover {
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

.tbl-headeruserlist {
    position: sticky;
    z-index: 999;
    top: 0;
  }
       
    .sticky-headeruserlist {
        position: relative;
        bottom: 1px;
        background-color: red;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
    }

    .tbl-headeruserlists {
        position: sticky;
        top: 0;
    }

    .sticky-headeruserlists {
        position: relative;
        bottom: 1px;
        background-color: red;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
    }

    .tbl-headeruserquota {
        position: sticky;
        top: 0;
    }

    .sticky-headeruserquota {
        position: relative;
        bottom: 1px;
        background-color: red;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
    }


    /*Tooltip*/
    section#tooltipp p {
        margin: 20px 0;
    }

    /*Tooltip text*/
    .tooltipp {
        position: relative;
        width: auto;
    }

    .tooltipp .tooltipp-text {
        font-family: "Open Sans", sans-serif;
        font-size: 1em;
        line-height: 1.5em;
        visibility: hidden;
        width: 400px; /* Fixed width */
        background-color: #fff;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        color: gray;
        text-align: center;
        border-radius: 6px;
        padding: 10px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 0%;
        margin-left: -60px;
        opacity: 0;
        cursor: pointer;
        transition: 0.3s;
        transform: translate3d(0px, 20px, 0px);

        /* Ensure text wraps */
        white-space: normal; /* Allow text to wrap */
        word-wrap: break-word; /* Break long words */
        overflow-wrap: break-word; /* Modern alternative to word-wrap */
    }

    .tooltipp .tooltipp-text::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #bbb transparent transparent transparent;
    }

    .tooltipp:hover .tooltipp-text {
        visibility: visible;
        opacity: 1;
        transform: translate3d(0px, 0px, 0px);
    }
        /* Custom Scrollbar for Webkit Browsers */
        .table-wrapperuserlistt::-webkit-scrollbar {
        width: 5px;
        /* Slimmer scrollbar width */
        height: 5px;
        /* Slimmer scrollbar height for horizontal scrolling */
    }

    .table-wrapperuserlistt::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Lighter background for track */
        border-radius: 5px;
    }

    .table-wrapperuserlistt::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Blue color for thumb */
        border-radius: 10px;
        cursor: pointer;
    }

    .table-wrapperuserlistt::-webkit-scrollbar-thumb:hover {
        background-color: #aaa;
        /* Darker blue on hover */
    }

    .table-wrapperuserlistt {
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
</style>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"><?= $translator['User List']; ?></h4>
    </div>

    <!-- <button id="backButton" style="display: none;">Back</button> -->
    <div class="px-4 py-3 border-bottom pagerlist1">
        <form action="" class="betform">
            <span class="top-left-btn">
                <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: auto;">
                    <input type="text" id="selectuserlist" class="form-control queryholderuserlistz usernames" placeholder="Search usernames" />
                    <input name="usernames" type="hidden" class="userIdbet" />
                    <select class="form-control queryholderuserlist" size="5" style="display: none;" id="userlists">
                        <!-- Options will be populated dynamically -->
                    </select>

                    <select name="recharge" class="form-control form-select queryholderuserlistz recharges" data-bs-placeholder="Select Type">
                        <option value="">-Recharge Level-</option>
                        <option value="1">Level One</option>
                        <option value="2">Level Two</option>
                        <option value="3">Level Three</option>
                    </select>

                    <select name="state" class="form-control form-select queryholderuserlistz states" data-bs-placeholder="Select Type">
                        <option value="">-State-</option>
                        <option value="1">Enable to run</option>
                        <option value="2">Suspend Betting</option>
                        <option value="3">Forbidden to log in</option>
                        <option value="4">Block User</option>
                    </select>

                    <input name="startdate" type="date" class="form-control queryholderuserlistz startdateuser" aria-describedby="name" placeholder="Name" />

                    <input name="enddate" type="date" class="form-control queryholderuserlistz enddateuser" aria-describedby="name" placeholder="Name" />
                </div>
            </span>
            <span class="toplist-center" aria-label=" navigation example">
                <!--enter is free-->
            </span>
            <span class="topplist-right" id="paginations" aria-label="Page navigation example">
                <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                    <button type="button" class="btn bg-white-subtle" id="backButton" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="back">
                        <i class="bx bxs-chevron-left-circle" style="font-size: 20px;"></i>
                    </button>
                    <button type="button" class="btn bg-white-subtle addagent" value="" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add Agent">
                        <i class="bx bxs-user-plus" style="font-size: 20px;"></i>
                    </button>
                    <button type="button" class="btn bg-white-subtle gettopagent" value="" aria-label="Get Top Agent" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Get Top Agent">
                        <i class="bx bxs-user-account" style="font-size: 20px;"></i>
                    </button>

                    <button type="button" class="btn bg-white-subtle player refreshlistuser" value="right" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                        <i class="bx bx-refresh" style="font-size: 20px;"></i>
                    </button>
                    <button type="button" class="btn bg-white-subtle executeuserlist" value="end" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                        <i class="bx bx-check-double loaderlist" style="font-size: 20px;"></i>
                    </button>
                </div>
            </span>
        </form>
    </div>

    <!-- <span class="tooltipp">relacionamentos verticais<span class="tooltipp-text">Entre culturas e povos brasileiros de todo o mundo</span></span> -->
    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperuserlist" id="maskuserlist" style="height: 530px; overflow-y: scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered table-hover">
                <thead class="text-dark fs-4 tbl-headeruserlist">
                    <tr class="headrowuserlist">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Username']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Nickname']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Level']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Relationship']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Direct Agent Subordinates']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Available Balance/Frozen Amount']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Rebate(%)']; ?></h6>
                        </th>
                        <!-- <th>
                            <h6 class="fs-4 fw-semibold mb-0">Deposit Level</h6>
                        </th> -->

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Creation Time']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Last Login']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Login Count']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Status']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class="bx bx-dots-vertical-rounded"></i></h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="userlistContainer" class="tbl-content">
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
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <!-- <button type="button" class="btn bg-white-subtle playerbet" value="betstart">
                    <i class="bx bx-chevrons-left" style="font-size: 20px;"></i>
                </button> -->
                <button type="button" class="btn bg-white-subtle playeruserlist" value="leftuserlists">
                    <i class="bx bx-chevron-left" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playeruserlist" value="rightuserlists">
                    <i class="bx bx-chevron-right" style="font-size: 20px;"></i>
                </button>
                <!-- <button type="button" class="btn bg-white-subtle playerbet" value="betend">
                    <i class="bx bx-chevrons-right" style="font-size: 20px;"></i>
                </button> -->
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <span id="paging_infolist" style="color: #aaa;">---</span>
        </span>
        <span class="top-right-btn" aria-label="Page navigation example">
            <select class="left-element form-control numrowsbet" style="font-size: 12px;">
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="500">500</option>
            </select>
            <span class="toplist-right" id="paginationuserlist" class="right-element">
                <!-- paginationation -->
            </span>
        </span>
    </div>
</div>

<!--view bet modal -->

<div id="addagentmodal" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Modal Header -->
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>Add Agent</div>
                        <i class="bx bx-message-square-x listclose" style="color: #868c87; font-size: 25px; cursor: pointer;"></i>
                    </div>
                </div>

                <!-- Form -->
                <form id="agentform">
                    <!-- Username Field -->

                    <div class="form-floating mb-3">
                        <input name="username" type="text" class="form-control border" placeholder="Username" />
                        <label>
                            <i class="bx bx-user me-2 fs-4 text-infod"></i>
                            <span class="border-start ps-3">Username</span>
                        </label>
                    </div>

                    <!-- Email Field -->
                    <div class="form-floating mb-3">
                        <input name="email" type="email" class="form-control border border-infos" placeholder="Email" />
                        <label>
                            <i class="bx bx-envelope me-2 fs-4 text-infod"></i>
                            <span class="border-start ps-3">Email address</span>
                        </label>
                    </div>

                    <!-- Password Field -->
                    <div class="form-floating mb-3">
                        <input name="password" type="password" class="form-control border border-infs" placeholder="Password" />
                        <label>
                            <i class="bx bx-lock me-2 fs-4 text-infoss"></i>
                            <span class="border-start ps-3">Password</span>
                        </label>
                    </div>

                    <!-- Confirm Password Field -->
                    <!-- <div class="form-floating mb-3">
                        <input name="password" type="password" class="form-control border border-infos" placeholder="Confirm Password" />
                        <label>
                            <i class="bx bx-lock me-2 fs-4 text-infos"></i>
                            <span class="border-start ps-3">Confirm Password</span>
                        </label>
                    </div> -->

                    <!-- Rebate Field -->
                    <div class="form-floating mb-3">
                        <select name="rebate" class="form-select form-control border border-infos" id="usererebate">
                            <!-- \<option value="" disabled selected>Select Rebate</option> -->
                            <!-- Dynamically populated options -->
                        </select>
                        <label>
                            <i class="bx bx-list-ul me-2 fs-4 text-infos"></i>
                            <span class="border-start ps-3">Rebate</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-md-flex align-items-center">
                        <div class="form-check">
                            <!-- <input type="checkbox" class="form-check-input" id="sf2" value="check" /> -->
                            <label class="form-check-label" for="sf2">Verify before submit</label>
                        </div>
                        <div class="mt-3 mt-md-0 ms-auto">
                            <button type="button" class="btn hstack gap-6 btnaddagent" style="border: solid 1px #ccc;" data-bs-dismissz="modal" aria-label="Close">
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

<div id="usrl-manage-user" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manage User Account</h5>
                <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
            </div>
            <div class="scrollable-container">
                <!-- User Profile Picture -->
                <div class="text-center mb-4">
                    <img src="<?php echo BASE_URL; ?>assets/images/profile/user-1.jpg" class="rounded-circle" width="120" height="120" alt="Profile Image" />
                </div>


                <!-- Personal Details Section -->
                <div class="card border mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Personal Details</h4>
                        <form id="personalDetailsForm">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="userName" class="form-label">Contact</label>
                                        <input type="text" class="form-control" id="usrl-contact" placeholder="Contact" disabled/>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userEmail" class="form-label">Whatsapp</label>
                                        <input type="email" class="form-control" id="usrl-whatsapp" placeholder="whatsapp" disabled/>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userEmail" class="form-label">Username</label>
                                        <input type="email" class="form-control" id="usrl-username" placeholder="username" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="storeName" class="form-label">Account Type</label>
                                        <input type="text" class="form-control" id="usrl-account-type" placeholder="Account Type" disabled/>
                                    </div>
                                    <div class="mb-3">
                                        <label for="usrl-state" class="form-label">State</label>
                                        <select id="usrl-state" class="form-select">
                                                <option value="1">Enable to Run</option>
												<option value="2">Suspend Betting</option>
												<option value="3">Forbidden to Log In</option>
												<option value="5">Forbidden to Deposit</option>
												<option value="6">Forbidden to Withdraw</option>
												<option value="4">Block User</option>

                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="usrl-rebate" class="form-label">Rebate (%)</label>
                                        <input type="text" class="form-control" id="usrl-rebate" placeholder="rebate(%)" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="userAddress" class="form-label">Remarks</label>
                                        <input type="text" class="form-control" id="usrl-remarks" placeholder="remarks" disabled/>
                                    </div>
                                    <div class="mb-3">
                                        <label for="usrl-deposit-limit" class="form-label">Deposit Limit</label>
                                        <input type="text" class="form-control" id="usrl-deposit-limit" placeholder="Deposit Limit" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="usrl-withdrawal-limit" class="form-label">Withdrawal Limit</label>
                                        <input type="text" class="form-control" id="usrl-withdrawal-limit" placeholder="Withdrawal Limit" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="usrl-daily-betting-total-limit" class="form-label">Daily Betting Total Limit</label>
                                        <input type="text" class="form-control" id="usrl-daily-betting-total-limit" placeholder="Daily Betting Total Limit" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Account Details Section -->
                <div class="card border">
                    <div class="card-body">
                        <h4 class="card-title">Account Security</h4>
                        <form id="accountDetailsForm">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="usrl-login-password" class="form-label">Login Password</label>
                                        <input type="password" class="form-control" id="usrl-login-password" placeholder="Login Password" disabled/>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="usrl-withdrawal-password" class="form-label">Withdrawal Password</label>
                                        <input type="password" class="form-control" id="usrl-withdrawal-password" placeholder="Withdrawal Password" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="usrl-accounting-binding" class="form-label">Account Binding</label>
                                        <input type="password" class="form-control" id="usrl-accounting-binding" placeholder="Account Binding"  disabled/>
                                    </div>
                                    <div class="mb-3">
                                        <label for="usrl-security" class="form-label">Security</label>
                                        <input type="password" class="form-control" id="usrl-security" placeholder="Security" disabled/>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-primary" id="update-user-infobtn">Save</button>
                                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="viewquota" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Modal Header -->
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-infos">Quota</h5>
                        <i class="bx bx-message-square-x listclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i>
                    </div>
                </div>

                <!-- Form -->
                <form>
                    <input type="text" class="form-control userquotaid" hidden />
                    <div class="modal-body scrollable-containerxx">
                        <div style="overflow: hidden;">
                        <div class="card-body p-4">
                        <div class="table-responsive mb-4 border rounded-1 table-wrapperuserquota" id="quotatable" style="height: 430px; overflow-y: scroll;">
                            <table class="table text-nowrap mb-0 align-middle table-bordered table-hover">
                            <thead class="text-dark fs-4 tbl-headeruserquota">
                           <tr class="headrowusequota">
                         
                                        <th class="font-weight-normal">Rebate(%)</th>
                                        <th class="font-weight-normal">Bonus Group</th>
                                        <th class="font-weight-normal">Quota Used</th>
                                        <th class="font-weight-normal">Quota Set</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                            </table>
                          </div>
                        </div>
                        </div>
                    </div>
             
        
                    <div class="d-md-flex align-items-center">
                        <div class="form-check">
                            <label class="form-check-label" for="sf2">Verify before submit</label>
                        </div>
                        <div class="mt-3 mt-md-0 ms-auto">
                            <button type="button" class="btn hstack gap-6 updatequotabtn" style="border: solid 1px #ccc;">
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



<div id="usl-deactivate-user-dialog" class="modal fade " tabindex="-1" aria-modal="true" role="dialog" style="display: none;top: 363px;left: 191px;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="width: 75%;">
            <div class="modal-body">
                <!-- Modal Header -->
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-infos" style="color: #e60e38;">Deactivate User</h5>
                        <i class="bx bx-message-square-x usrl-listclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i>
                    </div>
                </div>

                <!-- Form -->
                <form>
                    
                    <div class="modal-body scrollable-container">
                        <div style="overflow: hidden;text-align: center;font-size: large;font-weight: bold;">
                            <p>Are you sure you want to <span style="color: #e60e38;">Deactivate  Agent 1 ? </span></p>
                        </div>
                    </div>
                    <div class="d-md-flex align-items-center">
                        
                        <div class="mt-3 mt-md-0 ms-auto">
                            <button type="button" class="btn hstack gap-6 block-userbtn" style="border: solid 1px #ccc;color: #e60e38!important;">
                                <i class="bx bx-user-x loaderquota"></i>Deactivate User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="usl-lottery-name-modal" class="modal fade" tabindex="-1" aria-modal="true" role="dialog" style="display: none;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Modal Header -->
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-infos">Lottery Name</h5>
                        <i class="bx bx-message-square-x usrl-listclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i>
                    </div>
                </div>

                <!-- Form -->
                <form>
                    <input type="text" class="form-control userquotaid" hidden="">
                    <div class="modal-body scrollable-container">
                        <div style="overflow: hidden;">
                            <table class="table table-hover table-bordered text-nowrap mb-0" id="quotatable">
                                <thead>
                                    <tr>
                                        <th class="font-weight-normal">Lottery Name</th>
                                        <th class="font-weight-normal">Status</th>
                                        <th class="font-weight-normal">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="usrl-lot-dtholder"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-md-flex align-items-center">
                        
                        <div class="mt-3 mt-md-0 ms-auto">
                            <button type="button" class="btn hstack gap-6 usrl-listclose" style="border: solid 1px #ccc;">
                                <i class="bx bx-x-circle loaderquota"></i>Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="usl-delete-user-dialog" class="modal fade " tabindex="-1" aria-modal="true" role="dialog" style="display: none;top: 363px;left: 191px;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="width: 75%;">
            <div class="modal-body">
                <!-- Modal Header -->
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-infos" style="color: #e60e38;">Delete User</h5>
                        <i class="bx bx-message-square-x usrl-listclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i>
                    </div>
                </div>

                <!-- Form -->
                <form>
                    
                    <div class="modal-body scrollable-container">
                        <div style="overflow: hidden;text-align: center;font-size: large;font-weight: bold;">
                            <p>Are you sure you want to <span style="color: #e60e38;">Delete  Agent 1 ? </span></p>
                        </div>
                    </div>
                    <div class="d-md-flex align-items-center">
                        
                        <div class="mt-3 mt-md-0 ms-auto">
                            <button type="button" class="btn hstack gap-6 usrl-delete-userbtn" style="border: solid 1px #ccc;color: #e60e38!important;">
                                <i class="bx bx-trash loaderquota"></i>Delete User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="usl-whitelist-ips-modal" class="modal fade " tabindex="-1" aria-modal="true" role="dialog" style="display: none;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Modal Header -->
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-infos">White List Ips</h5>
                        <i class="bx bx-message-square-x usrl-listclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i>
                    </div>
                </div>

                <!-- Form -->
                <form>
                    <input type="text" class="form-control userquotaid" hidden="">
                    <div class="modal-body scrollable-container">
                        <div style="overflow: hidden;">
                            <table class="table table-hover table-bordered text-nowrap mb-0" id="quotatable">
                                <thead>
                                    <tr>
                                        <th class="font-weight-normal">IPs</th>
                                        <th class="font-weight-normal">Time</th>
                                        <th class="font-weight-normal">Status</th>
                                        <th class="font-weight-normal">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="usrl-ipsholder">
                                <tr>
                                    <td><b class="lottery-name"> 14.0</b></td>
                                    <td><b class="lottery-status">  1980</b></td>
                                    <td><b class="lottery-actn">0 </b> / 20</td>
                                    <td><b class="lottery-actn">0 </b> / 20</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-md-flex align-items-center">
                        <!-- <div class="form-check">
                            <label class="form-check-label" for="sf2">Verify before submit</label>
                        </div> -->
                        <div class="mt-3 mt-md-0 ms-auto">
                            <button type="button" class="btn hstack gap-6 usrl-listclose" style="border: solid 1px #ccc;">
                                <i class="bx bx-x-circle loaderquota"></i>
                                Close
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<input id="idHolder" type="hidden" value="">


<div id="usrl-relationship-dialog" class="modal fade" tabindex="-1" aria-modal="true" role="dialog" style="display: none; top: 363px; left: 191px;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="width: 75%;">
            <div class="modal-body">
                <!-- Modal Header -->
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-infos" style="">Relationship</h5>
                        <i class="bx bx-message-square-x usrl-listclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i>
                    </div>
                </div>

                <!-- Form -->
                <form>
                    
                    <div class="modal-body scrollable-container">
                        <div style="overflow: hidden;text-align: center;font-weight: bold;">
                            <p id="usrl-relholder"></p>
                        </div>
                    </div>
                    <div class="d-md-flex align-items-center">
                        
                        <div class="mt-3 mt-md-0 ms-auto">
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="viewaccount" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between">
                        <div>Account Change Info</div>
                        <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
                    </div>
                </div>

                <form>
                    <div class="row">
                        <div class="px-4 py-3 border-bottom pagerlist1">
                            <form action="" class="betform">
                                <span class="top-left-btn">
                                    <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: auto;">
                                        <select name="order_type" class="form-control form-select orderuserchange refresdata" data-bs-placeholder="Select Type" style="width: 39%;">
                                            <option value="">-<?= $translator['Transaction Type']; ?>-</option>
                                            <option value="1"><?= $translator['Deposit']; ?></option>
                                            <option value="2"><?= $translator['Win Bonus']; ?></option>
                                            <option value="3"> <?= $translator['Bet Awarded']; ?></option>
                                            <option value="4"><?= $translator['Withdrawal']; ?></option>
                                            <option value="6"><?= $translator['Bet Cancelled']; ?></option>
                                            <option value="5"><?= $translator['Bet Deduct']; ?></option>
                                            <option value="7"><?= $translator['Rebates']; ?></option>
                                            <option value="8"><?= $translator['Self Rebate']; ?></option>
                                            <option value="9"><?= $translator['Sending Red Envelope']; ?></option>
                                            <option value="10"><?= $translator['Red Envelope Receive']; ?></option>
                                            <option value="11"><?= $translator['Bet Refund']; ?></option>
                                            <option value="12"><?= $translator['Bet Lost']; ?></option>
                                        </select>

                                        <input name="startdate" type="date" class="form-control startdateusers refresdata" aria-describedby="name" style="width: 39%; position: relative; left: 4%;" placeholder="Name" />

                                        <input name="enddate" type="date" class="form-control enddateusers refresdata" aria-describedby="name" style="width: 39%; position: relative; left: 9%;" placeholder="Name" />
                                    </div>
                                </span>
                                <span class="toplist-center" aria-label=" navigation example">
                                    <!--enter is free-->
                                </span>
                                <span class="topplist-right" id="paginations" aria-label="Page navigation example">
                                    <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                                        <button type="button" class="btn bg-white-subtle player refreshuseracc" value="right" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                                            <i class="bx bx-refresh" style="font-size: 20px;"></i>
                                        </button>
                                        <button type="button" class="btn bg-white-subtle searchuseraccount" value="end" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                                            <i class="bx bx-check-double loaderuseracc" style="font-size: 20px;"></i>
                                        </button>
                                    </div>
                                </span>
                            </form>
                        </div>

                        <div class="card-body p-4">
                          
                                        <div class="table-responsive mb-4 border rounded-1 table-wrapperuserlistt" id="maskaccount" style="height: 330px; overflow-y: scroll;">
                                        <table class="table text-nowrap mb-0 align-middle table-bordered table-hover">
                                            <thead class="text-dark fs-4 tbl-headeruserlists">
                                        <tr class="headrowuserlists">
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['ID Number']; ?></h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Username']; ?></h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Transaction Type']; ?></h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Amount']; ?></h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Balance']; ?></h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Bet Stake Time']; ?></h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Server Time']; ?></h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Transaction ID']; ?></h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Status']; ?></h6>
                                            </th>
                                            <!-- <th>
                                            <h6 class="fs-4 fw-semibold mb-0"><i class="bx bx-dots-vertical-rounded"></i></h6>
                                        </th> -->
                                        </tr>
                                    </thead>
                                    <tbody id="accountchange" class="tbl-content">
                                        <tr class="no-results">
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
                                <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                                    <!-- <button type="button" class="btn bg-white-subtle playerbet" value="betstart">
                            <i class="bx bx-chevrons-left" style="font-size: 20px;"></i>
                        </button> -->
                                    <button type="button" class="btn bg-white-subtle playeruserlistt" value="leftuserlistss">
                            <i class="bx bx-chevron-left" style="font-size: 20px;"></i>
                        </button>
                        <button type="button" class="btn bg-white-subtle playeruserlistt" value="rightuserlistss">
                            <i class="bx bx-chevron-right" style="font-size: 20px;"></i>
                        </button>
                                    <!-- <button type="button" class="btn bg-white-subtle playerbet" value="betend">
                            <i class="bx bx-chevrons-right" style="font-size: 20px;"></i>
                        </button> -->
                                </div>
                            </span>
                            <span class="toplist-center" aria-label=" navigation example">
                                <span id="paging_infolistss" style="color: #aaa;">---</span>
                            </span>
                            <span class="top-right-btn" aria-label="Page navigation example">
                                <select class="left-element form-control numrowschange" style="font-size: 12px;">
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="500">500</option>
                                </select>
                                <span class="toplist-right" id="paginationacc" class="right-element">
                                    <!-- paginationation -->
                                </span>
                            </span>
                        </div>
                        <!-- <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <tbody id="rowbet1"></tbody>
                            </table>
                        </div>  -->
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
