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
    const Depositdata = (data) => { 
    
        let html = "";
       
      data.forEach((item) => {
      
          html += `
                      <tr>
                          <td>${item.payment_reference}</td>
                          <td>${item.user_email}</td>
                          <td>VIP</td>
                          <td>${item.momo_provider}</td>
                          <td>${formatMoney(item.amount_paid)}</td>
                          <td>${formatMoney(item.amount_paid)}</td>
                          <td>${item.date_created + ' / ' + item.time_created}</td>
                          <td>${item.momo_provider}</td>
                          <td>${item.user_mobile}</td>
                          <td>${item.momo_status.charAt(0).toUpperCase() + item.momo_status.slice(1)}</td>
                          
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
    let pageLimit = 20;
  
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
      $(".queryholderdeposit").val("");
      $("#maskDeposit").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3,
      });
      fetchDeposit(currentPageDeposit)
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
  
   
  
    let debounceTimeouts = null;
    $(document).ready(function () {
        // Event listener for keyup on #myInput
        $(document).on('keyup', '#Depositinput', function () {
            const query = $(this).val().trim();
    
            // Only trigger if input is more than 2 characters
            if (query.length > 1) {
                clearTimeout(debounceTimeouts); // Clear any existing timeout
                debounceTimeout = setTimeout(fetchUsers, 500, query); // Call fetchUsers with the query after 500ms delay
            } else {
                $('.DepositDropdown').hide(); // Hide dropdown if input is less than 3 characters
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

       $(document).on("click", function (e) {
          const $dropdownbet = $("#userfinaceDepo");
          if (!$(e.target).closest("#Depositinput, #userfinaceDepo").length) {
              $dropdownbet.hide();
          }
      });
        // Handle manual input clearing
        $(document).on('input', '#Depositinput', function () {
            if (!$(this).val()) {
                $('.userIdfinance').val(''); // Reset user ID if input is cleared
            }
        });
    });

    
    function filterdeposit(username,endfinance, currentPage, pageLimit) {
      $.post(
        `../admin/filterdeposit/${username}/${depositestate}/${startfinance}/${endfinance}/${currentPage}/${pageLimit}`,
        function (response) {
          try {
            const data = JSON.parse(response);
            //  console.log(data)
            //  return
            if (data.deposits.length < 1) {
              $("#financeContainer").html(`
                <tr class="no-results">
                  <td colspan="9">
                    <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                  </td>
                </tr>
              `);
              return;
            }
            $("#maskfinance").LoadingOverlay("hide");
             renderfinace(data.deposits);
          // Render pagination
          renderfinacePagination(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => filterfinance(username, depositestate, startfinance, endfinance, newPage, pageLimit));
          document.getElementById("paging_infofinance").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
    
          } catch (error) {
            console.error("Error parsing JSON response:", error);
          } finally {
            $(".loaderfinance").removeClass("bx-loader bx-spin").addClass("bx-check-double");
          }
        }
      ).fail(function (error) {
        console.error("Error fetching data:", error);
        $(".loaderfinance").removeClass("bx-loader bx-spin").addClass("bx-check-double");
      });
    }

    $(document).on('click', '.executedeposit', function () {
    
      if ($("#Depositinput").val() == "" && $(".startdepo").val() == "" ) {
        // $("#danger-finance").modal("show");
        showToast("Heads up!!","Select one or more data fields to filter","info")
      //  return;
    }
  
      const depositestate = $(".depositestate").val();
      const username = $("#Depositinput").val();
      const startdepo = $(".startdepo").val();
      const enddepo = $(".enddepo").val();
       console.log(username)
       return
   
      filterdeposit(username,startdepo,enddepo,currentPage,pageLimit)
    //   // Show loader
       $(".loaderdeposit").removeClass('bx-check-double').addClass('bx-loader bx-spin');
  
    });
  
  
    
    // Function to fetch and display users
    function fetchUsers(query) {
        let optionsHtml = '';
    
        $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
            try {
                response = typeof response === 'string' ? JSON.parse(response) : response;
                response.forEach(user => {
                  let   displayValues;
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
                     regnames  = user.contact;  // Show contact
                   }else{
                    displayValues = 'no data found ...';
                    regnames  = 'no data found ...';  // Show contact
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


    
  });
  