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
  .table-wrapperpayment::-webkit-scrollbar {
    width: 5px;
    /* Slimmer scrollbar width */
    height: 5px;
    /* Slimmer scrollbar height for horizontal scrolling */
  }

  .table-wrapperpayment::-webkit-scrollbar-track {
    background: #f1f1f1;
    /* Lighter background for track */
    border-radius: 5px;
  }

  .table-wrapperpayment::-webkit-scrollbar-thumb {
    background-color: #ccc;
    /* Blue color for thumb */
    border-radius: 10px;
    cursor: pointer;
  }

  .table-wrapperpayment::-webkit-scrollbar-thumb:hover {
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

  .tbl-paymentheader {
    position: sticky;
    top: 0;
  }

  .sticky-paymentheader {
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
      <<<<<<< HEAD
        <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: 100%;">
        <div style="width: 35%;">

          <input name="resultsList" class="queryholderlist form-control bring-forward" id="platformNames" data-user-id="" placeholder="<?= $translator['Platform Names']; ?>" autocomplete="off" style="width: 98%;">
          <div class="pp-names-wrapper ngp-usr-res-wrapper" style="width: 20.5%;">
            <ul style="max-height: 403px;margin: 0px; overflow-y:auto;" id="pp-names-list-wrapper"></ul>
          </div>
          <input name="usernames" type="hidden" id="selectedID" value="">
        </div>



        <select name="betsate" id="platformCurrency" class="form-control form-select queryholderlistt messagestype currency-list" data-bs-placeholder="Select Type">
          <option value="">-Currency<?= $translator['Currency']; ?>-</option>
        </select>

        <select name="betsate" id="platformStatus" class="form-control form-select queryholderlistt messagestype " data-bs-placeholder="Select Type">
          <option value="">-<?= $translator['Status']; ?>-</option>
          <option value="active"><?= $translator['Active']; ?></option>
          <option value="hidden"><?= $translator['Hidden']; ?></option>
          </option>
          <option value="inactive"><?= $translator['Inactive']; ?></option>
          </option>

          =======
          <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: 100%;">
            <!-- <div style="width: 35%;">
                    <input name="resultsList" class="queryholderlist form-control bring-forward" id="platformNames" data-user-id="" placeholder="Platform Names" autocomplete="off" style="width: 98%;" />
                    <div class="pp-names-wrapper ngp-usr-res-wrapper" style="width: 20.5%;"><ul style="max-height: 403px; margin: 0px; overflow-y: auto;" id="pp-names-list-wrapper"></ul></div>
                    <input name="usernames" type="hidden" id="selectedID" value="" />
                </div> -->

                <select name="betsate" id="platformStatuss" class="form-control form-select queryholderlistt messagestype payment-type" data-bs-placeholder="Select Type">
                    <option value="">-Select Payment Type-</option>
                    <option value="momo">Mobile Money</option>
                    <option value="bank">Bank</option>
                    <option value="crypto">Crypto</option>
                </select>

            <select name="betsate" id="platformStatuse" class="form-control form-select queryholderlistt messagestype" data-bs-placeholder="Select Type">
              <option value="">-Status-</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
              <option value="hidden">Hidden</option>
              >>>>>>> 04341e5d5094aca8f5be8e7c1109987248e7745a
            </select>
            <input name="startdate" id="platformStartDates" type="date" class="form-control queryholderlistt startfmessage" placeholder="Name" />

            <input name="enddate" id="platformEndDates" type="date" class="form-control queryholderlistt endmessage" placeholder="Name" />
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
        <button type="button" class="btn bg-white-subtle" id="addPaymentPlatformBtn" value="right" aria-label="Refresh" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add Payment Platform">
          <i class="bx bx-plus" style="font-size: 20px;"></i>
        </button>

        <button type="button" class="btn bg-white-subtle player refreshpayment" value="right" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
          <i class="bx bx-refresh" style="font-size: 20px;"></i>
        </button>
        <button type="button" class="btn bg-white-subtle executepayment" value="end" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
          <i class="bx bx-check-double loaderpay" style="font-size: 20px;"></i>
        </button>
      </div>
    </span>
  </div>

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperpayment" id="maskpayment" style="height: 530px; overflow-y: scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered">
                <thead class="text-dark fs-4 tbl-paymentheader">
                    <tr class="paymentheaderrow">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Payment Name</h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Payment Type</h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Currency</h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Minimum Amount</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Maximum Amount</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Date Created</h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Created By</h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class="bx bx-dots-vertical-rounded"></i></h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="paymentContainer">
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
      <span id="paging_infopayment" style="color: #aaa;">---</span>
    </span>
    <span class="top-right-btn" aria-label="Page navigation example">
      <select class="left-element form-control numrowspay" style="font-size: 12px;">
        <option value="50">50</option>
        <option value="100">100</option>
        <option value="200">200</option>
        <option value="500">500</option>
      </select>
      <span class="toplist-right" id="paginationpayments" aria-label="Page navigation example">
        <!--Dynamic pagination-->
      </span>
    </span>
  </div>
</div>

<!-- Modal -->
<div id="payplatmodal" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
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
                  </div>
                  <div class="mb-3">
                    <label for="pp-fee" class="form-label"> <?= $translator['Fee']; ?>(%) (<span style="color: #a01616;">*</span>)</label>
                    <input type="text" class="form-control" id="pp-fee" placeholder="<?= $translator['Fee']; ?>(%)">
                  </div>
                  <div class="mb-3">
                    <label for="pp-priority" class="form-label"><?= $translator['Priority']; ?></label>
                    <input type="text" class="form-control" id="pp-priority" placeholder="<?= $translator['Priority']; ?>">
                  </div>
                </div>
                <div class="col-6">

                  <div class="mb-3">
                    <label for="pp-info" class="form-label"><?= $translator['Info/Description']; ?></label>
                    <textarea type="text" class="form-control" id="pp-info" cols="15" rows="10" placeholder="<?= $translator['Info/Description']; ?>" style="height: 235px;"></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="pp-site-url" class="form-label"> <?= $translator['Site Url']; ?></label>
                    <input type="text" class="form-control" id="pp-site-url" placeholder="e.g www.enzerhub.com">
                  </div>
                  <div class="mb-3">
                    <label for="pp-admin-site-rul" class="form-label"><?= $translator['Admin Site Url']; ?></label>
                    <input type="text" class="form-control" id="pp-admin-site-url" placeholder="e.g www.enzerhub.com">
                  </div>
                </div>
                <div class="col-6">

                  <div class="mb-3">
                    <label for="pp-min-amount" class="form-label"><?= $translator['Min. Amount']; ?></label>
                    <input type="text" class="form-control" id="pp-min-amount" placeholder="<?= $translator['Min. Amount']; ?>">
                  </div>
                  <div class="mb-3">
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
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Afghanistan']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Albania']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Algeria']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Andorra']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Angola']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Antigua and Barbuda']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Argentina']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Armenia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Armenia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Austria']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Azerbaijan']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Bahamas']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Bahrain']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Bangladesh']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Barbados']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Belarus']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Belgium']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Belize']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Benin']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Bhutan']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Bolivia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Bosnia and Herzegovina']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Botswana']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Brazil']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Brunei']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Bulgaria']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Burkina Faso']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Burundi']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Côte dIvoire']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Cabo Verde']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Cambodia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Cameroon']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Canada']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Central African Republic']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Chad']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Chile']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['China']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Colombia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Comoros']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Costa Rica']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Croatia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Cuba']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Cyprus']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Czech Republic']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Democratic Republic of the Congo']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Denmark']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Djibouti']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Dominica']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Dominican Republic']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Ecuador']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Egypt']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['El Salvador']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Equatorial Guinea']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Eritrea']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Estonia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Eswatini']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Ethiopia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Federated States of Micronesia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Fiji']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Finland']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['France']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Gabon']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Gambia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Georgia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Germany']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Ghana']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Greece']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Grenada']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Guatemala']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Guinea']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Guinea-Bissau']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Guyana']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Haiti']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Honduras']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Hungary']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Iceland']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['India']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Indonesia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Iran']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Iraq']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Ireland']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Israel']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Italy']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Jamaica']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Japan']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Jordan']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Kazakhstan']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Kenya']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Kiribati']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Kosovo']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Kuwait']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Kyrgyzstan']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Laos']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Latvia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Lebanon']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Lesotho']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Liberia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Libya']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Liechtenstein']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Lithuania']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Luxembourg']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['North Macedonia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Madagascar']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Malawi']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Malaysia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Maldives']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Mali']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Malta']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Marshall Islands']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Mauritania']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Mauritius']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Mexico']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Moldova']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Monaco']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Mongolia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Montenegro']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Morocco']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Mozambique']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Myanmar']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Namibia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Nauru']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Nepal']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Netherlands']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['New Zealand']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Nicaragua']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Niger']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Nigeria']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['North Korea']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Norway']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Oman']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Pakistan']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Palau']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Panama']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Papua New Guinea']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Paraguay']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Peru']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Philippines']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Poland']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Portugal']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Qatar']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Republic of the Congo']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Romania']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Russia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Rwanda']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['St Kitts and Nevis']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['St Lucia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['St Vincent and the Grenadines']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Samoa']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Sao Tome and Principe']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Sao Tome and Principe']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Saudi Arabia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Senegal']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Serbia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Seychelles']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Sierra Leone']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Singapore']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Slovakia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Slovenia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Solomon Islands']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Somalia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['South Africa']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['South Korea']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['South Sudan']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Spain']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Sri Lanka']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Sudan']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Suriname']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Sweden']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Switzerland']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Syria']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Taiwan']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Tajikistan']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Tanzania']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Thailand']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Timor-Leste']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Togo']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Tonga']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Trinidad and Tobago']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Tunisia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Turkey']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Turkmenistan']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Tuvalu']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Uganda']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Ukraine']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['United Arab Emirates']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['United Kingdom']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['United States']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Uruguay']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Uzbekistan']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Vanuatu']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Vatican City']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Venezuela']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Vietnam']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Yemen']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Zambia']; ?></span></td>
                            </tr>
                            <tr>
                              <td><input class="form-check-input country-input " type="checkbox" value="1" id="flexCheckDefault"></td>
                              <td><span class="pp-lottery-name"><?= $translator['Zimbabwe']; ?></span></td>
                            </tr>

                          </tbody>

                        </table>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-primary" id="addNewPaymentPlatformBtn"><?= $translator['Save']; ?></button>
                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal"><?= $translator['Cancel']; ?></button>
              </div>
            </form>
          </div>

        </div>

        <!-- Form -->
        <form>
          <!-- Username Field -->
          <!-- Rebate Field -->

          <div class="col-md-12 mb-3">
            <div class="note-title">
              <!-- <label class="form-label">Note Title</label> -->
              <input type="text" id="paymentname" class="form-control form-reset" minlength="25" placeholder="payment name" />
            </div>
          </div>

          <div class="form-floating mb-3">
            <select name="deposit" class="form-select form-control borders border-infos currencytype form-reset">
              <option value="">-Select Payment Type-</option>
              <option value="momo">Mobile Money</option>
              <option value="bank">Bank</option>
              <option value="crypto">Crypto</option>

            </select>
            <label>
              <i class="bx bx-list-ul me-2 fs-4 text-infos"></i>
              <span class="border-start ps-3"><?= $translator['Payment Type']; ?></span>
            </label>
          </div>

          <div class="col-md-12 mb-3">
            <div class="note-title">
              <!-- <label class="form-label">Note Title</label> -->
              <input type="text" id="paylogo" class="form-control paylogo form-reset" minlength="25" placeholder="payment logo url" />
            </div>
          </div>

          <div class="form-floating mb-3">
            <select name="deposit" class="form-select form-control borders border-infos currencystate form-reset">
              <option value="">-Select Status-</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
              <option value="hidden">Hidden</option>
            </select>
            <label>
              <i class="bx bx-list-ul me-2 fs-4 text-infos"></i>
              <span class="border-start ps-3"><?= $translator['Status']; ?></span>
            </label>
          </div>

          <div class="col-md-12 mb-3">
            <div class="note-title">
              <!-- <label class="form-label">Note Title</label> -->
              <input type="text" id="maxiamount" class="form-control form-reset" minlength="25" placeholder="maximum amount" />
            </div>
          </div>

          <div class="col-md-12 mb-3">
            <div class="note-title">
              <!-- <label class="form-label">Note Title</label> -->
              <input type="text" id="miniamount" class="form-control form-reset" minlength="25" placeholder="minimum amount" />
            </div>
          </div>

          <div class="col-md-12 mb-3">
            <div class="note-title">
              <select id="currency-select" class="form-select form-control border border-infos currency-select form-reset">
                <option value="">-- Select Currency --</option>
              </select>
            </div>
          </div>

          <p></p>
          <div class="form-floating mb-3">
            <input name="agentname" type="text" class="form-control border sendby form-reset" placeholder="Approved by" value="<?php echo $fullname['full_name']; ?>" readonly />
            <label>
              <!-- <i class="bx bx-message me-2 fs-4 text-infod"></i> -->
              <span class="border-start ps-3"><?= $translator['Approved By']; ?></span>
            </label>
          </div>

          <!-- Submit Button -->
          <div class="d-md-flex align-items-center">
            <div class="form-check">
              <!-- <input type="checkbox" class="form-check-input" id="sf2" value="check" /> -->
              <!-- <label class="form-check-label" for="sf2"><?= $translator['Verify before submit']; ?></label> -->
            </div>
            <div class="mt-3 mt-md-0 ms-auto">
              <button type="button" class="btn hstack gap-6 savemoneybtn" style="border: solid 1px #ccc;" data-bss-dismiss="modal" aria-label="Close">
                <i class="bx bx-send loaderpays"></i>
                <?= $translator['Submit']; ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /.modal-dialog -->
