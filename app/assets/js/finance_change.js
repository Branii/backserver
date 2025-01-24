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
    const FinanceData = (data) => {
      let html = "";

  
      data.forEach((item) => {
        let total_income = item.deposit_withdrawal_type == 1 ? `+${item.deposit_and_withdrawal_amount}` :
        item.deposit_withdrawal_type == 4 ? `-${item.deposit_and_withdrawal_amount}` : 0;

          let types = item.deposit_withdrawal_type == 1 ? 'Deposit' :
          item.deposit_withdrawal_type == 4 ? 'Withdrawal' : '';
          let username = item.reg_type === "email" ? item.email : (item.reg_type === "username" ? item.username : item.contact);

        html += `
                      <tr>
                 <td>${typeof username === "string" || typeof username === "number" 
    ? String(username).charAt(0).toUpperCase() + String(username).slice(1) 
    : "N/A"}</td>
                      <td>VIP</td>
                      <td class="editables">${types}</td>
                      <td class="editables">${total_income}</td>
                      <td class="editables">${item.recharge_balance_in_advance}</td>
                      <td class="editables">${item.date_created +' '+item.deposit_and_withdrawal_time}</td>
                      <td class="editables">${item.remark}</td>
                                          
                      </tr>
                  `;
      });
      return html;
    };
  
    const renderfinace = (data) => {
      var html = FinanceData(data);
      $("#financeContainer").html(html);
    };
  
    let currentPage = 1;
    let pageLimit = 50;
  
    async function fetchfinance(page,pageLimit) {
      try {
        const response = await fetch(
          `../admin/fetchfinance/${page}/${pageLimit}`
        );
        const data = await response.json();
    
        $("#maskfinance").LoadingOverlay("hide");
        renderfinace(data.finance);
        renderfinacePagination(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchfinance(newPage, pageLimit));
        document.getElementById("paging_infofinance").innerHTML = "Page " + page + " of " + data.totalPages + " pages";
    
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
  
    fetchfinance(currentPage,pageLimit);
  
    // function renderfinacePagination(totalPages, currentPagefinance, fetchCallback) {
    //   let pagLink = `<ul class='pagination justify-content-end'>`;
    
    //   // Previous Button
    //   pagLink += `
    //     <li class='page-item ${currentPagefinance === 1 ? "disabled" : ""}'>
    //       <a class='page-link' href='#' data-page='${currentPagefinance - 1}'><i class='bx bx-chevron-left'></i></a>
    //     </li>
    //   `;
    
    //   // Page numbers with ellipsis
    //   for (let i = 1; i <= totalPages; i++) {
    //     if (i === currentPagefinance) {
    //       pagLink += `<li class='page-item active'><a class='page-link' href='#'>${i}</a></li>`;
    //     } else if (i === 1 || i === totalPages || Math.abs(i - currentPagefinance) <= 2) {
    //       pagLink += `<li class='page-item'><a class='page-link' href='#' data-page='${i}'>${i}</a></li>`;
    //     } else if (i === currentPagefinance - 3 || i === currentPagefinance + 3) {
    //       pagLink += `<li class='page-item disabled'><a class='page-link'>...</a></li>`;
    //     }
    //   }
    
    //   // Next Button
    //   pagLink += `
    //     <li class='page-item ${currentPagefinance === totalPages ? "disabled" : ""}'>
    //       <a class='page-link' href='#' data-page='${currentPagefinance + 1}'><i class='bx bx-chevron-right'></i></a>
    //     </li>
    //   `;
    
    //   pagLink += "</ul>";
    //   document.getElementById("paginationfiance").innerHTML = pagLink;
    
    //   // Add click event listeners to pagination links
    //   document.querySelectorAll("#paginationfiance .page-link").forEach((link) => {
    //     link.addEventListener("click", function (e) {
    //       e.preventDefault();
    //       const newPage = parseInt(this.getAttribute("data-page"));
    //       if (newPage > 0 && newPage <= totalPages && newPage !== currentPagefinance) {
    //         fetchCallback(newPage); // Call the provided fetch function with the new page number
    //       }
    //     });
    //   });
    // }

    function renderfinacePagination(totalPages, currentPage, pageLimit, callback) {
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

      document.getElementById("paginationfiance").innerHTML = pagLink;

      // Add click event listeners
      document.querySelectorAll("#paginationfiance .page-link").forEach((link) => {
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

    
    $(".refreshfiance").click(function () {
      $(".queryholderlistt").val("");
      $("#maskfinance").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3,
      });
      fetchfinance(currentPage,pageLimit)
    });
  
  
  
    //search function

    function filterfinance(username, depositestate, startfinance, endfinance, currentPage, pageLimit) {
      $.post(
        `../admin/filterdeposit/${username}/${depositestate}/${startfinance}/${endfinance}/${currentPage}/${pageLimit}`,
        function (response) {
          try {
            const data = JSON.parse(response);
            //  console.log(data)
            //  return
            if (data.deposits.length < 1) {
              $("#financeContainer").html(`
                <tr class="no-results">
                  <td colspan="9">
                    <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                  </td>
                </tr>
              `);
              return;
            }
            $("#maskfinance").LoadingOverlay("hide");
             renderfinace(data.deposits);
          // Render pagination
          renderfinacePagination(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => filterfinance(username, depositestate, startfinance, endfinance, newPage, pageLimit));
          document.getElementById("paging_infofinance").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
    
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

    $(document).on('click', '.executefinance', function () {
    
      if ($("#financeDropdown").val() == "" && $(".depositestate").val() == "" && $(".startfinance").val() == "" ) {
        // $("#danger-finance").modal("show");
        showToast("Heads up!!","Select one or more data fields to filter","info")
        return;
    }
  
      const depositestate = $(".depositestate").val();
      const username = $("#financeDropdown").val();
      const startfinance = $(".startfinance").val();
      const endfinance = $(".endfinance").val();
      console.log(username)
   
     filterfinance(username,depositestate,startfinance,endfinance,currentPage,pageLimit)
      // Show loader
      $(".loaderfinance").removeClass('bx-check-double').addClass('bx-loader bx-spin');
  
    });
  

      
    let debounceTimeout = null;
    $(document).ready(function () {
        // Event listener for keyup on #myInput
        $(document).on('keyup', '#financeinput', function () {
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
                $('#financeinput').val(selectedUsername);
                $('.userIdFields').val(selectedUserId);
                $('.financeDropdowns').hide();
            }
        });
    
        // Handle manual input clearing
        $(document).on('input', '#financeDropdowns', function () {
            if (!$(this).val()) {
                $('.userIdFields').val(''); // Reset user ID if input is cleared
            }
        });
    });
    
    // Function to fetch and display users
    function fetchUserss(query) {
        let optionsHtml = '';
    
        $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
            try {
                response = typeof response === 'string' ? JSON.parse(response) : response;

                console.log(response);
              
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
            }
          
              // Append the option to the optionsHtml string
              optionsHtml += `<option class="optioknlist" value="${user.uid}" data-usernames="${regname}">${displayValue}</option>`;
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
    

    //add money
    $(document).on("click", ".addmoneybtn", function () {
      const depositype =$(".depositt").val()
      const usernames = $(".userIdFields").val();
      const amount = $(".amount").val();
      const review = $(".review").val();

  
      if (amount === "" || review === "" || usernames === "") {
        showToast("Heads up!!", "All field are required", "info");
        return false;
      }
      $(".loaderfinance").removeClass("bx-send").addClass("bx-loader-circle bx-spin loader")
      $.post(`../admin/addmoney/${depositype}/${usernames}/${amount}/${review}`,
        function (response) {
          if (response) {
            $(".loaderfinance").removeClass("bx-loader-circle bx-spin loader").addClass("bx-send")
            showToast("Success", "transaction perform success", "success");
            fetchfinance(currentPagefinance);
          } else {
            showToast("Heads up!!","transaction failed", "info");
          }
        }
      );
    });
    


    //modal 
    
    $(document).on('click','.showmodal',function(){
      $("#addfinancemodal").modal("show");   
    })
    let debounceTimeouts = null;
    $(document).ready(function () {
        // Event listener for keyup on #myInput
        $(document).on('keyup', '#financeDropdown', function () {
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
                $('#financeDropdown').val(selectedUsername);
                $('.userIdfinance').val(selectedUserId);
                $('.financeDropdown').hide();
            }
        });
    
        // Handle manual input clearing
        $(document).on('input', '#financeDropdown', function () {
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
                    optionsHtml += `<option class="optlpionlist" value="${user.uid}" data-username="${regnames}">${displayValues}</option>`;
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

    $(".numrowsfinance").change(function () {
      $("#maskfinance").LoadingOverlay("show", {
          background: "rgb(90,106,133,0.1)",
          size: 3,
        });
      const numrows = $(this).val();
      fetchfinance(currentPage,numrows)
     });


    function tableScrollFinance() {
      const tableContainerFinance= document.querySelector(".table-wrapperfinance");
      const headerRowFinance= document.querySelector(".financeheadrow");

      tableContainerFinance.addEventListener("scroll", function () {
          if (tableContainerFinance.scrollTop > 0) {
              headerRowFinance.classList.add("sticky-financehead");
          } else {
              headerRowFinance.classList.remove("sticky-financehead");
          }
      });
   }
   tableScrollFinance();
  });
  