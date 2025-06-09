<style>
  .perm {
    border-bottom: solid 1px #eee;
  }

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

  .table-wrapper {
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

  .queryholder {
    width: 25%;
    margin-right: 5px;
    background-color: #FFF;
  }

  .queryhold {
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

  .option {
    text-align: left;
    border-bottom: solid 1px #eee;
    padding: 5px;
  }

  .option:hover {
    background-color: #eee;
  }

  .no-resultsAdmin {
    text-align: center;
    /* Center horizontally */
    vertical-align: middle;
    /* Center vertically */
    height: 20px;
    /* Set a minimum height to ensure centering */
    border: none;
  }

  .no-resultsAdmin img {
    position: relative;
    top: 100px;

  }

  /* Custom Scrollbar for Webkit Browsers */
  .table-wrapper::-webkit-scrollbar {
    width: 5px;
    /* Slimmer scrollbar width */
    height: 5px;
    /* Slimmer scrollbar height for horizontal scrolling */
  }

  .table-wrapper::-webkit-scrollbar-track {
    background: #f1f1f1;
    /* Lighter background for track */
    border-radius: 5px;
  }

  .table-wrapper::-webkit-scrollbar-thumb {
    background-color: #ccc;
    /* Blue color for thumb */
    border-radius: 10px;
    cursor: pointer;
  }

  .table-wrapper::-webkit-scrollbar-thumb:hover {
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

  .tbl-headerAdmin {
    position: sticky;
    top: 0;
  }

  .sticky-headerAdmin {
    position: relative;
    bottom: 1px;
    background-color: red;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
  }

  .pins {
    padding: 5px;
    border-bottom: solid 1px rgb(110, 129, 146, 0.1);
  }

  .ini {
    font-size: 16px;
    border: solid 1px #eee;
    background-color: #ddd;
  }

  .slected {
    border: solid 2px orangered
  }

  .maintext {
    color: #000;
  }

  .arr {
    color: #909aa9;
    margin: 0px 1rem;
  }

  .input-wrapper {
    position: relative;
  }

  #adminuserAccountDropdown {
    position: absolute;
    top: 100%;
    left: 0;
    max-height: 150px;
    overflow-y: auto;
    z-index: 1000;
    background: white;
    width: 100%;
  }

  #maskadmin {
    position: relative;
    height: 530px;
    overflow-y: auto;
  }
</style>

<style>
  .search-icon-wrapper {
    position: relative;
    display: inline-block;
  }

  .search-icon-overlay {
    position: absolute;
    top: 6px;
    left: 6px;
    right: 6px;
    bottom: 6px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 4px;
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 10;
  }

  .search-icon-overlay .spinner {
    width: 18px;
    height: 18px;
    border: 2px solid #ccc;
    border-top: 2px solid #333;
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }
</style>

<style>
  /* Zoom animation */
  .modal.zoom .modal-dialog {
    transform: scale(0.7);
    transition: transform 0.3s ease-in-out;
  }

  .modal.zoom.show .modal-dialog {
    transform: scale(1);
  }

  /* Shake effect */
  .modal.shake .modal-dialog {
    animation: shake 2s;
  }

  @keyframes shake {

    0%,
    100% {
      transform: translateX(0);
    }

    10%,
    30%,
    50%,
    70%,
    90% {
      transform: translateX(-10px);
    }

    20%,
    40%,
    60%,
    80% {
      transform: translateX(10px);
    }
  }
</style>


<span id="translation-type-admin" data-translation="<?= $translator['Please select or type an admin to search']; ?>" style="display:none;"></span>


<span id="trans-success" data-translation="<?= $translator['Success']; ?>" style="display:none;"></span>
<span id="trans-new-user" data-translation="<?= $translator['NewUserAdded']; ?>" style="display:none;"></span>
<span id="trans-heads-up" data-translation="<?= $translator['HeadsUp']; ?>" style="display:none;"></span>
<span id="trans-mandatory" data-translation="<?= $translator['AllFieldsMandatory']; ?>" style="display:none;"></span>


<span id="viewprofile-text" data-translation="<?= $translator['View Profile'] ?? 'View Profile'; ?>" style="display:none;"></span>
<span id="activity-text" data-translation="<?= $translator['Activity Logs'] ?? 'Activity Logs'; ?>" style="display:none;"></span>
<span id="permission-text" data-translation="<?= $translator['Permissions'] ?? 'Permissions'; ?>" style="display:none;"></span>
<!-- Hidden translatable message span -->
<span id="translation-info" data-msg="<?= $translator['Information'] ?>" style="display:none;"></span>
<span id="translation-noperm" data-msg="<?= $translator['No permissions selected. Update not sent.'] ?>" style="display:none;"></span>
<span id="translation-select-dates" data-msg="<?= $translator['Select date(s) to filter'] ?>" style="display:none;"></span>

<span id="status-active" data-msg="<?= $translator['active'] ?>"></span>
<span id="status-suspended" data-msg="<?= $translator['suspended'] ?>"></span>
<span id="status-deactivated" data-msg="<?= $translator['deactivated'] ?>"></span>

<span id="msg-success" data-msg="<?= $translator['permissions_success'] ?>"></span>
<span id="msg-error" data-msg="<?= $translator['permissions_error'] ?>"></span>
<span id="msg-title-success" data-msg="<?= $translator['success'] ?>"></span>
<span id="msg-title-error" data-msg="<?= $translator['error'] ?>"></span>


<span id="trans-heads-up-title" style="display:none;"><?php echo $translator['HEADS_UP_TITLE']; ?></span>
<span id="trans-select-admin-msg" style="display:none;"><?php echo $translator['SELECT_ADMIN_MSG']; ?></span>

<span id="trans-status-active" style="display:none;"><?php echo $translator['STATUS_ACTIVE']; ?></span>
<span id="trans-status-suspended" style="display:none;"><?php echo $translator['STATUS_SUSPENDED']; ?></span>
<span id="trans-status-deactivated" style="display:none;"><?php echo $translator['STATUS_DEACTIVATED']; ?></span>






<div class="card w-100 position-relative overflow-hidden">

  <div class="px-4 py-3 border-bottom">
    <h4 class="card-title mb-0"><?= $translator['Administrator List']; ?></h4>
  </div>

  <div class="px-4 py-3 border-bottom pager1">
    <span class="top-left-btn">
      <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding:5px;width:auto">

        <!-- <input type="hidden" class="userIdtrans" /> -->
        <div class="input-group mb-3">
          <!-- <span class="input-group-text  Searchuseradmintrans" id="basic-addon1" style="background-color:rgb(238,238,238,.4);border:solid 1px #ddd"><i class='bx bx-search Searchuseradmintrans' style="font-size:18px;"></i></span> -->
          <span class="input-group-text search-icon-wrapper" id="basic-addon1" style="background-color:rgb(238,238,238,.4); border:solid 1px #ddd;">
            <i class='bx bx-search search-icon' style="font-size:18px;"></i>
            <div class="search-icon-overlay">
              <div class="spinner"></div>
            </div>
          </span>


          <!-- <input type="text" class="form-control queryholder" placeholder="<?= $translator['Search']; ?>..." aria-label="Username" aria-describedby="basic-addon1" /> -->
          <!-- Input field to search for admins -->
          <input name="transuserpayment" class="form-control" id="transuseradmin"
            placeholder="<?= $translator['Search']; ?>..." autocomplete="off" />

          <input type="hidden" class="adminuserIdtrans" />

          <select class="form-control" size="5"
            style="display: none; position: absolute; z-index: 1000;"
            id="adminuserAccountDropdown">
          </select>


        </div>



      </div>
    </span>
    <span class="top-center" aria-label=" navigation example">
      <!--enter is free-->
    </span>
    <span class="topp-right" id="paginations" aria-label="Page navigation example">

      <div class="btn-group mb-2" role="group" aria-label="Basic example"
        style="border:solid 1px #eee;color:#bbb;background-color:#fff">
        <button type="button" class="btn bg-white-subtle " value="right" aria-label="Refresh"
          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="PDF">
          <i class='bx bx-file' style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle " value="right" aria-label="Refresh"
          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="XLS">
          <i class='bx bx-file-blank' style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle" value="right" data-bs-placement="top" data-bs-title="Add new">
          ::
        </button>
        <button type="button" class="btn bg-white-subtle player refreshadminuser" value="" aria-label="Refresh"
          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
          <i class="bx bx-refresh" style="font-size: 20px;"></i>
        </button>


        <button type="button" class="btn bg-white-subtle" value="end" aria-label="Execute" data-bs-toggle="modal" data-bs-target="#add-new"
          data-bs-placement="top" data-bs-title="Add new">
          <i class='bx bx-plus' style="font-size:20px"></i>
        </button>
      </div>

    </span>

  </div>

  <div class="card-body p-4">
    <div class="table-responsive mb-4 border rounded-1 table-wrappereAdmin table-wrapper" id="maskadmin" style="position: relative; height:530px; overflow-y:scroll;">
      <table class="table text-nowrap mb-0 align-middle table-bordered table-hover">
        <thead class="text-dark fs-4 tbl-headerAdmin">
          <tr class="headrow">
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Avatar']; ?></h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Username']; ?></h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Full Name']; ?></h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Initials']; ?></h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Email Address']; ?></h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Mobile Number']; ?></h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Two Factor Enabled']; ?></h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Activity Role']; ?></h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Account Status']; ?></h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><i class='bx bx-dots-vertical-rounded'></i></h6>
            </th>
          </tr>
        </thead>
        <tbody id="dataContainerAdmin" class="tbl-contentadmin">
          <tr class="no-resultsAdmin">
            <td colspan="10" class="text-center">
              <img src="<?php echo BASE_URL; ?>assets/images/notfound.png" class="dark-logo" alt="Logo-Dark" />
            </td>
          </tr>
        </tbody>
      </table>
    </div> <!-- ✅ Correctly closing #mask wrapper -->
  </div>


  <div class="px-4 py-3 border-top pager">
    <span class="top-left-btn">
      <div class="btn-group mb-2" role="group" aria-label="Basic example"
        style="border:solid 1px #eee;color:#bbb;background-color:#fff">
        <!-- <button type="button" class="btn bg-white-subtle player" value="start">
          <i class='bx bx-chevrons-left' style="font-size:20px"></i>
        </button> -->
        <button type="button" class="btn bg-white-subtle player" value="left">
          <i class='bx bx-chevron-left' style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle player" value="right">
          <i class='bx bx-chevron-right' style="font-size:20px"></i>
        </button>
        <!-- <button type="button" class="btn bg-white-subtle player" value="end">
          <i class='bx bx-chevrons-right' style="font-size:20px"></i>
        </button> -->
      </div>
    </span>
    <span class="top-center" aria-label=" navigation example">

      <span id="paging_info_admin" style="color:#aaa">---</span>

    </span>


    <span class="top-right-btn" aria-label="Page navigation example">
      <select class="left-element form-control numrows" style="font-size:12px">
        <!-- <option value="5" class="fromnumrows">5</option>
            <option value="10">10</option>
            <option value="20">20</option> -->
        <option value="50">50</option>
        <option value="100">100</option>
        <option value="200">200</option>
        <option value="500">500</option>
      </select>
      <span id="paginationAdmin" class="right-element"> </span>
    </span>

  </div>

