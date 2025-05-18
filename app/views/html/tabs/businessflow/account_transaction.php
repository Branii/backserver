
<div class="card w-100 position-relative overflow-hidden">
  <div class="px-4 py-3 border-bottom">
    <h4 class="card-title mb-0 translatable" data-key="account_transaction">Account Transactions</h4>
  </div>

  <div class="px-4 py-3 border-bottom pager1">
    <span class="top-left-btn">
      <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding:5px;width:auto">

        <input name="username" class="queryholder form-control translatable" data-key="enter_username" id="trans_username" placeholder="Enter Username" autocomplete="off"></input>

        <input type="text" class="form-control queryholder translatable" data-key="enter_transaction" id="trans_id" placeholder="Enter Transaction ID">

        <select name="order_type" class="form-control form-select queryholder" id="trans_type">
          <option value="" class="translatable" data-key="transaction_type">Transaction Type</option>
          <option value="1" class="translatable" data-key="deposit">Deposit</option>
          <option value="2" class="translatable" data-key="win_bonus">Win Bonus</option>
          <option value="3" class="translatable" data-key="bet_awarded">Bet Awarded</option>
          <option value="4" class="translatable" data-key="withdrawal">Withdrawal</option>
          <option value="5" class="translatable" data-key="bet_deduct">Bet Deduct</option>
          <option value="6" class="translatable" data-key="bet_cancelled">Bet Cancelled</option>
          <option value="7" class="translatable" data-key="rebate">Rebate</option>
          <option value="8" class="translatable" data-key="self_rebate">Self Rebate</option>
          <option value="9" class="translatable" data-key="send_red">Send Red Envelope</option>
          <option value="10" class="translatable" data-key="receive_red">Receive Red Envelope</option>
          <option value="11" class="translatable" data-key="bet_refund">Bet Refund</option>
          <option value="12" class="translatable" data-key="bet_lost">Bet Lost</option>
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
              <h6 class="fs-4 fw-semibold mb-0 translatable" data-key="id_number">ID Number</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0 translatable" data-key="user_name">User Name</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0 translatable" data-key="transaction_type">Transaction Type</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0 translatable" data-key="amount"> Amount </h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0 translatable" data-key="balance">Balance</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0 translatable" data-key="bet_date">Bet Date/Time</h6>
            </th>

            <th>
              <h6 class="fs-4 fw-semibold mb-0 translatable" data-key="server_date">Server Date/Time</h6>
            </th>

            <th>
              <h6 class="fs-4 fw-semibold mb-0 translatable" data-key="transaction_id">Transaction ID</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0 translatable" data-key="status">Status</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0 translatable"></h6><i class='bx bx-dots-vertical-rounded'></i></h6>
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


  <div class="micromodal" id="deposit_withdrawal" aria-hidden="true">
    <div class="micromodal__overlay" tabindex="-1" data-micromodal-close>
      <div class="micromodal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title" >

          <div class="modal-container">
              <header class="modal-container-header">
                  <span class="modal-container-title">
                  <i class='bx bx-receipt' style="font-size: 20px;" ></i>
                      Deposit Record
                  </span>
                  <!-- <button class="icon-buttonm" > -->
                      <i class='bx bx-x-circle' style="font-size: 30px;color:#ccc" aria-label="Close modal" data-micromodal-close></i>
                  <!-- </button> -->
              </header>
              <section class="modal-container-body rtf" style="width:500px">

              <div class="div" style="display: flex; justify-content: center; padding: 10px;border-bottom:solid 1px #ccc;position:relative;bottom:20px;">
                    <div style="font-size:20px;padding:5px;background-color:#eee;border-radius:10%" >GH₵ <span class="amount_recieved">00.00</span></div>
                </div>
                 
                <div class="div" style="display: flex; justify-content: space-between; padding: 10px;border-bottom:solid .5px #ccc">
                    <div>Amount Paid (GHS)</div>
                    <div class="amount_paid">0.00</div>
                </div>

                <div class="div" style="display: flex; justify-content: space-between; padding: 10px;border-bottom:solid .5px #ccc">
                    <div>Amount Recieved (GHS)</div>
                    <div class="amount_recieved">0.00</div>
                </div>

                <div class="div" style="display: flex; justify-content: space-between; padding: 10px;border-bottom:solid .5px #ccc">
                    <div>Total Charges (GHS)</div>
                    <div class="total_charges">0.00</div>
                </div>

                <div class="div" style="display: flex; justify-content: space-between; padding: 10px; border-bottom: solid .5px #ccc">
                    <div>Transaction Id</div>
                    <div class="transactionid">000xxx</div>
                </div>

                <div class="div" style="display: flex; justify-content: space-between; padding: 10px;border-bottom:solid .5px #ccc">
                    <div>Deposit From</div>
                    <div class="banktype"> xxx</div>
                </div>

                <div class="div" style="display: flex; justify-content: space-between; padding: 10px;border-bottom: dotted 1px #ccc">
                    <div>Date Created</div>
                    <div class="date_time_full">/</div>
                </div>

                <div class="div" style="">
                <ol class="timeline">
                  <li class="timeline-item">
                  <span class="timeline-item-icon | faded-icon">
                   <i class='bx bx-right-arrow-alt' ></i>
                    </span>
                    <div class="new-comment" style="display: flex;justify-content: space-between; padding: 10px;">
                      <span>Request Deposit</span>
                      <span class="date_time">/</span>
                    </div>
                  </li>
                  <li class="timeline-item">
                    <span class="timeline-item-icon | faded-icon">
                     <i class='bx bx-refresh' ></i>
                    </span>
                    <div class="new-comment" style="display: flex;justify-content: space-between; padding: 10px;">
                      <span>Processing</span>
                      <span class="date_time">/</span>
                    </div>
                  </li>
                  <li class="timeline-item">
                    <span class="timeline-item-icon | faded-icon">
                       <i class='bx bx-check'></i>
                    </span>
                    <div class="new-comment" style="display: flex;justify-content: space-between; padding: 10px;">
                      <span>Completed</span>
                      <span class="date_time">/</span>
                    </div>
                  </li>
                </ol>
                </div>
      
              </section>
              <footer class="modal-container-footer">
                  <span style="">Approved By: <b><span class="approved"></span></b></span>
              </footer>
          </div>
   
      </div>
    </div>
  </div>
 
