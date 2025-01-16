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
    const bankcarddata = (data) => { 
        
        const states = {
            0: "Not Active",
            1: "In Force",
            2: "Terminated",
            3: "Delete",
        
          };
        let html = "";
       
      data.forEach((item) => {
        const username = item.username == '*****' ? item.nickname : item.username;
      
          html += `
                      <tr>
                      
                          <td>${username}</td>
                          <td>${item.bank_type}</td>
                          <td>${item.account_name}</td>
                          <td>${item.card_number}</td>
                          <td>${item.withdrawal_count}</td>
                          <td>${item.bind_time}</td>
                          <td>${states[item.status]}</td> 
                      </tr>
                  `;
        });
        return html;
      };
  
    const renderbankcard = (data) => {
      var html = bankcarddata(data);
      $("#bankcardContainer").html(html);
    };
  
    let currentPagebankcard = 1;
    let pageLimit = 14;
  
    async function fetchbankcard(pagebankcard) {
      try {
        const response = await fetch(
          `../admin/fetchbankcard/${pagebankcard}/${pageLimit}`
        );
         const data = await response.json();
          // console.log(response);
        //   return
        $("#maskbanks").LoadingOverlay("hide");
        renderbankcard(data.bankcard);
  
        // // Render pagination
        renderbankcardPagination(data.totalPages, pagebankcard, 'normal');
         document.getElementById("paging_infobankcard").innerHTML = 'Page ' + pagebankcard + ' of ' + data.totalPages + ' pages'
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
  
    fetchbankcard(currentPagebankcard);
  

    function renderbankcardPagination(totalPages, currentPagebankcard) {
      let pagLink = `<ul class='pagination justify-content-end'>`;
    
      // Previous Button
      pagLink += `
        <li class='page-item ${currentPagebankcard === 1 ? "disabled" : ""}'>
          <a class='page-link' href='#' data-page='${currentPagebankcard - 1}'><i class='bx bx-chevron-left'></i></a>
        </li>
      `;
    
      // Page numbers with ellipsis
      for (let i = 1; i <= totalPages; i++) {
        if (i === currentPagebankcard) {
          pagLink += `<li class='page-item active'><a class='page-link' href='#'>${i}</a></li>`;
        } else if (i === 1 || i === totalPages || Math.abs(i - currentPagebankcard) <= 2) {
          pagLink += `<li class='page-item'><a class='page-link' href='#' data-page='${i}'>${i}</a></li>`;
        } else if (i === currentPagebankcard - 3 || i === currentPagebankcard + 3) {
          pagLink += `<li class='page-item disabled'><a class='page-link'>...</a></li>`;
        }
      }
    
      // Next Button
      pagLink += `
        <li class='page-item ${currentPagebankcard === totalPages ? "disabled" : ""}'>
          <a class='page-link' href='#' data-page='${currentPagebankcard + 1}'><i class='bx bx-chevron-right'></i></a>
        </li>
      `;
    
      pagLink += "</ul>";
      document.getElementById("paginationbankcard").innerHTML = pagLink;
    
      // Add click event listeners to pagination links
      document.querySelectorAll("#paginationbankcard .page-link").forEach((link) => {
        link.addEventListener("click", function (e) {
          e.preventDefault();
          const newPage = parseInt(this.getAttribute("data-page"));
          if (newPage > 0 && newPage <= totalPages && newPage !== currentPagebankcard) {
            // Update currentPagebankcard and display paging information
            currentPagebankcard = newPage;
            document.getElementById("paging_infobankcard").innerHTML = `Page ${currentPagebankcard} of ${totalPages} pages`;
            
            // Fetch and render new page data
            fetchbankcard(currentPagebankcard);
          }
        });
      });
    }
  
    $(".refreshbankcard").click(function () {
     // $(".query").val("");
      $("#maskbanks").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3,
      });
      fetchbankcard(currentPagebankcard)
    });
  
   
    let debounceTimeout =null; // To store the timeout ID
    $(document).ready(function () {
        // Event listener for keyup
        $(document).on('keyup','#bankcardinput', function () {
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
    
                                    $('.bankcardDropdown').html(optionsHtml).show(); // Display dropdown with options
                                } else {
                                    $('.bankcardDropdown').hide(); // Hide dropdown if no users found
                                }
                            } else {
                                console.error("Invalid response format: ", response);
                                $('.bankcardDropdown').hide();
                            }
                        } catch (error) {
                            console.error("Error parsing response: ", error);
                            $('.bankcardDropdown').hide();
                        }
                    }).fail(function (error) {
                        console.error("Error fetching users: ", error);
                        $('.bankcardDropdown').hide();
                    });
                }, 500); // 500ms debounce delay
            } else {
                $('.bankcardDropdown').hide(); // Hide dropdown if input is less than 3 characters
            }
        });
    
        $(document).on('change', '.bankcardDropdown', function () {
            const selectedOption = $(this).find('option:selected'); // Get the selected <option>
            const selectedUserId = selectedOption.val(); // Get user ID from the value attribute
            const selectedUsername = selectedOption.data('username'); // Get username from data-attribute
        
            if (selectedUserId) {
                // Set input field to selected username
                $('#bankcardinput').val(selectedUsername); 
                // Set the user ID in the hidden field (if any)
                $('.userIdField').val(selectedUserId); 
                // Hide dropdown after selection
                $('.bankcardDropdown').hide(); 
                
                console.log(selectedUserId);
                console.log(`Selected Username: ${selectedUsername}`);
            } else {
                // Clear both username and user ID if no option is selected
                $('#bankcardinput').val(''); 
                $('.userIdField').val(''); // Assuming you're using a hidden input for the ID
                $('.bankcardDropdown').show(); // Keep the dropdown visible in case of clearing
                console.log('Selection cleared');
            }
        });
        $(document).on('input', '#bankcardinput', function () {
            const inputValue = $(this).val(); // Get the current value of the input
            if (!inputValue) {
                // If input is cleared, reset the user ID as well
                $('.userIdField').val('');
                console.log('User manually cleared the username');
            }
        });

        
    });
    



    
  });
  