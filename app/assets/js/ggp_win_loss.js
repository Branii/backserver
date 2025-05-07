$(() =>{


    const BASE_URL = '../admin';
    let historyStack  = [];
    let pagesStack    = [];
    let pagingInfo    = [];
    const partnerID = $("#partner-holder").attr("data-partner-id");
   
    function showToast(title, message, type) {
        $.toast({
          position: "bottom-right",
          title: title,
          message: message,
          type: type,
          duration: 3000, // auto-dismiss after 3s
        });
      }
      const translatorScript = document.querySelector(".translations"); // Get the script tag
      const translator = JSON.parse(translatorScript.textContent);
    
//     const fetchUsersWinLoss = (lottery_id = "all",startDate = "all", endDate ="all",page = 1, limit = 10, generatePages = true) => {

//         lottery_id = lottery_id ?? "all";
//         startDate  = startDate.length === 0  ? "all" : startDate;
//         endDate    = endDate.length   === 0  ? "all" : endDate;
//         page       = parseInt(page)
//         $.ajax({
//             url: BASE_URL + `/users_win_loss/${lottery_id}/${startDate}/${endDate}/${page}/${limit}`, // full url with page number ,limit and flag
//             type: "POST",
//             beforeSend: function(){
//                 $("#wl-tbl").LoadingOverlay("show", {
//                     background: "rgb(90,106,133,0.1)",
//                     size: 3,
//                   });
// //    $($(".wl-refreshlist").find("i")[0]).removeClass("bx bx-refresh").addClass("bx-loader bx-spin");
//             },
//             success: function(response){
//                 console.log(response);
//                 response  = JSON.parse(response);
//                 data      = response.data;
//                 console.log(response);
//                 if(data.status === "error") {
//                     // $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13">${data.data}</td></tr>`); 
//                 }
//                 if(data.length == 0){
//                     $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);  
//                     return; 
//                 }
//                 let htmlMarkup = "";
//                 const num_users = Math.ceil(data[0].num_users / 10);
//                if(generatePages) renderPaginationGGP("wl-pagination",num_users, page);
//                 data.forEach(data => {
//                     htmlMarkup += getUserRowMarkup(data);
//                 });
                
//                 $("#winLossDtholder").html(htmlMarkup);
//             },
//             error: function(xhr,status,err){
//                   console.error("response from server, received" + err);
//             },
//             complete: function(){
//                 $("#wl-tbl").LoadingOverlay("hide", {
//                     background: "rgb(90,106,133,0.1)",
//                     size: 3,
//                   });
// // $($(".wl-refreshlist").find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx bx-refresh");
//             },
//         });
//     };

  
    const fetchLotteryNames = ()=> {
            try {
             $.ajax({
                url: `../admin/fetchLotteryname/${partnerID}`,
                type: "POST",
                success: function(data){
                     data = JSON.parse(data);
                     let html = `<option value="">${translator['Lottery Type']}</option>`;
                    data.forEach((lottery) => {
                        html += `<option value="${lottery.gt_id}">${lottery.name}</option>`;
                    });
                
                    $(".wl-selectlottery").html(html);
                },
                error: function(xhr,status,error){
                   
                },

            });
            
        } catch (error) {
              console.error("Error fetching data:", error);
            }
          }
    fetchLotteryNames();


    //
    $(document).on('click','.go-back',function(){
        if(historyStack.length === 0) {
            showToast("No Data","No data to show","info");
            return;
        }
        const content  = historyStack.pop();
        const pageData = pagesStack.pop();
        const pageInfo = pagingInfo.pop();

        $("#winLossDtholder").html(content);
        $("#wl-pagination-wrapper").html(pageData);
        $("#paging_infowl").html(pageInfo);

    });

    // Handle dropdown item selection
    $(document).on('change', '.userDropdown', function () {
        const selectedOption = $(this).find('option:selected');
        const selectedUserId = selectedOption.val();
        const selectedUsername = selectedOption.data('username');

        if (selectedUserId) {
            $('#myInput').val(selectedUsername);
            $('.userIdbet').val(selectedUserId);
            $('.userDropdown').hide();
        }
    });
        
let debounceTimeout = null;

    // filter user name
    $(document).on('keyup', '#wl-username', function () {
        const query = $(this).val().trim();
        if(query.length < 1){
            $(".usr-res-wrapper").hide();
            return;
        }
        // Only trigger if input is more than 2 characters
        if (query.length > 1) {
            clearTimeout(debounceTimeout); // Clear any existing timeout
            debounceTimeout = setTimeout(fetchbetUser, 300, query); // Call fetchUsers with the query after 500ms delay
        } else {
            $('.userDropdown').hide(); // Hide dropdown if input is less than 3 characters
        }

});
    // filter user name
    $(document).on('click', '.fetch-user-win-loss', function () {
        const userID  = $("#wl-username").attr("data-user-id");

    
        let lotteryID = $("#wl-selectlottery").val();
        let startDate = $("#wl-startdate").val();
        let endDate   = $("#wl-enddate").val();
        const element = this;

        if(userID.length === 0){
            showToast("No User selected","Select atleast one User.","info");
            return;
        }

        lotteryID = lotteryID == undefined ?  "all" : lotteryID;
        startDate = startDate.length != 0 ? startDate : "all";
        endDate   = endDate.length != 0 ? endDate : "all";



        $.ajax({
            url: `../admin/searchWinLossUser/${userID}/${lotteryID}/${startDate}/${endDate}/`,
            type: "POST",
            beforeSend: function(){
               $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
            },
            success: function(response){
                $("#subs-back-btn").hide();
                console.log(response);
               
                response  = JSON.parse(response);
                if(response.status === "error"){
                    $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13">Error: ${response.data}</td></tr>`); 
                    return
                }
               
                if(response.data.length == 0){
                    $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);  
                    return; 
                }
                userObj   = response.data;
                if(userObj.account_type > 1){
                    if(!$(".get-user-details-btn").hasClass("btn-disabled")) $(".get-user-details-btn").addClass("btn-disabled"); 
                }
                htmlMarkup = getUserRowMarkup(userObj);
                $("#winLossDtholder").html(htmlMarkup);
                
                },
            error: function(xhr,status,error){
                showToast("Error","An Error occured, please try again later.","info");
            },
            complete: function(){
                $($(element).find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx-check-double");
                $("#wl-pagination-wrapper").html("")
            }
        });


    });

     // filter user name
     $(document).on('click', '.fetch-user-details', function () {


         const numTableRows = $("#winLossDtholder").find('tr.wl-results');
        
         if(numTableRows.length === 0) {
            showToast("No User Selected.","Please select a user.",'info');
            return;
         }

         if(numTableRows.length > 1) {
            showToast("Too many users available.","Please select a single user.",'info');
            return;
         }
         
        const userID  =  $("#winLossDtholder").find('tr:first-child').attr("id").split("-")[2];

        let lotteryID = $("#wl-selectlottery").val();
        let startDate = $("#wl-startdate").val();
        let endDate   = $("#wl-enddate").val();

        const element = this;
       

        if(userID.length === 0){
            showToast("No User selected","Select atleast one User.","info");
            return;
        }

        lotteryID = lotteryID == undefined ?  "all" : lotteryID;
        startDate = startDate.length != 0 ? startDate : "all";
        endDate   = endDate.length != 0 ? endDate : "all";

        $.ajax({
            url: `../admin/getUserDetails/${userID}/${lotteryID}/${startDate}/${endDate}/`,
            type: "POST",
            beforeSend: function(){
               $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
            },
            success: function(response){
                $("#subs-back-btn").hide();
                response  = JSON.parse(response);
                if(response.status === "error"){
                    $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13">Error: ${response.data}</td></tr>`); 
                    return
                }
               
                if(response.data.length == 0){
                    $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);  
                    $("#paging_infowl").html('----------');
                    return; 
                }
                userObj   = response.data;
                if(userObj.account_type > 1){
                    if(!$(".get-user-details-btn").hasClass("btn-disabled")) $(".get-user-details-btn").addClass("btn-disabled"); 
                }
                htmlMarkup = getUserRowMarkup(userObj);
                historyStack.push($("#winLossDtholder").html());
                pagesStack.push($("#wl-pagination-wrapper").html());
                pagingInfo.push($("#paging_infowl").html());
                $("#winLossDtholder").html(htmlMarkup);
                
                },
            error: function(xhr,status,error){
                showToast("Error","Request Error, please try again.","Error");
            },
            complete: function(){
                $($(element).find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx-check-double");
                $("#wl-pagination-wrapper").html("")
            }
        });


    });



    $(document).on('keyup', '#wl-lottery', function () {
        const query = $(this).val().trim();
        if(query.length < 1){
            $(".lot-res-wrapper").hide();
            return;
        }
    
        // Only trigger if input is more than 2 characters
        if (query.length > 1) {
            clearTimeout(debounceTimeout); // Clear any existing timeout
            debounceTimeout = setTimeout(fetchLotteryname, 300, query); // Call fetchUsers with the query after 500ms delay
        } else {
            $('.userDropdown').hide(); // Hide dropdown if input is less than 3 characters
        }

});

    // Handle dropdown item selection
    $(document).on('click', '.name-items', function () {
        if($(this).attr("data-username") != undefined){
            $("#wl-username").val($(this).attr('data-username'));
            $("#wl-username").attr('data-user-id',$(this).attr('data-user-id'));
            $(".usr-res-wrapper").hide();
        }else if($(this).attr("data-lot-name") != undefined){
            $("#wl-lottery").val($(this).attr('data-lot-name'));
            $("#wl-lottery").attr('data-lot-id',$(this).attr('data-lot-id'));
            $(".lot-res-wrapper").hide();
        }
});


    // Get Top Agents
    $(document).on("click", ".fetch-top-agents", function () { fetchTopAgents(1); });

    // Get Top Agents
    $(document).on("click", ".fetch-agent-subs", function () { fetchAgentSubs(this,1); });



    // refresh list
    $(document).on("click", ".wl-refreshlist", function () { 
        $("#wl-username").attr("data-user-id",""); 
        $("#wl-username").val(""); 
        $("#wl-lottery").attr("data-lot-id",""); 
        $("#wl-lottery").val(""); 
        $("#wl-startdate").val(""); 
        $("#wl-enddate").val(""); 
        $("#winLossDtholder").html(`<tr class="no-resultslist"> <td colspan="13" id="wl-empty-td"><img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Empty Results" /></td></tr>`)
        $("#wl-pagination-wrapper").html("");
        $("#paging_infowl").html("---------");
        historyStack, pagesStack, pagingInfo = [];
        // fetchUsersWinLoss();
     });



    // handle the back button action
    $(document).on("click",".back-btn",function(){
            const lastHistory = historyStack.pop(); // get the previous history html markup
            const latestPage  = pagesStack.pop();  // get the previous pages html markup
            
            $("#winLossDtholder").html(lastHistory); // re-add the previous history html to the win loss dtHolder
            $("#win-loss-pages-wrapper").html(latestPage); // re-add the previous pages html to the pages wrapper
            
            if(historyStack.length === 0){
                $(".back-btn").addClass("btn-disabled"); // if the history stack is empty, disable the back button
                if($($("#winLossDtholder").find("tr:first-child")[0]).attr('data-acc-type') == "agent" && $("#winLossDtholder").children().length === 1){
                    if($(".get-user-details-btn").hasClass("btn-disabled")) $(".get-user-details-btn").removeClass("btn-disabled"); // remove disabled btn class from the get-user-details-btn 
                }
            }



        });


// Function to fetch and display users
const  fetchbetUser = (query) =>{
    let optionsHtml = '';

    $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
        try {
             const getDisplayName = (user) => {
                 if(user.username !== "" && user.username != undefined && user.username !== "*****") return user.username;
                 if(user.email !== undefined && user.email != "") return user.email;
                 if(user.contact != undefined && user.contact != "") return user.contact;
            };
            response = typeof response === 'string' ? JSON.parse(response) : response;

            for (let index = 0; index < response.length; index++) {
                const user = response[index];
                const username = user[user.regtype];
                
                optionsHtml += username === undefined ?  `<li class="name-items"> No Data Found.</li>`  : `<li class="name-items" data-user-id="${user.uid}" data-username="${username}">${username}</li>`;
            }
            $('#user-list-wrapper').html(optionsHtml);
            $(".usr-res-wrapper").show();
         } catch (error) {
            console.error("Error parsing response: ", error);
            $('.userDropdown').hide();
        }
    }).fail(function () {
        console.error("Error fetching users.");
        $('.userDropdown').hide();
    });
}


