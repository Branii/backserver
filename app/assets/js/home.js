$(function () {
  //NOTE -
  //////////////ACCOUNT TRANSACTION-//////////

  const AccountTransactions = (data) => {
    let html = "";
    const status = {
      1: "Deposit",
      2: "Win Bonus",
      3: "Bet Awarded",
      4: "Withdrawal",
      5: "Bet Cancelled",
      6: "Bet Deduct",
      7: "Rebates",
      8: "Self Rebate",
      9: "Send Red Envelope",
      10: "Receive Red Envelope",
      11: "Bet Refund",
    };

    data.forEach((item) => {
      html += `
                  <tr>
                      <td>${item.order_id.substring(0, 7)}</td>
                      <td>${item.username}</td>
                      <td>${status[item.order_type]}</td>
                      <td>${item.account_change}</td>
                      <td>${item.balance}</td>
                      <td>${item.dateTime}</td>
                      <td>${item.order_id}</td>
                      <td><i class='bx bxs-circle' style='color:#1dd846;font-size:8px'></i> Complete</td>
                      <td><i class='bx bx-info-circle' style='color:#868c87;font-size:18px;cursor:pointer;' ></i></td>
                  </tr>
              `;
    });
    return html;
  };

  const render = (data) => {
    var html = AccountTransactions(data);
    $("#dataContainer").html(html);
  };

  let currentPage = 1;
  let pageLimit = 50;

  async function fetchTrasaction(page) {
    try {
      const response = await fetch(
        `../admin/transactiondata/${page}/${pageLimit}`
      );
      const data = await response.json();
      console.log(response);

      $("#mask").LoadingOverlay("hide");

      // Render table data
      render(data.users);

      // Render pagination
      renderPagination(data.totalPages, page);
      document.getElementById("paging_info").innerHTML =
        "Page " + page + " of " + data.totalPages + " pages";
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }


  function renderPagination(totalPages, currentPage) {
    let pagLink = `<ul class='pagination justify-content-end'>`;

    // Previous Button
    pagLink += `
              <li class='page-item ${currentPage === 1 ? "disabled" : ""}'>
                  <a class='page-link' href='#' data-page='${
                    currentPage - 1
                  }'><i class='bx bx-chevron-left'></i></a>
              </li>
          `;

    // Page numbers with ellipsis
    for (let i = 1; i <= totalPages; i++) {
      if (i === currentPage) {
        pagLink += `<li class='page-item active'><a class='page-link' href='#'>${i}</a></li>`;
      } else if (
        i === 1 ||
        i === totalPages ||
        Math.abs(i - currentPage) <= 2
      ) {
        pagLink += `<li class='page-item'><a class='page-link' href='#' data-page='${i}'>${i}</a></li>`;
      } else if (i === currentPage - 3 || i === currentPage + 3) {
        pagLink += `<li class='page-item disabled'><a class='page-link'>...</a></li>`;
      }
    }

    // Next Button
    pagLink += `
              <li class='page-item ${
                currentPage === totalPages ? "disabled" : ""
              }'>
                  <a class='page-link' href='#' data-page='${
                    currentPage + 1
                  }'><i class='bx bx-chevron-right'></i></a>
              </li>
          `;

    pagLink += "</ul>";
    document.getElementById("pagination").innerHTML = pagLink;

    // Add click event listeners to pagination links
    document.querySelectorAll("#pagination .page-link").forEach((link) => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        const newPage = parseInt(this.getAttribute("data-page"));
        if (newPage > 0 && newPage <= totalPages) {
          currentPage = newPage;
          document.getElementById("paging_info").innerHTML =
            "Page " + currentPage + " of " + totalPages + " pages";
          fetchTrasaction(currentPage);
        }
      });
    });
  }

   fetchTrasaction(currentPage);

  $(".player").click(function () {
    let direction = $(this).val();
    const tableWrapper = $(".table-wrapper");
    const tableWrappers = document.querySelector(".table-wrapper");
    const scrollAmount = 1000; // Adjust as needed
    const scrollOptions = {
      behavior: "smooth",
    };
    if (tableWrapper.length) {
      switch (direction) {
        case "left":
          tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
          break;
        case "right":
          tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
          break;
        case "start":
          // Scroll to the absolute start (leftmost position)
          tableWrapper.animate({ scrollLeft: 0 }, "slow");
          break;
        case "end":
          const maxScrollLeft =
            tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
          tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
          break;
        default:
          break;
      }
    }
  });

  $(".refresh").click(function () {
    $("#mask").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3,
    });
    fetchTrasaction(currentPage);
  });

  $(".execute").click(function () {
    console.log("spinning");
    $(".loader").remove("bx bx-check-double").addClass("bx bx-loader bx-spin");
  });
  let debounceTimeout;
  $(".username").keyup(function () {
    let searchkey = $(this).val();
    const dropdown = $("#userDropdown");
    dropdown.empty(); // Clear existing options
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
      $.post(`../admin/filterusername/${searchkey}`, function (response) {
        if (response) {
          $("#userDropdown").show();
          let html = "";
          response.forEach((user) => {
            html += `<div value="${user.username}" class="option">${user.username}</div>`;
          });
          console.log("html  " + html);
          $("#userDropdown").html(html);
          $("#userDropdown").show();
        } else {
          $("#userDropdown").show();
        }
      });
    }, 300);
  });

  $(document).on("click", ".option", function () {
    $(".username").val($(this).text());
    $("#userDropdown").hide();
  });

  $(document).on("click", ".executetrans", function () {
    const username = $(".username").val();
    const order_id = $(".orderid").val();
    const odertype = $(".ordertype").val();
    const startdate = $(".startdate").val();
    const enddate = $(".enddate").val();
    console.log("spinning");
    $(".loader").remove("bx bx-check-double").addClass("bx bx-loader bx-spin");
    console.log(username, order_id, odertype, startdate, enddate);
  });


});
