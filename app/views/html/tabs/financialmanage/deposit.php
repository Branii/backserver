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

    .table-wrapperdeposit {
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

    .queryholderdeposit {
        width: 30%;
        margin-right: 5px;
        background-color: #fff;
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
    .table-wrapperdeposit::-webkit-scrollbar {
        width: 5px;
        /* Slimmer scrollbar width */
        height: 5px;
        /* Slimmer scrollbar height for horizontal scrolling */
    }

    .table-wrapperdeposit::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Lighter background for track */
        border-radius: 5px;
    }

    .table-wrapperdeposit::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Blue color for thumb */
        border-radius: 10px;
        cursor: pointer;
    }

    .table-wrapperdeposit::-webkit-scrollbar-thumb:hover {
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

    .tbl-depositheader {
        position: sticky;
        top: 0;
    }

    .sticky-depositheader {
        position: relative;
        bottom: 1px;
        background-color: red;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
    }

    .DepositDropdown {
        width: 16%;
        position: absolute;
        background-color: #fff;
        color: #aaa;
        max-height: 300px;
        overflow-y: scroll;
        border-radius: 5px;
        padding: 5px;
        top: 90%;
        z-index: 9999;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        display: none;
    }

    /* Style for the scrollbar */
    .DepositDropdown::-webkit-scrollbar {
        width: 3px;
        /* Width of the scrollbar */
    }

    .DepositDropdown::-webkit-scrollbar-track {
        background: #f0f0f0;
        /* Background of the scrollbar track */
        border-radius: 5px;
        /* Rounded corners */
    }

    .DepositDropdown::-webkit-scrollbar-thumb {
        background: #ccc;
        /* Color of the scrollbar handle */
        border-radius: 5px;
        /* Rounded corners */
    }

    .DepositDropdown::-webkit-scrollbar-thumb:hover {
        background: #aaa;
        /* Darker handle color on hover */
    }
</style>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"><?= $translator['Deposit Record']; ?></h4>
    </div>

    <div class="px-4 py-3 border-bottom pagerlist">
        <span class="top-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: auto;">
                <input type="text" id="Depositinput" class="form-control queryholderdeposit userdeposit" placeholder="<?= $translator['Search usernames']; ?>" />
                <input name="usernames" type="hidden" class="userIdfinance" />
                <select class="form-control DepositDropdown" size="5" style="display: none;" id="userfinaceDepo">
              
                </select>
                <input type="text" class="form-control queryholderdeposit depositids" id="nametextss" aria-describedby="name" placeholder="<?= $translator['Enter Deposit ID']; ?>" />

                <select name="betsate" class="form-control form-select queryholderdeposit depositchanel" data-bs-placeholder="Select Type">
                    <option value="">-<?= $translator['Deposit Channel']; ?>-</option>
                    <option value="3"><?= $translator['Momo']; ?></option>
                    <option value="5"><?= $translator['Crypto']; ?></option>
                    <option value="2"><?= $translator['Bank Transfer']; ?></option>
                    <option value="1"><?= $translator['Manual Deposit']; ?></option>
                </select>

                <select name="betsate" class="form-control form-select queryholderdeposit depositstatus" data-bs-placeholder="Select Type">
                    <option value="">-<?= $translator['Status']; ?>-</option>
                    <option value="pending"><?= $translator['Pending']; ?></option>
                    <option value="success"><?= $translator['Success']; ?></option>
                    <option value="failed"><?= $translator['Failed']; ?></option>
                </select>

                <input name="startdate" type="date" class="form-control queryholderdeposit startdepo" aria-describedby="name" placeholder="Name" />

                <input name="enddate" type="date" class="form-control queryholderdeposit enddepo" aria-describedby="name" placeholder="Name" />
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topplist-right" id="paginations" aria-label="Page navigation example">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <!-- <i ' ></i> -->
                <!-- <button type="button" class="btn bg-white-subtle showmodal" value="right" aria-label="Refresh" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Deposit/Withdrawal">
                    <i class="bx bx-plus" style="font-size: 20px;"></i>
                </button> -->

                <button type="button" class="btn bg-white-subtle player refreshdeposit" value="right" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class="bx bx-refresh" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle executedeposit" value="end" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class="bx bx-check-double loaderdeposit" style="font-size: 20px;"></i>
                </button>
            </div>
        </span>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperdeposit" id="maskDeposit" style="height: 530px; overflow-y: scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered">
                <thead class="text-dark fs-4 tbl-depositheader">
                    <tr class="depositheaderrow">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Deposit ID']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Username']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Level']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Deposit Channel']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Deposit Amount']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Fee']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Actual Amount Received']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Deposit Time']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Receiving Bank']; ?></h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Receiving Card Number']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Status']; ?></h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Approved By']; ?></h6>
                        </th>
                        <!-- <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class='bx bx-dots-vertical-rounded'></i></h6>
                        </th> -->
                    </tr>
                </thead>
                <tbody id="DepositContainer">
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
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <!-- <button type="button" class="btn bg-white-subtle playerdeposit" value="startd">
                    <i class='bx bx-chevrons-left' style="font-size:20px"></i>
                </button> -->
                <button type="button" class="btn bg-white-subtle playerdeposit" value="leftd">
                    <i class="bx bx-chevron-left" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playerdeposit" value="rightd">
                    <i class="bx bx-chevron-right" style="font-size: 20px;"></i>
                </button>
                <!-- <button type="button" class="btn bg-white-subtle playerdeposit" value="endd">
                    <i class='bx bx-chevrons-right' style="font-size:20px"></i>
                </button> -->
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <span id="paging_infodeposit" style="color: #aaa;">---</span>
        </span>
        <span class="top-right-btn" aria-label="Page navigation example">
            <select class="left-element form-control numrowsdeposit" style="font-size: 12px;">
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="500">500</option>
            </select>
            <span class="toplist-right" id="paginationdeposits" aria-label="Page navigation example">
                <!--Dynamic pagination-->
            </span>
        </span>
    </div>
</div>