// Function to fetch and display users
const fetchLotteryname = (lotteryName) => {
    let optionsHtml = '';

    $.post(`../admin/searchLotteryName/${encodeURIComponent(lotteryName)}`, function (response) {
        try {
             const getDisplayName = (user) => {
                 if(user.username !== "" && user.username != undefined && user.username !== "*****") return user.username;
                 if(user.email !== undefined && user.email != "") return user.email;
                 if(user.contact != undefined && user.contact != "") return user.contact;
            };
            response = typeof response === 'string' ? JSON.parse(response) : response;
           
            for (let index = 0; index < response.length; index++) {
                const lot = response[index];
                optionsHtml += `<li class="name-items" data-lot-id="${lot.gt_id}" data-lot-name="${lot.name}">${lot.name}</li>`;
            }
            $('#lot-list-wrapper').html(optionsHtml);
            $(".lot-res-wrapper").show();
         } catch (error) {
            console.error("Error parsing response: ", error);
            $('.userDropdown').hide();
        }
    }).fail(function () {
        console.error("Error fetching users.");
        $('.userDropdown').hide();
    });
}


$(document).on('click', '.wl-pagination', function () {
    if($(this).parent().hasClass("active")) return;
    const page       = $(this).attr("data-page").trim();
    const lottery_id = $("#wl-lottery").attr("data-lot-id"); 
    const startDate  = $("#wl-startdate").val().trim(); 
    const endDate    = $("#wl-enddate").val().trim(); 
    // fetchUsersWinLoss(lottery_id,startDate,endDate,page);
});

