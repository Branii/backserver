$(function () {

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
        1: "Manual email",
        2: "Bank Transfer",
        3: "Momo",
        5: "Crypto",
      };


    const emaildata = (data) => { 
 
    
        let html = "";
  
         data.forEach((item) => {
        //    console.log(item)
        //  const bankstatus = item.bank_status === 'active' ? '<span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">Active</span>':item.bank_status=="inactive" ? '<span class="badge fw-semibold py-1 w-85 bg-info-subtle text-warning">Inactive</span>':'<span class="badge fw-semibold py-1 w-85 bg-warning-subtle text-info">Hidden</span>'

        //  let timezone = item.timezone.split(" ");
        //  timezone     = `${timezone[0]}<span style="margin-left: 1rem;">GMT${timezone[1]}</span>`;
          
          html += `
                      <tr>
                          <td>${item.email_provider}</td>
                          <td>${item.sender_name}</td>
                          <td>${item.total_email}</td>
                          <td>${item.email_used}</td>
                          <td>${item.current_email}</td>
                          <td>${item.created_at}</td>
                          <td>${item.status}</td>
                          
                          <td>
                           <div class="dropdown">
                            <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class='bx bx-dots-vertical-rounded'></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;"> 
                             <a class="dropdown-item deleteemail cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);" datas="">
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
  
    const renderemail = (data) => {
      var html = emaildata(data);
      $("#emailcontainer").html(html);
    };
  
    let currentPage = 1;
    let pageLimit = 20;
 
    async function fetchemaildata(page,pageLimit) {
      try {
        const response = await fetch( `../admin/fetchemaildata/${page}/${pageLimit}`);
        const data = await response.json();
          // console.log(data)
      //   return
        $("#maskemail").LoadingOverlay("hide");
        renderemail(data.email);
        renderemailPagination(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchemaildata(newPage, pageLimit));
        document.getElementById("paging_infoemail").innerHTML = "Page " + page + " of " + data.totalPages + " pages";
    
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
    fetchemaildata(currentPage,pageLimit)

  function renderemailPagination(totalPages, currentPage, pageLimit, callback) {
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
  
      document.getElementById("paginationemails").innerHTML = pagLink;
  
      // Add click event listeners
      document.querySelectorAll("#paginationemails .page-link").forEach((link) => {
          link.addEventListener("click", function (e) {
              e.preventDefault();
              const newPage = +this.getAttribute("data-page");
              if (newPage > 0 && newPage <= totalPages) {
                  currentPage = newPage; // Update currentPage when a page link is clicked
                  $("#maskemail").LoadingOverlay("show", {
                      background: "rgb(90,106,133,0.1)",
                      size: 3,
                  });
                  callback(newPage, pageLimit); // Call fetchemail with the new page and pageLimit
              }
          });
      });
  }
  
  async function  filteremail(emailprovider,emailstatus,startemail,endemail,currentPage,pageLimit) {
    try {
        let  response = await fetch(`../admin/filteremail/${emailprovider}/${emailstatus}/${startemail}/${endemail}/${currentPage}/${pageLimit}`);
        const data =  await response.json();
      //  console.log(data)
        ///return

        $(".loaderemail").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
        if (data.email.length < 1) {
            let html = `
          <tr class="no-results">
              <td colspan="9">
                  <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
              </td>
          </tr>`;
            $("#maskemail").LoadingOverlay("hide");
            $("#emailcontainer").html(html);
            return;
        }
        $("#maskemail").LoadingOverlay("hide");
        renderemail(data.email);
        renderemailPagination(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => filteremail(emailprovider,emailstatus,startemail,endemail,newPage,pageLimit));
        document.getElementById("paging_infoemail").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
    } catch (error) {
        console.error("Error fetching data:", error);
    }
  }
  
  $(".refreshemail").click(function () {
    $(".queryholderemail").val("");
    $("#maskemail").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3,
    });
    fetchemaildata(currentPage,pageLimit)
  });
  

  $(".playeremail").click(function () {
      let direction = $(this).val();
      const tableWrapper = $(".table-wrapperemail");
      const tableWrappers = document.querySelector(".table-wrapperemail");
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

  $(document).on('click', '.executeemail', function () {
  if ($(".selectemailprovider").val() == "" && $(".emailstatus").val() == "" && $(".startemail").val() == "") {
    showToast("Heads up!!","Select one or more data fields to filter","info")
    return;
  }
  const emailprovider = $(".selectemailprovider").val();
  const emailstatus = $(".emailstatus").val()
  const startemail = $(".startemail").val();
  const endemail = $(".endemail").val();
 //  console.log(emailprovider,emailstatus,startemail,endemail)
  filteremail(emailprovider,emailstatus,startemail,endemail,currentPage,pageLimit)

  $(".loaderemail").removeClass('bx-check-double').addClass('bx-loader bx-spin');

  });

  $(document).on('click', '#addemailplatform', function () {
      $("#emailmodal").modal("show");  
  })

  $(document).on('click', '#addemailsettings', function () {
    $.post(`../admin/savesemailstaes`, function (response) {
      // console.log(response);
      //  return
        let data = typeof response === "string" ? JSON.parse(response)[0] : response;
  
        $(".depositSwitch").prop("checked", data.deposit == 1);
        $("#withdrawSwitch").prop("checked", data.withdraw == 1);
        // $("#securitySwitch").prop("checked", data.security == 1);
        // $("#promoSwitch").prop("checked", data.promo == 1);
          $("#gameSwitch").prop("checked", data.gamewon == 1);
        // $("#vipSwitch").prop("checked", data.vip == 1);
        $("#provider").val(data.email_provider);

        // Save to localStorage
        const savedPrefs = {
            provider: data.email_provider,
            deposit: data.deposit == 1,
            withdraw: data.withdraw == 1,
            // security: data.security == 1,
            // promo: data.promo == 1,
            gamewon: data.gamewon == 1,
            // vip: data.vip == 1
        };
        localStorage.setItem("emailPreferences", JSON.stringify(savedPrefs));
    });

      $("#emailModalsettings").modal("show");
  });
    //add new email platform
  // $(document).on("click", ".saveemail", function () {
  //     if ($("#emailnameprovider").val() == "" || $("#partnameemail").val() == "") {
  //         showToast("Heads up!!","Select one or more data fields to filter","info")
  //         return;
  //       }
  //     const  emailprovider = $("#emailnameprovider").val()
  //     const sendename = $("#partnameemail").val()
  //     const approvedby = $(".approved").val()
    
  // //   $(".loaderemails").removeClass("bx-send").addClass("bx-loader-circle bx-spin loader")
  // //   $(".form-reset").val('');
  //   $.post(`../admin/addprovider/${emailprovider}/${sendename}`, function (response){
  //     const results = JSON.parse(response)
  //     //  console.log(results)
  //     if(results == "success"){
  //       $("#emailmodal").modal("hide"); 
  //       showToast("Heads up!!","Sms provider added successfully","success")
  //       fetchemailplatform(currentPage,pageLimit)
  //     }else{
  //       showToast("Heads up!!","Sms provider added successfully","info")
  //     }
  
  //   })

  
  // });
  
  //delete message
  $(document).on("click", ".deleteemail", function () {
      const emailid = $(this).attr("datas");
      $.post(`../admin/deleteemail/${emailid}`, function (response) {
      if (response) {
          showToast("Success",JSON.parse(response), "success");
          fetchPaymentPlatform(currentPage,pageLimit)
      } else {
          showToast("Heads up!!", "failed", "info");
      }
      });
  });

    //edit message
  $(document).on("click", ".editemail", function () {
      $("#editemailplatform").modal("show");
      const emailid = $(this).attr("datas");
      $.post(`../admin/editemail/${emailid}`, function (response) {
          const data = JSON.parse(response)[0];
          $("#maxiamounts").val(data.max_withdrawal);
          $("#minamount").val(data.max_deposit);
          $("#emailids").val(data.bankid);
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

  $(document).on("click", ".updateemailbtn", function () {
      const typecurrency = $(".typecurrency").val();
      const maxiamounts  = $("#maxiamounts").val();
      const minamount    = $("#minamount").val();
      const statecurrent = $(".statecurrent").val();
      const  emailids  = $("#emailids").val();
      $(".loaderemailanup").removeClass("bx-send").addClass("bx-loader-circle bx-spin loader");
      $.post(`../admin/updateplatform/${typecurrency}/${maxiamounts}/${minamount}/${statecurrent}/${emailids}`, 
      function (response) {
      $(".loaderemailanup").removeClass("bx-loader-circle bx-spin loader").addClass("bx-send");
      if (response) {
          showToast("Success", JSON.parse(response), "success");
          $("#editemailplatform").modal("hide");
          fetchPaymentPlatform(currentPage,pageLimit)
      } else {
          showToast("Heads up!!", JSON.parse(response), "info");
      }
      });
  });

  $(document).on("click", "#sendSMSBtn", function () {
    const emailload = {
            provider: $("#provider").val(),
            deposit: $(".depositSwitch").is(":checked"),
            withdraw: $("#withdrawSwitch").is(":checked"),
            // security: $("#securitySwitch").is(":checked"),
            // promo: $("#promoSwitch").is(":checked"),
              gamewon: $("#gameSwitch").is(":checked"),
            // vip: $("#vipSwitch").is(":checked")
        };
      //  localStorage.setItem("emailPreferences", JSON.stringify(emailload));
    // $(".loaderemailanup").removeClass("bx-send").addClass("bx-loader-circle bx-spin loader");

      $.ajax({
            url: `../admin/emailpreferences`,
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(emailload),
              success: function (response) {
              let res = typeof response === "string" ? JSON.parse(response) : response;
                if(res === "success"){
                  showToast("Heads up!!","Sms settings saved","success")
                  $("#emailModalsettings").modal("hide");
           
                }else{
                showToast("Heads up!!","Sms settings not saved","info")
                }
        
            },
        });

      
  });

  async function fetchemailprovider() {
        try {
            const response = await fetch(`../admin/fetchemailprovider`); // Await the fetch call

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const data = await response.json(); // Parse JSON response
           // console.log(data)
          // return
           
            let html = `<option value="">Sms Provider</option>`;
            data.forEach((emailprovider) => {
                html += `<option value="${emailprovider.email_provider}">${emailprovider.email_provider}</option>`;
            });
            $(".selectemailprovider").html(html);
        } catch (error) {
            console.error("Error fetching data:", error);
        }
  }
   fetchemailprovider();


    // function tableScrollemail() {
    //     const tableContaineremail= document.querySelector(".table-wrapperemail");
    //     const headerRowemail= document.querySelector(".emailheaderrow");

    //     tableContaineremail.addEventListener("scroll", function () {
    //         if (tableContaineremail.scrollTop > 0) {
    //             headerRowemail.classList.add("sticky-emailheader");
    //         } else {
    //             headerRowemail.classList.remove("sticky-emailheader");
    //         }
    //     });
    // }
    // tableScrollemail();

});
  