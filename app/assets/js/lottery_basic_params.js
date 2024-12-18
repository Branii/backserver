$(() => {
  //      // Muniru <!---- FUNCTIONS BY YUSSIF MUNIRU ---------------->
  //         let max_prize_amt_per_bet = "";
  //         let max_win_per_issue = "";
  //         let maximum_amount_per_issue = "";
  //         let minimum_amount_per_issue = "";
  //         let min_amount_per_issue = "";
  //         let closing = "";

  //        $(document).on('click', '.edit-params-act-btn', function () {
  //         max_prize_amt_per_bet = $(this).attr("max-prize-amt-per-bet");
  //         max_win_per_issue = $(this).attr("maximum_win_per_issue");
  //         maximum_amount_per_issue = $(this).attr("maximum_amount_per_issue");
  //         min_amount_per_issue = $(this).attr("minimum_amount_per_issue");
  //         closing = $(this).attr("closing_time");
  //         const gameID = $(this).attr("game-id");
  //         $("#gt_id").attr("game-id",gameID);

  //         $(`#max-prize`).val($(this).attr("max-prize-amt-per-bet"));
  //         $(`#max-wins`).val($(this).attr("maximum_win_per_issue"));
  //         $(`#max-bet-amount`).val($(this).attr("maximum_amount_per_issue"));
  //         $(`#min-bet-amount`).val($(this).attr("minimum_amount_per_issue"));
  //         $(`#lock-time`).val($(this).attr("closing_time"));

  //        });
  //        $(document).on('click', '#edit-params-btn', function () {
  //         max_prize_amt_per_bet = $("#max-prize").val();
  //         max_win_per_issue =  $("#max-wins").val();
  //         maximum_amount_per_issue =$("#max-bet-amount").val();
  //         min_amount_per_issue = $("#min-bet-amount").val();
  //         closing = $("#lock-time").val();

  //         const flag = "update-params";
  //         const gameID = $("#gt_id").attr("game-id");
  //         const data = new URLSearchParams({max_prize_amt_per_bet: max_prize_amt_per_bet, max_win_per_issue: max_win_per_issue, maximum_amount_per_issue:maximum_amount_per_issue,min_amount_per_issue: min_amount_per_issue, closing: closing,gameid: gameID}).toString();
  //         console.log(data);

  //      $.ajax({
  //                 url: "../controller/gamesetting/LotteryBasicParams",
  //                 method: "POST",
  //                 data: { data: data, flag: flag },
  //                 beforeSend: function() {
  //                     // Show the spinner before the request starts
  //                      $("#lottery-basic-loader").css({'display': 'flex'});
  //                 },
  //                 success: function(response) {
  //                   console.log(response);
  //                   response = JSON.parse(response);
  //                   if(response.status === "success"){

  //                        $(`#edit-${gameID}`).attr("max-prize-amt-per-bet",max_prize_amt_per_bet);
  //                        $(`#edit-${gameID}`).attr("maximum_win_per_issue",max_win_per_issue);
  //                        $(`#edit-${gameID}`).attr("maximum_amount_per_issue",maximum_amount_per_issue);
  //                        $(`#edit-${gameID}`).attr("minimum_amount_per_issue",min_amount_per_issue);
  //                        $(`#edit-${gameID}`).attr("closing_time",closing);
  //                        $(`#td-mx-prize-${gameID}`).text(max_prize_amt_per_bet);
  //                        $(`#td-mx-win-${gameID}`).text(max_win_per_issue);
  //                        $(`#td-mx-amt-${gameID}`).text(maximum_amount_per_issue);
  //                        $(`#td-mn-amt-${gameID}`).text(min_amount_per_issue);
  //                        $(`#td-clsing-${gameID}`).text(closing);
  //                        alert("Parameters Updated Successfully.");
  //                        $(".btn-close-white").click();

  //                   }

  //                 },
  //                 complete: function() {
  //                     // Hide the spinner after the request is complete (either success or failure)
  //                      $("#lottery-basic-loader").css({'display': 'none'});
  //                 }
  //             });

  // });

  //  $(document).on('click', '.gameon, .gameoff', function () {
  //          console.log("gameID,status");
  //          const gameID = $(this).attr("data-target");
  //          const status = $(this).attr('class').split(' ')[1];

  //          $("#confirm-state-btn-" + status).attr({'data-gm-id': gameID, 'data-status': status});
  //         console.log("gameID,status");
  // });

  //  $(document).on('click', '#confirm-state-btn-gameon,#confirm-state-btn-gameoff', function () {

  //          const flag = "update-lottery-state";
  // 		 const status = $(this).attr('data-status');
  // 	     const gameID = $(this).attr('data-gm-id');
  //          const data = new URLSearchParams({state: status,gameid: gameID}).toString();

  //           if((status === 'gameon' && $(`#state-${gameID}`).text().toLowerCase() === 'turned on') || (status === 'gameoff' && $(`#state-${gameID}`).text().toLowerCase() === 'turned off')) {

  //             $(".btn-close-white").click();
  //             return;
  //           }
  //      $.ajax({
  //                 url: "../controller/gamesetting/LotteryBasicParams",
  //                 method: "POST",
  //                 data: { data: data, flag: flag },
  //                 beforeSend: function() {
  //                     // Show the spinner before the request starts
  //                      $("#lottery-basic-loader").css({'display': 'flex'});
  //                 },
  //                 success: function(response) {
  //                     console.log(response);
  //                     response = JSON.parse(response); // parse the response into a json obj

  //                     // use the status and data properties to identify changes made (data == 0 -> changes made, data == 1 -> no changes made)
  //                   if(response.status === "success" && response.data != 0){
  //                         $(`#state-${gameID}`).text(status == 'gameon' ? 'Turned On' : 'Turned Off');
  //                          alert("No user information changed.");
  //                   }else if(response.status === "success" && response.data == 0){
  //                        alert("No user information changed.");
  //                   } else{
  //                        console.error(response.msg);
  //                   }

  //                 },
  //                 complete: function() {
  //                     // Hide the spinner after the request is complete (either success or failure)
  //                      $("#lottery-basic-loader").css({'display': 'none'});
  //                      $(".btn-close-white").click();
  //                     // modalClose("confirm-state-modal-" + status);
  //                 }
  //             });

  // });

  //             $(document).on("click", "#refresh-lottery-draw" , function() {

  //                  $("#ld-username").val('');
  //                  $("#ld-lottery").val('');
  //                  $("#ld-startdate").val('');
  //                  $("#ld-enddate").val("");
  //                       $.ajax({
  //                       url: `../admin/refresh_lottery_draw`,
  //                 type: "POST",
  //                 data: {flag: 'refresh' },
  //                 beforeSend: function(){
  //                     $("#lottery-draw-loader").css({'display': 'flex'});
  //                 },
  //                 success:function (response) {

  //                     response = JSON.parse(response);
  //                     console.log(response);

  //                     if(response.length === 0){
  //                         $("#lottery-draw-dtholder").html(`<tr><td colspan='12' style='text-align:center;'>No Draw Records</td></tr>`);
  //                         $("#lottery-draws-pages-wrapper").html("");
  //                         return;
  //                     }
  //                     let rowsMarkup = "";
  //                     console.log(response);
  //                     response.forEach((row)=>{
  //                            rowsMarkup += lotteryDrawMarkup(row);
  //                     });
  //                     console.log(rowsMarkup);
  //                    $("#lottery-draw-dtholder").html(rowsMarkup);

  //                  renderPagination(1,response[0].count_draw_numbers,'ldr','filter-lottery-draw',"lottery-draws");
  //                 },
  //                 error:function (res,status,error) {
  //                   $(".dataholder").html("<tr><td colspan='12' style='text-align:center;'>An error occured, please try again later.</td></tr>");
  //                    console.log("An error occured: " + status + " - " + error);
  //                 },
  //                 complete:function () {
  //                      $("#lottery-draw-loader").css({'display': 'none'});
  //                 }

  //             }
  //             );
  //             });

  //             $(document).on("click", "#filter-lottery-basic,.lottery-basic-Btn,.prev-lottery-basic-Btn,.next-lottery-basic-Btn" , function() {

  //                 const lottery_id = $("#lottery_type").val();

  //                 let page        = !$(this).hasClass('prev-lottery-basic-Btn') &&  !$(this).hasClass('next-lottery-basic-Btn') ? parseInt($(this).attr('id').split('-').pop()) : $("#lottery-basic-pages-wrapper").find(".active-page").attr("id").split("-").pop();

  //                 page     = parseInt(page);
  //                 page     = Number.isNaN(page) ? 1 : page;

  //                 if($(this).hasClass('prev-lottery-basic-Btn')) page = page - 1;
  //                 if($(this).hasClass('next-lottery-basic-Btn')) page = page + 1;

  //                 let data = new URLSearchParams({lottery_id: lottery_id, page:page}).toString();

  //                 $.ajax({
  //                     url: "../controller/gamesetting/LotteryBasicParams",
  //                 type: "POST",
  //                 data: {flag: 'filter-lottery' , data: data},
  //                 beforeSend: function(){
  //                     $("#lottery-basic-loader").css({'display': 'flex'});
  //                 },
  //                 success:function (response) {
  //                     console.log(response);
  //                     response = JSON.parse(response);
  //                     console.log(response);
  //                     const totalCount = response.totalCount;
  //                     response  = response.data;
  //                     if(response.length === 0){
  //                         $("#lottery-basic-dtholder").html(`<tr><td colspan='12' style='text-align:center;'>No Draw Records</td></tr>`);
  //                         $("#lottery-basic-pages-wrapper").html("");
  //                         return;
  //                     }
  //                     let rowsMarkup = "";
  //                     response.forEach((row)=> {
  //                            rowsMarkup += lotteryBasicParametersMarkup(row);
  //                     });
  //                  const pagesMarkup = renderPagination(page,totalCount, "bl",  "lottery-basic","lottery-basic");
  //                  console.log(pagesMarkup);
  //                    $("#lottery-basic-dtholder").html(rowsMarkup);
  //                 },
  //                 error:function (res,status,error) {
  //                   $(".dataholder").html("<tr><td colspan='12' style='text-align:center;'>An error occured, please try again later.</td></tr>");
  //                    console.log("An error occured: " + status + " - " + error);
  //                 },
  //                 complete:function () {
  //                      $("#lottery-basic-loader").css({'display': 'none'});
  //                 }

  //             }
  //             );
  //             });

  //     $(document).on("click", ".filter-lottery-draw-Btn,.prev-filter-lottery-draw-Btn,.next-filter-lottery-draw-Btn" , function() {

  //             $("#ld-username").val('');
  //             $("#ld-lottery").val('');
  //             $("#ld-startdate").val('');
  //             $("#ld-enddate").val("");
  //             page     = parseInt(page);
  //             page     = Number.isNaN(page) ? 1 : page;
  // 		    console.log(page);
  //          if($(this).hasClass('prev-filter-lottery-draw-Btn')) page = page - 1;
  // 		 if($(this).hasClass('next-filter-lottery-draw-Btn')) page = page + 1;

  //         if (
  //         (($("#filter-lottery-draw-lotter").val().length === 0 || lottery_id === "undefined") &&
  //       start_date.length == 0 &&
  //       end_date.length == 0
  //     ) && ($(this).attr('aria-current') != "page")) {

  //       showDefaultToast("Make one or more filters", 2000, "tomato");
  //       return false;
  //     } else {

  //             let flag = "filterLotteryDrawRecords";
  //             let  data  = {lottery_id:lottery_id,start_date:start_date,end_date:end_date,page:page};
  //             data       = new URLSearchParams(data).toString();

  //             $.ajax({
  //                 url: `../admin/get_user_details/`,
  //                 type: "POST",
  //                 data: { data: data, flag: flag },
  //                 beforeSend: function(){
  //                     $("#lottery-draw-loader").css({'display': 'flex'});
  //                 },
  //                 success:function (response) {

  //                     response = JSON.parse(response);
  //                     console.log(response);

  //                     if(response.length === 0){
  //                         $("#lottery-draw-dtholder").html(`<tr><td colspan='12' style='text-align:center;'>No Draw Records</td></tr>`);
  //                         $("#lottery-draws-pages-wrapper").html("");
  //                         return;
  //                     }
  //                     let rowsMarkup = "";
  //                     console.log(response);
  //                     response.forEach((row)=>{
  //                            rowsMarkup += lotteryDrawMarkup(row);
  //                     });
  //                     console.log(rowsMarkup);
  //                    $("#lottery-draw-dtholder").html(rowsMarkup);

  //                  renderPagination(page,response[0].count_draw_numbers,'ldr','filter-lottery-draw','lottery-draws');
  //                 },
  //                 error:function (res,status,error) {
  //                   $(".dataholder").html("<tr><td colspan='12' style='text-align:center;'>An error occured, please try again later.</td></tr>");
  //                    console.log("An error occured: " + status + " - " + error);
  //                 },
  //                 complete:function () {
  //                      $("#lottery-draw-loader").css({'display': 'none'});
  //                 }

  //             }
  //             );
  //        }
  //     });

  //      $(document).on("click", ".page-btn" , function() {
  //         if($(this).parent().hasClass("active")){
  //             return;
  //          }
  //          $('.page-btn').parent().removeClass('active');
  //          $(this).parent().addClass('active');

  //         let lottery_id     = $(".usernameis").val();
  //         let start_date     = $(".startdate").val();
  //         let end_date       = $(".enddate").val();
  //         let page           = $(this).attr("id").split("-")[1];

  //         if (lottery_id === "all") {
  //             lottery_id = 1;
  //          }

  //             let flag = "filterLotteryDrawRecords";
  //             let  data  = {lottery_id:lottery_id,start_date:start_date,end_date:end_date,page:page};
  //             data       = new URLSearchParams(data).toString();
  //             $.ajax({
  //                 url: "../execute/gamesetting/LotteryDrawRecords",
  //                 type: "POST",
  //                 data: { data: data, flag: flag },
  //                 beforeSend: function(){
  //                   $(".dataholder").html("<tr><td colspan='12' style='text-align:center;'>Fetching data....</td></tr>");
  //                 },
  //                 success:function (response) {

  //                     response = JSON.parse(response);
  //                     if(response.length === 0) {
  //                         $(".dataholder").html("<tr><td colspan='12' style='text-align:center;'> No Draw Records Found. </td></tr>");
  //                         $("#pagination-ul").html("");
  //                         return;
  //                     }
  //                     let rowsMarkup = "";
  //                     console.log(response);
  //                     response.forEach((row)=>{
  //                            rowsMarkup += lotteryDrawMarkup(row);
  //                     });
  //                     console.log(rowsMarkup);
  //                    $(".dataholder").html(rowsMarkup);
  //                    page = parseInt(page);

  //                    if(page % 10 == 0){
  //                     let pagesMarkup = `<li class='page-item' ><a class='page-link page-btn' id='page-1'>1</a> </li>`;

  //                     let numPages = parseInt(response[0].count_draw_numbers);

  //                     const firstPage = page;

  //                     const remainingPages = ((numPages - page) > 10);
  //                     numPages = Math.ceil(numPages / 10);
  //                        	// pagesMarkup += `<li class='page-item  active' ><a class='page-link page-btn' id='page-${i}'>${i}</a> </li>`;
  //                        for(let i = page; i <= numPages; i++) {
  //                         console.log(i);
  //                         if(i == page){
  // 							pagesMarkup += `<li class='page-item  active' ><a class='page-link page-btn' id='page-${i}'>${i}</a> </li>`;
  // 						}else{
  //                             pagesMarkup += `<li class='page-item ' ><a class='page-link page-btn' id='page-${i}'>${i}</a></li>`;
  //                                 if(i == (page + 10)){
  //                                     break;
  //                                 }
  //                         }
  //                        }
  //                        if(remainingPages){
  //                         pagesMarkup += `<li class='page-item ' ><a class='page-link '>...</a> </li><li class='page-item' id='page${numPages}'><a class='page-link page-btn' id='page-${numPages}'>${numPages}</a></li>`;
  //                        }
  //                     $("#pagination-ul").html(pagesMarkup);
  //                    }

  //                    if(page == 1){
  //                     let pagesMarkup = '';
  //                      let numPages = parseInt(response[0].count_draw_numbers);

  //                     const remainingPages = ((numPages - page) > 10);

  //                        numPages = Math.ceil(numPages / 10);
  //                        	// pagesMarkup += `<li class='page-item  active' ><a class='page-link page-btn' id='page-${i}'>${i}</a> </li>`;
  //                        for(let i = page; i <= numPages; i++) {
  //                         console.log(i);
  //                         if(i == 1){
  // 							pagesMarkup += `<li class='page-item  active' ><a class='page-link page-btn' id='page-${i}'>${i}</a> </li>`;
  // 						}else{
  //                             pagesMarkup += `<li class='page-item ' ><a class='page-link page-btn' id='page-${i}'>${i}</a></li>`;
  //                                 if(i ==  10){
  //                                     break;
  //                                 }
  //                         }
  //                        }
  //                        if(remainingPages){
  //                         pagesMarkup += `<li class='page-item ' ><a class='page-link '>...</a> </li><li class='page-item' id='page${numPages}'><a class='page-link page-btn' id='page-${numPages}'>${numPages}</a></li>`;
  //                        }
  //                     $("#pagination-ul").html(pagesMarkup);
  //                    }
  //                 },
  //                 error:function (res,status,error) {
  //                   $(".dataholder").html("<tr><td colspan='12' style='text-align:center;'>An error occured, please try again later.</td></tr>");
  //                    console.log("An error occured: " + status + " - " + error);
  //                 },
  //                 complete:function () {
  //                     console.log("Operation Completed Successfully.");
  //                 }

  //             }
  //             );

  //     });

  // fetch the lottery draw records on page read

  // filter user name

  $(document).on("keyup", "#ld-lottery", function () {
    const query = $(this).val().trim();
    if (query.length < 1) {
      $(".lot-drw-res-wrapper").hide();
      return;
    }
  //  console.log("Keyup: ");
    // Only trigger if input is more than 2 characters
    if (query.length > 1) {
      clearTimeout(debounceTimeout); // Clear any existing timeout
      //  console.log("Debounce working...");
      debounceTimeout = setTimeout(fetchLotteryname, 300, query); // Call fetchUsers with the query after 500ms delay
    } else {
      $(".userDropdown").hide(); // Hide dropdown if input is less than 3 characters
    }
  });

  // Handle dropdown item selection
  $(document).on("click", ".name-items", function () {
    $("#ld-lottery").val($(this).attr("data-lot-name"));
    $("#ld-lottery").attr("data-lot-id", $(this).attr("data-lot-id"));
    $(".lot-drw-res-wrapper").hide();
  });
  // Handle dropdown item selection
  $(document).on("click", ".lb-refreshlist", function () {
    fetchLotteryBasicParams(1, 1);
    $("#ld-lottery").val("");
  });

  $(document).on("click", ".fetch-lotter-basic-records", function () {
    const lottery_id = $("#lottery").val();
    const page = 1;
    $.ajax({
      url: `../admin/fetch_lottery_basic_params/${lottery_id}/${page}`,
      type: "POST",
      beforeSend: function () {
        $("#lottery-draw-loader").css({ display: "flex" });
      },
      success: function (response) {
        response = JSON.parse(response);
      //  console.log(response);
        const data = response.data;
        const totalCount = response.totalCount;
      //  console.log(data);

        if (response.length === 0) {
          $("#lot-basic-dtholder").html(
            `<tr class="no-results"> <td colspan="9"><img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`
          );
          $("#lottery-draws-pages-wrapper").html("");
          return;
        }
        let rowsMarkup = "";
        //console.log(data);
        data.forEach((row) => {
          rowsMarkup += lotteryBasicParametersMarkup(row);
        });
      //  console.log(rowsMarkup);
        $("#lot-basic-dtholder").html(rowsMarkup);
      },
      error: function (res, status, error) {
        $(".dataholder").html(
          "<tr><td colspan='12' style='text-align:center;'>An error occured, please try again later.</td></tr>"
        );
        console.log("An error occured: " + status + " - " + error);
      },
      complete: function () {
        $("#lottery-draw-loader").css({ display: "none" });
      },
    });
  });

  fetchLotteryBasicParams(1, 1);
});

