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

.queryholderquota {
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
.table-wrapperfinances::-webkit-scrollbar {
    width: 5px;
    /* Slimmer scrollbar width */
    height: 5px;
    /* Slimmer scrollbar height for horizontal scrolling */
}

.table-wrapperfinances::-webkit-scrollbar-track {
    background: #f1f1f1;
    /* Lighter background for track */
    border-radius: 5px;
}

.table-wrapperfinances::-webkit-scrollbar-thumb {
    background-color: #ccc;
    /* Blue color for thumb */
    border-radius: 10px;
    cursor: pointer;
}

.table-wrapperfinances::-webkit-scrollbar-thumb:hover {
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

.financeDropdowns {
    /* width: 23%; */
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

.financeDropdown {
    width: 24%;
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

.queryholderlistt {
    width: 29%;
    margin-right: 5px;
    background-color: #fff;
}

/* Style for the scrollbar */
.financeDropdown::-webkit-scrollbar {
    width: 3px;
    /* Width of the scrollbar */
}

.financeDropdown::-webkit-scrollbar-track {
    background: #f0f0f0;
    /* Background of the scrollbar track */
    border-radius: 5px;
    /* Rounded corners */
}

.financeDropdown::-webkit-scrollbar-thumb {
    background: #ccc;
    /* Color of the scrollbar handle */
    border-radius: 5px;
    /* Rounded corners */
}

.financeDropdown::-webkit-scrollbar-thumb:hover {
    background: #aaa;
    /* Darker handle color on hover */
}


.tbl-financeheads {
    position: sticky;
    top: 0;
}

.sticky-financeheads {
    position: relative;
    bottom: 1px;
    background-color: red;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
}

.optionlist {
    text-align: left;
    border-bottom: solid 1px #eee;
    padding: 5px;
}

.optionlist:hover {
    background-color: #eee;
}
</style>




<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> <?= $translator['Payment Platform']; ?></h4>
    </div>

    <div class="px-4 py-3 border-bottom pagerlist">
        <span class="top-left-btn" style="width: 70%;">
        <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: 100%;">
        <div style="width: 35%;">
          
          <input name="resultsList" class="queryholderlist form-control bring-forward" id="platformNames" data-user-id="" placeholder="<?= $translator['Platform Names']; ?>" autocomplete="off" style="width: 98%;"> <div class="pp-names-wrapper ngp-usr-res-wrapper" style="width: 20.5%;"> <ul style="max-height: 403px;margin: 0px; overflow-y:auto;" id="pp-names-list-wrapper"></ul> </div>
          <input name="usernames" type="hidden" id="selectedID" value="">
        </div>
                
                

                <select name="betsate" id="platformCurrency" class="form-control form-select queryholderlistt messagestype currency-list" data-bs-placeholder="Select Type">
                    <option value="">-Currency<?= $translator['Currency']; ?>-</option>
                </select>

                <select name="betsate" id="platformStatus" class="form-control form-select queryholderlistt messagestype " data-bs-placeholder="Select Type">
                    <option value="">-<?= $translator['Status']; ?>-</option>
                    <option value="active"><?= $translator['Active']; ?></option>
                    <option value="hidden"><?= $translator['Hidden']; ?></option></option>
                    <option value="inactive"><?= $translator['Inactive']; ?></option></option>
                 
                </select>
                <input name="startdate" id="platformStartDate" type="date" class="form-control queryholderlistt startfmessage" placeholder="Name">

                <input name="enddate" id="platformEndDate" type="date" class="form-control queryholderlistt endmessage" placeholder="Name">
            </div>
            <!-- <div class="input-group mb-3">
				<span class="input-group-text" id="basic-addon12" style="background-color:rgb(238,238,238,.4);border:solid 1px #ddd"><i class='bx bx-search' style="font-size:18px;"></i></span>
				<input type="text" class="form-control queryholder userrebate" placeholder="Enter Rebate (%)" aria-label="Username" aria-describedby="basic-addon1" />
			</div> -->
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topplist-right" id="paginations" aria-label="Page navigation example">
            <div class="btn-group mb-2" role="group" aria-label="Basic example"
                style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <!-- <i ' ></i> -->
                <button type="button" class="btn bg-white-subtle" id="addPaymentPlatformBtn" value="right" aria-label="Refresh"
                    aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Add Payment Platform">
                    <i class="bx bx-plus" style="font-size: 20px;"></i>
                </button>

                <button type="button" class="btn bg-white-subtle player pp-refresh" value="right"
                    aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class="bx bx-refresh" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle search-payment-platform" value="end" aria-label="Execute"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class="bx bx-check-double" style="font-size: 20px;"></i>
                </button>
                <!-- <button type="button" class="btn bg-white-subtle executedeposit" value="end" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class="bx bx-check-double loaderdeposit" style="font-size: 20px;"></i>
                </button> -->
            </div>
        </span>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperfinances" id="maskfinances"
            style="height: 530px; overflow-y: scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered">
                <thead class="text-dark fs-4 tbl-financeheads">
                    <tr class="financeheadrows">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Payment Type']; ?></h6>
                        </th>

                        <!-- <th>
                            <h6 class="fs-4 fw-semibold mb-0">Currency Type</h6>
                        </th> -->
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"> <?= $translator['Currency']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Site Url']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"> <?= $translator['Admin Site Url']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Fees']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Min. Amount']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Max. Amount']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Date Created']; ?></h6>
                        </th>
                        
                       <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Created By']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Last Updated']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Last Update By']; ?></h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Status']; ?></h6>
                        </th>
                       
                        
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class='bx bx-dots-vertical-rounded'></i></h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="pp-dtholder">
                    <tr class="no-resultslist">
                        <td colspan="9">
                            <img src="<?php echo BASE_URL; ?>assets/images/notfound.png" class="dark-logo"
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
                <!-- <button type="button" class="btn bg-white-subtle playerfinance" value="startli">
                    <i class="bx bx-chevrons-left" style="font-size: 20px;"></i>
                </button> -->
                <button type="button" class="btn bg-white-subtle playerfinance" value="leftlin">
                    <i class="bx bx-chevron-left" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playerfinance" value="rightlin">
                    <i class="bx bx-chevron-right" style="font-size: 20px;"></i>
                </button>
                <!-- <button type="button" class="btn bg-white-subtle playerfinance" value="endlin">
                    <i class="bx bx-chevrons-right" style="font-size: 20px;"></i>
                </button> -->
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <span id="paging_infofmessage" style="color: #aaa;">---</span>
        </span>
        <span class="top-right-btn" aria-label="Page navigation example">
            <select class="left-element form-control numrowsnotfy" style="font-size: 12px;">
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="500">500</option>
            </select>
            <span class="toplist-right" id="paginationmessage" aria-label="Page navigation example">
                <!--Dynamic pagination-->
            </span>

        </span>

    </div>
