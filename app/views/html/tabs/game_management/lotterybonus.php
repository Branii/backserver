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

  .tab-btn {
    padding: 5px 10px;
    margin: 3px;
    background-color: #f1f1f1;
    border: 1px solid #ccc;
    cursor: pointer;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;

  }

  .tab-btn:hover {
    background-color: #e1e1e1;
  }
</style>
<div class="card w-100 position-relative overflow-hidden">
  <div class="px-4 py-3 border-bottom">
    <h4 class="card-title mb-0"></h4>
  </div>

  <div class="px-4 py-3 border-bottom pager1">
    <span class="top-left-btn">
      <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding:5px;width:auto">

        <select name="order_type" class="form-control form-select queryholders selectmain" data-bs-placeholder="Select Type" placeholder="slect lottery type">

        </select>


        <input type="date" class="form-control queryholders startdate" id="naetextlll" aria-describedby="name" placeholder="Name" />

        <input type="date" class="form-control queryholders enddate" id="nmetextlll" aria-describedby="name" placeholder="Name" />

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


  <div class="showtabss"></div>
  <hr>


  <div class="tab-contentss standard-tab-content" id="standard-tab" style="display:none;">
    <div class="table-responsive mb-4 border rounded-1 table-wrapper table-wrapperDraws" id="maskkk" style="height:530px;overflow-y:scroll;">
      <table class="table text-nowrap mb-0 align-middle table-bordered table-hover ">
        <thead class="text-dark fs-4 tbl-header">
          <tr class="headrowDraws">

            <th>
              <h6 class="fs-4 fw-semibold mb-0">Game PLay Group</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">PLay Group</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Lottery Game</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Standard Odds</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Play Method</h6>
            </th>

            <th>
              <h6 class="fs-4 fw-semibold mb-0">Total Bets</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Actual Draw Time</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Settle Complete Time</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Draw Status</h6>
            </th>
          </tr>
        </thead>
        <tbody id="" class="tbl-content maingameContainer">

          <tr class="no-results">
            <td colspan="9">
              <img src="<?php echo BASE_URL; ?>assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark" />
            </td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>

  <!-- Twosides tab content -->
  <div class="tab-contentss  twosides-tab-content" id="twosides-tab" style="display:none;">
    <div class="table-responsive mb-4 border rounded-1 table-wrapper table-wrapperDraws" id="maskkk" style="height:530px;overflow-y:scroll;">
      <table class="table text-nowrap mb-0 align-middle table-bordered table-hover ">
        <thead class="text-dark fs-4 tbl-header">
          <tr class="headrowDraws">

            <th>
              <h6 class="fs-4 fw-semibold mb-0">Game PLay Group</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">PLay Group</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Lottery Game</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Play Method</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Win Amount</h6>
            </th>

            <th>
              <h6 class="fs-4 fw-semibold mb-0">Sale Deadline</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Actual Draw Time</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Settle Complete Time</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Draw Status</h6>
            </th>
          </tr>
        </thead>
        <tbody id="" class="tbl-content maingameContainer">

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