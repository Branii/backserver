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

    .table-wrapperuserpaymentcard {
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

    .queryholderbankcard {
        width: 33%;
        margin-right: 5px;
        background-color: #fff;
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
    .table-wrapperuserpaymentcard::-webkit-scrollbar {
        width: 5px;
        /* Slimmer scrollbar width */
        height: 5px;
        /* Slimmer scrollbar height for horizontal scrolling */
    }

    .table-wrapperuserpaymentcard::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Lighter background for track */
        border-radius: 5px;
    }

    .table-wrapperuserpaymentcard::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Blue color for thumb */
        border-radius: 10px;
        cursor: pointer;
    }

    .table-wrapperuserpaymentcard::-webkit-scrollbar-thumb:hover {
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

    .bl-users-wrapper,
    .bl-bank-type-wrapper {
        position: absolute;
        width: 17%;
        border-radius: 5px;
        max-height: fit-content;
        background: #fff;
        border: 1px solid #dfe5ef;
        display: none;
        z-index: 10;
    }

    #bl-names-wrapper {
        max-height: 403px;
        margin: 0px;
        overflow-y: auto;
    }

    /* .tbl-bl-headeruserlist {
    position: sticky;
    z-index: 999;
    top: 0;
}

.sticky-bl-headeruserlist {
    position: relative;
    bottom: 1px;
    background-color: red;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
} */

    .tbl-headeruserpayment {
        position: sticky;
        top: 0;
    }

    .sticky-headeruserpayment {
        position: relative;
        bottom: 1px;
        background-color: red;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
    }

    /* Custom Scrollbar for Webkit Browsers */
    .table-wrapperuserpaymentcard::-webkit-scrollbar {
        width: 5px;
        /* Slimmer scrollbar width */
        height: 5px;
        /* Slimmer scrollbar height for horizontal scrolling */
    }

    .table-wrapperuserpaymentcard::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Lighter background for track */
        border-radius: 5px;
    }

    .table-wrapperuserpaymentcard::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Blue color for thumb */
        border-radius: 10px;
        cursor: pointer;
    }

    .table-wrapperuserpaymentcard::-webkit-scrollbar-thumb:hover {
        background-color: #aaa;
        /* Darker blue on hover */
    }

    .table-wrapperuserpaymentcard {
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
        <h4 class="card-title mb-0"><?= $translator['User Payment Method']; ?></h4>
    </div>

    <div class="px-4 py-3 border-bottom pagerlist1">
        <span class="top-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: 120%;">
                <input type="hidden" id="user_uid" value="" />

                <input id="usernames" type="hidden" value="" />
                <div style="width: 65%;">
                    <input name="transuserpayment" class="form-control bring-forward" id="transuserpayment" data-user-id=""
                        placeholder="<?= $translator['Search usernames']; ?>" autocomplete="off" style="width: 97%;" />
                    <select class="form-control queryholderuserpayment" size="5" style="display: none;" id="userpaymentAccountDropdown">
                        <!-- Options will be populated dynamically -->
                    </select>
                    <div class="bl-users-wrapper" style="width: 24.5%;">
                        <ul style="max-height: 403px; margin: 0px; overflow-y: auto;" id="bl-names-wrapper"></ul>
                    </div>
                </div>

                <!-- <div style="width: 65%;">
                    <input name="bank-type" class="form-control bring-forward" id="bl-bank-type"
                        placeholder="Search User Payment Name" autocomplete="off" style="width: 97%;" />
                    <div class="bl-bank-type-wrapper" style="width: 24.5%;">
                        <ul style="max-height: 403px; margin: 0px; overflow-y: auto;" id="bl-bank-type-wrapper"></ul>
                    </div>
                </div>
                <div style="width: 65%;">
                    <input name="card-number" type="text" class="form-control bring-forward" value=""
                        id="bl-card-number" placeholder="<?= $translator['Search Payment Method Number']; ?>" autocomplete="off" style="width: 97%;" />
                </div> -->

                <!-- <div class="custom-dropdown" style="width: 57%; margin-right: 5px;">
                    <select name="lotteryname" class="form-control form-select" id="bl-status"
                        data-bs-placeholder="Select Type">
                        <option value="0"><?= $translator['Status']; ?></option>
                        <option value="1"><?= $translator['In Force']; ?></option>
                        <option value="2"><?= $translator['Not Active']; ?></option>
                        <option value="3"><?= $translator['Terminated']; ?></option>
                        <option value="4"><?= $translator['Deleted']; ?></option>
                    </select>
                </div> -->
                <!-- <input type="date" name="startdate" class="form-control startdate" placeholder="Name" id="wl-startdate" style="width: 50%;">

            <input type="date" name="enddate" class="form-control enddate" placeholder="Name" id="wl-enddate" style="width: 50%;"> -->
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topplist-right" id="paginations" aria-label="Page navigation example">
            <div class="btn-group mb-2" role="group" aria-label="Basic example"
                style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <button type="button" class="btn bg-white-subtle player refreshuserpayment" value="" aria-label="Refresh"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class="bx bx-refresh" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle bl-search   Searchuserpaymentrans" value="" aria-label="Searchuserpayment"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Searchuserpayment">
                    <i class="bx loaderlist bx-check-double" style="font-size: 20px;"></i>
                </button>
            </div>
        </span>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperuserpaymentcard" id="maskuserpayment"
            style="height: 530px; overflow-y: scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered">
                <thead class="text-dark fs-4 tbl-headeruserpayment">
                    <tr class="headrowuserpayment">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Username']; ?></h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Total Payment Method']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Payment Type']; ?></h6>
                        </th>


                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class='bx bx-dots-vertical-rounded'></i></h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="usercardContainer">
                    <tr class="no-resultslist">
                        <td colspan="9">
                            <img src="<?php echo BASE_URL; ?>assets/images/not_found.jpg" class="dark-logo"
                                alt="Logo-Dark" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="px-4 py-3 border-top pagerlist">
        <span class="toplist-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example"
                style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <button type="button" class="btn bg-white-subtle playerusercard" value="leftlinks">
                    <i class="bx bx-chevron-left" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playerusercard" value="rightlinks">
                    <i class="bx bx-chevron-right" style="font-size: 20px;"></i>
                </button>
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <span id="paging_infobankcard" style="color: #aaa;">---</span>
        </span>
        <span class="toplist-right" id="paginationusercard" aria-label="Page navigation example">
            <!--Dynamic pagination-->
        </span>
    </div>
