$(function () {
    //NOTE -
    ////////////// LOTTERY BETTING-//////////
  
    const  Trackbetdata = (data) => {
      let htmls = "";
      const bettype = {
        1: "Bet",
        2: "Track",
      };
  
      const trackstatus  = {
        1: "Pending",
        2: "User Cancellation",
        3: "Completed",
        4: "Win Stop Track",
        5: "Not Win Stop Track",
      };
      const states = {
        1: "Settled",
        2: "Unsettled",
        4: "Cancelled",
        7: "Refund",
        8: "Delete",
      };
  
      data.forEach((item) => {
        let username = item.reg_type === "email" ? item.email : (item.reg_type === "username" ? item.username : item.contact);
        htmls += `
                      <tr>
                          <td>${item.track_token}</td>
                          <td>${username}</td>
                          <td>${item.game_type}</td>
                          <td>${item.start_draw}</td>
                          <td>${item.total_bets + "/" + item.total_track}</td>
                          <td>${item.total_amount + "/" + item.done_amount}</td>                  
                          <td>${trackstatus[item.track_status]}</td>
                          <td>${item.total_prize}</td>
                         <td>${item.track_rule}</td>
                         <td>${item.server_date + "/" + item.server_time}</td>
                     
                         
                          
                          <td>
                              
                               <div class="dropdown">
                                      <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                       <i class='bx bx-dots-vertical-rounded'></i>
                                      </a>
                                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                        <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 viewbets" href="javascript:void(0);"data-betcode="${item.bet_code}"data-gametype="${item.game_type}">
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
  
   
    // const firstRowbet = {
    //   'username': 'Username:',
    //   'bet_code': 'Bet Order ID:',
    //   'draw_period': 'Issue Number:',
    //   'ip_address': 'IP:',
    //   'unit_stake': 'Unit Stake:',
    //   'multiplier': 'Multiplier:',
    //   'bet_status': 'Bet Status:',
    //   'game_label': 'Game Type::',
    //   'draw_number': 'Draw Results:',
    //   'num_wins': 'Number of wins:',
    //   'bettype': 'Bet Type:'
    // }
  
    // const secondRowbet = {
    //   'game_type': 'Lottery Type:',
    //   'bet_time': 'Bet Time:',
    //   'closing_time': 'Closing Time:',
    //   'opening_time': 'Draw Time::',
    //   'bet_number': 'Total Bet:',
    //   'bet_amount': 'Total Bet Amount:',
    //   'win_amount': 'Prize:',
    //   'server_date': 'Win Amount:',
    //   'server_time': 'Actual profit:',
    //   'rebate_amount': 'Rebate Amount',
    //   'user_selection': 'Bet Details',
    
    // }
  
    const rendertrack = (data) => {
      var htmls = Trackbetdata(data);
      $("#trackdataContainer").html(htmls);
    };
  
    let currentPagetrack = 1;
    let pageLimit = 45;
  
    async function fetchtrackdata(page) {
      try {
        const response = await fetch(`../admin/trackdata/${page}/${pageLimit}`);
        const data = await response.json();
  
    //    console.log(response);
    //    return;
  
        $("#masktrack").LoadingOverlay("hide");
  
        // Render table data
        rendertrack(data.trackbet);
  
        // Render pagination
        rendertrackPagination(data.totalPages, page);
        document.getElementById("paging_infobet").innerHTML =
          "Page " + page + " of " + data.totalPages + " pages";
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
    function rendertrackPagination(totalPages, currentPagetrack) {
      let pagLink = `<ul class='pagination justify-content-end'>`;
    
      // Previous Button
      pagLink += `
        <li class='page-item ${currentPagetrack === 1 ? "disabled" : ""}'>
          <a class='page-link' href='#' data-page='${currentPagetrack - 1}'><i class='bx bx-chevron-left'></i></a>
        </li>
      `;
    
      // Page numbers with ellipsis
      for (let i = 1; i <= totalPages; i++) {
        if (i === currentPagetrack) {
          pagLink += `<li class='page-item active'><a class='page-link' href='#'>${i}</a></li>`;
        } else if (i === 1 || i === totalPages || Math.abs(i - currentPagetrack) <= 2) {
          pagLink += `<li class='page-item'><a class='page-link' href='#' data-page='${i}'>${i}</a></li>`;
        } else if (i === currentPagetrack - 3 || i === currentPagetrack + 3) {
          pagLink += `<li class='page-item disabled'><a class='page-link'>...</a></li>`;
        }
      }
    
      // Next Button
      pagLink += `
        <li class='page-item ${currentPagetrack === totalPages ? "disabled" : ""}'>
          <a class='page-link' href='#' data-page='${currentPagetrack + 1}'><i class='bx bx-chevron-right'></i></a>
        </li>
      `;
    
      pagLink += "</ul>";
      document.getElementById("paginationtrack").innerHTML = pagLink;
    
      // Add click event listeners to pagination links
      document.querySelectorAll("#paginationtrack .page-link").forEach((link) => {
        link.addEventListener("click", function (e) {
          e.preventDefault();
          const newPage = parseInt(this.getAttribute("data-page"));
          if (newPage > 0 && newPage <= totalPages && newPage !== currentPagetrack) {
            // Update currentPagetrack and display paging information
            currentPagetrack = newPage;
            document.getElementById("paging_infotrack").innerHTML = `Page ${currentPagetrack} of ${totalPages} pages`;
            
            // Fetch and render new page data
            fetchtrackdata(currentPagetrack);
          }
        });
      });
    }
    
    fetchtrackdata(currentPagetrack);
  
  
    $(".playerbet").click(function () {
      let direction = $(this).val();
      const tableWrapper = $(".table-wrappertrack");
      const tableWrappers = document.querySelector(".table-wrappertrack");
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
  
    
    $(".refreshtrack").click(function () {
      $('.queryholderlist').val('');
      $("#masktrack").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3,
      });
      fetchtrackdata(currentPagetrack);
    });
  
    $(".executetrack").click(function () {
   //   console.log("spinning");
      const betdata = $(".betform").serialize();
      console.log(betdata);
      $(".loaderbet").remove("bx bx-check-double").addClass("bx bx-loader bx-spin");
      try {
        $.post(`../admin/filterbetdatas/${betdata}/${pageLimit}`,
           function(response) {
               console.log(response)
              //  return
              const data = JSON.parse(response);
              if (data.filterbet.length < 1) {
                let html = `
                    <tr class="no-results" >
                    <td colspan="9">
                         <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                    </td>
                 </tr>`
                $("#lotterydataContainer").html(html);
                return
              }
           
              renderlottery(data.filterbet);
              renderbetPagination(data.totalPages, currentPagetrack,betdata);
          document.getElementById("paging_infotrack").innerHTML =
            "Page " + currentPagetrack + " of " + data.totalPages + " pages";
          });
          
      } catch (error) {
        console.error("Error fetching data:", error);
       }
  
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
    
  
  
    let debounceTimeout = null;

    $(document).ready(function () {
        // Event listener for keyup on #myInput
        $(document).on('keyup', '#trackinput', function () {
            const query = $(this).val().trim();
  
            // Only trigger if input is more than 2 characters
            if (query.length > 1) {
                clearTimeout(debounceTimeout); // Clear any existing timeout
                debounceTimeout = setTimeout(fetchbetUser, 500, query); // Call fetchUsers with the query after 500ms delay
            } else {
                $('.trackdown').hide(); // Hide dropdown if input is less than 3 characters
            }
        });
  
        // Handle dropdown item selection
        $(document).on('change', '.trackdown', function () {
            const selectedOption = $(this).find('option:selected');
            const selectedUserId = selectedOption.val();
            const selectedUsername = selectedOption.data('username');
  
            if (selectedUserId) {
                $('#trackinput').val(selectedUsername);
                $('.userIdbet').val(selectedUserId);
                $('.trackdown').hide();
            }
        });
  
        // Handle manual input clearing
        $(document).on('input', '#trackinput', function () {
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
                    displayValuebet = "no data found...";
                    regnamebet = "no data found..."// Show contact
                   }
                        optionsHtml += `<option class="optionlist" value="${user.uid}" data-username="${regnamebet}">${displayValuebet}</option>`;
             
                });
  
  
                $('.trackdown').html(optionsHtml).show();
            } catch (error) {
                console.error("Error parsing response: ", error);
                $('.trackdown').hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $('.trackdown').hide();
        });
    }
  
  
  function tableScrolltrack() {
    const tableContainerTrack = document.querySelector(".table-wrappertrack");
        const headerRowTrack = document.querySelector(".trackheadrow");

        tableContainerTrack.addEventListener("scroll", function () {
          if (tableContainerTrack.scrollTop > 0) {
            headerRowTrack.classList.add("sticky-trackhead");
          } else {
            headerRowTrack.classList.remove("sticky-trackhead");
          }
        });
  }
  tableScrolltrack();

 
  
  });
  