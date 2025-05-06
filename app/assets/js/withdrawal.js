$(function () {
  function tableScrollWithdraw() {
      const tableContainerFinanceWidrl = document.querySelector(".table-wrapperwithdraw");
      const headerRowFinanceWidrl = document.querySelector(".tbl-row-widrl");

      tableContainerFinanceWidrl.addEventListener("scroll", function () {
          if (tableContainerFinanceWidrl.scrollTop > 0) {
              headerRowFinanceWidrl.classList.add("sticky-table-head-widrl");
          } else {
              headerRowFinanceWidrl.classList.remove("sticky-table-head-widrl");
          }
      });
  }
  tableScrollWithdraw();

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
      const status = { 1: "Pending", 2: "Success", 3: "Failed" };
      const withdrawal_channel = { 3: "Momo", 5: "Crypto", 2: "Bank", 4: "Manual" }; // 3:momo 5:crypto 2:bank 4:manual
      
      data.forEach((item) => {
        let timezone = item.withdrawal_timezone.split(" ");
        timezone = timezone[0] + `<span style="margin-left: 1rem;">GMT${timezone[1]}</span>`;
          html += `
        <tr>
            <td>${item.withdrawal_id}</td>
            <td>${item.username}</td>
            <td>VIP</td>
            <td>${item.bank_type}</td>
            <td>${withdrawal_channel[item.withdrawal_channel]}</td>
            <td>${item.card_holder}</td>
            <td>${item.bank_card_number}</td>
            <td>${formatNumber(item.withdrawal_amount)}</td>
            <td>${formatNumber(item.fee)}</td>
            <td>${formatNumber(item.actual_withdrawal_amount)}</td>
            <td>${item.withdrawal_application_time.replace(" ", "/")}</td>
            <td>${timezone}</td>
            <td>${status[item.withdrawal_state]}</td>
            <td>${item.approved_by}</td>
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
  let pageLimit = 18;

  async function fetchwithdraw(pagewithdraw) {
      try {
          let response = await fetch(`../admin/fetchwithdraw/${pagewithdraw}/${pageLimit}`);
          response = await response.json();
          if (response.status === "error") {
              $("#withdrawContainer").html(`<tr class="no-resultslist"><td colspan="15">Error: ${response.data}</td></tr>`);
              return;
          }

          const data = response.data;
          $("#maskwithdraw").LoadingOverlay("hide");
          renderwithdraw(data);
          const totalPages = Math.ceil(data[0].total_records / 10);
          // Render pagination
          renderwithdrawPagination(totalPages, 1);
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
      $("#paging_infowithdraw").text(`Page ${currentPagewithdraw} of ${totalPages} ${totalPages === 1 ? " Page " : " Pages "} `);
      // Add click event listeners to pagination links
      // document.querySelectorAll("#paginationwithdraw .page-link").forEach((link) => {
      //   link.addEventListener("click", function (e) {
      //     e.preventDefault();
      //     const newPage = parseInt(this.getAttribute("data-page"));
      //     if (newPage > 0 && newPage <= totalPages && newPage !== currentPagewithdraw) {
      //       // Update currentPagewithdraw and display paging information
      //       currentPagewithdraw = newPage;
      //       // document.getElementById("paging_infowithdraw").innerHTML = `Page ${currentPagewithdraw} of ${totalPages} pages`;

      //       // Fetch and render new page data
      //       fetchwithdraw(currentPagewithdraw);
      //     }
      //   });
      // });
  }

  $(".refreshwithdrawa").click(function () {
      // $(".query").val("");
      $("#maskwithdraw").LoadingOverlay("show", {
          background: "rgb(90,106,133,0.1)",
          size: 3,
      });
      $("#widrl-userID").val("");
      $("#widrl-ID").val("");
      $("#widrl-channels").val(0);
      $("#widrl-status").val(0);
      $("#widrl-startDate").val("");
      $("#widrl-endDate").val("");
      fetchwithdraw(1);
  });

  let debounceTimeout = null; // To store the timeout ID

  // Event listener for keyup
  // $(document).on('keyup','#withdrawinput', function () {
  //     const query = $(this).val().trim();

  //     if (query.length > 2) { // Only trigger if input is more than 2 characters
  //         clearTimeout(debounceTimeout); // Clear any existing timeout
  //         debounceTimeout = setTimeout(() => {
  //             // Call the filterUsers logic directly here
  //             let optionsHtml = '';

  //             $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
  //                 try {
  //                   console.log(response)
  //                     if (typeof response === 'string') {
  //                         response = JSON.parse(response); // Parse string response
  //                     }

  //                     if (Array.isArray(response)) {
  //                         const filteredUsers = response.filter(user =>
  //                             user.username.toLowerCase().includes(query.toLowerCase())
  //                         );

  //                         if (filteredUsers.length > 0) {
  //                             filteredUsers.forEach(user => {
  //                               optionsHtml += `<option class ="optionlist"  value="${user.uid}" data-username="${user.username}">${user.username}</option>`;
  //                                 // optionsHtml += `<li class="optionlist" data-username="${user.username}">${user.username}</li>`;
  //                             });

  //                             $('.withdrawDropdown').html(optionsHtml).show(); // Display dropdown with options
  //                         } else {
  //                             $('.withdrawDropdown').hide(); // Hide dropdown if no users found
  //                         }
  //                     } else {
  //                         console.error("Invalid response format: ", response);
  //                         $('.withdrawDropdown').hide();
  //                     }
  //                 } catch (error) {
  //                     console.error("Error parsing response: ", error);
  //                     $('.withdrawDropdown').hide();
  //                 }
  //             }).fail(function (error) {
  //                 console.error("Error fetching users: ", error);
  //                 $('.withdrawDropdown').hide();
  //             });
  //         }, 500); // 500ms debounce delay
  //     } else {
  //         $('.withdrawDropdown').hide(); // Hide dropdown if input is less than 3 characters
  //     }
  // });

  // $(document).on('change', '.withdrawDropdown', function () {
  //     const selectedOption = $(this).find('option:selected'); // Get the selected <option>
  //     const selectedUserId = selectedOption.val(); // Get user ID from the value attribute
  //     const selectedUsername = selectedOption.data('username'); // Get username from data-attribute

  //     if (selectedUserId) {
  //         // Set input field to selected username
  //         $('#withdrawinput').val(selectedUsername);
  //         // Set the user ID in the hidden field (if any)
  //         $('.userIdField').val(selectedUserId);
  //         // Hide dropdown after selection
  //         $('.withdrawDropdown').hide();

  //         console.log(selectedUserId);
  //         console.log(`Selected Username: ${selectedUsername}`);
  //     } else {
  //         // Clear both username and user ID if no option is selected
  //         $('#withdrawinput').val('');
  //         $('.userIdField').val(''); // Assuming you're using a hidden input for the ID
  //         $('.withdrawDropdown').show(); // Keep the dropdown visible in case of clearing
  //         console.log('Selection cleared');
  //     }
  // });
  // $(document).on('input', '#withdrawinput', function () {
  //     const inputValue = $(this).val(); // Get the current value of the input
  //     if (!inputValue) {
  //         // If input is cleared, reset the user ID as well
  //         $('.userIdField').val('');
  //         console.log('User manually cleared the username');
  //     }
  // });

  const filterWidrlRecords = (currentPage, element, limit = 10, isPaging = false) => {
      let userID = $("#widrl-userID").val();
      let widrlID = $("#widrl-ID").val();
      let widrlChannels = $("#widrl-channels").val();
      let widrlStatus = $("#widrl-status").val();
      let widrlStartDate = $("#widrl-startDate").val();
      let widrlEndDate = $("#widrl-endDate").val();

      if (widrlStartDate === undefined) {
          widrlStartDate = "all";
      } else if (widrlStartDate.length == 0) {
          widrlStartDate = "all";
      }

      if (widrlEndDate === undefined) {
          widrlEndDate = "all";
      } else if (widrlEndDate.length == 0) {
          widrlEndDate = "all";
      }
      if (userID.length == 0 && widrlID.length == 0 && widrlChannels == 0 && widrlStatus == 0 && widrlStartDate == "all" && widrlEndDate == "all" && !isPaging) {
          showToast("No filters selected.", "Please select atleast one filter.", "info");
          return;
      }

      userID = userID.length == 0 ? "all" : userID;
      widrlID = widrlID.length == 0 ? "all" : widrlID;
      widrlChannels = widrlChannels == 0 ? "all" : widrlChannels;
      widrlStatus = widrlStatus == 0 ? "all" : widrlStatus;

      $.ajax({
          url: `../admin/searchWidrlRecords/${userID}/${widrlID}/${widrlChannels}/${widrlStatus}/${widrlStartDate}/${widrlEndDate}/${currentPage}/${limit}`,
          type: "POST",
          beforeSend: function () {
              $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
          },
          success: function (response) {
              console.log(response);
              response = JSON.parse(response);
              //console.log(response);

              if (response.status === "error") {
                  $("#withdrawContainer").html(`<tr class="no-resultslist"><td colspan="15">Error: ${response.data}</td></tr>`);
                  return;
              }

              if (response.data.length == 0) {
                  $("#withdrawContainer").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);
                  $("#paging_infowithdraw").text(`Page 0 of 0 Pages`);
                  $("#paginationwithdraw").html("");
                  return;
              }
              withdrawalRecords = response.data;
              const totalPages = Math.ceil(withdrawalRecords[0].total_records / limit);
              const html = withdrawdata(withdrawalRecords);
              $("#withdrawContainer").html(html);
              renderwithdrawPagination(totalPages, currentPage);
          },
          error: function (xhr, status, error) {
              console.log("An error occured: ");
          },
          complete: function () {
              $($(element).find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx-check-double");
              $("#maskwithdraw").LoadingOverlay("hide");
          },
      });
  };

  $(document).on("change", "#widrl-numrowstans", function () {
      const element = $("#paginationwithdraw .active .page-link")[0];
      const page = $(element).text();
      console.log($("#paginationwithdraw .active .page-link")[0]);
      const limit = $(this).val();
      filterWidrlRecords(parseInt(page), this, parseInt(limit), true);
  });

  $(document).on("click", ".widrl-search", function () {
      filterWidrlRecords(1, this);
  });

  /// search usernames
  $(document).on("click", "#paginationwithdraw .page-link", function (e) {
      e.preventDefault();
      const element = e.target;
      const page = $(this).attr("data-page");
      filterWidrlRecords(parseInt(page), this, 10, true);
  });

  $(document).on("keyup", ".widrl-username", function () {
      const query = $(this).val().trim();
      //  console.log("Hitting here period");
      // Only trigger if input is more than 2 characters
      if (query.length > 2) {
          clearTimeout(debounceTimeout); // Clear any existing timeout
          debounceTimeout = setTimeout(fetchbetUser, 500, query); // Call fetchUsers with the query after 500ms delay
      } else {
          $(".trackdown").hide(); // Hide dropdown if input is less than 3 characters
      }
  });

  // Handle manual input clearing
  $(document).on("input", ".widrl-username", function () {
      if (!$(this).val()) {
          $(".widrl-userID").val(""); // Reset user ID if input is cleared
      }
  });

  // Handle dropdown item selection
  $(document).on("change", "#users-options-wrapper", function () {
      const selectedOption = $(this).find("option:selected");
      const selectedUserId = selectedOption.val();
      if (selectedUserId.length === 0) return;
      const selectedUsername = selectedOption.data("username");

      if (selectedUserId) {
          $(".widrl-username").val(selectedUsername);
          $("#widrl-userID").val(selectedUserId);
          $("#users-options-wrapper").hide();
      }

      //   console.log(selectedUsername)
  });

  // Function to fetch and display users
  const fetchbetUser = (query) => {
      let optionsHtml = "";

      $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
          try {
              const getDisplayName = (user) => {
                  if (user.username !== "" && user.username != undefined && user.username !== "*****") return user.username;
                  if (user.email !== undefined && user.email != "") return user.email;
              };

              response = JSON.parse(response);
              if (response[0].empty) {
                  $("#users-options-wrapper").html(`<option value="">No Users Found.</option>`);
                  $("#users-options-wrapper").css({ display: "inline-block" });
                  return;
              }
              for (let index = 0; index < response.length; index++) {
                  const user = response[index];
                  const username = user[user.regtype];

                  optionsHtml += username === undefined ?  `<li class="optionlist"> No Data Found.</li>`  :  `<option class="optionlist" value="${user.uid}" data-username="${username}">${username}</option>`;
              }
              //  console.log(optionsHtml);
              $("#users-options-wrapper").html(optionsHtml);
              $("#users-options-wrapper").css({ display: "inline-block" });
          } catch (error) {
              console.error("Error parsing response: ", error);
              $("#users-options-wrapper").hide();
          }
      }).fail(function () {
          console.error("Error fetching users.");
          $(".#users-options-wrapper").hide();
      });
  };

  $(".playerwithdraw").click(function (e) {
      let direction = $(this).attr("data-page");
      const tableWrapper = $(".table-wrapperwithdraw");
      const tableWrappers = $(".table-wrapperwithdraw")[0];
      const scrollAmount = 1000; // Adjust as needed
      const scrollOptions = { behavior: "smooth" };
      if (tableWrapper.length) {
          switch (direction) {
              case "widrl-leftlinks":
                  tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
                  break;
              case "widrl-rightlinks":
                  tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
                  break;
              default:
                  break;
          }
      }
      e.stopPropagation(); // Prevent event bubbling
  });
});

function formatNumber(number) {
  number = parseFloat(number);
  // 1) Format to exactly four decimal places (no thousands separators)
  let formatted = number.toFixed(4);

  // 2) Remove trailing zeros after the decimal point
  formatted = formatted.replace(/0+$/, "");

  // 3) If the last character is now just a decimal point, remove it
  formatted = formatted.replace(/\.$/, "");

  return formatted;
}