</div>

<div class="modal fade" id="danger-depobsitsc" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content modal-filled" style="background-color: #f9f9f9;">
            <div class="modal-body p-4">
                <div class="text-center text-danger">
                    <i class="ti ti-hexagon-letter-x fs-7"></i>
                    <h4 class="mt-2">Oh snap!</h4>
                    <p class="mt-3" style="color: #aaa;">
                        All fields are required! Select one or more data fields to filter.
                    </p>
                    <button type="button" class="btn my-2" data-bs-dismiss="modal" style="background-color: #ddd;">
                        Okay
                    </button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addContactMbodavov" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <div>
                    <h5>User Payment Method</h5>
                </div>
                <div><i class="bx bx-message-square-x tclose"
                        style="color: #868c87; font-size: 25px; cursor: pointer;"></i></div>
            </div>
            <div class="modal-body">
                <div class="add-contact-box">
                    <div class="add-contact-content">
                        <form id="add[CbontactModalTitle">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3 contact-location">
                                        <input type="text" id="c-b-bankcard" class="form-control"
                                            placeholder="Update all User Payment Method" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex gap-6 m-0">
                    <!-- <button id="btn-add" class="btn btn-light">Add</button> -->
                    <button id="btn-setalldeposibt[" class="btn btn-light" data-bs-dismiss="modal">Save</button>
                    <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Discard</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="Userpaymentmodal" class="modal fade" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between">
                        <div>Bank Payment Method</div>
                        <div><i class="bx bx-message-square-x tclose"
                                style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal"
                                aria-label="Close"></i></div>
                    </div>
                </div>
                <form>
                    <div class="row" id="viewbetdatahide">
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <tbody id="row1"></tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <tbody id="row2"></tbody>
                            </table>
                        </div>
                    </div>
                </form>

                <div id="loadingIndicator" class="spinner-border text-primary" role="status"
                    style="display: none; position: relative; left: 40%;">
                    <span class="sr-only">Loading...</span>
                </div>

                <div id="userpaymenttbl">
                    <table class="table table-hover table-bordered text-nowrap mb-0 table-responsive" id="uerpaymenttbl">
                        <thead>
                            <tr>
                                <!-- <th class="font-weight-normal">#</th> -->
                                <th class="font-weight-normal">Payment Method</th>
                                <th class="font-weight-normal">Payment Type</th>
                                <th class="font-weight-normal">Status</th>
                                <th class="font-weight-normal">Action</th>

                            </tr>
                        </thead>
                        <tbody class="">

                        </tbody>
                    </table>
                </div>

                <div id="loadingIndicator" class="spinner-border text-primary" role="status"
                    style="display: none; position: relative; left: 40%;">
                    <span class="sr-only">Loading...</span>
                </div>


            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>