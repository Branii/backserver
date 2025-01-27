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
    const withdrawdata = (data) => { 
    
        let html = "";
       
      data.forEach((item) => {
      
          html += `
                      <tr>
                          <td>${item.withdrawal_id}</td>
                          <td>${item.username}</td>
                          <td>VIP</td>
                          <td>${item.bank_type}</td>
                          <td>${item.card_holder}</td>
                          <td>${item.bank_card_number}</td>
                          <td>${item.withdrawal_amount}</td>
                          <td>${item.actual_withdrawal_amount}</td>
                          <td>${item.withdrawal_application_time}</td>
                       <td>
                              <div class="dropdown">
                                    <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                     <i class='bx bx-dots-vertical-rounded'></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                      <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 " href="javascript:void(0);"data-bs-toggle="modal" data-bs-target="#signup">
                                        <i class="bx bx-show fs-5"></i>View
                                      </a>
                                      <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 viewquota" href="javascript:void(0);" data-rebate=""> 
                                        <i class="bx bx-show fs-5" ></i>Quota
                                      </a>
                                      <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
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
  
    const renderwithdraw = (data) => {
      var html = withdrawdata(data);
      $("#withdrawContainer").html(html);
    };
  
    let currentPagewithdraw = 1;
    let pageLimit =18;
  
    async function fetchwithdraw(pagewithdraw) {
      try {
        const response = await fetch(
          `../admin/fetchwithdraw/${pagewithdraw}/${pageLimit}`
        );
         const data = await response.json();
        //   console.log(response);
        //   return
        $("#maskwithdraw").LoadingOverlay("hide");
        renderwithdraw(data.withdraw);
  
        // // Render pagination
        renderwithdrawPagination(data.totalPages, pagewithdraw, 'normal');
         document.getElementById("paging_infowithdraw").innerHTML = 'Page ' + pagewithdraw + ' of ' + data.totalPages + ' pages'
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
  
    fetchwithdraw(currentPagewithdraw);
  

    function renderwithdrawPagination(totalPages, currentPagewithdraw) {
      let pagLink = `<ul class='pagination justify-content-end'>`;
    
      // Previous Button
      pagLink += `
        <li class='page-item ${currentPagewithdraw === 1 ? "disabled" : ""}'>
          <a class='page-link' href='#' data-page='${currentPagewithdraw - 1}'><i class='bx bx-chevron-left'></i></a>
        </li>
      `;
    
      // Page numbers with ellipsis
      for (let i = 1; i <= totalPages; i++) {
        if (i === currentPagewithdraw) {
          pagLink += `<li class='page-item active'><a class='page-link' href='#'>${i}</a></li>`;
        } else if (i === 1 || i === totalPages || Math.abs(i - currentPagewithdraw) <= 2) {
          pagLink += `<li class='page-item'><a class='page-link' href='#' data-page='${i}'>${i}</a></li>`;
        } else if (i === currentPagewithdraw - 3 || i === currentPagewithdraw + 3) {
          pagLink += `<li class='page-item disabled'><a class='page-link'>...</a></li>`;
        }
      }
    
      // Next Button
      pagLink += `
        <li class='page-item ${currentPagewithdraw === totalPages ? "disabled" : ""}'>
          <a class='page-link' href='#' data-page='${currentPagewithdraw + 1}'><i class='bx bx-chevron-right'></i></a>
        </li>
      `;
    
      pagLink += "</ul>";
      document.getElementById("paginationwithdraw").innerHTML = pagLink;
    
      // Add click event listeners to pagination links
      document.querySelectorAll("#paginationwithdraw .page-link").forEach((link) => {
        link.addEventListener("click", function (e) {
          e.preventDefault();
          const newPage = parseInt(this.getAttribute("data-page"));
          if (newPage > 0 && newPage <= totalPages && newPage !== currentPagewithdraw) {
            // Update currentPagewithdraw and display paging information
            currentPagewithdraw = newPage;
            document.getElementById("paging_infowithdraw").innerHTML = `Page ${currentPagewithdraw} of ${totalPages} pages`;
            
            // Fetch and render new page data
            fetchwithdraw(currentPagewithdraw);
          }
        });
      });
    }
  
    $(".refreshwithdrawa").click(function () {
     // $(".query").val("");
      $("#maskwithdraw").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3,
      });
      fetchwithdraw(currentPagewithdraw)
    });
  
   
    let debounceTimeout =null; // To store the timeout ID
    $(document).ready(function () {
        // Event listener for keyup
        $(document).on('keyup','#withdrawinput', function () {
            const query = $(this).val().trim();
    
            if (query.length > 2) { // Only trigger if input is more than 2 characters
                clearTimeout(debounceTimeout); // Clear any existing timeout
                debounceTimeout = setTimeout(() => {
                    // Call the filterUsers logic directly here
                    let optionsHtml = '';
    
                    $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
                        try {
                          console.log(response)
                            if (typeof response === 'string') {
                                response = JSON.parse(response); // Parse string response
                            }
    
                            if (Array.isArray(response)) {
                                const filteredUsers = response.filter(user =>
                                    user.username.toLowerCase().includes(query.toLowerCase())
                                );
                            
                                if (filteredUsers.length > 0) {
                                    filteredUsers.forEach(user => {
                                      optionsHtml += `<option class ="optionlist"  value="${user.uid}" data-username="${user.username}">${user.username}</option>`;
                                        // optionsHtml += `<li class="optionlist" data-username="${user.username}">${user.username}</li>`;
                                    });
    
                                    $('.withdrawDropdown').html(optionsHtml).show(); // Display dropdown with options
                                } else {
                                    $('.withdrawDropdown').hide(); // Hide dropdown if no users found
                                }
                            } else {
                                console.error("Invalid response format: ", response);
                                $('.withdrawDropdown').hide();
                            }
                        } catch (error) {
                            console.error("Error parsing response: ", error);
                            $('.withdrawDropdown').hide();
                        }
                    }).fail(function (error) {
                        console.error("Error fetching users: ", error);
                        $('.withdrawDropdown').hide();
                    });
                }, 500); // 500ms debounce delay
            } else {
                $('.withdrawDropdown').hide(); // Hide dropdown if input is less than 3 characters
            }
        });
    
        $(document).on('change', '.withdrawDropdown', function () {
            const selectedOption = $(this).find('option:selected'); // Get the selected <option>
            const selectedUserId = selectedOption.val(); // Get user ID from the value attribute
            const selectedUsername = selectedOption.data('username'); // Get username from data-attribute
        
            if (selectedUserId) {
                // Set input field to selected username
                $('#withdrawinput').val(selectedUsername); 
                // Set the user ID in the hidden field (if any)
                $('.userIdField').val(selectedUserId); 
                // Hide dropdown after selection
                $('.withdrawDropdown').hide(); 
                
                console.log(selectedUserId);
                console.log(`Selected Username: ${selectedUsername}`);
            } else {
                // Clear both username and user ID if no option is selected
                $('#withdrawinput').val(''); 
                $('.userIdField').val(''); // Assuming you're using a hidden input for the ID
                $('.withdrawDropdown').show(); // Keep the dropdown visible in case of clearing
                console.log('Selection cleared');
            }
        });
        $(document).on('input', '#withdrawinput', function () {
            const inputValue = $(this).val(); // Get the current value of the input
            if (!inputValue) {
                // If input is cleared, reset the user ID as well
                $('.userIdField').val('');
                console.log('User manually cleared the username');
            }
        });

        
    });
    
    



    $(".playerwithdraw").click(function () {
      let direction = $(this).val();
      const tableWrapper = $(".table-wrapperwithdraw");
      const tableWrappers = document.querySelector(".table-wrapperwithdraw");
      const scrollAmount = 1000; // Adjust as needed
      const scrollOptions = {
          behavior: "smooth",
      };
      if (tableWrapper.length) {
          switch (direction) {
              case "widrl-leftlinks":
                  tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
                  break;
              case "widrl-rightlinks":
                  tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
                  break;
              case "wdrl-starttrans":
                  // Scroll to the absolute start (leftmost position)
                  tableWrapper.animate({ scrollLeft: 0 }, "slow");
                  break;
              case "widrl-endlinks":
                  const maxScrollLeft = tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
                  tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
                  break;
              default:
                  break;
          }
      }
  });

    
  });
  