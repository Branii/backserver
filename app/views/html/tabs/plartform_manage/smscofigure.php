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
    .table-wrapperusernoti::-webkit-scrollbar {
        width: 5px;
        /* Slimmer scrollbar width */
        height: 5px;
        /* Slimmer scrollbar height for horizontal scrolling */
    }

    .table-wrapperusernoti::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Lighter background for track */
        border-radius: 5px;
    }

    .table-wrapperusernoti::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Blue color for thumb */
        border-radius: 10px;
        cursor: pointer;
    }

    .table-wrapperusernoti::-webkit-scrollbar-thumb:hover {
        background-color: #aaa;
        /* Darker blue on hover */
    }

    .notfyDropdown {
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

    .queryholdernotfys {
        width: 25%;
        margin-right: 10px;
        background-color: #fff;
    }

    /* Style for the scrollbar */
    .notfyDropdown::-webkit-scrollbar {
        width: 3px;
        /* Width of the scrollbar */
    }

    .notfyDropdown::-webkit-scrollbar-track {
        background: #f0f0f0;
        /* Background of the scrollbar track */
        border-radius: 5px;
        /* Rounded corners */
    }

    .notfyDropdown::-webkit-scrollbar-thumb {
        background: #ccc;
        /* Color of the scrollbar handle */
        border-radius: 5px;
        /* Rounded corners */
    }

    .notfyDropdown::-webkit-scrollbar-thumb:hover {
        background: #aaa;
        /* Darker handle color on hover */
    }

    .tbl-usernotiheads {
        position: sticky;
        top: 0;
    }

    .sticky-usernotiheads {
        position: relative;
        bottom: 1px;
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
        <h4 class="card-title mb-0"><?= $translator['Sms Configuration']; ?></h4>
    </div>

    <div class="px-4 py-3 border-bottom pagerlist">
        <span class="top-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: auto;">
                <input type="text" id="usernotifys" class="form-control queryholdernotfys usernames" placeholder="<?= $translator['Search usernames']; ?>" />
                <input name="usernames" type="hidden" class="userIdfinance" />
                <select class="form-control notfyDropdown" size="5" style="display: none;" id="usernotfy">
                    <!-- Options will be populated dynamically -->
                </select>

                <select name="betsate" class="form-control form-select queryholdernotfys messagesread" data-bs-placeholder="Select Type">
                    <option value="">-<?= $translator['Message Status']; ?>-</option>
                    <option value="read"><?= $translator['Read']; ?></option>
                    <option value="unread"><?= $translator['Unread']; ?></option>
                </select>
                <select name="lotteryname" class="form-control form-select queryholdernotfys selectpartner"> </select>

                <input name="startdate" type="date" class="form-control queryholdernotfys startnotfys" placeholder="Name" />

                <input name="enddate" type="date" class="form-control queryholdernotfys endnotfys" placeholder="Name" />
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topplist-right" id="paginations" aria-label="Page navigation example">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <button type="button" class="btn bg-white-subtle" id="addsmsplatform" value="right" aria-label="Refresh" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add Sms Platform">
                <i class="bx bx-plus" style="font-size: 20px;"></i>
                </button>

                <button type="button" class="btn bg-white-subtle" id="addsmssettings" value="right" aria-label="Refresh" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="sms settings">
                <i class="bx bx-cog" style="font-size: 20px;"></i>
                </button>

                <button type="button" class="btn bg-white-subtle player refresusernoti" value="right" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class="bx bx-refresh" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle executenoti" value="end" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class="bx bx-check-double loadernotfys" style="font-size: 20px;"></i>
                </button>
                <!-- <button type="button" class="btn bg-white-subtle executedeposit" value="end" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class="bx bx-check-double loaderdeposit" style="font-size: 20px;"></i>
                </button> -->
            </div>
        </span>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperusernotissms" id="maskusernotis" style="height: 530px; overflow-y: scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered">
                <thead class="text-dark fs-4 tbl-usernotiheadss">
                    <tr class="usernotiheadrowss">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Sms Provider</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Partner Name</h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Total Sms</h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Used Sms</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Remaining Sms</h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Status']; ?></h6>
                        </th>

                        <!-- <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class='bx bx-dots-vertical-rounded'></i></h6>
                        </th> -->
                    </tr>
                </thead>
                <tbody id="smscontainer">
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
            <span id="paging_infosms" style="color: #aaa;">---</span>
        </span>
        <span class="top-right-btn" aria-label="Page navigation example">
            <select class="left-element form-control numrowsms" style="font-size: 12px;">
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="500">500</option>
            </select>
            <span class="toplist-right" id="paginationsmss" aria-label="Page navigation example">
                <!--Dynamic pagination-->
            </span>
        </span>
    </div>
</div>


<div id="smsmodal" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Sms Platform</h5>
        <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
      </div>
      <div class="scrollable-container">
  
        <form>
        
          <div class="col-md-12 mb-3">
            <div class="note-title">
              <!-- <label class="form-label">Note Title</label> -->
              <input type="text" id="smsnameprovider" class="form-control form-reset" minlength="25" placeholder="Sms provider name" />
            </div>
          </div>

          <!-- <div class="form-floating mb-3">
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
          </div> -->

          <!-- <div class="col-md-12 mb-3">
            <div class="note-title">
              <label class="form-label">Note Title</label>
              <input type="text" id="paynlogo" class="form-control paylogo form-reset" minlength="25" placeholder="payment logo url" />
            </div>
          </div> -->

          <!-- <div class="form-floating mb-3">
            <select name="deposit" class="form-select form-control borders border-infos currencystate form-reset">
              <option value="">-Select Status-</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
            <label>
              <i class="bx bx-list-ul me-2 fs-4 text-infos"></i>
              <span class="border-start ps-3"><?= $translator['Status']; ?></span>
            </label>
          </div> -->

          <div class="col-md-12 mb-3">
            <div class="note-title">
              <!-- <label class="form-label">Note Title</label> -->
              <input type="text" class="form-control form-reset"  id="partnamesms" minlength="25" placeholder="partner name" />
              <!-- <select name="lotteryname"  class="form-control form-select selectpartner"> </select> -->
            </div>
          </div>

          <!-- <div class="col-md-12 mb-3">
            <div class="note-title">
              <label class="form-label">Note Title</label>
              <input type="text" id="miniamountg" class="form-control form-reset" minlength="25" placeholder="minimum amount" />
            </div>
          </div> -->

          <!-- <div class="col-md-12 mb-3">
            <div class="note-title">
              <select id="currency-select" class="form-select form-control border border-infos currency-select form-reset">
                <option value="">-- Select Currency --</option>
              </select>
            </div>
          </div> -->

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
              <button type="button" class="btn hstack gap-6 savesms" style="border: solid 1px #ccc;" data-bss-dismiss="modal" aria-label="Close">
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


<!-- SMS Modal -->
<div id="smsModalsettings" class="modal fade" tabindex="-1" aria-labelledby="smsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0" id="smsModalLabel">SMS Notification Preferences</h4>
                    <i class="bx bx-x" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i>
                </div>

                <div class="card border shadow-none" style="height:480px;">
                    <div class="card-body p-4">

                        <!-- Deposit -->
                        <div class="border-bottom py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap w-100 mb-2">
                                <div class="flex-grow-1">
                                    <h5 class="fs-5 fw-semibold mb-1">Deposit Confirmations</h5>
                                    <p class="mb-0 text-muted">Notifications confirming successful deposits.</p>
                                </div>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input depositSwitch" type="checkbox" id="depositSwitch" />
                                    <label class="form-check-label" for="depositSwitch">Enable</label>
                                </div>
                            </div>
                        </div>

                        <!-- Withdraw -->
                        <div class="border-bottom py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap w-100 mb-2">
                                <div>
                                    <h5 class="fs-5 fw-semibold mb-1">Withdrawal Notifications</h5>
                                    <p class="mb-0 text-muted">Alerts when a withdrawal is processed or completed.</p>
                                </div>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" id="withdrawSwitch" />
                                    <label class="form-check-label" for="withdrawSwitch">Enable</label>
                                </div>
                            </div>
                        </div>

                        <!-- Security -->
                        <div class="border-bottom py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap w-100 mb-2">
                                <div>
                                    <h5 class="fs-5 fw-semibold mb-1">Security Alerts</h5>
                                    <p class="mb-0 text-muted">Login attempts from new devices, password changes, etc.</p>
                                </div>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" id="securitySwitch" />
                                    <label class="form-check-label" for="securitySwitch">Enable</label>
                                </div>
                            </div>
                        </div>

                        <!-- Promo -->
                        <div class="border-bottom py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap w-100 mb-2">
                                <div>
                                    <h5 class="fs-5 fw-semibold mb-1">Promotional Offers</h5>
                                    <p class="mb-0 text-muted">Bonuses, promotions, and exclusive deals.</p>
                                </div>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" id="promoSwitch" />
                                    <label class="form-check-label" for="promoSwitch">Enable</label>
                                </div>
                            </div>
                        </div>

                        <!-- Game -->
                        <div class="border-bottom py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap w-100 mb-2">
                                <div>
                                    <h5 class="fs-5 fw-semibold mb-1">Game Updates</h5>
                                    <p class="mb-0 text-muted">New games or updates to existing ones.</p>
                                </div>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" id="gameSwitch" />
                                    <label class="form-check-label" for="gameSwitch">Enable</label>
                                </div>
                            </div>
                        </div>

                        <!-- VIP -->
                        <div class="border-bottom py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap w-100 mb-2">
                                <div>
                                    <h5 class="fs-5 fw-semibold mb-1">VIP Program Notifications</h5>
                                    <p class="mb-0 text-muted">Changes in VIP status and exclusive offers.</p>
                                </div>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" id="vipSwitch" />
                                    <label class="form-check-label" for="vipSwitch">Enable</label>
                                </div>
                            </div>
                        </div>

                        <!-- Provider -->
                        <div class="border-bottom py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap w-100 mb-2">
                                <div>
                                    <h5 class="fs-5 fw-semibold mb-1">Select SMS Provider</h5>
                                    <p class="mb-0 text-muted">For sending messages to clients.</p>
                                </div>
                                <!-- <div class="ms-auto" style="min-width: 250px;"> -->
                                    <select id="provider" class="form-select">
                                        <option value="">Select...</option>
                                        <option value="ntem">NTEM</option>
                                        <option value="smsonlinegh">SMSONLINEGH</option>
                                        <option value="hubtel">Hubtel</option>
                                    </select>
                                <!-- </div> -->
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center mt-4">
                            <button class="btn btn-primary" id="sendSMSBtn">Save Preferences</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