$(document).on('change', '#wl-numrowstans', function () {
    const page       = $($("#wl-pagination").find(".page-item.active page-link")[0]).attr("data-page").trim();
    const lottery_id = $("#wl-lottery").attr("data-lot-id"); 
    const startDate  = $("#wl-startdate").val().trim(); 
    const endDate    = $("#wl-enddate").val().trim(); 
    const pageLimit  = $(this).val();
    // fetchUsersWinLoss(lottery_id,startDate,endDate,page,pageLimit , false);

});



$(".playerWinLoss").click(function(e){
   
    let direction = $(this).val();
    const tableWrapper = $(".table-wrapperWl");
    const tableWrappers = $(".table-wrapperWl")[0];
    const scrollAmount = 1000; // Adjust as needed
    const scrollOptions = { behavior: "smooth" };
    if (tableWrapper.length) {
        switch (direction) {
            case "wl-leftlist":
                tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
                break;
            case "wl-rightlist":
                tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
                break;
            default:
                break;
        }
    }
    e.stopPropagation(); // Prevent event bubbling
  });
 
  const fetchTopAgents = (currentPage) => {
    let lotteryID = $("#wl-selectlottery").val();
    let startDate = $("#wl-startdate").val();
    let endDate   = $("#wl-enddate").val();
    const element = this;
    const limit = 10;
    if(lotteryID != undefined){
        if(lotteryID.length == 0) return;
    }


    lotteryID = lotteryID == undefined ?  "all" : lotteryID;
    startDate = startDate.length != 0 ? startDate : "all";
    endDate   = endDate.length != 0 ? endDate : "all";

    $.ajax({
        url: `../admin/fetchTopAgents/${lotteryID}/${startDate}/${endDate}/${currentPage}/${limit}`,
        type: "POST",
        beforeSend: function(){
           $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
        },
        success: function(response){
            $("#subs-back-btn").hide();
            response  = JSON.parse(response);
            if(response.status === "error"){
                $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13">Error: ${response.data}</td></tr>`); 
                return
            }
           
            if(response.data.length == 0){
                historyStack.push($("#winLossDtholder").html());
                pagesStack.push($("#wl-pagination-wrapper").html());
                pagingInfo.push($("#paging_infowl").html());
                $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);  
                $("#wl-pagination-wrapper").html("");
                $("#paging_infowl").html("---------");
                return; 
            }
            userObjs   = response.data;
            const totalPages = Math.ceil(userObjs[0].total_records / 10 );
            
            htmlMarkup = "";
            userObjs.forEach((userObj) => {
                htmlMarkup += getUserRowMarkup(userObj);
            });
            $("#winLossDtholder").html(htmlMarkup);
            if(totalPages < 2){
                console.log("Entered here..");
                $("#wl-pagination-wrapper").html("");
                $("#paging_infowl").html("---------");
                return;
            }
            renderwithdrawPagination(totalPages,parseInt(currentPage),"page-top-agents");
            
            },
        error: function(xhr,status,error){
            showToast("Error","An Error occured, please try again later.","info");
        },
        complete: function(){
            $($(element).find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx-check-double");
            $("#wl-pagination").html("")
        }
    });

    
  }

  const fetchAgentSubs = (eventElement,currentPage) => {

    console.log(eventElement);
    const agentID = $(eventElement).attr('data-agent-id');
    let lotteryID = $("#wl-selectlottery").val();
    let startDate = $("#wl-startdate").val();
    let endDate   = $("#wl-enddate").val();
    const element = this;
    const limit = 10;
    if(lotteryID != undefined){
        if(lotteryID.length == 0) return;
    }


    lotteryID = lotteryID == undefined ?  "all" : lotteryID;
    startDate = startDate.length != 0 ? startDate : "all";
    endDate   = endDate.length != 0 ? endDate : "all";
    flag      = "get-active-subs"
    console.log(agentID);
    $.ajax({
        url: `../admin/fetchAgentSubs/${agentID}/${lotteryID}/${startDate}/${endDate}/${flag}/${currentPage}/${limit}`,
        type: "POST",
        beforeSend: function(){
           $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
            //  $("#wl-tbl-wrapper").LoadingOverlay("show");
        },
        success: function(response){
            $("#subs-back-btn").hide();
            response  = JSON.parse(response);
            if(response.status === "error"){
                $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13">Error: ${response.data}</td></tr>`); 
                return
            }
           
            if(response.data.length == 0){
                historyStack.push($("#winLossDtholder").html());
                pagesStack.push($("#wl-pagination-wrapper").html());
                pagingInfo.push($("#paging_infowl").html());
                $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);  
                $("#wl-pagination-wrapper").html("");
                $("#paging_infowl").html("---------");
                return; 
            }
            userObjs   = response.data;
            // if(userObj.account_type > 1){
            //     if(!$(".get-user-details-btn").hasClass("btn-disabled")) $(".get-user-details-btn").addClass("btn-disabled"); 
            // }
            htmlMarkup = "";
            userObjs.forEach((userObj) => {
                htmlMarkup += getUserRowMarkup(userObj);
            });
            historyStack.push($("#winLossDtholder").html());
            pagesStack.push($("#wl-pagination-wrapper").html());
            pagingInfo.push($("#paging_infowl").html());
            $("#winLossDtholder").html(htmlMarkup);
            const totalPages = Math.ceil(parseInt(userObjs[0].totalRecords) / 10)
            if(totalPages < 11){
                $("#wl-pagination-wrapper").html("");
                $("#paging_infowl").html("---------");
                return;
            }
            renderwithdrawPagination(totalPages,parseInt(currentPage),'page-agent-subs');
            
            },
        error: function(xhr,status,error){
            showToast("Error","An Error occured, please try again later.","info");
        },
        complete: function(){
            $("#wl-tbl-wrapper").LoadingOverlay("hide");
            // $($(element).find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx-check-double");
            // $("#wl-pagination").html("")
        }
    });


  }

  $(document).on("click",".page-top-agents,.page-agent-subs",function(){
    const page = parseInt($(this).attr("data-page"));
    if(page < 1) return;
    if($(this).hasClass("page-top-agents")){
        fetchTopAgents(page);
    }else if($(this).hasClass("page-agent-subs")){
        fetchAgentSubs(this,page)
    }
  });
     

  const  renderwithdrawPagination = (totalPages, currentPagewithdraw,type = "page-top-agents") => {
    let pagLink = `<ul class='pagination justify-content-end'>`;
  
    // Previous Button
    pagLink += `
      <li class='page-item ${currentPagewithdraw === 1 ? "disabled" : ""}'>
        <a class='page-link ${type}' href='#' data-page='${currentPagewithdraw - 1}'><i class='bx bx-chevron-left'></i></a>
      </li>
    `;
  
    // Page numbers with ellipsis
    for (let i = 1; i <= totalPages; i++) {
      if (i === currentPagewithdraw) {
        pagLink += `<li class='page-item active'><a class='page-link ${type}' href='#'>${i}</a></li>`;
      } else if (i === 1 || i === totalPages || Math.abs(i - currentPagewithdraw) <= 2) {
        pagLink += `<li class='page-item'><a class='page-link ${type}' href='#' data-page='${i}'>${i}</a></li>`;
      } else if (i === currentPagewithdraw - 3 || i === currentPagewithdraw + 3) {
        pagLink += `<li class='page-item disabled'><a class='page-link'>...</a></li>`;
      }
    }
  
    // Next Button
    pagLink += `
      <li class='page-item ${currentPagewithdraw === totalPages ? "disabled" : ""}'>
        <a class='page-link ${type}' href='#' data-page='${currentPagewithdraw + 1}'><i class='bx bx-chevron-right'></i></a>
      </li>
    `;
  
    pagLink += "</ul>";
    document.getElementById("wl-pagination-wrapper").innerHTML = pagLink;
    $("#paging_infowl").text(`Page ${currentPagewithdraw} of ${totalPages} ${totalPages === 1 ? ' Page ' : ' Pages '} `)

  }

});


