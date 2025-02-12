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

    .table-wrapperwithdraw {
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

    .queryholderwithdraw {
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
    .table-wrapperwithdraw::-webkit-scrollbar {
        width: 5px;
        /* Slimmer scrollbar width */
        height: 5px;
        /* Slimmer scrollbar height for horizontal scrolling */
    }

    .table-wrapperwithdraw::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Lighter background for track */
        border-radius: 5px;
    }

    .table-wrapperwithdraw::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Blue color for thumb */
        border-radius: 10px;
        cursor: pointer;
    }

    .table-wrapperwithdraw::-webkit-scrollbar-thumb:hover {
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

    .widrl-queryholdertrans {   

        width: 11%;
        margin-right: 5px;
        background-color: #fff;
    }
    .table-head-widrl {
    position: sticky;
    top: 0;
  }

  .sticky-table-head-widrl {
    position: relative;
    bottom: 1px;
    background-color: red;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
  }
</style>

<div class="card w-100 position-relative overflow-hidden">

    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"><?= $translator['Withdrawal Records']; ?></h4>
    </div>

    <div class="px-4 py-3 border-bottom pagerlist">
        <span class="top-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: 165%;">
                <input type="text" id="mytrans" class="form-control widrl-queryholdertrans widrl-username mytrans" placeholder="Search usernames">
                <input name="usernames" type="hidden"  id="widrl-userID" class="userIdtrans widrl-queryholdertrans">
                <select class="form-control trackdown" size="5" style="display: none; width: 11%;background:#fff;" id="users-options-wrapper" ></select>
                <input type="text" class="form-control widrl-queryholdertrans orderid" id="widrl-ID" aria-describedby="name" placeholder="Search Withdrawal ID">

                <div class="custom-dropdown" style="width: 12%; margin-right: 5px;">
                    <select name="lotteryname" id="widrl-channels" class="form-control form-select queryholderlist tracklotery " data-bs-placeholder="Select Type">
                        <option value="0">Withdrawal Channels</option>
                        <option value="3">Momo</option>
                        <option value="2">Bank</option>
                        <option value="5">Crypto</option>
                        <option value="4">Manual</option>
                    </select>
                 </div>
                <div class="custom-dropdown" style="width: 11%; margin-right: 5px;">
                    <select name="lotteryname" id="widrl-status" class="form-control form-select queryholderlist tracklotery " data-bs-placeholder="Select Type">
                        <option value="0">Status</option>
                        <option value="1">Pending</option>
                        <option value="2">Success</option>
                        <option value="3">Failed</option>
                    </select>
                 </div>

                <input type="date"  class="form-control widrl-queryholdertrans wdrl-startdate" id="widrl-startDate" aria-describedby="name" placeholder="Start Date">
                <input type="date"  class="form-control widrl-queryholdertrans wdrl-enddate"   id="widrl-endDate" aria-describedby="name" placeholder="End Date">

            </div>
       

        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topplist-right" id="paginations" aria-label="Page navigation example">

            <div class="btn-group mb-2" role="group" aria-label="Basic example"
                style="border:solid 1px #eee;color:#bbb;background-color:#fff">
                
                <button type="button" class="btn bg-white-subtle player refreshwithdrawa" value="right" aria-label="Refresh"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class='bx bx-refresh' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle widrl-search" value="end" aria-label="Execute"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class='bx bx-check-double loaderlinks' style="font-size:20px"></i>
                </button>
            </div>

        </span>

    </div>

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperwithdraw" id="maskwithdraw" style="height:530px;overflow-y:scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered">
                <thead class="text-dark fs-4 table-head-widrl">
                    <tr class="tbl-row-widrl">

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Withdrawal ID']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Username']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Level']; ?></h6>
                        </th>
						<th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Bank Type']; ?></h6>
                        </th>
						<th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Withdrawal Channel']; ?></h6>
                        </th>
						<th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Cardholder']; ?></h6>
                        </th>
						
						<th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Bank Card Number']; ?>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Withdrawal Amount']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Fee']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Actual Withdrawal Amount']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Withdrawal Application Time']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Status']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Approved By']; ?></h6>
                        </th>
                        
                    </tr>
                </thead>
                <tbody id="withdrawContainer">

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
                <button type="button" class="btn bg-white-subtle playerwithdraw" data-page="widrl-leftlinks">
                    <i class='bx bx-chevron-left' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playerwithdraw" data-page="widrl-rightlinks">
                    <i class='bx bx-chevron-right' style="font-size:20px"></i>
                </button>
                
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">

            <span id="paging_infowithdraw" style="color:#aaa">---</span>

        </span>
        <span class="top-right-btn"  aria-label="Page navigation example">
        <select class="left-element form-control numrowstrans" id="widrl-numrowstans" style="font-size: 12px;">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="50">50</option>
            </select>
        <span class="right-element" id="paginationwithdraw">
            <!--Dynamic pagination-->
        </span>

        </span>

    </div>

</div>

<div class="modal fade" id="danger-depobsits" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
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
<div class="modal fade" id="add=ContactMbodavoc" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <div>  <h5><?= $translator['withdraw']; ?></h5></div>
                <div><i class='bx bx-message-square-x tclose' style='color:#868c87;font-size:25px;cursor:pointer;' ></i></div>
            </div>
            <div class="modal-body">
                <div class="add-contact-box">
                    <div class="add-contact-content">
                        <form id="add=CbontactModalTitle">
                             
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3 contact-location">
                                        <input type="text" id="c-b-withdraw" class="form-control" placeholder="Update all withdraw" />
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
                    <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal"> Discard
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>