</div>

<div id="editpayplatform" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <<<<<<< HEAD
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
                </div>
                <div class="mb-3">
                  <label for="pp-fee-edit" class="form-label"><?= $translator['Fee']; ?> (%) (<span style="color: #a01616;">*</span>)</label>
                  <input type="text" class="form-control" id="pp-fee-edit" placeholder="Fee (%)">
                </div>
                <div class="mb-3">
                  <label for="pp-priority-edit" class="form-label"><?= $translator['Priority']; ?></label>
                  <input type="text" class="form-control" id="pp-priority-edit" placeholder="Priority">
                </div>
              </div>
              <div class="col-6">

                <div class="mb-3">
                  <label for="pp-info-edit" class="form-label"><?= $translator['Info/Description']; ?></label>
                  <textarea type="text" class="form-control" id="pp-info-edit" cols="15" rows="10" placeholder="Info/Description" style="height: 235px;"></textarea>
                </div>
                <div class="mb-3">
                  <label for="pp-site-url-edit" class="form-label"><?= $translator['Site Url']; ?></label>
                  <input type="text" class="form-control" id="pp-site-url-edit" placeholder="e.g www.enzerhub.com">
                </div>
                <div class="mb-3">
                  <label for="pp-admin-site-url-edit" class="form-label"><?= $translator['Admin Site Url']; ?></label>
                  <input type="text" class="form-control" id="pp-admin-site-url-edit" placeholder="e.g www.enzerhub.com">
                </div>
              </div>
              <div class="col-6">

                <div class="mb-3">
                  <label for="pp-min-amount-edit" class="form-label"><?= $translator['Min. Amount']; ?></label>
                  <input type="text" class="form-control" id="pp-min-amount-edit" placeholder="Min. Amount">
                </div>
                <div class="mb-3">
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

                </div>
              </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
              <button type="button" class="btn btn-primary" id="editPaymentPlatformBtn"><?= $translator['Save']; ?></button>
              <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal"><?= $translator['Cancel']; ?></button>
            </div>
          </form>
        </div>

        =======
        <div class="modal-body">
          <!-- Modal Header -->
          <div class="text-center mt-2 mb-4">
            <div class="d-flex justify-content-between align-items-center">
              <div>Edit PaymentPlatform</div>
              <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
            </div>
            >>>>>>> 04341e5d5094aca8f5be8e7c1109987248e7745a
          </div>

          <!-- Form -->
          <form>
            <!-- Username Field -->
            <input type="text" id="paymentids" hidden />

            <div class="col-md-12 mb-3">
              <select name="currency" class="form-select typecurrency" id="typecurrency">
                <option value="">-- Select Currency --</option>
                <option value="AED">AED</option>
                <option value="AFN">AFN</option>
                <option value="ALL">ALL</option>
                <option value="AMD">AMD</option>
                <option value="ANG">ANG</option>
                <option value="AOA">AOA</option>
                <option value="ARS">ARS</option>
                <option value="AUD">AUD</option>
                <option value="AWG">AWG</option>
                <option value="AZN">AZN</option>
                <option value="BAM">BAM</option>
                <option value="BBD">BBD</option>
                <option value="BDT">BDT</option>
                <option value="BGN">BGN</option>
                <option value="BHD">BHD</option>
                <option value="BIF">BIF</option>
                <option value="BMD">BMD</option>
                <option value="BND">BND</option>
                <option value="BOB">BOB</option>
                <option value="BOV">BOV</option>
                <option value="BRL">BRL</option>
                <option value="BSD">BSD</option>
                <option value="BTN">BTN</option>
                <option value="BWP">BWP</option>
                <option value="BYN">BYN</option>
                <option value="BZD">BZD</option>
                <option value="CAD">CAD</option>
                <option value="CDF">CDF</option>
                <option value="CHE">CHE</option>
                <option value="CHF">CHF</option>
                <option value="CHW">CHW</option>
                <option value="CLF">CLF</option>
                <option value="CLP">CLP</option>
                <option value="CNY">CNY</option>
                <option value="COP">COP</option>
                <option value="COU">COU</option>
                <option value="CRC">CRC</option>
                <option value="CUC">CUC</option>
                <option value="CUP">CUP</option>
                <option value="CVE">CVE</option>
                <option value="CZK">CZK</option>
                <option value="DJF">DJF</option>
                <option value="DKK">DKK</option>
                <option value="DOP">DOP</option>
                <option value="DZD">DZD</option>
                <option value="EGP">EGP</option>
                <option value="ERN">ERN</option>
                <option value="ETB">ETB</option>
                <option value="EUR">EUR</option>
                <option value="FJD">FJD</option>
                <option value="FKP">FKP</option>
                <option value="GBP">GBP</option>
                <option value="GEL">GEL</option>
                <option value="GHS">GHS</option>
                <option value="GIP">GIP</option>
                <option value="GMD">GMD</option>
                <option value="GNF">GNF</option>
                <option value="GTQ">GTQ</option>
                <option value="GYD">GYD</option>
                <option value="HKD">HKD</option>
                <option value="HNL">HNL</option>
                <option value="HRK">HRK</option>
                <option value="HTG">HTG</option>
                <option value="HUF">HUF</option>
                <option value="IDR">IDR</option>
                <option value="ILS">ILS</option>
                <option value="INR">INR</option>
                <option value="IQD">IQD</option>
                <option value="IRR">IRR</option>
                <option value="ISK">ISK</option>
                <option value="JMD">JMD</option>
                <option value="JOD">JOD</option>
                <option value="JPY">JPY</option>
                <option value="KES">KES</option>
                <option value="KGS">KGS</option>
                <option value="KHR">KHR</option>
                <option value="KMF">KMF</option>
                <option value="KPW">KPW</option>
                <option value="KRW">KRW</option>
                <option value="KWD">KWD</option>
                <option value="KYD">KYD</option>
                <option value="KZT">KZT</option>
                <option value="LAK">LAK</option>
                <option value="LBP">LBP</option>
                <option value="LKR">LKR</option>
                <option value="LRD">LRD</option>
                <option value="LSL">LSL</option>
                <option value="LYD">LYD</option>
                <option value="MAD">MAD</option>
                <option value="MDL">MDL</option>
                <option value="MGA">MGA</option>
                <option value="MKD">MKD</option>
                <option value="MMK">MMK</option>
                <option value="MNT">MNT</option>
                <option value="MOP">MOP</option>
                <option value="MRU">MRU</option>
                <option value="MUR">MUR</option>
                <option value="MVR">MVR</option>
                <option value="MWK">MWK</option>
                <option value="MXN">MXN</option>
                <option value="MXV">MXV</option>
                <option value="MYR">MYR</option>
                <option value="MZN">MZN</option>
                <option value="NAD">NAD</option>
                <option value="NGN">NGN</option>
                <option value="NIO">NIO</option>
                <option value="NOK">NOK</option>
                <option value="NPR">NPR</option>
                <option value="NZD">NZD</option>
                <option value="OMR">OMR</option>
                <option value="PAB">PAB</option>
                <option value="PEN">PEN</option>
                <option value="PGK">PGK</option>
                <option value="PHP">PHP</option>
                <option value="PKR">PKR</option>
                <option value="PLN">PLN</option>
                <option value="PYG">PYG</option>
                <option value="QAR">QAR</option>
                <option value="RON">RON</option>
                <option value="RSD">RSD</option>
                <option value="RUB">RUB</option>
                <option value="RWF">RWF</option>
                <option value="SAR">SAR</option>
                <option value="SBD">SBD</option>
                <option value="SCR">SCR</option>
                <option value="SDG">SDG</option>
                <option value="SEK">SEK</option>
                <option value="SGD">SGD</option>
                <option value="SHP">SHP</option>
                <option value="SLL">SLL</option>
                <option value="SOS">SOS</option>
                <option value="SRD">SRD</option>
                <option value="SSP">SSP</option>
                <option value="STN">STN</option>
                <option value="SVC">SVC</option>
                <option value="SYP">SYP</option>
                <option value="SZL">SZL</option>
                <option value="THB">THB</option>
                <option value="TJS">TJS</option>
                <option value="TMT">TMT</option>
                <option value="TND">TND</option>
                <option value="TOP">TOP</option>
                <option value="TRY">TRY</option>
                <option value="TTD">TTD</option>
                <option value="TWD">TWD</option>
                <option value="TZS">TZS</option>
                <option value="UAH">UAH</option>
                <option value="UGX">UGX</option>
                <option value="USD">USD</option>
                <option value="USN">USN</option>
                <option value="UYI">UYI</option>
                <option value="UYU">UYU</option>
                <option value="UYW">UYW</option>
                <option value="UZS">UZS</option>
                <option value="VED">VED</option>
                <option value="VES">VES</option>
                <option value="VND">VND</option>
                <option value="VUV">VUV</option>
                <option value="WST">WST</option>
                <option value="XAF">XAF</option>
                <option value="XAG">XAG</option>
                <option value="XAU">XAU</option>
                <option value="XBA">XBA</option>
                <option value="XBB">XBB</option>
                <option value="XBC">XBC</option>
                <option value="XBD">XBD</option>
                <option value="XCD">XCD</option>
                <option value="XDR">XDR</option>
                <option value="XOF">XOF</option>
                <option value="XPD">XPD</option>
                <option value="XPF">XPF</option>
                <option value="XPT">XPT</option>
                <option value="XSU">XSU</option>
                <option value="XTS">XTS</option>
                <option value="XUA">XUA</option>
                <option value="XXX">XXX</option>
                <option value="YER">YER</option>
                <option value="ZAR">ZAR</option>
                <option value="ZMW">ZMW</option>
                <option value="ZWL">ZWL</option>
              </select>

            </div>

            <div class="col-md-12 mb-3">
              <div class="note-title">
                <label class="form-label">Maximun Amount</label>
                <input type="text" id="maxiamounts" class="form-control" minlength="25" placeholder="maximum amount" />
              </div>
            </div>

            <div class="col-md-12 mb-3">
              <div class="note-title">
                <label class="form-label">Minimum Amount</label>
                <input type="text" id="minamount" class="form-control" minlength="25" placeholder="minimum amount" />
              </div>
            </div>

            <div class="form-floating mb-3">
              <select name="deposit" class="form-select form-control borders border-infos statecurrent form-reset">
                <option value="">-- Select Status --</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="hidden">Hidden</option>
              </select>
            </div>

            <br />
            <div class="form-floating mb-3">
              <input name="agentname" type="text" class="form-control border sendby" placeholder="Approved by" value="<?php echo $fullname['full_name']; ?>" readonly />
              <label>
                <!-- <i class="bx bx-message me-2 fs-4 text-infod"></i> -->
                <span class="border-start ps-3"><?= $translator['Approved By']; ?></span>
              </label>
            </div>

            <!-- Submit Button -->
            <div class="d-md-flex align-items-center">

              <div class="mt-3 mt-md-0 ms-auto">
                <button type="button" class="btn hstack gap-6 updatepaybtn" style="border: solid 1px #ccc;" data-bss-dismiss="modal" aria-label="Close">
                  <i class="bx bx-send loaderpayanup"></i>
                  <?= $translator['Submit']; ?>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.modal-dialog -->
  </div>