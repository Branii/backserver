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
        1: "Manual payment",
        2: "Bank Transfer",
        3: "Momo",
        5: "Crypto",
      };


    const paymentdata = (data) => { 
    
        let html = "";
  
         data.forEach((item) => {
         const bankstatus = item.bank_status === 'active' ? '<span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">Active</span>':item.bank_status=="inactive" ? '<span class="badge fw-semibold py-1 w-85 bg-info-subtle text-warning">Inactive</span>':'<span class="badge fw-semibold py-1 w-85 bg-warning-subtle text-info">Hidden</span>'

         let timezone = item.timezone.split(" ");
         timezone     = `${timezone[0]}<span style="margin-left: 1rem;">GMT${timezone[1]}</span>`;
         
          html += `
                      <tr>
                          <td>${item.name}</td>
                          <td>${item.bank_type}</td>
                          <td>${item.currency_type}</td>
                          <td>${formatMoney(item.max_deposit)}</td>
                          <td>${formatMoney(item.max_withdrawal)}</td>
                          <td>${item.created_at}</td>
                          <td>${timezone}</td>
                          <td>${item.approved_by}</td>
                          <td>${bankstatus}</td>
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
  
    const renderpayment = (data) => {
      var html = paymentdata(data);
      $("#paymentContainer").html(html);
    };
  
    let currentPage = 1;
    let pageLimit = 20;
 
    
    async function fetchPaymentPlatform(page,pageLimit) {
      try {
        const response = await fetch( `../admin/fetchPaymentPlatform/${page}/${pageLimit}`);
        const data = await response.json();
        $("#maskpayment").LoadingOverlay("hide");
        renderpayment(data.payment);
        renderpaymentPagination(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchPaymentPlatform(newPage, pageLimit));
        document.getElementById("paging_infopayment").innerHTML = "Page " + page + " of " + data.totalPages + " pages";
    
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
    fetchPaymentPlatform(currentPage,pageLimit)

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
  
      document.getElementById("paginationpayments").innerHTML = pagLink;
  
      // Add click event listeners
      document.querySelectorAll("#paginationpayments .page-link").forEach((link) => {
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
  
  async function filterpayment(curencytypes,stautspayment,startdepay,enddepay,currentPage,pageLimit) {
    try {
        let  response = await fetch(`../admin/filterpayments/${partnerID}/${curencytypes}/${stautspayment}/${startdepay}/${enddepay}/${currentPage}/${pageLimit}`);
        const data =  await response.json();

        $(".loaderpay").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
        if (data.payments.length < 1) {
            let html = `
          <tr class="no-results">
              <td colspan="9">
                  <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
              </td>
          </tr>`;
            $("#maskpayment").LoadingOverlay("hide");
            $("#paymentContainer").html(html);
            return;
        }
        $("#maskpayment").LoadingOverlay("hide");
        renderpayment(data.payments);
        renderpaymentPagination(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => filterpayment(username,stautspayment,startdepay,enddepay,newPage,pageLimit));
        document.getElementById("paging_infopayment").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
    } catch (error) {
        console.error("Error fetching data:", error);
    }
  }
  


  $(".refreshpayment").click(function () {
    $(".queryholderlistt").val("");
    $("#maskpayment").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3,
    });
    fetchPaymentPlatform(currentPage,pageLimit)
  });
  

  $(".playerpayment").click(function () {
    let direction = $(this).val();
    const tableWrapper = $(".table-wrapperpayment");
    const tableWrappers = document.querySelector(".table-wrapperpayment");
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

   

  $(document).on('click', '.executepayment', function () {
    if ($("#platformStatuss").val() == "" && $("#platformStartDates").val() == "" && $("#platformStatuse").val() == "") {
      showToast("Heads up!!","Select one or more data fields to filter","info")
      return;
  }
    const curencytypes = $("#platformStatuss").val();
    const stautspayment = $("#platformStatuse").val()
    const startdepay = $("#platformStartDates").val();
    const enddepay = $("#platformEndDates").val();
      console.log(curencytypes,stautspayment,startdepay,enddepay)

     filterpayment(curencytypes,stautspayment,startdepay,enddepay,currentPage,pageLimit)

      $(".loaderpay").removeClass('bx-check-double').addClass('bx-loader bx-spin');

  });

  $(document).on('click', '#addPaymentPlatformBtn', function () {
      $("#payplatmodal").modal("show");  
  })

  const currencyCodes = ['AED','AFN','ALL','AMD','ANG','AOA','ARS','AUD','AWG','AZN',
      'BAM','BBD','BDT','BGN','BHD','BIF','BMD','BND','BOB','BOV',
      'BRL','BSD','BTN','BWP','BYN','BZD','CAD','CDF','CHE','CHF','CHW','CLF','CLP',
      'CNY','COP','COU','CRC','CUC','CUP','CVE','CZK','DJF','DKK','DOP','DZD','EGP',
      'ERN','ETB','EUR','FJD','FKP','GBP','GEL','GHS','GIP','GMD','GNF','GTQ','GYD',
      'HKD','HNL','HRK','HTG','HUF','IDR','ILS','INR','IQD','IRR','ISK','JMD','JOD',
      'JPY','KES','KGS','KHR','KMF','KPW','KRW','KWD','KYD','KZT','LAK','LBP','LKR',
      'LRD','LSL','LYD','MAD','MDL','MGA','MKD','MMK','MNT','MOP','MRU','MUR','MVR',
      'MWK','MXN','MXV','MYR','MZN','NAD','NGN','NIO','NOK','NPR','NZD','OMR','PAB',
      'PEN','PGK','PHP','PKR','PLN','PYG','QAR','RON','RSD','RUB','RWF','SAR','SBD',
      'SCR','SDG','SEK','SGD','SHP','SLL','SOS','SRD','SSP','STN','SVC','SYP','SZL',
      'THB','TJS','TMT','TND','TOP','TRY','TTD','TWD','TZS','UAH','UGX','USD','USN',
      'UYI','UYU','UYW','UZS','VED','VES','VND','VUV','WST','XAF','XAG','XAU','XBA',
      'XBB','XBC','XBD','XCD','XDR','XOF','XPD','XPF','XPT','XSU','XTS','XUA','XXX',
      'YER','ZAR','ZMW','ZWL'];
  

  $(document).ready(function() {
      const $select = $('#currency-select');
      currencyCodes.forEach(function(code) {
          $select.append(`<option value="${code}">${code}</option>`);
      });
  });

        //add new payment platform
  $(document).on("click", ".savemoneybtn", function () {
      const data = {
        paymentname: $("#paymentname").val(),
        currencytype: $(".currencytype").val(),
        paylogo: $(".paylogo").val(), // no need to encode
        currencystate: $(".currencystate").val(),
        maxiamount: $("#maxiamount").val(),
        miniamount: $("#miniamount").val(),
        currencyselect: $(".currency-select").val(),
        approvedby: $(".approved").val()
      };

        for (const [key, value] of Object.entries(data)) {
          if (!value || value.trim() === "") {
              showToast("Heads up!", `Field ${key} is required.`, "info");
              return; // Stop the process if any field is empty
          }
      }
    
      $(".loaderpays").removeClass("bx-send").addClass("bx-loader-circle bx-spin loader")
      $(".form-reset").val('');
      $.ajax({
        url: "../admin/addnewpayment", // Clean URL!
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function (response) {
            const message = typeof response === 'string' ? JSON.parse(response) : response;
            $(".loaderpays").removeClass("bx-loader-circle bx-spin loader").addClass("bx-send");
            showToast("Success", message, "success");
            $("#payplatmodal").modal("hide");  
            fetchPaymentPlatform(currentPage,pageLimit)
        },
        error: function () {
            showToast("Error", "Failed to save data", "error");
            $(".loaderpays").removeClass("bx-loader-circle bx-spin loader").addClass("bx-send");
        }
    });
      
  });
    
      
   //delete message
  $(document).on("click", ".deletepayment", function () {
      const payid = $(this).attr("datas");
      $.post(`../admin/deletepayment/${payid}`, function (response) {
      if (response) {
          showToast("Success",JSON.parse(response), "success");
          fetchPaymentPlatform(currentPage,pageLimit)
      } else {
          showToast("Heads up!!", "failed", "info");
      }
      });
  });

       //edit message
  $(document).on("click", ".editpayment", function () {
    $("#editpayplatform").modal("show");
     const payid = $(this).attr("datas");
      $.post(`../admin/editpayment/${payid}`, function (response) {
        const data = JSON.parse(response)[0];
        $("#maxiamounts").val(data.max_withdrawal);
        $("#minamount").val(data.max_deposit);
        $("#paymentids").val(data.bankid);
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
    const  paymentids  = $("#paymentids").val();
    $(".loaderpayanup").removeClass("bx-send").addClass("bx-loader-circle bx-spin loader");
     $.post(`../admin/updateplatform/${typecurrency}/${maxiamounts}/${minamount}/${statecurrent}/${paymentids}`, 
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

  function tableScrollpayment() {
    const tableContainerpayment= document.querySelector(".table-wrapperpayment");
    const headerRowpayment= document.querySelector(".paymentheaderrow");

    tableContainerpayment.addEventListener("scroll", function () {
        if (tableContainerpayment.scrollTop > 0) {
            headerRowpayment.classList.add("sticky-paymentheader");
        } else {
            headerRowpayment.classList.remove("sticky-paymentheader");
        }
    });
  }
 tableScrollpayment();


});
  