</div>

<div id="addNewPaymentPlatform" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <?= $translator['Add Payment Platform']; ?></h5>
                <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
            </div>
            <div class="scrollable-container">
                <div class="card border mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Enzerhub <?= $translator['Payment Platforms']; ?></h4>
                        <form id="pp-personalDetailsForm">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="userName" class="form-label"><?= $translator['Partner']; ?> (<span style="color: #a01616;">*</span>)</label>
                                        <input type="text" class="form-control" id="pp-contact" placeholder="Enzerhub" disabled="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pp-currency" class="form-label"> <?= $translator['Currency']; ?> (<span style="color: #a01616;">*</span>)</label>
                                        <select id="pp-currency" class="form-select currency-list"></select>
                                    </div>
                                    
                                    
                                   <div class="mb-3">
                                        <label for="pp-status" class="form-label"><?= $translator['Status']; ?> (<span style="color: #a01616;">*</span>)</label>
                                        <select id="pp-status" class="form-select">
                                            <option value="active"><?= $translator['Active']; ?></option>
                                            <option value="hidden"><?= $translator['Hidden']; ?></option>
                                            <option value="inactive"><?= $translator['Inactive']; ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    
                                    
                                    <div class="mb-3">
                                        <label for="pp-payment-type" class="form-label"><?= $translator['Payment Type']; ?> (<span style="color: #a01616;">*</span>)</label>
                                        <select id="pp-payment-type" class="form-select pp-payment-types"></select>
                                    </div><div class="mb-3">
                                        <label for="pp-fee" class="form-label"> <?= $translator['Fee']; ?>(%) (<span style="color: #a01616;">*</span>)</label>
                                        <input type="text" class="form-control" id="pp-fee" placeholder="<?= $translator['Fee']; ?>(%)">
                                    </div>
                                <div class="mb-3">
                                        <label for="pp-priority" class="form-label"><?= $translator['Priority']; ?></label>
                                        <input type="text" class="form-control" id="pp-priority" placeholder="<?= $translator['Priority']; ?>">
                                    </div></div>
                                <div class="col-6">
                                    
                                    <div class="mb-3">
                                        <label for="pp-info" class="form-label"><?= $translator['Info/Description']; ?></label>
                                        <textarea type="text" class="form-control" id="pp-info" cols="15" rows="10" placeholder="<?= $translator['Info/Description']; ?>" style="height: 235px;"></textarea>
                                    </div>
                                <div class="mb-3">
                                        <label for="pp-site-url" class="form-label"> <?= $translator['Site Url']; ?></label>
                                        <input type="text" class="form-control" id="pp-site-url" placeholder="e.g www.enzerhub.com">
                                    </div><div class="mb-3">
                                        <label for="pp-admin-site-rul" class="form-label"><?= $translator['Admin Site Url']; ?></label>
                                        <input type="text" class="form-control" id="pp-admin-site-url" placeholder="e.g www.enzerhub.com">
                                    </div>
                                </div>
                                <div class="col-6">
                                    
                                    <div class="mb-3">
                                        <label for="pp-min-amount" class="form-label"><?= $translator['Min. Amount']; ?></label>
                                        <input type="text" class="form-control" id="pp-min-amount" placeholder="<?= $translator['Min. Amount']; ?>">
                                    </div><div class="mb-3">
                                        <label for="pp-max-amount" class="form-label"><?= $translator['Max. Amount']; ?></label>
                                        <input type="text" class="form-control" id="pp-max-amount" placeholder="<?= $translator['Max. Amount']; ?>">
                                    </div>
                                <div class="mb-3">
         <label for="pp-site-url" class="form-label"><?= $translator['Countries']; ?></label>
    <div class="modal-body scrollable-container">
                        <div style="overflow: scroll;height: 256px;">
                            <table class="table table-hover table-bordered text-nowrap mb-0" id="quotatable">
                                
                                                           
 <tbody class="pp-countries-list-wrapper" id="pp-countries-list">

