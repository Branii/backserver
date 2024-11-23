$(function () {
  //NOTE -
  ////////////// LOTTERY BETTING-//////////

  const Lottery = (data) => {
    let htmls = "";
    const bettype = {
      1: "Bet",
      2: "Track",
    };

    const betstatus = {
      2: "Win",
      3: "Loss",
      5: "Pending",
      6: "Void",
      7: "Refund",
    };
    const states = {
      1: "Settled",
      2: "Unsettled",
      4: "Cancelled",
      7: "Refund",
      8: "Delete",
    };

    data.forEach((item) => {
      const betOddsObject = JSON.parse(item.bet_odds);
      const betOddsArray = Object.values(betOddsObject);
      const betodds = betOddsArray * item.multiplier * item.unit_stake;
      htmls += `
                    <tr>
                        <td>${item.bet_code}</td>
                        <td>${item.username}</td>
                        <td>${item.draw_period}</td>
                        <td>${item.name}</td>
                        <td>${item.game_label}</td>
                        <td>${item.bet_date + " " + item.bet_time}</td>
                        <td>${bettype[item.bettype]}</td>
                        <td>${betodds}</td>
                        <td>${item.bet_number}</td>
                         <td>${item.unit_stake}</td>
                        <td>${item.multiplier}</td>
                        <td>${item.bet_amount}</td>
                        <td>${item.win_amount}</td>
                        <td>${item.rebate_amount}</td>
                        <td>${betstatus[item.bet_status]}</td>
                        <td>${states[item.state]}</td>
                        <td>${item.ip_address}</td>
                        <td>
                            
                             <div class="dropdown">
                                    <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                     <i class='bx bx-dots-vertical-rounded'></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                      <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                        <i class="bx bx-show fs-5"></i>View
                                      </a>
                                      <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                        <i class="bx bx-x fs-5" ></i>Cancel Bet
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
    return htmls;
  };

  const renderlottery = (data) => {
    var htmls = Lottery(data);
    $("#lotterydataContainer").html(htmls);
  };

  let currentPage = 1;
  let pageLimit = 50;

  async function fetchLotteryBet(page) {
    try {
      const response = await fetch(`../admin/lotterydata/${page}/${pageLimit}`);
      const data = await response.json();

      console.log(data);
    //   return;

      $("#masks").LoadingOverlay("hide");

      // Render table data
      renderlottery(data.lotterybet);

      // Render pagination
      renderbetPagination(data.totalPages, page);
      document.getElementById("paging_infos").innerHTML =
        "Page " + page + " of " + data.totalPages + " pages";
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }
  function renderbetPagination(totalPages, currentPage) {
    let pagLink = `<ul class='pagination justify-content-end'>`;
  
    // Previous Button
    pagLink += `
      <li class='page-item ${currentPage === 1 ? "disabled" : ""}'>
        <a class='page-link' href='#' data-page='${currentPage - 1}'><i class='bx bx-chevron-left'></i></a>
      </li>
    `;
  
    // Page numbers with ellipsis
    for (let i = 1; i <= totalPages; i++) {
      if (i === currentPage) {
        pagLink += `<li class='page-item active'><a class='page-link' href='#'>${i}</a></li>`;
      } else if (i === 1 || i === totalPages || Math.abs(i - currentPage) <= 2) {
        pagLink += `<li class='page-item'><a class='page-link' href='#' data-page='${i}'>${i}</a></li>`;
      } else if (i === currentPage - 3 || i === currentPage + 3) {
        pagLink += `<li class='page-item disabled'><a class='page-link'>...</a></li>`;
      }
    }
  
    // Next Button
    pagLink += `
      <li class='page-item ${currentPage === totalPages ? "disabled" : ""}'>
        <a class='page-link' href='#' data-page='${currentPage + 1}'><i class='bx bx-chevron-right'></i></a>
      </li>
    `;
  
    pagLink += "</ul>";
    document.getElementById("paginationss").innerHTML = pagLink;
  
    // Add click event listeners to pagination links
    document.querySelectorAll("#paginationss .page-link").forEach((link) => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        const newPage = parseInt(this.getAttribute("data-page"));
        if (newPage > 0 && newPage <= totalPages && newPage !== currentPage) {
          // Update currentPage and display paging information
          currentPage = newPage;
          document.getElementById("paging_infos").innerHTML = `Page ${currentPage} of ${totalPages} pages`;
          
          // Fetch and render new page data
          fetchLotteryBet(currentPage);
        }
      });
    });
  }
  
  fetchLotteryBet(currentPage);


  $(".players").click(function () {
    let direction = $(this).val();
    const tableWrapper = $(".table-wrappers");
    const tableWrappers = document.querySelector(".table-wrappers");
    const scrollAmount = 1000; // Adjust as needed
    const scrollOptions = {
      behavior: "smooth",
    };
    if (tableWrapper.length) {
      switch (direction) {
        case "beteft":
          tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
          break;
        case "betright":
          tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
          break;
        case "betstart":
          // Scroll to the absolute start (leftmost position)
          tableWrappers.animate({ scrollLeft: 0 }, "slow");
          break;
        case "betend":
          const maxScrollLeft =
            tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
          tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
          break;
        default:
          break;
      }
    }
  });

  let debounceTimeout;

  $(".usernames").keyup(function () {
      let searchkeys = $(this).val();
      const dropdowns = $("#userDropdowns");
  
      dropdowns.empty();
      clearTimeout(debounceTimeout);
  
      debounceTimeout = setTimeout(() => {
          if (searchkeys.trim() !== "") { // Check for non-empty input
              $.post(`../admin/filterusername/${searchkeys}`, function (responses) {
                  // Parse response if necessary
                  const users = typeof responses === "string" ? JSON.parse(responses) : responses;
  
                  if (users && users.length > 0) {
                      let html = "";
                      users.forEach((user) => {
                          html += `<div value="${user.username}" class="options">${user.username}</div>`;
                      });
                      // Populate the dropdown and show it
                      dropdowns.html(html);
                      dropdowns.show();
                  } else {
                      // Hide the dropdown if no users are found
                      dropdowns.hide();
                  }
              });
          } else {
              // Hide the dropdown if input is empty
              dropdowns.hide();
          }
      }, 300); // Adjust debounce delay as needed
  });
  
  $(document).on("click", ".options", function () {
      const selectedValue = $(this).text(); // Get the selected username
      $(".usernames").val(selectedValue); // Set the input field with the selected value
      $("#userDropdowns").hide(); // Hide the dropdown after selection
  });
  

  $(".betrefresh").click(function () {
    $('.queryholders').val('');
    $("#masks").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3,
    });
    fetchLotteryBet(currentPage);
  });

  $(".executebet").click(function () {
    console.log("spinning");
    $(".loader").remove("bx bx-check-double").addClass("bx bx-loader bx-spin");
  });

  async function fetchLotteryname() {
    try {
      const response = await fetch(`../admin/fetchLotteryname/`); // Await the fetch call
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
  
      const data = await response.json(); // Parse JSON response
      console.log(data);
      let html = `<option value="all" class="options" selected>-lottery Type-</option>`;
      data.forEach((lottery) => {
          html += `<option value="${lottery.gt_id}" class="options">${lottery.name}</option>`;
      });

      $(".selectlottery").html(html);
  
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }
  fetchLotteryname()
  


});
