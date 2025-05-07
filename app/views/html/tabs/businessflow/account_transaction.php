<style>
    .pager {
        position: relative;
        /* Sets positioning context for absolute elements inside */
        padding: 20px;
        height: 80px;
        background-color: #f9f9f9;
    }

    .pager1 {
        position: relative;
        /* Sets positioning context for absolute elements inside */
        padding: 20px;
        height: 80px;
        background-color: #f9f9f9;
    }

    .top-left-btn {
        position: absolute;
        top: 10px;
        /* Distance from the top */
        left: 10px;
        /* Distance from the left */
        padding: 5px 10px;
        /* background-color: red; */
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .top-center {
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

    .top-right-btn {
        position: absolute;
        top: 10px;
        /* Distance from the top */
        right: 10px;
        /* Distance from the right */
        padding: 5px 10px;
        /* background-color: red; */
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        /* Optional: Adds space between elements */
        align-items: center;
        /* Optional: Vertically centers the elements */
    }

    .topp-right {
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

    .table-wrapperaccount {
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

    .queryholdertransaction {
        width: 39%;
        margin-right: 7px;
        background-color: white;
    }

    /* .acc_transaction_username {
            width: 19%;
            position: absolute;
            color: #aaa;
            max-height: 300px;
            overflow-y: scroll;
            border-radius: 5px;
            padding: 10px;
            top: 90%;
            z-index: 9999;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
            display: none;
        } */
    .option {
        text-align: left;
        border-bottom: solid 1px #eee;
        padding: 5px;
    }

    .option:hover {
        background-color: #eee;
    }

    .no-results {
        text-align: center;
        /* Center horizontally */
        vertical-align: middle;
        /* Center vertically */
        height: 20px;
        /* Set a minimum height to ensure centering */
        border: none;
    }

    .no-results img {
        position: relative;
        top: 100px;
    }

    /* Custom Scrollbar for Webkit Browsers */
    .table-wrapperaccount::-webkit-scrollbar {
        width: 5px;
        /* Slimmer scrollbar width */
        height: 5px;
        /* Slimmer scrollbar height for horizontal scrolling */
    }

    .table-wrapperaccount::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Lighter background for track */
        border-radius: 5px;
    }

    .table-wrapperaccount::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Blue color for thumb */
        border-radius: 10px;
        cursor: pointer;
    }

    .table-wrapperaccount::-webkit-scrollbar-thumb:hover {
        background-color: #aaa;
        /* Darker blue on hover */
    }

    .left-element {
        position: relative;
        bottom: 8px;
        height: 35px;
        background-color: #fff;
        margin-right: 5px;
    }

    .active>.page-link {
        background-color: orangered !important;
        border: none;
    }

    .tbl-header {
        position: sticky;
        background-color: red;
        top: 0;
    }

    .sticky-header {
        position: relative;
        bottom: 1px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
    }

    .pins {
        padding: 5px;
        border-bottom: solid 1px rgb(110, 129, 146, 0.1);
    }

    .useraccount {
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
    .useraccount::-webkit-scrollbar {
        width: 3px;
        /* Width of the scrollbar */
    }

    .useraccount::-webkit-scrollbar-track {
        background: #f0f0f0;
        /* Background of the scrollbar track */
        border-radius: 5px;
        /* Rounded corners */
    }

    .useraccount::-webkit-scrollbar-thumb {
        background: #ccc;
        /* Color of the scrollbar handle */
        border-radius: 5px;
        /* Rounded corners */
    }

    .useraccount::-webkit-scrollbar-thumb:hover {
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
</style>
<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"><?= $translator['Account Transaction Details']; ?></h4>
    </div>
    <div class="px-4 py-3 border-bottom pager1">
        <span class="top-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: auto;">
                <input type="text" id="transuser" class="form-control queryholdertransaction usernames transuser"
                    placeholder="<?= $translator['Search Username']; ?>" />
                <input name="usernames" type="hidden" class="" />
                <select class="form-control useraccount" size="5" style="display: none;" id="userAccountDropdown">
                    <!-- Options will be populated dynamically -->
                </select>
                <input type="text" class="form-control queryholdertransaction clearitem" id="transactionId"
                    aria-describedby="name" placeholder="<?= $translator['Search Transaction ID']; ?>" />

                <select name="order_type" class="form-control form-select queryholdertransaction " id="ordertypetrans"
                    data-bs-placeholder="Select Type">
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
                </select>

                <select name="lotteryname" class="form-control form-select queryholdertransaction selectpartner"> 

                </select>
           
                <input type="date" class="form-control queryholdertransaction" id="startdatrans" aria-describedby="name"
                    placeholder="Name" />
                <input type="date" class="form-control queryholdertransaction" id="enddatetrans" aria-describedby="name"
                    placeholder="Name" />
            </div>
        </span>
        <span class="top-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topp-right" id="paginations" aria-label="Page navigation example">
            <div class="btn-group mb-2" role="group" aria-label="Basic example"
                style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <button type="button" class="btn bg-white-subtle" value="right" aria-label="Refresh"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="PDF">
                    <i class="bx bx-file" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle" value="right" aria-label="Refresh"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="XLS">
                    <i class="bx bx-file-blank" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle" value="right">
                    ::
                </button>
                <button type="button" class="btn bg-white-subtle accountrefresh" value="right" aria-label="Refresh"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?= $translator['Refresh']; ?>">
                    <i class="bx bx-refresh" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle executetrans" value="end" aria-label="Execute"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?= $translator['Execute']; ?>">
                    <i class="bx bx-check-double loadertrans" style="font-size: 20px;"></i>
                </button>
            </div>
        </span>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperaccount" id="mask"
            style="height: 530px; overflow-y: scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered table-hover">
                <thead class="text-dark fs-4 tbl-header">
                    <tr class="accheaderrow">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['ID Number']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Username']; ?></h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Partner Name</h6>
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
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Transaction Time']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Time Zone/Hrs']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Transaction ID']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Status']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class="bx bx-dots-vertical-rounded"></i></h6>
                        </th>
                    </tr>
                </thead>

                <tbody id="dataContainer" class="tbl-content">
                    <tr class="no-results">
                        <td colspan="9">
                            <img src="<?php echo BASE_URL; ?>assets/images/notfound.png" class="dark-logo"
                                alt="Logo-Dark" />
                        </td>
                    </tr>

                
                </tbody>
                
            </table>
           
        </div>
        

    </div>
    <div class="px-4 py-3 border-top pager">
        <span class="top-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example"
                style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <!-- <button type="button" class="btn bg-white-subtle player" value="start">
                    <i class="bx bx-chevrons-left" style="font-size: 20px;"></i>
                </button> -->
                <button type="button" class="btn bg-white-subtle playertrans" value="lefttrans">
                    <i class="bx bx-chevron-left" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playertrans" value="righttrans">
                    <i class="bx bx-chevron-right" style="font-size: 20px;"></i>
                </button>
                <!-- <button type="button" class="btn bg-white-subtle player" value="end">
                    <i class="bx bx-chevrons-right" style="font-size: 20px;"></i>
                </button> -->
            </div>
        </span>
        <span class="top-center" aria-label=" navigation example">
            <span id="paging_info" style="color: #aaa;">---</span>
        </span>
        <span class="top-right-btn" aria-label="Page navigation example">
            <select class="left-element form-control numrowstrans" style="font-size: 12px;">

                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="500">500</option>
            </select>
            <span id="pagination" class="right-element">--pagination--- </span>
        </span>
    </div>
</div>

<div id="signup-modal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between">
                        <div><?= $translator['Transaction Info']; ?></div>
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

                <div id="transacttbl">
                    <table class="table table-hover table-bordered text-nowrap mb-0 table-responsive" id="transtbl">
                        <thead>
                            <tr>
                                <!-- <th class="font-weight-normal">#</th> -->
                                <th class="font-weight-normal"><?= $translator['Username']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Level']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Deposit/Withdrawal Type']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Transaction Amount']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Balance']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Transaction Time']; ?></th>
                                <!-- <th class="font-weight-normal"><?= $translator['Turnover Requirement']; ?></th> -->
                                <!-- <th class="font-weight-normal">Bet Slip</th> -->
                                <th class="font-weight-normal"><?= $translator['Reviews']; ?></th>
                            </tr>
                        </thead>
                        <tbody class="">
                            <?php

                            ?>
                        </tbody>
                    </table>
                </div>

                <div id="loadingIndicator" class="spinner-border text-primary" role="status"
                    style="display: none; position: relative; left: 40%;">
                    <span class="sr-only">Loading...</span>
                </div>

                <div id="transredenvelop">
                    <table class="table table-hover table-bordered text-nowrap mb-0 table-responsive" id="transtbls">
                        <thead>
                            <tr>
                                <th class="font-weight-normal"><?= $translator['ID Number']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Username']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Transaction Type']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Amount']; ?></th>
                                <!-- <th class="font-weight-normal"><?= $translator['Credit Amount']; ?></th> -->
                                <th class="font-weight-normal"><?= $translator['Balance']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Date/Time']; ?></th>
                                <!-- <th class="font-weight-normal"><?= $translator['Game']; ?></th> -->
                                <th class="font-weight-normal"><?= $translator['Transaction ID']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Status']; ?></th>
                                <!-- <th class="font-weight-normal"><?= $translator['Reviews']; ?></th> -->
                            </tr>
                        </thead>
                        <tbody class="">
                            <?php

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<script class="translations" type="application/json">
<?= json_encode($translator); ?>
</script>