<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Afghanistan']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Albania']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Algeria']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Andorra']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Angola']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Antigua and Barbuda']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Argentina']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Armenia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Armenia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Austria']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Azerbaijan']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Bahamas']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Bahrain']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Bangladesh']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Barbados']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Belarus']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Belgium']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Belize']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Benin']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Bhutan']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Bolivia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Bosnia and Herzegovina']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Botswana']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Brazil']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Brunei']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Bulgaria']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Burkina Faso']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Burundi']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Côte dIvoire']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Cabo Verde']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Cambodia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Cameroon']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Canada']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Central African Republic']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Chad']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Chile']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['China']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Colombia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Comoros']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Costa Rica']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Croatia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Cuba']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Cyprus']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Czech Republic']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Democratic Republic of the Congo']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Denmark']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Djibouti']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Dominica']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Dominican Republic']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Ecuador']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Egypt']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['El Salvador']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Equatorial Guinea']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Eritrea']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Estonia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Eswatini']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Ethiopia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Federated States of Micronesia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Fiji']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Finland']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['France']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Gabon']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Gambia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Georgia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Germany']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Ghana']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Greece']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Grenada']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Guatemala']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Guinea']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Guinea-Bissau']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Guyana']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Haiti']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Honduras']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Hungary']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Iceland']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['India']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Indonesia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Iran']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Iraq']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Ireland']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Israel']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Italy']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Jamaica']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Japan']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Jordan']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Kazakhstan']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Kenya']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Kiribati']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Kosovo']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Kuwait']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Kyrgyzstan']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Laos']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Latvia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Lebanon']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Lesotho']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Liberia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Libya']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Liechtenstein']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Lithuania']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Luxembourg']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['North Macedonia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Madagascar']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Malawi']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Malaysia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Maldives']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Mali']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Malta']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Marshall Islands']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Mauritania']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Mauritius']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Mexico']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Moldova']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Monaco']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Mongolia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Montenegro']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Morocco']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Mozambique']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Myanmar']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Namibia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Nauru']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Nepal']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Netherlands']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['New Zealand']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Nicaragua']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Niger']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Nigeria']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['North Korea']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Norway']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Oman']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Pakistan']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Palau']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Panama']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Papua New Guinea']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Paraguay']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Peru']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Philippines']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Poland']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Portugal']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Qatar']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Republic of the Congo']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Romania']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Russia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Rwanda']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['St Kitts and Nevis']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['St Lucia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['St Vincent and the Grenadines']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Samoa']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Sao Tome and Principe']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Sao Tome and Principe']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Saudi Arabia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Senegal']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Serbia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Seychelles']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Sierra Leone']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Singapore']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Slovakia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Slovenia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Solomon Islands']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Somalia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['South Africa']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['South Korea']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['South Sudan']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Spain']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Sri Lanka']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Sudan']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Suriname']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Sweden']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Switzerland']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Syria']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Taiwan']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Tajikistan']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Tanzania']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Thailand']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Timor-Leste']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Togo']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Tonga']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Trinidad and Tobago']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Tunisia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Turkey']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Turkmenistan']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Tuvalu']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Uganda']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Ukraine']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['United Arab Emirates']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['United Kingdom']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['United States']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Uruguay']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Uzbekistan']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Vanuatu']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Vatican City']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Venezuela']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Vietnam']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Yemen']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Zambia']; ?></span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault" ></td>
  <td><span class="pp-lottery-name"><?= $translator['Zimbabwe']; ?></span></td>
