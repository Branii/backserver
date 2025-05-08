$(() => {
    const partnerID = $('#partner-holder').attr("data-partner-id");
    const BASE_URL = "../admin";
    let historyStack = [];
    let pagesStack = [];
    let pagingInfo = [];
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
    const searchUserWinLoss = () => {
        const data = new URLSearchParams({ username: username, lottery: lottery_id, start_date: start_date, end_date: end_date }).toString();
        $.ajax({
            url: "../controller/datareport/winlossreport",
            type: "POST",
            data: { data: data, flag: flag },
            beforeSend: function () {
                $("#win-loss-loader").css("display", "flex");
            },
            success: function (response) {
                $("#subs-back-btn").hide();
                response = JSON.parse(response);

                const num_res = response.length;
                if (response.length == 0) {
                    historyStack = [];
                    $("#win-loss-dtholder").html("<tr><td colspan='12'  style='text-align:center;'>No results found.</td></tr>");
                    return;
                }
                if ($("#user-details-btn").is(":visible")) $("#user-details-btn").hide();
                if (num_res === 1) {
                    if (response[0].account_type > 1) $("#user-details-btn").show();
                }

                let htmlMarkup = "";
                response.forEach((data, index) => {
                    htmlMarkup += getUserRowMarkupNGP(data);
                });
                $("#win-loss-dtholder").html(htmlMarkup);
                // historyStack = [htmlMarkup];
                pagesStack = [];
            },
            error: function (xhr, status, error) {
                showToast("Error", "");
            },
            complete: function () {
                $("#win-loss-loader").css("display", "none");
            },
        });
    }; // search for user win loss

    const fetchLotteryNames = () => {
        try {
            $.ajax({
                url: `../admin/fetchLotteryname/${partnerID}`,
                type: "POST",
                success: function (data) {
                    data = JSON.parse(data);
                    let html1 = `<option value="all">${translator["Lottery Type"]}</option>`;
                    data.forEach((lottery) => {
                        html1 += `<option value="${lottery.gt_id}">${lottery.name}</option>`;
                    });

                    $("#ngp-wl-selectlottery").html(html1);
                },
                error: function (xhr, status, error) {},
            });
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    };
    fetchLotteryNames();

    //
    $(document).on("click", ".ngp-go-back", function () {
        if (historyStack.length === 0) {
            showToast("No Data", "No data to show", "info");
            return;
        }
        const content = historyStack.pop();
        const pageData = pagesStack.pop();
        const pageInfo = pagingInfo.pop();

        $("#ngp-winLossDtholder").html(content);
        $("#ngp-wl-pagination-wrapper").html(pageData);
        $("#ngp-paging_infowl").html(pageInfo);
    });

    // Handle dropdown item selection
    $(document).on("change", ".userDropdown", function () {
        const selectedOption = $(this).find("option:selected");
        const selectedUserId = selectedOption.val();
        const selectedUsername = selectedOption.data("username");

        if (selectedUserId) {
            $("#myInput").val(selectedUsername);
            $(".userIdbet").val(selectedUserId);
            $(".userDropdown").hide();
        }
    });

    let debounceTimeout = null;

    // filter user name
    $(document).on("keyup", "#ngp-wl-username", function () {
        const query = $(this).val().trim();
        if (query.length < 1) {
            $(".ngp-usr-res-wrapper").hide();
            return;
        }
        // Only trigger if input is more than 2 characters
        if (query.length > 1) {
            clearTimeout(debounceTimeout); // Clear any existing timeout
            debounceTimeout = setTimeout(fetchbetUser, 300, query); // Call fetchUsers with the query after 500ms delay
        } else {
            $(".ngp-userDropdown").hide(); // Hide dropdown if input is less than 3 characters
        }
    });
    // filter user name
    $(document).on("click", ".ngp-fetch-user-win-loss", function () {
        const userID = $("#ngp-wl-username").attr("data-user-id");

        let lotteryID = $("#ngp-wl-selectlottery").val();
        let startDate = $("#ngp-wl-startdate").val();
        let endDate = $("#ngp-wl-enddate").val();
        const element = this;
        if (lotteryID != undefined) {
            if (lotteryID.length == 0) return;
        }

        if (userID.length === 0) {
            showToast("No User selected", "Select atleast one User.", "info");
            return;
        }

        lotteryID = lotteryID == undefined ? "all" : lotteryID;
        startDate = startDate.length != 0 ? startDate : "all";
        endDate = endDate.length != 0 ? endDate : "all";

        $.ajax({
            url: `../admin/searchWinLossUser/${userID}/${lotteryID}/${startDate}/${endDate}/`,
            type: "POST",
            beforeSend: function () {
                $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
            },
            success: function (response) {
                $("#subs-back-btn").hide();
                response = JSON.parse(response);
                if (response.status === "error") {
                    $("#ngp-winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13">Error: ${response.data}</td></tr>`);
                    return;
                }

                if (response.data.length == 0) {
                    $("#ngp-winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);
                    return;
                }
                userObj = response.data;
                if (userObj.account_type > 1) {
                    if (!$(".get-user-details-btn").hasClass("btn-disabled")) $(".get-user-details-btn").addClass("btn-disabled");
                }
                htmlMarkup = getUserRowMarkupNGP(userObj);
                $("#ngp-winLossDtholder").html(htmlMarkup);
            },
            error: function (xhr, status, error) {
                showToast("Error", "An Error occured, please try again later.", "info");
            },
            complete: function () {
                $($(element).find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx-check-double");
                $("#ngp-wl-pagination-wrapper").html("");
            },
        });
    });

    // filter user name
    $(document).on("click", ".ngp-fetch-user-details", function () {
        const numTableRows = $("#ngp-winLossDtholder").find("tr.ngp-wl-results");

        if (numTableRows.length === 0) {
            showToast("No User Selected.", "Please select a user.", "info");
            return;
        }

        if (numTableRows.length > 1) {
            showToast("Too many users available.", "Please select a single user.", "info");
            return;
        }

        const userID = $("#ngp-winLossDtholder").find("tr:first-child").attr("id").split("-")[2];

        let lotteryID = $("#ngp-wl-selectlottery").val();
        let startDate = $("#ngp-wl-startdate").val();
        let endDate = $("#ngp-wl-enddate").val();
        const element = this;

        if (userID.length === 0) {
            showToast("No User selected", "Select atleast one User.", "info");
            return;
        }

        lotteryID = lotteryID == undefined ? "all" : lotteryID;
        startDate = startDate.length != 0 ? startDate : "all";
        endDate = endDate.length != 0 ? endDate : "all";

        $.ajax({
            url: `../admin/getUserDetails/${userID}/${lotteryID}/${startDate}/${endDate}/`,
            type: "POST",
            beforeSend: function () {
                $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
            },
            success: function (response) {
                $("#subs-back-btn").hide();
                response = JSON.parse(response);
                if (response.status === "error") {
                    $("#ngp-winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13">Error: ${response.data}</td></tr>`);
                    return;
                }

                if (response.data.length == 0) {
                    $("#ngp-winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);
                    $("#ngp-paging_infowl").html("----------");
                    return;
                }
                userObj = response.data;
                if (userObj.account_type > 1) {
                    if (!$(".get-user-details-btn").hasClass("btn-disabled")) $(".get-user-details-btn").addClass("btn-disabled");
                }
                htmlMarkup = getUserRowMarkupNGP(userObj);
                historyStack.push($("#ngp-winLossDtholder").html());
                pagesStack.push($("#ngp-wl-pagination-wrapper").html());
                pagingInfo.push($("#ngp-paging_infowl").html());
                $("#ngp-winLossDtholder").html(htmlMarkup);
            },
            error: function (xhr, status, error) {
                showToast("Error", "Request Error, please try again.", "Error");
            },
            complete: function () {
                $($(element).find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx-check-double");
                $("#ngp-wl-pagination-wrapper").html("");
            },
        });
    });

    $(document).on("keyup", "#ngp-wl-lottery", function () {
        const query = $(this).val().trim();
        if (query.length < 1) {
            $(".lot-res-wrapper").hide();
            return;
        }

        // Only trigger if input is more than 2 characters
        if (query.length > 1) {
            clearTimeout(debounceTimeout); // Clear any existing timeout
            debounceTimeout = setTimeout(fetchLotteryname, 300, query); // Call fetchUsers with the query after 500ms delay
        } else {
            $(".userDropdown").hide(); // Hide dropdown if input is less than 3 characters
        }
    });

    // Handle dropdown item selection
    $(document).on("click", ".ngp-name-items", function () {
        if ($(this).attr("data-username") != undefined) {
            $("#ngp-wl-username").val($(this).attr("data-username"));
            $("#ngp-wl-username").attr("data-user-id", $(this).attr("data-user-id"));
            $(".ngp-usr-res-wrapper").hide();
        } else if ($(this).attr("data-lot-name") != undefined) {
            $("#ngp-wl-lottery").val($(this).attr("data-lot-name"));
            $("#ngp-wl-lottery").attr("data-lot-id", $(this).attr("data-lot-id"));
            $(".ngp-lot-res-wrapper").hide();
        }
    });

    // Get Top Agents
    $(document).on("click", ".ngp-fetch-top-agents", function () {
        let page = 1;
        if ($(this).hasClass("page-link")) page = parseInt($(this).attr("data-page"));
        fetchTopAgents(1);
    });

    // Get Top Agents
    $(document).on("click", ".ngp-fetch-agent-subs", function () {
        fetchAgentSubs(this, 1);
    });

    // refresh list
    $(document).on("click", ".ngp-wl-refreshlist", function () {
        $("#ngp-wl-username").attr("data-user-id", "");
        $("#ngp-wl-username").val("");
        $("#ngp-wl-lottery").attr("data-lot-id", "");
        $("#ngp-wl-lottery").val("");
        $("#ngp-wl-startdate").val("");
        $("#ngp-wl-enddate").val("");
        $("#ngp-winLossDtholder").html(`<tr class="no-resultslist"> <td colspan="13" id="ngp-wl-empty-td"><img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Empty Results" /></td></tr>`);
        $("#ngp-wl-pagination-wrapper").html("");
        $("#ngp-paging_infowl").html("---------");
        historyStack, pagesStack, (pagingInfo = []);
        // fetchUsersWinLoss();
    });

    // Function to fetch and display users
    const fetchbetUser = (query) => {
        let optionsHtml = "";

        $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
            try {
                const getDisplayName = (user) => {
                    if (user.username !== "" && user.username != undefined && user.username !== "*****") return user.username;
                    if (user.email !== undefined && user.email != "") return user.email;
                    if (user.contact != undefined && user.contact != "") return user.contact;
                };
                response = typeof response === "string" ? JSON.parse(response) : response;
                for (let index = 0; index < response.length; index++) {
                    const user = response[index];
                    const username = user[user.regtype];
                    optionsHtml +=  username === undefined ?  `<li class="name-items ngp-name-items"> No Data Found.</li>`  :  `<li class="name-items ngp-name-items" data-user-id="${user.uid}" data-username="${username}">${username}</li>`;
                }
                $("#ngp-user-list-wrapper").html(optionsHtml);
                $(".ngp-usr-res-wrapper").show();
            } catch (error) {
                console.error("Error parsing response: ", error);
                $(".userDropdown").hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $(".userDropdown").hide();
        });
    };

    // Function to fetch and display users
    const fetchLotteryname = (lotteryName) => {
        let optionsHtml = "";

        $.post(`../admin/searchLotteryName/${encodeURIComponent(lotteryName)}`, function (response) {
            try {
                const getDisplayName = (user) => {
                    if (user.username !== "" && user.username != undefined && user.username !== "*****") return user.username;
                    if (user.email !== undefined && user.email != "") return user.email;
                    if (user.contact != undefined && user.contact != "") return user.contact;
                };
                response = typeof response === "string" ? JSON.parse(response) : response;

                for (let index = 0; index < response.length; index++) {
                    const lot = response[index];
                    optionsHtml += `<li class="name-items" data-lot-id="${lot.gt_id}" data-lot-name="${lot.name}">${lot.name}</li>`;
                }
                $("#lot-list-wrapper").html(optionsHtml);
                $(".lot-res-wrapper").show();
            } catch (error) {
                console.error("Error parsing response: ", error);
                $(".userDropdown").hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $(".userDropdown").hide();
        });
    };

    $(document).on("click", ".ngp-wl-pagination", function () {
        if ($(this).parent().hasClass("active")) return;
        const page = $(this).attr("data-page").trim();
        const lottery_id = $("#ngp-wl-lottery").attr("data-lot-id");
        const startDate = $("#ngp-wl-startdate").val().trim();
        const endDate = $("#ngp-wl-enddate").val().trim();
        // fetchUsersWinLoss(lottery_id,startDate,endDate,page);
    });

    $(".ngp-playerWinLoss").click(function (e) {
        let direction = $(this).val();
        const tableWrapper = $(".ngp-table-wrapperWl");
        const tableWrappers = $(".ngp-table-wrapperWl")[0];
        const scrollAmount = 1000; // Adjust as needed
        const scrollOptions = { behavior: "smooth" };
        if (tableWrapper.length) {
            switch (direction) {
                case "ngp-wl-leftlist":
                    tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
                    break;
                case "ngp-wl-rightlist":
                    tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
                    break;
                default:
                    break;
            }
        }
        // e.stopPropagation(); // Prevent event bubbling
    });

    const fetchTopAgents = (currentPage) => {
        let lotteryID = $("#ngp-wl-selectlottery").val();
        let startDate = $("#ngp-wl-startdate").val();
        let endDate = $("#ngp-wl-enddate").val();
        const element = this;
        const limit = 10;
        if (lotteryID != undefined) {
            if (lotteryID.length == 0) return;
        }

        lotteryID = lotteryID == undefined ? "all" : lotteryID;
        startDate = startDate.length != 0 ? startDate : "all";
        endDate = endDate.length != 0 ? endDate : "all";

        $.ajax({
            url: `../admin/fetchTopAgents/${lotteryID}/${startDate}/${endDate}/${currentPage}/${limit}`,
            type: "POST",
            beforeSend: function () {
                $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
            },
            success: function (response) {
                $("#subs-back-btn").hide();
                response = JSON.parse(response);
                if (response.status === "error") {
                    $("#ngp-winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13">Error: ${response.data}</td></tr>`);
                    return;
                }

                if (response.data.length == 0) {
                    historyStack.push($("#ngp-winLossDtholder").html());
                    pagesStack.push($("#ngp-wl-pagination-wrapper").html());
                    pagingInfo.push($("#ngp-paging_infowl").html());
                    $("#ngp-winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);
                    $("#ngp-wl-pagination-wrapper").html("");
                    $("#ngp-paging_infowl").html("---------");
                    return;
                }
                userObjs = response.data;
                const totalPages = Math.ceil(userObjs[0].total_records / 10);

                htmlMarkup = "";
                userObjs.forEach((userObj) => {
                    htmlMarkup += getUserRowMarkupNGP(userObj);
                });
                $("#ngp-winLossDtholder").html(htmlMarkup);
                if (totalPages < 2) {
                    $("#ngp-wl-pagination-wrapper").html("");
                    $("#ngp-paging_infowl").html("---------");
                    return;
                }
                renderPaginationNGP(totalPages, parseInt(currentPage), "ngp-page-top-agents");
            },
            error: function (xhr, status, error) {
                showToast("Error", "An Error occured, please try again later.", "info");
            },
            complete: function () {
                $($(element).find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx-check-double");
                $("#ngp-wl-pagination").html("");
            },
        });
    };

    const fetchAgentSubs = (eventElement, currentPage) => {
        const agentID = $(eventElement).attr("data-agent-id");
        let lotteryID = $("#ngp-wl-selectlottery").val();
        let startDate = $("#ngp-wl-startdate").val();
        let endDate = $("#ngp-wl-enddate").val();
        const element = this;
        const limit = 10;
        if (lotteryID != undefined) {
            if (lotteryID.length == 0) return;
        }

        lotteryID = lotteryID == undefined ? "all" : lotteryID;
        startDate = startDate.length != 0 ? startDate : "all";
        endDate = endDate.length != 0 ? endDate : "all";
        $.ajax({
            url: `../admin/fetchAgentSubs/${agentID}/${lotteryID}/${startDate}/${endDate}/${currentPage}/${limit}`,
            type: "POST",
            beforeSend: function () {
                $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
                //  $("#ngp-wl-tbl-wrapper").LoadingOverlay("show");
            },
            success: function (response) {
                $("#subs-back-btn").hide();
                response = JSON.parse(response);
                if (response.status === "error") {
                    $("#ngp-winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13">Error: ${response.data}</td></tr>`);
                    return;
                }

                if (response.data.length == 0) {
                    historyStack.push($("#ngp-winLossDtholder").html());
                    pagesStack.push($("#ngp-wl-pagination-wrapper").html());
                    pagingInfo.push($("#ngp-paging_infowl").html());
                    $("#ngp-winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);
                    $("#ngp-wl-pagination-wrapper").html("");
                    $("#ngp-paging_infowl").html("---------");
                    return;
                }
                userObjs = response.data;
                // if(userObj.account_type > 1){
                //     if(!$(".get-user-details-btn").hasClass("btn-disabled")) $(".get-user-details-btn").addClass("btn-disabled");
                // }
                htmlMarkup = "";
                userObjs.forEach((userObj) => {
                    htmlMarkup += getUserRowMarkupNGP(userObj);
                });
                historyStack.push($("#ngp-winLossDtholder").html());
                pagesStack.push($("#ngp-wl-pagination-wrapper").html());
                pagingInfo.push($("#ngp-paging_infowl").html());
                $("#ngp-winLossDtholder").html(htmlMarkup);
                const totalPages = Math.ceil(parseInt(userObjs[0].totalRecords) / 10);
                if (totalPages < 11) {
                    $("#ngp-wl-pagination-wrapper").html("");
                    $("#ngp-paging_infowl").html("---------");
                    return;
                }
                renderPaginationNGP(totalPages, parseInt(currentPage), "ngp-page-agent-subs");
            },
            error: function (xhr, status, error) {
                showToast("Error", "An Error occured, please try again later.", "info");
            },
            complete: function () {
                $("#ngp-wl-tbl-wrapper").LoadingOverlay("hide");
                // $($(element).find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx-check-double");
                // $("#ngp-wl-pagination").html("")
            },
        });
    };

    $(document).on("click", ".ngp-page-top-agents,.ngp-page-agent-subs", function () {
        const page = parseInt($(this).attr("data-page"));
        if (page < 1) return;
        if ($(this).hasClass("ngp-page-top-agents")) {
            fetchTopAgents(page);
        } else if ($(this).hasClass("ngp-page-agent-subs")) {
            fetchAgentSubs(this, page);
        }
    });
});

const renderPaginationNGP = (totalPages, currentPagewithdraw, type = "ngp-page-top-agents") => {
    let pagLink = `<ul class='pagination justify-content-end'>`;

    // Previous Button
    pagLink += `
      <li class='page-item ${currentPagewithdraw === 1 ? "disabled" : ""}'>
        <a class='page-link ${type}' href='#' data-page='${currentPagewithdraw - 1}'><i class='bx bx-chevron-left'></i></a>
      </li>
    `;

    // Page numbers with ellipsis
    for (let i = 1; i <= totalPages; i++) {
        if (i === currentPagewithdraw) {
            pagLink += `<li class='page-item active'><a class='page-link ${type}' href='#'>${i}</a></li>`;
        } else if (i === 1 || i === totalPages || Math.abs(i - currentPagewithdraw) <= 2) {
            pagLink += `<li class='page-item'><a class='page-link ${type}' href='#' data-page='${i}'>${i}</a></li>`;
        } else if (i === currentPagewithdraw - 3 || i === currentPagewithdraw + 3) {
            pagLink += `<li class='page-item disabled'><a class='page-link'>...</a></li>`;
        }
    }

    // Next Button
    pagLink += `
      <li class='page-item ${currentPagewithdraw === totalPages ? "disabled" : ""}'>
        <a class='page-link ${type}' href='#' data-page='${currentPagewithdraw + 1}'><i class='bx bx-chevron-right'></i></a>
      </li>
    `;

    pagLink += "</ul>";
    document.getElementById("ngp-wl-pagination-wrapper").innerHTML = pagLink;
    $("#ngp-paging_infowl").text(`Page ${currentPagewithdraw} of ${totalPages} ${totalPages === 1 ? " Page " : " Pages "} `);
    // Add click event listeners to pagination links
    // document.querySelectorAll("#paginationwithdraw .page-link").forEach((link) => {
    //   link.addEventListener("click", function (e) {
    //     e.preventDefault();
    //     const newPage = parseInt(this.getAttribute("data-page"));
    //     if (newPage > 0 && newPage <= totalPages && newPage !== currentPagewithdraw) {
    //       // Update currentPagewithdraw and display paging information
    //       currentPagewithdraw = newPage;
    //       // document.getElementById("paging_infowithdraw").innerHTML = `Page ${currentPagewithdraw} of ${totalPages} pages`;

    //       // Fetch and render new page data
    //       fetchwithdraw(currentPagewithdraw);
    //     }
    //   });
    // });
};

const getUserRowMarkupNGP = (userData) => {
    const subsBtn =
        parseInt(userData.account_type) === 2 || parseInt(userData.account_type) === 3
            ? `<div class="btn-group mb-2 ngp-fetch-agent-subs" role="group" aria-label="Basic example" data-agent-id="${userData.user_id}" style="border:solid 1px #eee;color:#bbb;background-color:#fff;margin: 0px !important;">
             <button type="button" class="btn bg-white-subtle ngp-playerWinLoss" value="ngp-wl-rightlist"> Subs </button></div>`
            : "";

    return `<tr id='user-id-${userData.user_id}' id='${userData.account_type > 1 ? "agent" : ""}' class='ngp-wl-results' data-acc-type='${userData.account_type > 1 ? "agent" : ""}'>
        <td> ${userData.username} </td>
        <td> ${userData.num_bettors} </td>
        <td> ${userData.num_bet_tickets} </td>
        <td> ${userData.rebate} </td>
        <td> ${userData.total_bet_amount} </td>
        <td> ${userData.total_rebate_amount} </td>
        <td> ${userData.total_valid_amount} </td>
        <td> ${userData.total_win_amount} </td>
        <td> ${userData.fees} </td>
        <td> ${userData.total_promotions_and_bonus} </td>
        <td> ${userData.total_refund_amount} </td>
        <td> ${userData.win_loss} </td>
        <td> ${subsBtn} </td>
            </tr>`;
};
