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
       const username = item.username == '*****' ? item.email :(item.username ||item.contact);

      console.log(item.username)
      htmls += `
                    <tr>
                        <td>${item.bet_code}</td>
                        <td>${username}</td>
                        <td>${item.draw_period}</td>
                        <td>${item.game_type}</td>
                        <td>${item.game_label}</td>
                        <td>${item.bet_date + " " + item.bet_time}</td>
                        <td>${betodds}</td>
                        <td>${item.bet_number}</td>
                         <td>${item.unit_stake}</td>
                        <td>${item.multiplier}</td>
                        <td>${item.bet_amount}</td>
                        <td>${item.win_amount}</td>
                       
                        <td>${betstatus[item.bet_status]}</td>
                        
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
 //   let displayValue = ;
  //  if (key === 'user_selection') {
      // Create a textarea for user selection
    //  displayValue = `<td><textarea rows="4">${key}</textarea></td>`;
  //} 
  
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
  let pageLimit = 30;

  async function fetchLotteryBet(page) {
    try {
      const response = await fetch(`../admin/lotterydata/${page}/${pageLimit}`);
      const data = await response.json();

     // console.log(response);
     //  return;

      $("#maskbet").LoadingOverlay("hide");

      // Render table data
      renderlottery(data.lotterybet);

      // Render pagination
      renderbetPagination(data.totalPages,page,uidd,gametype,betsate,betstatus,startdates,enddates);
      document.getElementById("paging_infobet").innerHTML =
        "Page " + page + " of " + data.totalPages + " pages";
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  async function getexample(uidd,gametype,betsate,betstatus,startdates,enddates,currentPagebet,pageLimit){
    $.post(`../admin/filterbetdata/${uidd}/${gametype}/${betsate}/${betstatus}/${startdates}/${enddates}/${currentPagebet}/${pageLimit}`)
    .done(function(response) {
        console.log(response);

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
            renderbetPagination(data.totalPages, currentPagebet, uidd,gametype,betsate,betstatus,startdates,enddates);

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

  function renderbetPagination(totalPages, currentPagebet,uidd,gametype,betsate,betstatus,startdates,enddates) {
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
          fetchLotteryBet(newPage,uidd,gametype,betsate,betstatus,startdates,enddates);
        }
      });
    });
  }
  
  fetchLotteryBet(currentPagebet);


  $(".playerbet").click(function () {
    let direction = $(this).val();
    const tableWrapper = $(".table-wrapperlist");
    const tableWrappers = document.querySelector(".table-wrapperlist");
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
    console.log(betcode)
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


// let debounceTimeout =null; // To store the timeout ID
// $(document).ready(function () {
//     // Event listener for keyup
//     $(document).on('keyup','#myInput', function () {
//         const query = $(this).val().trim();

//         if (query.length > 2) { // Only trigger if input is more than 2 characters
//             clearTimeout(debounceTimeout); // Clear any existing timeout
//             debounceTimeout = setTimeout(() => {
//                 // Call the filterUsers logic directly here
//                 let optionsHtml = '';

//                 $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
//                     try {
                      
//                         if (typeof response === 'string') {
//                             response = JSON.parse(response); // Parse string response
//                         }

//                         const formattedArray = response.flatMap(item => [
//                           { "uid": item.uid, "username": item.username },
//                           { "uid": item.uid, "username": item.nickname }
//                         ]);
//                         const filteredUsers = formattedArray.filter(user => user.username !== '*****');
//                         filteredUsers.forEach(user => {
//                           optionsHtml += `<option class ="optionlist"  value="${user.uid}" data-username="${user.username}">${user.username}</option>`;
//                         })

//                         //console.log(optionsHtml)

//                         $('.userDropdown').html(optionsHtml).show(); 

//                     } catch (error) {
//                         console.error("Error parsing response: ", error);
//                         $('.userDropdown').hide();
//                     }
//                 }).fail(function (error) {
//                     console.error("Error fetching users: ", error);
//                     $('.userDropdown').hide();
//                 });
//             }, 500); // 500ms debounce delay
//         } else {
//             $('.userDropdown').hide(); // Hide dropdown if input is less than 3 characters
//         }
//     });

//     // Handle dropdown item click
//     $(document).on('change', '.userDropdown', function () {
//       const selectedOption = $(this).find('option:selected'); // Get the selected <option>
//       const selectedUserId = selectedOption.val(); // Get user ID from the value attribute
//       const selectedUsername = selectedOption.data('username'); // Get username from data-attribute
//       if (selectedUserId) {
//         $('#myInput').val(selectedUsername); 
//         $('.userIdbet').val(selectedUserId); 
//         $('.userDropdown').hide();  
//       }
   
//   });

//   $(document).on('input', '#myInput', function () {
//     const inputValue = $(this).val(); // Get the current value of the input
//     if (!inputValue) {
//         // If input is cleared, reset the user ID as well
//         $('.userIdbet').val('');
//         console.log('User manually cleared the username');
//     }
// });
// });


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
            $('.userDropdown').hide(); // Hide dropdown if input is less than 3 characters
        }
    });

    // Handle dropdown item selection
    $(document).on('change', '.userDropdown', function () {
        const selectedOption = $(this).find('option:selected');
        const selectedUserId = selectedOption.val();
        const selectedUsername = selectedOption.data('username');

        if (selectedUserId) {
            $('#myInput').val(selectedUsername);
            $('.userIdbet').val(selectedUserId);
            $('.userDropdown').hide();
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
    let optionsHtml = '';

    $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
        try {
            response = typeof response === 'string' ? JSON.parse(response) : response;

            const filteredUsers = response.flatMap(item => [
                { "uid": item.uid, "username": item.username },
                { "uid": item.uid, "username": item.email },
                { "uid": item.uid, "username": item.contact }
            ]).filter(user => user.username !== '*****');

            filteredUsers.forEach(user => {
                optionsHtml += `<option class="optionlist" value="${user.uid}" data-username="${user.username}">${user.username}</option>`;
            });

            $('.userDropdown').html(optionsHtml).show();
        } catch (error) {
            console.error("Error parsing response: ", error);
            $('.userDropdown').hide();
        }
    }).fail(function () {
        console.error("Error fetching users.");
        $('.userDropdown').hide();
    });
}



});
