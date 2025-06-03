$(function () {
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
      const states = {
        1: "Manual sms",
        2: "Bank Transfer",
        3: "Momo",
        5: "Crypto",
      };


    const smsdata = (data) => { 
 
    
        let html = "";
  
         data.forEach((item) => {
        //    console.log(item)
        //  const bankstatus = item.bank_status === 'active' ? '<span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">Active</span>':item.bank_status=="inactive" ? '<span class="badge fw-semibold py-1 w-85 bg-info-subtle text-warning">Inactive</span>':'<span class="badge fw-semibold py-1 w-85 bg-warning-subtle text-info">Hidden</span>'

        //  let timezone = item.timezone.split(" ");
        //  timezone     = `${timezone[0]}<span style="margin-left: 1rem;">GMT${timezone[1]}</span>`;
          
          html += `
                      <tr>
                          <td>${item.sms_provider}</td>
                          <td>${item.sender_name}</td>
                          <td>${item.total_sms}</td>
                          <td>${item.sms_used}</td>
                          <td>${item.current_sms}</td>
                          <td>${item.status}</td>
                          
                          <td>
                           <div class="dropdown">
                            <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class='bx bx-dots-vertical-rounded'></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;"> 
                            <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 editsms" href="javascript:void(0);" datas =""> 
                                <i class="bx bx-edit fs-5" ></i>Edit
                            </a>

                             <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 editsms" href="javascript:void(0);" datas =""> 
                                <i class="bx bx-edit fs-5" ></i>Edit
                            </a>
                            <a class="dropdown-item deletesms cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);" datas="">
                                <i class="bx bx-money fs-5"></i>Sms Top up
                            </a>
                             <a class="dropdown-item deletesms cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);" datas="">
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
  
    const rendersms = (data) => {
      var html = smsdata(data);
      $("#smscontainer").html(html);
    };
  
    let currentPage = 1;
    let pageLimit = 20;
 
    
    async function fetchsmsplatform(page,pageLimit) {
      try {
        const response = await fetch( `../admin/fetchsmsplatform/${page}/${pageLimit}`);
        const data = await response.json();
          // console.log(data)
      //   return
        $("#masksms").LoadingOverlay("hide");
        rendersms(data.sms);
        rendersmsPagination(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchsmsplatform(newPage, pageLimit));
        document.getElementById("paging_infosms").innerHTML = "Page " + page + " of " + data.totalPages + " pages";
    
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
    fetchsmsplatform(currentPage,pageLimit)

  function rendersmsPagination(totalPages, currentPage, pageLimit, callback) {
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
  
      document.getElementById("paginationsmss").innerHTML = pagLink;
  
      // Add click event listeners
      document.querySelectorAll("#paginationsmss .page-link").forEach((link) => {
          link.addEventListener("click", function (e) {
              e.preventDefault();
              const newPage = +this.getAttribute("data-page");
              if (newPage > 0 && newPage <= totalPages) {
                  currentPage = newPage; // Update currentPage when a page link is clicked
                  $("#masksms").LoadingOverlay("show", {
                      background: "rgb(90,106,133,0.1)",
                      size: 3,
                  });
                  callback(newPage, pageLimit); // Call fetchsms with the new page and pageLimit
              }
          });
      });
  }
  
  async function filtersms(curencytypes,stautssms,startdepay,enddepay,currentPage,pageLimit) {
    try {
        let  response = await fetch(`../admin/filtersmss/${partnerID}/${curencytypes}/${stautssms}/${startdepay}/${enddepay}/${currentPage}/${pageLimit}`);
        const data =  await response.json();

        $(".loaderpay").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
        if (data.smss.length < 1) {
            let html = `
          <tr class="no-results">
              <td colspan="9">
                  <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
              </td>
          </tr>`;
            $("#masksms").LoadingOverlay("hide");
            $("#smsContainer").html(html);
            return;
        }
        $("#masksms").LoadingOverlay("hide");
        rendersms(data.smss);
        rendersmsPagination(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => filtersms(username,stautssms,startdepay,enddepay,newPage,pageLimit));
        document.getElementById("paging_infosms").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
    } catch (error) {
        console.error("Error fetching data:", error);
    }
  }
  
  $(".refreshsms").click(function () {
    $(".queryholderlistt").val("");
    $("#masksms").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3,
    });
    fetchPaymentPlatform(currentPage,pageLimit)
  });
  

    $(".playersms").click(function () {
        let direction = $(this).val();
        const tableWrapper = $(".table-wrappersms");
        const tableWrappers = document.querySelector(".table-wrappersms");
        const scrollAmount = 1000; // Adjust as needed
        const scrollOptions = {
        behavior: "smooth",
        };
        if (tableWrapper.length) {
        switch (direction) {
            case "leftd":
            tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
            break;
            case "rightd":
            tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
            break;
            case "startd":
            // Scroll to the absolute start (leftmost position)
            tableWrapper.animate({ scrollLeft: 0 }, "slow");
            break;
            case "endd":
            const maxScrollLeft =
                tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
            tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
            break;
            default:
            break;
        }
        }
    });

   

    $(document).on('click', '.executesms', function () {
    if ($("#platformStatuss").val() == "" && $("#platformStartDates").val() == "" && $("#platformStatuse").val() == "") {
      showToast("Heads up!!","Select one or more data fields to filter","info")
      return;
    }
    const curencytypes = $("#platformStatuss").val();
    const stautssms = $("#platformStatuse").val()
    const startdepay = $("#platformStartDates").val();
    const enddepay = $("#platformEndDates").val();
      // console.log(curencytypes,stautssms,startdepay,enddepay)

     filtersms(curencytypes,stautssms,startdepay,enddepay,currentPage,pageLimit)

      $(".loaderpay").removeClass('bx-check-double').addClass('bx-loader bx-spin');

    });

    $(document).on('click', '#addsmsplatform', function () {
        $("#smsmodal").modal("show");  
    })

   $(document).on('click', '#addsmssettings', function () {
     $.post(`../admin/savessmsstaes`, function (response) {
        let data = typeof response === "string" ? JSON.parse(response)[0] : response;
   
        $(".depositSwitch").prop("checked", data.deposit == 1);
        $("#withdrawSwitch").prop("checked", data.withdraw == 1);
        // $("#securitySwitch").prop("checked", data.security == 1);
        // $("#promoSwitch").prop("checked", data.promo == 1);
        // $("#gameSwitch").prop("checked", data.game == 1);
        // $("#vipSwitch").prop("checked", data.vip == 1);
        $("#provider").val(data.sms_provider);

        // Save to localStorage
        const savedPrefs = {
            provider: data.sms_provider,
            deposit: data.deposit == 1,
            withdraw: data.withdraw == 1,
            // security: data.security == 1,
            // promo: data.promo == 1,
            // game: data.game == 1,
            // vip: data.vip == 1
        };
        localStorage.setItem("smsPreferences", JSON.stringify(savedPrefs));
     });

       $("#smsModalsettings").modal("show");
   });

      //add new sms platform
    $(document).on("click", ".savesms", function () {
       if ($("#smsnameprovider").val() == "" && $("#partnamesms").val() == "") {
            showToast("Heads up!!","Select one or more data fields to filter","info")
            return;
          }
       const  smsprovider = $("#smsnameprovider").val()
       const sendename = $("#partnamesms").val()
       const approvedby = $(".approved").val()
     
    //   $(".loaderpays").removeClass("bx-send").addClass("bx-loader-circle bx-spin loader")
    //   $(".form-reset").val('');
      $.post(`../admin/addprovider/${smsprovider}/${sendename}`, function (response){
        const results = JSON.parse(response)
        //  console.log(results)
        if(results == "success"){
         $("#smsmodal").modal("hide"); 
         showToast("Heads up!!","Sms provider added successfully","success")
        }else{
          showToast("Heads up!!","Sms provider added successfully","info")
        }
    
      })

    
    });
    
    //delete message
    $(document).on("click", ".deletesms", function () {
        const payid = $(this).attr("datas");
        $.post(`../admin/deletesms/${payid}`, function (response) {
        if (response) {
            showToast("Success",JSON.parse(response), "success");
            fetchPaymentPlatform(currentPage,pageLimit)
        } else {
            showToast("Heads up!!", "failed", "info");
        }
        });
    });

       //edit message
    $(document).on("click", ".editsms", function () {
        $("#editpayplatform").modal("show");
        const payid = $(this).attr("datas");
        $.post(`../admin/editsms/${payid}`, function (response) {
            const data = JSON.parse(response)[0];
            $("#maxiamounts").val(data.max_withdrawal);
            $("#minamount").val(data.max_deposit);
            $("#smsids").val(data.bankid);
            const currencys = data.currency_type;
            if ($(`.typecurrency option[value="${currencys}"]`).length === 0) {
                $(".typecurrency").append(new Option(currencys, currencys));
            }
            $(".typecurrency").val(currencys); 

            const status = data.bank_status;
            if ($(`.statecurrent option[value="${status}"]`).length === 0) {
                $(".statecurrent").append(new Option(status, status));
            }
            $(".statecurrent").val(status); 
        });
    });


    $(document).on("click", ".updatepaybtn", function () {
        const typecurrency = $(".typecurrency").val();
        const maxiamounts  = $("#maxiamounts").val();
        const minamount    = $("#minamount").val();
        const statecurrent = $(".statecurrent").val();
        const  smsids  = $("#smsids").val();
        $(".loaderpayanup").removeClass("bx-send").addClass("bx-loader-circle bx-spin loader");
        $.post(`../admin/updateplatform/${typecurrency}/${maxiamounts}/${minamount}/${statecurrent}/${smsids}`, 
        function (response) {
        $(".loaderpayanup").removeClass("bx-loader-circle bx-spin loader").addClass("bx-send");
        if (response) {
            showToast("Success", JSON.parse(response), "success");
            $("#editpayplatform").modal("hide");
            fetchPaymentPlatform(currentPage,pageLimit)
        } else {
            showToast("Heads up!!", JSON.parse(response), "info");
        }
        });
    });


     $(document).on("click", "#sendSMSBtn", function () {
       const payload = {
                provider: $("#provider").val(),
                deposit: $(".depositSwitch").is(":checked"),
                withdraw: $("#withdrawSwitch").is(":checked"),
                // security: $("#securitySwitch").is(":checked"),
                // promo: $("#promoSwitch").is(":checked"),
                // game: $("#gameSwitch").is(":checked"),
                // vip: $("#vipSwitch").is(":checked")
            };
         ///  localStorage.setItem("smsPreferences", JSON.stringify(payload));
        $(".loaderpayanup").removeClass("bx-send").addClass("bx-loader-circle bx-spin loader");

         $.ajax({
                url: `../admin/smspreferences`,
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify(payload),
                 success: function (response) {
                 let res = typeof response === "string" ? JSON.parse(response) : response;
                   if(res === "success"){
                     showToast("Heads up!!","Sms settings saved","success")
                      $("#smsModalsettings").modal("hide");
                   }else{
                    showToast("Heads up!!","Sms settings not saved","info")
                   }
           
                },
           });

          
     });

    // function tableScrollsms() {
    //     const tableContainersms= document.querySelector(".table-wrappersms");
    //     const headerRowsms= document.querySelector(".smsheaderrow");

    //     tableContainersms.addEventListener("scroll", function () {
    //         if (tableContainersms.scrollTop > 0) {
    //             headerRowsms.classList.add("sticky-smsheader");
    //         } else {
    //             headerRowsms.classList.remove("sticky-smsheader");
    //         }
    //     });
    // }
    // tableScrollsms();


});
  