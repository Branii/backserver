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

  //const translator = JSON.parse(document.getElementById("translation-container").getAttribute("data-translations"));
  const translatorScript = document.querySelector(".translations"); // Get the script tag
  const translator = JSON.parse(translatorScript.textContent);
  const Lottery = (data) => {
      let htmls = "";
      //translator["Deposit"]
      const gamemodel = {
          1: translator["Standard"],
          2: translator["Two Sides"],
          3: translator["Road Bets"],
          4: translator["Long Dragon"],
          5: translator["Many Tables"],
          6: translator["Board Games"],
          7: translator["Fantan"],
          8: translator["Trend"],
      };

      const betstatus = {
          2: translator["Win"],
          3: translator["Loss"],
          5: translator["Pending"],
          6: translator["Void"],
          7: translator["Refund"],
      };
      const states = {
          1: translator["Settled"],
          2: translator["Unsettled"],
          4: translator["Cancelled"],
          7: translator["Refund"],
          8: translator["Delete"],
      };

      const status = {
          2: { title: translator["Win"], color: "#4CAF50" }, // Green
          3: { title: translator["Loss"], color: "#E91E63" }, // Red
          5: { title: translator["Pending"], color: "#9E9E9E" }, // Grey
          6: { title: translator["Void"], color: "#F44336" },
          7: { title: translator["Refund"], color: "#03A9F4" }, // Light Blue
      };

      data.forEach((item) => {
          const betOddsObject = JSON.parse(item.bet_odds);
          const betOddsArray = Object.values(betOddsObject);
          const betodds = betOddsArray * item.multiplier * item.unit_stake;
          let username = item.reg_type === "email" ? item.email : item.reg_type === "username" ? item.username : item.contact;

          htmls += `
                  <tr>
                      <td>${item.bet_code}</td>
                      <td>${username}</td>
                      <td>${item.draw_period}</td>
                      <td>${item.game_type}</td>
                      <td>${gamemodel[item.game_model]}</td>
                      <td>${item.game_label}</td>
                      <td>${item.bet_date + " / " + item.bet_time}</td>
                      <td>${item.server_date + " / " + item.server_time}</td>
                      <td>${item.unit_stake}</td>
                      <td>${item.multiplier}</td>
                      <td>${formatMoney(item.bet_amount)}</td>
                      <td>${formatMoney(item.win_bonus)}</td>
                      <td><i class='bx bxs-circle' style='color:${status[item.bet_status].color};font-size:8px;margin-right:5px;'></i>${status[item.bet_status].title}</td>
                      <td> <span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">${states[item.state]}</span></td>
                      <td><i value='${item.bet_code}_${item.gt_id}' class='bx bx-info-circle viewbets' style='color:#868c87;font-size:18px;cursor:pointer;'></i></td>
                  </tr>
              `;
      });
      return htmls;
  };

  const Showbettable = (data, obj) => {
      let htmlbet = "";
      Object.entries(data).forEach(([key, value]) => {
          let test = value !== translator["Bet Selection"] && langMap[value] ? langMap[value] : translator["Bet Selection"];

          if (value == test) {
              htmlbet += `
          <td>${value}</td>
           <td class="${key === "user_selection" ? "bet_userSelection" : ""}">
            <textarea class="form-control"   readonly style="height: 75px;">${obj[key]}</textarea>
            </td>`;
          } else {
              htmlbet += `
          <tr>
            <td>${value}</td>
            <td class="${key === "user_selection" ? "bet_userSelection" : ""}" 
              ${key === "user_selection" ? `title="${obj[key]}"` : ""}>
              ${key === "win_bonus" || key === "bet_amount" || key === "rebate_amount" ? `${formatMoney(obj[key])}` : `${obj[key]}`}
             </td>
          </tr>
          `;
          }
      });
      return htmlbet;
  };
  const langMap = {
      "投注选择:": "Bet Selection",
  };

  const firstRowbet = {
      bet_code: `${translator["Bet Order ID"]}`,
      draw_period: `${translator["Issue Number"]}`,
      bet_time: `${translator["Bet Time"]}`,
      bet_number: `${translator["Total Bets"]}`,
      unit_stake: `${translator["Unit Stake"]}`,
      multiplier: `${translator["Multiplier"]}`,
      bet_amount: `${translator["Total Bet Amount"]}`,
      win_bonus: `  ${translator["Win Amount"]}`,
      rebate_amount: `${translator["Rebate Amount"]}`,
      num_wins: `${translator["Number of Wins"]}`,
      draw_number: `${translator["Draw Results"]}`,
  };

  const secondRowbet = {
      reg_type: `${translator["Username"]}`,
      ip_address: `${translator["IP"]}`,
      game_type: `${translator["Lottery Type"]}`,
      game_label: `${translator["Game Label"]}`,
      bettype: `${translator["Bet Type"]}`,
      game_model: `${translator["Game Model"]}`,
      closing_time: `${translator["Closing Time"]}`,
      opening_time: `${translator["Draw Time"]}`,
      bet_status: `${translator["Bet Status"]}`,
      user_selection: `${translator["Bet Selection"]}`,
      //'user_selection': 'Bet Selection'
  };

  const renderlottery = (data) => {
      var htmls = Lottery(data);
      $("#lotterydataContainer").html(htmls);
  };

  let currentPagebet = 1;
  let pageLimit = 20;

  // Fetch lottery bet data
  async function fetchLotteryBet(currentPagebet,pageLimit) {
      try {
          const response = await fetch(`../admin/lotterydata/${currentPagebet}/${pageLimit}`);
          const data = await response.json();
          $("#maskbet").LoadingOverlay("hide");
          renderlottery(data.lotterybet);
          renderbetPagination(data.totalPages, currentPagebet, (currentPagebet) => fetchLotteryBet(currentPagebet, pageLimit)); // Pass callback
          document.getElementById("paging_infobet").innerHTML = `${translator["Page"]} ${currentPagebet} ${translator["Of"]} ${data.totalPages} ${translator["Page"]}`;
      } catch (error) {
            console.error("Error fetching data:", error);
      }
  }

  fetchLotteryBet(currentPagebet, pageLimit);
  function renderbetPagination(totalPages, currentPagebet, callback) {
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
  async function filterbetdatas(uidd, betOrderID, gametype, betsate, betstatus, startdates, enddates, currentPagebet, pageLimit) {
      $.post(`../admin/filterbetdata/${uidd}/${betOrderID}/${gametype}/${betsate}/${betstatus}/${startdates}/${enddates}/${currentPagebet}/${pageLimit}`).done(function (response) {
          try {
              const data = JSON.parse(response);
              if (data.response == "error") {
                  showToast("Alert", "User does not exist", "info");
                  $(".loaderbet").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
                  return;
              }
              console.log(response);
              $(".loaderbet").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
              if (data.filterbet.length < 1) {
                  let html = `
                <tr class="no-results">
                    <td colspan="9">
                        <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                    </td>
                </tr>`;
                  $("#maskbet").LoadingOverlay("hide");
                  $("#lotterydataContainer").html(html);
                  return;
              }
              $("#maskbet").LoadingOverlay("hide");
              renderlottery(data.filterbet);
              renderbetPagination(data.totalPages,currentPagebet, (page) => {filterbetdatas(uidd, betOrderID, gametype, betsate, betstatus, startdates, enddates, page, pageLimit);}); // Pass callback

              document.getElementById("paging_infobet").innerHTML =`${translator["Page"]} ${currentPagebet} ${translator["Of"]} ${data.totalPages} ${translator["Page"]}`
          } catch (error) {
              console.error("Error parsing JSON response:", error);
              $(".loaderbet").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
          }

          $(".loaderbet").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
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
                  const maxScrollLeft = tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
                  tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
                  break;
              default:
                  break;
          }
      }
  });

  $(".betrefresh").click(function () {
      $(".queryholderbet").val("");
      $(".userIdbet").val("");
      $("#maskbet").LoadingOverlay("show", {
          background: "rgb(90,106,133,0.1)",
          size: 3,
      });
      currentPagebet = 1;
      pageLimit = 20;
      fetchLotteryBet(currentPagebet, pageLimit);
  });

  $(".executebet").click(function () {
      if ($("#myInput").val() == "" && $(".typelottery").val() == "" && $(".startdates").val() == "" && $(".betsate").val() == "" && $(".betstatus").val() == "" && $("#lot-betID").val() == "") {
          // $("#dangerbet").modal("show");
          showToast("Heads up!!", "Select one or more data fields to filter", "info");
          return;
      }
      const uidd = $("#myInput").val();
      const betOrderID = $("#lot-betID").val();
      const gametype = $(".typelottery").val();
      const betsate = $(".betsate").val();
      const betstatus = $(".betstatus").val();
      const startdates = $(".startdates").val();
      const enddates = $(".enddates").val();
      // console.log(uidd)
      // console.log(enddates)

      filterbetdatas(uidd, betOrderID, gametype, betsate, betstatus, startdates, enddates, currentPagebet, pageLimit);

      $(".loaderbet").removeClass("bx bx-check-double").addClass("bx bx-loader bx-spin");
  });

  async function fetchLotteryname() {
      try {
          const response = await fetch(`../admin/fetchLotteryname/`); // Await the fetch call
          if (!response.ok) {
              throw new Error(`HTTP error! Status: ${response.status}`);
          }
          const data = await response.json(); // Parse JSON response
          let html = `<option value="">${translator['Lottery Type']}</option>`;
          data.forEach((lottery) => {
              html += `<option value="${lottery.gt_id}">${lottery.name}</option>`;
          });
          $(".selectlottery").html(html);
      } catch (error) {
          console.error("Error fetching data:", error);
      }
  }
  fetchLotteryname();

  // viewbets
  $(document).on("click", ".viewbets", function () {
      $("#viewbetsmodal").modal("show");
      const betcode = $(this).attr("value");
      console.log(betcode);

      // console.log(gametype)
      $("#rowbet").empty();
      $("#rowbe1").empty();
      viewstakedBet(betcode);
  });

  async function viewstakedBet(betcode) {
      try {
          const response = await fetch(`../admin/viewBetstake/${betcode}`);
          const data = await response.json();
          //  console.log(response)
          //  return
          let htmlbet1 = Showbettable(firstRowbet, data);
          let htmlbet2 = Showbettable(secondRowbet, data);
          $("#rowbet").html(htmlbet1);
          $("#rowbet1").html(htmlbet2);
      } catch (error) {
          console.error("Error fetching data:", error);
      }
  }

  let debounceTimeout = null;
  let isPastingss = false;

  $(document).ready(function () {
      // Event listener for keyup on #myInput
      $(document).on("keyup", "#myInput", function () {
          const query = $(this).val().trim();

          // Only trigger if input is more than 2 characters
          if (query.length > 1 && !isPastingss) {
              clearTimeout(debounceTimeout); // Clear any existing timeout
              debounceTimeout = setTimeout(fetchbetUser, 500, query); // Call fetchUsers with the query after 500ms delay
          } else {
              $(".userDropdownb").hide(); // Hide dropdown if input is less than 3 characters
          }
      });

      $(document).on("paste", "#myInput", function () {
          isPastingss = true; // Set the flag to true when paste happens
          $(".userDropdownb").hide();
          setTimeout(function () {
              isPastingss = false; // Reset the flag after a short delay (allow paste to finish)
          }, 100); // Delay of 100ms is usually enough for paste operations to finish
      });

      // Handle dropdown item selection
      $(document).on("change", ".userDropdownb", function () {
          const selectedOption = $(this).find("option:selected");
          const selectedUserId = selectedOption.val();
          const selectedUsername = selectedOption.data("username");

          if (selectedUserId) {
              $("#myInput").val(selectedUsername);
              $(".userIdbet").val(selectedUserId);
              $(".userDropdownb").hide();
          }
      });

      $(document).on("click", function (e) {
          const $dropdownbet = $("#userlotteryDropdown");
          if (!$(e.target).closest("#myInput, #userlotteryDropdown").length) {
              $dropdownbet.hide();
          }
      });
      // Handle manual input clearing
      $(document).on("input", "#myInput", function () {
          if (!$(this).val()) {
              $(".userIdbet").val(""); // Reset user ID if input is cleared
          }
      });
  });
  // Function to fetch and display users
  function fetchbetUser(query) {
      $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
          try {
              response = typeof response === "string" ? JSON.parse(response) : response;

              let optionsHtml = "";

              response.forEach((user) => {
                  let displayValuebet;
                  let regnamebet;
                  // Display based on regtype
                  if (user.regtype === "email") {
                      displayValuebet = user.email;
                      regnamebet = user.email; // Show email
                  } else if (user.regtype === "username") {
                      displayValuebet = user.username;
                      regnamebet = user.username; // Show username
                  } else if (user.regtype === "contact") {
                      displayValuebet = user.contact;
                      regnamebet = user.contact; // Show contact
                  } else {
                      displayValuebet = "no data found...";
                      regnamebet = "no data found..."; // Show contact
                  }
                  optionsHtml += `<option class="optionlist" value="${user.uid}" data-username="${regnamebet}">${displayValuebet}</option>`;
              });

              $(".userDropdownb").html(optionsHtml).show();
          } catch (error) {
              console.error("Error parsing response: ", error);
              $(".userDropdownb").hide();
          }
      }).fail(function () {
          console.error("Error fetching users.");
          $(".userDropdownb").hide();
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

  $(".search-betID").on("input paste", function () {
      const self = this;
      setTimeout(() => {
          // Trim leading spaces
          $(self).val($(self).val().replace(/^\s+/, ""));
      }, 0);
  });

  $(".search-betID").on("dblclick", function () {
      $(this).val(""); // Clears the input field
  });

});
