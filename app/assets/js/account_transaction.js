$(function () {

  const AccountTransactions = (data) => {
   
    let html = "";
    const status = {
      1: { title: "Deposit", color: "#4CAF50" },          // Green
      2: { title: "Win Bonus", color: "#FF9800" },         // Orange
      3: { title: "Bet Awarded", color: "#03A9F4" },       // Light Blue
      4: { title: "Withdrawal", color: "#F44336" },        //pink
      5: { title: "Bet Deduct", color: "#E91E63" },       // Red
      6: { title: "Bet Cancelled", color: "#9E9E9E" },     // Grey
      7: { title: "Rebates", color: "#8BC34A" },           // Light Green
      8: { title: "Self Rebate", color: "#00BCD4" },       // Cyan
      9: { title: "Send Red Envelope", color: "#FF5722" }, // Deep Orange
      10: { title: "Receive Red Envelope", color: "#795548" }, // Brown
      11: { title: "Bet Refund", color: "#FFC107" }        // Amber
    };

    data.forEach((item) => {
      //let username = item.reg_type === "email" ? item.email : (item.reg_type === "username" ? item.username : item.contact);

      html += `
                  <tr class="trow">
                    <td>${'TR' + item.order_id.substring(0, 7)}</td>
                      <td>${item.username}</td>
                      <td><i class='bx bxs-circle' style='color:${status[item.order_type].color};font-size:8px;margin-right:5px;'></i>${status[item.order_type].title}</td>
                      <td>${Number(item.account_change) < 0 ? Number(item.account_change).toFixed(4) : `+ ${Number(item.account_change).toFixed(4)}`}</td>
                      <td>${Number(item.balance).toFixed(4)}</td>
                      <td>${item.dateTime}</td>
                      <td>${item.order_id}</td>
                      <td><i class='bx bxs-circle' style='color:#1dd846;font-size:8px'></i> Complete</td>
                      <td><i value='${item.order_id}_${item.game_type}' class='bx bx-info-circle tinfo' style='color:#868c87;font-size:18px;cursor:pointer;'></i></td>
                  </tr>
              `;
    });
    return html;
  };

  const FromTable = (data,obj) => {
    let html = "";
    Object.entries(data).forEach(([key, value]) => {
     // console.log(`${key}: ${value}`);
      html += `
            <tr>
                <td>${value}</td>
                <td>${obj[key]}</td>
            </tr>
            `;
    });
    return html;
  };

  const firstRow = {
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

  const secondRow = {
    'game_type': 'Lottery Type::',
    'bet_time': 'Bet Time:',
    'closing_time': 'Closing Time:',
    'opening_time': 'Draw Time::',
    'bet_number': 'Total Bet:',
    'bet_amount': 'Total Bet Amount:',
    'win_amount': 'Prize:',
    'server_date': 'Win Amount:',
    'server_time': 'Actual profit:',
    'user_selection': 'Bet Details',
    'test': ' ',
  }

  const render = (data) => {
    var html = AccountTransactions(data);
    $("#dataContainer").html(html);
  };

  let currentPage = 1;
  let pageLimit = 50;


  async function fetchTrasaction(page,pageLimit) {
    try {
      const response = await fetch(`../admin/transactiondata/${page}/${pageLimit}`);
      const data = await response.json();
      // console.log(response)
      // return
 
      $("#mask").LoadingOverlay("hide")
      render(data.transaction);

      // Render pagination
      renderPagination(data.totalPages, page,pageLimit, 'normal');
      document.getElementById("paging_info").innerHTML = 'Page ' + page + ' of ' + data.totalPages + ' pages'
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  async function filterTrasaction(username, orderid, ordertype, startdate, enddate,currentPage,pageLimit) {
    try {
      const response = await fetch(`../admin/filtertransactions/${username}/${orderid}/${ordertype}/${startdate}/${enddate}/${currentPage}/${pageLimit}`);
      const data = await response.json();

      //  console.log(response)
      // return

      $(".loader").removeClass('bx bx-loader bx-spin').addClass('bx bx-check-double');
      if (data.transactions.length < 1) {
        let html = `
            <tr class="no-results" >
            <td colspan="9">
                 <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
            </td>
         </tr>`
        $("#dataContainer").html(html);
        return
      }
      $("#mask").LoadingOverlay("hide")
      render(data.transactions);

      // Render pagination
      renderPaginationFilter(data.totalPages, currentPage, username, orderid, ordertype, startdate, enddate);
      document.getElementById("paging_info").innerHTML = 'Page ' + currentPage + ' of ' + data.totalPages + ' pages'
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  async function fetchTrasactionBet(transactionId) {
    try {
      const response = await fetch(`../admin/getTransactionBet/${transactionId}`);
      const data = await response.json();

      $("#row1").html("")
      $("#row2").html("")
      let html1 = FromTable(firstRow,data)
      let html2 = FromTable(secondRow,data)
      $("#row1").html(html1)
      $("#row2").html(html2)

    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  function renderPagination(totalPages, currentPage) {
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

    document.getElementById("pagination").innerHTML = pagLink;

    // Add click event listeners
    document.querySelectorAll("#pagination .page-link").forEach(link => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        const newPage = +this.getAttribute("data-page");
        if (newPage > 0 && newPage <= totalPages) {
         fetchTrasaction(newPage,pageLimit);
        }
      });
    });
  }

  function renderPaginationFilter(totalPages, currentPage, username, orderid, ordertype, startdate, enddate) {
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

    document.getElementById("pagination").innerHTML = pagLink;

    // Add click event listeners
    document.querySelectorAll("#pagination .page-link").forEach(link => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        const newPage = +this.getAttribute("data-page");
        if (newPage > 0 && newPage <= totalPages) {
          $("#mask").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3
          });
          filterTrasaction(username, orderid, ordertype, startdate, enddate,newPage, pageLimit, );
        }
      });
    });
  }

  fetchTrasaction(currentPage,pageLimit);

  $(".player").click(function () {

    let direction = $(this).val();
    const tableWrapper = $(".table-wrapper");
    const tableWrappers = document.querySelector(".table-wrapper");
    const scrollAmount = 1000; // Adjust as needed
    const scrollOptions = {
      behavior: 'smooth',
    };
    if (tableWrapper.length) {

      switch (direction) {
        case 'left':
          tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
          break;
        case 'right':
          tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
          break;
        case 'start':
          // Scroll to the absolute start (leftmost position)
          tableWrapper.animate({ scrollLeft: 0 }, 'slow');
          break;
        case 'end':
          const maxScrollLeft = tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
          tableWrapper.animate({ scrollLeft: maxScrollLeft }, 'slow');
          break;
        default:
          break;
      }


    }
  })

  $(".refresh").click(function () {
    //$(".queryholder").val("")
    $("#mask").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3
    });
    fetchTrasaction(currentPage,pageLimit);
  })

  // let timeout;
  // let userId;
  // function performSearch() {
  //   const query = $('#selected').val();

  //     $.post(`../admin/filterusername/${query}`, function (response) {

  //     if (typeof response === 'string') {
  //       $(".acc_transaction_username").hide();
  //     } else if (typeof response === 'object') {
        
  //       let html = '';
  //       // Sort users alphabetically by username
  //       response.sort((a, b) => a.username.localeCompare(b.username));
  //       // Generate HTML for the select options
  //       response.forEach((user) => {
  //         html += `<span value="${user.uid}" class="option">${user.username}</span>`;
  //       });

  //       // Insert the generated options into the <select> element
  //       $(".acc_transaction_username").html(html).show();

  //     }
  //   })
  // }


  $(document).on('click', '.executetrans', function () {

    const username = $(".userIdtrans").val()
    const orderid = $(".orderid").val()
    const ordertype = $(".ordertype").val()
    const startdatet = $(".startdatet").val()
    const enddatet = $(".enddatet").val()
    console.log(enddate)
    $(".loader").removeClass('bx-check-double').addClass('bx-loader bx-spin');
    $("#mask").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3
    });
    setTimeout(() => {
    filterTrasaction(username, orderid, ordertype, startdatet, enddatet,currentPage,pageLimit)
    }, 100);
  })

  $(document).on('click', '.tinfo', function () {
    $("#signup-modal").modal("show");
    const transactionId = $(this).attr('value')
    // console.log(transactionId)
    $("#row1").html("")
    $("#row2").html("")
    fetchTrasactionBet(transactionId);

  })

  $(document).on('click', function () {
    $(".acc_transaction_username").hide();
  });

  $(".numrows").change(function(){
    const numrow = $(this).val();
    const username = $(".userIdtrans").val()
    const orderid = $(".orderid").val()
    const ordertype = $(".ordertype").val()
    const startdatet = $(".startdatet").val()
    const enddatet = $(".enddatet").val()
    $("#mask").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3
    });
    filterTrasaction(username, orderid, ordertype, startdatet, enddatet,currentPage,numrow)
  })

  let elem = '';
  var menu = new BootstrapMenu('.chrome-tab', {
    fetchElementData:function(element){
      elem  = element
    },
    actions: [{
      name: "<div class='pins'><i class='bx bxs-pin' style='font-size:15px;' ></i> <span style='font-size:12px'>Pin</span></div>",
      onClick: function() {
        $(elem[0]).find(".chrome-tab-close").removeClass("chrome-tab-close").addClass("bx bxs-pin")
        console.log("Pinned")
      }
    }, {
      name: "<div class='pins'><i class='bx bx-pin' style='font-size:15px;' ></i> <span style='font-size:12px'>Unpin</span></div>",
      onClick: function() {
        $(elem[0]).find(".bxs-pin").removeClass("bx bxs-pin").addClass("chrome-tab-close")
        console.log("Uninned")
      }
    }, {
      name: "<div class='pins'><i class='bx bx-checkbox-minus' style='font-size:15px;' ></i> <span style='font-size:12px'>Disable</span></div>",
      onClick: function() { 
       // $(elem[0]).find(".chrome-tab-close").removeClass("chrome-tab-close")
      }
    }]
  });

  //search the 

  let debounceTimeout = null;

  $(document).ready(function () {
      // Event listener for keyup on #myInput
      $(document).on('keyup', '#mytrans', function () {
          const query = $(this).val().trim();

          // Only trigger if input is more than 2 characters
          if (query.length > 1) {
              clearTimeout(debounceTimeout); // Clear any existing timeout
              debounceTimeout = setTimeout(fetchbetUser, 500, query); // Call fetchUsers with the query after 500ms delay
          } else {
              $('.useraccount').hide(); // Hide dropdown if input is less than 3 characters
          }
      });

      // Handle dropdown item selection
      $(document).on('change', '.useraccount', function () {
          const selectedOption = $(this).find('option:selected');
          const selectedUserId = selectedOption.val();
          const selectedUsername = selectedOption.data('username');

          if (selectedUserId) {
              $('#mytrans').val(selectedUsername);
              $('.userIdtrans').val(selectedUserId);
              $('.useraccount').hide();
          }
      });

      // Handle manual input clearing
      $(document).on('input', '#mytrans', function () {
          if (!$(this).val()) {
              $('.userIdtrans').val(''); // Reset user ID if input is cleared
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

              $('.useraccount').html(optionsHtml).show();
          } catch (error) {
              console.error("Error parsing response: ", error);
              $('.useraccount').hide();
          }
      }).fail(function () {
          console.error("Error fetching users.");
          $('.useraccount').hide();
      });
  }


});