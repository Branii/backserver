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
    justify-content: space-between; /* Optional: Adds space between elements */
    align-items: center; /* Optional: Vertically centers the elements */
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

  .table-wrapperBackup{
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
  bottom:8px;
  height: 35px;
  background-color: #fff;
  margin-right: 5px;
}

.active > .page-link{
  background-color: orangered !important;
  border:none;
}
.tbl-headerBackup {
  position: sticky;
  top: 0;
}

.sticky-headerBackup{
  position: relative;
  bottom:1px;
  background-color: red;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
}

.pins{
  padding:5px;
  border-bottom: solid 1px rgb(110,129,146,0.1);
}

.ini{
  font-size: 16px;
  border: solid 1px #eee;
  background-color: #ddd;
}

.slected{
  border:solid 2px orangered
}

.daterangepicker{
  box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px  !important;
}

</style>

<div class="card w-100 position-relative overflow-hidden">

  <div class="px-4 py-3 border-bottom">
    <h4 class="card-title mb-0">System backups and recovery</h4>
  </div>

  <div class="px-4 py-3 border-bottom pager1">
    <span class="top-left-btn">
      <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding:5px;width:auto">


          <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="background-color:rgb(238,238,238,.4);border:solid 1px #ddd"><i class='bx bx-search' style="font-size:18px;"></i></span>
                    <input type="text" class="form-control linkedCalendars queryholder" placeholder="Search ..." aria-label="Username" aria-describedby="basic-addon1" />
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
        <button type="button" class="btn bg-white-subtle" value="right" >
          ::
        </button>
        <button type="button" class="btn bg-white-subtle refreshh" value="right" aria-label="Refresh"
          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
          <i class='bx bx-refresh' style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle createnew" value="end"
          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Create new">
          <i class='bx bx-plus' style="font-size:20px"></i>
        </button>
      </div>

    </span>

  </div>

  <div class="card-body p-4">
    <div class="table-responsive mb-4 border rounded-1 table-wrappereBackup table-wrapper" id="maskk" style="height:530px;overflow-y:scroll;">
      <table class="table text-nowrap mb-0 align-middle table-bordered table-hover ">
        <thead class="text-dark fs-4 tbl-headerBackup">
          <tr class="headrowBackup">
            <th>
              <h6 class="fs-4 fw-semibold mb-0">#Id</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Ico</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Backup Name</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Backup Type</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Backup Path</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Backup Size</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Encryption Type</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Backup Date</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Backu Time</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Backup Status</h6>
            </th>
      
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><i class='bx bx-dots-vertical-rounded'></i></h6>
            </th>
          </tr>
        </thead> 
        <tbody id="dataContainerBackup" class="tbl-contentbackup">

          <tr class="no-resultsAdmin">
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
      <div class="btn-group mb-2" role="group" aria-label="Basic example"
        style="border:solid 1px #eee;color:#bbb;background-color:#fff">
        <button type="button" class="btn bg-white-subtle player" value="start">
          <i class='bx bx-chevrons-left' style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle player" value="left">
          <i class='bx bx-chevron-left' style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle player" value="right">
          <i class='bx bx-chevron-right' style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle player" value="end">
          <i class='bx bx-chevrons-right' style="font-size:20px"></i>
        </button>
      </div>
    </span>
    <span class="top-center" aria-label=" navigation example">

      <span id="paging_info_backup" style="color:#aaa">---</span>

    </span>

   
    <span class="top-right-btn"  aria-label="Page navigation example">
    <select class="left-element form-control numrowsbackup" style="font-size:12px">
            <!-- <option value="5" class="fromnumrows">5</option>
            <option value="10">10</option>
            <option value="20">20</option> -->
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="200">200</option>
            <option value="500">500</option>
     </select>
      <span id="paginationBackup" class="right-element"> </span>
    </span>

  </div>

</div>