</tr>

</tbody>

        </table>
             </div>
                    </div>
                                        
                                    </div></div>
                            </div>
                        <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-primary" id="addNewPaymentPlatformBtn"><?= $translator['Save']; ?></button>
                                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal"><?= $translator['Cancel']; ?></button>
                            </div></form>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>

<div id="editPaymentPlatform" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $translator['Add Payment Platform']; ?></h5>
                <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
            </div>
            <div class="scrollable-container">
                <div class="card border mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Enzerhub <?= $translator['Payment Platforms']; ?></h4>
                        <form id="pp-personalDetailsForm">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="userName" class="form-label"><?= $translator['Partner']; ?> (<span style="color: #a01616;">*</span>)</label>
                                        <input type="text" class="form-control" id="pp-contact" placeholder="Enzerhub" disabled="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pp-currency-edit" class="form-label"><?= $translator['Currency']; ?> (<span style="color: #a01616;">*</span>)</label>
                                        <select id="pp-currency-edit" class="form-select currency-list"></select>
                                    </div>
                                    
                                    
                                   <div class="mb-3">
                                        <label for="pp-status-edit" class="form-label">Status (<span style="color: #a01616;">*</span>)</label>
                                        <select id="pp-status-edit" class="form-select">
                                            <option value="active"><?= $translator['Active']; ?></option>
                                            <option value="hidden"><?= $translator['Hidden']; ?></option>
                                            <option value="inactive"><?= $translator['Inactive']; ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    
                                    
                                    <div class="mb-3">
                                        <label for="pp-payment-type-edit" class="form-label"><?= $translator['Payment Type']; ?> (<span style="color: #a01616;">*</span>)</label>
                                        <select id="pp-payment-type-edit" class="form-select pp-payment-types"></select>
                                    </div><div class="mb-3">
                                        <label for="pp-fee-edit" class="form-label"><?= $translator['Fee']; ?> (%) (<span style="color: #a01616;">*</span>)</label>
                                        <input type="text" class="form-control" id="pp-fee-edit" placeholder="Fee (%)">
                                    </div>
                                <div class="mb-3">
                                        <label for="pp-priority-edit" class="form-label"><?= $translator['Priority']; ?></label>
                                        <input type="text" class="form-control" id="pp-priority-edit" placeholder="Priority">
                                    </div></div>
                                <div class="col-6">
                                    
                                    <div class="mb-3">
                                        <label for="pp-info-edit" class="form-label"><?= $translator['Info/Description']; ?></label>
                                        <textarea type="text" class="form-control" id="pp-info-edit" cols="15" rows="10" placeholder="Info/Description" style="height: 235px;"></textarea>
                                    </div>
                                <div class="mb-3">
                                        <label for="pp-site-url-edit" class="form-label"><?= $translator['Site Url']; ?></label>
                                        <input type="text" class="form-control" id="pp-site-url-edit" placeholder="e.g www.enzerhub.com">
                                    </div><div class="mb-3">
                                        <label for="pp-admin-site-url-edit" class="form-label"><?= $translator['Admin Site Url']; ?></label>
                                        <input type="text" class="form-control" id="pp-admin-site-url-edit" placeholder="e.g www.enzerhub.com">
                                    </div>
                                </div>
                                <div class="col-6">
                                    
                                    <div class="mb-3">
                                        <label for="pp-min-amount-edit" class="form-label"><?= $translator['Min. Amount']; ?></label>
                                        <input type="text" class="form-control" id="pp-min-amount-edit" placeholder="Min. Amount">
                                    </div><div class="mb-3">
                                        <label for="pp-max-amount-edit" class="form-label"><?= $translator['Max. Amount']; ?></label>
                                        <input type="text" class="form-control" id="pp-max-amount-edit" placeholder="Max. Amount">
                                    </div>
                                <div class="mb-3">
         <label for="pp-countries-edit" class="form-label"><?= $translator['Countries']; ?></label>
    <div class="modal-body scrollable-container">
                        <div style="overflow: scroll;height: 256px;">
                            <table class="table table-hover table-bordered text-nowrap mb-0" id="quotatable">
                             <tbody class="pp-payment-countries-edit" id="edit-countries-tbody"></tbody>   

        </table>
             </div>
                    </div>
                                        
                                    </div></div>
                            </div>
                        <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-primary" id="editPaymentPlatformBtn"><?= $translator['Save']; ?></button>
                                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal"><?= $translator['Cancel']; ?></button>
                            </div></form>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>

