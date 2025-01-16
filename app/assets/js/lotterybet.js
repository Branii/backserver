$(function () {
  //NOTE -
  ////////////// LOTTERY BETTING-//////////

  function formatBalance(balance) {
    if (balance % 1 !== 0 && balance.toString().split(".")[1].length > 3) {
        return Number(balance).toFixed(4);
    }
    return Number(balance).toFixed(4);
  }

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
       const username = item.username == '*****' ? item.email :(item.username ||item.contact);
       const statusColor = item.bet_status == "5" ? "bg-warning-subtle text-warning" : (item.bet_status === "2" ? "bg-success-subtle text-success" :  "bg-danger-subtle text-danger");
      htmls += `
                    <tr>
                        <td>${item.bet_code}</td>
                        <td>${username}</td>
                        <td>${formatBalance(item.draw_period)}</td>
                        <td>${item.game_type}</td>
                        <td>${item.game_label}</td>
                        <td>${item.bet_date + " " + item.bet_time}</td>
                        <td>${betodds}</td>
                        <td>${item.bet_number}</td>
                         <td>${item.unit_stake}</td>
                        <td>${item.multiplier}</td>
                        <td>${formatBalance(item.bet_amount)}</td>
                        <td>${formatBalance(item.win_amount)}</td>
                        <td><span class="badge fw-semibold py-1 w-85 ${statusColor}">${betstatus[item.bet_status]}</span></td>
                        <td>${states[item.state]}</td>
                        
                        <td>
                            
                             <div class="dropdown">
                                    <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                     <i class='bx bx-dots-vertical-rounded'></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                      <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 viewbets" href="javascript:void(0);"data-betcode="${item.bet_code}"data-gametype="${item.gt_id}">
                                        <i class="bx bx-show fs-5"></i>View Bet
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

  const Showbettable = (data,obj) => {
    let htmlbet = "";
    Object.entries(data).forEach(([key, value]) => {
    //  console.log(`${key}: ${value}`);

  
      htmlbet += `
            <tr>
                <td>${value}</td>
                <td>${obj[key]}</td>
            </tr>
            `;
    });
    return htmlbet;
  };

  const firstRowbet = {
    'username': 'Username:',
    'bet_code': 'Bet Order ID:',
    'draw_period': 'Issue Number:',
    'ip_address': 'IP:',
    'unit_stake': 'Unit Stake:',
    'multiplier': 'Multiplier:',
    'bet_status': 'Bet Status:',
    'game_label': 'Game Type::',
    'draw_number': 'Draw Results:',
    'num_wins': 'Number of wins:',
    'bettype': 'Bet Type:'
  }

  const secondRowbet = {
    'game_type': 'Lottery Type:',
    'bet_time': 'Bet Time:',
    'closing_time': 'Closing Time:',
    'opening_time': 'Draw Time::',
    'bet_number': 'Total Bet:',
    'bet_amount': 'Total Bet Amount:',
    'win_amount': 'Prize:',
    'server_date': 'Win Amount:',
    'server_time': 'Actual profit:',
    'rebate_amount': 'Rebate Amount',
    'user_selection': 'Bet Details',
  
  }

  const renderlottery = (data) => {
    var htmls = Lottery(data);
    $("#lotterydataContainer").html(htmls);
  };

  let currentPagebet = 1;
  let pageLimit = 50;

  async function fetchLotteryBet(page) {
    try {
      const response = await fetch(`../admin/lotterydata/${page}/${pageLimit}`);
      const data = await response.json();

      console.log(response);
     //  return;

      $("#maskbet").LoadingOverlay("hide");

      // Render table data
      renderlottery(data.lotterybet);

      // Render pagination
      renderbetPagination(data.totalPages,page);
      document.getElementById("paging_infobet").innerHTML =
        "Page " + page + " of " + data.totalPages + " pages";
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  function renderbetPagination(totalPages, currentPage) {
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

    document.getElementById("paginationbet").innerHTML = pagLink;

    // Add click event listeners
    document.querySelectorAll("#paginationbet .page-link").forEach(link => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        const newPage = +this.getAttribute("data-page");
        if (newPage > 0 && newPage <= totalPages) {
          $("#maskbet").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3,
          });
          fetchLotteryBet(newPage);
        }
      });
    });
  }
  
  fetchLotteryBet(currentPagebet);
  
  async function getexample(uidd,gametype,betsate,betstatus,startdates,enddates,currentPagebet,pageLimit){
    $.post(`../admin/filterbetdata/${uidd}/${gametype}/${betsate}/${betstatus}/${startdates}/${enddates}/${currentPagebet}/${pageLimit}`)
    .done(function(response) {
         console.log(response);
        //  return

        try {
            const data = JSON.parse(response); // Parse the response

            if (data.filterbet.length < 1) {
                // If no results, show "no results" message
                let html = `
                    <tr class="no-results">
                        <td colspan="9">
                            <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                        </td>
                    </tr>`;
                $("#lotterydataContainer").html(html);
                $(".loaderbet").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
                return;
            }

            // Render filtered data and pagination
            renderlottery(data.filterbet);
            renderbetPage(data.totalPages,currentPagebet);

            // Update paging info
             document.getElementById("paging_infobet").innerHTML = `Page ${currentPagebet} of ${data.totalPages} pages`;

        } catch (error) {
            console.error("Error parsing JSON response:", error);
            $(".loaderbet").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
        }

        // Hide loader
        $(".loaderbet").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");

    })
  }

  function renderbetPage(totalPages, currentPagebet,uidd,gametype,betsate,betstatus,startdates,enddates) {

    let pagLink = `<ul class='pagination justify-content-end'>`;
  
    // Previous Button
    pagLink += `
      <li class='page-item ${currentPagebet === 1 ? "disabled" : ""}'>
        <a class='page-link' href='#' data-page='${currentPagebet - 1}'><i class='bx bx-chevron-left'></i></a>
      </li>
    `;
  
    // Page numbers with ellipsis
    for (let i = 1; i <= totalPages; i++) {
      if (i === currentPagebet) {
        pagLink += `<li class='page-item active'><a class='page-link' href='#'>${i}</a></li>`;
      } else if (i === 1 || i === totalPages || Math.abs(i - currentPagebet) <= 2) {
        pagLink += `<li class='page-item'><a class='page-link' href='#' data-page='${i}'>${i}</a></li>`;
      } else if (i === currentPagebet - 3 || i === currentPagebet + 3) {
        pagLink += `<li class='page-item disabled'><a class='page-link'>...</a></li>`;
      }
    }
  
    // Next Button
    pagLink += `
      <li class='page-item ${currentPagebet === totalPages ? "disabled" : ""}'>
        <a class='page-link' href='#' data-page='${currentPagebet + 1}'><i class='bx bx-chevron-right'></i></a>
      </li>
    `;
  
    pagLink += "</ul>";
    document.getElementById("paginationbet").innerHTML = pagLink;
  
    // Add click event listeners to pagination links
    document.querySelectorAll("#paginationbet .page-link").forEach((link) => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        const newPage = parseInt(this.getAttribute("data-page"));
        if (newPage > 0 && newPage <= totalPages && newPage !== currentPagebet) {
          // Update currentPagebet and display paging information
        
          document.getElementById("paging_infobet").innerHTML = `Page ${currentPagebet} of ${totalPages} pages`;
          
          // Fetch and render new page data
          getexample(uidd,gametype,betsate,betstatus,startdates,enddates,newPage,pageLimit)
        //  getexample()
        }
      });
    });
  }
  
  $(".playerbet").click(function () {
    let direction = $(this).val();
    const tableWrapper = $(".table-wrapperlottery");
    const tableWrappers = document.querySelector(".table-wrapperlottery");
    const scrollAmount = 1000; // Adjust as needed
    const scrollOptions = {
      behavior: "smooth",
    };
    if (tableWrapper.length) {
      switch (direction) {
        case "betleft":
          tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
          break;
        case "betright":
          tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
          break;
        case "betstart":
          // Scroll to the absolute start (leftmost position)
          tableWrapper.animate({ scrollLeft: 0 }, "slow");
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

  $(".betrefresh").click(function () {
    $('.queryholderlist').val('');
    $("#maskbet").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3,
    });
    fetchLotteryBet(currentPagebet);
  });

  $(".executebet").click(function () {
    // Get form data
    const uidd = $('.userIdbet').val();
    const gametype = $('.typelottery').val();
    const betsate = $('.betsate').val();
    const betstatus = $('.betstatus').val();
    const startdates = $('.startdates').val();
    const enddates = $('.enddates').val();

    getexample(uidd,gametype,betsate,betstatus,startdates,enddates,currentPagebet,pageLimit)

    // Show loader
    $(".loaderbet").removeClass("bx bx-check-double").addClass("bx bx-loader bx-spin");

    // Make AJAX request

      
  });

  async function fetchLotteryname() {
    try {
      const response = await fetch(`../admin/fetchLotteryname/`); // Await the fetch call
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }

      const data = await response.json(); // Parse JSON response
      // console.log(data);
      let html = `<option value="" class="" selected>-lottery Type-</option>`;
      data.forEach((lottery) => {
          html += `<option value="${lottery.gt_id}" class="">${lottery.name}</option>`;
      });

      $(".selectlottery").html(html);
  
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }
  fetchLotteryname()
  
  // viewbets
  $(document).on("click",".viewbets",function(){
    $("#viewbetsmodal").modal("show")
    const betcode = $(this).attr("data-betcode")
    const gametype = $(this).attr("data-gametype")
    // console.log(betcode)
    $("#rowbet").html("")
    $("#rowbe1").html("")
     viewstakedBet(betcode,gametype)
  })

  async function viewstakedBet(betcode,gametype) {
      try {
        const response = await fetch(`../admin/viewBetstake/${betcode}/${gametype}`);
        const data = await response.json();
        // console.log(response)
        //  return
        let htmlbet1 = Showbettable(firstRowbet,data)
        let htmlbet2 = Showbettable(secondRowbet,data)
        $("#rowbet").html(htmlbet1)
        $("#rowbet1").html(htmlbet2)

      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }



  let debounceTimeout = null;

  $(document).ready(function () {
      // Event listener for keyup on #myInput
      $(document).on('keyup', '#myInput', function () {
          const query = $(this).val().trim();

          // Only trigger if input is more than 2 characters
          if (query.length > 1) {
              clearTimeout(debounceTimeout); // Clear any existing timeout
              debounceTimeout = setTimeout(fetchbetUser, 500, query); // Call fetchUsers with the query after 500ms delay
          } else {
              $('.userDropdownb').hide(); // Hide dropdown if input is less than 3 characters
          }
      });

      // Handle dropdown item selection
      $(document).on('change', '.userDropdownb', function () {
          const selectedOption = $(this).find('option:selected');
          const selectedUserId = selectedOption.val();
          const selectedUsername = selectedOption.data('username');

          if (selectedUserId) {
              $('#myInput').val(selectedUsername);
              $('.userIdbet').val(selectedUserId);
              $('.userDropdownb').hide();
          }
      });

      // Handle manual input clearing
      $(document).on('input', '#myInput', function () {
          if (!$(this).val()) {
              $('.userIdbet').val(''); // Reset user ID if input is cleared
          }
      });
  });

  // Function to fetch and display users
  function fetchbetUser(query) {
  

      $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
          try {
              response = typeof response === 'string' ? JSON.parse(response) : response;

              let optionsHtml = '';

              // Iterate through each item in the response array
              response.forEach(item => {
                  // Create an array of possible username types (email, username, contact) for each user
                  const userOptions = [
                      { "uid": item.uid, "username": item.username, "reg_type": "username" },
                      { "uid": item.uid, "username": item.email, "reg_type": "email" },
                      { "uid": item.uid, "username": item.contact, "reg_type": "contact" }
                  ];
              
                  // Filter to select the correct username based on the `reg_type`
                  const validUser = userOptions.find(user => {
                      // Check for the correct username based on the reg_type
                      return (user.reg_type === "email" && user.username === item.email) ||
                             (user.reg_type === "username" && user.username === item.username) ||
                             (user.reg_type === "contact" && user.username === item.contact);
                  });
              
                  // If a valid user option is found, append it to the options HTML
                  if (validUser) {
                      optionsHtml += `<option class="optionlist" value="${validUser.uid}" data-username="${validUser.username}">${validUser.username}</option>`;
                
                  }
                 
              });


              $('.userDropdownb').html(optionsHtml).show();
          } catch (error) {
              console.error("Error parsing response: ", error);
              $('.userDropdownb').hide();
          }
      }).fail(function () {
          console.error("Error fetching users.");
          $('.userDropdownb').hide();
      });
  }

  function tableScroll() {
    const tableContainerBetting = document.querySelector(".table-wrapperlottery");
    const headerRowBetting = document.querySelector(".lottery_betting");

    tableContainerBetting.addEventListener("scroll", function () {
      if (tableContainerBetting.scrollTop > 0) {
        headerRowBetting.classList.add("sticky-headerRow");
      } else {
        headerRowBetting.classList.remove("sticky-headerRow");
      }
    });
  }
  tableScroll();


});