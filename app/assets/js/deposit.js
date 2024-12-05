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
    const Depositdata = (data) => { 
    
        let html = "";
       
      data.forEach((item) => {
      
          html += `
                      <tr>
                          <td>${item.payment_reference}</td>
                          <td>${item.user_name}</td>
                          <td>VIP</td>
                          <td>${item.momo_provider}</td>
                          <td>${item.amount_paid}</td>
                          <td>${item.amount_paid}</td>
                          <td>${item.date_created + '/' + item.time_created}</td>
                          <td>${item.momo_provider}</td>
                           <td>${item.user_mobile}</td>
                          
                      </tr>
                  `;
        });
        return html;
      };
  
    const renderdeposit = (data) => {
      var html = Depositdata(data);
      $("#DepositContainer").html(html);
    };
  
    let currentPageDeposit = 1;
    let pageLimit =17;
  
    async function fetchDeposit(pageDeposit) {
      try {
        const response = await fetch(
          `../admin/fetchDeposit/${pageDeposit}/${pageLimit}`
        );
         const data = await response.json();
        //  console.log(response);
        //  return
        $("#maskDeposit").LoadingOverlay("hide");
        renderdeposit(data.deposit);
  
        // // Render pagination
        renderdepositPagination(data.totalPages, pageDeposit, 'normal');
         document.getElementById("paging_infodeposit").innerHTML = 'Page ' + pageDeposit + ' of ' + data.totalPages + ' pages'
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
  
    fetchDeposit(currentPageDeposit);
  

    function renderdepositPagination(totalPages, currentPagedeposit) {
      let pagLink = `<ul class='pagination justify-content-end'>`;
    
      // Previous Button
      pagLink += `
        <li class='page-item ${currentPagedeposit === 1 ? "disabled" : ""}'>
          <a class='page-link' href='#' data-page='${currentPagedeposit - 1}'><i class='bx bx-chevron-left'></i></a>
        </li>
      `;
    
      // Page numbers with ellipsis
      for (let i = 1; i <= totalPages; i++) {
        if (i === currentPagedeposit) {
          pagLink += `<li class='page-item active'><a class='page-link' href='#'>${i}</a></li>`;
        } else if (i === 1 || i === totalPages || Math.abs(i - currentPagedeposit) <= 2) {
          pagLink += `<li class='page-item'><a class='page-link' href='#' data-page='${i}'>${i}</a></li>`;
        } else if (i === currentPagedeposit - 3 || i === currentPagedeposit + 3) {
          pagLink += `<li class='page-item disabled'><a class='page-link'>...</a></li>`;
        }
      }
    
      // Next Button
      pagLink += `
        <li class='page-item ${currentPagedeposit === totalPages ? "disabled" : ""}'>
          <a class='page-link' href='#' data-page='${currentPagedeposit + 1}'><i class='bx bx-chevron-right'></i></a>
        </li>
      `;
    
      pagLink += "</ul>";
      document.getElementById("paginationdeposit").innerHTML = pagLink;
    
      // Add click event listeners to pagination links
      document.querySelectorAll("#paginationdeposit .page-link").forEach((link) => {
        link.addEventListener("click", function (e) {
          e.preventDefault();
          const newPage = parseInt(this.getAttribute("data-page"));
          if (newPage > 0 && newPage <= totalPages && newPage !== currentPagedeposit) {
            // Update currentPagedeposit and display paging information
            currentPagedeposit = newPage;
            document.getElementById("paging_infodeposit").innerHTML = `Page ${currentPagedeposit} of ${totalPages} pages`;
            
            // Fetch and render new page data
            fetchDeposit(currentPagedeposit);
          }
        });
      });
    }
  
    $(".refreshdeposit").click(function () {
     // $(".query").val("");
      $("#maskDeposit").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3,
      });
      fetchDeposit(currentPageDeposit)
    });
  
   
    let debounceTimeout =null; // To store the timeout ID
    $(document).ready(function () {
        // Event listener for keyup
        $(document).on('keyup','#Depositinput', function () {
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
    
                                    $('.DepositDropdown').html(optionsHtml).show(); // Display dropdown with options
                                } else {
                                    $('.DepositDropdown').hide(); // Hide dropdown if no users found
                                }
                            } else {
                                console.error("Invalid response format: ", response);
                                $('.DepositDropdown').hide();
                            }
                        } catch (error) {
                            console.error("Error parsing response: ", error);
                            $('.DepositDropdown').hide();
                        }
                    }).fail(function (error) {
                        console.error("Error fetching users: ", error);
                        $('.DepositDropdown').hide();
                    });
                }, 500); // 500ms debounce delay
            } else {
                $('.DepositDropdown').hide(); // Hide dropdown if input is less than 3 characters
            }
        });
    
        $(document).on('change', '.DepositDropdown', function () {
            const selectedOption = $(this).find('option:selected'); // Get the selected <option>
            const selectedUserId = selectedOption.val(); // Get user ID from the value attribute
            const selectedUsername = selectedOption.data('username'); // Get username from data-attribute
        
            if (selectedUserId) {
                // Set input field to selected username
                $('#Depositinput').val(selectedUsername); 
                // Set the user ID in the hidden field (if any)
                $('.userIdField').val(selectedUserId); 
                // Hide dropdown after selection
                $('.DepositDropdown').hide(); 
                
                console.log(selectedUserId);
                console.log(`Selected Username: ${selectedUsername}`);
            } else {
                // Clear both username and user ID if no option is selected
                $('#Depositinput').val(''); 
                $('.userIdField').val(''); // Assuming you're using a hidden input for the ID
                $('.DepositDropdown').show(); // Keep the dropdown visible in case of clearing
                console.log('Selection cleared');
            }
        });
        $(document).on('input', '#Depositinput', function () {
            const inputValue = $(this).val(); // Get the current value of the input
            if (!inputValue) {
                // If input is cleared, reset the user ID as well
                $('.userIdField').val('');
                console.log('User manually cleared the username');
            }
        });

        
    });
    



    
  });
  