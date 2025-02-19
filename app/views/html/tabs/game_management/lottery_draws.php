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
</style>

<div class="card w-100 position-relative overflow-hidden">

  <div class="px-4 py-3 border-bottom">
    <h4 class="card-title mb-0">Lottery draw records</h4>
  </div>

  <div class="px-4 py-3 border-bottom pager1">
    <span class="top-left-btn">
    <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding:5px;width:156%;">

      <select name="order_type" id="allGameNames" class="form-control form-select queryholder ordertype" data-bs-placeholder="Select Type" style="width: 15%;">
      <option value="1">Royal 5</option>
      </select>
<div style="width: 15%;">
    <input name="issuenumber" class="queryholderlist form-control bring-forward" id="ltd-issuenumber" placeholder="Search Issue Number" autocomplete="off" style="width:97%;"> </div>



  <select name="status" id="ltd-status" class="form-control form-select queryholder" data-bs-placeholder="Select Status" style="width: 15%;">
    <option value="0">-- Status --</option>
    <option value="1">Open</option>
    <option value="2">Closed</option>
    <option value="waiting">Settling</option>
    <option value="done">Settled</option>

</select>

  <input type="date" class="form-control queryholder startdate" id="ltd-start-date" style="width: 15%;">
  <input type="date" class="form-control queryholder enddate" id="ltd-end-date" style="width: 15%;">

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
        <button type="button" class="btn bg-white-subtle" value="right">
         ::
        </button>
        <button type="button" class="btn bg-white-subtle  refreshdraws" value="right" aria-label="Refresh"
          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
          <i class='bx bx-refresh' style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle executegetdrawsb" value="end" aria-label="Execute"
          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
          <i class='bx bx-check-double loader' style="font-size:20px"></i>
        </button>
      </div>

    </span>

  </div>

  <div class="card-body p-4">
    <div class="table-responsive mb-4 border rounded-1 table-wrapper table-wrapperDraws" id="maskkk" style="height:530px;overflow-y:scroll;">
      <table class="table text-nowrap mb-0 align-middle table-bordered table-hover ">
        <thead class="text-dark fs-4 tbl-header">
          <tr class="headrowDraws">
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Lottery Type</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Lottery Code</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Issue Number']; ?></h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Winning Numbers']; ?> </h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Bet Amount']; ?></h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Win Amount']; ?></h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Draw Time</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Sales Deadline</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Actual Draw Time</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Settlement Completion Time</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Status</h6>
            </th>
            
          </tr>
        </thead> 
        <tbody id="dataContainerDrawsss" class="tbl-content">

          <tr class="no-results">
            <td colspan="12">
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

      <span id="ltd_paging_info_draws" style="color:#aaa">---</span>

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
      <span id="ltd_paginationDraws" class="right-element"> </span>
    </span>

  </div>

</div>