const fetchLotteryBasicParams = (lottery_id = 1, page) => {
  $.ajax({
    url: `../admin/fetch_lottery_basic_params/${lottery_id}/${page}`,
    type: "POST",
    beforeSend: function () {
      $("#lottery-draw-loader").css({ display: "flex" });
    },
    success: function (response) {
     // console.log("LOTTERY DRAW RECORDS: ", response);
      response = JSON.parse(response);
   //   console.log(response);
      const data = response.data;
      const totalCount = response.totalCount;

      renderPagination(totalCount, page, "lb-pagination");

      if (response.length === 0) {
        $("#lot-basic-dtholder").html(
          `<tr class="no-results"> <td colspan="9"><img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`
        );
        $("#lottery-draws-pages-wrapper").html("");
        return;
      }
      let rowsMarkup = "";
     // console.log(data);
      data.forEach((row) => {
        rowsMarkup += lotteryBasicParametersMarkup(row);
      });
     // console.log(rowsMarkup);
      $("#lot-basic-dtholder").html(rowsMarkup);
    },
    error: function (res, status, error) {
      $(".dataholder").html(
        "<tr><td colspan='12' style='text-align:center;'>An error occured, please try again later.</td></tr>"
      );
      console.log("An error occured: " + status + " - " + error);
    },
    complete: function () {
      $("#lottery-draw-loader").css({ display: "none" });
    },
  });
};

