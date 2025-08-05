$(function () {
    const partnerID = $("#partner-holder").attr("data-partner-id");
    function tableScrollWithdraw() {
        const tableContainerFinanceWidrl = document.querySelector(".table-wrapperwithdraw");
        const headerRowFinanceWidrl = document.querySelector(".tbl-row-widrl");

        tableContainerFinanceWidrl.addEventListener("scroll", function () {
            if (tableContainerFinanceWidrl.scrollTop > 0) {
                headerRowFinanceWidrl.classList.add("sticky-table-head-widrl");
            } else {
                headerRowFinanceWidrl.classList.remove("sticky-table-head-widrl");
            }
        });
    }
    tableScrollWithdraw();

    function showToast(title, message, type) {
        $.toast({
            position: "bottom-right",
            title: title,
            message: message,
            type: type,
            duration: 3000, // auto-dismiss after 3s
        });
    }

    const translatorScript = document.querySelector(".translations"); // Get the script tag
    const translator = JSON.parse(translatorScript.textContent);



    const status = {
        1: document.getElementById('status_pending').innerText,
        2: document.getElementById('status_success').innerText,
        3: document.getElementById('status_failed').innerText
    };

    const withdrawal_channel = {
        3: document.getElementById('channel_momo').innerText,
        5: document.getElementById('channel_crypto').innerText,
        2: document.getElementById('channel_bank').innerText,
        4: document.getElementById('channel_manual').innerText
    };
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

    const withdrawdata = (data) => {
        let html = "";
        const status = { 1: translator["Pending"], 2: translator["Approved"], 3: translator["Rejected"] };
        const withdrawal_channel = { 3: translator["Momo"], 5: translator["Crypto"], 2: translator["Bank"], 4: translator["Manual"] }; // 3:momo 5:crypto 2:bank 4:manual 

        data.forEach((item) => {
            let username = item.reg_type === "email" ? item.email : item.reg_type === "username" ? item.username : item.contact;
            let timezone = item.withdrawal_timezone.split(" ");
            timezone = timezone[0] + `<span style="margin-left: 1rem;">GMT${timezone[1]}</span>`;
            html += `
        <tr>
            <td>${item.withdrawal_id}</td>
            <td>${username}</td>
            <td>VIP</td>
            <td>${item.bank_type}</td>
            <td>${withdrawal_channel[item.withdrawal_channel]}</td>
            <td>${item.card_holder}</td>
            <td>${item.bank_card_number}</td>
            <td>${formatMoney(item.withdrawal_amount)}</td>
            <td>${formatMoney(item.fee)}</td>
            <td>${formatMoney(item.actual_withdrawal_amount)}</td>
            <td>${item.withdrawal_application_time.replace(" ", "/")}</td>
            <td>${timezone}</td>
          <td>${status[item.withdrawal_state]}</td>
            <td>${item.approved_by}</td>
        </tr>
          `;
        });
        return html;
    };

    const renderwithdraw = (data) => {
        var html = withdrawdata(data);
        $("#withdrawContainer").html(html);
    };

    let currentPage = 1;
    let pageLimit = 20;

    async function fetchwithdraw(currentPage, pageLimit) {
        try {

            let response = await fetch(`../financial/fetchwithdraw/${currentPage}/${pageLimit}`);
            data = await response.json();
            $("#maskwithdraw").LoadingOverlay("hide");
            renderwithdraw(data.withdraw);
            renderwithdrawPagination(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => fetchwithdraw(newPage, pageLimit));
            document.getElementById("paging_infowithdraw").innerHTML = `${translator["Page"]} ${currentPage} ${translator["Of"]} ${data.totalPages} ${translator["Pages"]}`;
            // document.getElementById("paging_infowithdraw").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }
    fetchwithdraw(currentPage, pageLimit)

    function renderwithdrawPagination(totalPages, currentPage, pageLimit, callback) {
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

        document.getElementById("paginationwithdraw").innerHTML = pagLink;

        // Add click event listeners
        document.querySelectorAll("#paginationwithdraw .page-link").forEach((link) => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                const newPage = +this.getAttribute("data-page");
                if (newPage > 0 && newPage <= totalPages) {
                    $("#maskwithdraw").LoadingOverlay("show", {
                        background: "rgb(90,106,133,0.1)",
                        size: 3,
                    });
                    callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
                }
            });
        });
    }

    $(".playerwithdraw").click(function (e) {
        let direction = $(this).attr("data-page");
        const tableWrapper = $(".table-wrapperwithdraw");
        const tableWrappers = $(".table-wrapperwithdraw")[0];
        const scrollAmount = 1000; // Adjust as needed
        const scrollOptions = { behavior: "smooth" };
        if (tableWrapper.length) {
            switch (direction) {
                case "widrl-leftlinks":
                    tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
                    break;
                case "widrl-rightlinks":
                    tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
                    break;
                default:
                    break;
            }
        }
        e.stopPropagation(); // Prevent event bubbling
    });

    $(".refreshwithdrawa").click(function () {
        $(".widrl-queryholdertrans").val("");
        $("#maskwithdraw").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3,
        });
        fetchwithdraw(currentPage, pageLimit);
    });

    $(document).on("click", ".widrl-search", function () {
        if ($("#withdrawalname").val() == "" && $("#widrl-channels").val() == "" && $("#widrl-state").val() == "" && $("#widrl-ID").val() == ""
            && $(".wdrl-startdate").val() == "" && $(".wdrl-enddate").val() == "") {
            // $("#danger-finance").modal("show");
            showToast(translator["Heads up!!"], translator["Select one or more data fields to filter"], "info")
            // showToast(headsUpText, selectFieldsText, "info");
            return;
        }
        const username = $("#withdrawalname").val();
        const withrawchanels = $("#widrl-channels").val();
        const withdrawstate = $("#widrl-state").val();
        const withdrawid = $("#widrl-ID").val();
        const startwithdraw = $(".wdrl-startdate").val();
        const endwithdraw = $(".wdrl-enddate").val();
        //   console.log(username,withrawchanels,withdrawstate,withdrawid,startwithdraw,endwithdraw)
        //  return
        filterwithdraw(username, withrawchanels, withdrawstate, withdrawid, startwithdraw, endwithdraw, currentPage, pageLimit);
        $(".loaderwithdraw").removeClass("bx-check-double").addClass("bx-loader bx-spin");
    });

    async function filterwithdraw(username, withrawchanels, withdrawstate, withdrawid, startwithdraw, endwithdraw, currentPage, pageLimit) {
        $.post(`../financial/filterwithdraw/${username}/${withrawchanels}/${withdrawstate}/${withdrawid}/${startwithdraw}/${endwithdraw}/${currentPage}/${pageLimit}`, function (response) {
            try {
                const data = JSON.parse(response);
                //console.log(data)
                //  return
                $(".loaderwithdraw").removeClass("bx-loader bx-spin").addClass("bx-check-double");
                if (data.withdrawx.length < 1) {
                    $("#withdrawContainer").html(`
                <tr class="no-results">
                  <td colspan="9">
                    <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                  </td>
                </tr>
              `);
                    return;
                }
                $("#maskwithdraw").LoadingOverlay("hide");
                renderwithdraw(data.withdrawx);
                renderwithdrawPagination(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => filterwithdraw(username, withrawchanels, withdrawstate, startwithdraw, endwithdraw, newPage, pageLimit));
                document.getElementById("paging_infowithdraw").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            } finally {
                $(".loaderwithdraw").removeClass("bx-loader bx-spin").addClass("bx-check-double");
            }
        }).fail(function (error) {
            console.error("Error fetching data:", error);
            $(".loaderwithdraw").removeClass("bx-loader bx-spin").addClass("bx-check-double");
        });
    }

    let debounceTimeout = null;
    $(document).ready(function () {
        // Event listener for keyup on #myInput
        $(document).on("keyup", "#withdrawalname", function () {
            const query = $(this).val().trim();
            // Only trigger if input is more than 2 characters
            if (query.length > 1) {
                clearTimeout(debounceTimeout); // Clear any existing timeout
                debounceTimeout = setTimeout(fetchUserss, 500, query); // Call fetchUsers with the query after 500ms delay
            } else {
                $(".withdrawDropdowns").hide(); // Hide dropdown if input is less than 3 characters
            }
        });

        // Handle dropdown item selection
        $(document).on("change", ".withdrawDropdowns", function () {
            const selectedOption = $(this).find("option:selected");
            const selectedUserId = selectedOption.val();
            const selectedUsername = selectedOption.data("usernames");

            if (selectedUserId) {
                $("#withdrawalname").val(selectedUsername);
                $(".userIdFields").val(selectedUserId);
                $(".withdrawDropdowns").hide();
            }
        });

        $(document).on("click", function (e) {
            const $dropdownbet = $("#users-options-wrapper");
            if (!$(e.target).closest("#withdrawalname, #users-options-wrapper").length) {
                $dropdownbet.hide();
            }
        });
        // Handle manual input clearing
        $(document).on("input", "#withdrawalname", function () {
            if (!$(this).val()) {
                $(".userIdFields").val(""); // Reset user ID if input is cleared
            }
        });
    });

    // Function to fetch and display users
    function fetchUserss(query) {
        let optionsHtml = '';

        $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
            try {
                response = typeof response === 'string' ? JSON.parse(response) : response;
                response.forEach(user => {
                    let displayValue;
                    let regname;
                    // Display based on regtype
                    if (user.regtype === "email") {
                        displayValue = user.email;
                        regname = user.email;  // Show email
                    } else if (user.regtype === "username") {
                        displayValue = user.username;
                        regname = user.username;  // Show username
                    } else if (user.regtype === "contact") {
                        displayValue = user.contact;
                        regname = user.contact;  // Show contact
                    } else {
                        displayValue = 'no data found ...';
                    }
                    // Append the option to the optionsHtml string
                    optionsHtml += `<option class="optionlists" value="${user.uid}" data-usernames="${regname}">${displayValue}</option>`;
                });
                $('.withdrawDropdowns').html(optionsHtml).show();
            } catch (error) {
                console.error("Error parsing response: ", error);
                $('.withdrawDropdowns').hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $('.withdrawDropdowns').hide();
        });
    }

});

