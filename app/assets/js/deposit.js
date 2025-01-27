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
    function formatMoney(money) { 
      let moneyStr = String(money); 
      if (moneyStr.includes(".")) { 
          let parts = moneyStr.split("."); 
          if (parts[1].length > 2) { 
              parts[1] = parts[1].substring(0, 4); 
          } 
          moneyStr = parts.join(".").replace(/\.?0+$/, ""); 
      } 
      return moneyStr; 
  }
      const states = {
        1: "Manual Deposit",
        2: "Bank Transfer",
        3: "Momo",
        5: "Crypto",
      };


    const Depositdata = (data) => { 
    
        let html = "";
       
      data.forEach((item) => {
        let username = item.reg_type === "email" ? item.email : (item.reg_type === "username" ? item.username : item.contact);
      
          html += `
                      <tr>
                          <td>${item.payment_reference}</td>
                           <td>${typeof username === "string" || typeof username === "number" 
                          ? String(username).charAt(0).toUpperCase() + String(username).slice(1) : "N/A"}
                          </td>
                          <td>VIP</td>
                          <td>${states[item.desposit_channel]? states[item.desposit_channel]: "N/A"}</td>
                          <td>${formatMoney(item.amount_paid)}</td>
                          <td>0</td>
                          <td>${formatMoney(item.amount_paid)}</td>
                          <td>${item.date_created + ' / ' + item.time_created}</td>
                          <td>${item.momo_provider ? item.momo_provider: "N/A"}</td>
                          <td>${item.user_mobile}</td>
                          <td>${item.momo_status.charAt(0).toUpperCase() + item.momo_status.slice(1)}</td>
                          <td>${item.approved_by}</td>
                          
                      </tr>
                  `;
        });
        return html;
      };
  
    const renderdeposit = (data) => {
      var html = Depositdata(data);
      $("#DepositContainer").html(html);
    };
  
    let currentPage = 1;
    let pageLimit = 20;
 
    
    async function fetchDeposit(page,pageLimit) {
      try {
        const response = await fetch(
          `../admin/fetchDeposit/${page}/${pageLimit}`
        );
        const data = await response.json();
    
        $("#maskDeposit").LoadingOverlay("hide");
        renderdeposit(data.deposit);
        renderdepositPagination(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchDeposit(newPage, pageLimit));
        document.getElementById("paging_infodeposit").innerHTML = "Page " + page + " of " + data.totalPages + " pages";
    
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
    fetchDeposit(currentPage,pageLimit)

    function renderdepositPagination(totalPages, currentPage, pageLimit, callback) {
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

      document.getElementById("paginationdeposit").innerHTML = pagLink;

      // Add click event listeners
      document.querySelectorAll("#paginationdeposit .page-link").forEach((link) => {
          link.addEventListener("click", function (e) {
              e.preventDefault();
              const newPage = +this.getAttribute("data-page");
              if (newPage > 0 && newPage <= totalPages) {
                  $("#maskDeposit").LoadingOverlay("show", {
                      background: "rgb(90,106,133,0.1)",
                      size: 3,
                  });
                  callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
              }
          });
      });
  }



    $(".refreshdeposit").click(function () {
      $(".queryholderdeposit").val("");
      $("#maskDeposit").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3,
      });
      fetchDeposit(currentPage,pageLimit)
    });
  

    $(".playerdeposit").click(function () {
      let direction = $(this).val();
      const tableWrapper = $(".table-wrapperdeposit");
      const tableWrappers = document.querySelector(".table-wrapperdeposit");
      const scrollAmount = 1000; // Adjust as needed
      const scrollOptions = {
        behavior: "smooth",
      };
      if (tableWrapper.length) {
        switch (direction) {
          case "leftd":
            tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
            break;
          case "rightd":
            tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
            break;
          case "startd":
            // Scroll to the absolute start (leftmost position)
            tableWrapper.animate({ scrollLeft: 0 }, "slow");
            break;
          case "endd":
            const maxScrollLeft =
              tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
            tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
            break;
          default:
            break;
        }
      }
    });
  
   
 
    
    function  filterdeposit(username,depositchanel,depositid,startdepo,enddepo,currentPage,pageLimit) {
      $.post(
        `../admin/filterdeposits/${username}/${depositchanel}/${depositid}/${startdepo}/${enddepo}/${currentPage}/${pageLimit}`,
        function (response) {
          try {
            const data = JSON.parse(response);
              console.log(data)
              // return
              $(".loaderdeposit").removeClass("bx-loader bx-spin").addClass("bx-check-double");
            if (data.deposits.length < 1) {
              $("#DepositContainer").html(`
                <tr class="no-results">
                  <td colspan="9">
                    <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                  </td>
                </tr>
              `);
              return;
            }
            $("#maskDeposit").LoadingOverlay("hide");
            renderdeposit(data.deposits);
          // Render pagination
          renderdepositPagination(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => filterdeposit(username,startdepo,enddepo,newPage,pageLimit) );
          document.getElementById("paging_infodeposit").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
    
          } catch (error) {
            console.error("Error parsing JSON response:", error);
          } finally {
            $(".loaderdeposit").removeClass("bx-loader bx-spin").addClass("bx-check-double");
          
          }
        }
      ).fail(function (error) {
        console.error("Error fetching data:", error);
        $(".loaderfinance").removeClass("bx-loader bx-spin").addClass("bx-check-double");
      });
    }

    $(document).on('click', '.executedeposit', function () {
    
      if ($("#Depositinput").val() == "" && $(".startdepo").val() == "" && $(".depositchanel").val() ==""
      && $(".depositids").val() == "") {
        // $("#danger-finance").modal("show");
        showToast("Heads up!!","Select one or more data fields to filter","info")
      //  return;
    }
  
      const username = $("#Depositinput").val();
      const depositchanel  = $(".depositchanel").val()
      const depositid = $(".depositids").val();
      const startdepo = $(".startdepo").val();
      const enddepo = $(".enddepo").val();
       console.log(depositid)
      //  return
   
      filterdeposit(username,depositchanel,depositid,startdepo,enddepo,currentPage,pageLimit)
    //   // Show loader
       $(".loaderdeposit").removeClass('bx-check-double').addClass('bx-loader bx-spin');
  
    });
  
  
    // Function to fetch and display users
     
    let debounceTimeout = null;
    let isPasting = false; 
    $(document).ready(function () {
        // Event listener for keyup on #Depositinput
        $(document).on('keyup', '#Depositinput', function (event) {
            const query = $(this).val().trim();
          
            // Only trigger if input is more than 1 character and not from pasting
            if (query.length > 1 && !isPasting) {
                clearTimeout(debounceTimeout); // Clear any existing timeout
                debounceTimeout = setTimeout(fetchUsers, 500, query); // Call fetchUsers with the query after 500ms delay
            } else {
                $('.DepositDropdown').hide(); // Hide dropdown if input is less than 2 characters or from pasting
            }
        });

       
        // Handle dropdown item selection
        $(document).on('change', '.DepositDropdown', function () {
            const selectedOption = $(this).find('option:selected');
            const selectedUserId = selectedOption.val();
            const selectedUsername = selectedOption.data('username');
    
            if (selectedUserId) {
                $('#Depositinput').val(selectedUsername);
                $('.userIdfinance').val(selectedUserId);
                $('.DepositDropdown').hide();
            }
        });
    
        // Hide dropdown when clicking outside
        $(document).on("click", function (e) {
            const $dropdownbet = $("#userfinaceDepo");
            if (!$(e.target).closest("#Depositinput, #userfinaceDepo").length) {
                $dropdownbet.hide();
            }
        });

    

       $(document).on('paste', '#Depositinput', function () {
        isPasting = true; // Set the flag to true when paste happens
        $('.DepositDropdown').hide()
        setTimeout(function () {
            isPasting = false; // Reset the flag after a short delay (allow paste to finish)
        }, 100);  // Delay of 100ms is usually enough for paste operations to finish
    
        });
    
        // Handle manual input clearing
        $(document).on('input', '#Depositinput', function () {
            if (!$(this).val()) {
                $('.userIdfinance').val(''); // Reset user ID if input is cleared
                // $('.DepositDropdown').hide();
            }
        });
    });
    
    function fetchUsers(query) {
        let optionsHtml = '';
    
        $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
            try {
                response = typeof response === 'string' ? JSON.parse(response) : response;
                response.forEach(user => {
                    let displayValues;
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
                        regnames = user.contact;  // Show contact
                    } else {
                        displayValues = 'no data found ...';
                        regnames = 'no data found ...';  // Show no data found
                    }
                    optionsHtml += `<option class="optlpionlist" value="${user.uid}" data-username="${regnames}">${displayValues}</option>`;
                });
    
                $('.DepositDropdown').html(optionsHtml).show();
            } catch (error) {
                console.error("Error parsing response: ", error);
                $('.DepositDropdown').hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $('.DepositDropdown').hide();
        });
    }
    

    function tableScrollDeposit() {
      const tableContainerDeposit= document.querySelector(".table-wrapperdeposit");
      const headerRowDeposit= document.querySelector(".depositheaderrow");

      tableContainerDeposit.addEventListener("scroll", function () {
          if (tableContainerDeposit.scrollTop > 0) {
              headerRowDeposit.classList.add("sticky-depositheader");
          } else {
              headerRowDeposit.classList.remove("sticky-depositheader");
          }
      });
   }
   tableScrollDeposit();

    $(".numrowsdeposit").change(function () {
        $("#maskDeposit").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3,
          });
        const depositrows = $(this).val();
        fetchDeposit(currentPage,depositrows)
      });

      $('#nametextss').on('dblclick', function () {
        $(this).val(''); // Clears the input field
      });
    
      $(".userdeposit").on("input paste", function () {
        const self = this;
        setTimeout(() => {
          // Trim leading spaces
          $(self).val($(self).val().replace(/^\s+/, ""));
        }, 0);
      });
  });
  