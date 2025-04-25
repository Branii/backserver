$(() =>{

    const partnerID = $('#partner-holder').attr("data-partner-id");
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
   
      const page = 1;
      const limit = 20;


        $(document).on("click",".showEditModal",function(){
            $("#editPaymentPlatform").css("display","block");
            $("#editPaymentPlatform").addClass("show");
            const row = $(this).closest("tr");
            const data = $(row).find("td");
            const cid = $(row).attr("id").split("-")[1];
            $("#pp-payment-type-edit").val(cid);
            $("#pp-currency-edit").val(data[1].innerHTML.trim());
            $("#pp-status-edit").val(data[11].innerHTML.toLocaleLowerCase().trim());
            $("#pp-fee-edit").val(data[4].innerHTML);
            $("#pp-min-amount-edit").val(data[5].innerHTML);
            $("#pp-max-amount-edit").val(data[6].innerHTML);
            $("#pp-site-url-edit").val(data[2].innerHTML);
            $("#pp-admin-site-url-edit").val(data[3].innerHTML);
            $("#pp-info-edit").val($(`#pp-info-${cid}`).text());
            $("#pp-priority-edit").val($(`#pp-priority-${cid}`).text());

           let tableHtml = "";
            countries.forEach(country => {
                tableHtml += `<tr>
                <td><input class="form-check-input " type="checkbox" value="${country}" id="flexCheckDefault" ${$(`#pp-countries-${cid}`).text().includes(country) ? "checked" : ""}></td>
                <td><span class="pp-lottery-name">${country}</span></td>
                </tr>
                `
            });
            $("#edit-countries-tbody").html(tableHtml);


    });

   

    $(document).on("click","#editPaymentPlatformBtn",function(){
            const paymentType = $("#pp-payment-type-edit").val();
        const paymentTypeName = $("#pp-payment-type-edit option:selected").attr("data-name");
        const currency    = $("#pp-currency-edit").val();
        const status      = $("#pp-status-edit").val();
        const fee         = $("#pp-fee-edit").val();
        const maxAmount   = $("#pp-max-amount-edit").val();
        const minAmount   = $("#pp-min-amount-edit").val();
        const siteUrl        = $("#pp-site-url-edit").val();
        const adminSiteUrl   = $("#pp-admin-site-url-edit").val();
        const info            = $("#pp-info-edit").val();
        const priority        = $("#pp-priority-edit").val();
        const countries       = [];
        $("#edit-countries-tbody").find("tr td input:checked").closest("tr").find(".pp-lottery-name").each(function() { countries.push($(this).text()); });
        const encodedSiteUrl = encodeURIComponent(siteUrl).replace(/%2F/g, '%252F');
        const encodedAdminSiteUrl = encodeURIComponent(adminSiteUrl).replace(/%2F/g, '%252F');
        const encodedCountries = encodeURIComponent(countries);


         
        $.post(`../admin/editPaymentPlaftorm/${paymentType}/${paymentTypeName}/${currency}/${status}/${fee}/${maxAmount}/${minAmount}/${siteUrl}/${adminSiteUrl}/${info}/${priority}/${encodedCountries}`, function (response) {
            try {
                
                response = typeof response === 'string' ? JSON.parse(response) : response;
            
                if(response.status == "error"){
                    showToast("Error",response.data,'error');
                    return;
                }

                if(response.data < 0){
                    showToast("Error","Error adding payment platform.Maybe a duplicate.","error")
                    return;
                }

                showToast("Success","Payment Platform successfully updated.","success");
                fetchpaymentplatformsForPartner();
                $(".tclose").click();
                $("#pp-payment-type-edit").val("");
                $("#pp-currency-edit").val("");
                $("#pp-status-edit").val("active");
                $("#pp-fee-edit").val("");
                $("#pp-max-amount-edit").val("");
                $("#pp-min-amount-edit").val("");
                $("#pp-site-url-edit").val("");
                $("#pp-admin-site-url-edit").val("");

             } catch (error) {
                console.error("Error parsing response: ", error);
                $('.userDropdown').hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $('.userDropdown').hide();
        });
        });

        $(document).on("click","#addPaymentPlatformBtn",function(){
            $("#addNewPaymentPlatform").addClass("show");
            $("#addNewPaymentPlatform").css("display","block");

        });

        $(document).on("click",".tclose",function(){
            $("#editPaymentPlatform").removeClass("show");
            $("#editPaymentPlatform").css("display","none");
            $("#addNewPaymentPlatform").removeClass("show");
            $("#addNewPaymentPlatform").css("display","none");



            // clear all the fields for adding the payment platform
            $("#pp-payment-type").val("");
            $("#pp-currency").val("");
            $("#pp-status").val("active");
            $("#pp-fee").val("");
            $("#pp-max-amount").val("");
            $("#pp-min-amount").val("");
            $("#pp-site-url").val("");
            $("#pp-admin-site-url").val("");
            $(".country-input").prop("checked",false);
            $("#pp-info").val("");
            $("#pp-priority").val("");
        });
        $(document).on("click",".search-payment-platform",function(){
            searchPaymentPlatforms();
        });

        const searchPaymentPlatforms = (page = 1,limit = 20) => {
            const platformName  = $('#selectedID').val();
            const currency      = $("#platformCurrency").val();
            const status        = $("#platformStatus").val()
            const startDate     = $("#platformStartDate").val();
            const endDate       = $("#platformEndDate").val();

            console.log(platformName,currency,status,startDate,endDate,page,limit);

            if(platformName == undefined && currency == status && startDate == undefined && endDate == undefined){
                showToast("Error", "Please select at least one filter","error");
                return;
            }
            if(platformName.length == 0 && currency.length == 0 && startDate.length == 0 && endDate.length == 0) {
                showToast("Error", "Please select at least one filter","error");
                return;
            }
          
            $.post(`../admin/searchPaymentPlatform/${platformName}/${currency}/${status}/${startDate}/${endDate}/${page}/${limit}`, function(response){
                response = typeof response === 'string' ? JSON.parse(response) : response;
                
                if(response.status === "error"){
                    showToast("Error", "Error loading data for Payment Platforms","error");
                    return;
                  }

                  if(response.data.length === 0){
                    $("#pp-dtholder").html(`<tr class="no-resultslist">
                    <td colspan="9">
                    
                        <img src="http://localhost/admin/app/assets/images/not_found1.jpg" class="dark-logo"
                            alt="Logo-Dark"  width="150px" height="150px" />
                    </td>
                </tr>`);
                return;
                  }

                  let html = "";
                  response.data.forEach((data) =>{
                    html += paymentsMarkup(data);
                  });
                $("#pp-dtholder").html(html);
            });
        };

    const fetchpaymentplatformsForPartner = ()=> {
        try {
             $.ajax({
                url: `../admin/fetchpaymentplatformsForPartner/${page}/${limit}/`,
                type: "POST",
                
                success: function(response){
                    
                     response = JSON.parse(response);
                     console.log(response);
                     if(response.status === "error"){
                        showToast("Error", "Error loading data for Payment Platforms","error");
                        return;
                      }

                      if(response.data.length === 0){
                        $("#pp-dtholder").html(`<tr class="no-resultslist">
                        <td colspan="9">
                            <img src="http://localhost/admin/app/assets/images/not_found1.jpg" class="dark-logo"
                                alt="Logo-Dark" width="150px;" height="150px;"/>
                        </td>
                    </tr>`);
                    return;
                      }

                      let html = "";
                      response.data.forEach((data) =>{
                        html += paymentsMarkup(data);
                      });

                
                    $("#pp-dtholder").html(html);
                },
                error: function(xhr,status,error){
                   
                },

            });
            
        } catch (error) {
              console.error("Error fetching data:", error);
            }
          }
          fetchpaymentplatformsForPartner();


          $(document).on('click',".pp-refresh",function(){
            $("#platformNames").val("");
            $("#platformCurrency").val("");
            $("#platformStatus").val("");
            $("#platformStartDate").val("");
            $("#platformEndDate").val("");
            fetchpaymentplatformsForPartner();
          });

          const fetchpaymentplatforms = ()=> {
            try {
                 $.ajax({
                    url: `../admin/fetchpaymentplatforms/${page}/${limit}/`,
                    type: "POST",
                    success: function(response){
                       
                         response = JSON.parse(response);
                         console.log(response);
                         if(response.status === "error"){
                            showToast("Error", "Error loading data for Payment Platforms","error");
                            return;
                          }
    
                          if(response.data.length === 0){
                           return;
                          }
                           response = response.data;
                          optionsHtml = `<option value="">--Payment Type--</option>`;
                          
                          for (let index = 0; index < response.length; index++) {
                            const data = response[index];
                            optionsHtml += `<option value="${data.cid}" data-name="${data.name}">${data.name}</option>`;
                        }
                        console.log(optionsHtml);
                        $('.pp-payment-types').html(optionsHtml);
                    },
                    error: function(xhr,status,error){
                       
                    },
    
                });
                
            } catch (error) {
                  console.error("Error fetching data:", error);
                }
              }
    fetchpaymentplatforms();
    

    $(document).on("keyup","#platformNames",function(){
        searchPlatformNames($("#platformNames").val());
    });





    $(document).on('click',"#addNewPaymentPlatformBtn",function(){

        const paymentType = $("#pp-payment-type").val();
        const paymentTypeName = $("#pp-payment-type option:selected").attr("data-name");
        const currency    = $("#pp-currency").val();
        const status      = $("#pp-status").val();
        const fee         = $("#pp-fee").val();
        const maxAmount   = $("#pp-max-amount").val();
        const minAmount   = $("#pp-min-amount").val();
        const siteUrl        = $("#pp-site-url").val();
        const adminSiteUrl   = $("#pp-admin-site-url").val();
        const info            = $("#pp-info").val();
        const priority        = $("#pp-priority").val();
        const countries       = [];


        // if(paymentType == undefined || paymentTypeName == undefined || currency == undefined || status == undefined ){

        //     showToast("Error", "Please fill all the required fields.", "error");
        //     return
        // }
        
        // if(paymentType.length == 0 || paymentTypeName.length == 0 || currency.length == 0  || status.length == 0 ){

        //     showToast("Error", "Please fill all the required fields.", "error");
        //     return
        // }


        $("#pp-countries-list").find("tr td input:checked").closest("tr").find(".pp-lottery-name").each(function() { countries.push($(this).text()); });
        const encodedSiteUrl = encodeURIComponent(siteUrl).replace(/%2F/g, '%252F');
        const encodedAdminSiteUrl = encodeURIComponent(adminSiteUrl).replace(/%2F/g, '%252F');
        const encodedCountries = encodeURIComponent(countries);
        $.post(`../admin/addNewPaymentPlaftorm/${paymentType}/${paymentTypeName}/${currency}/${status}/${fee}/${maxAmount}/${minAmount}/${encodedSiteUrl}/${encodedAdminSiteUrl}/${info}/${priority}/${encodedCountries}`, function (response) {
            try {

                
                response = typeof response === 'string' ? JSON.parse(response) : response;
                console.log(response);
                if(response.status == "error"){
                    showToast("Error",response.data,'error');
                    return;
                }

                if(response.data < 0){
                    showToast("Error","Error adding payment platform.Maybe a duplicate.","error")
                    return;
                }

                showToast("Success","New payment platform successfully added.","success");
                $(".tclose").click();
                $("#pp-payment-type").val("");
                $("#pp-currency").val("");
                $("#pp-status").val("active");
                $("#pp-fee").val("");
                $("#pp-max-amount").val("");
                $("#pp-min-amount").val("");
                $("#pp-site-url").val("");
                $("#pp-admin-site-url").val("");
                $(".country-input").val("");
                $("#pp-info").val("");
                $("#pp-priority").val("");


                 const html = `<tr id='cid-${paymentType}'>
                        <td> ${paymentTypeName} </td>
                        <td> ${currency} </td>
                        <td> ${siteUrl} </td>
                        <td> ${adminSiteUrl} </td>
                        <td> ${fee} </td>
                        <td> ${minAmount} </td>
                        <td> ${maxAmount} </td>
                        <td> ${getFormattedDateTime()} </td>
                        <td> ${$("#admin-name").text()} </td>
                        <td> ${getFormattedDateTime()} </td>
                        <td> ${$("#admin-name").text()} </td>
                        <td> ${status} </td>
                        <td class="showEditModal" style="cursor:pointer;" ><i class='bx bx-edit-alt'></i> </td>
                        <td id="pp-info-${paymentType}" style="display:none;">${info}</td>
                        <td id="pp-priority-${paymentType}" style="display:none;">${priority}</td>
                        <td id="pp-countries-${paymentType}" style="display:none;">${countries.join(",")}</td>
                            </tr>`;

                $("#pp-dtholder").prepend(html);
                
            } catch (error) {
                console.error("Error parsing response: ", error);
                $('.userDropdown').hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $('.userDropdown').hide();
        });

    });

    $(document).on("click",".close-modal",function(){

        $(".tclose").click();
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


    // refresh list
    $(document).on("click", ".pp-refreshlist", function () { 
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



     $(document).on("click",".pp-name-items",function(){
       const platformName = $(this).text();
       const paltformID   = $(this).attr("data-cid");
       $("#platformNames").val(platformName);
       $("#selectedID").val(paltformID);
       $('#pp-names-list-wrapper').html("");
       $(".pp-names-wrapper").hide();
     });

// Function to fetch and display users
const  searchPlatformNames = (query) =>{
    let optionsHtml = '';

    if(query.trim().length === 0) {

        $('#pp-names-list-wrapper').html("");
        $(".pp-names-wrapper").hide();
        return;
    }

    $.post(`../admin/searchPlatformNames/${encodeURIComponent(query)}`, function (response) {
        try {
            
            response = typeof response === 'string' ? JSON.parse(response) : response;
            // console.log(response);
            // return;
            for (let index = 0; index < response.length; index++) {
                const platformData = response[index];
                optionsHtml += `<li class="name-items pp-name-items" data-cid="${platformData.cid}" data-name="${platformData.name}">${platformData.name}</li>`;
            }
            $('#pp-names-list-wrapper').html(optionsHtml);
            if(response.length > 0){
                $(".pp-names-wrapper").show();
            }else{
                $(".pp-names-wrapper").hide(); 
            }
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
const  fetchDifferentCurrencies = () =>{
    let optionsHtml = `<option value="">--Currency--</option>`;

    for (let index = 0; index < currencyCodes.length; index++) {
        const data = currencyCodes[index];
        optionsHtml += `<option value="${data}">${data}</option>`;
    }
    // console.log(response);
    $('.currency-list').html(optionsHtml);

    // $.get(`../admin/fetchDifferentCurrency/`, function (response) {
    //     try {
            
    //         response = typeof response === 'string' ? JSON.parse(response) : response;
            
    //         for (let index = 0; index < response.length; index++) {
    //             const data = response[index];
    //             console.log(data);
    //             optionsHtml += `<option value="${data.currency}">${data.currency}</option>`;
    //         }
    //         console.log(response);
    //         $('.currency-list').html(optionsHtml);
    //      } catch (error) {
    //         console.error("Error parsing response: ", error);
           
    //     }
    // }).fail(function () {
    //     console.error("Error fetching users.");
    //     $('.userDropdown').hide();
    // });
}

fetchDifferentCurrencies();

// Function to fetch and display users
const fetchPaymentPlatform = (paymentPlatform) => {
    let optionsHtml = '';

    $.post(`../admin/fetchPaymentPlatform/${encodeURIComponent(paymentPlatform)}`, function (response) {
        try {
            
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
    const tableWrapper = $(".table-wrapperPP");
    const tableWrappers = $(".table-wrapperPP")[0];
    const scrollAmount = 1000; // Adjust as needed
    const scrollOptions = { behavior: "smooth" };
    if (tableWrapper.length) {
        switch (direction) {
            case "pp-leftlist":
                tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
                break;
            case "pp-rightlist":
                tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
                break;
            default:
                break;
        }
    }
    e.stopPropagation(); // Prevent event bubbling
  });

  const fetchAgentSubs = (eventElement,currentPage) => {

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


     


});


const renderPaginationPaymentPlatform = (elementID,totalPages, currentPage, ) => {
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


const paymentsMarkup = (data) => {
    console.log(data.countries);
    const cid  = data.payment_type_id === undefined ? data.cid : data.payment_type_id;
    return `<tr id='cid-${cid}'>
        <td> ${data.name} </td>
        <td> ${data.currency} </td>
        <td> ${data.site_url} </td>
        <td> ${data.admin_site_url} </td>
        <td> ${data.fee} </td>
        <td> ${data.min_amount} </td>
        <td> ${data.max_amount} </td>
        <td> ${data.date_created} </td>
        <td> ${data.created_by} </td>
        <td> ${data.last_update} </td>
        <td> ${data.last_update_by} </td>
        <td> ${data.status == "active" ? "Active" : (data.status == "inactive" ? "Inactive" : "Hidden")} </td>
        <td class="showEditModal" style="cursor:pointer;" ><i class='bx bx-edit-alt'></i> </td>
        <td id="pp-info-${cid}" style="display:none;">${data.info}</td>
        <td id="pp-priority-${cid}" style="display:none;">${data.priority}</td>
        <td id="pp-countries-${cid}" style="display:none;">${data.countries}</td>
            </tr>`

};


function getFormattedDateTime() {
    const now = new Date();
    
    // Year, month (0-based), day
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
  
    // Hours, minutes, seconds
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
  
    // Build the string in YYYY-MM-DD / HH:MM:SS format
    return `${year}-${month}-${day} / ${hours}:${minutes}:${seconds}`;
  }






const countries = [
    "Afghanistan",
    "Albania",
    "Algeria",
    "Andorra",
    "Angola",
    "Antigua and Barbuda",
    "Argentina",
    "Armenia",
    "Australia",
    "Austria",
    "Azerbaijan",
    "Bahamas",
    "Bahrain",
    "Bangladesh",
    "Barbados",
    "Belarus",
    "Belgium",
    "Belize",
    "Benin",
    "Bhutan",
    "Bolivia",
    "Bosnia and Herzegovina",
    "Botswana",
    "Brazil",
    "Brunei",
    "Bulgaria",
    "Burkina Faso",
    "Burundi",
    "Côte d'Ivoire",
    "Cabo Verde",
    "Cambodia",
    "Cameroon",
    "Canada",
    "Central African Republic",
    "Chad",
    "Chile",
    "China",
    "Colombia",
    "Comoros",
    "Costa Rica",
    "Croatia",
    "Cuba",
    "Cyprus",
    "Czech Republic",
    "Democratic Republic of the Congo",
    "Denmark",
    "Djibouti",
    "Dominica",
    "Dominican Republic",
    "Ecuador",
    "Egypt",
    "El Salvador",
    "Equatorial Guinea",
    "Eritrea",
    "Estonia",
    "Eswatini",
    "Ethiopia",
    "Federated States of Micronesia",
    "Fiji",
    "Finland",
    "France",
    "Gabon",
    "Gambia",
    "Georgia",
    "Germany",
    "Ghana",
    "Greece",
    "Grenada",
    "Guatemala",
    "Guinea",
    "Guinea-Bissau",
    "Guyana",
    "Haiti",
    "Honduras",
    "Hungary",
    "Iceland",
    "India",
    "Indonesia",
    "Iran",
    "Iraq",
    "Ireland",
    "Israel",
    "Italy",
    "Jamaica",
    "Japan",
    "Jordan",
    "Kazakhstan",
    "Kenya",
    "Kiribati",
    "Kosovo",
    "Kuwait",
    "Kyrgyzstan",
    "Laos",
    "Latvia",
    "Lebanon",
    "Lesotho",
    "Liberia",
    "Libya",
    "Liechtenstein",
    "Lithuania",
    "Luxembourg",
    "North Macedonia",
    "Madagascar",
    "Malawi",
    "Malaysia",
    "Maldives",
    "Mali",
    "Malta",
    "Marshall Islands",
    "Mauritania",
    "Mauritius",
    "Mexico",
    "Moldova",
    "Monaco",
    "Mongolia",
    "Montenegro",
    "Morocco",
    "Mozambique",
    "Myanmar",
    "Namibia",
    "Nauru",
    "Nepal",
    "Netherlands",
    "New Zealand",
    "Nicaragua",
    "Niger",
    "Nigeria",
    "North Korea",
    "Norway",
    "Oman",
    "Pakistan",
    "Palau",
    "Panama",
    "Papua New Guinea",
    "Paraguay",
    "Peru",
    "Philippines",
    "Poland",
    "Portugal",
    "Qatar",
    "Republic of the Congo",
    "Romania",
    "Russia",
    "Rwanda",
    "St Kitts and Nevis",
    "St Lucia",
    "St Vincent and the Grenadines",
    "Samoa",
    "San Marino",
    "Sao Tome and Principe",
    "Saudi Arabia",
    "Senegal",
    "Serbia",
    "Seychelles",
    "Sierra Leone",
    "Singapore",
    "Slovakia",
    "Slovenia",
    "Solomon Islands",
    "Somalia",
    "South Africa",
    "South Korea",
    "South Sudan",
    "Spain",
    "Sri Lanka",
    "Sudan",
    "Suriname",
    "Sweden",
    "Switzerland",
    "Syria",
    "Taiwan",
    "Tajikistan",
    "Tanzania",
    "Thailand",
    "Timor-Leste",
    "Togo",
    "Tonga",
    "Trinidad and Tobago",
    "Tunisia",
    "Turkey",
    "Turkmenistan",
    "Tuvalu",
    "Uganda",
    "Ukraine",
    "United Arab Emirates",
    "United Kingdom",
    "United States",
    "Uruguay",
    "Uzbekistan",
    "Vanuatu",
    "Vatican City",
    "Venezuela",
    "Vietnam",
    "Yemen",
    "Zambia",
    "Zimbabwe"
  ];
  


  const currencyCodes = [
      // A
      'AED','AFN','ALL','AMD','ANG','AOA','ARS','AUD','AWG','AZN',
      // B
      'BAM','BBD','BDT','BGN','BHD','BIF','BMD','BND','BOB','BOV',
      'BRL','BSD','BTN','BWP','BYN','BZD',
      // C
      'CAD','CDF','CHE','CHF','CHW','CLF','CLP','CNY','COP','COU',
      'CRC','CUC','CUP','CVE','CZK',
      // D
      'DJF','DKK','DOP','DZD',
      // E
      'EGP','ERN','ETB','EUR',
      // F
      'FJD','FKP',
      // G
      'GBP','GEL','GHS','GIP','GMD','GNF','GTQ','GYD',
      // H
      'HKD','HNL','HRK','HTG','HUF',
      // I
      'IDR','ILS','INR','IQD','IRR','ISK',
      // J
      'JMD','JOD','JPY',
      // K
      'KES','KGS','KHR','KMF','KPW','KRW','KWD','KYD','KZT',
      // L
      'LAK','LBP','LKR','LRD','LSL','LYD',
      // M
      'MAD','MDL','MGA','MKD','MMK','MNT','MOP','MRU','MUR','MVR',
      'MWK','MXN','MXV','MYR','MZN',
      // N
      'NAD','NGN','NIO','NOK','NPR','NZD',
      // O
      'OMR',
      // P
      'PAB','PEN','PGK','PHP','PKR','PLN','PYG',
      // Q
      'QAR',
      // R
      'RON','RSD','RUB','RWF',
      // S
      'SAR','SBD','SCR','SDG','SEK','SGD','SHP','SLL','SOS','SRD',
      'SSP','STN','SVC','SYP','SZL',
      // T
      'THB','TJS','TMT','TND','TOP','TRY','TTD','TWD','TZS',
      // U
      'UAH','UGX','USD','USN','UYI','UYU','UYW','UZS',
      // V
      'VED','VES','VND','VUV',
      // W
      'WST',
      // X (special codes / precious metals, etc.)
      'XAF','XAG','XAU','XBA','XBB','XBC','XBD','XCD','XDR','XOF',
      'XPD','XPF','XPT','XSU','XTS','XUA','XXX',
      // Y
      'YER',
      // Z
      'ZAR','ZMW','ZWL'
  ];
  