</div>

<div class="modal fade" id="al-danger-alertwe" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
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

<!-- sample modal content -->
<div id="add-new" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content" style="padding:20px">
      <div class="d-flex justify-content-between">
        <div><?= $translator['New Administrator']; ?></div>
        <div><i class='bx bx-message-square-x tclose' style='color:#868c87;font-size:25px;cursor:pointer;' data-bs-dismiss="modal" aria-label="Close"></i></div>
      </div>
      <p></p>
      <div class="">
        <!-- start Info Border with Icons -->
        <div class="cardd">
          <div class="card-body">
            <form id="admins">
              <div class="form-floating mb-3 d-flex row justify-content-center">

                <div class="d-flex align-items-center">
                  <a href="javascript:void(0)">
                    <img src="http://localhost/admin/app/assets/images/profile/user-1.jpg" value="user-1.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                    <i class='bx bxs-check-circle ava' style="font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;"></i>
                  </a>
                  <a href="javascript:void(0)">
                    <img src="http://localhost/admin/app/assets/images/profile/user-2.jpg" value="user-2.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                    <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;"></i>
                  </a>
                  <a href="javascript:void(0)">
                    <img src="http://localhost/admin/app/assets/images/profile/user-3.jpg" value="user-3.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                    <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;"></i>
                  </a>
                  <a href="javascript:void(0)">
                    <img src="http://localhost/admin/app/assets/images/profile/user-4.jpg" value="user-4.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                    <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;"></i>
                  </a>
                  <a href="javascript:void(0)">
                    <img src="http://localhost/admin/app/assets/images/profile/user-5.jpg" value="user-5.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                    <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;"></i>
                  </a>
                  <a href="javascript:void(0)">
                    <img src="http://localhost/admin/app/assets/images/profile/user-6.jpg" value="user-6.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                    <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;"></i>
                  </a>
                  <a href="javascript:void(0)">
                    <img src="http://localhost/admin/app/assets/images/profile/user-7.jpg" value="user-7.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                    <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;"></i>
                  </a>
                  <a href="javascript:void(0)">
                    <img src="http://localhost/admin/app/assets/images/profile/user-8.jpg" value="user-8.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                    <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;"></i>
                  </a>
                  <a href="javascript:void(0)">
                    <img src="http://localhost/admin/app/assets/images/profile/user-9.jpg" value="user-9.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                    <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;"></i>
                  </a>
                  <a href="javascript:void(0)">
                    <img src="http://localhost/admin/app/assets/images/profile/user-10.jpg" value="user-10.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                    <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;"></i>
                  </a>
                </div>

              </div>

              <div class="form-floating mb-3" hidden>
                <input type="text" class="form-control profile_picture" name="profile_picture" value="user-1.jpg" />
              </div>

              <div class="form-floating mb-3">
                <input type="text" class="form-control fullname" name="full_name" placeholder="Username" autocomplete="new-username" />
                <label>
                  <!-- <i class="ti ti-mail me-2 fs-4 text-info"></i> -->
                  <span class="border-start ps-3"><?= $translator['Full Name']; ?></span>
                </label>
              </div>

              <div class="form-floating mb-3">
                <input type="email" class="form-control fullemail" name="email" placeholder="Email" autocomplete="new-username" />
                <label>
                  <!-- <i class="ti ti-mail me-2 fs-4 text-info"></i> -->
                  <span class="border-start ps-3"><?= $translator['Email address']; ?></span>
                </label>
              </div>

              <div class="form-floating mb-3">
                <input type="email" class="form-control fullcontact" name="phone_number" placeholder="Email" autocomplete="new-username" />
                <label>
                  <!-- <i class="ti ti-mail me-2 fs-4 text-info"></i> -->
                  <span class="border-start ps-3"><?= $translator['Mobile Contact']; ?></span>
                </label>
              </div>

              <div class="form-floating mb-3">
                <select id="user-role" class="form-select fullrole" name="role">
                  <option value="super_admin"><?= $translator['Super Admin']; ?></option>
                  <option value="admin"><?= $translator['Admin']; ?></option>
                  <option value="moderator"><?= $translator['Moderator']; ?></option>
                  <option value="content_manager"><?= $translator['Content Manager']; ?></option>
                  <option value="support_staff"><?= $translator['Support Staff']; ?></option>
                  <option value="finance_manager"><?= $translator['Finance Manager']; ?></option>
                  <option value="agent_manager"><?= $translator['Agent Manager']; ?></option>
                  <option value="auditor"><?= $translator['Auditor']; ?></option>
                  <option value="limited"><?= $translator['Limited Access Admin']; ?></option>
                </select>

                <label>
                  <!-- <i class="ti ti-mail me-2 fs-4 text-info"></i> -->
                  <span class="border-start ps-3"><?= $translator['User Role']; ?></span>
                </label>
              </div>


              <div class="d-md-flex align-items-center">
                <div class="form-check">
                  <!-- <input type="checkbox" class="form-check-input" id="sf2" value="check" /> -->
                  <!-- <label class="form-check-label" for="sf2"><?= $translator['Verify before submit']; ?></label> -->
                </div>
                <div class="mt-3 mt-md-0 ms-auto">
                  <button type="submit" class="btn hstack gap-6 fullsubmit" style="border:solid 1px #ccc">
                    <i class="ti ti-send me-2 fs-4"></i>
                    <?= $translator['Submit']; ?>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- end Info Border with Icons -->
      </div>

    </div>
  </div>
