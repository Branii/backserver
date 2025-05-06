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

.no-resultslist ptns-no-result {
    text-align: center;
    /* Center horizontally */
    vertical-align: middle;
    /* Center vertically */
    height: 20px;
    /* Set a minimum height to ensure centering */
    border: none;
}

.no-resultslist ptns-no-result img {
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

.dark-red {
  color: #af0404;
}
</style>




<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">Partners</h4>
    </div>
<input name="data-holder" id="data-holder" type="hidden" data-row-id="" data-payment-platform-id="">
    <div class="px-4 py-3 border-bottom pagerlist">
        <span class="top-left-btn" style="width: 70%;">
        <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: 100%;">
        
                
                

                <select name="betsate" id="ptns-partners" class="form-control form-select queryholderlistt messagestype" data-bs-placeholder="Select Type"></select>

                <select name="betsate" id="ptns-partnerState" class="form-control form-select queryholderlistt messagestype " data-bs-placeholder="Select Type">
                    <option value="">-State-</option>
                    <option value="active">Active</option>
                    <option value="blocked">Blocked</option>
                    <option value="inactive">Inactive</option>
                 
                </select>
                <input name="startdate" id="ptns-partnerStartDate" type="date" class="form-control queryholderlistt startfmessage" placeholder="Name">

                <input name="enddate" id="ptns-partnerEndDate" type="date" class="form-control queryholderlistt endmessage" placeholder="Name">
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topplist-right" id="ptns-paginations" aria-label="Page navigation example">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <!-- <i ' ></i> -->
                <button type="button" class="btn bg-white-subtle" id="ptns-addPartnerBtn" value="right" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add Payment partner">
                    <i class="bx bx-plus" style="font-size: 20px;"></i>
                </button>

                <button type="button" id="ptns-refresh" class="btn bg-white-subtle player" value="right" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class="bx bx-refresh" style="font-size: 20px;"></i>
                </button>
                <button type="button" id="ptns-search" class="btn bg-white-subtle" value="end" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class="bx bx-check-double" style="font-size: 20px;"></i>
                </button>
                <!-- <button type="button" class="btn bg-white-subtle executedeposit" value="end" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class="bx bx-check-double loaderdeposit" style="font-size: 20px;"></i>
                </button> -->
            </div>
        </span>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperfinances" id="ptns-maskfinances"
            style="height: 37rem; overflow-y: scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered">
                <thead class="text-dark fs-4 tbl-financeheads">
                    <tr class="financeheadrows">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">ID</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Name</h6>
                        </th>
                          <th>
                            <h6 class="fs-4 fw-semibold mb-0">Currency</h6>
                        </th> 
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Site Url</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Admin Site Url</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                        </th>
                        
                       <th>
                            <h6 class="fs-4 fw-semibold mb-0">Creation Time</h6>
                        </th>
                       <th>
                            <h6 class="fs-4 fw-semibold mb-0">Timezone/Hrs</h6>
                        </th>
                       <th>
                            <h6 class="fs-4 fw-semibold mb-0">Creation By</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Last Updated</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Last Update By</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">View/Edit</h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="ptns-pp-dtholder">
                    <tr class="no-resultslist ptns-no-result">
                        <td colspan="12">
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
            <span id="ptns-paging_infofmessage" style="color: #aaa;">---</span>
        </span>
        <span class="top-right-btn" aria-label="Page navigation example">
            <select class="left-element form-control numrowsnotfy" style="font-size: 12px;">
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="500">500</option>
            </select>
            <span class="toplist-right" id="ptns-paginationmessage" aria-label="Page navigation example">
                <!--Dynamic pagination-->
            </span>

        </span>

    </div>
</div>

<div id="ptns-addNewPartnerDialog" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Partners</h5>
                <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
            </div>
            <div class="scrollable-container">
                <div class="card border mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Add Partner</h4>
                        <form id="ptns-pp-personalDetailsForm">
                            <div class="row">
                                
                                <div class="col-lg-6">
                                    
                                    
                                    <div class="mb-3">
                                        <label for="partner-name" class="form-label">Partner Name (<span style="color: #a01616;">*</span>)</label>
                                        <input type="text" class="form-control" id="ptns-partner-name" placeholder="e.g Enzerhub">
                                    </div><div class="mb-3">
                                        <label for="ptns-site-url" class="form-label">Site Url (<span style="color: #a01616;">*</span>)</label>
                                        <input type="text" class="form-control" id="ptns-site-url" placeholder="e.g www.enzerhub.com">
                                    </div><div class="mb-3">
                                        <label for="ptns-admin-site-rul" class="form-label">Admin Site Url (<span style="color: #a01616;">*</span>)</label>
                                        <input type="text" class="form-control" id="ptns-admin-site-url" placeholder="e.g www.enzerhub.com">
                                    </div>
                                  </div>
                                <div class="col-6">
                                    
                                    
                                  <div class="mb-3">
                            <label for="pp-countries-edit" class="form-label">Currency </label>
                        
                                        
                                    <select id="ptns-currency" class="form-select currency-list"></select></div>
                                <div class="mb-3">
                                        <label for="ptns-status" class="form-label">Select State (<span style="color: #a01616;">*</span>)</label>
                                        
                                    <select id="ptns-status" class="form-select" disabled="">
                                            <option value="inactive">Inactive</option>
                                        </select></div></div>
                                
                            
                                </div>
                        <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-primary" id="ptns-addNewPartnerBtn">Save</button>
                                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Cancel</button>
                            </div></form>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>

<div id="ptns-editPaymentpartner" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Payment partner</h5>
                <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
            </div>
            <div class="scrollable-container">
                <div class="card border mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Enzerhub Payment partners</h4>
                        <form id="ptns-pp-personalDetailsForm">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="userName" class="form-label">Partner (<span style="color: #a01616;">*</span>)</label>
                                        <input type="text" class="form-control" id="ptns-pp-contact" placeholder="Enzerhub" disabled="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pp-currency-edit" class="form-label">Currency (<span style="color: #a01616;">*</span>)</label>
                                        <select id="ptns-pp-currency-edit" class="form-select currency-list"></select>
                                    </div>
                                    
                                    
                                   <div class="mb-3">
                                        <label for="pp-status-edit" class="form-label">Status (<span style="color: #a01616;">*</span>)</label>
                                        <select id="ptns-pp-status-edit" class="form-select">
                                            <option value="active">Active</option>
                                            <option value="hidden">Hidden</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    
                                    
                                    <div class="mb-3">
                                        <label for="pp-payment-type-edit" class="form-label">Payment Type (<span style="color: #a01616;">*</span>)</label>
                                        <select id="ptns-pp-payment-type-edit" class="form-select pp-payment-types"></select>
                                    </div><div class="mb-3">
                                        <label for="partner-name-edit" class="form-label">Fee (%) (<span style="color: #a01616;">*</span>)</label>
                                        <input type="text" class="form-control" id="partner-name-edit" placeholder="Fee (%)">
                                    </div>
                                <div class="mb-3">
                                        <label for="pp-priority-edit" class="form-label">Priority</label>
                                        <input type="text" class="form-control" id="ptns-pp-priority-edit" placeholder="Priority">
                                    </div></div>
                                <div class="col-6">
                                    
                                    <div class="mb-3">
                                        <label for="pp-info-edit" class="form-label">Info/Description</label>
                                        <textarea type="text" class="form-control" id="ptns-pp-info-edit" cols="15" rows="10" placeholder="Info/Description" style="height: 235px;"></textarea>
                                    </div>
                                <div class="mb-3">
                                        <label for="pp-site-url-edit" class="form-label">Site Url</label>
                                        <input type="text" class="form-control" id="ptns-pp-site-url-edit" placeholder="e.g www.enzerhub.com">
                                    </div><div class="mb-3">
                                        <label for="pp-admin-site-url-edit" class="form-label">Admin Site Url</label>
                                        <input type="text" class="form-control" id="ptns-pp-admin-site-url-edit" placeholder="e.g www.enzerhub.com">
                                    </div>
                                </div>
                                <div class="col-6">
                                    
                                    <div class="mb-3">
                                        <label for="pp-min-amount-edit" class="form-label">Min. Amount</label>
                                        <input type="text" class="form-control" id="ptns-pp-min-amount-edit" placeholder="Min. Amount">
                                    </div><div class="mb-3">
                                        <label for="pp-max-amount-edit" class="form-label">Max. Amount</label>
                                        <input type="text" class="form-control" id="ptns-pp-max-amount-edit" placeholder="Max. Amount">
                                    </div>
                                <div class="mb-3">
         <label for="pp-countries-edit" class="form-label">Countries <i class='bx bxs-minus-circle'></i></label>
    <div class="modal-body scrollable-container">
                        <div style="overflow: scroll;height: 256px;">
                            <table class="table table-hover table-bordered text-nowrap mb-0" id="ptns-quotatable">
                             <tbody class="pp-payment-countries-edit" id="ptns-edit-countries-tbody"></tbody>   

        </table>
             </div>
                    </div>
                                        
                                    </div></div>
                            </div>
                        <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-primary" id="ptns-editPaymentpartnerBtn">Save</button>
                                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Cancel</button>
                            </div></form>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>


<div class="card w-100 position-relative overflow-hidden" style="display:none;">
    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">Payment Platform</h4>
    </div>

    <div class="px-4 py-3 border-bottom pagerlist">
        <span class="top-left-btn" style="width: 70%;">
        <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: 100%;">
        <div style="width: 35%;">
          
          <input name="resultsList" class="queryholderlist form-control bring-forward" id="platformNames" data-user-id="" placeholder="Platform Names" autocomplete="off" style="width: 98%;"> <div class="pp-names-wrapper ngp-usr-res-wrapper" style="width: 20.5%;"> <ul style="max-height: 403px;margin: 0px; overflow-y:auto;" id="pp-names-list-wrapper"></ul> </div>
          <input name="usernames" type="hidden" id="selectedID" value="">
        </div>

                <select name="betsate" id="platformCurrency" class="form-control form-select queryholderlistt messagestype currency-list" data-bs-placeholder="Select Type">
                    <option value="">-Currency-</option>
                </select>

                <select name="betsate" id="platformStatus" class="form-control form-select queryholderlistt messagestype " data-bs-placeholder="Select Type">
                    <option value="">-Status-</option>
                    <option value="active">Active</option>
                    <option value="hidden">Hidden</option>
                    <option value="inactive">Inactive</option>
                 
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
                            <h6 class="fs-4 fw-semibold mb-0">Payment Type</h6>
                        </th>

                        <!-- <th>
                            <h6 class="fs-4 fw-semibold mb-0">Currency Type</h6>
                        </th> -->
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Currency</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Site Url</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Admin Site Url</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Fees</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Min. Amount</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Max. Amount</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Date Created</h6>
                        </th>
                        
                       <th>
                            <h6 class="fs-4 fw-semibold mb-0">Created By</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Last Updated</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Last Update By</h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Status</h6>
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

<div id="ptns-addNewPaymentPlatform" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
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
                                        <label for="userName" class="form-label">Partner (<span style="color: #a01616;">*</span>)</label>
                                        <input type="text" class="form-control" id="pp-contact" placeholder="Enzerhub" disabled="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pp-currency" class="form-label">Currency (<span style="color: #a01616;">*</span>)</label>
                                        <select id="pp-currency" class="form-select currency-list"></select>
                                    </div>
                                    
                                    
                                   <div class="mb-3">
                                        <label for="pp-status" class="form-label">Status (<span style="color: #a01616;">*</span>)</label>
                                        <select id="pp-status" class="form-select">
                                            <option value="active">Active</option>
                                            <option value="hidden">Hidden</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    
                                    
                                    <div class="mb-3">
                                        <label for="pp-payment-type" class="form-label">Payment Type (<span style="color: #a01616;">*</span>)</label>
                                        <select id="pp-payment-type" class="form-select pp-payment-types"></select>
                                    </div><div class="mb-3">
                                        <label for="pp-fee" class="form-label">Fee (%) (<span style="color: #a01616;">*</span>)</label>
                                        <input type="text" class="form-control" id="pp-fee" placeholder="Fee (%)">
                                    </div>
                                <div class="mb-3">
                                        <label for="pp-priority" class="form-label">Priority</label>
                                        <input type="text" class="form-control" id="pp-priority" placeholder="Priority">
                                    </div></div>
                                <div class="col-6">
                                    
                                    <div class="mb-3">
                                        <label for="pp-info" class="form-label">Info/Description</label>
                                        <textarea type="text" class="form-control" id="pp-info" cols="15" rows="10" placeholder="Info/Description" style="height: 235px;"></textarea>
                                    </div>
                                <div class="mb-3">
                                        <label for="pp-site-url" class="form-label">Site Url</label>
                                        <input type="text" class="form-control" id="pp-site-url" placeholder="e.g www.enzerhub.com">
                                    </div><div class="mb-3">
                                        <label for="pp-admin-site-rul" class="form-label">Admin Site Url</label>
                                        <input type="text" class="form-control" id="pp-admin-site-url" placeholder="e.g www.enzerhub.com">
                                    </div>
                                </div>
                                <div class="col-6">
                                    
                                    <div class="mb-3">
                                        <label for="pp-min-amount" class="form-label">Min. Amount</label>
                                        <input type="text" class="form-control" id="pp-min-amount" placeholder="Min. Amount">
                                    </div><div class="mb-3">
                                        <label for="pp-max-amount" class="form-label">Max. Amount</label>
                                        <input type="text" class="form-control" id="pp-max-amount" placeholder="Max. Amount">
                                    </div>
                                <div class="mb-3">
         <label for="pp-site-url" class="form-label">Countries <i class='bx bxs-minus-circle'></i></label>
    <div class="modal-body scrollable-container">
                        <div style="overflow: scroll;height: 256px;">
                            <table class="table table-hover table-bordered text-nowrap mb-0" id="quotatable">
                                
                                                           
 <tbody class="pp-countries-list-wrapper" id="pp-countries-list">

<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Afghanistan</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Albania</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Algeria</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Andorra</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Angola</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Antigua and Barbuda</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Argentina</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Armenia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Australia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Austria</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Azerbaijan</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Bahamas</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Bahrain</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Bangladesh</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Barbados</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Belarus</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Belgium</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Belize</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Benin</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Bhutan</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Bolivia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Bosnia and Herzegovina</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Botswana</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Brazil</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Brunei</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Bulgaria</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Burkina Faso</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Burundi</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Côte d'Ivoire</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Cabo Verde</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Cambodia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Cameroon</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Canada</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Central African Republic</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Chad</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Chile</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">China</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Colombia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Comoros</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Costa Rica</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Croatia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Cuba</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Cyprus</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Czech Republic</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Democratic Republic of the Congo</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Denmark</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Djibouti</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Dominica</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Dominican Republic</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Ecuador</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Egypt</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">El Salvador</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Equatorial Guinea</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Eritrea</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Estonia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Eswatini</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Ethiopia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Federated States of Micronesia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Fiji</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Finland</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">France</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Gabon</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Gambia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Georgia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Germany</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Ghana</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Greece</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Grenada</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Guatemala</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Guinea</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Guinea-Bissau</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Guyana</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Haiti</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Honduras</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Hungary</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Iceland</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">India</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Indonesia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Iran</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Iraq</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Ireland</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Israel</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Italy</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Jamaica</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Japan</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Jordan</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Kazakhstan</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Kenya</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Kiribati</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Kosovo</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Kuwait</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Kyrgyzstan</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Laos</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Latvia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Lebanon</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Lesotho</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Liberia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Libya</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Liechtenstein</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Lithuania</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Luxembourg</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">North Macedonia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Madagascar</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Malawi</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Malaysia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Maldives</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Mali</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Malta</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Marshall Islands</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Mauritania</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Mauritius</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Mexico</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Moldova</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Monaco</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Mongolia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Montenegro</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Morocco</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Mozambique</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Myanmar</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Namibia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Nauru</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Nepal</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Netherlands</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">New Zealand</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Nicaragua</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Niger</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Nigeria</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">North Korea</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Norway</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Oman</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Pakistan</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Palau</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Panama</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Papua New Guinea</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Paraguay</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Peru</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Philippines</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Poland</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Portugal</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Qatar</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Republic of the Congo</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Romania</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Russia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Rwanda</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">St Kitts and Nevis</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">St Lucia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">St Vincent and the Grenadines</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Samoa</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">San Marino</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Sao Tome and Principe</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Saudi Arabia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Senegal</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Serbia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Seychelles</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Sierra Leone</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Singapore</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Slovakia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Slovenia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Solomon Islands</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Somalia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">South Africa</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">South Korea</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">South Sudan</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Spain</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Sri Lanka</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Sudan</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Suriname</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Sweden</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Switzerland</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Syria</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Taiwan</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Tajikistan</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Tanzania</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Thailand</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Timor-Leste</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Togo</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Tonga</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Trinidad and Tobago</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Tunisia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Turkey</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Turkmenistan</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Tuvalu</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Uganda</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Ukraine</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">United Arab Emirates</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">United Kingdom</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">United States</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Uruguay</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Uzbekistan</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Vanuatu</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Vatican City</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Venezuela</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Vietnam</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Yemen</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Zambia</span></td>
</tr>
<tr>
  <td><input class="form-check-input country-input " type="checkbox" value="1"  ></td>
  <td><span class="pp-lottery-name">Zimbabwe</span></td>
</tr>

</tbody>

        </table>
             </div>
                    </div>
                                        
                                </div>
                                
                                </div>
                            </div>
                        <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-primary" id="addNewPaymentPlatformBtn">Save</button>
                                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Cancel</button>
                            </div></form>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>

<div id="ptns-editPaymentPlatform" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
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
                                        <label for="userName" class="form-label">Partner (<span style="color: #a01616;">*</span>)</label>
                                        <input type="text" class="form-control" id="pp-contact" placeholder="Enzerhub" disabled="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pp-currency-edit" class="form-label">Currency (<span style="color: #a01616;">*</span>)</label>
                                        <select id="pp-currency-edit" class="form-select currency-list"></select>
                                    </div>
                                    
                                    
                                   <div class="mb-3">
                                        <label for="pp-status-edit" class="form-label">Status (<span style="color: #a01616;">*</span>)</label>
                                        <select id="pp-status-edit" class="form-select">
                                            <option value="active">Active</option>
                                            <option value="hidden">Hidden</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    
                                    
                                    <div class="mb-3">
                                        <label for="pp-payment-type-edit" class="form-label">Payment Type (<span style="color: #a01616;">*</span>)</label>
                                        <select id="pp-payment-type-edit" class="form-select pp-payment-types"></select>
                                    </div><div class="mb-3">
                                        <label for="pp-fee-edit" class="form-label">Fee (%) (<span style="color: #a01616;">*</span>)</label>
                                        <input type="text" class="form-control" id="pp-fee-edit" placeholder="Fee (%)">
                                    </div>
                                <div class="mb-3">
                                        <label for="pp-priority-edit" class="form-label">Priority</label>
                                        <input type="text" class="form-control" id="pp-priority-edit" placeholder="Priority">
                                    </div></div>
                                <div class="col-6">
                                    
                                    <div class="mb-3">
                                        <label for="pp-info-edit" class="form-label">Info/Description</label>
                                        <textarea type="text" class="form-control" id="pp-info-edit" cols="15" rows="10" placeholder="Info/Description" style="height: 235px;"></textarea>
                                    </div>
                                <div class="mb-3">
                                        <label for="pp-site-url-edit" class="form-label">Site Url</label>
                                        <input type="text" class="form-control" id="pp-site-url-edit" placeholder="e.g www.enzerhub.com">
                                    </div><div class="mb-3">
                                        <label for="pp-admin-site-url-edit" class="form-label">Admin Site Url</label>
                                        <input type="text" class="form-control" id="pp-admin-site-url-edit" placeholder="e.g www.enzerhub.com">
                                    </div>
                                </div>
                                <div class="col-6">
                                    
                                    <div class="mb-3">
                                        <label for="pp-min-amount-edit" class="form-label">Min. Amount</label>
                                        <input type="text" class="form-control" id="pp-min-amount-edit" placeholder="Min. Amount">
                                    </div><div class="mb-3">
                                        <label for="pp-max-amount-edit" class="form-label">Max. Amount</label>
                                        <input type="text" class="form-control" id="pp-max-amount-edit" placeholder="Max. Amount">
                                    </div>
                                <div class="mb-3">
         <label for="pp-countries-edit" class="form-label">Countries <i class='bx bxs-minus-circle'></i></label>
    <div class="modal-body scrollable-container">
                        <div style="overflow: scroll;height: 256px;">
                            <table class="table table-hover table-bordered text-nowrap mb-0" id="quotatable"><tbody class="pp-payment-countries-edit" id="edit-countries-tbody"></tbody></table>
             </div>
                    </div>
                                        
                                    </div>
                                  </div>
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
</div>


<div id="ptns-main-info-modal" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="
">
            <div class="modal-header">
                <h5 class="modal-title">Main Info</h5>
                <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
            </div>
            <div class="scrollable-container">
            <div class="card border mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Main Info</h4>
                        <form id="pp-personalDetailsForm">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="ptns-partner-id" class="form-label">ID (<span class="dark-red">*</span>)</label>
                                        <input type="text" class="form-control" id="ptns-partner-id" placeholder="Enzerhub" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ptns-partner-name-edit" class="form-label">Name (<span class="dark-red">*</span>)</label>
                                        
                                    <input type="text" class="form-control" id="ptns-partner-name-edit" placeholder="Name"></div>
                                    
                                    
                                   
                                <div class="mb-3">
                                        <label for="ptns-site-url-edit" class="form-label">Site Url (<span class="dark-red">*</span>)</label>
                                        <input type="text" class="form-control" id="ptns-site-url-edit" placeholder="e.g www.enzerhub.com">
                                    </div><div class="mb-3">
                                        <label for="ptns-admin-site-url-edit" class="form-label">Admin Site Url (<span class="dark-red">*</span>)</label>
                                        <input type="text" class="form-control" id="ptns-admin-site-url-edit" placeholder="e.g www.enzerhub.com">
                                    </div><div class="mb-3">
                                        <label for="ptns-client-min-age" class="form-label">Client Min Age </label>
                                        <input type="text" value="18" class="form-control" id="ptns-client-min-age" placeholder="18">
                                    </div><div class="mb-3">
                                        <label for="ptns-verification-type-edit" class="form-label">Verification Type </label>
                                        
                                    <select id="ptns-verification-type-edit" class="form-select">
                                      <option value="email">Email</option>
                                      <option value="phone">Phone</option>
                                      <option value="emailandphone">Email & Phone</option>
                                  </select></div><div class="mb-3">
                                        <label for="ptns-unused-withdrawal-amount" class="form-label">Unused Amount Withdraw</label>
                                        <input type="text" value="10" class="form-control" id="ptns-unused-withdrawal-amount" placeholder="e.g 10">
                                    </div></div>
                                <div class="col-lg-6">
                                    
                                    
                                    
                                <div class="mb-3">
                                        <label for="ptns-priority-edit" class="form-label">Priority</label>
                                        <input type="text" value="6" class="form-control" id="ptns-priority-edit" placeholder="e.g 6">
                                    </div><div class="mb-3">
                                        <label for="ptns-state-edit" class="form-label">State (<span class="dark-red">*</span>)</label>
                                        <select id="ptns-state-edit" class="form-select">
                                            <option value="active">Active</option>
                                            <option value="hidden">Hidden</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div><div class="mb-3">
                                        <label for="ptns-currency-edit" class="form-label">Currency (<span class="dark-red">*</span>)</label>
                                        <select id="ptns-currency-edit" class="form-select currency-list"><option value="">--Currency--</option>
                                      
                                      </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ptns-creation-time-edit" class="form-label">Creation Time</label>
                                        <input type="text" class="form-control" id="ptns-creation-time-edit" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ptns-created-by-edit" class="form-label">Created By</label>
                                        <input type="text" class="form-control" id="ptns-created-by-edit" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ptns-last-update-edit" class="form-label">Last Update</label>
                                        <input type="text" class="form-control" id="ptns-last-update-edit" disabled>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="ptns-update-by-edit" class="form-label">Update By</label>
                                        <input type="text" class="form-control" id="ptns-update-by-edit" disabled>
                                    </div>
                                   
                                  </div>
                                
                                <div class="col-6">
                                    
                                    
                                
                                  </div>
                            </div>
                        <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-primary" id="editPartnerMainInfoBtn">Save</button>
                                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Cancel</button>
                            </div></form>
                    </div>
                    
                </div>
          </div>
        </div>
    </div>
</div>


<div id="ptns-payment-platforms-modal" class="modal fade" tabindex="-1" aria-modal="true" role="dialog" >
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="width: 90rem;right: 227px;">
            <div class="modal-header">
                <h5 class="modal-title">Payment Settings</h5>
                <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
            </div>
            <div class="scrollable-container" style="">
                <div class="card w-100 position-relative overflow-hidden" style="/* display:none; */">
    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">Payment Settings</h4>
    </div>

    <div class="px-4 py-3 border-bottom pagerlist">
        <span class="top-left-btn" style="width: 70%;">
        <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: 100%;">
        <div style="width: 35%;">
          
          <input name="resultsList" class="queryholderlist form-control bring-forward" id="platformNames" data-user-id="" placeholder="Platform Names" autocomplete="off" style="width: 98%;"> <div class="pp-names-wrapper ngp-usr-res-wrapper" style="width: 20.5%;"> <ul style="max-height: 403px;margin: 0px; overflow-y:auto;" id="pp-names-list-wrapper"></ul> </div>
          <input name="usernames" type="hidden" id="selectedID" value="">
        </div>

                <select name="betsate" id="platformCurrency" class="form-control form-select queryholderlistt messagestype currency-list" data-bs-placeholder="Select Type">
                    <option value="">-Currency-</option>
                </select>

                <select name="betsate" id="platformStatus" class="form-control form-select queryholderlistt messagestype " data-bs-placeholder="Select Type">
                    <option value="">-Status-</option>
                    <option value="active">Active</option>
                    <option value="hidden">Hidden</option>
                    <option value="inactive">Inactive</option>
                 
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
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <!-- <i ' ></i> -->
                <button type="button" class="btn bg-white-subtle" id="addPaymentPlatformBtn" value="right" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add Payment Platform">
                    <i class="bx bx-plus" style="font-size: 20px;"></i>
                </button>

                <button type="button" class="btn bg-white-subtle player pp-refresh" value="right" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class="bx bx-refresh" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle search-payment-platform" value="end" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class="bx bx-check-double" style="font-size: 20px;"></i>
                </button>
                <!-- <button type="button" class="btn bg-white-subtle executedeposit" value="end" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class="bx bx-check-double loaderdeposit" style="font-size: 20px;"></i>
                </button> -->
            </div>
        </span>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperfinances" id="maskfinances" style="height: 530px; overflow-y: scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered">
                <thead class="text-dark fs-4 tbl-financeheads">
                    <tr class="financeheadrows">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Payment Type</h6>
                        </th>

                        <!-- <th>
                            <h6 class="fs-4 fw-semibold mb-0">Currency Type</h6>
                        </th> -->
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Currency</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Site Url</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Admin Site Url</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Fees</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Min. Amount</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Max. Amount</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Date Created</h6>
                        </th>
                        
                       <th>
                            <h6 class="fs-4 fw-semibold mb-0">Created By</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Last Updated</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Last Update By</h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                        </th>
                       
                        
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class="bx bx-dots-vertical-rounded"></i></h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="pp-dtholder">
                    <tr class="no-resultslist">
                        <td colspan="13">
                            <img src="<?php echo BASE_URL; ?>assets/images/notfound.png" class="dark-logo" alt="Logo-Dark">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="px-4 py-3 border-top pagerlist">
        <span class="toplist-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
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
                
            </div>
        </div>
    </div>
</div>

<div id="ptns-product-settings-modal" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="
    width: 30rem;
    left: 11rem;
">
            <div class="modal-header">
                <h5 class="modal-title">Product Settings</h5>
                <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
            </div>
            <div class="scrollable-container">
                <div class="card border mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Product Settings</h4>
                        <form id="pp-personalDetailsForm">
                            <div class="row">
                                <div class="col-6" style="width: 100%;">
                                <div class="mb-3">
         <label for="pp-site-url" class="form-label">Lotteries </label>
    <div class="modal-body scrollable-container">
                        <div style="overflow: scroll;height: 100%;">
                            <table class="table table-hover table-bordered text-nowrap mb-0" id="quotatable">                                   
 <tbody class="ptns-lotteries-list-wrapper" id="ptns-lotteries-list"></tbody>

        </table>
             </div>
                    </div>
                                        
                                </div>
                                
                                </div>
                            </div>
                        <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-primary" id="editPartnerLotteriesBtn">Save</button>
                                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Cancel</button>
                            </div></form>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>


<div id="ptns-currency-settings-modal" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="
    width: 30rem;
    left: 11rem;
">
            <div class="modal-header">
                <h5 class="modal-title">Currency Settings</h5>
                <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
            </div>
            <div class="scrollable-container">
                <div class="card border mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Currency Settings</h4>
                        <form id="pp-personalDetailsForm">
                            <div class="row">
                                <div class="col-6" style="width: 100%;">
                                <div class="mb-3">
    <div class="modal-body scrollable-container">
                        <div style="overflow: scroll;height: 100%;">
                            <table class="table table-hover table-bordered text-nowrap mb-0" id="quotatable">                                   
 <tbody class="ptns-currency-list-wrapper" id="ptns-currency-list"></tbody>

        </table>
             </div>
                    </div>
                                        
                                </div>
                                
                                </div>
                            </div>
                        <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-primary" id="editCurrencySettingsBtn">Save</button>
                                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Cancel</button>
                            </div></form>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>

<div id="ptns-languages-settings-modal" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="
    width: 30rem;
    left: 11rem;
">
            <div class="modal-header">
                <h5 class="modal-title">Languages Settings</h5>
                <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
            </div>
            <div class="scrollable-container">
                <div class="card border mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Languages Settings</h4>
                        <form id="pp-personalDetailsForm">
                            <div class="row">
                                <div class="col-6" style="width: 100%;">
                                <div class="mb-3">
    <div class="modal-body scrollable-container">
                        <div style="overflow: scroll;height: 100%;">
                            <table class="table table-hover table-bordered text-nowrap mb-0" id="quotatable">                                   
 <tbody class="ptns-currency-list-wrapper" id="ptns-languages-list"></tbody>

        </table>
             </div>
                    </div>
                                        
                                </div>
                                
                                </div>
                            </div>
                        <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-primary" id="editLanguageSettingsBtn">Save</button>
                                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Cancel</button>
                            </div></form>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>


<div id="ptns-paymennt-info-modal" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title">Payment Info</h5>
                <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
            </div>
            <div class="scrollable-container">
                <div class="card border mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Payment Info</h4>
                        <form id="pp-personalDetailsForm">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="userName" class="form-label">ID</label>
                                        <input type="text" class="form-control" id="pp-contact" placeholder="Enzerhub">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pp-currency-edit" class="form-label">Bank Name</label>
                                        
                                    <input type="text" class="form-control" id="pp-fee-edit" placeholder="Bank Name"></div>
                                    
                                    
                                   
                                <div class="mb-3">
                                        <label for="pp-site-url-edit" class="form-label">Bank Code</label>
                                        <input type="text" class="form-control" id="pp-site-url-edit" placeholder="e.g 123445">
                                    </div><div class="mb-3">
                                        <label for="pp-admin-site-url-edit" class="form-label">Bank Account Number</label>
                                        <input type="text" class="form-control" id="pp-admin-site-url-edit" placeholder="e.g 02343454654657565">
                                    </div><div class="mb-3">
                                        <label for="pp-site-url-edit" class="form-label">Bank Account Branch</label>
                                        <input type="text" value="Achimota" class="form-control" id="pp-site-url-edit" placeholder="Bank Account Branch">
                                    </div></div>
                                <div class="col-lg-6">
                                    
                                    
                                    <div class="mb-3">
                                        <label for="pp-admin-site-url-edit" class="form-label">IBAN</label>
                                        <input type="text" value="20" class="form-control" id="pp-admin-site-url-edit" placeholder="IBAN">
                                    </div><div class="mb-3">
                                        <label for="pp-fee-edit" class="form-label">Account Owner Name</label>
                                        <input type="text" value="1000" class="form-control" id="pp-fee-edit" placeholder="Account Owner Name">
                                    </div>
                                <div class="mb-3">
                                        <label for="pp-currency-edit" class="form-label">Currency</label>
                                        <select id="pp-currency-edit" class="form-select currency-list"><option value="">--Currency--</option><option value="AED">AED</option><option value="AFN">AFN</option><option value="ALL">ALL</option><option value="AMD">AMD</option><option value="ANG">ANG</option><option value="AOA">AOA</option><option value="ARS">ARS</option><option value="AUD">AUD</option><option value="AWG">AWG</option><option value="AZN">AZN</option><option value="BAM">BAM</option><option value="BBD">BBD</option><option value="BDT">BDT</option><option value="BGN">BGN</option><option value="BHD">BHD</option><option value="BIF">BIF</option><option value="BMD">BMD</option><option value="BND">BND</option><option value="BOB">BOB</option><option value="BOV">BOV</option><option value="BRL">BRL</option><option value="BSD">BSD</option><option value="BTN">BTN</option><option value="BWP">BWP</option><option value="BYN">BYN</option><option value="BZD">BZD</option><option value="CAD">CAD</option><option value="CDF">CDF</option><option value="CHE">CHE</option><option value="CHF">CHF</option><option value="CHW">CHW</option><option value="CLF">CLF</option><option value="CLP">CLP</option><option value="CNY">CNY</option><option value="COP">COP</option><option value="COU">COU</option><option value="CRC">CRC</option><option value="CUC">CUC</option><option value="CUP">CUP</option><option value="CVE">CVE</option><option value="CZK">CZK</option><option value="DJF">DJF</option><option value="DKK">DKK</option><option value="DOP">DOP</option><option value="DZD">DZD</option><option value="EGP">EGP</option><option value="ERN">ERN</option><option value="ETB">ETB</option><option value="EUR">EUR</option><option value="FJD">FJD</option><option value="FKP">FKP</option><option value="GBP">GBP</option><option value="GEL">GEL</option><option value="GHS">GHS</option><option value="GIP">GIP</option><option value="GMD">GMD</option><option value="GNF">GNF</option><option value="GTQ">GTQ</option><option value="GYD">GYD</option><option value="HKD">HKD</option><option value="HNL">HNL</option><option value="HRK">HRK</option><option value="HTG">HTG</option><option value="HUF">HUF</option><option value="IDR">IDR</option><option value="ILS">ILS</option><option value="INR">INR</option><option value="IQD">IQD</option><option value="IRR">IRR</option><option value="ISK">ISK</option><option value="JMD">JMD</option><option value="JOD">JOD</option><option value="JPY">JPY</option><option value="KES">KES</option><option value="KGS">KGS</option><option value="KHR">KHR</option><option value="KMF">KMF</option><option value="KPW">KPW</option><option value="KRW">KRW</option><option value="KWD">KWD</option><option value="KYD">KYD</option><option value="KZT">KZT</option><option value="LAK">LAK</option><option value="LBP">LBP</option><option value="LKR">LKR</option><option value="LRD">LRD</option><option value="LSL">LSL</option><option value="LYD">LYD</option><option value="MAD">MAD</option><option value="MDL">MDL</option><option value="MGA">MGA</option><option value="MKD">MKD</option><option value="MMK">MMK</option><option value="MNT">MNT</option><option value="MOP">MOP</option><option value="MRU">MRU</option><option value="MUR">MUR</option><option value="MVR">MVR</option><option value="MWK">MWK</option><option value="MXN">MXN</option><option value="MXV">MXV</option><option value="MYR">MYR</option><option value="MZN">MZN</option><option value="NAD">NAD</option><option value="NGN">NGN</option><option value="NIO">NIO</option><option value="NOK">NOK</option><option value="NPR">NPR</option><option value="NZD">NZD</option><option value="OMR">OMR</option><option value="PAB">PAB</option><option value="PEN">PEN</option><option value="PGK">PGK</option><option value="PHP">PHP</option><option value="PKR">PKR</option><option value="PLN">PLN</option><option value="PYG">PYG</option><option value="QAR">QAR</option><option value="RON">RON</option><option value="RSD">RSD</option><option value="RUB">RUB</option><option value="RWF">RWF</option><option value="SAR">SAR</option><option value="SBD">SBD</option><option value="SCR">SCR</option><option value="SDG">SDG</option><option value="SEK">SEK</option><option value="SGD">SGD</option><option value="SHP">SHP</option><option value="SLL">SLL</option><option value="SOS">SOS</option><option value="SRD">SRD</option><option value="SSP">SSP</option><option value="STN">STN</option><option value="SVC">SVC</option><option value="SYP">SYP</option><option value="SZL">SZL</option><option value="THB">THB</option><option value="TJS">TJS</option><option value="TMT">TMT</option><option value="TND">TND</option><option value="TOP">TOP</option><option value="TRY">TRY</option><option value="TTD">TTD</option><option value="TWD">TWD</option><option value="TZS">TZS</option><option value="UAH">UAH</option><option value="UGX">UGX</option><option value="USD">USD</option><option value="USN">USN</option><option value="UYI">UYI</option><option value="UYU">UYU</option><option value="UYW">UYW</option><option value="UZS">UZS</option><option value="VED">VED</option><option value="VES">VES</option><option value="VND">VND</option><option value="VUV">VUV</option><option value="WST">WST</option><option value="XAF">XAF</option><option value="XAG">XAG</option><option value="XAU">XAU</option><option value="XBA">XBA</option><option value="XBB">XBB</option><option value="XBC">XBC</option><option value="XBD">XBD</option><option value="XCD">XCD</option><option value="XDR">XDR</option><option value="XOF">XOF</option><option value="XPD">XPD</option><option value="XPF">XPF</option><option value="XPT">XPT</option><option value="XSU">XSU</option><option value="XTS">XTS</option><option value="XUA">XUA</option><option value="XXX">XXX</option><option value="YER">YER</option><option value="ZAR">ZAR</option><option value="ZMW">ZMW</option><option value="ZWL">ZWL</option></select>
                                    </div><div class="mb-3">
                                        <label for="pp-priority-edit" class="form-label">Transaction Type</label>
                                        
                                    <select id="pp-status-edit" class="form-select">
                                            <option value="Deposit">Deposit</option>
                                            <option value="Withdraw">Withdraw</option>
                                            
                                        </select></div><div class="mb-3">
                                        <label for="pp-priority-edit" class="form-label">Payment Systems Integration</label>
                                        <select id="pp-status-edit" class="form-select">
                                            <option value="active">Active</option>
                                            <option value="hidden">Hidden</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div></div>
                                
                                
                            </div>
                        <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-primary" id="addNewPaymentPlatformBtn">Save</button>
                                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Cancel</button>
                            </div></form>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>
</div>

<!-- <div id="ptns-editPaymentpartner" class="modal fade" tabindex="-1" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Payment partner</h5>
                <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
            </div>
            <div class="scrollable-container">
                <div class="card border mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Enzerhub Payment partners</h4>
                        <form id="ptns-pp-personalDetailsForm">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="userName" class="form-label">Partner</label>
                                        <input type="text" class="form-control" id="ptns-pp-contact" placeholder="Enzerhub" disabled="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pp-currency-edit" class="form-label">Currency</label>
                                        <select id="ptns-pp-currency-edit" class="form-select currency-list"></select>
                                    </div>
                                    
                                    
                                   <div class="mb-3">
                                        <label for="pp-status-edit" class="form-label">Status</label>
                                        <select id="ptns-pp-status-edit" class="form-select">
                                            <option value="active">Active</option>
                                            <option value="hidden">Hidden</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    
                                    
                                    <div class="mb-3">
                                        <label for="pp-payment-type-edit" class="form-label">Payment Type</label>
                                        <select id="ptns-pp-payment-type-edit" class="form-select pp-payment-types" disabled></select>
                                    </div><div class="mb-3">
                                        <label for="partner-name-edit" class="form-label">Fee (%)</label>
                                        <input type="text" class="form-control" id="ptns-partner-name-edit" placeholder="Fee (%)">
                                    </div>
                                </div>
                                <div class="col-6">
                                    
                                    <div class="mb-3">
                                        <label for="pp-min-amount-edit" class="form-label">Min. Amount</label>
                                        <input type="text" class="form-control" id="ptns-pp-min-amount-edit" placeholder="Min. Amount">
                                    </div>
                                <div class="mb-3">
                                        <label for="pp-admin-site-url-edit" class="form-label">Admin Site Url</label>
                                        <input type="text" class="form-control" id="ptns-pp-admin-site-url-edit" placeholder="e.g www.enzerhub.com">
                                    </div>
                                </div>
                                <div class="col-6">
                                    
                                    <div class="mb-3">
                                        <label for="pp-max-amount-edit" class="form-label">Max. Amount</label>
                                        <input type="text" class="form-control" id="ptns-pp-max-amount-edit" placeholder="Max. Amount">
                                    </div>
                                <div class="mb-3">
                                        <label for="pp-site-url-edit" class="form-label">Site Url</label>
                                        <input type="text" class="form-control" id="ptns-pp-site-url-edit" placeholder="e.g www.enzerhub.com">
                                    </div></div>
                            </div>
                        <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-primary" id="ptns-editPaymentpartnerBtn">Save</button>
                                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Cancel</button>
                            </div></form>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div> -->