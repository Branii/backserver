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
    const AnnoucementData = (data) => {
      let html = "";

      data.forEach((item) => {
        // let total_income = item.deposit_withdrawal_type == 1 ? `+${item.deposit_and_withdrawal_amount}` :
        // item.deposit_withdrawal_type == 4 ? `-${item.deposit_and_withdrawal_amount}` : 0;

           let messagetype =  (item.ms_type == "general") ? "Announcement" : (item.ms_type == "personal")? "Notification" : (item.ms_type == "users")? "Notification" : "";
        //   item.deposit_withdrawal_type == 4 ? 'Withdrawal' : '';
        //   let username = item.reg_type === "email" ? item.email : (item.reg_type === "username" ? item.username : item.contact);

        html += `
                      <tr>
                        <td>${item.title}</td>
                        <td style ="max-width: 300px;word-wrap: break-word;overflow-wrap: break-word; white-space: normal;">${item.content}</td>
                        <td>${item.created_at}</td>
                        <td>${messagetype}</td>
                        <td>${item.audience}</td> 
                        <td>${item.send_by}</td>     
                        <td>
                          
                      <div class="dropdown">
                            <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                              <i class='bx bx-dots-vertical-rounded'></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                            
                              <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 viewquota" href="javascript:void(0);" datas ="${item.msg_id}"> 
                                <i class="bx bx-edit fs-5" ></i>Edit
                              </a>
                              
                                <a class="dropdown-item deletemessage cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);" datas="${item.msg_id}">
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
  
    const rendermessage = (data) => {
      var html = AnnoucementData(data);
      $("#messagecontainer").html(html);
    };
  
    let currentPage = 1;
    let pageLimit = 20;
  
    async function fetchmessage(page,pageLimit) {
      try {
        const response = await fetch(`../admin/fetchmessage/${page}/${pageLimit}`);
        const data = await response.json();
      // console.log(data);
        $("#maskfinances").LoadingOverlay("hide");
        rendermessage(data.messages);
        renderfinacePaginations(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchmessage(newPage, pageLimit));
        document.getElementById("paging_infofmessage").innerHTML = "Page " + page + " of " + data.totalPages + " pages";
    
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
  
    fetchmessage(currentPage,pageLimit);
  

    function renderfinacePaginations(totalPages, currentPage, pageLimit, callback) {
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

      document.getElementById("paginationmessage").innerHTML = pagLink;
      // Add click event listeners
      document.querySelectorAll("#paginationmessage .page-link").forEach((link) => {
          link.addEventListener("click", function (e) {
              e.preventDefault();
              const newPage = +this.getAttribute("data-page");
              if (newPage > 0 && newPage <= totalPages) {
                  $("#maskfinance").LoadingOverlay("show", {
                      background: "rgb(90,106,133,0.1)",
                      size: 3,
                  });
                  callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
              }
          });
      });
  }

    
    $(".refreshmessage").click(function () {
      $(".queryholderlistt").val("");
      $("#maskfinances").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3,
      });
      fetchmessage(currentPage,pageLimit)
    });
  
  
  
    //search function

    async function  filtermessage(username,messagestype,startfmessage,endmessage,currentPage,pageLimit) {
      $.post( `../admin/filtermessage/${username}/${messagestype}/${startfmessage}/${endmessage}/${currentPage}/${pageLimit}`,
        function (response) {
          try {
            const data = JSON.parse(response);
              console.log(data)
           //   return
            $(".loaderfinanccs").removeClass("bx-loader bx-spin").addClass("bx-check-double");
            if (data.message.length < 1) {
              $("#messagecontainer").html(`
                <tr class="no-results">
                  <td colspan="9">
                    <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                  </td>
                </tr>
              `);
              return;
            }
            $("#maskfinances").LoadingOverlay("hide");
            rendermessage(data.message);
          // Render pagination
          renderfinacePaginations(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) =>  filtermessage(username,messagestype,startfmessage,endmessage,newPage,pageLimit));
          document.getElementById("paging_infofmessage").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
    
          } catch (error) {
            console.error("Error parsing JSON response:", error);
          } finally {
            $(".loaderfinance").removeClass("bx-loader bx-spin").addClass("bx-check-double");
          }
        }
      ).fail(function (error) {
        console.error("Error fetching data:", error);
        $(".loaderfinance").removeClass("bx-loader bx-spin").addClass("bx-check-double");
      });
    }

     $(document).on('click', '.executemessage', function () {
    
      if ($("#financeDropdownl").val() == "" && $(".messagestype").val() == "" && $(".startfmessage").val() == "" ) {
        // $("#danger-finance").modal("show");
        showToast("Heads up!!","Select one or more data fields to filter","info")
        return;
    }
  
      const messagestype = $(".messagestype").val();
      const username = $("#financeDropdownl").val();
      const startfmessage = $(".startfmessage").val();
      const endmessage = $(".endmessage").val();

      console.log(username+messagestype+startfmessage+endmessage)
    //   return
   
    filtermessage(username,messagestype,startfmessage,endmessage,currentPage,pageLimit)
    //   // Show loader
       $(".loaderfinanccs").removeClass('bx-check-double').addClass('bx-loader bx-spin');
  
     });
  

      
    let debounceTimeout = null;
    $(document).ready(function () {
        // Event listener for keyup on #myInput
        $(document).on('keyup', '#financeinputl', function () {
            const query = $(this).val().trim();
    
            // Only trigger if input is more than 2 characters
            if (query.length > 1) {
                clearTimeout(debounceTimeout); // Clear any existing timeout
                debounceTimeout = setTimeout(fetchUserss, 500, query); // Call fetchUsers with the query after 500ms delay
            } else {
                $('.financeDropdowns').hide(); // Hide dropdown if input is less than 3 characters
            }
        });
    
        // Handle dropdown item selection
        $(document).on('change', '.financeDropdowns', function () {
            const selectedOption = $(this).find('option:selected');
            const selectedUserId = selectedOption.val();
            const selectedUsername = selectedOption.data('usernames');
    
            if (selectedUserId) {
                $('#financeinputl').val(selectedUsername);
                $('.userIdFieldss').val(selectedUserId);
                $('.financeDropdowns').hide();
            }
        });
    
        $(document).on("click", function (e) {
          const $dropdownbet = $("#userfinaceDropdownl");
          if (!$(e.target).closest("#financeinputl, #userfinaceDropdownl").length) {
              $dropdownbet.hide();
          }
      });
        // Handle manual input clearing
        $(document).on('input', '#financeinputl', function () {
            if (!$(this).val()) {
                $('.userIdFieldss').val(''); // Reset user ID if input is cleared
            }
        });
    });
    
    // Function to fetch and display users
    function fetchUserss(query) {
        let optionsHtml = '';
    
        $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
            try {
                response = typeof response === 'string' ? JSON.parse(response) : response;

           //     console.log(response);
              
          response.forEach(user => {
           let   displayValue;
           let regname;
            // Display based on regtype
            if (user.regtype === "email") {
               displayValue = user.email;
               regname = user.email;  // Show email
            } else if (user.regtype === "username") {
              displayValue = user.username;
              regname = user.username;  // Show username
            } else if (user.regtype === "contact") {
              displayValue = user.contact;
              regname  = user.contact;  // Show contact
            }else{
              displayValue = 'no data found ...';
              regname = 'no data found ...';  // Show contact
             }
          
              // Append the option to the optionsHtml string
              optionsHtml += `<option class="optionlist" value="${user.uid}" data-usernames="${regname}">${displayValue}</option>`;
          });
                $('.financeDropdowns').html(optionsHtml).show();
            } catch (error) {
                console.error("Error parsing response: ", error);
                $('.financeDropdowns').hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $('.financeDropdowns').hide();
        });
    }

     $('.messagetype').on('change', function () {
      if ($(this).val() === 'personal') {
          $('#financeinputl').parent().show(); 
      } else {
          $('#financeinputl').parent().hide(); 
          $(".userIdFieldss, #financeinputl").val(''); 
      }
     }).trigger('change'); 

    //add annoucement
    $(document).on("click", ".sendmessagebtn", function () {
      // const financeinputl = $("#financeinputl").val()
      const messagetype = $(".messagetype").val()
      const messagetitle = $("#note-has-title").val()
      const usernames = $(".userIdFieldss").val();
      const description = encodeURIComponent($("#description").val());
      const sendby = $(".sendby").val()
     console.log(usernames + "" + messagetype +""+messagetitle +""+description+""+sendby)
      //return
       if (messagetitle === "" || description === "" || sendby === "") {
         showToast("Heads up!!", "All field are required", "info");
         return false;
        }
      // $("#addfinancemodal").modal("hide"); 
      $("#announcementemodal").modal("hide");  
        $(".userIdFieldss, #note-has-title,#description,#financeinputl").val(''); 
       $(".loaderfinancc").removeClass("bx-send").addClass("bx-loader-circle bx-spin loader")
       $.post(`../admin/annoucement/${messagetype}/${messagetitle}/${usernames}/${description}/${sendby}`,
        function (response) {
         // console.log(response.success);
         // console.log(response)
           if (response) {
             $(".loaderfinancc").removeClass("bx-loader-circle bx-spin loader").addClass("bx-send")  
             showToast("Success", response, "success");
             fetchmessage(currentPage,pageLimit)
           } else {
             showToast("Heads up!!","failed", "info");
           }
        }
      );
    });
    
   //delete message

   
    $(document).on('click','.deletemessage',function(){
      const messageid =  $(this).attr("datas");
     // console.log(messageid);
      $.post(`../admin/deleteannoucement/${messageid}`,
        function (response) {
         // console.log(response.success);
          //console.log(response)
           if (response) {
             showToast("Success", response, "success");
             fetchmessage(currentPage,pageLimit)        
           } else {
             showToast("Heads up!!","failed", "info");
           }
        }
      );
    })

    //modal 
    
    $(document).on('click','.messagemodal',function(){
      $("#announcementemodal").modal("show");   
    })

    let debounceTimeouts = null;
    $(document).ready(function () {
        // Event listener for keyup on #myInput
        $(document).on('keyup', '#financeDropdownl', function () {
            const query = $(this).val().trim();
    
            // Only trigger if input is more than 2 characters
            if (query.length > 1) {
                clearTimeout(debounceTimeouts); // Clear any existing timeout
                debounceTimeout = setTimeout(fetchUsers, 500, query); // Call fetchUsers with the query after 500ms delay
            } else {
                $('.financeDropdown').hide(); // Hide dropdown if input is less than 3 characters
            }
        });
    
        // Handle dropdown item selection
        $(document).on('change', '.financeDropdown', function () {
            const selectedOption = $(this).find('option:selected');
            const selectedUserId = selectedOption.val();
            const selectedUsername = selectedOption.data('username');
    
            if (selectedUserId) {
                $('#financeDropdownl').val(selectedUsername);
                $('.userIdfinance').val(selectedUserId);
                $('.financeDropdown').hide();
            }
        });

       $(document).on("click", function (e) {
          const $dropdownbet = $("#userfinaceDropdownsl");
          if (!$(e.target).closest("#financeDropdownl, #userfinaceDropdownsl").length) {
              $dropdownbet.hide();
          }
      });
        // Handle manual input clearing
        $(document).on('input', '#financeDropdownl', function () {
            if (!$(this).val()) {
                $('.userIdfinance').val(''); // Reset user ID if input is cleared
            }
        });
    });
    
    // Function to fetch and display users
    function fetchUsers(query) {
        let optionsHtml = '';
    
        $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
            try {
                response = typeof response === 'string' ? JSON.parse(response) : response;
                response.forEach(user => {
                  let   displayValues;
                  let regnames;
                   // Display based on regtype
                   if (user.regtype === "email") {
                      displayValues = user.email;
                      regnames = user.email;  // Show email
                   } else if (user.regtype === "username") {
                     displayValues = user.username;
                     regnames = user.username;  // Show username
                   } else if (user.regtype === "contact") {
                     displayValues = user.contact;
                     regnames  = user.contact;  // Show contact
                   }else{
                    displayValues = 'no data found ...';
                    regnames  = 'no data found ...';  // Show contact
                   }
                    optionsHtml += `<option class="optionlist" value="${user.uid}" data-username="${regnames}">${displayValues}</option>`;
                });
    
                $('.financeDropdown').html(optionsHtml).show();
            } catch (error) {
                console.error("Error parsing response: ", error);
                $('.financeDropdown').hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $('.financeDropdown').hide();
        });
    }

    $(".numrowsfinances").change(function () {
      $("#maskfinance").LoadingOverlay("show", {
          background: "rgb(90,106,133,0.1)",
          size: 3,
        });
      const numrows = $(this).val();
      fetchfinance(currentPage,numrows)
     });




    function tableScrollFinancess() {
      const tableContainerFinances= document.querySelector(".table-wrapperfinances");
      const headerRowFinances= document.querySelector(".financeheadrows");

      tableContainerFinances.addEventListener("scroll", function () {
          if (tableContainerFinances.scrollTop > 0) {
              headerRowFinances.classList.add("sticky-financeheads");
          } else {
              headerRowFinances.classList.remove("sticky-financeheads");
          }
      });
   }
   tableScrollFinancess();

   
  });
  