function sanitizeHTML(str) {
  if (typeof str !== "string") {
    return str; // Return as is if not a string
  }
  return str
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

function lotteryBasicParametersMarkup(data) {
  return `
<tr>
    <td>${data.id}</td>
    <td><img src="${sanitizeHTML(
      data.lottery_image
    )}" alt="lottery icon" width="40"></td>
    <td>${data.lottery_name}</td>
    <td>${data.lottery_type}</td>
    <td></td>
    <td></td>
    <td>${data.alias}</td>
    <td id="td-mx-prize-${data.id}">${data.max_prize_per_bet}</td>
    <td id="td-mx-win-${data.id}">${data.max_win}</td>
    <td id="td-mx-amt-${data.id}">${data.max_amt_per_issue}</td>
    <td id="td-mn-amt-${data.id}">${data.mn_amt_per_issue}</td>
    <td id="td-clsing-${data.id}">${data.clsing}</td>
    <td><span class="state">${data.state}</span></td>
    <td>
        <div class="btn-group mb-2 mt-2">
            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fe fe-mail"></i>
            </button>
            <ul class="dropdown-menu">
                <li class="action-btn">
                    <a class="dropdown-item edit-params-act-btn" 
                       data-bs-target="#edit-params-act-btn" 
                       data-bs-toggle="modal" 
                       max-prize-amt-per-bet="${data.max_prize_per_bet}" 
                       maximum_win_per_issue="${data.max_win}" 
                       maximum_amount_per_issue="${data.max_amt_per_issue}"  
                       minimum_amount_per_issue="${data.mn_amt_per_issue}"  
                       closing_time="${data.clsing}" 
                       game-id="${data.id}" 
                       id="edit-${data.id}">
                        edit
                    </a>
                </li>
                <li class="action-btn">
                    <a class="dropdown-item gameon" 
                       data-target="${data.id}" 
                       data-bs-target="#confirm-state-modal-gameon" 
                       data-bs-toggle="modal">
                        turn on
                    </a>
                </li>
                <li class="action-btn">
                    <a class="dropdown-item gameoff" 
                       data-target="${data.id}" 
                       data-bs-target="#confirm-state-modal-gameoff" 
                       data-bs-toggle="modal">
                        turn off
                    </a>
                </li>
            </ul>
        </div>
    </td>
</tr>`;
}

function lotteryDrawMarkup(data) {
  return `<tr>
            <td>${data.lottery_type}</td>
            <td>${data.lottery_code}</td>
            <td>${data.period}</td>
            <td>${data.draw_number}</td>
            <td>${data.total_bet_amount}</td>
            <td>${data.total_bet_won}</td>
            <td>${data.time_added}</td>
            <td>${data.closing_time}</td>
            <td>${data.opening_time}</td>
            <td>${data.closing_time}</td>
            <td>${data.state}</td>
            </tr>`;
}

function gather_update_fields() {
  max_prize_amt_per_bet = $(this).attr("max-prize-amt-per-bet");
  max_win_per_issue = $(this).attr("maximum_win_per_issue");
  maximum_amount_per_issue = $(this).attr("maximum_amount_per_issue");
  min_amount_per_issue = $(this).attr("minimum_amount_per_issue");
  closing = $(this).attr("closing_time");
}

function modalClose(modalID = "edit-params-act-btn") {
  $("#" + modalID).removeClass("show");
  $("#" + modalID).hide();
  $(".modal-backdrop.fade.show").remove();
}

let debounceTimeout = null;

// Function to fetch and display users
const fetchLotteryname = (lotteryName) => {
  let optionsHtml = "";

  $.post(
    `../admin/searchLotteryName/${encodeURIComponent(lotteryName)}`,
    function (response) {
      try {
       // console.log(response);
        response =
          typeof response === "string" ? JSON.parse(response) : response;
      //  console.log(response);

        for (let index = 0; index < response.length; index++) {
          const lot = response[index];
          optionsHtml += `<li class="name-items" data-lot-id="${lot.gt_id}" data-lot-name="${lot.name}">${lot.name}</li>`;
        }
      //  console.log(optionsHtml);
        $("#lot-drw-list-wrapper").html(optionsHtml);
        $(".lot-drw-res-wrapper").show();
      } catch (error) {
        console.error("Error parsing response: ", error);
        $(".userDropdown").hide();
      }
    }
  ).fail(function () {
    console.error("Error fetching users.");
    $(".userDropdown").hide();
  });
};

const renderPagination = (totalPages, currentPage, pagesWrapper = "") => {
  const createPageLink = (i, label = i, disabled = false, active = false) =>
    `<li class='page-item ${disabled ? "disabled" : ""} ${
      active ? "active" : ""
    }'>
        <a class='page-link' href='#' data-page='${i}'>${label}</a>
      </li>`;
  let pagLink = `<ul class='pagination justify-content-end'>`;

  totalPages = totalPages / 10;

  // Previous Button
  pagLink += createPageLink(
    currentPage - 1,
    `<i class='bx bx-chevron-left'></i>`,
    currentPage === 1
  );

  // Page numbers with ellipsis
  for (let i = 1; i <= totalPages; i++) {
    if (i === 1 || i === totalPages || Math.abs(i - currentPage) <= 2) {
      pagLink += createPageLink(i, i, false, i === currentPage);
    } else if (i === currentPage - 3 || i === currentPage + 3) {
      pagLink += createPageLink(i, "...", true);
    }
  }

  // Next Button
  pagLink += createPageLink(
    currentPage + 1,
    `<i class='bx bx-chevron-right'></i>`,
    currentPage === totalPages
  );
  pagLink += "</ul>";

  document.getElementById(`${pagesWrapper}-pages-wrapper`).innerHTML = pagLink;
  // document.getElementById("pagination").innerHTML = pagLink;
};
