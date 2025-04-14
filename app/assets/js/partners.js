$(() =>{

    const BASE_URL = '../admin';
    let historyStack  = [];
    let pagesStack    = [];
    let pagingInfo    = [];
   
    function showToast(title, message, type) {
        $.toast({
          position: "bottom-right",
          title: title,
          message: message,
          type: type,
          duration: 3000, // auto-dismiss after 3s
        });
      }  

      const  searchPartnersNames = (query) =>{
        let optionsHtml = '';
        console.log(query);
        if(query.trim().length === 0) {
    
            $('#ptn-names-list-wrapper').html("");
            $(".ptn-names-wrapper").hide();
            return;
        }
    
        $.post(`../admin/searchPartnersNames/${encodeURIComponent(query)}`, function (response) {
            try {
                
                console.log(response);
                return;
                response = typeof response === 'string' ? JSON.parse(response) : response;
                // console.log(response);
                // return;
                for (let index = 0; index < response.length; index++) {
                    const platformData = response[index];
                    optionsHtml += `<li class="name-items pp-name-items" data-cid="${platformData.cid}" data-name="${platformData.name}">${platformData.name}</li>`;
                }
                $('#ptn-names-list-wrapper').html(optionsHtml);
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

    $(document).on("keyup","#ptn-search-partners-names",function (){
        console.log();
        searchPartnersNames($(this).val());
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

    $(document).on("click",".pp-name-items",function(){
        const platformName = $(this).text();
        const paltformID   = $(this).attr("data-cid");
        $("#platformNames").val(platformName);
        $("#selectedID").val(paltformID);
        $('#pp-names-list-wrapper').html("");
        $(".pp-names-wrapper").hide();
      });

});