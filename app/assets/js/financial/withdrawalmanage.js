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

    const langStrings = {
        Page: document.getElementById("tr_page").textContent,
        of: document.getElementById("tr_of").textContent,
        pages: document.getElementById("tr_pages").textContent
    };


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

    const withdrawdatas = (data) => {
        let html = "";
        const status = { 1: "Pending", 2: "Approved", 3: "Rejected" };
        const withdrawal_channel = { 3: "Momo", 5: "Crypto", 2: "Bank", 4: "Manual" }; // 3:momo 5:crypto 2:bank 4:manual

        data.forEach((item) => {
            let username = item.reg_type === "email" ? item.email : item.reg_type === "username" ? item.username : item.contact;
            let timezone = item.withdrawal_timezone.split(" ");
            timezone = timezone[0] + `<span style="margin-left: 1rem;">GMT${timezone[1]}</span>`;
            html += `
        <tr>
            <td>${item.withdrawal_id}</td>
            <td>${username}</td>
            <td>${formatMoney(item.withdrawal_amount)}</td>
            <td>${formatMoney(item.fee)}</td>
            <td>${formatMoney(item.actual_withdrawal_amount)}</td>
            <td>${item.withdrawal_application_time.replace(" ", "/")}</td>
            <td>${timezone}</td>
            <td>${status[item.withdrawal_state]}</td>
            <td>${item.approved_by}</td>
            <td>          
                   <div class="dropdown">
                        <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class='bx bx-dots-vertical-rounded'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                            <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 btnapprove" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#al-info-alert" data-uid="${item.withdrawalid}">
                                <i class="bx bx-check-double"></i>Approved
                            </a>
                            <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 viewuserinfo" href="javascript:void(0);"data-bs-toggle="modal" data-bs-target="er" data-uid="">
                                <i class="bx bx-message-square-x fs-5"></i>Reject
                            </a> 
                        </div>
                    </div>
             </td>
        </tr>
          `;
        });
        return html;
    };

    const renderwithdraws = (data) => {
        var html = withdrawdatas(data);
        $("#withdrawContainers").html(html);
    };

    let currentPage = 1;
    let pageLimit = 20;

    async function fetchwithdrawmanage(currentPage, pageLimit) {
        try {

            let response = await fetch(`../financial/fetchwithdrawmanage/${currentPage}/${pageLimit}`);
            data = await response.json();
           // console.log(data)
            //return
            $("#maskwithdraws").LoadingOverlay("hide");
            renderwithdraws(data.withdraws);
            renderwithdrawsPagination(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => fetchwithdrawmanage(newPage, pageLimit));
            document.getElementById("paging_infowithdraws").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }
    fetchwithdrawmanage(currentPage, pageLimit)

    function renderwithdrawsPagination(totalPages, currentPage, pageLimit, callback) {
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

        document.getElementById("paginationwithdraws").innerHTML = pagLink;

        // Add click event listeners
        document.querySelectorAll("#paginationwithdraws .page-link").forEach((link) => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                const newPage = +this.getAttribute("data-page");
                if (newPage > 0 && newPage <= totalPages) {
                    $("#maskwithdraws").LoadingOverlay("show", {
                        background: "rgb(90,106,133,0.1)",
                        size: 3,
                    });
                    callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
                }
            });
        });
    }


    $(".playerwithdraws").click(function (e) {
        let direction = $(this).attr("data-page");
        const tableWrapper = $(".table-wrapperwithdraws");
        const tableWrappers = $(".table-wrapperwithdraws")[0];
        const scrollAmount = 1000; // Adjust as needed
        const scrollOptions = { behavior: "smooth" };
        if (tableWrapper.length) {
            switch (direction) {
                case "widrl-leftlinkss":
                    tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
                    break;
                case "widrl-rightlinkss":
                    tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
                    break;
                default:
                    break;
            }
        }
        e.stopPropagation(); // Prevent event bubbling
    });

    $(".refreshwithdraws").click(function () {
        $(".widrl-queryholdertrans").val("");
        $("#maskwithdraws").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3,
        });
        fetchwithdrawmanage(currentPage, pageLimit);
    });

    $(document).on("click", ".widrl-searchs", function () {
        if ($("#withdrawalnames").val() == "" && $("#widrl-channelss").val() == "" && $("#widrl-states").val() == "" && $("#widrl-IDs").val() == ""
            && $(".wdrl-startdates").val() == "" && $(".wdrl-enddates").val() == "") {
            // $("#danger-finance").modal("show");
            showToast("Heads up!!", "Select one or more data fields to filter", "info")
            // showToast(headsUpText, selectFieldsText, "info");
            return;
        }
        const username = $("#withdrawalnames").val();
        const withrawchanels = $("#widrl-channelss").val();
        const withdrawstate = $("#widrl-states").val();
        const withdrawid = $("#widrl-ID").val();
        const startwithdraw = $(".wdrl-startdates").val();
        const endwithdraw = $(".wdrl-enddates").val();
        // console.log(username,withrawchanels,withdrawstate,withdrawid,startwithdraw,endwithdraw)
        //  return
        filterwithdraw(username, withrawchanels, withdrawstate, withdrawid, startwithdraw, endwithdraw, currentPage, pageLimit);
        $(".loaderwithdraw").removeClass("bx-check-double").addClass("bx-loader bx-spin");
    });

    async function filterwithdraw(username, withrawchanels, withdrawstate, withdrawid, startwithdraw, endwithdraw, currentPage, pageLimit) {
        $.post(`../financial/filterwithdraw/${username}/${withrawchanels}/${withdrawstate}/${withdrawid}/${startwithdraw}/${endwithdraw}/${currentPage}/${pageLimit}`, function (response) {
            try {
                const data = JSON.parse(response);
                //  console.log(data)
                //  return
                $(".loaderwithdraw").removeClass("bx-loader bx-spin").addClass("bx-check-double");
                if (data.withdrawx.length < 1) {
                    $("#withdrawContainers").html(`
                    <tr class="no-results">
                    <td colspan="9">
                        <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                    </td>
                    </tr>
               `);
                    return;
                }
                $("#maskwithdraw").LoadingOverlay("hide");
                renderwithdraws(data.withdrawx);
                renderwithdrawsPagination(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => filterwithdraw(username, withrawchanels, withdrawstate, startwithdraw, endwithdraw, newPage, pageLimit));
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
        $(document).on("keyup", "#withdrawalnames", function () {
            const query = $(this).val().trim();
            // Only trigger if input is more than 2 characters
            if (query.length > 1) {
                clearTimeout(debounceTimeout); // Clear any existing timeout
                debounceTimeout = setTimeout(fetchUserss, 500, query); // Call fetchUsers with the query after 500ms delay
            } else {
                $(".withdrawsDropdowns").hide(); // Hide dropdown if input is less than 3 characters
            }
        });

        // Handle dropdown item selection
        $(document).on("change", ".withdrawsDropdowns", function () {
            const selectedOption = $(this).find("option:selected");
            const selectedUserId = selectedOption.val();
            const selectedUsername = selectedOption.data("usernames");

            if (selectedUserId) {
                $("#withdrawalnames").val(selectedUsername);
                $(".userIdFields").val(selectedUserId);
                $(".withdrawsDropdowns").hide();
            }
        });

        $(document).on("click", function (e) {
            const $dropdownbet = $("#users-options-wrappers");
            if (!$(e.target).closest("#withdrawalnames, #users-options-wrappers").length) {
                $dropdownbet.hide();
            }
        });
        // Handle manual input clearing
        $(document).on("input", "#withdrawalnames", function () {
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
                $('.withdrawsDropdowns').html(optionsHtml).show();
            } catch (error) {
                console.error("Error parsing response: ", error);
                $('.withdrawsDropdowns').hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $('.withdrawsDropdowns').hide();
        });
    }


    //approved function
    $(document).on("click", ".tcloses", function () {
        $("#al-info-alert").modal("hide");
    });
    let withdrawalId;
    $(document).on("click", ".btnapprove", function () {
        withdrawalId = $(this).data("uid")
    });

    $(document).on("click", ".btncontinue", function () {
        const approvedby = $(".approved").val();

        $.post(`../financial/approvewithdraw/${withdrawalId}/${approvedby}`, function (response) {
            try {
                const data = JSON.parse(response);
                //  console.log(data)
                //return
                if (data === "success") {
                    showToast("Success", "Withdrawal approved successfully", "success");
                    fetchwithdrawmanage(currentPage, pageLimit); // Refresh the list
                } else {
                    showToast("Error", "Failed to approve withdrawal", "error");
                }
            } catch (error) {
                console.error("Error parsing response:", error);
                showToast("Error", "An error occurred while processing your request", "error");
            }
        }).fail(function () {
            showToast("Error", "Failed to connect to the server", "error");
        });
    });

});

