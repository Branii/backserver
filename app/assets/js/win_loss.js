$(() =>{

    const BASE_URL = '../admin';
    let historyStack  = [];
    let pagesStack    = [];
   
    
    const fetchUsersWinLoss = (lottery_id = "all",startDate = "all", endDate ="all",page = 1, limit = 10, generatePages = true) => {

        lottery_id = lottery_id ?? "all";
        startDate  = startDate.length === 0  ? "all" : startDate;
        endDate    = endDate.length   === 0  ? "all" : endDate;
        page       = parseInt(page)
        $.ajax({
            url: BASE_URL + `/users_win_loss/${lottery_id}/${startDate}/${endDate}/${page}/${limit}`, // full url with page number ,limit and flag
            type: "POST",
            beforeSend: function(){
                $("#wl-tbl").LoadingOverlay("show", {
                    background: "rgb(90,106,133,0.1)",
                    size: 3,
                  });
//    $($(".wl-refreshlist").find("i")[0]).removeClass("bx bx-refresh").addClass("bx-loader bx-spin");
            },
            success: function(response){
                console.log(response);
                response  = JSON.parse(response);
                data      = response.data;
                console.log(response);
                if(data.status === "error") {
                    // $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13">${data.data}</td></tr>`); 
                }
                if(data.length == 0){
                    $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);  
                    return; 
                }
                let htmlMarkup = "";
                const num_users = Math.ceil(data[0].num_users / 10);
               if(generatePages) renderPagination("wl-pagination",num_users, page);
                data.forEach(data => {
                    htmlMarkup += getUserRowMarkup(data);
                });
                
                $("#winLossDtholder").html(htmlMarkup);
            },
            error: function(xhr,status,err){
                  console.error("response from server, received" + err);
            },
            complete: function(){
                $("#wl-tbl").LoadingOverlay("hide", {
                    background: "rgb(90,106,133,0.1)",
                    size: 3,
                  });
// $($(".wl-refreshlist").find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx bx-refresh");
            },
        });
    };

   const searchUserWinLoss = () => {

      const data = new URLSearchParams({username: username, lottery:lottery_id , start_date: start_date, end_date: end_date}).toString();
        console.log(data);
        $.ajax({
            url: "../controller/datareport/winlossreport",
            type: "POST",
            data: {data:data, flag:flag },
            beforeSend: function(){
                    $("#win-loss-loader").css('display', 'flex');
            },
            success: function(response){
                console.log(response);
                $("#subs-back-btn").hide();
                response  = JSON.parse(response);
                
                const num_res = response.length;
                if(response.length == 0){
                    historyStack = [];
                    $("#win-loss-dtholder").html("<tr><td colspan='12'  style='text-align:center;'>No results found.</td></tr>");  
                    return; 
                }
                if($("#user-details-btn").is(":visible")) $("#user-details-btn").hide();
                if(num_res === 1){
                    if(response[0].account_type > 1) $("#user-details-btn").show();
                }
                
                let htmlMarkup = "";
                response.forEach((data,index) => {
                    htmlMarkup += getUserRowMarkup(data);
                }); 
                $("#win-loss-dtholder").html(htmlMarkup);
                // historyStack = [htmlMarkup];
                pagesStack = [];
                
                },
            error: function(xhr,status,error){
                console.log("An error occured: " );
            },
            complete: function(){
                    $("#win-loss-loader").css('display', 'none');
            }
        });

        }; // search for user win loss



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
        console.log("Keyup: " );
        // Only trigger if input is more than 2 characters
        if (query.length > 1) {
            clearTimeout(debounceTimeout); // Clear any existing timeout
            console.log("Debounce working...");
            debounceTimeout = setTimeout(fetchbetUser, 300, query); // Call fetchUsers with the query after 500ms delay
        } else {
            $('.userDropdown').hide(); // Hide dropdown if input is less than 3 characters
        }

});
    // filter user name
    $(document).on('click', '.fetch-user-win-loss', function () {
        const userName  = $("#wl-username").attr("data-user-id");

        if(userName == undefined){
            console.log("Please No User selected.");
            return;
        }
        let lotteryID = $("#wl-lottery").attr("data-lot-id");
        let startDate = $("#wl-startdate").val();
        let endDate   = $("#wl-enddate").val();
        const element = this;
        if(lotteryID != undefined){
            if(lotteryID.length == 0) return;
        }

        lotteryID = lotteryID == undefined ?  "all" : lotteryID;
        startDate = startDate.length != 0 ? startDate : "all";
        endDate   = endDate.length != 0 ? endDate : "all";

        $.ajax({
            url: `../admin/searchWinLossUser/${userName}/${lotteryID}/${startDate}/${endDate}/`,
            type: "POST",
            beforeSend: function(){
               $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
            },
            success: function(response){
                console.log(response);
                $("#subs-back-btn").hide();
                response  = JSON.parse(response);
                if(response.status === "error"){
                    $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13">Error: ${response.data}</td></tr>`); 
                    return
                }
               
                if(response.data.length == 0){
                    $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);  
                    return; 
                }
                userObj      = response.data[0];
                if(userObj.account_type > 1){
                    if(!$(".get-user-details-btn").hasClass("btn-disabled")) $(".get-user-details-btn").addClass("btn-disabled"); 
                }
                htmlMarkup = getUserRowMarkup(userObj);
                $("#winLossDtholder").html(htmlMarkup);
                
                },
            error: function(xhr,status,error){
                console.log("An error occured: " );
            },
            complete: function(){
                $($(element).find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx-check-double");
                $("#wl-pagination").html("")
            }
        });


    });


    $(document).on('keyup', '#wl-lottery', function () {
        const query = $(this).val().trim();
        if(query.length < 1){
            $(".lot-res-wrapper").hide();
            return;
        }
        console.log("Keyup: " );
        // Only trigger if input is more than 2 characters
        if (query.length > 1) {
            clearTimeout(debounceTimeout); // Clear any existing timeout
            console.log("Debounce working...");
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
    $(document).on("click", ".top-agents-btn", function () {

        
        let lotteryID = $("#wl-lottery").attr("data-lot-id");
        let startDate = $("#startdate").val();
        let endDate   = $("#enddate").val();
        const page      = 1;

        
        
        lotteryID = lotteryID == undefined || lotteryID == "" ?  "all" : lotteryID;
        startDate = startDate.length != 0 ? startDate : "all";
        endDate   = endDate.length != 0 ? endDate : "all";

            $.ajax({
                url: `../admin/get_top_agents/${lotteryID}/${startDate}/${endDate}/${page}}`,
                type: "POST",
                beforeSend: function(){
                      $("#win-loss-loader").css('display', 'flex');
                },
                success: function(response){
                     $("#subs-back-btn").hide();
                response  = JSON.parse(response);
                console.log(response);
                const num_res = response.length;
                if(response.length == 0){
                    historyStack = [];
                    pagesStack = [];
                    $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);  
                    return; 
                }
                if(!$(".get-user-details-btn").hasClass("btn-disabled")) $(".get-user-details-btn").addClass("btn-disabled");
                if(num_res === 1){
                    if(response[0].account_type > 1) $(".get-user-details-btn").removeClass("btn-disabled");
                }
                
                let htmlMarkup = "";
                response.forEach((data,index) => {
                    htmlMarkup += getUserRowMarkup(data);
                }); 
                $("#winLossDtholder").html(htmlMarkup);
                // historyStack = [htmlMarkup];
                // pagesStack = [];
                },
                error: function(xhr,status,error){
                    console.log("An error occured: " );
                },
                complete: function(){
                     $("#win-loss-loader").css('display', 'none');
                }
        });
});


    // handle the back button action
    $(document).on("click",".get-user-details-btn",function(){

            const lotteryID = $("#wl-lottery").attr("data-lot-id");
            const startDate = $("#startdate").val();
            const endDate   = $("#enddate").val();
            const agentID   = $("#winLossDtholder").find('tr:first-child').attr("id").split("-")[2];

                $.ajax({
                    url: `../admin/get_user_details/${agentID}/${lotteryID}/${startDate}/${endDate}//}`,
                    type: "POST",
                    beforeSend: function(){
                        $("#win-loss-loader").css('display', 'flex');
                    },
                    success: function(response){
                    console.log(response);
                    response  = JSON.parse(response); // parse the response server
                    
                
                    if(response.length == 0){
                        // show the empty response placeholder
                        $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);  
                        return; 
                    }

                    // add the the tbody html with the new accumulated html markup
                    $("#winLossDtholder").html(getUserRowMarkup(response));
                    
                    },
                    error: function(xhr,status,error){
                        console.log("An error occured: " );
                    },
                    complete: function(){
                        $("#win-loss-loader").css('display', 'none');
                    }
            });
});


    // refresh list
    $(document).on("click", ".wl-refreshlist", function () { 
        $("#wl-username").attr("data-user-id",""); 
        $("#wl-username").val(""); 
        $("#wl-lottery").attr("data-lot-id",""); 
        $("#wl-lottery").val(""); 
        $("#wl-startdate").val(""); 
        $("#wl-enddate").val(""); 
        
        fetchUsersWinLoss();
     });


    // Get Subs
    $(document).on("click", ".get-subs-btn", function () {

            const lotteryID = $("#wl-lottery").attr("data-lot-id");
            const startDate = $("#startdate").val();
            const endDate   = $("#enddate").val();
            const agentID   = $(this).closest('tr').attr("id").split("-")[2];
            const page      = 1;

                $.ajax({
                    url: `../admin/get_subs/${agentID}/${lotteryID}/${startDate}/${endDate}/${page}}`,
                    type: "POST",
                    beforeSend: function(){
                        $("#win-loss-loader").css('display', 'flex');
                    },
                    success: function(response){
                    response  = JSON.parse(response); // parse the response server
                
                    
                    historyStack =  [$("#winLossDtholder").html()]; // store the dtholder html in the history stack
                    if($(".back-btn").hasClass("btn-disabled")) $(".back-btn").removeClass("btn-disabled"); // enable the back button to traverse through the history stack
                    

                    if(!$(".get-user-details-btn").hasClass("btn-disabled")) $(".get-user-details-btn").addClass("btn-disabled"); // disable the get user details button

                    if(response.length == 0){
                        // show the empty response placeholder
                        $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);  
                    
                    
                    
                        return; 
                    }

                    // accumulate the subs html 
                    let htmlMarkup = "";
                    response.forEach((data) => {
                        htmlMarkup += getUserRowMarkup(data);
                    }); 

                    // add the the tbody html with the new accumulated html markup
                    $("#winLossDtholder").html(htmlMarkup);
                    // pagesStack = [];
                    },
                    error: function(xhr,status,error){
                        console.log("An error occured: " );
                    },
                    complete: function(){
                        $("#win-loss-loader").css('display', 'none');
                    }
            });
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
            console.log(response);
            for (let index = 0; index < response.length; index++) {
                const user = response[index];
                const username = getDisplayName(user);
                optionsHtml += `<li class="name-items" data-user-id="${user.uid}" data-username="${username}">${username}</li>`;
            }
            console.log(optionsHtml);
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
            console.log(response);
           
            for (let index = 0; index < response.length; index++) {
                const lot = response[index];
                optionsHtml += `<li class="name-items" data-lot-id="${lot.gt_id}" data-lot-name="${lot.name}">${lot.name}</li>`;
            }
            console.log(optionsHtml);
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


// fetch the latest users win loss
fetchUsersWinLoss();




$(document).on('click', '.wl-pagination', function () {
    if($(this).parent().hasClass("active")) return;
    const page       = $(this).attr("data-page").trim();
    const lottery_id = $("#wl-lottery").attr("data-lot-id"); 
    const startDate  = $("#wl-startdate").val().trim(); 
    const endDate    = $("#wl-enddate").val().trim(); 
    fetchUsersWinLoss(lottery_id,startDate,endDate,page);
});

$(document).on('change', '#wl-numrowstans', function () {
    const page       = $($("#wl-pagination").find(".page-item.active page-link")[0]).attr("data-page").trim();
    const lottery_id = $("#wl-lottery").attr("data-lot-id"); 
    const startDate  = $("#wl-startdate").val().trim(); 
    const endDate    = $("#wl-enddate").val().trim(); 
    const pageLimit  = $(this).val();
    fetchUsersWinLoss(lottery_id,startDate,endDate,page,pageLimit , false);

});

});


const renderPagination = (elementID,totalPages, currentPage, ) => {
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
    return `<tr id='user-id-${userData.uid}' id='${userData.account_type > 1 ? 'agent' : ''}' data-acc-type='${userData.account_type > 1 ? 'agent' : ''}'>
        <td> ${userData.username} </td>
        <td> ${userData.num_bet_tickets} </td>
        <td> ${userData.user_rebate} </td>
        <td> ${userData.total_bet_amount} </td>
        <td> ${userData.total_rebate_amount} </td>
        <td> ${userData.total_valid_amount} </td>
        <td> ${userData.total_win_amount} </td>
        <td> ${userData.win_loss} </td>
            </tr>`

};