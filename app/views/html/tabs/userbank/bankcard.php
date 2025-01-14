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

    .table-wrapperbankcard {
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
    .table-wrapperbankcard::-webkit-scrollbar {
        width: 5px;
        /* Slimmer scrollbar width */
        height: 5px;
        /* Slimmer scrollbar height for horizontal scrolling */
    }

    .table-wrapperbankcard::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Lighter background for track */
        border-radius: 5px;
    }

    .table-wrapperbankcard::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Blue color for thumb */
        border-radius: 10px;
        cursor: pointer;
    }

    .table-wrapperbankcard::-webkit-scrollbar-thumb:hover {
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
</style>

<div class="card w-100 position-relative overflow-hidden">

    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"><?= $translator['Bank Card List']; ?></h4>
    </div>

    <div class="px-4 py-3 border-bottom pagerlist">
        <span class="top-left-btn">
            <!-- <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding:5px;width:auto">
            <input type="text" class="form-control product-search ps-5 userrebate" id="input-rsearch" placeholder="Search Rebate..." />
            <i class="bx bx-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            
            </div> -->
            <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon12" style="background-color:rgb(238,238,238,.4);border:solid 1px #ddd"><i class='bx bx-search' style="font-size:18px;"></i></span>
                    <input type="text" class="form-control queryholder userrebate" placeholder="Enter Rebate (%)" aria-label="Username" aria-describedby="basic-addon1" />
          </div>

        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topplist-right" id="paginations" aria-label="Page navigation example">

            <div class="btn-group mb-2" role="group" aria-label="Basic example"
                style="border:solid 1px #eee;color:#bbb;background-color:#fff">
                <!-- <i ' ></i> -->
                <!-- <button type="button" class="btn bg-white-subtle player setallbankcard" value="right" aria-label="Refresh"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Set all bankcard">
                    <i class='bx bx-plus' style="font-size:20px"></i>
                </button> -->
                <button type="button" class="btn bg-white-subtle player refreshbankcard" value="right" aria-label="Refresh"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class='bx bx-refresh' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle executeuserlinks" value="end" aria-label="Execute"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class='bx bx-check-double loaderlinks' style="font-size:20px"></i>
                </button>
            </div>

        </span>

    </div>

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperbankcard" id="maskbanks" style="height:530px;overflow-y:scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered">
                <thead class="text-dark fs-4">
                    <tr>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Username']; ?></h6>
                        </th>
                      
						<th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Bank Name']; ?></h6>
                        </th>
						<th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Cardholder']; ?></h6>
                        </th>
						
						<th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Bank Card Number']; ?></h6>
                        </th>
						<th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Successful Withdrawal Count']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Binding Time']; ?></h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Status']; ?></h6>
                        </th>
                        <!-- <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class='bx bx-dots-vertical-rounded'></i></h6>
                        </th> -->
                    </tr>
                </thead>
                <tbody id="bankcardContainer">

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
                <button type="button" class="btn bg-white-subtle playerbankcard" value="leftlinks">
                    <i class='bx bx-chevron-left' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playerbankcard" value="rightlinks">
                    <i class='bx bx-chevron-right' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playerbankcard" value="endlinks">
                    <i class='bx bx-chevrons-right' style="font-size:20px"></i>
                </button>
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">

            <span id="paging_infobankcard" style="color:#aaa">---</span>

        </span>
        <span class="toplist-right" id="paginationbankcard" aria-label="Page navigation example">

            <!--Dynamic pagination-->

        </span>

    </div>

</div>

<div class="modal fade" id="danger-depobsitsc" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
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
<div class="modal fade" id="addContactMbodavov" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <div>  <h5>bankcard</h5></div>
                <div><i class='bx bx-message-square-x tclose' style='color:#868c87;font-size:25px;cursor:pointer;' ></i></div>
            </div>
            <div class="modal-body">
                <div class="add-contact-box">
                    <div class="add-contact-content">
                        <form id="add[CbontactModalTitle">
                             
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3 contact-location">
                                        <input type="text" id="c-b-bankcard" class="form-control" placeholder="Update all bankcard" />
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