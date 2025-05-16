let partnersObjs = {};
let validLotteries = [];
let currentPage = 1;
let pageLimit  = 20;
$(() =>{
    
    
    
    const partnerID = $("#partner-holder").attr("data-partner-id");


    $(document).on("click",".dropdown-edit-partners",function(){
        const partnerID = $(this).attr("id").split("-")[2];
        partnerObj = partnersObjs[partnerID];
        $("#data-holder").attr("data-row-id",partnerID);
        $("#ptns-partner-id").val(partnerObj.partner_id);
        $("#ptns-partner-name-edit").val(partnerObj.name);
        $("#ptns-site-url-edit").val(partnerObj.site_url);
        $("#ptns-admin-site-url-edit").val(partnerObj.admin_site_url);
        $("#ptns-client-min-age").val(partnerObj.client_min_age);
        $("#ptns-verification-type-edit").val(partnerObj.verification_type);
        $("#ptns-unused-withdrawal-amount").val(partnerObj.unused_withdrawal_amount);
        $("#ptns-priority-edit").val(partnerObj.priority);
        $("#ptns-state-edit").val(partnerObj.state);
        $("#ptns-currency-edit").val(partnerObj.currency);
        $("#ptns-creation-time-edit").val(partnerObj.date_created);
        $("#ptns-created-by-edit").val(partnerObj.created_by);
        $("#ptns-last-update-edit").val(partnerObj.last_update);
        $("#ptns-update-by-edit").val(partnerObj.last_update_by);
    });

    $(document).on("click","#ptns-addPartnerBtn",function(){

        // console.log("We will be the source.");
        $("#ptns-addNewPartnerDialog").addClass("show");
        $("#ptns-addNewPartnerDialog").css("display","block");
    });


//     const BASE_URL = '../admin';
//     let historyStack  = [];
//     let pagesStack    = [];
//     let pagingInfo    = [];
   
    function showToast(title, message, type) {
        $.toast({
          position: "bottom-right",
          title: title,
          message: message,
          type: type,
          duration: 3000, // auto-dismiss after 3s
        });
      }  



      $(document).on("click","#editPartnerMainInfoBtn",function(){
        editPartnerMainInfo();
      });

      const editPartnerMainInfo = () => {
        const partnerID              = $("#data-holder").attr("data-row-id");
        const partnerName            = $("#ptns-partner-name-edit").val();
        const siteUrl                = $("#ptns-site-url-edit").val();
        const adminSiteUrl           =  $("#ptns-admin-site-url-edit").val();
        const clientMinAge           =  $("#ptns-client-min-age").val();
        const verificationType       = $("#ptns-verification-type-edit").val();
        const unusedWithdrawalAmount =  $("#ptns-unused-withdrawal-amount").val();
        const priority               =  $("#ptns-priority-edit").val();
        const state                  =  $("#ptns-state-edit").val();
        const currency               =  $("#ptns-currency-edit").val();
     
     
        $.post(`../admin/editPartnerMainInfo/${partnerID}/${partnerName}/${siteUrl}/${adminSiteUrl}/${clientMinAge}/${verificationType}/${unusedWithdrawalAmount}/${priority}/${state}/${currency}`, function (response) {
            try {
     
                response = typeof response === 'string' ? JSON.parse(response) : response;
              
                if(response.status === "error"){
                    showToast("Error", response.data, 'error');
                }
                if(response.status === "success"){

                    if(response.data > 0){
                        $(".tclose").click();
                        fetchAllPartners();
                        showToast("Success", "Partner Info updated successfully.", 'success');
                        return;
                    }

                  showToast("Error", "Please no change in information.", 'error');
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


      $(document).on("click","#editCurrencySettingsBtn",() => {
        const lotteries = $("#ptns-currency-list tr td input:checked").map((_,el) => el.value).get().join(",");
        const partnerID = $("#data-holder").attr("data-row-id");

        $.post(`../admin/editPartnerCurrencySettings/${partnerID}/${lotteries}`, function (response) {
            try {
     
                response = typeof response === 'string' ? JSON.parse(response) : response;
                if(response.status === "error"){
                    showToast("Error", response.data, 'error');
                }
                if(response.status === "success"){

                    if(response.data > 0){
                        $(".tclose").click();
                        fetchAllPartners();
                        showToast("Success", "Product Settings updated successfully.", 'success');
                        return;
                    }

                  showToast("Error", "Please no change in information.", 'error');
                }
            } catch (error) {
                console.error("Error parsing response: ", error);
                $('.userDropdown').hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $('.userDropdown').hide();
        });
        
    });

      $(document).on("click","#editLanguageSettingsBtn",() => {
        const languages = $("#ptns-languages-list tr td input:checked").map((_,el) => el.value).get().join(",");
        const partnerID = $("#data-holder").attr("data-row-id");

        $.post(`../admin/editPartnerlanguagesSettings/${partnerID}/${languages}`, function (response) {
            try {
     
                response = typeof response === 'string' ? JSON.parse(response) : response;
                if(response.status === "error"){
                    showToast("Error", response.data, 'error');
                }
                if(response.status === "success"){

                    if(response.data > 0){
                        $(".tclose").click();
                        fetchAllPartners();
                        showToast("Success", "Product Settings updated successfully.", 'success');
                        return;
                    }

                  showToast("Error", "Please no change in information.", 'error');
                }
            } catch (error) {
                console.error("Error parsing response: ", error);
                $('.userDropdown').hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $('.userDropdown').hide();
        });
        
    });


    
      $(document).on("click","#editPartnerLotteriesBtn",() => {
        const lotteries = $("#ptns-lotteries-list tr td input:checked").map((_,el) => el.value).get().join(",");
        const partnerID = $("#data-holder").attr("data-row-id");
        $.post(`../admin/editPartnerLotteries/${partnerID}/${lotteries}`, function (response) {
            try {
     
                response = typeof response === 'string' ? JSON.parse(response) : response;
                if(response.status === "error"){
                    showToast("Error", response.data, 'error');
                }
                if(response.status === "success"){

                    if(response.data > 0){
                        $(".tclose").click();
                        fetchAllPartners();
                        showToast("Success", "Product Settings updated successfully.", 'success');
                        return;
                    }

                  showToast("Error", "Please no change in information.", 'error');
                }
            } catch (error) {
                console.error("Error parsing response: ", error);
                $('.userDropdown').hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $('.userDropdown').hide();
        });
        
    });




      const editPartnerLotteries = () => {
        const partnerID              = $("#data-holder").attr("data-row-id");
        const partnerName            = $("#ptns-partner-name-edit").val();
        const siteUrl                = $("#ptns-site-url-edit").val();
        const adminSiteUrl           =  $("#ptns-admin-site-url-edit").val();
        const clientMinAge           =  $("#ptns-client-min-age").val();
        const verificationType       = $("#ptns-verification-type-edit").val();
        const unusedWithdrawalAmount =  $("#ptns-unused-withdrawal-amount").val();
        const priority               =  $("#ptns-priority-edit").val();
        const state                  =  $("#ptns-state-edit").val();
        const currency               =  $("#ptns-currency-edit").val();
     
     
        $.post(`../admin/editPartnerMainInfo/${partnerID}/${partnerName}/${siteUrl}/${adminSiteUrl}/${clientMinAge}/${verificationType}/${unusedWithdrawalAmount}/${priority}/${state}/${currency}`, function (response) {
            try {
     
                response = typeof response === 'string' ? JSON.parse(response) : response;
              
                if(response.status === "error"){
                    showToast("Error", response.data, 'error');
                }
                if(response.status === "success"){

                    if(response.data > 0){
                        $(".tclose").click();
                        fetchAllPartners();
                        showToast("Success", "Partner Info updated successfully.", 'success');
                        return;
                    }

                  showToast("Error", "Please no change in information.", 'error');
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



      const  searchPartnersNames = (query) =>{
        let optionsHtml = '';
        // console.log(query);
        if(query.trim().length === 0) {
    
            $('#ptns-ptn-names-list-wrapper').html("");
            $(".ptn-names-wrapper").hide();
            return;
        }
    
        $.post(`../admin/searchPartnersNames/${encodeURIComponent(query)}`, function (response) {
            try {

                response = typeof response === 'string' ? JSON.parse(response) : response;
                // console.log(response);
                // return;
                for (let index = 0; index < response.length; index++) {
                    const platformData = response[index];
                    optionsHtml += `<li class="name-items pp-name-items" data-cid="${platformData.cid}" data-name="${platformData.name}">${platformData.name}</li>`;
                }
                $('#ptns-ptn-names-list-wrapper').html(optionsHtml);
                $(".ptn-names-wrapper").show();
             } catch (error) {
                console.error("Error parsing response: ", error);
                $('.userDropdown').hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $('.userDropdown').hide();
        });
    }

    $(document).on("keyup","#ptns-ptn-search-partners-names",function (){
        // console.log();
        searchPartnersNames($(this).val());
      });

    $(document).on("click",".search-payment-platform",function(){
        searchPaymentPlatforms();
    });

    $(document).on("click",".pp-name-items",function(){
        const platformName = $(this).text();
        const paltformID   = $(this).attr("data-cid");
        $("#ptns-platformNames").val(platformName);
        $("#ptns-selectedID").val(paltformID);
        $('#ptns-pp-names-list-wrapper').html("");
        $(".pp-names-wrapper").hide();
      });

      const translatorScript = document.querySelector(".translations"); // Get the script tag
      const translator = JSON.parse(translatorScript.textContent);
   
      const page = 1;
      const limit = 20;


        $(document).on("click",".showEditModal",function(){
            $("#ptns-editPaymentPlatform").css("display","block");
            $("#ptns-editPaymentPlatform").addClass("show");
            const row = $(this).closest("tr");
            const data = $(row).find("td");
            const cid = $(row).attr("id").split("-")[1];
            $("#ptns-pp-payment-type-edit").val(cid);
            $("#ptns-pp-currency-edit").val(data[1].innerHTML.trim());
            $("#ptns-pp-status-edit").val(data[11].innerHTML.toLocaleLowerCase().trim());
            $("#ptns-pp-fee-edit").val(data[4].innerHTML);
            $("#ptns-pp-min-amount-edit").val(data[5].innerHTML);
            $("#ptns-pp-max-amount-edit").val(data[6].innerHTML);
            $("#ptns-pp-site-url-edit").val(data[2].innerHTML);
            $("#ptns-pp-admin-site-url-edit").val(data[3].innerHTML);
            $("#ptns-pp-info-edit").val($(`#ptns-pp-info-${cid}`).text());
            $("#ptns-pp-priority-edit").val($(`#ptns-pp-priority-${cid}`).text());

           let tableHtml = "";
            countries.forEach(country => {
                tableHtml += `<tr>
                <td><input class="form-check-input " type="checkbox" value="${country}"  ${$(`#ptns-pp-countries-${cid}`).text().includes(country) ? "checked" : ""}></td>
                <td><span class="pp-lottery-name">${country}</span></td>
                </tr>
                `
            });
            $("#ptns-edit-countries-tbody").html(tableHtml);


    });

   $(document).on("click","#ptns-editPaymentPlatformBtn",function(){
            const paymentType = $("#ptns-pp-payment-type-edit").val();
        const paymentTypeName = $("#ptns-pp-payment-type-edit option:selected").attr("data-name");
        const currency    = $("#ptns-pp-currency-edit").val();
        const status      = $("#ptns-pp-status-edit").val();
        const fee         = $("#ptns-pp-fee-edit").val();
        const maxAmount   = $("#ptns-pp-max-amount-edit").val();
        const minAmount   = $("#ptns-pp-min-amount-edit").val();
        const siteUrl        = $("#ptns-pp-site-url-edit").val();
        const adminSiteUrl   = $("#ptns-pp-admin-site-url-edit").val();
        const info            = $("#ptns-pp-info-edit").val();
        const priority        = $("#ptns-pp-priority-edit").val();
        const countries       = [];
        $("#ptns-edit-countries-tbody").find("tr td input:checked").closest("tr").find(".pp-lottery-name").each(function() { countries.push($(this).text()); });
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
                fetchAllPartners();
                $(".tclose").click();
                $("#ptns-pp-payment-type-edit").val("");
                $("#ptns-pp-currency-edit").val("");
                $("#ptns-pp-status-edit").val("active");
                $("#ptns-pp-fee-edit").val("");
                $("#ptns-pp-max-amount-edit").val("");
                $("#ptns-pp-min-amount-edit").val("");
                $("#ptns-pp-site-url-edit").val("");
                $("#ptns-pp-admin-site-url-edit").val("");

             } catch (error) {
                console.error("Error parsing response: ", error);
                $('.userDropdown').hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $('.userDropdown').hide();
        });
        });

       

        $(document).on("click",".tclose",function(){
            $("#ptns-editPaymentPlatform").removeClass("show");
            $("#ptns-editPaymentPlatform").css("display","none");
            $("#ptns-addNewPartnerDialog").removeClass("show");
            $("#ptns-addNewPartnerDialog").css("display","none");



            // clear all the fields for adding the payment platform
            $("#ptns-partner-name").val("");
            $("#ptns-site-url").val("");
            $("#ptns-admin-site-url").val("active");
            $("#ptns-currency").val("");
        });
        $(document).on("click","#ptns-search",function(){
            searchPaymentPlatforms();
        });

        const searchPaymentPlatforms = (page = 1,limit = 20) => {
            const partnerName  = $('#ptns-partners').val();
            const state      = $("#ptns-partnerState").val();
            const startDate        = $("#ptns-partnerStartDate").val();
            const endDate       = $("#ptns-partnerEndDate").val();

            // console.log(partnerName,state,startDate,endDate);

            if(partnerName == undefined && state == undefined && startDate == undefined && endDate == undefined){
                showToast("Error", "Please select at least one filter","error");
                return;
            }
            if(partnerName.length == 0 && state.length == 0 && startDate.length == 0 && endDate.length == 0) {
                showToast("Error", "Please select at least one filter","error");
                return;
            }
          
            $.post(`../admin/searchPartners/${partnerName}/${state}/${startDate}/${endDate}/${page}/${limit}`, function(response){
                response = typeof response === 'string' ? JSON.parse(response) : response;
                
                if(response.status === "error"){
                    showToast("Error", "Error loading data for Payment Platforms","error");
                    return;
                  }

                  if(response.data.length === 0){
                    $("#ptns-pp-dtholder").html(`<tr class="no-resultslist ptns-no-result">
                    <td colspan="12"><img src="http://localhost/admin/app/assets/images/not_found1.jpg" class="dark-logo"
                            alt="Logo-Dark"  width="150px" height="150px" /></td></tr>`);
                return;
                  }

                  let html = "";
                  response.data.forEach((data) =>{
                    html += partnersMarkup(data);
                  });
                $("#ptns-pp-dtholder").html(html);
            });
        };

    const fetchAllPartners = ()=> {
        try {
             $.ajax({
                url: `../admin/fetchPartners/${partnerID}/${page}/${limit}/`,
                type: "POST",
                
                success: function(response){
                    
                     response = JSON.parse(response);
                     //console.log(response);
                     if(response.status === "error"){
                        showToast("Error", "Error loading data for Payment Platforms","error");
                        return;
                      }

                      if(response.data.length === 0){
                        $("#ptns-pp-dtholder").html(`<tr class="no-resultslist ptns-no-result ptns-no-result">
                        <td colspan="12">
                            <img src="http://localhost/admin/app/assets/images/not_found1.jpg" class="dark-logo"
                                alt="Logo-Dark" width="150px;" height="150px;"/>
                        </td>
                    </tr>`);
                    return;
                      }

                      let html = "";
                      response.data.forEach((data) =>{
                        html += partnersMarkup(data);
                      });

                
                    $("#ptns-pp-dtholder").html(html);
                },
                error: function(xhr,status,error){
                   
                },

            });
            
        } catch (error) {
              console.error("Error fetching data:", error);
            }
    }
    fetchAllPartners();


    $(document).on('click',"#ptns-refresh",function(){
        $("#ptns-partners").val("");
        $("#ptns-partnerState").val("");
        $("#ptns-partnerStartDate").val("");
        $("#ptns-partnerEndDate").val("");
        fetchAllPartners();
    });

    const fetchPartnersNames = ()=> {
    try {
            $.ajax({
            url: `../admin/fetchPartnersNames/${partnerID}/${page}/${limit}/`,
            type: "POST",
            success: function(response){
                
                    response = JSON.parse(response);
                  //  console.log(response);
                    if(response.status === "error"){
                    showToast("Error", "Error loading data for Payment Platforms","error");
                    return;
                    }

                    if(response.data.length === 0){
                        optionsHtml = `<option value="">--Partners--</option>`;
                        $('#ptns-partners').html(optionsHtml);
                    return;
                    }
                    response = response.data;
                    optionsHtml = `<option value="">--Partners--</option>`;
                    
                    for (let index = 0; index < response.length; index++) {
                    const data = response[index];
                    optionsHtml += `<option value="${data.partner_id}" data-name="${data.name}">${data.name}</option>`;
                }
                // console.log(optionsHtml);
                $('#ptns-partners').html(optionsHtml);
            },
            error: function(xhr,status,error){
                
            },

        });
        
    } catch (error) {
            console.error("Error fetching data:", error);
        }
    }
    fetchPartnersNames();
    

    $(document).on("keyup","#ptns-platformNames",function(){
        searchPlatformNames($("#ptns-platformNames").val());
    });

    $(document).on("click",".ptns-main-info",function(){
        const partnerID = $("#data-holder").attr("data-row-id");
        const partner   = partnersObjs[partnerID];

        // console.log(partner);
        return;
        const partnerName            = $("#ptns-partner-name-edit").val();
        const siteUrl                = $("#ptns-site-url-edit").val();
        const adminSiteUrl           =  $("#ptns-admin-site-url-edit").val();
        const clientMinAge           =  $("#ptns-client-min-age").val();
        const verificationType       = $("#ptns-verification-type-edit").val();
        const unusedWithdrawalAmount =  $("#ptns-unused-withdrawal-amount").val();
        const priority               =  $("#ptns-priority-edit").val();
        const state                  =  $("#ptns-state-edit").val();
        const currency               =  $("#ptns-currency-edit").val();
    
    });

    $(document).on("click",".ptns-product-settings",function(){
        const partnerID = $("#data-holder").attr("data-row-id");
        const partner   = partnersObjs[partnerID];
        let blocked_lotteries = partner.blocked_lotteries.split(",");
        let lotteriesMarkup = "";
        validLotteries.forEach((lottery) => {
            let lotteryCheckState = !blocked_lotteries.includes(String(lottery.lt_id)) ? "checked" : ""; 
            lotteriesMarkup += `<tr>
        <td><input class="form-check-input " type="checkbox" value="${lottery.lt_id}" ${lotteryCheckState}></td>
        <td><span class="pp-lottery-name">${lottery.name}</span></td>
        </tr>`
        });
        $("#ptns-lotteries-list").html(lotteriesMarkup);
    });

    $(document).on("click",".ptns-currency-settings",function(){
        const partnerID = $("#data-holder").attr("data-row-id");
        const partner   = partnersObjs[partnerID];
        let blocked_currencies = partner.blocked_currencies.split(",");
        let currenciesMarkup = "";
        currencyCodes.forEach((currency) => {
            let currencyCheckState = !blocked_currencies.includes(currency) ? "checked" : ""; 
            currenciesMarkup += `<tr>
        <td><input class="form-check-input " type="checkbox" value="${currency}" ${currencyCheckState}></td>
        <td><span class="pp-lottery-name">${currency}</span></td>
        </tr>`
        });
        $("#ptns-currency-list").html(currenciesMarkup);
    });

    $(document).on("click",".ptns-language-settings",function(){
        const partnerID = $("#data-holder").attr("data-row-id");
        const partner   = partnersObjs[partnerID];
        let blocked_languages = partner.blocked_languages.split(",");
        let languagesMarkup = "";
        for (let name in internationalLanguagesNative) {
            let language = internationalLanguagesNative[name];
            let languageCheckState = !blocked_languages.includes(name) ? "checked" : ""; 
            languagesMarkup += `<tr>
        <td><input class="form-check-input " type="checkbox" value="${name}" ${languageCheckState}></td>
        <td><span class="pp-lottery-name">${language}</span></td>
        </tr>`
        }
      
        $("#ptns-languages-list").html(languagesMarkup);
    });
   

    const filterPaymentPlatforms = async (page,limit) => {

        const partnerID = $("#data-holder").attr("data-row-id");
        const partner   = partnersObjs[partnerID];
        const paymentPlatformID = $("#data-holder").attr("data-payment-platform-id");
        const curency_types = $("#platformStatuss").val();
        const status = $("#platformStatuse").val()
        const startDate = $("#platformStartDates").val();
        const endDate = $("#platformEndDates").val();
        let blocked_payment_platforms = partner.blocked_payment_platforms.split(",");
            try {
                const response = await fetch(`../admin/filterPartnerPaymentPlatforms/${partnerID}/${blocked_payment_platforms}/${paymentPlatformID}/${curency_types}/${status}/${startDate}/${endDate}/${page}/${limit}`);
        
                const data = await response.json();
                // console.log(data);
                if(data.data.status === "error"){
                    showToast("Error",data.data,"error");
                    return;
                }
            
                if (data.data.length < 1) {
                    let html = `
                <tr class="no-results">
                    <td colspan="9">
                        <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                    </td>
                </tr>`;
                    $("#maskpayment").LoadingOverlay("hide");
                    $("#ptns-payment-platforms-dtholder").html(html);
                    return;
                }
                $("#maskpayment").LoadingOverlay("hide");
                $("#ptns-payment-platforms-dtholder").html(paymentdata(data.data));
                const totalPages = Math.ceil(data.data[0].total_records / 20);
                renderpaymentPagination(totalPages, currentPage, pageLimit, (newPage, pageLimit) => filterPaymentPlatforms(newPage,pageLimit));
                document.getElementById("paging_infopayment").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
            } catch (error) {
                console.error("Error fetching data:", error);
            }
    };


    $(document).on("click",".ptns-payment-settings", async function() {
       
        filterPaymentPlatforms(1,20);
          
    });


    $(document).on('click',"#ptns-addNewPartnerBtn",function(){

        const partnerName  = $("#ptns-partner-name").val();
        const currency     = $("#ptns-currency").val();
        const siteUrl      = $("#ptns-site-url").val();
        const adminSiteUrl = $("#ptns-admin-site-url").val();

        const encodedSiteUrl = encodeURIComponent(siteUrl).replace(/%2F/g, '%252F');
        const encodedAdminSiteUrl = encodeURIComponent(adminSiteUrl).replace(/%2F/g, '%252F');
     
        $.post(`../admin/addNewPartner/${partnerName}/${currency}/${encodedSiteUrl}/${encodedAdminSiteUrl}`, function (response) {
            try {

                
                response = typeof response === 'string' ? JSON.parse(response) : response;
               // console.log(response);

               
                if(response.status == "error"){
                    showToast("Error",response.data,'error');
                    return;
                }

                if(response.data < 0){
                    showToast("Error","Partners names have to be unique..","error")
                    return;
                }

                showToast("Success","New Partner successfully added.","success");
                $(".tclose").click();
                $("#ptns-partner-name").val("");
                $("#ptns-site-url").val("");
                $("#ptns-admin-site-url").val("");
                $("#ptns-currency-body").find("tr td input:checked").val("");
// this is the test commit

                 const html = `<tr id='ptns-id-${response.id}'>
                        <td> ${response.id} </td>
                        <td> ${partnerName} </td>
                        <td> ${currency} </td>
                        <td> ${siteUrl} </td>
                        <td> ${adminSiteUrl} </td>
                        <td> Inactive</td>
                        <td> ${response.extra.date_created} </td>
                        <td> ${response.extra.created_by} </td>
                        <td> ${response.extra.date_created} </td>
                        <td> ${response.extra.created_by} </td>
                         <td><div class="dropdown">
                                <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="${response.id}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class='bx bx-dots-vertical-rounded'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 ptns-main-info" href="javascript:void(0);"data-bs-toggle="modal" data-bs-target="#ptns-main-info-modal" data-uid="">
                                    <i class="bx bx-show fs-5"></i>Main Info
                                </a>
                                <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 ptns-payment-settings" href="javascript:void(0);" data-rebate="" data-uid=""> 
                                    <i class='bx bx-wallet' ></i>Payment Settings
                                </a>
                                    <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 ptns-product-settings" data-agent-id="" href="javascript:void(0);"data-uid=""> 
                                    <i class='bx bx-git-merge'></i>Product Settings
                                </a>
                                <a class="dropdown-item ptns-currency-settings cursor-pointer d-flex align-items-center gap-1 " href="javascript:void(0);"data-uid="">
                                    <i class="bx bx-money fs-5"></i>Currency Settings
                                </a>
                                    <a class="dropdown-item ptns-language-settings cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"  data-uid="">
                                    <i class='bx bx-blanket' ></i>Language Settings
                                </a>
                                 
                                   
                                
                                </div>
                            </div>
                </td>
                          </tr>`;

                $(".ptns-no-result").remove();
                $("#ptns-pp-dtholder").prepend(html);
                
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

     $(document).on("click",".pp-name-items",function(){
       const platformName = $(this).text();
       const paltformID   = $(this).attr("data-cid");
       $("#ptns-platformNames").val(platformName);
       $("#ptns-selectedID").val(paltformID);
       $('#ptns-pp-names-list-wrapper').html("");
       $(".pp-names-wrapper").hide();
     });


     const fetchLotteryTypes = () => {
        $.ajax({
            url: `../admin/fetchLotteries/${partnerID}/fetchLotteries`,
            type: "POST",
            beforeSend: function () {},
            success: function (response) {
                response = JSON.parse(response);
              //  console.log(response);
                let responseMarkup = "";
                if (response.status == "error") {
                    showToast("Error", response.data, "error");
                    return;
                }
                data = response.data;
                validLotteries = data;   
            },
            error: function (res, status, error) {},
            complete: function () {
                // console.log("Operation Completed Successfully.");
            },
        });
    };

    fetchLotteryTypes();


    const populateCurrencySettings = () => {
        let markup = "";
        currencyCodes.forEach((currency) => {
            markup += `<tr>
        <td><input class="form-check-input " type="checkbox" value="${currency}" checked></td>
        <td><span class="pp-lottery-name">${currency}</span></td>
        </tr>`
        });
        $("#ptns-currency-list").html(markup);
    };

    // populateCurrencySettings();

    const populateLanguageSettings = () => {
        let markup = "";
        internationalLanguagesNative.forEach((lang) => {
            markup += `<tr>
        <td><input class="form-check-input " type="checkbox" value="${lang}" checked></td>
        <td><span class="pp-lottery-name">${lang}</span></td>
        </tr>`
        });
        $("#ptns-languages-list").html(markup);
    };

    // populateLanguageSettings();
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
            $('#ptns-lot-list-wrapper').html(optionsHtml);
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
    let lotteryID = $("#ptns-wl-selectlottery").val();
    let startDate = $("#ptns-wl-startdate").val();
    let endDate   = $("#ptns-wl-enddate").val();
    const element = this;
    const limit = 10;
    if(lotteryID != undefined){
        if(lotteryID.length == 0) return;
    }

    lotteryID = lotteryID == undefined ?  "all" : lotteryID;
    startDate = startDate.length != 0 ? startDate : "all";
    endDate   = endDate.length != 0 ? endDate : "all";
    flag      = "get-active-subs"
    // console.log(agentID);
    $.ajax({
        url: `../admin/fetchAgentSubs/${agentID}/${lotteryID}/${startDate}/${endDate}/${flag}/${currentPage}/${limit}`,
        type: "POST",
        beforeSend: function(){
           $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
            //  $("#ptns-wl-tbl-wrapper").LoadingOverlay("show");
        },
        success: function(response){
            $("#ptns-subs-back-btn").hide();
            response  = JSON.parse(response);
            if(response.status === "error"){
                $("#ptns-winLossDtholder").html(`<tr class="no-resultslist ptns-no-result"><td colspan="13">Error: ${response.data}</td></tr>`); 
                return
            }
           
            if(response.data.length == 0){
                historyStack.push($("#ptns-winLossDtholder").html());
                pagesStack.push($("#ptns-wl-pagination-wrapper").html());
                pagingInfo.push($("#ptns-paging_infowl").html());
                $("#ptns-winLossDtholder").html(`<tr class="no-resultslist ptns-no-result"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);  
                $("#ptns-wl-pagination-wrapper").html("");
                $("#ptns-paging_infowl").html("---------");
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
            historyStack.push($("#ptns-winLossDtholder").html());
            pagesStack.push($("#ptns-wl-pagination-wrapper").html());
            pagingInfo.push($("#ptns-paging_infowl").html());
            $("#ptns-winLossDtholder").html(htmlMarkup);
            const totalPages = Math.ceil(parseInt(userObjs[0].totalRecords) / 10)
            if(totalPages < 11){
                $("#ptns-wl-pagination-wrapper").html("");
                $("#ptns-paging_infowl").html("---------");
                return;
            }
            renderwithdrawPagination(totalPages,parseInt(currentPage),'page-agent-subs');
            
            },
        error: function(xhr,status,error){
            showToast("Error","An Error occured, please try again later.","info");
        },
        complete: function(){
            $("#ptns-wl-tbl-wrapper").LoadingOverlay("hide");
            // $($(element).find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx-check-double");
            // $("#ptns-wl-pagination").html("")
        }
    });


  }


const populateCurrencies = () => {
    let tableHtml = "";
    currencyCodes.forEach(currency => {
        tableHtml += `<tr>
        <td style="width:1.2rem;"><input class="form-check-input " type="checkbox" value="${currency}" ></td>
        <td><span class="pp-lottery-name">${currency}</span></td>
        </tr>
        `
    });
    $("#ptns-currency-body").html(tableHtml);
}

populateCurrencies();
});



// --------------------------------------------------------------------


const renderPaginationPaymentPlatform = (elementID,totalPages, currentPage, ) => {
    const createPageLink = (i, label = i, disabled = false, active = false) =>
        `<li class='page-item ${disabled ? "disabled" : ""} ${active ? "active" : ""}'>
        <a class='page-link wl-pagination' href='#ptns-' data-page='${i}'>${label}</a>
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
    document.querySelectorAll(`#ptns-${elementID} .page-link`).forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const newPage = +this.getAttribute("data-page");
            if (newPage > 0 && newPage <= totalPages) {
                $("#ptns-mask").LoadingOverlay("show", {
                    background: "rgb(90,106,133,0.1)",
                    size: 3,
                  });
                // callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
            }
        });
    });
}

const paymentdata = (data) => { 
    
    let html = "";
   
     data.forEach((item) => {
      let timezone = item.timezone.split(" ");
      timezone     = `${timezone[0]}<span style="margin-left: 1rem;">GMT${timezone[1]}</span>`
      const status = item.status === 'active' ? '<span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">Active</span>'  :item.status=="inactive" ? '<span class="badge fw-semibold py-1 w-85 bg-info-subtle text-warning">Inactive</span>':'<span class="badge fw-semibold py-1 w-85 bg-warning-subtle text-warning">Hidden</span>'
     
      html += `
              <tr>
                  <td>${item.name}</td>
                  <td>${item.currency_type}</td>
                  <td>${item.currency}</td>
                  <td>${item.site_url}</td>
                  <td>${item.admin_site_url}</td>
                  <td>${formatMoney(item.fees)}</td>
                  <td>${formatMoney(item.min_deposit)}</td>
                  <td>${formatMoney(item.max_deposit)}</td>
                  <td>${formatMoney(item.min_withdrawal)}</td>
                  <td>${formatMoney(item.max_withdrawal)}</td>
                  <td>${item.date_created}</td>
                  <td>${timezone}</td>
                  <td>${item.created_by}</td>
                  <td>${item.last_update}</td>
                  <td>${item.last_update_by}</td>
                  <td>${status}</td>
                  <td>
                    <div class="dropdown">
                    <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class='bx bx-dots-vertical-rounded'></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;"> 
                    <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 editpayment" href="javascript:void(0);" datas ="${item.bankid}"> 
                        <i class="bx bx-edit fs-5" ></i>Edit
                    </a>
                        <a class="dropdown-item deletepayment cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);" datas="${item.bankid}">
                        <i class="bx bx-trash fs-5"></i>Delete
                    </a>
                    </div>
                    </div>
                  </td>
                      
                  </tr>
              `;
    });
    return html;
  };


const partnersMarkup = (data) => {
    partnersObjs[data.partner_id] = data;
    let timezone = data.timezone.split(" ");
    timezone     = `${timezone[0]}<span style="margin-left: 1rem">GMT${timezone[1]}</span>`;
    return `<tr id='ptns-id-${data.partner_id}'>
            <td> ${data.partner_id} </td>
            <td> ${data.name} </td>
            <td> ${data.currency} </td>
            <td> ${data.site_url} </td>
            <td> ${data.admin_site_url} </td>
            <td> ${data.state}</td>
            <td> ${data.date_created} </td>
            <td> ${timezone}</td>
            <td> ${data.created_by} </td>
            <td> ${data.date_created} </td>
            <td> ${data.last_update_by} </td>
            <td><div class="dropdown">
                    <a class="dropdown-toggles dropdown-edit-partners" href="javascript:void(0)" role="button" id="data-obj-${data.partner_id}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true" ><i class='bx bx-dots-vertical-rounded'></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                    <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 ptns-main-info" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ptns-main-info-modal" data-uid="">
                        <i class="bx bx-show fs-5"></i>Main Info
                    </a> 
                    <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 ptns-payment-settings" href="javascript:void(0);" data-rebate="" data-uid="" data-bs-toggle="modal" data-bs-target="#ptns-payment-platforms-modal" data-uid=""> 
                        <i class='bx bx-wallet' ></i>Payment Settings
                    </a>
                        <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 ptns-product-settings" data-agent-id="" href="javascript:void(0);"data-uid="" data-bs-toggle="modal" data-bs-target="#ptns-product-settings-modal" data-uid=""> 
                        <i class='bx bx-git-merge'></i>Product Settings
                    </a>

                    <a class="dropdown-item ptns-currency-settings cursor-pointer d-flex align-items-center gap-1 " href="javascript:void(0);"data-uid="" data-bs-toggle="modal" data-bs-target="#ptns-currency-settings-modal" data-uid="">
                        <i class="bx bx-money fs-5"></i>Currency Settings
                    </a> 
                        <a class="dropdown-item ptns-language-settings cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"  data-uid="" data-bs-toggle="modal" data-bs-target="#ptns-languages-settings-modal" data-uid="">
                        <i class='bx bx-blanket' ></i>Language Settings
                    </a> 
                   

                       
                    </div>
                   </div>
                </td>
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


function renderpaymentPagination(totalPages, currentPage, pageLimit, callback) {
    const createPageLink = (i, label = i, disabled = false, active = false) =>
        `<li class='page-item ${disabled ? "disabled" : ""} ${active ? "active" : ""}'>
            <a class='page-link' href='#' data-page='${i}'>${label}</a>
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

    document.getElementById("ptns-pagination").innerHTML = pagLink;

    // Add click event listeners
    document.querySelectorAll("#ptns-pagination .page-link").forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const newPage = +this.getAttribute("data-page");
            if (newPage > 0 && newPage <= totalPages) {
                currentPage = newPage; // Update currentPage when a page link is clicked
                $("#maskpayment").LoadingOverlay("show", {
                    background: "rgb(90,106,133,0.1)",
                    size: 3,
                });
                callback(newPage, pageLimit); // Call fetchpayment with the new page and pageLimit
            }
        });
    });
}

  function formatMoney(money) { 
    let moneyStr = String(money); 
    if (moneyStr.includes(".")) { 
        let parts = moneyStr.split("."); 
        if (parts[1].length > 2) { 
            parts[1] = parts[1].substring(0, 4); 
        } 
        moneyStr = parts.join(".").replace(/\.?0+$/, ""); 
    } 
    return moneyStr; 
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
  

 const internationalLanguagesNative = {
    "arabic" : "العربية",            // Arabic
   "chinese" : "中文（普通话）",      // Chinese (Mandarin)
   "english" : "English",           // English
   "french" : "Français",          // French
   "russian" : "Русский",           // Russian
   "spanish" : "Español",           // Spanish
   "portugal" : "Português",         // Portuguese
   "germany" : "Deutsch",           // German
   "japanese" : "日本語",             // Japanese
   "hindi" : "हिन्दी",             // Hindi
 
   // Additional major Asian languages
  "Bengali" : "বাংলা",             // Bengali
  "Urdu" : "اردو",             // Urdu
  "Punjabi" : "ਪੰਜਾਬੀ",           // Punjabi
  "Gujarati" : "ગુજરાતી",           // Gujarati
  "Marathi" : "मराठी",             // Marathi
  "Telugu" : "తెలుగు",           // Telugu
  "Tamil" : "தமிழ்",             // Tamil
  "Kannada" : "ಕನ್ನಡ",             // Kannada
  "Malayalam" : "മലയാളം",           // Malayalam
  "Nepali" : "नेपाली",           // Nepali
  "Sinhala" : "සිංහල",           // Sinhala
  "Korean" : "한국어",             // Korean
  "Vietnamese" : "Tiếng Việt",        // Vietnamese
  "Thai" : "ภาษาไทย",          // Thai
  "Persian" : "فارسی",             // Persian (Farsi)
  "Indonesian" : "Bahasa Indonesia",  // Indonesian (Latin script)
  "Malay" : "Bahasa Melayu",     // Malay (Latin script)
  "Burmese" : "ဗမာစာ",            // Burmese (Myanmar)
  "Khmer" : "ភាសាខ្មែរ",        // Khmer
  "Lao" : "ລາວ",             // Lao
 };