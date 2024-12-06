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
        html += `
                      <tr>
                      <td>${item.odds_group}</td>
                      <td>${item.rebate}</td>
                      <td class="editable">${item.finance}</td>
                      <td>
                        <button class="edit-btn btn btn-lights btn-sm" style="font-size:25px;cursor: pointer;"><i class='bx bxs-edit'></i></button>
                        <button class="update-btn btn btn-lighst btn-sm d-none" rebateid="${item.rebate_id}"><i class='bx bx-check-square' style="font-size:25px;"></i></button>
                        <button class="btn btn-sm btn-secondarys alt-btn"style="font-size:25px;cursor: pointer;"><i class='bx bx-message-square-x'></i></button> <!-- New button -->
                      </td>                       
                      </tr>
                  `;
      });
      return html;
    };
  
    const renderfinace = (data) => {
      var html = financeData(data);
      $("#financeContainer").html(html);
    };
  
    let currentPagefinance = 1;
    let pageLimit = 21;
  
    async function fetchfinance(pagefinance) {
      try {
        const response = await fetch(
          `../admin/fetchfinance/${pagefinance}/${pageLimit}`
        );
        const data = await response.json();
        // console.log(response);
        // return
        $("#maskfinance").LoadingOverlay("hide");
        renderfiance(data.finance);
  
        // // Render pagination
         renderPaginationfinance(data.totalPages, pagefinance, 'normal');
         document.getElementById("paging_infofinance").innerHTML = 'Page ' + pagefinance + ' of ' + data.totalPages + ' pages'
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
  
   // fetchfinance(currentPagefinance);
  
  
    $(".refreshfiance").click(function () {
      $(".query").val("");
      $("#maskfinance").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3,
      });
      fetchfinance(currentPagefinance)
    });
  
   
    let debounceTimeout =null; // To store the timeout ID
    $(document).ready(function () {
        // Event listener for keyup
        $(document).on('keyup','#financeinput', function () {
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
    
                                    $('.financeDropdown').html(optionsHtml).show(); // Display dropdown with options
                                } else {
                                    $('.financeDropdown').hide(); // Hide dropdown if no users found
                                }
                            } else {
                                console.error("Invalid response format: ", response);
                                $('.financeDropdown').hide();
                            }
                        } catch (error) {
                            console.error("Error parsing response: ", error);
                            $('.financeDropdown').hide();
                        }
                    }).fail(function (error) {
                        console.error("Error fetching users: ", error);
                        $('.financeDropdown').hide();
                    });
                }, 500); // 500ms debounce delay
            } else {
                $('.financeDropdown').hide(); // Hide dropdown if input is less than 3 characters
            }
        });
    
        $(document).on('change', '.financeDropdown', function () {
            const selectedOption = $(this).find('option:selected'); // Get the selected <option>
            const selectedUserId = selectedOption.val(); // Get user ID from the value attribute
            const selectedUsername = selectedOption.data('username'); // Get username from data-attribute
        
            if (selectedUserId) {
                // Set input field to selected username
                $('#financeinput').val(selectedUsername); 
                // Set the user ID in the hidden field (if any)
                $('.userIdField').val(selectedUserId); 
                // Hide dropdown after selection
                $('.financeDropdown').hide(); 
                
                console.log(selectedUserId);
                console.log(`Selected Username: ${selectedUsername}`);
            } else {
                // Clear both username and user ID if no option is selected
                $('#financeinput').val(''); 
                $('.userIdField').val(''); // Assuming you're using a hidden input for the ID
                $('.financeDropdown').show(); // Keep the dropdown visible in case of clearing
                console.log('Selection cleared');
            }
        });
        $(document).on('input', '#financeinput', function () {
            const inputValue = $(this).val(); // Get the current value of the input
            if (!inputValue) {
                // If input is cleared, reset the user ID as well
                $('.userIdField').val('');
                console.log('User manually cleared the username');
            }
        });

        
    });
    
        
      
  });
  