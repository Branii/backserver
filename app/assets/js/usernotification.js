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
  const usernotiData = (data) => {
     let html = ""
     console.log(data);
      data.forEach((item) => {
        const readstatus = item.read_status === 'read' ? '<span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">Read</span>'  : '<span class="badge fw-semibold py-1 w-85 bg-warning-subtle text-warning">Unread</span>'
        let timezone = item.timezone.split(" ");
        timezone = `${timezone}<span style="margin-left: 1rem;">GMT${timezone[1]}</span>`
        html += `
            <tr>
                <td>${item.username}</td>
                <td>${item.subject}</td>
                <td style ="max-width: 300px;word-wrap: break-word;overflow-wrap: break-word; white-space: normal;">${item.message}</td>
                <td>${item.created_at}</td> 
                <td>${timezone}</td> 
                <td> ${readstatus}</td>                               
            </tr>
            `;
      });
      return html;
  };

  const renderusernoti = (data) => {
      var html = usernotiData(data);
      $("#notificationcontainer").html(html);
  };

  let currentPage = 1;
  let pageLimit = 25;

  async function fetchusernotification(page,pageLimit) {
      try {
          const response = await fetch(`../admin/fetchusernotification/${partnerID}/${page}/${pageLimit}`);
          const data = await response.json();
          //console.log(response);
          //  return
          $("#maskusernoti").LoadingOverlay("hide");
          renderusernoti(data.notification);
           renderPaginationusernoti(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchusernotification(newPage, pageLimit));
           document.getElementById("paging_infonoti").innerHTML = "Page " + page + " of " + data.totalPages + " pages";
      } catch (error) {
          console.error("Error fetching data:", error);
      }
  }

  fetchusernotification(currentPage, pageLimit);

  function renderPaginationusernoti(totalPages, currentPage, pageLimit, callback) {
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

      document.getElementById("paginationnoti").innerHTML = pagLink;
      // Add click event listeners
      document.querySelectorAll("#paginationnoti .page-link").forEach((link) => {
          link.addEventListener("click", function (e) {
              e.preventDefault();
              const newPage = +this.getAttribute("data-page");
              if (newPage > 0 && newPage <= totalPages) {
                  $("#maskusernoti").LoadingOverlay("show", {
                      background: "rgb(90,106,133,0.1)",
                      size: 3,
                  });
                  callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
              }
          });
      });
  }


  $(".refresusernoti").click(function () {
      $(".queryholdernotfys").val("");
      $("#maskusernoti").LoadingOverlay("show", {
          background: "rgb(90,106,133,0.1)",
          size: 3,
      });
      fetchusernotification(currentPage, pageLimit);
  });

   $(document).on('click','.executenoti',function(){
        if ($("#usernotifys").val() == "" && $(".messagesread").val() == "" && $(".startnotfys").val() == "") {
            // $("#danger-finance").modal("show");
            showToast("Heads up!!", "Select one or more data fields to filter", "info");
            return;
        }
        const username = $("#usernotifys").val();
        const messagestype = $(".messagesread").val();
        const startnotfys = $(".startnotfys").val();
        const endnotfys = $(".endnotfys").val();
        // console.log(username,messagestype,startnotfys,endnotfys);
        filterUserNotifys(username, messagestype, startnotfys, endnotfys, currentPage, pageLimit)
   })

   async function filterUserNotifys(username, messagestype, startnotfys, endnotfys, currentPage, pageLimit) {
    $.post(`../admin/filteruserNotifys/${partnerID}/${username}/${messagestype}/${startnotfys}/${endnotfys}/${currentPage}/${pageLimit}`, 
        function (response) {
        try {
        const data = JSON.parse(response);
       // console.log(data);
       //    return
        $(".loadernotfys").removeClass("bx-loader bx-spin").addClass("bx-check-double");
        if (data.usermessage.length < 1) {
            $("#notificationcontainer").html(`
            <tr class="no-results">
            <td colspan="9">
            <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
        </td>
        </tr>
        `);
            return;
        }
        $("#maskusernoti").LoadingOverlay("hide");
        renderusernoti(data.usermessage);
        // Render pagination
        renderfinacePaginations(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => filterUserNotifys(username, messagestype, startnotfys, endnotfys, newPage, pageLimit));
        document.getElementById("paging_infonoti").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
    } catch (error) {
        console.error("Error parsing JSON response:", error);
    } finally {
        $(".loadernotfys").removeClass("bx-loader bx-spin").addClass("bx-check-double");
    }
    }).fail(function (error) {
    console.error("Error fetching data:", error);
    $(".loadernotfys").removeClass("bx-loader bx-spin").addClass("bx-check-double");
    });
    }




   let debounceTimeouts = null;
   $(document).ready(function () {

       $(document).on("keyup", "#usernotifys", function () {
           const query = $(this).val().trim();
           if (query.length > 1) {
               clearTimeout(debounceTimeouts); // Clear any previous timeout
               debounceTimeouts = setTimeout(function () {
                   fetchUsers(query); // Call fetchUsers with the query after 500ms delay
               }, 500);
           } else {
               $(".notfyDropdown").hide(); // Hide dropdown if input is less than 2 characters
           }
       });
   
       // Handle dropdown item selection
       $(document).on("change", ".notfyDropdown", function () {
           const selectedOption = $(this).find("option:selected");
           const selectedUserId = selectedOption.val();
           const selectedUsername = selectedOption.data("username");
           
           if (selectedUserId) {
               $("#usernotifys").val(selectedUsername); // Set the input to the selected username
               $(".userIdfinance").val(selectedUserId); // Set the user ID in a hidden field
               $(".notfyDropdown").hide(); // Hide dropdown after selection
           }
       });
   
       // Hide dropdown when clicking outside of the input or dropdown
       $(document).on("click", function (e) {
           const $dropdownbet = $(".notfyDropdown");
           if (!$(e.target).closest("#usernotifys, .notfyDropdown").length) {
               $dropdownbet.hide(); // Hide dropdown if click is outside
           }
       });
   
       // Handle clearing of user ID when input is manually cleared
       $(document).on("input", "#usernotifys", function () {
           if (!$(this).val()) {
               $(".userIdfinance").val(""); // Reset user ID if input is cleared
           }
       });
   });
   function fetchUsers(query) {
       let optionsHtml = "";
   
       $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
           try {
               response = typeof response === "string" ? JSON.parse(response) : response;
               // If response is not empty, build the dropdown options
               if (response.length > 0) {
                   response.forEach((user) => {
                       let displayValues;
                       let regnames;
   
                       // Display based on regtype (email, username, or contact)
                       if (user.regtype === "email") {
                           displayValues = user.email;
                           regnames = user.email; // Show email
                       } else if (user.regtype === "username") {
                           displayValues = user.username;
                           regnames = user.username; // Show username
                       } else if (user.regtype === "contact") {
                           displayValues = user.contact;
                           regnames = user.contact; // Show contact
                       } else {
                           displayValues = "no data found ...";
                           regnames = "no data found ..."; // Show a fallback message
                       }
   
                       // Build the option HTML
                       optionsHtml += `<option class="optionlist" value="${user.uid}" data-username="${regnames}">${displayValues}</option>`;
                   });
   
                   $(".notfyDropdown").html(optionsHtml).show(); // Show the dropdown with options
               } else {
                   $(".notfyDropdown").html("<option>No users found</option>").show(); // If no users found, display a message
               }
           } catch (error) {
               console.error("Error parsing response: ", error);
               $(".notfyDropdown").hide(); // Hide dropdown on error
           }
       }).fail(function () {
           console.error("Error fetching users.");
           $(".notfyDropdown").hide(); // Hide dropdown on fail
       });
   }
   
  function tableScrollUsernoti() {
      const tableContainerusernoti = document.querySelector(".table-wrapperusernoti");
      const headerRowusernoti = document.querySelector(".usernotiheads");

      tableContainerusernoti.addEventListener("scroll", function () {
          if (tableContainerusernoti.scrollTop > 0) {
              headerRowusernoti.classList.add("sticky-usernotiheadrows");
          } else {
              headerRowusernoti.classList.remove("sticky-usernotiheadrows");
          }
      });
  }

  tableScrollUsernoti();
});
