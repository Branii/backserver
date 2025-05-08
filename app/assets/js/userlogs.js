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

  const UserlogsData = (data) => {
      let html = "";

      data.forEach((item) => {
          //   const ipInfo = fetchIpInfo(item.ip);

          // // Extract city from IP information or use a fallback
          //  const city = ipInfo?.geoplugin_city || 'Unknown';
          let username = item.reg_type === "email" ? item.email : item.reg_type === "username" ? item.username : item.contact;
          let timezone = item.timezone.split(" ");
          timezone = timezone[0] + `<span style="margin-left: 1rem;">GMT${timezone[1]}</span>`;
          html += `
                  <tr>
                      <td>${typeof username === "string" || typeof username === "number" ? String(username).charAt(0).toUpperCase() + String(username).slice(1) : "N/A"}</td>
                      <td>${item.login_date + " / " + item.login_time}</td>
                      <td>${timezone}</td>
                      <td>${item.ip}</td>
                      <td></td>
                      <td>${item.browser_info.substring(0, 12)}</td>
                      <td>${item.device_info.substring(0, 15)}</td>
                      <td>${item.app_version}</td>
                  </tr>
              `;
      });
      return html;
  };

  const renderuserlogs = (data) => {
      var html = UserlogsData(data);
      $("#userlogsContainer").html(html);
  };

  let currentPage = 1;
  let pageLimit = 20;

  async function fetchUserlogs(page, pageLimit) {
      try {
          const response = await fetch(`../admin/userlogsdata/${partnerID}/${page}/${pageLimit}`);
          const data = await response.json();
          //  console.log(response);

          $("#masklogs").LoadingOverlay("hide");
          renderuserlogs(data.userlogs);
          renderuserlogPagination(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchUserlogs(newPage, pageLimit));
          document.getElementById("paging_infologs").innerHTML = "Page " + page + " of " + data.totalPages + " pages";
      } catch (error) {
          console.error("Error fetching data:", error);
      }
  }

  fetchUserlogs(currentPage, pageLimit);

  async function filterUserlogs(usernamelog, startdatelog, enddatelog, currentPage, pageLimit) {
      try {
          const response = await fetch(`../admin/filterUserlogs/${partnerID}/${usernamelog}/${startdatelog}/${enddatelog}/${currentPage}/${pageLimit}`);
          const data = await response.json();
          console.log(response);
          //  return

          $(".loaderlog").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
          if (data.userloggs.length < 1) {
              let html = `
            <tr class="no-results" >
            <td colspan="9">
                 <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
            </td>
         </tr>`;
              $("#userlogsContainer").html(html);
              return;
          }
          $("#masklogs").LoadingOverlay("hide");
          renderuserlogs(data.userloggs);

          // Render pagination
          renderuserlogPagination(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => filterUserlogs(usernamelog, startdatelog, enddatelog, newPage, pageLimit));
          document.getElementById("paging_infologs").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
      } catch (error) {
          console.error("Error fetching data:", error);
      }
  }

  function renderuserlogPagination(totalPages, currentPage, pageLimit, callback) {
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

      document.getElementById("paginationlogs").innerHTML = pagLink;

      // Add click event listeners
      document.querySelectorAll("#paginationlogs .page-link").forEach((link) => {
          link.addEventListener("click", function (e) {
              e.preventDefault();
              const newPage = +this.getAttribute("data-page");
              if (newPage > 0 && newPage <= totalPages) {
                  $("#masklogs").LoadingOverlay("show", {
                      background: "rgb(90,106,133,0.1)",
                      size: 3,
                  });
                  callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
              }
          });
      });
  }

  $(".playerlogs").click(function () {
      let direction = $(this).val();
      const tableWrapper = $(".table-wrapperlogs");
      const tableWrappers = document.querySelector(".table-wrapperlogs");
      const scrollAmount = 1000; // Adjust as needed
      const scrollOptions = {
          behavior: "smooth",
      };
      if (tableWrapper.length) {
          switch (direction) {
              case "leftlogs":
                  tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
                  break;
              case "rightlogs":
                  tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
                  break;
              case "startlogs":
                  // Scroll to the absolute start (leftmost position)
                  tableWrapper.animate({ scrollLeft: 0 }, "slow");
                  break;
              case "endlogs":
                  const maxScrollLeft = tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
                  tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
                  break;
              default:
                  break;
          }
      }
  });

  $(".refreshlogs").click(function () {
      $(".queryholderlogs").val("");
      $("#masklogs").LoadingOverlay("show", {
          background: "rgb(90,106,133,0.1)",
          size: 3,
      });
      fetchUserlogs(currentPage, pageLimit);
  });

  $(".numrowslog").change(function () {
      $("#masklogs").LoadingOverlay("show", {
          background: "rgb(90,106,133,0.1)",
          size: 3,
      });
      const numrow = $(this).val();
      fetchUserlogs(currentPage, numrow);
  });

  $(document).on("click", ".executeuserlogs", function () {
      if ($("#userloginput").val() == "" && $(".startdatelog").val() == "") {
          showToast("Heads up!!", "Select one or more data fields to filter", "info");
          return;
      }
      const usernamelog = $("#userloginput").val();
      const startdatelog = $(".startdatelog").val();
      const enddatelog = $(".enddatelog").val();
      console.log(usernamelog);
      $(".loaderlog").removeClass("bx-check-double").addClass("bx-loader bx-spin");
      setTimeout(() => {
          filterUserlogs(usernamelog, startdatelog, enddatelog, currentPage, pageLimit);
      }, 100);
  });

  $(document).on("click", function () {
      $(".queryholderxxx").hide();
  });

  let debounceTimeoutlogs = null;

  $(document).ready(function () {
      // Event listener for keyup on #myInput
      $(document).on("keyup", "#userloginput", function () {
          const query = $(this).val().trim();

          // Only trigger if input is more than 2 characters
          if (query.length > 1) {
              clearTimeout(debounceTimeoutlogs); // Clear any existing timeout
              debounceTimeoutlogs = setTimeout(fetchUserslogs, 500, query); // Call fetchUsers with the query after 500ms delay
          } else {
              $(".userlogdropdown").hide(); // Hide dropdown if input is less than 3 characters
          }
      });

      // Handle dropdown item selection
      $(document).on("change", ".userlogdropdown", function () {
          const selectedOption = $(this).find("option:selected");
          const selectedUserId = selectedOption.val();
          const selectedUsername = selectedOption.data("username");
          console.log(selectedUserId);

          if (selectedUserId) {
              $("#userloginput").val(selectedUsername);
              $(".userIds").val(selectedUserId);
              $(".userlogdropdown").hide();
          }
      });

      $(document).on("click", function (e) {
          const $dropdown = $("#userfinaceuserlogs");
          if (!$(e.target).closest("#userloginput, #userfinaceuserlogs").length) {
              $dropdown.hide();
          }
      });
      // Handle manual input clearing
      $(document).on("input", "#userloginput", function () {
          if (!$(this).val()) {
              $(".userIds").val(""); // Reset user ID if input is cleared
          }
      });
  });

  // Function to fetch and display users
  function fetchUserslogs(query) {
      let optionsHtml = "";

      $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
          try {
              response = typeof response === "string" ? JSON.parse(response) : response;
              response.forEach((user) => {
                  let displayValues;
                  let regnames;
                  // Display based on regtype
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
                      displayValues = "no data found..";
                      regnames = "no data found..";
                  }
                  optionsHtml += `<option class="optionlist" value="${user.uid}" data-username="${regnames}">${displayValues}</option>`;
              });

              $(".userlogdropdown").html(optionsHtml).show();
          } catch (error) {
              console.error("Error parsing response: ", error);
              $(".userlogdropdown").hide();
          }
      }).fail(function () {
          console.error("Error fetching users.");
          $(".userlogdropdown").hide();
      });
  }

  function tableScrollUserLogs() {
      const tableContainerUserLogs = document.querySelector(".table-wrapperuserlogs");
      const headerRowUserLogs = document.querySelector(".userlogheadrow");

      tableContainerUserLogs.addEventListener("scroll", function () {
          if (tableContainerUserLogs.scrollTop > 0) {
              headerRowUserLogs.classList.add("sticky-userloghead");
          } else {
              headerRowUserLogs.classList.remove("sticky-userloghead");
          }
      });
  }
  tableScrollUserLogs();
  // function getIpLocation(ip = "157.173.97.174:443") {
  //   const url = ip ? `http://www.geoplugin.net/json.gp?ip=${ip}` : "http://www.geoplugin.net/json.gp";

  //   $.getJSON(url, function(data) {
  //       console.log("IP Address: " + data.geoplugin_request);
  //       console.log("City: " + data.geoplugin_city);
  //       console.log("Region: " + data.geoplugin_region);
  //       console.log("Country: " + data.geoplugin_countryName);
  //   }).fail(function() {
  //       console.error("Failed to fetch location data.");
  //   });
  // }

  // // Usage Example:
  // // Get location of visitor's IP
  //   getIpLocation();

  // // Get location of a specific IP
  // // getIpLocation("8.8.8.8");
});
