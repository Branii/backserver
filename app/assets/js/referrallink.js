$(function () {
  const showToast = (title, message, type) => {
      $.toast({
          position: "bottom-right",
          title: title,
          message: message,
          type: type,
          duration: 3000, // auto-dismiss after 3s
      });
  };

  const UserlinksData = (data) => {
      let html = "";

      data.forEach((item) => {
        let username = item.reg_type === "email" ? item.email : item.reg_type === "username" ? item.username : item.contact;
          html += `
                  <tr>
                      <td>${username}</td>
                      <td class='link-offset-1 text-decoration-underline'>${item.register_link}</td>
                      <td>${item.rebate}</td>
                      <td>${item.register_count + " / " + item.quota_used}</td>
                       <td>${item.date_created + " / " + item.time_created}</td>
                       <td>${item.remarks}</td>
                      
                  </tr>
              `;
      });
      return html;
  };

  const renderuserlinks = (data) => {
      var html = UserlinksData(data);
      $("#linksContainer").html(html);
  };

  let currentPage = 1;
  let pageLimit = 20;

  async function fetchUserlinks(page, pageLimit) {
      try {
          const response = await fetch(`../admin/userlinkdata/${partnerID}/${page}/${pageLimit}`);
          const data = await response.json();
          $("#maskreferal").LoadingOverlay("hide");
          renderuserlinks(data.userlinks);
          renderfinacesPagination(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchUserlinks(newPage, pageLimit));
          document.getElementById("paging_inforeferal").innerHTML = "Page " + page + " of " + data.totalPages + " pages";
      } catch (error) {
          console.error("Error fetching data:", error);
      }
  }

  async function filterUserlinks(username, linkstart, linkenddate, currentPage, pageLimit) {
      try {
          const response = await fetch(`../admin/filterUserlinks/${partnerID}/${username}/${linkstart}/${linkenddate}/${currentPage}/${pageLimit}`);
          const data = await response.json();
          // console.log(response)
          //  return

          $(".loaderreferal").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
          if (data.userlinkss.length < 1) {
              let html = `
              <tr class="no-results" >
              <td colspan="9">
                   <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
              </td>
           </tr>`;
              $("#linksContainer").html(html);
              return;
          }
          renderuserlinks(data.userlinkss);

          renderfinacesPagination(data.totalPages, page, pageLimit, (newPage, pageLimit) => filterUserlinks(username, linkstart, linkenddate, newPage, pageLimit));
          document.getElementById("paging_inforeferal").innerHTML = "Page " + page + " of " + data.totalPages + " pages";
      } catch (error) {
          console.error("Error fetching data:", error);
      }
  }

  function renderfinacesPagination(totalPages, currentPage, pageLimit, callback) {
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

      document.getElementById("paginationreferal").innerHTML = pagLink;

      // Add click event listeners
      document.querySelectorAll("#paginationreferal .page-link").forEach((link) => {
          link.addEventListener("click", function (e) {
              e.preventDefault();
              const newPage = +this.getAttribute("data-page");
              if (newPage > 0 && newPage <= totalPages) {
                  $("#maskreferal").LoadingOverlay("show", {
                      background: "rgb(90,106,133,0.1)",
                      size: 3,
                  });
                  callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
              }
          });
      });
  }

  fetchUserlinks(currentPage, pageLimit);

  $(".playerlinks").click(function () {
      let direction = $(this).val();
      const tableWrapper = $(".table-wrapperlistlinks");
      const tableWrappers = document.querySelector(".table-wrapperlistlinks");
      const scrollAmount = 1000; // Adjust as needed
      const scrollOptions = {
          behavior: "smooth",
      };
      if (tableWrapper.length) {
          switch (direction) {
              case "leftlinks":
                  tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
                  break;
              case "rightlinks":
                  tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
                  break;
              case "startlinks":
                  // Scroll to the absolute start (leftmost position)
                  tableWrapper.animate({ scrollLeft: 0 }, "slow");
                  break;
              case "endlinks":
                  const maxScrollLeft = tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
                  tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
                  break;
              default:
                  break;
          }
      }
  });

  $(".refreshreferal").click(function () {
       $(".queryholderlogss").val("")
      $("#maskreferal").LoadingOverlay("show", {
          background: "rgb(90,106,133,0.1)",
          size: 3,
      });
      fetchUserlinks(currentPage, pageLimit);
  });

  $(document).on("click", ".executeusereferal", function () {
      if ($("#linkinput").val() == "" && $(".linkstart").val() == "") {
          //   $("#danger-userlinks").modal("show");
          showToast("Heads up!!", "Select one or more data fields to filter", "info");
          return;
      }
      const username = $("#linkinput").val();
      const linkstart = $(".linkstart").val();
      const linkenddate = $(".linkenddate").val();
      console.log(username);
      $(".loaderreferal").removeClass("bx-check-double").addClass("bx-loader bx-spin");
      // setTimeout(() => {
      filterUserlinks(username, linkstart, linkenddate, currentPage, pageLimit);
      // }, 100);
  });

  let debounceTimeout = null;
  $(document).ready(function () {
      // Event listener for keyup on #myInput
      $(document).on("keyup", "#linkinput", function () {
          const query = $(this).val().trim();

          // Only trigger if input is more than 2 characters
          if (query.length > 1) {
              clearTimeout(debounceTimeout); // Clear any existing timeout
              debounceTimeout = setTimeout(fetchUserlink, 500, query); // Call fetchUsers with the query after 500ms delay
          } else {
              $(".linkDropdown").hide(); // Hide dropdown if input is less than 3 characters
          }
      });

      // Handle dropdown item selection
      $(document).on("change", ".linkDropdown", function () {
          const selectedOption = $(this).find("option:selected");
          const selectedUserId = selectedOption.val();
          const selectedUsername = selectedOption.data("usernames");

          if (selectedUserId) {
              $("#linkinput").val(selectedUsername);
              $(".userIdFields").val(selectedUserId);
              $(".linkDropdown").hide();
          }
      });

      $(document).on("click", function (e) {
          const $dropdownbet = $("#linkinputdowns");
          if (!$(e.target).closest("#linkinput, #linkinputdowns").length) {
              $dropdownbet.hide();
          }
      });
      // Handle manual input clearing
      $(document).on("input", "#linkinput", function () {
          if (!$(this).val()) {
              $(".userIdFields").val(""); // Reset user ID if input is cleared
          }
      });
  });

  // Function to fetch and display users
  function fetchUserlink(query) {
      let optionsHtml = "";

      $.post(`../admin/Searchusername/${partnerID}/${encodeURIComponent(query)}`, function (response) {
          try {
              response = typeof response === "string" ? JSON.parse(response) : response;

              //     console.log(response);

              response.forEach((user) => {
                  let displayValue;
                  let regname;
                  // Display based on regtype
                  if (user.regtype === "email") {
                      displayValue = user.email;
                      regname = user.email; // Show email
                  } else if (user.regtype === "username") {
                      displayValue = user.username;
                      regname = user.username; // Show username
                  } else if (user.regtype === "contact") {
                      displayValue = user.contact;
                      regname = user.contact; // Show contact
                  } else {
                      displayValue = "no data found ...";
                      regname = "no data found ..."; // Show contact
                  }

                  // Append the option to the optionsHtml string
                  optionsHtml += `<option class="optionlist" value="${user.uid}" data-usernames="${regname}">${displayValue}</option>`;
              });
              $(".linkDropdown").html(optionsHtml).show();
          } catch (error) {
              console.error("Error parsing response: ", error);
              $(".linkDropdown").hide();
          }
      }).fail(function () {
          console.error("Error fetching users.");
          $(".linkDropdown").hide();
      });
  }

  function tableScrollLinks() {
      const tableContainerLinks = document.querySelector(".table-wrapperquota");
      const headerRowLinks = document.querySelector(".headrowlinks");

      tableContainerLinks.addEventListener("scroll", function () {
          if (tableContainerLinks.scrollTop > 0) {
              headerRowLinks.classList.add("sticky-headerlinks");
          } else {
              headerRowLinks.classList.remove("sticky-headerlinks");
          }
      });
  }

  tableScrollLinks();
});
