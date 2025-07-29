$(() => {
  const partnerID = $("#partner-holder").attr("data-partner-id");

  // fetch the lottery draw records on page read

  function showToast(title, message, type, duration) {
    $.toast({
      position: "bottom-right",
      title: title,
      message: message,
      type: type,
      duration: duration === undefined ? 3000 : duration * 1000 // auto-dismiss after 3s
    });
  }

  // filter user name

  $(document).on("keyup", "#ld-lottery", function() {
    const query = $(this).val().trim();
    if (query.length < 1) {
      $(".lot-drw-res-wrapper").hide();
      return;
    }
    //  console.log("Keyup: ");
    // Only trigger if input is more than 2 characters
    if (query.length > 1) {
      clearTimeout(debounceTimeout); // Clear any existing timeout
      //  console.log("Debounce working...");
      debounceTimeout = setTimeout(fetchLotteryname, 300, query); // Call fetchUsers with the query after 500ms delay
    } else {
      $(".userDropdown").hide(); // Hide dropdown if input is less than 3 characters
    }
  });

  $(document).on("click", ".tclose,.close-modal", function() {
    $("#lb-edit").removeClass("show");
    $("#lb-edit").css("display", "none");
  });

  $(document).on("click", ".lb-tclose", function() {
    $("#lb-toggle-lottery").removeClass("show");
    $("#lb-toggle-lottery").css("display", "none");
  });

  $(document).on("click", ".edit-params-act-btn", function() {
    $("#lb-edit").addClass("show");
    $("#lb-edit").css("display", "block");

    const lotteryID = $(this).attr("id").split("-")[1];
    const maxPrizeAmount = $(`#td-mx-prize-${lotteryID}`).text();
    const maxWinPerPersonPerIssue = $(`#td-mx-win-${lotteryID}`).text();
    const maxBetAmountPerIssue = $(`#td-mx-amt-${lotteryID}`).text();
    const minBetAmountPerIssue = $(`#td-mn-amt-${lotteryID}`).text();
    const lockTimeForClosingBet = $(`#td-clsing-${lotteryID}`).text();
    const sortingWeight = $(`#td-sorting-weight-${lotteryID}`).text();

    $(`#lb-dialog-mx-prize`).val(maxPrizeAmount);
    $(`#lb-dialog-mx-win`).val(maxWinPerPersonPerIssue);
    $(`#lb-dialog-mx-amt`).val(maxBetAmountPerIssue);
    $(`#lb-dialog-mn-amt`).val(minBetAmountPerIssue);
    $(`#lb-dialog-clsing`).val(lockTimeForClosingBet);
    $(`#lb-dialog-sorting-weight`).val(sortingWeight);

    $("#lb-id-holder ").val(lotteryID);
    $("#lb-lottery-type").val($(this).attr("data-lottery-type"));
  });

  $(document).on("click", "#lb-update-lottery", function() {
    const lotteryID = $("#lb-id-holder").val();
    const maxPrizeAmount = $(`#lb-dialog-mx-prize`).val();
    const maxWinPerPersonPerIssue = $(`#lb-dialog-mx-win`).val();
    const maxBetAmountPerIssue = $(`#lb-dialog-mx-amt`).val();
    const minBetAmountPerIssue = $(`#lb-dialog-mn-amt`).val();
    const lockTimeForClosingBet = $(`#lb-dialog-clsing`).val();
    const sortingWeight = $(`#lb-dialog-sorting-weight`).val();
    const lotteryType = $(`#lb-lottery-type`).val();
    $.ajax({
      url: `../game/updateLottery/${maxPrizeAmount}/${maxBetAmountPerIssue}/${maxWinPerPersonPerIssue}/${minBetAmountPerIssue}/${lockTimeForClosingBet}/${sortingWeight}/${lotteryType}/${lotteryID}`,
      type: "POST",
      beforeSend: function() {
        $("#lottery-draw-loader").css({ display: "flex" });
      },
      success: function(response) {
        response = JSON.parse(response);
        const data = response.data;
        if (response.status === "error") {
          showToast("Error", "Data not updated.", "error");
          return;
        }

        if (response.swapped.length > 0) {
          const firstID = response.swapped[0];
          const secondID = response.swapped[1];
          const firstSortingWeight = $(`#td-sorting-weight-${firstID}`).text();
          const secondSortingWeight = $(
            `#td-sorting-weight-${secondID}`
          ).text();
          $(`#td-sorting-weight-${firstID}`).text(secondSortingWeight);
          $(`#td-sorting-weight-${secondID}`).text(firstSortingWeight);
        } else {
          $(`#td-sorting-weight-${lotteryID}`).text(sortingWeight);
        }

        $(`#td-mx-prize-${lotteryID}`).text(maxPrizeAmount);
        $(`#td-mx-win-${lotteryID}`).text(maxWinPerPersonPerIssue);
        $(`#td-mx-amt-${lotteryID}`).text(maxBetAmountPerIssue);
        $(`#td-mn-amt-${lotteryID}`).text(minBetAmountPerIssue);
        $(`#td-clsing-${lotteryID}`).text(lockTimeForClosingBet);

        $(".tclose").click();
        showToast("Success", "Lottery Data Successfully Updated.", "info");
      },
      error: function(res, status, error) {
        $(".dataholder").html(
          "<tr><td colspan='12' style='text-align:center;'>An error occured, please try again later.</td></tr>"
        );
      },
      complete: function() {
        $("#lottery-draw-loader").css({ display: "none" });
      }
    });
  });

  $(document).on("click", ".update-lottery-state-btn", function() {
    const lotteryID = $("#lb-id-holder").val();
    const status = $("#lb-toggle-lottery").attr("data-status");
    $.ajax({
      url: `../admin/updateLotteryStatus/${partnerID}/${lotteryID}/${status}`,
      type: "POST",
      beforeSend: function() {
        $("#lottery-draw-loader").css({ display: "flex" });
      },
      success: function(response) {
        response = JSON.parse(response);
        const data = response.data;
        if (response.status === "error") {
          showToast("Error", "Lottery Data Successfully Updated.", "error");
          return;
        }

        if (data == 0) {
          showToast(
            "Error",
            "This lottery has already being " +
              (status === "gameon" ? " Turned On " : " Turned Off "),
            "error"
          );
          $(".lb-tclose").click();
          return;
        }

        $(".lb-tclose").click();
        showToast(
          "Success",
          "Lottery " +
            (status === "gameon" ? " Turned On " : " Turned Off ") +
            " Successfully.",
          "info"
        );
        $("#state-" + lotteryID).text(
          status === "gameon" ? "Turned On" : "Turned Off"
        );
      },
      error: function(res, status, error) {
        $(".dataholder").html(
          "<tr><td colspan='12' style='text-align:center;'>An error occured, please try again later.</td></tr>"
        );
      },
      complete: function() {
        $("#lottery-draw-loader").css({ display: "none" });
      }
    });
  });

  $(document).on("click", ".gameon,.gameoff", function() {
    $("#lb-toggle-lottery").addClass("show");
    $("#lb-toggle-lottery").css("display", "block");

    const lotteryName = $(
      $($(this).parents("tr")[0]).find("td:eq(3)")[0]
    ).text();

    $("#lb-id-holder").val($(this).attr("data-target"));
    let status = $(this).attr("class").split(" ")[1];
    $("#toggle-lottery-msg").html(
      `Are you sure you want to  ${status === "gameon"
        ? " <span style='color:#2aa96b;'> Turn On </span> "
        : " <span style='color:#e60e38;'> Turn Off </span> "}  <span style="font-weight: 900;">${lotteryName}</span> ? `
    );
    $("#lb-toggle-lottery").attr({ "data-status": status });
  });

  $("input").on("focus", function() {
    var $this = $(this);
    // Get current value
    var val = $this.val();
    // Clear and set it back to move the caret to the end
    $this.val("").val(val);
  });

  // Handle dropdown item selection
  $(document).on("click", ".name-items", function() {
    $("#ld-lottery").val($(this).attr("data-lot-name"));
    $("#ld-lottery").attr("data-lot-id", $(this).attr("data-lot-id"));
    $(".lot-drw-res-wrapper").hide();
  });
  // Handle dropdown item selection
  $(document).on("click", ".lb-refreshlist", function() {
    $("#lottery").val(0);
    fetchLotteryBasicParams(1, this);
  });

  $(document).on("click", ".fetch-lotter-basic-records", function() {
    fetchLotteryBasicParams(1, this);
  });

  $(".lb_data_scroll").click(function() {
    let direction = $(this).val();
    const tableWrapper = $(".table-wrapperbaic");
    const tableWrappers = document.querySelector(".table-wrapperbaic");
    const scrollAmount = 1300; // Adjust as needed
    const scrollOptions = {
      behavior: "smooth"
    };
    if (tableWrapper.length) {
      switch (direction) {
        case "leftb":
          tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
          break;
        case "rightb":
          tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
          break;
        // case "startlists":
        //     // Scroll to the absolute start (leftmost position)
        //     tableWrapper.animate({ scrollLeft: 0 }, "slow");
        //     break;
        // case "endlists":
        //     const maxScrollLeft = tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
        //     tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
        //     break;
        default:
          break;
      }
    }
  });

  function lotteryDrawMarkup(data) {
    return `<tr>
              <td>${data.lottery_type}</td>
              <td>${transformInput(data.lottery_code)}</td>
              <td>${data.period}</td>
              <td>${data.draw_number}</td>
              <td>${data.total_bet_amount}</td>
              <td>${data.total_bet_won}</td>
              <td>${data.time_added}</td>
              <td>${data.closing_time}</td>
              <td>${data.opening_time}</td>
              <td>${data.closing_time}</td>
              <td>${data.state}</td>
              </tr>`;
  }

  function lotteryBasicParametersMarkup(data) {
    //    console.log('Rendered IMG:', data.lottery_image);
    return `
  <tr>
      <td>${data.id}</td>
    <td><img src="${sanitizeHTML(
      data.lottery_image
    )}" alt="lottery icon" width="40"></td>
      <td id="td-sorting-weight-${data.id}">${data.sort_weight[data.id] ?? 0}</td>
      <td>${data.lottery_type}</td>
      <td>System</td>
      <td></td>
      <td>${transformInput(data.lottery_name)}</td>
      <td id="td-mx-prize-${data.id}">${data.max_prize_per_bet}</td>
      <td id="td-mx-win-${data.id}">${data.max_win}</td>
      <td id="td-mx-amt-${data.id}">${data.max_amt_per_issue}</td>
      <td id="td-mn-amt-${data.id}">${data.mn_amt_per_issue}</td>
      <td id="td-clsing-${data.id}">${data.clsing}</td>
      <td><span class="state">${data.state}</span></td>
      <td>
          <div class="btn-group mb-2 mt-2">
              <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fe fe-mail"></i>
              </button>
              <ul class="dropdown-menu">
                  <li class="action-btn" style="cursor:pointer;">
                      <a class="dropdown-item edit-params-act-btn" 
                        data-lottery-type="${data.lottery_id}"
                         
                         max-prize-amt-per-bet="${data.max_prize_per_bet}" 
                         maximum_win_per_issue="${data.max_win}" 
                         maximum_amount_per_issue="${data.max_amt_per_issue}"  
                         minimum_amount_per_issue="${data.mn_amt_per_issue}"  
                         closing_time="${data.clsing}" 
                         game-id="${data.id}" 
                         id="edit-${data.id}" >
                          Edit
                      </a>
                  </li>
                  <li class="action-btn" style="cursor:pointer;">
                      <a class="dropdown-item gameon" 
                         data-target="${data.id}" 
                         data-bs-target="#confirm-state-modal-gameon" 
                         data-bs-toggle="modal" >
                          Turn On
                      </a>
                  </li>
                  <li class="action-btn" style="cursor:pointer;">
                      <a class="dropdown-item gameoff" 
                         data-target="${data.id}" 
                         data-bs-target="#confirm-state-modal-gameoff" 
                         data-bs-toggle="modal" >
                          Turn Off
                      </a>
                  </li>
                 
                          <!-- Trigger: use <a> or <button> with data-id -->
              <li class="action-btn" style="cursor:pointer;">
                <a class="dropdown-item addgamemodal"
                  data-id="${data.id}|${data.logo}">
                  Update Image
                </a>
              </li>


              </ul>
          </div>
      </td>
  </tr>`;
  }

  const pageLimit = 20;
  const fetchLotteryBasicParams = (page, element) => {
    const lottery_id = $("#lottery").val();
    // console.log(lottery_id);
    $.ajax({
      url: `../game/fetch_lottery_basic_params/${partnerID}/${lottery_id}/${page}`,
      type: "POST",
      beforeSend: function() {
        $($(element).find("i")[0])
          .removeClass("bx-check-double")
          .addClass("bx-loader bx-spin");
      },
      success: function(response) {
        //  console.log("LOTTERY DRAW RECORDS: ", response);
        response = JSON.parse(response);
        const data = response.data;
        // console.log(data);

        if (data.length === 0) {
          $("#dataholder").LoadingOverlay("hide");
          $("#lot-basic-dtholder").html(
            `<tr class="no-results"> <td colspan="9"><img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`
          );
          $("#lb-pagination").html("");
          return;
        }

        let rowsMarkup = "";
        // console.log(data);
        data.forEach(row => {
          rowsMarkup += lotteryBasicParametersMarkup(row);
        });
        // console.log(rowsMarkup);
        $("#lot-basic-dtholder").html(rowsMarkup);
        const totalPages = Math.ceil(response.totalCount / 20);
        renderPaginationlist(totalPages, page, pageLimit, (newpage, element) =>
          fetchLotteryBasicParams(newpage, element)
        );
      },
      error: function(res, status, error) {
        $(".dataholder").html(
          "<tr><td colspan='12' style='text-align:center;'>An error occured, please try again later.</td></tr>"
        );
      },
      complete: function() {
        $($(element).find("i")[0])
          .addClass("bx-check-double")
          .removeClass("bx-loader bx-spin");
      }
    });
  };

  function sanitizeHTML(str) {
    if (typeof str !== "string") {
      return str; // Return as is if not a string
    }
    return str
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  function gather_update_fields() {
    max_prize_amt_per_bet = $(this).attr("max-prize-amt-per-bet");
    max_win_per_issue = $(this).attr("maximum_win_per_issue");
    maximum_amount_per_issue = $(this).attr("maximum_amount_per_issue");
    min_amount_per_issue = $(this).attr("minimum_amount_per_issue");
    closing = $(this).attr("closing_time");
  }

  function modalClose(modalID = "edit-params-act-btn") {
    $("#" + modalID).removeClass("show");
    $("#" + modalID).hide();
    $(".modal-backdrop.fade.show").remove();
  }

  let debounceTimeout = null;

  // Function to fetch and display users
  const fetchLotteryname = lotteryName => {
    let optionsHtml = "";

    $.post(
      `../admin/searchLotteryName/${encodeURIComponent(lotteryName)}`,
      function(response) {
        try {
          // console.log(response);
          response =
            typeof response === "string" ? JSON.parse(response) : response;

          for (let index = 0; index < response.length; index++) {
            const lot = response[index];
            optionsHtml += `<li class="name-items" data-lot-id="${lot.gt_id}" data-lot-name="${lot.name}">${lot.name}</li>`;
          }
          //  console.log(optionsHtml);
          $("#lot-drw-list-wrapper").html(optionsHtml);
          $(".lot-drw-res-wrapper").show();
        } catch (error) {
          console.error("Error parsing response: ", error);
          $(".userDropdown").hide();
        }
      }
    ).fail(function() {
      console.error("Error fetching users.");
      $(".userDropdown").hide();
    });
  };

  function renderPaginationlist(totalPages, currentPage, pageLimit, callback) {
    const createPageLink = (i, label = i, disabled = false, active = false) =>
      `<li class='page-item ${disabled ? "disabled" : ""} ${active
        ? "active"
        : ""}'>
                <a class='page-link' href='#' data-page='${i}'>${label}</a>
            </li>`;
    let pagLink = `<ul class='pagination justify-content-end'>`;

    // Previous Button
    pagLink += createPageLink(
      currentPage - 1,
      `<i class='bx bx-chevron-left'></i>`,
      currentPage === 1
    );

    // Page numbers with ellipsis
    for (let i = 1; i <= totalPages; i++) {
      if (i === 1 || i === totalPages || Math.abs(i - currentPage) <= 2) {
        pagLink += createPageLink(i, i, false, i === currentPage);
      } else if (i === currentPage - 3 || i === currentPage + 3) {
        pagLink += createPageLink(i, "...", true);
      }
    }

    // Next Button
    pagLink += createPageLink(
      currentPage + 1,
      `<i class='bx bx-chevron-right'></i>`,
      currentPage === totalPages
    );
    pagLink += "</ul>";

    document.getElementById("lb-pagination").innerHTML = pagLink;
    $("#paging_info_drawsw").html(`Page ${currentPage} of ${totalPages} Pages`);

    // Add click event listeners
    document.querySelectorAll("#lb-pagination .page-link").forEach(link => {
      link.addEventListener("click", function(e) {
        e.preventDefault();
        const newPage = +this.getAttribute("data-page");
        if (newPage > 0 && newPage <= totalPages) {
          $("#maskuserlist").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3
          });
          callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
        }
      });
    });
  }

  const transformInput = str => {
    // Trim whitespace from both ends
    str = str.trim();

    // Rule 1: If the string starts with digits, an 'x', and then more digits (e.g. "11x5")
    if (/^\d+x\d+/.test(str)) {
      // Take everything before the first space as the prefix
      const prefix = str.split(/\s+/)[0];
      return prefix.charAt(0).toUpperCase() + prefix.slice(1) + "1001";
    } else {
      // Rule 2: Process as a name-like string

      // Remove any trailing digits (e.g., "RoodevFast3" -> "RoodevFast")
      str = str.replace(/\d+$/, "");

      let words = [];

      // If there's a space, split on whitespace
      if (str.includes(" ")) {
        words = str.split(/\s+/);
      } else {
        // Otherwise, try splitting on CamelCase: sequences of capital letter + subsequent lowercase
        const matches = str.match(/[A-Z][a-z]*/g);
        if (matches) {
          words = matches;
        } else {
          // If we can't split (or there's no CamelCase), treat the entire string as one word
          words = [str];
        }
      }

      // If no words found, just return the (trimmed) string as-is
      if (words.length === 0) {
        return str.charAt(0).toUpperCase() + str.slice(1);
      }
      // Build the abbreviation
      // 1) First letter of the first word
      let abbreviation = words[0].charAt(0);
      // 2) Append the first consonant (non-vowel) that follows in the first word
      const vowels = "aeiouAEIOU";
      for (let i = 1; i < words[0].length; i++) {
        if (!vowels.includes(words[0][i])) {
          abbreviation += words[0][i];
          break;
        }
      }
      // 3) If there's a second word, add its first letter;
      // otherwise, if the first word has >= 3 letters, add the third letter
      if (words.length > 1) {
        abbreviation += words[1].charAt(0);
      } else {
        if (words[0].length >= 3) {
          abbreviation += words[0].charAt(2);
        }
      }
      // Capitalize and append "500"
      return (
        abbreviation.charAt(0).toUpperCase() + abbreviation.slice(1) + "500"
      );
    }
  };

  fetchLotteryBasicParams(1);
  function tableScrolluserListsquota() {
    const tableContainerUsersquota = document.querySelector(
      ".table-wrapperbaic"
    );
    const headerRowUserListsquota = document.querySelector(".headrowDraws");

    tableContainerUsersquota.addEventListener("scroll", function() {
      if (tableContainerUsersquota.scrollTop > 0) {
        headerRowUserListsquota.classList.add("sticky-headrowDraws");
      } else {
        headerRowUserListsquota.classList.remove("sticky-headrowDraws");
      }
    });
  }

  tableScrolluserListsquota();

  const lotterySettings = {
    1: { name: "5D", num_of_balls: 5, min_ball: 0, max_ball: 9 },
    2: { name: "PK10", num_of_balls: 10, min_ball: 1, max_ball: 10 },
    3: { name: "FAST3", num_of_balls: 3, min_ball: 1, max_ball: 6 },
    5: { name: "3D", num_of_balls: 3, min_ball: 0, max_ball: 9 },
    6: { name: "11x5", num_of_balls: 5, min_ball: 1, max_ball: 11 },
    8: { name: "Mark6", num_of_balls: 7, min_ball: 1, max_ball: 49 },
    10: { name: "Happy8", num_of_balls: 8, min_ball: 1, max_ball: 80 },
    11: { name: "PK6", num_of_balls: 6, min_ball: 1, max_ball: 6 }
  };

  $(document).on("change", ".game_groups", function() {
    const selectedID = $(this).val().split("|")[1]; // e.g., "2"
    // console.log(selectedID);
    const settings = lotterySettings[selectedID];

    if (settings) {
      $("#numm_of_balls").val(settings.num_of_balls);
      $("#minn_ball").val(settings.min_ball);
      $("#maxx_ball").val(settings.max_ball);
    } else {
      console.warn(" No settings found for this lottery ID.");
    }
  });

  $(document).on("click", ".addLottery", function(evt) {
    evt.preventDefault();
    const name = $("#namee").val();
    const alias = $("#alias").val();
    const gamegroups = $("#lottery_types").val().split("|")[1];
    const numberOfBalls = $("#numm_of_balls").val();
    const min_ball = $("#minn_ball").val();
    const max_ball = $("#maxx_ball").val();
    const secondsperissue = $("#secondss_per_issue").val();
    // Get raw time and format to HH:MM:SS
    const rawStartTime = $("#starttimee").val();
    const rawStopTime = $("#stoptimee").val();
    const starttime =
      rawStartTime.length === 5 ? rawStartTime + ":00" : rawStartTime;
    const stoptime =
      rawStopTime.length === 5 ? rawStopTime + ":00" : rawStopTime;
    const lotterymodel = $("#lottery_model").val();
    const lotteryType = $("#lottery_types").val().split("|")[0];
    const logoFileName = $(".gameimage").val();

    if (
      !name ||
      !alias ||
      !gamegroups ||
      !lotteryType ||
      !numberOfBalls ||
      !min_ball ||
      !max_ball ||
      !secondsperissue ||
      isNaN(secondsperissue) ||
      parseInt(secondsperissue) <= 0 ||
      !starttime ||
      !stoptime ||
      !lotterymodel ||
      !logoFileName
    ) {
      showToast(
        "Heads up!!",
        "All fields are required and seconds per issue must be a positive number",
        "info"
      );

      return;
    }

    $("#lotteryForm")[0].reset();
    $("#addlottery-modals").modal("hide");

    $.post(
      `../game/addlottery/${encodeURIComponent(name)}/${encodeURIComponent(
        alias
      )}/${encodeURIComponent(
        gamegroups
      )}/${numberOfBalls}/${min_ball}/${max_ball}/${secondsperissue}/${starttime}/${stoptime}/${lotterymodel}/${encodeURIComponent(
        lotteryType
      )}/${encodeURIComponent(logoFileName)}`,
      function(response) {
        console.log(response);

        if (response.status === "success") {
          showToast(
            "Success",
            response.message ||
              "Lottery Game Added and odds updated successfully",
            "success"
          );
          //    $("#myFormsss")[0].reset();

          fetchLotteryBasicParams(1);

          $("#lotteryForm")[0].reset(); // This one line replaces all individual resets
          $("#logoPreview").hide(); // Hide the preview if shown
          $("#addlottery-modals").modal("hide");
        } else if (
          response.status === "error" &&
          response.message.includes("already exists")
        ) {
          showToast(
            "Already Exists",
            response.message || "Lottery already added",
            "warning"
          );
        } else if (response.status === "error") {
          showToast("Error", response.message || "Operation failed", "error");
        }
      },
      "json" // expecting JSON response
    );
  });

  $(document).on("click", ".refreshgame", function() {
    // Show loading overlay
    $("#masklotterygames").LoadingOverlay("show", {
      background: "rgba(90,106,133,0.1)",
      size: 3
    });
    $("#lottery").val("0");
    $("#partnerSelect").val("0");

    $(".userIdtrans").val("");
    setTimeout(() => {
      $("#masklotterygames").LoadingOverlay("hide");
      fetchLotteryBasicParams(1);
    }, 3000);
  });

  async function getAllGamesLottery() {
    try {
      const response = await fetch(`../game/getAllGamesLottery`);
      const data = await response.json();
      // console.log(data);

      let lotteryTypeOptions =
        "<option value='' disabled selected>Select Lottery Type</option>";

      data.forEach(item => {
        lotteryTypeOptions += `<option value='${item.name}|${item.lt_id}'>${item.name}</option>`;
      });

      $(".lotteryTypeSelect").html(lotteryTypeOptions);
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  getAllGamesLottery();

  async function getTimegames() {
    try {
      const response = await fetch(`../game/getTimegames`);
      const data = await response.json();
      // console.log(data);

      let html = "";

      html += `<option>select Time</option>`;
      data.forEach(item => {
        html += `<option value='${item.seconds}'>${item.seconds}</option>`;
      });
      $(".secondsselect").html(html);
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }
  getTimegames();

  async function getAllGamesModels() {
    try {
      const response = await fetch(`../game/getAllGameModels`);
      const data = await response.json();
      // console.log(data);

      let html = "";

      html += `<option>select Game Model</option>`;
      data.forEach(item => {
        html += `<option value='${item.model_id}'>${item.model_name}</option>`;
      });
      $(".modelTypess").html(html);
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }
  getAllGamesModels();

  $(document).on("click", ".lb-tclose", function() {
    $("#lb-toggle-lottery").removeClass("show");
    $("#lb-toggle-lottery").css("display", "none");
  });

  $(document).on("click", ".addnewlottery", function() {
    $("#addlottery-modals").modal("show");
  });

  // Show modal with game ID
  $(document).on("click", ".addgamemodal", function() {
    const id = $(this).data("id");
    $("#lottery_game_id").val(id);

    $("#imagePreview").hide().attr("src", "#");
    $("#lottery_logo_file").val("");
    $("#lb-uploadimage").modal("show");
  });

  let selectedFile = null;
  // Handle file input change and preview
  $("#lottery_logo_file").on("change", function() {
    const file = this.files[0];
    if (file) {
      if (file.size > 1048576) {
        // 1MB
        showToast("Error", "Image is too large. Max 1MB allowed.", "error");

        $(this).val("");
        $("#imagePreview").hide().attr("src", "#");
        selectedFile = null;
        return;
      }
      selectedFile = file;
      const reader = new FileReader();
      reader.onload = function(e) {
        $("#imagePreview").attr("src", e.target.result).show();
      };
      reader.readAsDataURL(file);
    }
  });

  // Handle confirm upload button click
  let base64String = "";
  $(document).on("click", "#upload", function() {
    const imageData = $("#lottery_game_id").val().split("|");

    if (!selectedFile) {
      showToast("Headsup!", "Please select an image to upload.", "info");

      return;
    }
    if (selectedFile.size > 1048576) {
      showToast("Error", "Image is too large. Max 1MB allowed.", "error");
      return;
    }

    $.post(
      "http://192.168.1.51/chairman_test/api/v1/limvo/udateGameImage",
      JSON.stringify({
        imageData: base64String,
        gameId: imageData[0],
        gameName: imageData[1]
      }),
      function(response) {
        // console.log(response);
        if (response.type === "success") {
          showToast("Success", response.message, "success");
          fetchLotteryBasicParams(1);
          $("#lb-uploadimage").modal("hide");
          $("#lottery_logo_file").val("");
        } else {
          showToast(
            "Error",
            response.message || "Image upload failed.",
            "error"
          );
        }
      },
      "json" // expecting JSON response
    );
  });

  function convertImageToBase64(file, callback) {
    const reader = new FileReader();
    reader.onload = function(e) {
      base64String = e.target.result.split(",")[1]; // Remove data:image/... prefix
      callback(base64String);
    };
    reader.readAsDataURL(file); // Reads file as Data URL (Base64)
  }

  // Example usage (on file input change)
  document
    .getElementById("lottery_logo_file")
    .addEventListener("change", function(e) {
      const file = e.target.files[0];
      base64String = convertImageToBase64(file, function(imageString) {
        return imageString;
        //  console.log(base64String)
      });
    });

  // $(".refreshgame").click(function () {
  //   // Show loading overlay
  //   $("#masklotterygames").LoadingOverlay("show", {
  //     background: "rgb(90,106,133,0.1)",
  //     size: 3
  //   });

  //   // Clear all input fields
  //   $("#bl-idholder").val("");
  //   $("#bl-username").val("");
  //   $("#bl-bank-type").val("");
  //   $("#bl-card-number").val("");
  //   $("#bl-status").val(0);
  //   $("#transuserpayment").val("");
  //   $(".queryholderuserpayment").hide().html("");
  //   $(".userIdtrans").val("");

  //   fetchLotteryBasicParams(1); // Also removed 'this' here
  // });
});
