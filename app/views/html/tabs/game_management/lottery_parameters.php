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

/* From Uiverse.io by Subaashbala */ 
/* The switch - the box around the slider */
.switch {
  font-size: 17px;
  position: relative;
  display: inline-block;
  width: 5em;
  z-index:0;
  height: 2.25em;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #eee;
  outline: 1px solid #f3f8fe;
  box-shadow: 0 4px 5px #f3f8fe inset, 0 4px 5px #c8d5e6;
  transition: 0.4s;
  border-radius: 30px;
}

.slider:before {
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

.switch input:checked + .slider:before {
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
      <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding:5px;width:auto">

        <select name="order_type" id="allGameNamesLottery" class="form-control form-select  lotteryTypes" style ="width:90%;">

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
        <button type="button" class="btn bg-white-subtle  refreshdraws" value="right" aria-label="Refresh"
          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
          <i class='bx bx-refresh' style="font-size:20px"></i>
        </button>
        <button type="button" class="btn bg-white-subtle executegetparams" value="end" aria-label="Execute"
          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
          <i class='bx bx-check-double loader' style="font-size:20px"></i>
        </button>
      </div>

    </span>

  </div>

  <div class="card-body p-4">
    <div class="table-responsive mb-4 border rounded-1 table-wrapper table-wrapperDraws" id="maskkk" style="height:530px;overflow-y:scroll;">
      <div class="table text-nowrap mb-0 align-middle table-bordered table-hover ">
        <div class="text-dark fs-4 tbl-header">
        
        <div class="surface">
          <div class="mock-browser">
            <div class="chrome-tabs" id="tabheadParams"  style="--tab-content-margin: 9px;">
              <div class="chrome-tabs-content ten" style="position:relative;z-index:9999">
       
              </div>
              <div class="chrome-tabs-bottom-bar"></div>
              <!-- Styles to prevent flash after JS initialization -->
            </div>
            <!-- <div class="chrome-tabs-optional-shadow-below-bottom-bar"></div> -->
          </div>
        </div>
        </div> 
        <div id="dataContainerDraws" class="tbl-content">

          <div class="no-results chrome__tabb">
          
              <img src="<?php echo BASE_URL; ?>assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark" />
          
          </div>

          <div class="chrome__tabb standard_content"> 
            <table class="table table-bordered"> 
               <tr>
                 <th><?= $translator['Game Type']; ?></th>
                 <th><?= $translator['Play Group']; ?></th>
                 <th><?= $translator['Lottery Games']; ?></th>
                 <th><?= $translator['Lottery Odds']; ?></th>
                 <th><?= $translator['Play Method']; ?></th>
                 <th><?= $translator['Play Method']; ?></th>
                 <th><?= $translator['Total Bets']; ?></th>
                 <th><?= $translator['Current Total Bets']; ?></th>
               </tr>
               <tbody class="game_name_container">

               </tbody>
            </table>
          </div>
          <div class="chrome__tabb twoside_content">
          <table class="table table-bordered"> 
               <tr>
                 <th>Game Play Group</th>
                 <th>Play Group</th>
                 <th>Lottery Games</th>
                 <th>Lottery Odds</th>
                 <th>Play Method</th>
                 <th>Total Bets</th>
               </tr>
               <tbody class="twosides_container">

               </tbody>
            </table>
          </div>
          <div class="chrome__tabb longdragon_content"> 
          <table class="table table-bordered"> 
               <tr>
                 <th>Game Play Group</th>
                 <th>Play Group</th>
                 <th>Lottery Games</th>
                 <th>Lottery Odds</th>
                 <th>Play Method</th>
                 <th>Total Bets</th>
               </tr>
               <tbody class="longdragon_container">

               </tbody>
            </table>
          </div>
          <div class="chrome__tabb boardgame_content"> 
          <table class="table table-bordered"> 
               <tr>
                 <th>Game Play Group</th>
                 <th>Play Group</th>
                 <th>Lottery Games</th>
                 <th>Lottery Odds</th>
                 <th>Play Method</th>
                 <th>Total Bets</th>
               </tr>
               <tbody class="boardgames_container">

               </tbody>
            </table>
          </div>
          <div class="chrome__tabb roadbet_content"> 
          <table class="table table-bordered"> 
               <tr>
                 <th>Game Play Group</th>
                 <th>Play Group</th>
                 <th>Lottery Games</th>
                 <th>Lottery Odds</th>
                 <th>Play Method</th>
                 <th>Total Bets</th>
               </tr>
               <tbody class="roadbet_container">

               </tbody>
            </table>
          </div>
          <div class="chrome__tabb fantan_content">
          <table class="table table-bordered"> 
               <tr>
                 <th>Game Play Group</th>
                 <th>Play Group</th>
                 <th>Lottery Games</th>
                 <th>Lottery Odds</th>
                 <th>Play Method</th>
                 <th>Total Bets</th>
               </tr>
               <tbody class="fantan_container">

               </tbody>
            </table>
          </div>
          <!-- <div class="chrome__tabb manytable_content"> 
          <table class="table"> 
               <tr>
                 <th>Game Play Group</th>
                 <th>Play Group</th>
                 <th>Lottery Games</th>
                 <th>Lottery Odds</th>
                 <th>Play Method</th>
                 <th>Total Bets</th>
               </tr>
               <tbody class="standard_container">

               </tbody>
            </table>
          </div> -->

        </div>
      </div>
    </div>





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

