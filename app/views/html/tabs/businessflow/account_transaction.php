
<div class="card w-100 position-relative overflow-hidden">
  <div class="px-4 py-3 border-bottom">
    <h4 class="card-title mb-0">Account Transactions</h4>
  </div>

  <div class="px-4 py-3 border-bottom pager1">
    <span class="top-left-btn">
      <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding:5px;width:auto">

        <input name="username" class="queryholder form-control" id="trans_username" placeholder="Enter Username" autocomplete="off"></input>

        <input type="text" class="form-control queryholder" id="trans_id" placeholder="Enter Transaction ID">

        <select name="order_type" class="form-control form-select queryholder" id="trans_type">
          <option value="">Transaction Type</option>
          <option value="1">Deposit</option>
          <option value="2">Win Bonus</option>
          <option value="3">Bet Awarded</option>
          <option value="4">Withdrawal</option>
          <option value="5">Bet Deduct</option>
          <option value="6">Bet Cancelled</option>
          <option value="7">Rebate</option>
          <option value="8">Self Rebate</option>
          <option value="9">Send Red Envelope</option>
          <option value="10">Receive Red Envelope</option>
          <option value="11">Bet Refund</option>
          <option value="12">Bet Lost</option>
        </select>

        <input type="date" class="form-control queryholder" id="trans_datefrom"/>

        <input type="date" class="form-control queryholder" id="trans_dateto" />

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
        <button type="button" class="btn bg-white-subtle " value="right" aria-label="Refresh" id="refresh_trans"
          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
          <i class='bx bx-refresh' id="accrefresh" style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle" value="end" aria-label="Execute" id="exec_trans"
          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
          <i class='bx bx-check-double' id="acctrans" style="font-size:20px"></i>
        </button>
      </div>

    </span>

  </div>

  <div class="card-body p-4">
    <div class="table-responsive mb-4 border rounded-1 table-wrapper acctablewrapper" id="acc_mask" style="height:555px;overflow-y:scroll;">
      <table class="table text-nowrap mb-0 align-middle table-bordered table-hover ">
        <thead class="text-dark fs-4 tbl-header" style="background-color: red;">
          <tr class="accheaderrow">
            <th>
              <h6 class="fs-4 fw-semibold mb-0">ID Number</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">User Name</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Transaction Type</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0"> Amount </h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Balance</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Bet Date/Time</h6>
            </th>

            <th>
              <h6 class="fs-4 fw-semibold mb-0">Server Date/Time</h6>
            </th>

            <th>
              <h6 class="fs-4 fw-semibold mb-0">Transaction ID</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Status</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0"><i class='bx bx-dots-vertical-rounded'></i></h6>
            </th>
          </tr>
        </thead> 
        <tbody id="accountTransactionTable" class="tbl-content">

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
        <button type="button" class="btn bg-white-subtle accplayer" value="left">
          <i class='bx bx-chevron-left' style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle accplayer" value="right">
          <i class='bx bx-chevron-right' style="font-size:20px"></i>
        </button>
      </div>
    </span>

    <span class="top-center">
      <span id="accPageInfo" style="color:#aaa">---</span>
    </span>

    <span class="top-right-btn"  aria-label="Page navigation example">
    <select class="left-element form-control accrowsort" style="font-size:12px">
            <!-- <option value="5" class="fromnumrows">5</option> -->
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="200">200</option>
            <option value="500">500</option>
     </select>
      <span id="accPageBox" class="right-element"> </span>
    </span>

  </div>
</div>



  <div class="micromodal" id="modal-1" aria-hidden="true">
    <div class="micromodal__overlay" tabindex="-1" data-micromodal-close>
      <div class="micromodal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title" >

          <div class="modal-container">
              <header class="modal-container-header">
                  <span class="modal-container-title">
                  <i class='bx bx-receipt' style="font-size: 20px;"></i>
                      Bet Details
                  </span>
                  <!-- <button class="icon-buttonm" > -->
                      <i class='bx bx-x-circle' style="font-size: 30px;color:#ccc" aria-label="Close modal" data-micromodal-close></i>
                  <!-- </button> -->
              </header>
              <section class="modal-container-body rtf">
                 
                <div class="div" style="display:flex">
                   <div class="left" style="width:auto;height:auto;border-right:solid 1px #eee">
                      <table class="table">
                          <tbody id="firstrow"></tbody>
                      </table>
                   </div>
                   <div class="right" style="width:auto;height:auto;">
                   <table class="table">
                          <tbody id="secondrow"></tbody>
                      </table>
                   </div>
                </div>
      
              </section>
              <!-- <footer class="modal-container-footer">
                  <button class="button is-ghost">Decline</button>
                  <button class="button is-primary">Accept</button>
              </footer> -->
          </div>
   
      </div>
    </div>
  </div>


  <div class="micromodal" id="modal-niii" aria-hidden="true">
    <div class="micromodal__overlay" tabindex="-1" data-micromodal-close>
      <div class="micromodal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title" >

          <div class="modal-container">
              <header class="modal-container-header">
                  <span class="modal-container-title">
                      <svg aria-hidden="true" height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M14 9V4H5v16h6.056c.328.417.724.785 1.18 1.085l1.39.915H3.993A.993.993 0 0 1 3 21.008V2.992C3 2.455 3.449 2 4.002 2h10.995L21 8v1h-7zm-2 2h9v5.949c0 .99-.501 1.916-1.336 2.465L16.5 21.498l-3.164-2.084A2.953 2.953 0 0 1 12 16.95V11zm2 5.949c0 .316.162.614.436.795l2.064 1.36 2.064-1.36a.954.954 0 0 0 .436-.795V13h-5v3.949z" fill="currentColor"></path>
                      </svg>
                      Terms and Services
                  </span>
                  <!-- <button class="icon-buttonm" > -->
                      <i class='bx bx-x-circle' style="font-size: 30px;color:#ccc" aria-label="Close modal" data-micromodal-close></i>
                  <!-- </button> -->
              </header>
              <section class="modal-container-body rtf">
                 
                <div class="div" style="display:flex">
                   <div class="left" style="width: 500px;height:600px;">
                      <table class="table">
                          <tbody id="firstrow"></tbody>
                      </table>
                   </div>
                   <div class="right" style="width: 500px;height:600px;">
                   <table class="table">
                          <tbody id="secondrow"></tbody>
                      </table>
                   </div>
                </div>
      
              </section>
              <footer class="modal-container-footer">
                  <button class="button is-ghost">Decline</button>
                  <button class="button is-primary">Accept</button>
              </footer>
          </div>
   
      </div>
    </div>
  </div>
 
