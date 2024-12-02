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
  const UserlistData = (data) => {
    let html = "";
    const status = {
      1: "Enable", // Green
      2: "Suspend", // Orange
      3: "Forbbiden", // Light Blue
      4: "Blocked", // Red
    };

    //   const account_type = {
    //     1 :"customer",
    //     2 : "agent",
    //     3 : "sub agent",        // Red
    //   };

    const recharges = {
      1: "momo",
      2: "bank Transfer",
      3: "bank card",
      4: "crypto", // Red
    };

    data.forEach((item) => {
      html += `
                    <tr>
                        <td>${item.username}</td>
                        <td>${item.nickname}</td>
                        <td>VIP</td>
                        <td>${item.relationship}</td>
                        <td>${item.totalsubordinate}</td>
                        <td>${item.balance}</td> 
                        <td>${item.rebate}</td>
                        <td>${item.created_at}</td>
                        <td>${status[item.user_state]}</td>
                   
                          <td>
                            
                             <div class="dropdown">
                                    <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                     <i class='bx bx-dots-vertical-rounded'></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                      <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 " href="javascript:void(0);"data-bs-toggle="modal" data-bs-target="#signup">
                                        <i class="bx bx-show fs-5"></i>View
                                      </a>
                                      <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 viewquota" href="javascript:void(0);" data-rebate="${item.quota}"data-uid="${item.uid}"> 
                                        <i class="bx bx-show fs-5" ></i>Quota
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
    return html;
  };

  // const FromTable = (data,obj) => {
  //   let html = "";
  //   Object.entries(data).forEach(([key, value]) => {
  //    // console.log(`${key}: ${value}`);
  //     html += `
  //           <tr>
  //               <td>${value}</td>
  //               <td>${obj[key]}</td>
  //           </tr>
  //           `;
  //   });
  //   return html;
  // };

  // const firstRow = {
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

  // const secondRow = {
  //   'game_type': 'Lottery Type::',
  //   'bet_time': 'Bet Time:',
  //   'closing_time': 'Closing Time:',
  //   'opening_time': 'Draw Time::',
  //   'bet_number': 'Total Bet:',
  //   'bet_amount': 'Total Bet Amount:',
  //   'win_amount': 'Prize:',
  //   'server_date': 'Win Amount:',
  //   'server_time': 'Actual profit:',
  //   'user_selection': 'Bet Details',
  //   'test': ' ',
  // }

  const renderuserlist = (data) => {
    var html = UserlistData(data);
    $("#userlistContainer").html(html);
  };

  let currentPagelist = 1;
  let pageLimit = 50;

  async function fetchUserlist(pagelist) {
    try {
      const response = await fetch(
        `../admin/userlistdata/${pagelist}/${pageLimit}`
      );
      const data = await response.json();
      //  console.log(response);
      //  return
      $("#masklist").LoadingOverlay("hide");
      renderuserlist(data.users);

      // Render pagination
      renderPaginationlist(data.totalPages, pagelist, "normal");
      document.getElementById("paging_infolist").innerHTML =
        "Page " + pagelist + " of " + data.totalPages + " pages";
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  async function filterUserlist(
    pagelist,
    username,
    states,
    startdate,
    enddate
  ) {
    try {
      const response = await fetch(
        `../admin/filteruserlist/${username}/${states}/${startdate}/${enddate}/${pagelist}/${pageLimit}`
      );
      const data = await response.json();
      // console.log(response);

      $(".loaderlist")
        .removeClass("bx bx-loader bx-spin")
        .addClass("bx bx-check-double");
      if (data.userlists.length < 1) {
        let html = `
              <tr class="no-results" >
              <td colspan="9">
                   <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
              </td>
           </tr>`;
        $("#userlistContainer").html(html);
        return;
      }
      renderuserlist(data.userlists);

      // Render pagination
      renderPaginationlist(
        data.totalPages,
        pagelist,
        "search",
        username,
        states,
        startdate,
        enddate
      );
      document.getElementById("paging_infolist").innerHTML =
        "Page " + pagelist + " of " + data.totalPages + " pages";
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  // async function fetchTrasactionBet(transactionId) {
  //   try {
  //     const response = await fetch(`../admin/getTransactionBet/${transactionId}`);
  //     const data = await response.json();

  //     $("#row1").html("")
  //     $("#row2").html("")
  //     let html1 = FromTable(firstRow,data)
  //     let html2 = FromTable(secondRow,data)
  //     $("#row1").html(html1)
  //     $("#row2").html(html2)

  //   } catch (error) {
  //     console.error("Error fetching data:", error);
  //   }
  // }

  function renderPaginationlist(
    totalPages,
    currentPagelist,
    pagingType = "",
    username = "",
    states = "",
    startdate = "",
    enddate = ""
  ) {
    const createPageLink = (i, label = i, disabled = false, active = false) =>
      `<li class='page-item ${disabled ? "disabled" : ""} ${
        active ? "active" : ""
      }'>
          <a class='page-link' href='#' data-page='${i}'>${label}</a>
        </li>`;
    let pagLink = `<ul class='pagination justify-content-end'>`;

    // Previous Button
    pagLink += createPageLink(
      currentPagelist - 1,
      `<i class='bx bx-chevron-left'></i>`,
      currentPagelist === 1
    );

    // Page numbers with ellipsis
    for (let i = 1; i <= totalPages; i++) {
      if (i === 1 || i === totalPages || Math.abs(i - currentPagelist) <= 2) {
        pagLink += createPageLink(i, i, false, i === currentPagelist);
      } else if (i === currentPagelist - 3 || i === currentPagelist + 3) {
        pagLink += createPageLink(i, "...", true);
      }
    }

    // Next Button
    pagLink += createPageLink(
      currentPagelist + 1,
      `<i class='bx bx-chevron-right'></i>`,
      currentPagelist === totalPages
    );
    pagLink += "</ul>";

    document.getElementById("paginationlist").innerHTML = pagLink;

    // Add click event listeners
    document.querySelectorAll("#paginationlist .page-link").forEach((link) => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        const newPage = +this.getAttribute("data-page");
        if (newPage > 0 && newPage <= totalPages) {
          pagingType === "search"
            ? filterUserlist(newPage, username, states, startdate, enddate)
            : fetchUserlist(newPage);
        }
      });
    });
  }

  fetchUserlist(currentPagelist);

  $(".playerlist").click(function () {
    let direction = $(this).val();
    const tableWrapper = $(".table-wrapperlist");
    const tableWrappers = document.querySelector(".table-wrapperlist");
    const scrollAmount = 1000; // Adjust as needed
    const scrollOptions = {
      behavior: "smooth",
    };
    if (tableWrapper.length) {
      switch (direction) {
        case "leftlist":
          tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
          break;
        case "rightlist":
          tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
          break;
        case "startlist":
          // Scroll to the absolute start (leftmost position)
          tableWrapper.animate({ scrollLeft: 0 }, "slow");
          break;
        case "endlist":
          const maxScrollLeft =
            tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
          tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
          break;
        default:
          break;
      }
    }
  });

  $(".refreshlist").click(function () {
    $(".queryholder").val("");
    $("#masklist").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3,
    });
    fetchUserlist(currentPagelist);
  });

  let timeout;
  let userIdd;
  function performSearch() {
    const querys = $("#selectuserlist").val();
    console.log(querys)
    // return
    $.post(`../admin/filterusername/${querys}`, function (response) {
   
      
      if (typeof response === "string") {
        $(".queryholderxx").hide();
      } else if (typeof response === "object") {
        let html = "";
        // Sort users alphabetically by username
        response.sort((a, b) => a.username.localeCompare(b.username));
        // Generate HTML for the select options
        response.forEach((user) => {
          html += `<li value="" class="optionlist">${user.username}</li>`;
        });

        // Insert the generated options into the <select> element
        $(".queryholderxx").html(html).show();
      }
    });
  }

  $(document).on("input", "#selectuserlist", function () {
    clearTimeout(timeout);
    $(".userIds").val("");
    timeout = setTimeout(performSearch, 300);
  });

  $(document).on("click", ".optionlist", function () {
    $("#selectuserlist").val($(this).text());
    userIdd = $(this).attr("value");
    $(".userIds").val(userIdd);
    $(".queryholderxx").hide();
  });

  $(document).on("click", ".executeuserlist", function () {
    if ($("#selectuserlist").val() == "" && $(".states").val() == "") {
      $("#dangerlist").modal("show");
      return;
    }
    const username =
      $(".userId").val().trim() === "" ? $("#selectuserlist").val(): $(".userId").val().trim();
    const states = $(".states").val();
    // const ordertype = $(".ordertype").val()
    const startdate = $(".startdate").val();
    const enddate = $(".enddate").val();
    console.log(username);
    $(".loaderlist")
      .removeClass("bx-check-double")
      .addClass("bx-loader bx-spin");
    setTimeout(() => {
      filterUserlist(currentPagelist, username, states, startdate, enddate);
    }, 100);
  });

  // $(document).on('click', '.tinfo', function () {
  //   $("#signup-modal").modal("show");
  //   const transactionId = $(this).attr('value')
  //   console.log(transactionId)
  //   $("#row1").html("")
  //   $("#row2").html("")
  //   fetchTrasactionBet(transactionId);

  // })

  // $(document).on("click", function () {
  //   $(".queryholderxx").hide();
  // });

  $(".tclose").click(function () {
    $("#signup-modal").modal("hide");
  });

  $(document).on("click", ".addagents", function () {
    $("#addagentmodal").modal("show");
  });

  $(".listclose").click(function () {
    $("#addagentmodal").modal("hide");
  });

  async function fetchRebatedata() {
    try {
      const response = await fetch(`../admin/fetchRebatedata/`); // Await the fetch call
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      
      const data = await response.json(); // Parse JSON response
     // console.log(data);
      let html ="";
    
      // Check if data is not empty and iterate over it to generate options
      if (Array.isArray(data) && data.length > 0) {
        data.forEach((rebate) => {
          html += `<option value="${rebate.rebate}" class="">${rebate.rebate}</option>`;
        });
      } else {
        html += `<option value="" disabled>No rebates found</option>`; // If no data, show a message
      }
  
      // Inject the options into the #rebatedata select element
      $("#usererebate").html(html);
  
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }
  fetchRebatedata();

  $(document).on("click", ".btnaddagent", function () {
    const datas = $("#agentform").serialize();
    addAgent(datas);
  });

  async function addAgent(datas) {
    try {
      const response = await fetch(`../admin/addAgent/${datas}`);
      const data = await response.json();
      // console.log(response);
      const errorMessages = {
        emailexist: "Email already exists",
        usernamePattern:
          "Username must  Contain only letters\n, numbers, and underscores\n Start with a letter",
        username:
          "Username must contain only letters, numbers, and underscores and start with a letter",
        email: "Email address is invalid",
        passwordNumber: "Password must contain at least one number",
        passwordCaseSensitive:
          "Password must contain at least one uppercase and\n lowercase letter",
        passwordSpecialChar:
          "Password must contain at least one special symbol",
        confirmPassword: "Password does not match",
        passwordLength: "Password must be at least 8 characters",
        passwordRequired: "Password is required",
      };
      let message = null;
      // Loop through error keys to find the first error
      for (const [key, errorMessage] of Object.entries(errorMessages)) {
        if (data[key]) {
          message = errorMessage;
          break;
        }
      }
      if (message) {
        showToast("Heads up!!", message, "info");
        return;
      } else {
        $(".loaders")
          .removeClass("bx-send")
          .addClass("bx-loader-circle bx-spin loader");
        setTimeout(function () {
          $(".loaders")
            .removeClass("bx-loader-circle bx-spin loader")
            .addClass("bx-send");
          $("#addagent").modal("hide");
          showToast("Success", "agent added sucessfully", "success");
          // fetchUserlist(currentPagelist);
        }, 500);
      }
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  async function fetchTopAgent(pagelist) {
    try {
      const response = await fetch(
        `../admin/fetchTopAgent/${pagelist}/${pageLimit}`
      );

      const data = await response.json();
      // console.log(response);
      renderuserlist(data.topagent);
      $("#masklist").LoadingOverlay("hide");
      // Render pagination
      renderPaginationlist(data.totalPages, pagelist, "normal");
      document.getElementById("paging_infolist").innerHTML =
        "Page " + pagelist + " of " + data.totalPages + " pages";

      // return;
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  //get top agent
  $(".gettopagent").click(function () {
    $(".queryholder").val("");
    $("#masklist").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3,
    });
    fetchTopAgent(currentPagelist);
  });

  //quota
  $(document).on("click", ".viewquota", function () {
    $("#viewquota").modal("show");

    const uid = $(this).attr("data-uid").trim();
    $(".userquotaid").val(uid);
    console.log(uid)

    $.post(`../admin/getuserrebate/${uid}/`, function (data) {
       const rebatelist = JSON.parse(data);
     
      let tableBody = document
        .getElementById("quotatable")
        .getElementsByTagName("tbody")[0];
      while (tableBody.firstChild) {
        tableBody.removeChild(tableBody.firstChild);
      }

      rebatelist.forEach((item) => {
        let row = tableBody.insertRow();
        let rowData = [
          `<b class="rebate_group"> ${item.rebate}</b>`,
          `<b class="bonus_group">  ${item.odds_group}</b>`,
          `<b class="count_group">${item.counts} </b> / ${item.quota}`,
          `<input type="text" value="${item.quota}" class="quota_set form-control" />`,
        ];

        rowData.forEach((datass) => {
          let cell = row.insertCell();
          cell.innerHTML = datass;
        });
      });
    });
  });

  $(document).on("click", ".updatequotabtn", function () {
    // const $spinner = $(this).find('.spinner-borderrr');
    // $spinner.show(); // Show the spinner immediately
    let uid = $(".userquotaid").val();
    let rebate_group = [];
    let bonus_group = [];
    let quata_group = [];
    let count_group = [];

    $(".rebate_group").each(function () {
      var value = $(this).text();
      rebate_group.push(value);
    });

    $(".bonus_group").each(function () {
      var value = $(this).text();
      bonus_group.push(value);
    });

    $(".quota_set").each(function () {
      var value = $(this).val();
      quata_group.push(value);
    });

    $(".count_group").each(function () {
      var value = $(this).text();
      count_group.push(value);
    });

    $(".loaderquota").removeClass("bx-send").addClass("bx-loader-circle bx-spin loader");
    //
    $.post( `../admin/updateUsedquota/${uid}/${rebate_group}/${bonus_group}/${quata_group}/${count_group}/`,

      function (result) {
        // console.log(result);
        setTimeout(function() {
          $(".loaderquota").removeClass("bx-loader-circle bx-spin loader").addClass("bx-send");
            if (result) {
              $("#viewquota").modal("hide");
                showToast("Success", "quota updated successfullly", "success");
               
            } else {
                showToast("Heads up !!", "no changes made", "info");
            }
      
        }, 500); // Duration before showing the toast
      }
    );
  });

  function tableScrolluserList() {
    const tableContainerUser = document.querySelector(".table-wrapperuserlist");
        const headerRowUserList = document.querySelector(".userlistheadrow");

        tableContainerUser.addEventListener("scroll", function () {
          if (tableContainerUser.scrollTop > 0) {
            headerRowUserList.classList.add("sticky-headersUserlist");
          } else {
            headerRowUserList.classList.remove("sticky-headersUserlist");
          }
        });
  }
  tableScrolluserList();
  
});
