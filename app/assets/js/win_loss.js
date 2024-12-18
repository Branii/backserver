$(() =>{

    const BASE_URL = '../admin';
    let historyStack  = [];
    let pagesStack    = [];
   
    
    const win_loss = () => {
        const flag = "win-loss";
        const page = 1;
        const limit = 10;
        $.ajax({
            url: BASE_URL + `/win_loss/${page}/${limit}/${flag}`, // full url with page number ,limit and flag
            type: "POST",
            beforeSend: function(){
                console.log("sending the request for the win loss");
            },
            success: function(response){
                console.log(response);
                data  = JSON.parse(response);
                console.log(response);
                $("#winLossDtholder").html(response.data);
            },
            error: function(xhr,status,err){
                  console.error("response from server, received" + err);
            },
            complete: function(){
                console.log("response from server, received");
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
        let startDate = $("#startdate").val();
        let endDate   = $("#enddate").val();
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
                    $("#win-loss-loader").css('display', 'flex');
            },
            success: function(response){
                $("#subs-back-btn").hide();
                response  = JSON.parse(response);
                console.log(response);
                const num_res = response.length;
                
                if(response.length == 0){
                    historyStack = [];
                    $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);  
                    return; 
                }
                if(response[0].account_type > 1){
                    if(!$(".get-user-details-btn").hasClass("btn-disabled")) $(".get-user-details-btn").addClass("btn-disabled"); 
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
        $("#startdate").val();
        $("#enddate").val();
        $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);  

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


});



const getUserRowMarkup = (userData) => {
    return `<tr id='user-id-${userData.uid}' id='${userData.account_type > 1 ? 'agent' : ''}' data-acc-type='${userData.account_type > 1 ? 'agent' : ''}'>
        <td> ${userData.username} </td>
        <td> ${userData.rel} </td>
        <td> ${userData.num_bettors} </td>
        <td> ${userData.num_bet_tickets} </td>
        <td> ${userData.user_rebate} </td>
        <td> ${userData.total_bet_amount} </td>
        <td> ${userData.total_rebate_amount} </td>
        <td> ${userData.total_valid_amount} </td>
        <td> ${userData.total_win_amount} </td>
        <td> ${userData.win_loss} </td>
        <td class="get-subs-btn"> ${userData.view_btn} </td>
            </tr>`

};