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
          const username = item.username === '*****' ? item.email : (item.contact ||item.username);

        html += `
                      <tr>
                      <td>${username}</td>
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
  
    let currentPagefinance = 1;
    let pageLimit = 25;
  
    async function fetchfinance(pagefinance) {
      try {
        const response = await fetch(
          `../admin/fetchfinance/${pagefinance}/${pageLimit}`
        );
         const data = await response.json();
        //  console.log(response);
        //  return
        $("#maskfinance").LoadingOverlay("hide");
        renderfinace(data.finance);
  
        // // Render pagination
        renderfinacePagination(data.totalPages, pagefinance, 'normal');
         document.getElementById("paging_infofinance").innerHTML = 'Page ' + pagefinance + ' of ' + data.totalPages + ' pages'
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
  
    fetchfinance(currentPagefinance);
  

    function renderfinacePagination(totalPages, currentPagefinace,username, depositestate,startfinance,endfinance) {
      let pagLink = `<ul class='pagination justify-content-end'>`;
    
      // Previous Button
      pagLink += `
        <li class='page-item ${currentPagefinace === 1 ? "disabled" : ""}'>
          <a class='page-link' href='#' data-page='${currentPagefinace - 1}'><i class='bx bx-chevron-left'></i></a>
        </li>
      `;
    
      // Page numbers with ellipsis
      for (let i = 1; i <= totalPages; i++) {
        if (i === currentPagefinace) {
          pagLink += `<li class='page-item active'><a class='page-link' href='#'>${i}</a></li>`;
        } else if (i === 1 || i === totalPages || Math.abs(i - currentPagefinace) <= 2) {
          pagLink += `<li class='page-item'><a class='page-link' href='#' data-page='${i}'>${i}</a></li>`;
        } else if (i === currentPagefinace - 3 || i === currentPagefinace + 3) {
          pagLink += `<li class='page-item disabled'><a class='page-link'>...</a></li>`;
        }
      }
    
      // Next Button
      pagLink += `
        <li class='page-item ${currentPagefinace === totalPages ? "disabled" : ""}'>
          <a class='page-link' href='#' data-page='${currentPagefinace + 1}'><i class='bx bx-chevron-right'></i></a>
        </li>
      `;
    
      pagLink += "</ul>";
      document.getElementById("paginationfiance").innerHTML = pagLink;
    
      // Add click event listeners to pagination links
      document.querySelectorAll("#paginationfiance .page-link").forEach((link) => {
        link.addEventListener("click", function (e) {
          e.preventDefault();
          const newPage = parseInt(this.getAttribute("data-page"));
          if (newPage > 0 && newPage <= totalPages && newPage !== currentPagefinace) {
            // Update currentPagefinace and display paging information
            // currentPagefinace = newPage;
            document.getElementById("paging_infofinance").innerHTML = `Page ${currentPagefinace} of ${totalPages} pages`;
            
            // Fetch and render new page data
            fetchfinance(newPage,username, depositestate,startfinance,endfinance);
          }
        });
      });
    }
  
    $(".refreshfiance").click(function () {
     // $(".query").val("");
      $("#maskfinance").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3,
      });
      fetchfinance(currentPagefinance)
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
    
                const filteredUsers = response.flatMap(item => [
                    { "uid": item.uid, "username": item.username },
                    { "uid": item.uid, "username": item.email},
                    { "uid": item.uid, "username": item.contact}
                ]).filter(user => user.username !== '*****');
    
                filteredUsers.forEach(user => {
                    optionsHtml += `<option class="optionlist" value="${user.uid}" data-usernames="${user.username}">${user.username}</option>`;
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
    
                const filteredUsers = response.flatMap(item => [
                    { "uid": item.uid, "username": item.username },
                    { "uid": item.uid, "username": item.email },
                    { "uid": item.uid, "username": item.contact}
                ]).filter(user => user.username !== '*****');
    
                filteredUsers.forEach(user => {
                    optionsHtml += `<option class="optionlist" value="${user.uid}" data-username="${user.username}">${user.username}</option>`;
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

    //search function


    $(document).on('click', '.executefinance', function () {

      const financeDropdown = $("#financeDropdown").val();
      const depositestate = $(".depositestate").val();
      
      // Show modal if required fields are empty
      if (!financeDropdown && !depositestate) {
          $("#danger-finance").modal("show");
          return;
      }
  
      const username = $(".userIdfinance").val();
      const startfinance = $(".startfinance").val();
      const endfinance = $(".endfinance").val();
  
      // Show loader
      $(".loaderfinance").removeClass('bx-check-double').addClass('bx-loader bx-spin');
  
      // Request data from server
      $.post(`../admin/filterdeposit/${username}/${depositestate}/${startfinance}/${endfinance}/${currentPagefinance}/${pageLimit}`, 
        function(response) {
          console.log(response)
  
          try {
              const data = JSON.parse(response); // Parse the response
  
              // If no deposits, show a 'no results' message
              if (data.deposit.length < 1) {
                  $("#financeContainer").html(`
                      <tr class="no-results">
                          <td colspan="9">
                              <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                          </td>
                      </tr>
                  `);
                  return;
              }
  
              // Render results and pagination
              renderfinace(data.deposit);
              renderfinacePagination(data.totalPages,currentPagefinance,username, depositestate,startfinance,endfinance);
              document.getElementById("paging_infobet").innerHTML = `Page ${currentPagefinance} of ${data.totalPages} pages`;
  
          } catch (error) {
              console.error("Error parsing JSON response:", error);
          } finally {
              // Hide loader after completion
              $(".loaderfinance").removeClass("bx-loader bx-spin").addClass("bx-check-double");
          }
  
      }).fail(function (error) {
          console.error("Error fetching data:", error);
          $(".loaderfinance").removeClass("bx-loader bx-spin").addClass("bx-check-double");
      });
    });
  
    
    
  });
  