<!-- <div id="editPaymentPlatform" class="modal fade" tabindex="-1" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Payment Platform</h5>
                <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
            </div>
            <div class="scrollable-container">
                <div class="card border mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Enzerhub Payment Platforms</h4>
                        <form id="pp-personalDetailsForm">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="userName" class="form-label">Partner</label>
                                        <input type="text" class="form-control" id="pp-contact" placeholder="Enzerhub" disabled="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pp-currency-edit" class="form-label">Currency</label>
                                        <select id="pp-currency-edit" class="form-select currency-list"></select>
                                    </div>
                                    
                                    
                                   <div class="mb-3">
                                        <label for="pp-status-edit" class="form-label">Status</label>
                                        <select id="pp-status-edit" class="form-select">
                                            <option value="active">Active</option>
                                            <option value="hidden">Hidden</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    
                                    
                                    <div class="mb-3">
                                        <label for="pp-payment-type-edit" class="form-label">Payment Type</label>
                                        <select id="pp-payment-type-edit" class="form-select pp-payment-types" disabled></select>
                                    </div><div class="mb-3">
                                        <label for="pp-fee-edit" class="form-label">Fee (%)</label>
                                        <input type="text" class="form-control" id="pp-fee-edit" placeholder="Fee (%)">
                                    </div>
                                </div>
                                <div class="col-6">
                                    
                                    <div class="mb-3">
                                        <label for="pp-min-amount-edit" class="form-label">Min. Amount</label>
                                        <input type="text" class="form-control" id="pp-min-amount-edit" placeholder="Min. Amount">
                                    </div>
                                <div class="mb-3">
                                        <label for="pp-admin-site-url-edit" class="form-label">Admin Site Url</label>
                                        <input type="text" class="form-control" id="pp-admin-site-url-edit" placeholder="e.g www.enzerhub.com">
                                    </div>
                                </div>
                                <div class="col-6">
                                    
                                    <div class="mb-3">
                                        <label for="pp-max-amount-edit" class="form-label">Max. Amount</label>
                                        <input type="text" class="form-control" id="pp-max-amount-edit" placeholder="Max. Amount">
                                    </div>
                                <div class="mb-3">
                                        <label for="pp-site-url-edit" class="form-label">Site Url</label>
                                        <input type="text" class="form-control" id="pp-site-url-edit" placeholder="e.g www.enzerhub.com">
                                    </div></div>
                            </div>
                        <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-primary" id="editPaymentPlatformBtn">Save</button>
                                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Cancel</button>
                            </div></form>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div> -->