</div>


<div id="view-profile" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content" style="padding:20px">
      <div class="d-flex justify-content-between">
        <h4 class="card-title"><?= $translator['Admin Profile']; ?></h4>
        <div><i class='bx bx-message-square-x tclose' style='color:#868c87;font-size:25px;cursor:pointer;' data-bs-dismiss="modal" aria-label="Close"></i></div>
      </div>
      <p></p>
      <div class="">
        <!-- start Info Border with Icons -->
        <div class="cardd">
          <div class="card-body">

            <div class="col-lg-12 d-flex align-items-stretch">
              <div class="card w-100 border position-relative overflow-hidden">
                <div class="card-body p-4">
                  <div class="text-center">
                    <img src="" alt="modernize-img" id="adminprofile" class="img-fluid rounded-circle" width="120" height="120">
                    <div class="d-flex align-items-center justify-content-center my-4 gap-4">
                      <h3 class="mb-0" id="pro_fullname"><?= $translator['full_name']; ?></h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-12">
              <div class="card w-100 border position-relative overflow-hidden mb-0">
                <div class="card-body p-4">
                  <h4 class="card-title"><?= $translator['Personal Details']; ?></h4>
                  <p class="card-subtitle mb-4"><?= $translator['To change your personal detail , edit and save from here']; ?></p>
                  <form>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label for="exampleInputtext" class="form-label"><?= $translator['User name']; ?></label>
                          <input type="text" class="form-control" id="adminusername" placeholder="---">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputtext1" class=" form-label"><?= $translator['Email address']; ?></label>
                          <input type="email" class="form-control" id="adminemail" placeholder="---">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputtext1" class="form-label"><?= $translator['Mobile contact']; ?></label>
                          <input type="email" class="form-control" id="admincontact" placeholder="---">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label for="exampleInputtext2" class="form-label"><?= $translator['Recovery email']; ?></label>
                          <input type="text" class="form-control" id="adminrecovery" placeholder="---">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputtext2" class="form-label"><?= $translator['Account status']; ?></label>
                          <input type="text" class="form-control" id="adminstatus" placeholder="---">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputtext3" class="form-label"><?= $translator['Activity role']; ?></label>
                          <input type="text" class="form-control" id="adminrole" placeholder="---">
                        </div>
                      </div>
                      <!-- <div class="col-12">
                                <div>
                                  <label for="exampleInputtext4" class="form-label">Address</label>
                                  <input type="text" class="form-control" id="exampleInputtext4" placeholder="814 Howard Street, 120065, India">
                                </div>
                              </div> -->
                      <div class="col-12">
                        <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
                          <!-- <button class="btn btn-primary">Save</button>
                                  <button class="btn bg-danger-subtle text-danger">Cancel</button> -->
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- end Info Border with Icons -->
      </div>
    </div>
  </div>
