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
  .table-wrapperbonus::-webkit-scrollbar {
    width: 5px;
    /* Slimmer scrollbar width */
    height: 5px;
    /* Slimmer scrollbar height for horizontal scrolling */
  }

  .table-wrapperbonus::-webkit-scrollbar-track {
    background: #f1f1f1;
    /* Lighter background for track */
    border-radius: 5px;
  }

  .table-wrapperbonus::-webkit-scrollbar-thumb {
    background-color: #ccc;
    /* Blue color for thumb */
    border-radius: 10px;
    cursor: pointer;
  }

  .table-wrapperbonus::-webkit-scrollbar-thumb:hover {
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

.tbl-headerbonus {
  position: sticky;
  top: 0;
  z-index: 9;
}

.sticky-headerbonus {
  position: relative;
  bottom:1px;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
 
}

.pins{
  padding:5px;
  border-bottom: solid 1px rgb(110,129,146,0.1);
}

/* From Uiverse.io by victoryamaykin */ 
.switch {
 position: relative;
 display: inline-block;
 width: 120px;
 height: 34px;
}

.switch input {
 display: none;
}

.slider {
 position: absolute;
 cursor: pointer;
 top: 0;
 left: 0;
 right: 0;
 bottom: 0;
 background-color:rgb(211, 8, 8);
 -webkit-transition: .4s;
 transition: .4s;
 border-radius: 34px;

}

.slider:before {
 position: absolute;
 content: "";
 height: 26px;
 width: 26px;
 left: 4px;
 bottom: 4px;
 background-color: white;
 -webkit-transition: .4s;
 transition: .4s;
 border-radius: 50%;
}

input:checked + .slider {
 background-color:rgb(6, 173, 48);
}

input:focus + .slider {
 box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
 -webkit-transform: translateX(26px);
 -ms-transform: translateX(26px);
 transform: translateX(85px);
}

/*------ ADDED CSS ---------*/
.slider:after {
 content: 'INACTIVE';
 color: white;
 display: block;
 position: absolute;
 transform: translate(-50%,-50%);
 top: 50%;
 left: 50%;
 font-size: 10px;
 font-family: Verdana, sans-serif;
}

input:checked + .slider:after {
 content: 'ACTIVE';
}

/*--------- END --------*/


.lbp-gamegroup-wrapper {
  margin: 1rem;
  margin-bottom: 2rem;
  padding: 1rem;
  border-radius: 10px;
  border: 1px solid #c6cad2;
}

.lbp-gamegroup-title {
  display: flex;
  align-items: center;
  padding: 16px 0px;
}
.lbp-center {
  margin: 0px auto;
}

.lbp-gameitem-wrapper {
  display: flex;
  flex-wrap: wrap;
  row-gap: .8rem;
  width: 105%;
  padding: 0px;
  margin: 0px;
}


.lbp-gameitem-parent{
  width: 31%;
  background: #f3f3f3;
  display: flex;
  padding: 10px;
  border-radius: 10px;
  padding-left: 20px;
  justify-content: space-evenly;
  margin-right: 20px;
  align-items: center;
}

.lbp-gameitem-name {

  /* margin-right: 50px; */
  color: #333;
  font-weight: 500;

}

.lbp-gameitem-input{
  background-color: #fff;
  padding: 8px;
  text-align: center;
}

.update-gamegroup:hover{
    /* border: solid 1px #2a3547; */
    color: #ccc !important;
    background: #2a3547 !important;
}

.update-gamegroup{
    border: solid 1px #ccc;
    color: #2a3547 !important;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.lpd-gameitem-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-right: 10px;
}

.lpd-gameitem-wrapper span {
  font-size: 0.8rem;
}


.lpd-switch{
    position: relative;
    display: inline-block;
    width: 120px;
    height: 34px;
}

.lpd-form-check-input[type=checkbox] {
    border-radius: .25em;
}

.lpd-switch input {
    display: none;
}

.lpd-form-check-input {
    --bs-form-check-bg: transparent;
    flex-shrink: 0;
    width: 1.313em;
    height: 1.313em;
    margin-top: .0935em;
    vertical-align: top;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: var(--bs-form-check-bg);
    background-image: var(--bs-form-check-bg-image);
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
    border: 1.25px solid #dfe5ef;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
}


.lpd-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgb(211, 8, 8);
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 34px;
}

input:checked + .lpd-slider {
    background-color: rgb(6, 173, 48);
}

.lpd-form-check-input:checked[type=checkbox] {
    --bs-form-check-bg-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e);
}

.lpd-form-check-input:checked {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
}
.lpd-form-check-input[type=checkbox] {
    border-radius: .25em;
}
.lpd-switch input {
    display: none;
}


input:checked + .lpd-slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(85px);
}
.lpd-slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .lpd-slider:after {
    content: 'ON';
}
.lpd-slider:after {
    content: 'OFF';
    color: white;
    display: block;
    position: absolute;
    transform: translate(-50%, -50%);
    top: 50%;
    left: 50%;
    font-size: 10px;
    font-family: Verdana, sans-serif;
}

/* From Uiverse.io by Subaashbala */ 
/* The switch - the box around the slider */
.switches {
  font-size: 17px;
  position: relative;
  display: inline-block;
  width: 5em;
  height: 2.25em;
}

