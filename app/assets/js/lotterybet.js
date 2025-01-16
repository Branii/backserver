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

    const status = {
      2: { title: "Win", color: "#4CAF50" }, // Green
      3: { title: "Loss", color: "#E91E63" }, // Red
      5: { title: "Pending", color: "#9E9E9E" }, // Grey
      6: { title: "Void", color: "#F44336" },
      7: { title: "Refund", color: "#03A9F4" }, // Light Blue
    
  };

    data.forEach((item) => {
       const betOddsObject = JSON.parse(item.bet_odds);
       const betOddsArray = Object.values(betOddsObject);
       const betodds = betOddsArray * item.multiplier * item.unit_stake;
       let username = item.reg_type === "email" ? item.email : (item.reg_type === "username" ? item.username : item.contact);

      // console.log(item.username)
      htmls += `
                    <tr>
                        <td>${item.bet_code}</td>
                        <td>${username}</td>
                        <td>${item.draw_period}</td>
                        <td>${item.game_type}</td>
                        <td>${item.game_label}</td>
                        <td>${item.bet_date + " " + item.bet_time}</td>
                        <td>${item.bet_number}</td>
                        <td>${item.unit_stake}</td>
                        <td>${item.multiplier}</td>
                        <td>${formatBalance(item.bet_amount)}</td>
                        <td>${formatBalance(item.win_amount)}</td>
                         <td><i class='bx bxs-circle' style='color:${status[item.bet_status].color};font-size:8px;margin-right:5px;'></i>${status[item.bet_status].title}</td>
                 
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
   
      htmlbet += `
            <tr>
              <td>${value}</td>
              <td class="${key === "user_selection" ? "bet_userSelection" : ""}" 
                ${key === "user_selection" ? `title="${obj[key]}"` : ""}>
                ${obj[key]}
              </td>
            </tr>
            `;
    });
    return htmlbet;
  };

 
  const firstRowbet = {
    'reg_type': 'Username:',
    'bet_code': 'Bet Order ID:',
    'draw_period': 'Issue Number:',
    'ip_address': 'IP:',
    'unit_stake': 'Unit Stake:',
    'multiplier': 'Multiplier:',
    'bet_status': 'Bet Status:',
    'game_label': 'Game Type::',
    'draw_number': 'Draw Results:',
    'num_wins': 'Number of wins:',
  
  }

  const secondRowbet = {
    'bettype': 'Bet Type:',
    'game_type': 'Lottery Type:',
    'bet_time': 'Bet Time:',
    'closing_time': 'Closing Time:',
    'opening_time': 'Draw Time::',
    'bet_number': 'Total Bet:',
    'bet_amount': 'Total Bet Amount:',
    // 'win_amount': 'Prize:',
    'win_amount': 'Win Amount:',
    // 'server_time': 'Actual profit:',
    'rebate_amount': 'Rebate Amount',
    'user_selection': 'Bet Details',

  
  }

  const renderlottery = (data) => {
    var htmls = Lottery(data);
    $("#lotterydataContainer").html(htmls);
  };


  let currentPagebet = 1;
  let pageLimit = 40;
  
  // Fetch lottery bet data
  async function fetchLotteryBet(currentPagebet) {
    try {
      const response = await fetch(`../admin/lotterydata/${currentPagebet}/${pageLimit}`);
      const data = await response.json();
      console.log(response)
    
      $("#maskbet").LoadingOverlay("hide");
      const totalPages = data.totalPages;
      renderlottery(data.lotterybet);
      renderbetPagination(totalPages, currentPagebet, (page) => fetchLotteryBet(page,pageLimit)); // Pass callback
      document.getElementById("paging_infobet").innerHTML = 
        `Page ${currentPagebet} of ${totalPages} pages`;
    } catch (error) {
   //   console.error("Error fetching data:", error);
    }
  }
  
  fetchLotteryBet(currentPagebet,pageLimit);
  // Render pagination dynamically
  function renderbetPagination(totalPages, currentPagebet, callback) {
    if (totalPages === 0) {
      // Handle the case where there are no pages (no records)
      document.getElementById("pagination").innerHTML = "No records available.";
      return;
  }
    let pagLink = `<ul class='pagination justify-content-end'>`;
  
    // Previous Button
    pagLink += `
      <li class='page-item ${currentPagebet === 1 ? "disabled" : ""}'>
        <a class='page-link' href='#' data-page='${currentPagebet - 1}'>
          <i class='bx bx-chevron-left'></i>
        </a>
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
        <a class='page-link' href='#' data-page='${currentPagebet + 1}'>
          <i class='bx bx-chevron-right'></i>
        </a>
      </li>
    `;
  
    pagLink += "</ul>";
    document.getElementById("paginationbet").innerHTML = pagLink;
  
    // Add click event listeners to the pagination links
    document.querySelectorAll("#paginationbet .page-link").forEach((link) => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        const newPage = parseInt(this.getAttribute("data-page"));
  
        // Ensure the new page is within bounds
        if (newPage > 0 && newPage <= totalPages && newPage !== currentPagebet) {
          $("#maskbet").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3,
          });
          callback(newPage); // Dynamically call the provided function
        }
      });
    });
  }
  
  // Filter and fetch lottery bet data
  async function filterbetdatas(uidd,gametype,betsate,betstatus,startdates,enddates,currentPagebet,pageLimit) {
    $.post(`../admin/filterbetdata/${uidd}/${gametype}/${betsate}/${betstatus}/${startdates}/${enddates}/${currentPagebet}/${pageLimit}`)
      .done(function (response) {
        try {
          const data = JSON.parse(response);
  
          if (data.filterbet.length < 1) {
            // If no results, show "no results" message
            let html = `
              <tr class="no-results">
                <td colspan="9">
                  <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                </td>
              </tr>`;
            $("#lotterydataContainer").html(html);
            $("#maskbet").LoadingOverlay("hide");
            $(".loaderbet").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
            return;
          }
          $("#maskbet").LoadingOverlay("hide");
          renderlottery(data.filterbet);
          renderbetPagination(data.totalPages, currentPagebet, (page) => {
            filterbetdatas(uidd, gametype, betsate, betstatus, startdates, enddates, page, pageLimit);
          }); // Pass callback
  
          document.getElementById("paging_infobet").innerHTML = 
            `Page ${currentPagebet} of ${data.totalPages} pages`;
        } catch (error) {
          console.error("Error parsing JSON response:", error);
          $(".loaderbet").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
        }
  
        $(".loaderbet").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
      });
  }
  
  // Initialize

  
  
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
    $('.queryholderbet').val('');
    $('.userIdbet').val('')
    $("#maskbet").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3,
    });
    currentPagebet = 1;
    pageLimit = 50;
    fetchLotteryBet(currentPagebet, pageLimit);
  });




  $(".executebet").click(function () {
    // Get form data
    const uidd = $('.userIdbet').val();
    const gametype = $('.typelottery').val();
    const betsate = $('.betsate').val();
    const betstatus = $('.betstatus').val();
    const startdates = $('.startdates').val();
    const enddates = $('.enddates').val();
    console.log(startdates)
    console.log(enddates)

    filterbetdatas(uidd,gametype,betsate,betstatus,startdates,enddates,currentPagebet,pageLimit)

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
      let html = `<option value=""selected>-lottery Type-</option>`;
      data.forEach((lottery) => {
          html += `<option value="${lottery.gt_id}">${lottery.name}</option>`;
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
    console.log(betcode)
    console.log(gametype)
    $("#rowbet").empty()
    $("#rowbe1").empty()
     viewstakedBet(betcode,gametype)
  })

    async function viewstakedBet(betcode,gametype) {
      try {
        const response = await fetch(`../admin/viewBetstake/${betcode}/${gametype}`);
        const data = await response.json();
        //  console.log(response)
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

              response.forEach(user => {
                let   displayValuebet;
                let regnamebet;
                 // Display based on regtype
                 if (user.regtype === "email") {
                  displayValuebet = user.email;
                  regnamebet = user.email;  // Show email
                 } else if (user.regtype === "username") {
                  displayValuebet = user.username;
                  regnamebet = user.username;  // Show username
                 } else if (user.regtype === "contact") {
                  displayValuebet = user.contact;
                  regnamebet  = user.contact;  // Show contact
                 }else{
                  displayValuebet = 'no data found...'
                 }
                      optionsHtml += `<option class="optionlist" value="${user.uid}" data-username="${regnamebet}">${displayValuebet}</option>`;
           
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


    $(".numrowsbet").change(function () {
      $("#maskbet").LoadingOverlay("show", {
          background: "rgb(90,106,133,0.1)",
          size: 3,
        });
        const numrowbet = $(this).val(); // Get the selected number of rows
        pageLimit = parseInt(numrowbet, 10); // Update the global pageLimit
        currentPagebet = 1; // Reset to the first page when rows per page changes
        fetchLotteryBet(currentPagebet, pageLimit);
  });
  function tableScroll() {
    const tableContainerBetting = document.querySelector(".table-wrapperlottery");
    const headerRowBetting = document.querySelector(".headrowbet");

    tableContainerBetting.addEventListener("scroll", function () {
      if (tableContainerBetting.scrollTop > 0) {
        headerRowBetting.classList.add("sticky-headerbet");
      } else {
        headerRowBetting.classList.remove("sticky-headerbet");
      }
    });
  }
  tableScroll();


});
