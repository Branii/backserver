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
    width: 19%;
    margin-right: 5px;
    background-color: #FFF;
  }

  .acc_transaction_username {
    width: 19%;
    position: absolute;
    color: #aaa;
    max-height: 300px;
    overflow-y: scroll;
    border-radius: 5px;
    padding: 10px;
    top: 90%;
    z-index: 9999;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
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

.tbl-header {
  position: sticky;
  top: 0;
}

.sticky-headerDraws {
  position: relative;
  bottom:1px;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
}

.pins{
  padding:5px;
  border-bottom: solid 1px rgb(110,129,146,0.1);
}


.bring-forward {
        position:absolute;
        z-index: 10 !important;
        background: white !important;
        
}
</style>

<div class="card w-100 position-relative overflow-hidden">

  <div class="px-4 py-3 border-bottom">
    <h4 class="card-title mb-0">Lottery Basic Records</h4>
  </div>

    <div class="px-4 py-3 border-bottom pagerlist1">
        <span class="top-left-btn">
            <div  class="btn-group mb-2" role="group" aria-label="Basic example" style="padding:5px;width:150%;">

    
<select name="betsate" class="form-control form-select queryholderlistt depositestate " data-bs-placeholder="Select Type" id="lottery" style="width: 70%;">
         <option value="all">--Select Lottery--</option>
        <option value="1" id="lt_1" name="lottery_type">5D</option>
        <option value="2" id="lt_2" name="lottery_type">PK10</option>
        <option value="3" id="lt_3" name="lottery_type">FAST3</option>
        <option value="5" id="lt_5" name="lottery_type">3D</option>
        <option value="6" id="lt_6" name="lottery_type">11x5</option>
        <option value="8" id="lt_8" name="lottery_type">Mark6</option>
        <option value="9" id="lt_9" name="lottery_type">PC28</option>
        <option value="10" id="lt_10" name="lottery_type">Happy</option>
      
        </select>
        </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topplist-right" id="paginations" aria-label="Page navigation example">

            <div class="btn-group mb-2" role="group" aria-label="Basic example"
                style="border:solid 1px #eee;color:#bbb;background-color:#fff">

              
                <button type="button" class="btn bg-white-subtle btn-disabled" value="" aria-label="Back" 
                     data-bs-placement="top" data-bs-title="Get User Details">
                    <i class='bx bxs-user' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle btn-disabled" value="" aria-label="Get Top Agent"
                     data-bs-title="Get Top Agent">
                    <i class='bx bxs-user-account' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle player refreshlist" value="" aria-label="Refresh"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class='bx bx-refresh' style="font-size:20px"></i>
                </button>
                <button type="button" class="btn bg-white-subtle fetch-lotter-basic-records" value="" aria-label="Search"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Search">
                    <i class='bx bx-check-double loaderlist' style="font-size:20px"></i>
                </button>

            </div>

        </span>

    </div>

  <div class="card-body p-4">
    <div class="table-responsive mb-4 border rounded-1 table-wrapper table-wrapperDraws" id="maskkk" style="height:530px;overflow-y:scroll;">
      <table class="table text-nowrap mb-0 align-middle table-bordered table-hover ">
        <thead class="text-dark fs-4 tbl-header">
          <tr class="headrowDraws">
            <!-- <th>
              <h6 class="fs-4 fw-semibold mb-0">Lottery Type</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Lottery Alias</h6>
            </th> -->
            <th>
              <h6 class="fs-4 fw-semibold mb-0">ID</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Lottery Icon</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Sorting Weight</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Lottery Name</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Lottery Source</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Lottery Description</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Lottery Code</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Maximum Prize Amount Per Bet</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Maximum Winnings Per Person Per Issue</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Maximum Bet Amount Per Issue</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Minimum Bet Amount Per Issue</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Lock Time for Closing Bets</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Lottery Status</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Action</h6>
            </th>
          </tr>
        </thead> 
        <tbody id="lot-basic-dtholder" class="tbl-content">

          <tr class="no-results">
            <td colspan="9">
              <img src="<?php echo BASE_URL; ?>assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark" />
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

      <span id="paging_info_draws" style="color:#aaa">---</span>

    </span>

   
      

    <span class="top-right-btn"  aria-label="Page navigation example">
    <select class="left-element form-control numrows" style="font-size:12px">
            <!-- <option value="5" class="fromnumrows">5</option>
            <option value="10">10</option>
            <option value="20">20</option> -->
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="200">200</option>
            <option value="500">500</option>
     </select>
      <span id="paginationDraws" class="right-element"> </span>
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


<div id="signup-modal" class="modal fade" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="text-center mt-2 mb-4">
          <div class="d-flex justify-content-between">
            <div>Transaction Info</div>
            <div><i class='bx bx-message-square-x tclose' style='color:#868c87;font-size:25px;cursor:pointer;' data-bs-dismiss="modal" aria-label="Close"></i></div>
          </div>
        </div>

        <form>
          <div class="row">
            <div class="col-md-6">
              <table class="table table-bordered table-striped">
                <tbody id="row1">
                </tbody>
              </table>
            </div>

            <div class="col-md-6">
              <table class="table table-bordered table-striped">
                <tbody id="row2">
                </tbody>
              </table>
            </div>

          </div>
        </form>

      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