/* Hide default HTML checkbox */
.switches input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider1 {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #e7eff9;
  outline: 1px solid #f3f8fe;
  box-shadow: 0 4px 5px #f3f8fe inset, 0 4px 5px #c8d5e6;
  transition: 0.4s;
  border-radius: 30px;
}

.slider1:before {
  position: absolute;
  content: "off";
  font-size: 0.85em;
  color: #d2d6d8;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 2em;
  min-width: 2em;
  border-radius: 20px;
  left: 0.35em;
  bottom: 0.3em;
  background-color: red;
  outline: 2px solid #d2d6d8;
  transition: 0.4s;
}

.switches input:checked + .slider1:before {
  content: "on";
  background-color: green;
  color: white;
  transform: translateX(3.1em);
}

</style>

<div class="card w-100 position-relative overflow-hidden">

  <div class="px-4 py-3 border-bottom">
    <h4 class="card-title mb-0"><?= $translator['Lottery Bonus Parameters']; ?></h4>
  </div>

  <div class="px-4 py-3 border-bottom pager1">
    <span class="top-left-btn">
      <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding:5px;width:173%">

        <select name="order_type" id="allGameNamesLottery" class="form-control form-select  lotteryTypes " style ="width:90%;">

        </select>
        <select name="order_type" class="form-control form-select"  style= "margin-left:15px" id="allmodels"
        data-bs-placeholder="Select Type">
        <!-- <option value="">-<?= $translator['Game Model']; ?>-</option>
        <option value="standard"><?= $translator['Standard']; ?></option>
        <option value="twosides"><?= $translator['Two Sides']; ?></option>
        <option value="longdragon"> <?= $translator['Long Dragon']; ?></option>
        <option value="boardgames"><?= $translator['Board Games']; ?></option>
        <option value="roadbet"><?= $translator['Road Bet']; ?></option>
        <option value="fantan"><?= $translator['Fantan']; ?></option>
        <option value="manytables"><?= $translator['Many Tables']; ?></option> -->
          </select>


          <select name="order_type" class="form-control form-select" style= "margin-left:15px; display: none;" id="game_groups">
       
          </select>

        <!-- <input type="date" class="form-control queryholder startdate" id="drawfrom"/>

        <input type="date" class="form-control queryholder enddate" id="drawto"/> -->

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
        <button type="button" class="btn bg-white-subtle  refreshdrawskk" value="right" aria-label="Refresh"
          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
          <i class='bx bx-refresh' style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle executegetparams" id="lbp_search" value="end" aria-label="Execute"
          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
          <i class='bx bx-check-double loader' style="font-size:20px"></i>
        </button>
      </div>

    </span>

  </div>
  <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperbonus lpd-table-wrappers" id="maskrfeferal" style="height:530px;overflow-y:scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered">
                <thead class="text-dark fs-4 tbl-headerbonus">
                    <tr class="headrowbonus">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?=  $translator['Game Type']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Play Group']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Lottery Games']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Lottery Odds']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Total Bets Control']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Total Bets']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Game Status']; ?></h6>
                        </th>
                        
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class='bx bx-dots-vertical-rounded'></i></h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="game_name_container">

                    <tr class="no-resultslist">
                        <td colspan="9">
                            <img src="<?php echo BASE_URL; ?>assets/images/notfound.png" class="dark-logo" alt="Logo-Dark" />
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="table-responsive mb-4 border rounded-1 table-wrapperbonus lpd-table-wrappers" id="lbp_twosides" style="height:530px;overflow-y:scroll;display:none;">
            <table class="table text-nowrap mb-0 align-middle table-bordered" style="display:none;">
                <thead class="text-dark fs-4 tbl-headerbonus">
                    <tr class="headrowbonus">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?=  $translator['Game Type']; ?> Two Sides headed </h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Play Group']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Lottery Games']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Lottery Odds']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Total Bets Control']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Total Bets']; ?></h6>
                        </th>
                       
                        
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class='bx bx-dots-vertical-rounded'></i></h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="game_name_container">

                    <tr class="no-resultslist">
                        <td colspan="9">
                            <img src="<?php echo BASE_URL; ?>assets/images/notfound.png" class="dark-logo" alt="Logo-Dark" />
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="table-responsive mb-4 border rounded-1 table-wrapperbonus lpd-table-wrappers" id="lbp_boardgames" style="height:530px;overflow-y:scroll;display:none;">
            <table class="table text-nowrap mb-0 align-middle table-bordered" style="display:none;">
                <thead class="text-dark fs-4 tbl-headerbonus">
                    <tr class="headrowbonus">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?=  $translator['Game Type']; ?> Two Sides headed </h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Play Group']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Lottery Games']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Lottery Odds']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Total Bets Control']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Total Bets']; ?></h6>
                        </th>
                       
                        
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class='bx bx-dots-vertical-rounded'></i></h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="game_name_container">

                    <tr class="no-resultslist">
                        <td colspan="9">
                            <img src="<?php echo BASE_URL; ?>assets/images/notfound.png" class="dark-logo" alt="Logo-Dark" />
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
<!--   
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
            <option value="5" class="fromnumrows">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="200">200</option>
            <option value="500">500</option>
     </select>
      <span id="paginationDraws" class="right-element"> </span>
    </span>

  </div> -->

</div>