<div class="modal fade" id="al-danger-alert" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
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
            <div>New Administrator</div>
            <div><i class='bx bx-message-square-x tclose' style='color:#868c87;font-size:25px;cursor:pointer;' data-bs-dismiss="modal" aria-label="Close"></i></div>
          </div><p></p>
          <div class="">
              <!-- start Info Border with Icons -->
              <div class="cardd">
                <div class="card-body">
                  <form id="admins">
                    <div class="form-floating mb-3 d-flex row justify-content-center">

                      <div class="d-flex align-items-center">
                          <a href="javascript:void(0)">
                            <img src="http://localhost/admin/app/assets/images/profile/user-1.jpg" value="user-1.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                            <i class='bx bxs-check-circle ava' style="font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;" ></i>
                          </a>
                          <a href="javascript:void(0)">
                            <img src="http://localhost/admin/app/assets/images/profile/user-2.jpg" value="user-2.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                            <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;" ></i>
                          </a>
                          <a href="javascript:void(0)">
                            <img src="http://localhost/admin/app/assets/images/profile/user-3.jpg" value="user-3.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                            <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;" ></i>
                          </a>
                          <a href="javascript:void(0)">
                            <img src="http://localhost/admin/app/assets/images/profile/user-4.jpg" value="user-4.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                            <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;" ></i>
                          </a>
                          <a href="javascript:void(0)">
                            <img src="http://localhost/admin/app/assets/images/profile/user-5.jpg" value="user-5.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                            <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;" ></i>
                          </a>
                          <a href="javascript:void(0)">
                            <img src="http://localhost/admin/app/assets/images/profile/user-6.jpg" value="user-6.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                            <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;" ></i>
                          </a>
                          <a href="javascript:void(0)">
                            <img src="http://localhost/admin/app/assets/images/profile/user-7.jpg" value="user-7.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                            <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;" ></i>
                          </a>
                          <a href="javascript:void(0)">
                            <img src="http://localhost/admin/app/assets/images/profile/user-8.jpg" value="user-8.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                            <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;" ></i>
                          </a>
                          <a href="javascript:void(0)">
                            <img src="http://localhost/admin/app/assets/images/profile/user-9.jpg" value="user-9.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                            <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;" ></i>
                          </a>
                          <a href="javascript:void(0)">
                            <img src="http://localhost/admin/app/assets/images/profile/user-10.jpg" value="user-10.jpg" class="rounded-circle me-n2 card-hover border border-2 border-white upp" width="50" height="50">
                            <i class='bx bxs-check-circle ava' style="display:none;font-size: 20px;position:relative;top:20px;left:-8px;z-index:9999;" ></i>
                          </a>
                        </div>
                      
                    </div>
                    <div class="form-floating mb-3" hidden>
                      <input type="text" class="form-control profile_picture" name="profile_picture" value="user-1.jpg"/>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control fullname" name="full_name" placeholder="Username" autocomplete="new-username"/>
                      <label>
                        <!-- <i class="ti ti-mail me-2 fs-4 text-info"></i> -->
                        <span class="border-start ps-3">Full Name</span>
                      </label>
                    </div>
                    <div class="form-floating mb-3" >
                      <input type="email" class="form-control fullemail" name="email" placeholder="Email" autocomplete="new-username"/>
                      <label>
                        <!-- <i class="ti ti-mail me-2 fs-4 text-info"></i> -->
                        <span class="border-start ps-3">Email address</span>
                      </label>
                    </div>

                    <div class="form-floating mb-3" >
                      <input type="email" class="form-control fullcontact" name="phone_number" placeholder="Email" autocomplete="new-username"/>
                      <label>
                        <!-- <i class="ti ti-mail me-2 fs-4 text-info"></i> -->
                        <span class="border-start ps-3">Mobile Contact</span>
                      </label>
                    </div>

                    <div class="form-floating mb-3" >
                    <select id="user-role" class="form-select fullrole" name="role">
                      <option value="super_admin">Super Admin</option>
                      <option value="admin">Admin</option>
                      <option value="moderator">Moderator</option>
                      <option value="content_manager">Content Manager</option>
                      <option value="support_staff">Support Staff</option>
                      <option value="finance_manager">Finance Manager</option>
                      <option value="agent_manager">Agent Manager</option>
                      <option value="auditor">Auditor</option>
                      <option value="limited">Limited Access Admin</option>
                    </select>

                      <label>
                        <!-- <i class="ti ti-mail me-2 fs-4 text-info"></i> -->
                        <span class="border-start ps-3">User Role</span>
                      </label>
                    </div>
                   

                    <div class="d-md-flex align-items-center">
                      <div class="form-check">
                        <!-- <input type="checkbox" class="form-check-input" id="sf2" value="check" /> -->
                        <label class="form-check-label" for="sf2">Verify before submit</label>
                      </div>
                      <div class="mt-3 mt-md-0 ms-auto">
                        <button type="submit" class="btn hstack gap-6 fullsubmit" style="border:solid 1px #ccc">
                          <i class="ti ti-send me-2 fs-4"></i>
                          Submit
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
                     