const renderPaginationGGP = (elementID,totalPages, currentPage, ) => {
    const createPageLink = (i, label = i, disabled = false, active = false) =>
        `<li class='page-item ${disabled ? "disabled" : ""} ${active ? "active" : ""}'>
        <a class='page-link wl-pagination' href='#' data-page='${i}'>${label}</a>
    </li>`;
    let pagLink = `<ul class='pagination justify-content-end'>`;

    // Previous Button
    pagLink += createPageLink(currentPage - 1, `<i class='bx bx-chevron-left'></i>`, currentPage === 1);

    // Page numbers with ellipsis
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || Math.abs(i - currentPage) <= 2) {
            pagLink += createPageLink(i, i, false, i === currentPage);
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            pagLink += createPageLink(i, "...", true);
        }
    }

    // Next Button
    pagLink += createPageLink(currentPage + 1, `<i class='bx bx-chevron-right'></i>`, currentPage === totalPages);
    pagLink += "</ul>";

    document.getElementById(elementID).innerHTML = pagLink;

    // Add click event listeners
    document.querySelectorAll(`#${elementID} .page-link`).forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const newPage = +this.getAttribute("data-page");
            if (newPage > 0 && newPage <= totalPages) {
                $("#mask").LoadingOverlay("show", {
                    background: "rgb(90,106,133,0.1)",
                    size: 3,
                  });
                // callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
            }
        });
    });
}


const getUserRowMarkup = (userData) => {

    const subsBtn = parseInt(userData.account_type) === 2 || parseInt(userData.account_type) === 3 ? `<div class="btn-group mb-2 fetch-agent-subs" role="group" aria-label="Basic example" data-agent-id="${userData.user_id}" style="border:solid 1px #eee;color:#bbb;background-color:#fff;margin: 0px !important;">
             <button type="button" class="btn bg-white-subtle playerWinLoss" value="wl-rightlist"> Subs </button></div>` : "";

    return `<tr id='user-id-${userData.user_id}' id='${userData.account_type > 1 ? 'agent' : ''}' class='wl-results' data-acc-type='${userData.account_type > 1 ? 'agent' : ''}'>
        <td> ${userData.username} </td>
        <td> ${userData.num_bettors} </td>
        <td> ${userData.num_bet_tickets} </td>
        <td> ${userData.rebate} </td>
        <td> ${userData.total_bet_amount} </td>
        <td> ${userData.total_rebate_amount} </td>
        <td> ${userData.total_valid_amount} </td>
        <td> ${userData.total_win_amount} </td>
        <td> ${userData.win_loss} </td>
        <td> ${subsBtn} </td>
            </tr>`

};


