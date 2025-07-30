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

    .queryholder {
        width: 19%;
        margin-right: 5px;
        background-color: #fff;
    }

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
    .table-wrapperexcept::-webkit-scrollbar {
        width: 5px;
        /* Slimmer scrollbar width */
        height: 5px;
        /* Slimmer scrollbar height for horizontal scrolling */
    }

    .table-wrapperexcept::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Lighter background for track */
        border-radius: 5px;
    }

    .table-wrapperexcept::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Blue color for thumb */
        border-radius: 10px;
        cursor: pointer;
    }

    .table-wrapperexcept::-webkit-scrollbar-thumb:hover {
        background-color: #aaa;
        /* Darker blue on hover */
    }

    .table-wrapperexcept {
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

    .sticky-headerexcept {
        position: relative;
        bottom: 1px;
        background-color: red;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
    }

    .left-element {
        position: relative;
        bottom: 8px;
        height: 35px;
        background-color: #fff;
        margin-right: 5px;
    }

    .active > .page-link {
        background-color: orangered !important;
        border: none;
    }

    .tbl-headerexcept {
        position: sticky;
        top: 0;
    }

    .pins {
        padding: 5px;
        border-bottom: solid 1px rgb(110, 129, 146, 0.1);
    }
</style>




<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"><?= $translator['Lottery Exception']; ?></h4>
    </div>

    <div class="px-4 py-3 border-bottom pagerlist1">
        <span class="top-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: 110%;">
                 <div class="custom-dropdown" style="width:75%; margin-right: 5px;">
                <select name="betsate" class="form-control form-select queryholderlistt typelotterys selectlottery" data-bs-placeholder="Select Type">
                    <option value="0">--<?= $translator['Select Lottery']; ?>--</option>
                   
                 </select>
                </div>
                 
                <select name="lotteryname" class="form-control form-select queryholderlistt selectpartner" style="width: 70%;"> 

                </select>
               
                 <input type="text" class="form-control queryholderlistt" id="drawperiod" aria-describedby="name"placeholder="Search Issue Number" style="width: 70%;"/>
                 <input type="date" class="form-control queryholderlistt" id="exceptdate" aria-describedby="name"placeholder="Name" />
                <input type="date" class="form-control queryholderlistt" id="exceptdates" aria-describedby="name"placeholder="Name" />
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topplist-right" id="paginations" aria-label="Page navigation example">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
              
              <button type="button" class="btn bg-white-subtle player exceptrefresh" value="" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class="bx bx-refresh" style="font-size: 20px;"></i>
             </button>              
                <button type="button" class="btn bg-white-subtle fetchexcept" value="" aria-label="Search" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Search">
                    <i class="bx bx-check-double loaderexcept" style="font-size: 20px;"></i>
                </button>

            </div>
        </span>
    </div>

    <!-- These spans are invisible but hold the translation text -->

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperexcept" id="maskexcept" style="height: 530px; overflow-y: scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered table-hover">
                <thead class="text-dark fs-4 tbl-headerexcept">
                    <tr class="headrowexcept">
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
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Issue Number']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Total Counts']; ?></h6>
                        </th>
                         <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Total Bet Settled']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Total Bet Unsettled']; ?></h6>
                        </th>
                         <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Cancel / Refund']; ?></h6>
                        </th>
                         <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Bet Time']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Time Zone/Hrs']; ?></h6>
                        </th>
                       
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class="bx bx-dots-vertical-rounded"></i></h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="lotteryexceptionholder" class="tbl-content">
                    <tr class="no-results">
                        <td colspan="9">
                            <img src="<?php echo BASE_URL; ?>assets/images/notfound.png" class="dark-logo" alt="Logo-Dark" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="px-4 py-3 border-top pager">
        <span class="top-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <button type="button" class="btn bg-white-subtle playerexcept" value="exceptleft">
                    <i class="bx bx-chevron-left" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playerexcept" value="exceptright">
                    <i class="bx bx-chevron-right" style="font-size: 20px;"></i>
                </button>
            </div>
        </span>
        <span class="top-center" aria-label=" navigation example">
            <span id="paging_infoexcept" style="color: #aaa;">---</span>
        </span>

        <span id="lb-pagination-pages-wrapper" class="top-right-btn" aria-label="Page navigation example">
            <select class="left-element form-control exceptnumrows" style="font-size: 12px;">
                <option value="50"><?= $translator['50'] ?? '50' ?></option>
                <option value="100"><?= $translator['100'] ?? '100' ?></option>
                <option value="200"><?= $translator['200'] ?? '200' ?></option>
                <option value="500"><?= $translator['500'] ?? '500' ?></option>                         
            </select>
            <span id="except-pagination" class="right-element"> </span>
        </span>
    </div>
</div>
