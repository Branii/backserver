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

    .table-wrapperwithdraws {
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

    .optionlists {
        text-align: left;
        border-bottom: solid 1px #eee;
        padding: 5px;
     }

    .optionlists:hover {
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
    .table-wrapperwithdraws::-webkit-scrollbar {
        width: 5px;
        /* Slimmer scrollbar width */
        height: 5px;
        /* Slimmer scrollbar height for horizontal scrolling */
    }

    .table-wrapperwithdraws::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Lighter background for track */
        border-radius: 5px;
    }

    .table-wrapperwithdraws::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Blue color for thumb */
        border-radius: 10px;
        cursor: pointer;
    }

    .table-wrapperwithdraws::-webkit-scrollbar-thumb:hover {
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

  .arr {
    color: #909aa9;
    margin: 0px 1rem;
    }

    .withdrawsDropdowns {
      width: 11%;
    position: absolute;
    background-color: #fff;
    color: #aaa;
    max-height: 300px;
    overflow-y: scroll;
    border-radius: 5px;
    padding: 10px;
    top: 90%;
    z-index: 9;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    display: none;
}


.withdrawsDropdowns::-webkit-scrollbar {
    width: 3px;
    /* Width of the scrollbar */
}

.withdrawsDropdowns::-webkit-scrollbar-track {
    background: #f0f0f0;
    /* Background of the scrollbar track */
    border-radius: 5px;
    /* Rounded corners */
}

.withdrawsDropdowns::-webkit-scrollbar-thumb {
    background: #ccc;
    /* Color of the scrollbar handle */
    border-radius: 5px;
    /* Rounded corners */
}

.withdrawsDropdowns::-webkit-scrollbar-thumb:hover {
    background: #aaa;
    /* Darker handle color on hover */
}


</style>



<span id="tr_page" style="display:none"><?= $translator['Page'] ?></span>
<span id="tr_of" style="display:none"><?= $translator['of'] ?></span>
<span id="tr_pages" style="display:none"><?= $translator['pages'] ?></span>

<span id="status_pending" style="display:none;"><?= $translator['status_pending'] ?></span>
<span id="status_success" style="display:none;"><?= $translator['status_success'] ?></span>
<span id="status_failed" style="display:none;"><?= $translator['status_failed'] ?></span>

<span id="channel_momo" style="display:none;"><?= $translator['channel_momo'] ?></span>
<span id="channel_crypto" style="display:none;"><?= $translator['channel_crypto'] ?></span>
<span id="channel_bank" style="display:none;"><?= $translator['channel_bank'] ?></span>
<span id="channel_manual" style="display:none;"><?= $translator['channel_manual'] ?></span>


<div class="card w-100 position-relative overflow-hidden">

    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"><?= $translator['Withdrawal Manage']; ?></h4>
    </div>

    <div class="px-4 py-3 border-bottom pagerlist">
        <span class="top-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: 130%;">
                <input type="text" id="withdrawalnames" class="form-control widrl-queryholdertrans widrl-username mytrans" placeholder="<?= $translator['Search usernames']; ?>">
                <input name="usernames" type="hidden"  id="widrl-userIDs" class="userIdtrans widrl-queryholdertrans">
                <select class="form-control withdrawsDropdowns" size="5" style="display: none;" id="users-options-wrappers" >

                </select>
                <input type="text" class="form-control widrl-queryholdertrans orderid" id="widrl-IDs" aria-describedby="name" placeholder=" <?= $translator['Search Withdrawal ID']; ?>">

                <select name="lotteryname" id="widrl-channelss" class="form-control form-select widrl-queryholdertrans tracklotery " data-bs-placeholder="Select Type">
                    <option value=""><?= $translator['Withdrawal Channels']; ?></option>
                    <option value="3"><?= $translator['Momo']; ?></option>
                    <option value="2"><?= $translator['Bank']; ?></option>
                    <option value="5"><?= $translator['Crypto']; ?></option>
                    <option value="4"><?= $translator['Manual']; ?></option>
                </select>

                <select name="lotteryname" id="widrl-states" class="form-control form-select widrl-queryholdertrans tracklotery " data-bs-placeholder="Select Type">
                    <option value=""><?= $translator['Withdrawal Status']; ?></option>
                    <option value="2"><?= $translator['Approved']; ?></option>
                    <option value="1"><?= $translator['Pending']; ?></option>
                    <option value="3"><?= $translator['Rejected']; ?></option>

                </select>
                <select name="lotteryname" class="form-control form-select widrl-queryholdertrans selectpartner"> 

                </select>
                 
                <input type="date"  class="form-control widrl-queryholdertrans wdrl-startdates"  aria-describedby="name" placeholder="Start Date">
                <input type="date"  class="form-control widrl-queryholdertrans wdrl-enddates"    aria-describedby="name" placeholder="End Date">

            </div>
       

        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topplist-right" id="paginations" aria-label="Page navigation example">

            <div class="btn-group mb-2" role="group" aria-label="Basic example"
                style="border:solid 1px #eee;color:#bbb;background-color:#fff">
                
                <button type="button" class="btn bg-white-subtle player refreshwithdraws" value="right" aria-label="Refresh"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class='bx bx-refresh' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle widrl-searchs" value="end" aria-label="Execute"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class='bx bx-check-double loaderwithdraws' style="font-size:20px"></i>
                </button>
            </div>

        </span>

    </div>

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperwithdraws" id="maskwithdraws" style="height:530px;overflow-y:scroll;">
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
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Timezone/hrs']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Status']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Approved By']; ?></h6>
                        </th>
                         <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class="bx bx-dots-vertical-rounded"></i></h6>
                        </th>
                        
                    </tr>
                </thead>
                <tbody id="withdrawContainers">

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
                <button type="button" class="btn bg-white-subtle playerwithdraws" data-page="widrl-leftlinkss">
                    <i class='bx bx-chevron-left' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playerwithdraws" data-page="widrl-rightlinkss">
                    <i class='bx bx-chevron-right' style="font-size:20px"></i>
                </button>
                
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">

            <span id="paging_infowithdraws" style="color:#aaa">---</span>

        </span>
        <span class="top-right-btn"  aria-label="Page navigation example">
           <select class="left-element form-control numrowstrans" id="widrl-numrowstanss" style="font-size: 12px;">
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="200">200</option>
            <option value="500">500</option>
            </select>
            <span class="right-element" id="paginationwithdraws">
                <!--Dynamic pagination-->
            </span>

        </span>

    </div>

</div>



   
    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn mb-1 bg-info-subtle text-info  px-4 fs-4 " data-bs-toggle="modal" data-bs-target="#al-info-alert">
        Info Alert
    </button> -->

    <!-- Vertically centered modal -->
    <div class="modal fade" id="al-info-alert" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content modal-filled bg-info-subtle">
                <div class="modal-body p-4">
                    <div class="text-center text-gray">
                        <i class="bx bx-message-square-x tcloses fs-7"></i>
                        <h4 class="mt-2">Heads up!</h4>
                        <p class="mt-3">
                           Are you sure you want to approve this withdrawal?
                        </p>
                        <button type="button" class="btn btn-light my-2 btncontinue" data-bs-dismiss="modal">
                            Continue
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
 
  

  


