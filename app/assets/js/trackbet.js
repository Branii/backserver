$(function () {
    //NOTE -
    ////////////// LOTTERY BETTING-//////////
    function formatBalance(balance) {
        if (balance % 1 !== 0 && balance.toString().split(".")[1].length > 3) {
            return Number(balance).toFixed(4);
        }
        return Number(balance).toFixed(4);
    }
    function formatMoney(money) {
        return String(money).includes(".") && String(money).split(".")[1].length > 2 ? String(Number(money).toFixed(4)) : money;
    }
    const Trackbetdata = (data) => {
        let htmls = "";
        const bettype = {
            1: "Bet",
            2: "Track",
        };

        const trackstatus = {
            1: "Running",
            2: "Self Stop Track",
            3: "Completed",
            4: "Stop If Win",
            5: "Stop If Not Win",
        };
        const states = {
            1: "Settled",
            2: "Unsettled",
            4: "Cancelled",
            7: "Refund",
            8: "Delete",
        };

        data.forEach((item) => {
            let username = item.reg_type === "email" ? item.email : item.reg_type === "username" ? item.username : item.contact;
            htmls += `
                    <tr>
                        <td>${item.track_token}</td>
                        <td>${username}</td>
                        <td>${item.game_type}</td>
                        <td>${item.start_draw}</td>
                        <td>${item.total_bets + "/" + item.tracked}</td>
                        <td>${formatMoney(item.total_amount) + "/" + formatMoney(item.done_amount)}</td>                  
                        <td>${trackstatus[item.track_status]}</td>
                        <td>${item.win_amount}</td>
                       <td>${item.track_rule}</td>
                       <td>${item.server_date + "/" + item.server_time}</td>
                      <td><i value='${item.track_token}_${item.game_type_id}' class='bx bx-info-circle trackinfo' style='color:#868c87;font-size:18px;cursor:pointer;'></i></td>
                       
                        
                        
                    </tr>
                `;
        });
        return htmls;
    };

    const Showtrackbet = (data, obj) => {
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

    const firstRowtrack = {
        reg_type: "Username:",
        bet_code: "Bet Order ID:",
        draw_period: "Issue Number:",
        ip_address: "IP:",
        unit_stake: "Unit Stake:",
        multiplier: "Multiplier:",
        bet_status: "Bet Status:",
        game_label: "Game Type::",
        draw_number: "Draw Results:",
        num_wins: "Number of wins:",
    };

    const secondRowtrack = {
        bettype: "Bet Type:",
        game_type: "Lottery Type:",
        bet_time: "Bet Time:",
        closing_time: "Closing Time:",
        opening_time: "Draw Time::",
        bet_number: "Total Bet:",
        bet_amount: "Total Bet Amount:",
        // 'win_amount': 'Prize:',
        win_amount: "Win Amount:",
        // 'server_time': 'Actual profit:',
        rebate_amount: "Rebate Amount",
        user_selection: "Bet Selection",
    };

    const rendertrack = (data) => {
        var htmls = Trackbetdata(data);
        $("#trackdataContainer").html(htmls);
    };

    //   let currentPagetracktrack = 1;
    //   let pageLimit = 10;

    let currentPagetrack = 1;
    let pageLimit = 10;

    async function fetchtrackdata(page, pageLimit) {
        try {
            const response = await fetch(`../admin/trackdata/${page}/${pageLimit}`);
            const data = await response.json();

            $("#masktrack").LoadingOverlay("hide");
            rendertrack(data.trackbet);

            // Render pagination
            renderPaginationtrack(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchtrackdata(newPage, pageLimit));
            document.getElementById("paging_infotrack").innerHTML = "Page " + page + " of " + data.totalPages + " pages";
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }

    async function filterTrack(usernames, trackstatus, tracklotery, startdatetrack, enddatetrack, currentPagetrack, pageLimit) {
        try {
            const response = await fetch(`../admin/filterTrackdata/${usernames}/${trackstatus}/${tracklotery}/${startdatetrack}/${enddatetrack}/${currentPagetrack}/${pageLimit}`);

            const data = await response.json();
            if (data.response == "error") {
                showToast("Alert", "User does not exist", "info");
                $(".loader").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
                return;
            }

            ///console.log(response);

            $(".loadertrack").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
            if (data.trackfilter.length < 1) {
                let html = `
            <tr class="no-results">
                <td colspan="9">
                    <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                </td>
            </tr>`;
                $("#masktrack").LoadingOverlay("hide");
                $("#trackdataContainer").html(html);
                return;
            }
            $("#masktrack").LoadingOverlay("hide");
            rendertrack(data.trackfilter);

            // Render pagination
            renderPaginationtrack(data.totalPages, currentPagetrack, pageLimit, (newPage, pageLimit) => filterTrack(usernames, trackstatus, tracklotery, startdatetrack, enddatetrack, newPage, pageLimit));
            document.getElementById("paging_infotrack").innerHTML = "Page " + currentPagetrack + " of " + data.totalPages + " pages";
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }

    function renderPaginationtrack(totalPages, currentPagetrack, pageLimit, callback) {
        const createPageLink = (i, label = i, disabled = false, active = false) =>
            `<li class='page-item ${disabled ? "disabled" : ""} ${active ? "active" : ""}'>
          <a class='page-link' href='#' data-page='${i}'>${label}</a>
      </li>`;
        let pagLink = `<ul class='pagination justify-content-end'>`;

        // Previous Button
        pagLink += createPageLink(currentPagetrack - 1, `<i class='bx bx-chevron-left'></i>`, currentPagetrack === 1);

        // Page numbers with ellipsis
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || Math.abs(i - currentPagetrack) <= 2) {
                pagLink += createPageLink(i, i, false, i === currentPagetrack);
            } else if (i === currentPagetrack - 3 || i === currentPagetrack + 3) {
                pagLink += createPageLink(i, "...", true);
            }
        }

        // Next Button
        pagLink += createPageLink(currentPagetrack + 1, `<i class='bx bx-chevron-right'></i>`, currentPagetrack === totalPages);
        pagLink += "</ul>";

        document.getElementById("paginationtrack").innerHTML = pagLink;

        // Add click event listeners
        document.querySelectorAll("#paginationtrack .page-link").forEach((link) => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                const newPage = +this.getAttribute("data-page");
                if (newPage > 0 && newPage <= totalPages) {
                    $("#masktrack").LoadingOverlay("show", {
                        background: "rgb(90,106,133,0.1)",
                        size: 3,
                    });
                    callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
                }
            });
        });
    }

    fetchtrackdata(currentPagetrack, pageLimit);

    $(".playertrack").click(function () {
        let direction = $(this).val();
        const tableWrapper = $(".table-wrappertrack");
        const tableWrappers = document.querySelector(".table-wrappertrack");
        const scrollAmount = 1000; // Adjust as needed
        const scrollOptions = {
            behavior: "smooth",
        };
        if (tableWrapper.length) {
            switch (direction) {
                case "trackleft":
                    tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
                    break;
                case "trackright":
                    tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
                    break;
                case "trackstart":
                    // Scroll to the absolute start (leftmost position)
                    tableWrapper.animate({ scrollLeft: 0 }, "slow");
                    break;
                case "trackend":
                    const maxScrollLeft = tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
                    tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
                    break;
                default:
                    break;
            }
        }
    });

    $(".refreshtrack").click(function () {
        $(".queryholderlist").val("");
        $("#masktrack").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3,
        });
        fetchtrackdata(currentPagetrack, pageLimit);
    });

    $(".numrowstrack").change(function () {
        $("#masktrack").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3,
        });
        const numrows = $(this).val();
        fetchtrackdata(currentPagetrack, numrows);
    });

    $(".executetrack").click(function () {
        if ($("#trackinput").val() == "" && $(".trackstatus").val() == "" && $(".tracklotery").val() == "" && $(".startdatetrack").val() == "") {
            $("#dangertrack").modal("show");
            return;
        }
        const usernames = $("#trackinput").val();
        const trackstatus = $(".trackstatus").val();
        const tracklotery = $(".tracklotery").val();
        const startdatetrack = $(".startdatetrack").val();
        const enddatetrack = $(".enddatetrack").val();
        console.log(usernames);
        filterTrack(usernames, trackstatus, tracklotery, startdatetrack, enddatetrack, currentPagetrack, pageLimit);
        $(".loadertrack").remove("bx bx-check-double").addClass("bx bx-loader bx-spin");
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
    fetchLotteryname();

    $(document).on("click", ".trackinfo", function () {
        $("#viewtrackmodal").modal("show");
        const tracktoken = $(this).attr("value");
        console.log(tracktoken);

        $("#row1").empty();
        $("#row2").empty();
        fetchTrackDeatails(tracktoken);
        fetchAllToken(tracktoken);
    });

    async function fetchAllToken(tracktoken) {
        try {
            const response = await fetch(`../admin/getAllTokenbet/${tracktoken}`);
            const data = await response.json();
            const tableBody = document.getElementById("trackbetTableBody");
            tableBody.innerHTML = "";
            data.forEach((item) => {
                const row = document.createElement("tr");

                const betstatus = {
                    2: "Win",
                    3: "Loss",
                    5: "Pending",
                    6: "Void",
                    7: "Refund",
                };
                row.innerHTML = `
                <td>${item.draw_number || "N/A"}</td>        <!-- Draw Result -->
                <td>${item.draw_period || "N/A"}</td>       <!-- Issue Number -->
                <td>${item.multiplier || "N/A"}</td>        <!-- Multiplier -->
                <td>${item.bet_amount || "N/A"}</td>        <!-- Bet Amount -->
                <td>${item.trackrule || "N/A"}</td>          <!-- Progress -->
                <td>${betstatus[item.bet_status] || "N/A"}</td>        <!-- Track Status -->
            `;
                // Append the row to the table body
                tableBody.appendChild(row);
            });
        } catch (error) {
            console.error("Error fetching or rendering data:", error);
        }
    }

    async function fetchTrackDeatails(tracktoken) {
        try {
            const response = await fetch(`../admin/getTrackbet/${tracktoken}`);
            const data = await response.json();
            $("#row1").empty();
            $("#row2").empty();
            let html1 = Showtrackbet(firstRowtrack, data);
            let html2 = Showtrackbet(secondRowtrack, data);
            $("#rowtrack").html(html1);
            $("#rowtrack1").html(html2);
            // }
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }

    let debounceTimeout = null;

    $(document).ready(function () {
        // Event listener for keyup on #myInput
        $(document).on("keyup", "#trackinput", function () {
            const query = $(this).val().trim();

            // Only trigger if input is more than 2 characters
            if (query.length > 1) {
                clearTimeout(debounceTimeout); // Clear any existing timeout
                debounceTimeout = setTimeout(fetchbetUser, 500, query); // Call fetchUsers with the query after 500ms delay
            } else {
                $(".trackdown").hide(); // Hide dropdown if input is less than 3 characters
            }
        });

        // Handle dropdown item selection
        $(document).on("change", ".trackdown", function () {
            const selectedOption = $(this).find("option:selected");
            const selectedUserId = selectedOption.val();
            const selectedUsername = selectedOption.data("username");

            if (selectedUserId) {
                $("#trackinput").val(selectedUsername);
                $(".userIdbet").val(selectedUserId);
                $(".trackdown").hide();
            }
        });

        // Handle manual input clearing
        $(document).on("input", "#trackinput", function () {
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

                $(".trackdown").html(optionsHtml).show();
            } catch (error) {
                console.error("Error parsing response: ", error);
                $(".trackdown").hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $(".trackdown").hide();
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
