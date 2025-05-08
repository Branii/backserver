
$(function () {
    const partnerID = $("#partner-holder").attr("data-partner-id");
    //NOTE -
    ////////////// LOTTERY BETTING-//////////
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

    const formatText = (text) => {
        return text
            .split("_") // Split the string into parts based on underscores
            .map((word) => word.charAt(0).toUpperCase() + word.slice(1)) // Capitalize the first letter of each word
            .join(" "); // Join the parts back with spaces
    };

    const translatorScript = document.querySelector(".translations"); // Get the script tag
    const translator = JSON.parse(translatorScript.textContent);
    const Trackbetdata = (data) => {
        let htmls = "";
        const bettype = {
            1: "Bet",
            2: "Track",
        };

        const trackstatus = {
            1: translator["Running"],
            2: translator["Self Stop Track"],
            3: translator["Completed"],
            4: translator["Stop If Win"],
            5: translator["Stop If Not Win"],
        };
        const states = {
            1: "Settled",
            2: "Unsettled",
            4: "Cancelled",
            8: "Delete",
        };

        data.forEach((item) => {
            let username = item.reg_type === "email" ? item.email : item.reg_type === "username" ? item.username : item.contact;
            let trackrule = item.track_rule == "no_rule" ? "No Rule" : item.track_rule == "stop_if_not_win" ? "Stop If Not Win" : item.track_rule == "stop_if_win" ? "Stop If Win" : "";
            htmls += `
                    <tr>
                        <td>${item.track_token}</td>
                        <td>${username}</td>
                        <td>${item.game_type}</td>
                        <td>${item.start_draw}</td>
                        <td>${item.tracked + "/" + item.total_bets}</td>
                        <td>${formatMoney(item.done_amount) + "/" + formatMoney(item.total_amount)}</td>                  
                        <td>${formatMoney(item.win_amount)}</td>
                        <td>${trackrule}</td>
                        <td>${item.server_date + " / " + item.server_time}</td>
                        <td> <span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">${trackstatus[item.track_status]}</span></td>
                        <td><i value='${item.track_token}_${item.game_type_id}' class='bx bx-info-circle trackinfo' style='color:#868c87;font-size:18px;cursor:pointer;'></i></td>
                    </tr>
                `;
        });
        return htmls;
    };

    const Showtrackbet = (data, obj) => {
        let htmlbet = "";
        Object.entries(data).forEach(([key, value]) => {
            let test = value !== translator["Bet Selection"] && langMap[value] ? langMap[value] : translator["Bet Selection"];

            if (value == test) {
                 htmlbet += `
                  <td>${value}</td>
                   <td class="${key === "user_selection" ? "bet_userSelection" : ""}">
                    <textarea class="form-control"   readonly style="height: 75px;">${obj[key]}</textarea>
                    </td>`
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
        '投注选择:' :'Bet Selection',
    }
    
    const firstRowtrack = {
        bet_code:    `${translator["Bet Order ID"]}`,
        draw_period: `${translator["Issue Number"]}`,
        bet_time:    `${translator["Bet Time"]}`,
        bet_number:  `${translator["Total Bets"]}`,
        unit_stake:  `${translator["Unit Stake"]}`,
        multiplier:  `${translator["Multiplier"]}`,
        bet_amount:  `${translator["Total Bet Amount"]}`,
        win_bonus:   `${translator["Win Amount"]}`,
        rebate_amount:`${translator["Rebate Amount"]}`,
        num_wins:     `${translator["Number of Wins"]}`,
        draw_number:  `${translator["Draw Results"]}`,
    };
    
    const secondRowtrack = {
        reg_type:   `${translator["Username"]}`,
        ip_address: `${translator["IP"]}`,
        game_type:  `${translator["Lottery Type"]}`,
        game_label: `${translator["Game Label"]}`,
        bettype:    `${translator["Bet Type"]}`,
        game_model: `${translator["Game Model"]}`,
        closing_time:`${translator["Closing Time"]}`,
        opening_time:`${translator["Draw Time"]}`,
        bet_status:  `${translator["Bet Status"]}`,
        user_selection: `${translator["Bet Selection"]}`,
    };
     

    const rendertrack = (data) => {
        var htmls = Trackbetdata(data);
        $("#trackdataContainer").html(htmls);
    };

    let currentPagetrack = 1;
    let pageLimit = 20;

    async function fetchtrackdata(page, pageLimit) {
        try {
            const response = await fetch(`../admin/trackdata/${page}/${pageLimit}`);
            const data = await response.json();
    
            $("#masktrack").LoadingOverlay("hide");
            rendertrack(data.trackbet);
            // Render pagination
            renderPaginationtrack(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchtrackdata(newPage, pageLimit));
            document.getElementById("paging_infotrack").innerHTML = `${translator["Page"]} ${page} ${translator["Of"]} ${data.totalPages} ${translator["Pages"]}`;
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }

    async function filterTrack(usernames, trackstatus, trackcode, tracklotery, startdatetrack, enddatetrack, currentPagetrack, pageLimit) {
        try {
            const response = await fetch(`../admin/filterTrackdata/${usernames}/${trackstatus}/${trackcode}/${tracklotery}/${startdatetrack}/${enddatetrack}/${currentPagetrack}/${pageLimit}`);

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
            renderPaginationtrack(data.totalPages, currentPagetrack, pageLimit, (newPage, pageLimit) => filterTrack(usernames, trackstatus, trackcode, tracklotery, startdatetrack, enddatetrack, newPage, pageLimit));
            document.getElementById("paging_infotrack").innerHTML = `${translator["Page"]} ${page} ${translator["Of"]} ${data.totalPages} ${translator["Pages"]}`;
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
        const scrollOptions = { behavior: "smooth" };
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
        if ($("#trackinput").val() == "" && $(".trackstatus").val() == "" && $(".tracklotery").val() == "" && $(".startdatetrack").val() == "" && $("#trackcode").val() == "") {
            showToast("Heads up!!", "Select one or more data fields to filter", "info");
            return;
        }
        const usernames = $("#trackinput").val();
        const trackstatus = $(".trackstatus").val();
        const tracklotery = $(".tracklotery").val();
        const trackcode = $("#trackcode").val();
        const startdatetrack = $(".startdatetrack").val();
        const enddatetrack = $(".enddatetrack").val();

        filterTrack(usernames, trackstatus, tracklotery, trackcode, startdatetrack, enddatetrack, currentPagetrack, pageLimit);
        $(".loadertrack").remove("bx bx-check-double").addClass("bx bx-loader bx-spin");
    });

    async function fetchLotteryname() {
        try {
            const response = await fetch(`../admin/fetchLotteryname/${partnerID}`); // Await the fetch call
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json(); // Parse JSON response
            // console.log(data);
            let html = `<option value="">${translator['Lottery Type']}</option>`;
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
                    2: translator["Win"],
                    3: translator["Loss"],
                    5: translator["Pending"],
                    6: translator["Void"],
                    7: translator["Refund"],
                };

                const states = {
                    1: "Settled",
                    2: "Unsettled",
                    4: "Cancelled",
                    7: translator["Refund"]
                };
                row.innerHTML = `
                <td>${item.draw_number || "N/A"}</td>     
                <td>${item.draw_period || "N/A"}</td> 
                <td>${item.multiplier || "N/A"}</td>       
                <td>${item.bet_amount || "N/A"}</td> 
                <td>${states[item.state]|| "N/A"}</td>
                <td>${betstatus[item.bet_status] || "N/A"}</td>    
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

        $(document).on("click", function (e) {
            const $dropdownbet = $("#usertrackDropdown");
            if (!$(e.target).closest("#trackinput, #usertrackDropdown").length) {
                $dropdownbet.hide();
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

    function tableScrolltracker() {
        const tableContainerTracker = document.querySelector(".trackertable");
        const headerRowTrack = document.querySelector(".trackerheasrow");

        tableContainerTracker.addEventListener("scroll", function () {
            if (tableContainerTracker.scrollTop > 0) {
                headerRowTracker.classList.add("sticky-trackerhead");
            } else {
                headerRowTracker.classList.remove("sticky-trackerhead");
            }
        });
    }
    tableScrolltracker();

    $(".clearitem").on("dblclick", function () {
        $(this).val(""); // Clears the input field
    });
});
