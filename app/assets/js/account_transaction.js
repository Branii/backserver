
$(function () {
    
    const partnerID = $("#partner-holder").attr("data-partner-id");

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

    const translatorScript = document.querySelector(".translations"); 
    const translator = JSON.parse(translatorScript.textContent); 
    const AccountTransactions = (data) => {
        let html = "";

        const statusColor = {
            1: { title: translator["Deposit"], color: "#4CAF50" }, // Green
            2: { title: translator["Win Bonus"], color: "#FF9800" }, // Orange
            3: { title: translator["Bet Awarded"], color: "#03A9F4" }, // Light Blue
            4: { title: translator["Withdrawal"], color: "#F44336" },
            5: { title: translator["Bet Deduct"], color: "#E91E63" }, // Red
            6: { title: translator["Bet Cancelled"], color: "#9E9E9E" }, // Grey
            7: { title: translator["Rebates"], color: "#8BC34A" }, // Light Green
            8: { title: translator["Self Rebate"], color: "#00BCD4" }, // Cyan
            9: { title: translator["Sending Red Envelope"], color: "#FF5722" }, // Deep Orange
            10: { title: translator["Red Envelope Receive"], color: "#795548" }, // Brown
            11: { title: translator["Bet Refund"], color: "#FFC107" }, // Amber
            // 12: { title: translator["Bet Lost"], color: "#FFC107" } // Amber
        };

        let completes = translator["Completed"];
        const formatTimestamp = (timestamp) => `${timestamp.slice(0, 10)} / ${timestamp.slice(10)}`;

        data.forEach((item) => {
            let username = item.reg_type === "email" ? item.email : item.reg_type === "username" ? item.username : item.contact;
            if (item.order_type === 12) return;
            let timezone = item.timezone.split(" ");
            timezone     = `${timezone[0]}<span style="margin-left: 1rem;">GMT${timezone[1]}</span>`
            html += `
                      <tr class="trow">
                        <td>${"TR" + item.order_id.substring(0, 7)}</td>
                        <td>${username}</td>
                        <td>${item.name}</td>
                        <td><i class='bx bxs-circle' style='color:${statusColor[item.order_type].color};font-size:8px;margin-right:5px;'></i>${statusColor[item.order_type].title}</td>
                        <td>${formatMoney(item.account_change) < 0 ? formatMoney(item.account_change) : `+ ${formatMoney(item.account_change)}`}</td>
                        <td>${formatMoney(item.balance)}</td>
                        <td>${formatTimestamp(item.date_created)}</td>
                        <td>${timezone}</td>
                        <td>${item.order_id}</td>
                        <td> <span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">${completes}</span></td>
                        <td><i value='${item.order_id}_${item.game_type}_${item.order_type}' class='bx bx-info-circle tinfo' style='color:#868c87;font-size:18px;cursor:pointer;'></i></td>
                      </tr>
                  `;
        });

        return html;
    };

    const FromTable = (transactiondata, obj) => {
        let html = ""; // Initialize the HTML string

        Object.entries(transactiondata).forEach(([key, value]) => {

            let test = value !== translator["Bet Selection"] && langMap[value] ? langMap[value] : translator["Bet Selection"];
            if (value == test) {
                html += `
                   <td>${value}</td>
                  <td class="">
                     <textarea class="form-control" readonly style="height:75px;">${obj[key]}</textarea>
                  </td>`;
            } else {
                html += `
                   <tr>
                     <td>${value}</td>
                     <td class="${key === "user_selection" ? "bt" : ""}" 
                       ${key === "user_selection" ? `ti="${obj[key]}"` : ""}>
                       ${key === "win_bonus" || key === "bet_amount" || key === "rebate_amount" ? `${formatMoney(obj[key])}` : `${obj[key]}`}
                      </td>
                   </tr>
                   `;
            }
        });

        return html; 
    };

    const langMap = {
        '投注选择:' :'Bet Selection',
    }
    
    const firstRow = {
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

    const secondRow = {
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
    };

    const render = (data) => {
        var html = AccountTransactions(data);
        $("#dataContainer").html(html);
    };

    let currentPage = 1;
    let pageLimit = 20;

    async function fetchTrasaction(page, pageLimit) {
        try {
            const response = await fetch(`../admin/transactiondata/${page}/${pageLimit}`);
            const data = await response.json();
            $("#mask").LoadingOverlay("hide");
            render(data.transaction);
            renderPagination(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchTrasaction(newPage, pageLimit));
            document.getElementById("paging_info").innerHTML = `${translator["Page"]} ${page} ${translator["Of"]} ${data.totalPages} ${translator["Pages"]}`;
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }
    fetchTrasaction(currentPage, pageLimit);

    function renderPagination(totalPages, currentPage, pageLimit, callback) {
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
        document.querySelectorAll("#pagination .page-link").forEach((link) => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                const newPage = +this.getAttribute("data-page");
                if (newPage > 0 && newPage <= totalPages) {
                    $("#mask").LoadingOverlay("show", {
                        background: "rgb(90,106,133,0.1)",
                        size: 3,
                    });
                    callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
                }
            });
        });
    }

    $(".playertrans").click(function () {
        let direction = $(this).val();
        const tableWrapper = $(".table-wrapperaccount");
        const tableWrappers = document.querySelector(".table-wrapperaccount");
        const scrollAmount = 1000; // Adjust as needed
        const scrollOptions = {
            behavior: "smooth",
        };
        if (tableWrapper.length) {
            switch (direction) {
                case "lefttrans":
                    tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
                    break;
                case "righttrans":
                    tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
                    break;
                case "starttrans":
                    // Scroll to the absolute start (leftmost position)
                    tableWrapper.animate({ scrollLeft: 0 }, "slow");
                    break;
                case "endtrans":
                    const maxScrollLeft = tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
                    tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
                    break;
                default:
                    break;
            }
        }
    });

    $(".accountrefresh").click(function () {
        $(".queryholdertransaction").val("");

        $("#mask").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3,
        });

        fetchTrasaction(currentPage, pageLimit);
    });

    $(document).on("click", ".executetrans", function () {
        if ($("#transuser").val() == "" && $("#transactionId").val() == "" && $("#ordertypetrans").val() == ""
         && $("#startdatrans").val() == "" && $(".selectpartner").val() == "") {
            showToast("Heads up!!", "Select one or more data fields to filter", "info");
            return;
        }
        const transusername = $("#transuser").val();
        const transactionId = $("#transactionId").val();
        const ordertypetrans = $("#ordertypetrans").val();
        const partneruid = $(".selectpartner").val();
        const startdatrans = $("#startdatrans").val();
        const enddatetrans = $("#enddatetrans").val();
       
        $(".loadertrans").removeClass("bx-check-double").addClass("bx-loader bx-spin");
        setTimeout(() => {
            filterTrasaction(transusername, transactionId, ordertypetrans,partneruid, startdatrans, enddatetrans, currentPage, pageLimit);
        }, 100);
    });

    async function filterTrasaction(transusername, transactionId, ordertypetrans,partneruid, startdatrans, enddatetrans, currentPage, pageLimit) {
        try {
            const response = await fetch(`../admin/filtertransactions/${transusername}/${transactionId}/${ordertypetrans}/${partneruid}/${startdatrans}/${enddatetrans}/${currentPage}/${pageLimit}`);
            const data = await response.json();
    
            $(".loadertrans").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
            if (data.transactions.length < 1) {
                let html = `
                <tr class="no-results">
                    <td colspan="9">
                        <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                    </td>
                </tr>`;
                $("#mask").LoadingOverlay("hide");
                $("#dataContainer").html(html);
                return;
            }
            $("#mask").LoadingOverlay("hide");
            render(data.transactions);

            // Render pagination"Page " + currentPage + " of " + data.totalPages + " pages"
            renderPagination(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => filterTrasaction(transusername, transactionId, ordertypetrans,partneruid, startdatrans, enddatetrans, newPage, pageLimit));
            document.getElementById("paging_info").innerHTML = `${translator["Page"]} ${currentPage} ${translator["Of"]} ${data.totalPages} ${translator["Pages"]}`;
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }

    $("#viewbetdatahide").hide();
    $("#transacttbl").hide();
    $("#transredenvelop").hide();
    $("#loadingIndicator").show();

    function processTransactionData(transactiondata) {
        let total_income = "";
        let deposit_withdrawal_types = "";

        // Determine total income and deposit/withdrawal type
        if (transactiondata.deposit.deposit_withdrawal_type == 1) {
            total_income = '<span style="color:;">+' + transactiondata.deposit.deposit_and_withdrawal_amount + "</span>";
            deposit_withdrawal_types = '<span style="color:;">Deposit</span>';
        } else if (transactiondata.deposit.deposit_withdrawal_type == 2) {
            total_income = '<span style="color:green;">-' + transactiondata.deposit.deposit_and_withdrawal_amount + "</span>";
            deposit_withdrawal_types = '<span class="tag">Withdrawal</span>';
        }

        // Return the processed data
        return {
            usernames: transactiondata.usernames || "N/A",
            vip: "vip", // Static value
            deposit_withdrawal_types,
            deposit_amount: formatMoney(transactiondata.deposit.deposit_and_withdrawal_amount),
            recharge_balance: formatMoney(transactiondata.deposit.recharge_balance_in_advance),
            deposit_time: transactiondata.deposit.date_created + " / " + transactiondata.deposit.deposit_and_withdrawal_time,
            // required_coding_amount: transactiondata.deposit.required_coding_amount || "N/A",
            remark: transactiondata.deposit.remark || "N/A",
        };
    }

    function populatedepositeTable(transactiondata) {
        $("#transacttbl").show();
        $("#transredenvelop").hide();
        $("#viewbetdatahide").hide();
        let tableBody = document.getElementById("transacttbl").getElementsByTagName("tbody")[0];

        // Clear any existing rows
        tableBody.innerHTML = "";

        // Process the data
        const processedData = processTransactionData(transactiondata);

        // Create a new row and populate it with the processed data
        let row = tableBody.insertRow();

        // Insert cells and fill them with processed data
        row.insertCell(0).textContent = processedData.usernames;
        row.insertCell(1).textContent = processedData.vip;
        row.insertCell(2).innerHTML = processedData.deposit_withdrawal_types;
        row.insertCell(3).textContent = processedData.deposit_amount;
        row.insertCell(4).textContent = processedData.recharge_balance;
        row.insertCell(5).textContent = processedData.deposit_time;
        // row.insertCell(6).textContent = processedData.required_coding_amount;
        row.insertCell(6).textContent = processedData.remark;
    }

    function processRedEnvelopeData(transactiondata) {
        let status = "";
        let creditAmount = 0;
        let debitAmount = 0;
        let states = "";

        // Determine the status of the red envelope
        if (transactiondata.redEnvelope.order_type == 1) {
            status = "Deposit";
        } else if (transactiondata.redEnvelope.order_type == 9) {
            status = "Sending Red Envelope";
        } else if (transactiondata.redEnvelope.order_type == 10) {
            status = "Red Envelope Received";
        }

        // Determine credit and debit amounts based on the transaction type
        // if (transactiondata.redEnvelope.transaction_type == 1) {
        //     creditAmount = '<span style="color:;">+' + transactiondata.redEnvelope.account_change + "</span>";
        // } else {
        //     debitAmount = '<span style="color:re;">' + transactiondata.redEnvelope.account_change + " </span>";
        // }

        // Determine the state of the transaction
        if (transactiondata.redEnvelope.status == 1) {
            states = "Completed";
        }

        // Return the processed data in a structured format
        return {
            usernames: transactiondata.usernames || "N/A",
            status,
            amount: transactiondata.redEnvelope.account_change,
            balance: transactiondata.redEnvelope.balance || "N/A",
            dateTime: transactiondata.redEnvelope.dateTime || "N/A",
            orderId: transactiondata.redEnvelope.order_id || "N/A",
            states,
        };
    }
    function populateRedEnvelopeTable(transactiondata) {
        $("#transredenvelop").show();
        $("#transacttbl").hide();
        $("#viewbetdatahide").hide();
        let tableBody = document.getElementById("transtbls").getElementsByTagName("tbody")[0];

        // Clear any existing rows
        tableBody.innerHTML = "";

        // Process the data using the previously defined function
        const processedData = processRedEnvelopeData(transactiondata);

        // Create a new row and populate it with the processed data
        let row = tableBody.insertRow();

        // Insert cells and fill them with processed data
        row.insertCell(0).textContent = processedData.usernames;
        row.insertCell(1).textContent = processedData.status;
        row.insertCell(2).innerHTML = processedData.amount;
        // row.insertCell(3).innerHTML = processedData.creditAmount;
        row.insertCell(3).textContent = processedData.balance;
        row.insertCell(4).textContent = processedData.dateTime;
        row.insertCell(5).textContent = processedData.orderId;
        row.insertCell(6).textContent = processedData.states;
    }

    async function fetchTrasactionBet(transactionId) {
        try {
            const response = await fetch(`../admin/getTransactionBet/${transactionId}`);
            const transactiondata = await response.json();
            if (transactiondata.deposit) {
                populatedepositeTable(transactiondata);
            } else if (transactiondata.redEnvelope) {
                populateRedEnvelopeTable(transactiondata);
            } else {
                $("#transredenvelop").hide();
                $("#transacttbl").hide();
                $("#viewbetdatahide").show();
                $("#row1").empty();
                $("#row2").empty();
                let html1 = FromTable(firstRow, transactiondata);
                let html2 = FromTable(secondRow, transactiondata);
                $("#row1").html(html1);
                $("#row2").html(html2);
            }
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }

    $(document).on("click", ".tinfo", function () {
        setTimeout(() => {
            $("#loadingIndicator").hide();
        }, 100);
        $("#signup-modal").modal("show");
        const transactionId = $(this).attr("value");
        //console.log(transactionId);

        $("#row1").empty();
        $("#row2").empty();
        fetchTrasactionBet(transactionId);
    });

    $(document).on("click", function () {
        $(".acc_transaction_username").hide();
    });

    $(".numrowstrans").change(function () {
        $("#mask").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3,
        });
        const numrow = $(this).val();
        fetchTrasaction(currentPage, numrow);
    });

    //search the for username
    let debounceTimeout = null;
    let isPastings = false;

    $(document).ready(function () {
        $(document).on("keyup", "#transuser", function () {
            const query = $(this).val().trim();

            // Only trigger if input is more than 2 characters
            if (query.length > 1 && !isPastings) {
                clearTimeout(debounceTimeout); // Clear any existing timeout
                debounceTimeout = setTimeout(fetchbetUser, 500, query); // Call fetchUsers with the query after 500ms delay
            } else {
                $(".useraccount").hide(); 
            }
        });

        $(document).on("paste", "#transuser", function () {
            isPastings = true; // Set the flag to true when paste happens
            $(".useraccount").hide();
            setTimeout(function () {
                isPastings = false; // Reset the flag after a short delay (allow paste to finish)
            }, 100); // Delay of 100ms is usually enough for paste operations to finish
        });

        // Handle dropdown item selection
        $(document).on("change", ".useraccount", function () {
            const selectedOption = $(this).find("option:selected");
            const selectedUserId = selectedOption.val();
            const selectedUsername = selectedOption.data("username");
            if (selectedUserId) {
                $("#transuser").val(selectedUsername);
                $(".userIdtrans").val(selectedUserId);
                $(".useraccount").hide();
            }
        });

        $(document).on("click", function (e) {
            const $dropdown = $("#userAccountDropdown");
            if (!$(e.target).closest("#transuser, #userAccountDropdown").length) {
                $dropdown.hide();
            }
        });
        // Handle manual input clearing
        $(document).on("input", "#transuser", function () {
            if (!$(this).val()) {
                $(".userIdtrans").val(""); // Reset user ID if input is cleared
            }
        });

        // Hide the dropdown when an option is selected
        //  $dropdown.on("click", ".optionlist", function () {
        //     const selectedValue = $(this).text();
        //     $input.val(selectedValue); // Optionally set the input value to the selected option
        //     $dropdown.hide();
        // });
    });
    // Function to fetch and display users
    function fetchbetUser(query) {
        let optionsHtml = "";

        $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
            try {
                response = typeof response === "string" ? JSON.parse(response) : response;

                response.forEach((user) => {
                    let displayusername;
                    let regusername;
                    // Display based on regtype
                    if (user.regtype === "email") {
                        displayusername = user.email;
                        regusername = user.email; // Show email
                    } else if (user.regtype === "username") {
                        displayusername = user.username;
                        regusername = user.username; // Show username
                    } else if (user.regtype === "contact") {
                        displayusername = user.contact;
                        regusername = user.contact; // Show contact
                    } else {
                        displayusername = "no data found...";
                        regusername = "no data found..."; // Show contact
                    }
                    optionsHtml += `<option class="optionlist" value="${user.uid}" data-username="${regusername}">${displayusername}</option>`;
                });

                $(".useraccount").html(optionsHtml).show();
            } catch (error) {
                console.error("Error parsing response: ", error);
                $(".useraccount").hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $(".useraccount").hide();
        });
    }

    $(".clearitem").on("dblclick", function () {
        $(this).val(""); // Clears the input field
    });

    $(".transuser").on("input paste", function () {
        const self = this;
        setTimeout(() => {
            // Trim leading spaces
            $(self).val($(self).val().replace(/^\s+/, ""));
        }, 0);
    });

    async function fetchPartnername() {
        try {
            const response = await fetch(`../admin/fetchPartnername/${partnerID}`); // Await the fetch call

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const data = await response.json(); // Parse JSON response
            //console.log(data)
           
            let html = `<option value="">Partner Name</option>`;
            data.forEach((partner) => {
                html += `<option value="${partner.partner_id}">${partner.name}</option>`;
            });
            $(".selectpartner").html(html);
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }
    fetchPartnername();

});
