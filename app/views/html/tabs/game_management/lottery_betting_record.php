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

  .tops-left-btn {
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

  .tops-center {
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

  .tops-right-btn {
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

  .topps-right {
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

  .table-wrappers {
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

  .queryholders {
    width: 19%;
    margin-right: 5px;
    background-color: #FFF;
  }

  .user-options {
    width: 100%;
    /* Makes each option fill the select width */
    white-space: nowrap;
    /* Prevents text from wrapping */
    text-align: left;
    /* Adds some spacing inside the option */
    border-bottom: solid 1px #ccc;
  }

  .user-options:hover {
    background-color: #eee;
  }

  #userDropdowns {
    max-height: 300px;
    overflow-y: scroll;
    overflow-x: hidden;
  }
</style>
<div class="card w-100 position-relative overflow-hidden">
  <div class="px-4 py-3 border-bottom">
    <h4 class="card-title mb-0">LOTTERY BETTING RECORDS</h4>
  </div>

  <div class="px-4 py-3 border-bottom pager1">
    <span class="top-left-btn">
      <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding:5px;width:auto">

      
        <input type="text" class="form-control queryholders usernames" id="nametexlllt" aria-describedby="name" placeholder="Enter Name" />
        <div id="userDropdowns" class="form-control" size="5" style="background-color:#fff; position: absolute; top: 90%; width: 19%; display: none; z-index: 1000;">
        </div>


        <select name="order_type" class="form-control form-select queryholders selectlottery" data-bs-placeholder="Select Type" placeholder="slect lottery type">
          
        </select>

        <select name="order_type" class="form-control form-select queryholders ordertype" data-bs-placeholder="Select Type">
          <option value="all">all</option>
          <option value="1">Win</option>
          <option value="2">Loss</option>
          <option value="3">Pending</option>
          <option value="4">Refund</option>
        </select>

        <select name="order_type" class="form-control form-select queryholders ordertype" data-bs-placeholder="Select Type">
          <option value="all">all</option>
          <option value="1">Settled</option>
          <option value="2">Unsettled</option>
          <option value="6">Cancelled Bet</option>
          <option value="4">Refund</option>
          <option value="4">Deleted</option>
        </select>

        <input type="date" class="form-control queryholders startdate" id="nametextlll" aria-describedby="name" placeholder="Name" />

        <input type="date" class="form-control queryholders enddate" id="nametextlll" aria-describedby="name" placeholder="Name" />

      </div>
    </span>
    <span class="top-center" aria-label=" navigation example">
      <!--enter is free-->
    </span>
    <span class="topps-right" id="paginations" aria-label="Page navigation example">

      <div class="btn-group mb-2" role="group" aria-label="Basic example"
        style="border:solid 1px #eee;color:#bbb;background-color:#fff">
        <button type="button" class="btn bg-white-subtle player betrefresh" value="right" aria-label="Refresh"
          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
          <i class='bx bx-refresh' style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle executebet" value="end" aria-label="Execute"
          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
          <i class='bx bx-check-double loaderbet' style="font-size:20px"></i>
        </button>
      </div>

    </span>

  </div>

  <div class="card-body p-4">
    <div class="table-responsive mb-4 border rounded-1 table-wrappers" id="masks" style="height:530px;overflow-y:scroll;">
      <table class="table text-nowrap mb-0 align-middle table-bordered">
        <thead class="text-dark fs-4">
          <tr>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">
                Bet Order ID</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">User Name</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Issue Number</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Lottery Type</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Game Type</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Bet Time</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Bet Type</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Prize</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Number of Bets</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Unit Stake</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Multiplier</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Bet Amount</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Win Amount</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Rebate Amount</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Win/Loss</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Status</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">IP</h6>
            </th>

            <th>
              <h6 class="fs-4 fw-semibold mb-0"><i class='bx bx-dots-vertical-rounded'></i></h6>
            </th>
          </tr>
        </thead>
        <tbody id="lotterydataContainer">

          <!--Dynamic content here-->

        </tbody>
      </table>
    </div>
  </div>
  <div class="px-4 py-3 border-top pager">
    <span class="tops-left-btn">
      <div class="btn-group mb-2" role="group" aria-label="Basic example"
        style="border:solid 1px #eee;color:#bbb;background-color:#fff">
        <button type="button" class="btn bg-white-subtle players" value="betstart">
          <i class='bx bx-chevrons-left' style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle players" value="betleft">
          <i class='bx bx-chevron-left' style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle players" value="betright">
          <i class='bx bx-chevron-right' style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle players" value="betend">
          <i class='bx bx-chevrons-right' style="font-size:20px"></i>
        </button>
      </div>
    </span>
    <span class="tops-center" aria-label=" navigation example">

      <span id="paging_infos" style="color:#aaa">---</span>

    </span>
    <span class="tops-right" id="paginationss" aria-label="Page navigation example">

      <!--Dynamic pagination-->

    </span>

  </div>
</div>
</div>
</div>