</div>


<!-- //permission card end-->
<div id="view-permissions" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content" style="padding:20px">
      <div class="d-flex justify-content-between">
        <h4 class="card-title adminName"></h4>
        <div class="d-flex align-items-center">
          <input class="form-check-input" type="checkbox" id="selectAllPermissions" name="permissions[]" value="view_users">
          <i class='bx bx-message-square-x tclose ms-3'
            style='color:#868c87; font-size:25px; cursor:pointer;'
            data-bs-dismiss="modal"
            aria-label="Close"></i>
        </div>
      </div>
      <p></p>
      <div class="permissionholder" style="overflow-y:scroll; max-height:500px;">
        <!-- Permissions content goes here -->
      </div>
      <div class="col-12">
        <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
          <button class="btn bg-danger-subtle text-danger updateperm">
            <?= $translator['Update permissions']; ?>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="view-activity-logs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h5 class="modal-title logname" id="myLargeModalLabel">
          ...
        </h5>
        <div><i class='bx bx-message-square-x tclose' style='color:#868c87;font-size:25px;cursor:pointer;' data-bs-dismiss="modal" aria-label="Close"></i></div>
      </div>
      <div class="px-4 py-3 border-bottom pager1">
        <span class="top-left-btn">
          <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding:5px;width:auto">


            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1" style="background-color:rgb(238,238,238,.4);border:solid 1px #ddd"><i class='bx bx-search' style="font-size:18px;"></i></span>
              <input type="text" class="form-control queryholder" placeholder="<?= $translator['Search']; ?>..." aria-label="Username" aria-describedby="basic-addon1" />
            </div>

            <div class="input-group mb-3">
              <input type="date" class="form-control queryholder datefrom" style="z-index:9999" />
            </div>

            <div class="input-group mb-3">
              <input type="date" class="form-control queryholder dateto" style="z-index:9999" />
            </div>
          </div>
        </span>
        <span class="top-center" aria-label=" navigation example">
          <!--enter is free-->
        </span>
        <span class="topp-right" id="paginations" aria-label="Page navigation example">

          <div class="btn-group mb-2" role="group" aria-label="Basic example"
            style="border:solid 1px #eee;color:#bbb;background-color:#fff">
            <button type="button" class="btn bg-white-subtle " value="right" aria-label="PDF"
              data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="PDF">
              <i class='bx bx-file' style="font-size:20px"></i>
            </button>
            <button type="button" class="btn bg-white-subtle " value="right" aria-label="XLS"
              data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="XLS">
              <i class='bx bx-file-blank' style="font-size:20px"></i>
            </button>
            <button type="button" class="btn bg-white-subtle rangelogs" value="right" aria-label="Filter"
              data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter">
              <i class='bx bx-check-double loaderz' style="font-size:20px"></i>
            </button>
          </div>

        </span>

      </div>

      <div class="modal-body" style="overflow-y:scroll;max-height:500px;">
        <table class="table text-nowrap align-middle table-bordered">
          <thead class="text-dark fs-4">
            <tr>
              <!-- <th>
                        <h6 class="fs-4 fw-semibold mb-0">Id</h6>
                      </th> -->
              <th>
                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Action']; ?></h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Date']; ?></h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Time']; ?></h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Ip Address']; ?></h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Affected']; ?></h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Old Value']; ?></h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['New Value']; ?></h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Status']; ?></h6>
              </th>
            </tr>
          </thead>
          <tbody id="adminLogsContainer">

          </tbody>
        </table>
      </div>
      <div class="modal-footer" id="paginationAdminLogs" style="border-top:solid 1px #eee;">
        <button type="button" class="btn bg-danger-subtle text-danger  waves-effect text-start" data-bs-dismiss="modal">
          Close
        </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
</div>