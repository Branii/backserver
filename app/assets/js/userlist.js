$(function () {
    const showToast = (title, message, type) => {
        $.toast({
            position: "bottom-right",
            title: title,
            message: message,
            type: type,
            duration: 3000, // auto-dismiss after 3s
        });
    };

    // editting the user from the userlist table
    $(document).on("click", ".manage-user-btn,.user-restrictions-btn", function () {
        let userID = $("#idHolder").val();
        // console.log(id)
        flag = "";
        const data = new URLSearchParams({ user_id: id }).toString();
        $.ajax({
            url: userListUrl,
            type: "POST",
            beforeSend: function () {},
            success: function (response) {
                console.log(response);
                res = JSON.parse(response);
                console.log(res);

                $("#usrl-username").val(res.username);
                $("#usrl-accounting-binding").val(res.agent_username);
                $("#usrl-withdrawal-limit").val(res.withdrawal_limit);
                $("#usrl-state").val(res.state);
                $("#usrl-rebate").val(res.rebate);
                $("#usrl-daily-betting-total-limit").val(res.betlimit);
                $("#usrl-account-type").val(res.recharge_level);
                $("#usrl-deposit-limit").val(res.recharge_level);
                $("#usrl-remarks").val(res.remark);
                $("#usrl-login-password").val(res.money_password);
                $("#usrl-withdrawal-password").val(res.money_password);
                $("#usrl-contact").val(res.user_contact);
                $("#usrl-whatsapp").val(res.user_contact);
                $("#usrl-security").val(res.security_answer);
                $("#usrl-email").val(res.user_email);
            },
            error: function (xhr, status, error) {},
            complete: function () {
                $(`#${userListTitle}-loader`).css({ display: "none" });
            },
        });
    });

    const fetchAgentSubs = (eventElement, currentPage) => {
        console.log(eventElement);
        const agentID = $(eventElement).attr("data-agent-id");
        let lotteryID = $("#wl-selectlottery").val();
        let startDate = $("#wl-startdate").val();
        let endDate = $("#wl-enddate").val();
        const element = this;
        const limit = 10;
        if (lotteryID != undefined) {
            if (lotteryID.length == 0) return;
        }

        lotteryID = lotteryID == undefined ? "all" : lotteryID;
        startDate = startDate.length != 0 ? startDate : "all";
        endDate = endDate.length != 0 ? endDate : "all";
        flag = "all-subs";
        console.log(agentID);
        $.ajax({
            url: `../admin/fetchAgentSubs/${agentID}/${lotteryID}/${startDate}/${endDate}/${flag}/${currentPage}/${limit}`,
            type: "POST",
            beforeSend: function () {
                $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
                //  $("#wl-tbl-wrapper").LoadingOverlay("show");
            },
            success: function (response) {
                $("#subs-back-btn").hide();
                response = JSON.parse(response);
                if (response.status === "error") {
                    $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13">Error: ${response.data}</td></tr>`);
                    return;
                }

                if (response.data.length == 0) {
                    historyStack.push($("#winLossDtholder").html());
                    pagesStack.push($("#wl-pagination-wrapper").html());
                    pagingInfo.push($("#paging_infowl").html());
                    $("#winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);
                    $("#wl-pagination-wrapper").html("");
                    $("#paging_infowl").html("---------");
                    return;
                }
                userObjs = response.data;
                // if(userObj.account_type > 1){
                //     if(!$(".get-user-details-btn").hasClass("btn-disabled")) $(".get-user-details-btn").addClass("btn-disabled");
                // }
                htmlMarkup = "";
                userObjs.forEach((userObj) => {
                    htmlMarkup += getUserRowMarkup(userObj);
                });
                historyStack.push($("#winLossDtholder").html());
                pagesStack.push($("#wl-pagination-wrapper").html());
                pagingInfo.push($("#paging_infowl").html());
                $("#winLossDtholder").html(htmlMarkup);
                const totalPages = Math.ceil(parseInt(userObjs[0].totalRecords) / 10);
                if (totalPages < 11) {
                    $("#wl-pagination-wrapper").html("");
                    $("#paging_infowl").html("---------");
                    return;
                }
                // renderwithdrawPagination(totalPages,parseInt(currentPage),'page-agent-subs');
            },
            error: function (xhr, status, error) {
                showToast("Error", "An Error occured, please try again later.", "info");
            },
            complete: function () {
                $("#wl-tbl-wrapper").LoadingOverlay("hide");
                // $($(element).find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx-check-double");
                // $("#wl-pagination").html("")
            },
        });
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
            //  console.log(item)
            let username = item.reg_type === "email" ? item.email : item.reg_type === "username" ? item.username : item.contact;

            let subordinate;
            if (item.account_type == 2) {
                subordinate = "Top Agent";
            } else if (item.account_type == 3 && item.sub_count == 0) {
                subordinate = "Sub Agent";
            } else if (item.account_type == 3 && item.sub_count == 1) {
                subordinate = username + " <i class='bx bx-right-arrow-alt'></i> " + item.subordinates;
            } else if (item.account_type == 3 && item.sub_count == 2) {
                subordinate = username + " <i class='bx bx-right-arrow-alt'></i> " + item.subordinates.split(",")[0];
            } else if (item.account_type == 3 && item.sub_count > 2) {
                subordinate = username + " <i class='bx bx-dots-horizontal-rounded' ></i>" + item.subordinates.split(",")[0];
            } else if (item.account_type == 1 && item.sub_count == 0) {
                subordinate = "---";
            }

            const formattedSubordinates = item.subordinates ? username + " <i class='bx bx-right-arrow-alt'></i> " + item.subordinates.split(",").join(" <i class='bx bx-right-arrow-alt'></i> ") : "None";
            //  let username = item.reg_type === "email" ? item.email : item.reg_type === "username" ? item.username : item.contact;
            let logincount = item.logincount == null ? "0" : item.logincount;
            const [date, time] = item.created_at.split(" ");
            let dates = "";
            let times = "";
            if (item.last_login && item.last_login !== "*****") {
                [dates, times] = item.last_login.split(" ");
            } else {
                dates = item.last_login || ""; // Use empty string if null/undefined
                times = item.last_login || "";
            }
            //  console.log(item.subordinates)

            html += `
                  <tr id="usrl-tr-${item.uid}">
                     <td>${username}</td>
                      <td>${item.nickname}</td>
                      <td>VIP</td>
                     <td>
                  <span class="tooltipp" style="">${subordinate}
                      <span class="tooltipp-text">${formattedSubordinates}</span>
                  </span>
                  </td>
                      <td>${item.sub_count} </td>
                      <td>${formatMoney(item.balance)}</td> 
                      <td>${item.rebate}</td>
                      <td>${date + " / " + time}</td>
                      <td>${dates + " / " + times}</td>
                      <td>${logincount}</td>
                      <td id="usrl-state-${item.uid}">${status[item.user_state]}</td>
                 
                        <td>
                          
                           <div class="dropdown">
                                  <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                   <i class='bx bx-dots-vertical-rounded'></i>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                    <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 viewuserinfo" href="javascript:void(0);"data-bs-toggle="modal" data-bs-target="#usrl-manage-user" data-uid="${
                                        item.uid
                                    }">
                                      <i class="bx bx-show fs-5"></i>View
                                    </a>
                                    <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 viewquota" href="javascript:void(0);" data-rebate="${item.quota}"data-uid="${item.uid}"> 
                                      <i class="bx bx-show fs-5" ></i>Quota
                                    </a>
                                     <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 viewsub" data-agent-id="${item.uid}" href="javascript:void(0);"data-uid="${item.subordinates}"> 
                                      <i class="bx bx-show fs-5" ></i>Subs
                                    </a>
                                    <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1 acountbtn" href="javascript:void(0);"data-uid="${item.uid}">
                                      <i class="bx bx-money fs-5"></i>Account Change
                                    </a>
                                     <a class="dropdown-item usr-deactivate-user cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"  data-uid="${item.uid}">
                                      <i class="bx bx-trash fs-5"></i>Deactivate User
                                    </a> <a class="dropdown-item user-lottery-name cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"  data-uid="${item.uid}">
                                      <i class="bx bx-trash fs-5"></i>Lottery Name
                                    </a>
                                     <a class="dropdown-item usr-white-list cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"  data-uid="${item.uid}">
                                      <i class="bx bx-trash fs-5"></i>White List
                                    </a>
                                     <a class="dropdown-item  usr-delete-user cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"  data-uid="${item.uid}">
                                      <i class="bx bx-trash fs-5"></i>Delete User
                                    </a>
                                  </div>
                                </div>
                      </td>
                     
                  </tr>
              `;
        });
        return html;
    };

    $(document).on("click", ".usrl-listclose", function () {
        const parent = $(this).parents(".modal").first();
        parent.removeClass("show");
        parent.css({ display: "none" });
    });

    $(document).on("click", ".usr-deactivate-user, .block-userbtn", function () {
        showDialog("usl-deactivate-user-dialog");
        if ($(this).hasClass("usr-deactivate-user")) {
            $("#idHolder").val($(this).attr("data-uid"));
        }
        if ($(this).hasClass("block-userbtn")) {
            manageUser("blockUser", this);
        }
    });
    $(document).on("click", ".usr-white-list", function () {
        showDialog("usl-whitelist-ips-modal");
        $("#idHolder").val($(this).attr("data-uid"));
        fetchUserLogs();
    });
    $(document).on("click", ".user-lottery-name", function () {
        showDialog("usl-lottery-name-modal");
        $("#idHolder").val($(this).attr("data-uid"));
        fetchLotteryTypes();
    });
    $(document).on("click", ".usr-delete-user,.usrl-delete-userbtn", function () {
        showDialog("usl-delete-user-dialog");
        if ($(this).hasClass("usr-delete-user")) {
            $("#idHolder").val($(this).attr("data-uid"));
        }
        if ($(this).hasClass("usrl-delete-userbtn")) {
            manageUser("deleteUser");
        }
    });

    const renderuserlist = (data) => {
        if (data.length === 0) {
            $("#userlistContainer").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);
            return;
        }
        var html = UserlistDataV2(data);
        $("#userlistContainer").html(html);
        //tippy('[data-tippy-content]');
    };

    let currentPage = 1;
    let pageLimit = 20;

    async function fetchUserlist(page, pageLimit) {
        try {
            const response = await fetch(`../admin/userlistdata/${page}/${pageLimit}`);
            const data = await response.json();
            //   console.log(response);
            //  return
            $("#maskuserlist").LoadingOverlay("hide");
            renderuserlist(data);
            // renderuserlist(data.users);
            const totalPages = Math.ceil(data.data[0].total_records / 20);
            renderPaginationlist(totalPages, page, pageLimit, (newPage, pageLimit) => fetchUserlist(newPage, pageLimit));
            document.getElementById("paging_infolist").innerHTML = "Page " + page + " of " + totalPages + " pages";
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }
    fetchUserlist(currentPage, pageLimit);

    function filterUserlist(username, states, startdate, enddate, currentPage, pageLimit) {
        $.post(`../admin/filteruserlist/${username}/${states}/${startdate}/${enddate}/${currentPage}/${pageLimit}`, function (response) {
            try {
                const data = JSON.parse(response);
                // console.log(data);
                //  return
                $(".loaderlist").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
                if (data.userlists.length < 1) {
                    $("#userlistContainer").html(`
              <tr class="no-results">
                <td colspan="9">
                  <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                </td>
              </tr>
            `);
                    return;
                }
                $("#maskuserlist").LoadingOverlay("hide");
                renderuserlist(data.userlists);
                // Render pagination
                renderPaginationlist(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => filterUserlist(username, states, startdate, enddate, newPage, pageLimit));
                document.getElementById("paging_infolist").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            } finally {
                $(".loaderfinances").removeClass("bx-loader bx-spin").addClass("bx-check-double");
            }
        }).fail(function (error) {
            console.error("Error fetching data:", error);
            $(".loaderfinances").removeClass("bx-loader bx-spin").addClass("bx-check-double");
        });
    }

    function renderPaginationlist(totalPages, currentPage, pageLimit, callback) {
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

        document.getElementById("paginationuserlist").innerHTML = pagLink;

        // Add click event listeners
        document.querySelectorAll("#paginationuserlist .page-link").forEach((link) => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                const newPage = +this.getAttribute("data-page");
                if (newPage > 0 && newPage <= totalPages) {
                    $("#maskuserlist").LoadingOverlay("show", {
                        background: "rgb(90,106,133,0.1)",
                        size: 3,
                    });
                    callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
                }
            });
        });
    }

    $(".playeruserlist").click(function () {
        let direction = $(this).val();
        const tableWrapper = $(".table-wrapperuserlist");
        const tableWrappers = document.querySelector(".table-wrapperuserlist");
        const scrollAmount = 1000; // Adjust as needed
        const scrollOptions = {
            behavior: "smooth",
        };
        if (tableWrapper.length) {
            switch (direction) {
                case "leftuserlists":
                    tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
                    break;
                case "rightuserlists":
                    tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
                    break;
                case "startlists":
                    // Scroll to the absolute start (leftmost position)
                    tableWrapper.animate({ scrollLeft: 0 }, "slow");
                    break;
                case "endlists":
                    const maxScrollLeft = tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
                    tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
                    break;
                default:
                    break;
            }
        }
    });

    $(".refreshlistuser").click(function () {
        $(".queryholderuserlistz").val("");
        $("#maskuserlist").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3,
        });
        fetchUserlist(currentPage, pageLimit);
    });

    let debounceTimeouts = null;

    $(document).ready(function () {
        // Event listener for keyup on #myInput
        $(document).on("keyup", "#selectuserlist", function () {
            const query = $(this).val().trim();

            // Only trigger if input is more than 2 characters
            if (query.length > 1) {
                clearTimeout(debounceTimeouts); // Clear any existing timeout
                debounceTimeout = setTimeout(fetchUsers, 500, query); // Call fetchUsers with the query after 500ms delay
            } else {
                $(".queryholderuserlist").hide(); // Hide dropdown if input is less than 3 characters
            }
        });

        // Handle dropdown item selection
        $(document).on("change", ".queryholderuserlist", function () {
            const selectedOption = $(this).find("option:selected");
            const selectedUserId = selectedOption.val();
            const selectedUsername = selectedOption.data("username");
            console.log(selectedUserId);

            if (selectedUserId) {
                $("#selectuserlist").val(selectedUsername);
                $(".userIds").val(selectedUserId);
                $(".queryholderuserlist").hide();
            }
        });

        $(document).on("click", function (e) {
            const $dropdown = $("#userlists");
            if (!$(e.target).closest("#selectuserlist, #userlists").length) {
                $dropdown.hide();
            }
        });
        // Handle manual input clearing
        $(document).on("input", "#selectuserlist", function () {
            if (!$(this).val()) {
                $(".userIds").val(""); // Reset user ID if input is cleared
            }
        });
    });

    // Function to fetch and display users
    function fetchUsers(query) {
        let optionsHtml = "";

        $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
            try {
                response = typeof response === "string" ? JSON.parse(response) : response;
                response.forEach((user) => {
                    let displayValues;
                    let regnames;
                    // Display based on regtype
                    if (user.regtype === "email") {
                        displayValues = user.email;
                        regnames = user.email; // Show email
                    } else if (user.regtype === "username") {
                        displayValues = user.username;
                        regnames = user.username; // Show username
                    } else if (user.regtype === "contact") {
                        displayValues = user.contact;
                        regnames = user.contact; // Show contact
                    } else {
                        displayValues = "no data found..";
                    }
                    optionsHtml += `<option class="optionlist" value="${user.uid}" data-username="${regnames}">${displayValues}</option>`;
                });

                $(".queryholderuserlist").html(optionsHtml).show();
            } catch (error) {
                console.error("Error parsing response: ", error);
                $(".queryholderuserlist").hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $(".queryholderuserlist").hide();
        });
    }

    $(document).on("click", ".executeuserlist", function () {
        if ($("#selectuserlist").val() == "" && $(".states").val() == "" && $(".startdateuser").val() == "") {
            showToast("Heads up!!", "Select one or more data fields to filter", "info");
            return;
        }
        const username = $("#selectuserlist").val();
        const states = $(".states").val();
        const startdate = $(".startdateuser").val();
        const enddate = $(".enddateuser").val();
        console.log(states);
        $(".loaderlist").removeClass("bx-check-double").addClass("bx-loader bx-spin");
        setTimeout(() => {
            filterUserlist(username, states, startdate, enddate, currentPage, pageLimit);
        }, 100);
    });

    $(".tclose").click(function () {
        $("#signup-modal").modal("hide");
    });

    $(document).on("click", ".addagent", function () {
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
            let html = "";

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
        const form = document.getElementById("agentform");
        const formData = new FormData(form);
        const datas = Object.fromEntries(formData.entries());
        // console.log(datas);
        addAgent(datas);
    });
    // `../admin/addAgent/${datas}
    async function addAgent(datas) {
        try {
            ///api/v1/limvo/selfregister
            const response = await fetch("https://localhost/chairman_test/api/v1/limvo/register_super_user", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(datas),
            });

            if (!response.ok) {
                throw new Error(`Error: ${response.type} - ${response.statusText}`);
            }
            // const data = await response.json();
            // console.log('Registration Success:', data);
            const result = await response.json();
            // console.log('Registration Success:', result);
            // Handle success or error based on response type
            if (result.type === "success") {
                $(".loaders").removeClass("bx-send").addClass("bx-loader-circle bx-spin loader");
                setTimeout(function () {
                    $(".loaders").removeClass("bx-loader-circle bx-spin loader").addClass("bx-send");
                    showToast("Success", result.message, "success");
                    //$("#addagent").modal("hide");
                }, 500);

                fetchUserlist(currentPage, pageLimit);
            } else if (result.type === "error") {
                showToast("Heads up!!", result.message, "info");
            }
            // const errorMessages = {
            //     emailexist: "Email already exists",
            //     usernamePattern: "Username must  Contain only letters\n, numbers, and underscores\n Start with a letter",
            //     username: "Username must contain only letters, numbers, and underscores and start with a letter",
            //     email: "Email address is invalid",
            //     passwordNumber: "Password must contain at least one number",
            //     passwordCaseSensitive: "Password must contain at least one uppercase and\n lowercase letter",
            //     passwordSpecialChar: "Password must contain at least one special symbol",
            //     confirmPassword: "Password does not match",
            //     passwordLength: "Password must be at least 8 characters",
            //     passwordRequired: "Password is required",
            // };
            // let message = null;
            // // Loop through error keys to find the first error
            // for (const [key, errorMessage] of Object.entries(errorMessages)) {
            //     if (data[key]) {
            //         message = errorMessage;
            //         break;
            //     }
            // }
            // if (message) {
            //     showToast("Heads up!!", message, "info");
            //     return;
            // } else {
            //     $(".loaders").removeClass("bx-send").addClass("bx-loader-circle bx-spin loader");
            //     setTimeout(function () {
            //         $(".loaders").removeClass("bx-loader-circle bx-spin loader").addClass("bx-send");
            //         $("#addagent").modal("hide");
            //         showToast("Success", "agent added sucessfully", "success");
            //         // fetchUserlist(currentPagelist);
            //     }, 500);
            //  }
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }

    async function fetchTopAgent(page) {
        try {
            const response = await fetch(`../admin/fetchTopAgent/${page}/${pageLimit}`);

            const data = await response.json();
            // console.log(response);
            renderuserlist(data.topagent);
            $("#masklist").LoadingOverlay("hide");
            renderPaginationlist(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchTopAgent(newPage, pageLimit));
            document.getElementById("paging_infolist").innerHTML = "Page " + page + " of " + data.totalPages + " pages";
            // return;
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }

    //get top agent
    $(".gettopagent").click(function () {
        fetchTopAgent(currentPage, pageLimit);
    });

    //quota
    $(document).on("click", ".viewquota", function () {
        $("#viewquota").modal("show");

        const uid = $(this).attr("data-uid").trim();
        $(".userquotaid").val(uid);
        // console.log(uid);

        $.post(`../admin/getuserrebate/${uid}/`, function (data) {
            const rebatelist = JSON.parse(data);
            let tableBody = document.getElementById("quotatable").getElementsByTagName("tbody")[0];
            while (tableBody.firstChild) {
                tableBody.removeChild(tableBody.firstChild);
            }

            rebatelist.forEach((item) => {
                let row = tableBody.insertRow();
                let rowData = [
                    `<span class="rebate_group"> ${item.rebate}</span>`,
                    `<span class="bonus_group">  ${item.odds_group}</span>`,
                    `<span class="count_group">${item.counts} </span> / ${item.quota}`,
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
        $.post(
            `../admin/updateUsedquota/${uid}/${rebate_group}/${bonus_group}/${quata_group}/${count_group}/`,

            function (result) {
                // console.log(result);
                setTimeout(function () {
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

    //fetch_sub
    let navigationHistory = [];
    $(document).on("click", ".viewsub", function () {
        const userID = $(this).attr("data-agent-id").trim();
        navigationHistory.push({
            nameArray: [],
            currentPage: currentPage,
            pageLimit: pageLimit,
        });
        // console.log("Navigation History:", navigationHistory);
        fetchsubagent(userID, currentPage, pageLimit, this);
    });

    const fetchsubagent = (userID, currentPage, pageLimit, element) => {
        $.ajax({
            url: `../admin/agent_subordinate/${userID}/${currentPage}/${pageLimit}`,
            type: "POST",
            beforeSend: function () {
                //    $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
                //  $("#ngp-wl-tbl-wrapper").LoadingOverlay("show");
            },
            success: function (response) {
                response = JSON.parse(response);
                const data = response.data;
                console.log(data);
                if (response.status === "error") {
                    showToast("Error", data, "error");
                    // $("#ngp-winLossDtholder").html(`<tr class="no-resultslist"><td colspan="13">Error: ${data}</td></tr>`);
                    return;
                }
                if (data.length === 0) {
                    $("#userlistContainer").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);
                    return;
                }

                $("#userlistContainer").html(UserlistDataV2(response));
                renderPaginationlist(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => fetchsubagent(nameArray, newPage, pageLimit));
                document.getElementById("paging_infolist").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";

                return;
            },
            error: function (xhr, status, err) {},
            complete: function () {},
        });
    };

    const UserlistDataV2 = (response) => {
        console.log(response);
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

        const data = response.data;
        const login_counts = response.login_counts.data;
        const subsLookups = response.direct_subs_count.data;

        // Create a lookup object where the key is uid and the value is logs_count
        const logsLookup = login_counts.reduce((lookup, item) => {
            lookup[item.uid] = item.logs_count;
            return lookup;
        }, {});
        // Create a lookup object where the key is uid and the value is logs_count
        const subsLookup = subsLookups.reduce((lookup, item) => {
            lookup[item.uid] = item.subs_count;
            return lookup;
        }, {});

        data.forEach((item) => {
            //  console.log(item)
            let username = item.reg_type === "email" ? item.email : item.reg_type === "username" ? item.username : item.contact;

            let subordinate = "";
            if (item.account_type == 2) {
                subordinate = "Top Agent";
            } else if (item.account_type == 3 && item.sub_count == 0) {
                subordinate = "Sub Agent";
            } else if (item.account_type == 3 && item.sub_count == 1) {
                subordinate = username + " <i class='bx bx-right-arrow-alt'></i> " + item.subordinates;
            } else if (item.account_type == 3 && item.sub_count == 2) {
                subordinate = username + " <i class='bx bx-right-arrow-alt'></i> " + item.subordinates.split(",")[0];
            } else if (item.account_type == 3 && item.sub_count > 2) {
                subordinate = username + " <i class='bx bx-dots-horizontal-rounded' ></i>" + item.subordinates.split(",")[0];
            } else if (item.account_type == 1 && item.sub_count == 0) {
                subordinate = "---";
            }

            const formattedSubordinates = item.subordinates ? username + " <i class='bx bx-right-arrow-alt'></i> " + item.subordinates.split(",").join(" <i class='bx bx-right-arrow-alt'></i> ") : "None";
            //  let username = item.reg_type === "email" ? item.email : item.reg_type === "username" ? item.username : item.contact;
            let logincount = item.logincount == null ? "0" : item.logincount;
            const [date, time] = item.created_at.split(" ");
            let dates = "";
            let times = "";
            if (item.last_login && item.last_login !== "*****") {
                [dates, times] = item.last_login.split(" ");
            } else {
                dates = item.last_login || ""; // Use empty string if null/undefined
                times = item.last_login || "";
            }

            //     <span class="tooltipp" style="">${subordinate}
            //     <span class="tooltipp-text">Surbodinate names</span>
            // </span>

            html += `
              <tr id="usrl-tr-${item.uid}">
                 <td>${username}</td>
                  <td>${item.nickname}</td>
                  <td>VIP</td>
                 <td class="show-user-rel ${item.agent_level === "*****" ? "no-agent" : ""}" data-user-id="${item.uid}">
               ${item.account_type == 1 ? "-------" : item.account_type == 2 ? "Top Agent" : subsLookups[item.uid] < 2 ? item.agent_name + "->" + username : item.agent_name + "->" + username + "..."}
              </td>
                  <td>${subsLookup[item.uid] ?? 0} </td>
                  <td>${formatMoney(item.balance)}</td> 
                  <td>${item.rebate}</td>
                  <td>${date + " / " + time}</td>
                  <td>${dates + " / " + times}</td>
                  <td>${logsLookup[item.uid] ?? 0}</td>
                  <td id="usrl-state-${item.uid}">${status[item.user_state]}</td>
             
                    <td>
                      
                       <div class="dropdown">
                              <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                               <i class='bx bx-dots-vertical-rounded'></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 viewuserinfo" href="javascript:void(0);"data-bs-toggle="modal" data-bs-target="#usrl-manage-user" data-uid="${
                                    item.uid
                                }">
                                  <i class="bx bx-show fs-5"></i>View
                                </a>
                                <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 viewquota" href="javascript:void(0);" data-rebate="${item.quota}"data-uid="${item.uid}"> 
                                  <i class="bx bx-show fs-5" ></i>Quota
                                </a>
                                 <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 viewsub" data-agent-id="${item.uid}" href="javascript:void(0);"data-uid="${item.subordinates}"> 
                                  <i class="bx bx-show fs-5" ></i>Subs
                                </a>
                                <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1 acountbtn" href="javascript:void(0);"data-uid="${item.uid}">
                                  <i class="bx bx-money fs-5"></i>Account Change
                                </a>
                                 <a class="dropdown-item usr-deactivate-user cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"  data-uid="${item.uid}">
                                  <i class="bx bx-trash fs-5"></i>Deactivate User
                                </a> <a class="dropdown-item user-lottery-name cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"  data-uid="${item.uid}">
                                  <i class="bx bx-trash fs-5"></i>Lottery Name
                                </a>
                                 <a class="dropdown-item usr-white-list cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"  data-uid="${item.uid}">
                                  <i class="bx bx-trash fs-5"></i>White List
                                </a>
                                 <a class="dropdown-item  usr-delete-user cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"  data-uid="${item.uid}">
                                  <i class="bx bx-trash fs-5"></i>Delete User
                                </a>
                              </div>
                            </div>
                  </td>
                 
              </tr>
          `;
        });
        return html;
    };

    // function fetchsubagent(userID,currentPage, pageLimit) {
    //     $.post(`../admin/agent_subordinate/${userID}/${currentPage}/${pageLimit}`,
    //         function (response) {
    //         try {
    //            const data = JSON.parse(response);

    //             //  return
    //               $("#maskuserlist").LoadingOverlay("hide");

    //               toggleBackButton();
    //         } catch (error) {
    //             console.error("Error parsing JSON response:", error);
    //         } finally {
    //            // $(".loaderfinances").removeClass("bx-loader bx-spin").addClass("bx-check-double");
    //         }
    //     }).fail(function (error) {
    //         console.error("Error fetching data:", error);
    //       //  $(".loaderfinances").removeClass("bx-loader bx-spin").addClass("bx-check-double");
    //     });

    // }

    function toggleBackButton() {
        if (navigationHistory.length > 1) {
            $("#backButton").show();
        } else {
            $("#backButton").show();
        }
    }

    $("#backButton").on("click", function () {
        if (navigationHistory.length > 1) {
            // Pop the last navigation state
            navigationHistory.pop();
            const previousState = navigationHistory[navigationHistory.length - 1];

            fetchsubagent(previousState.nameArray, previousState.currentPage, previousState.pageLimit, this);
        } else {
            navigationHistory = []; // Clear history
            currentPage = 1;
            fetchUserlist(currentPage, pageLimit);
        }

        // Hide back button if no navigation history
        toggleBackButton();
    });

    $(document).on("click", ".viewuserinfo", function () {
        $("#idHolder").val($(this).attr("data-uid"));
        fetchUserInfo();
    });

    function tableScrolluserList() {
        const tableContainerUser = document.querySelector(".table-wrapperuserlist");
        const headerRowUserList = document.querySelector(".headrowuserlist");

        tableContainerUser.addEventListener("scroll", function () {
            if (tableContainerUser.scrollTop > 0) {
                headerRowUserList.classList.add("sticky-headeruserlist");
            } else {
                headerRowUserList.classList.remove("sticky-headeruserlist");
            }
        });
    }
    tableScrolluserList();

    const manageUser = (flag, elemennt) => {
        const userID = $("#idHolder").val();
        const lotteryID = "all";
        $.ajax({
            url: `../admin/manageUser/${userID}/${lotteryID}/${flag}`,
            type: "POST",
            beforeSend: function () {
                //    $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
                //  $("#wl-tbl-wrapper").LoadingOverlay("show");
            },
            success: function (response) {
                $("#subs-back-btn").hide();
                response = JSON.parse(response);
                if (response.status === "error") {
                    showToast("Error", "", "info");
                    return;
                }

                if (response.data == 0 && flag == "blockUser") {
                    showToast("Blocked", "Please this User has already being blocked.", "info");
                    return;
                }
                if (response.data == 0 && flag == "deleteUser") {
                    showToast("Delete", "Operation Invalid", "error");
                    return;
                }

                let msg = "";
                switch (flag) {
                    case "blockUser":
                        msg = "User Successfully Blocked.";
                        $("#usrl-state-" + userID).text("Blocked");
                        break;
                    case "deleteUser":
                        msg = "User Successfully Deleted";
                        $("#usrl-tr-" + userID).remove();
                        break;
                    case "lottery-name":
                        msg = "Lottery status updated";
                        break;
                    case "ips":
                        msg = "Login Ip state updated";
                        break;
                    default:
                        msg = "";
                }
                if (msg.length == 0) {
                    showToast("Error", "Invalid operation.", "error");
                    return;
                }
                showToast("Completed", msg, "success");
            },
            error: function (xhr, status, error) {
                showToast("Error", "An Error occured, please try again later.", "info");
            },
            complete: function () {
                $("#wl-tbl-wrapper").LoadingOverlay("hide");
                // $($(element).find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx-check-double");
                // $("#wl-pagination").html("")
            },
        });
    };

    const fetchLotteryTypes = () => {
        const userID = $("#idHolder").val();
        const lotteryID = "all";
        let flag = "fetchUserLotteries";
        $.ajax({
            url: `../admin/manageUser/${userID}/${lotteryID}/${flag}`,
            type: "POST",
            beforeSend: function () {},
            success: function (response) {
                response = JSON.parse(response);
                console.log(response);
                let responseMarkup = "";

                if (response.status == "error") {
                    showToast("Error", response.data, "error");
                    return;
                }
                data = response.data;

                let blockedLotteries = data[0].blockedLotteries == undefined ? [] : Object.values(data[0].blockedLotteries);

                data.forEach((lottery) => {
                    responseMarkup += lotteriesMarkup(lottery, blockedLotteries);
                });
                // return;
                $("#usrl-lot-dtholder").html(responseMarkup);
            },
            error: function (res, status, error) {},
            complete: function () {
                console.log("Operation Completed Successfully.");
            },
        });
    };

    $(document).on("click", ".toggle-lot", function () {
        if ($(this).is(":checked")) {
            toggleLottery(this, true);
        } else {
            toggleLottery(this, false);
        }
    });
    $(document).on("click", ".toggle-ip-state", function () {
        if ($(this).is(":checked")) {
            blockUserIps(this);
        } else {
            blockUserIps(this);
        }
    });
    $(document).on("click", "#update-user-infobtn", function () {
        updateUserData();
    });

    const toggleLottery = (element, toggle) => {
        const userID = $("#idHolder").val();
        const lotteryID = $(element).val();
        let flag = "updateLotteryState";

        $.ajax({
            url: `../admin/manageUser/${userID}/${lotteryID}/${flag}`,
            type: "POST",
            beforeSend: function () {},
            success: function (response) {
                console.log(response);
                response = JSON.parse(response);
                if (response.status == "error") {
                    showToast("Error", response.data, "error");
                    return;
                }

                if (response.data == 0) {
                    showToast("Error", `Request Error`, "error");
                }

                if (toggle) {
                    showToast("Enabled", `Lottery Enabled`, "info");
                } else {
                    showToast("Disabled", `Lottery  Disabled.`, "error");
                }
            },
            error: function (res, status, error) {},
            complete: function () {},
        });
    };

    const updateUserData = () => {
        const userID = $("#idHolder").val();
        const flag = "updateUserInfo";
        const depositLimit = $("#usrl-deposit-limit").val();
        const withdrawalLimit = $("#usrl-withdrawal-limit").val();
        const rebate = $("#usrl-rebate").val();
        const state = $("#usrl-state").val();
        const dailyBettingLimit = $("#usrl-daily-betting-total-limit").val();

        $.ajax({
            url: `../admin/updateUserData/${userID}/${depositLimit}/${withdrawalLimit}/${rebate}/${state}/${dailyBettingLimit}/${flag}`,
            type: "POST",
            beforeSend: function () {},
            success: function (response) {
                console.log(response);
                res = JSON.parse(response);

                if (res.status == "error") {
                    showToast("Error", res.data, "error");
                    return;
                }

                if (res.data == 0) {
                    showToast("Error", "Error processing request", "error");
                    return;
                }
                $(".close-modal").click();
                showToast("Successful", "Records succesfully updated.", "info");
            },
            error: function (res, status, error) {},
            complete: function () {
                $("#overlay-loader").hide();
                console.log("Operation Completed Successfully.");
            },
        });
    };

    const fetchUserInfo = () => {
        const userID = $("#idHolder").val();
        const flag = "fetchUserInfo";
        const lotteryID = "all";

        $.ajax({
            url: `../admin/manageUser/${userID}/${lotteryID}/${flag}`,
            type: "POST",
            beforeSend: function () {},
            success: function (response) {
                console.log(response);
                res = JSON.parse(response);

                if (res.status == "error" || res.data.length === 0) {
                    showToast("Error", res.data, "error");
                    return;
                }

                res = res.data;

                $("#usrl-username").val(res.username);
                $("#usrl-accounting-binding").val(res.agent_username);
                $("#usrl-withdrawal-limit").val(res.withdrawal_level);
                $("#usrl-state").val(res.user_state);
                $("#usrl-rebate").val(res.rebate);
                $("#usrl-daily-betting-total-limit").val(res.daily_bet_llimit === "*****" ? 0 : res.daily_bet_llimit);
                $("#usrl-account-type").val(res.recharge_level);
                $("#usrl-deposit-limit").val(res.recharge_level);
                $("#usrl-remarks").val(res.remark);
                $("#usrl-login-password").val(res.money_password);
                $("#usrl-withdrawal-password").val(res.money_password);
                $("#usrl-contact").val(res.user_contact);
                $("#usrl-whatsapp").val(res.user_contact);
                $("#usrl-security").val(res.security_answer);
                $("#usrl-email").val(res.user_email);
            },
            error: function (res, status, error) {},
            complete: function () {
                $("#overlay-loader").hide();
                console.log("Operation Completed Successfully.");
            },
        });
    };

    const blockUserIps = (element) => {
        const userID = $("#idHolder").val();
        const ulogID = $(element).val();
        let flag = "blockUserIp";

        $.ajax({
            url: `../admin/manageUser/${userID}/${ulogID}/${flag}`,
            type: "POST",
            beforeSend: function () {},
            success: function (response) {
                console.log(response);
                response = JSON.parse(response);

                if (response.state == 0) return;
                if (response.status == "error") {
                    showToast("Error", response.data, "error");
                    return;
                }

                if (response.data == 0) {
                    showToast("Not Done", "Already blocked", "info");
                    return;
                }

                showToast("Completed", "IP state updated successfully.", "info");
            },
            error: function (res, status, error) {},
            complete: function () {
                $("#overlay-loader").hide();
                console.log("Operation Completed Successfully.");
            },
        });
    };

    const fetchUserLogs = () => {
        const userID = $("#idHolder").val();
        const flag = "fetchUserLogs";
        const lotteryID = "all";

        $.ajax({
            url: `../admin/manageUser/${userID}/${lotteryID}/${flag}`,
            type: "POST",
            beforeSend: function () {},
            success: function (response) {
                console.log(response);
                response = JSON.parse(response);
                console.log(response);
                if (response.status == "error") {
                    showToast("Error", response.data, "error");
                    $("#usrl-ipsholder").html(`<tr><td colspan="10">${response.data}</td></tr>`);
                    return;
                }

                if (response.data.length === 0) {
                    $("#usrl-ipsholder").html(`<tr><td colspan="10"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);
                    return;
                }

                let markup = "";
                response.data.forEach((data) => {
                    markup += userIpsMarkup(data);
                });

                $("#usrl-ipsholder").html(markup);
            },
            error: function (res, status, error) {},
            complete: function () {
                $("#overlay-loader").hide();
                console.log("Operation Completed Successfully.");
            },
        });
    };

    $(document).on("click", ".show-user-rel", function () {
        if ($(this).hasClass("no-agent")) {
            showToast("No Agent", "This user has no relationship.", "info");
            return;
        }
        showDialog("usrl-relationship-dialog");
        fetchUserRel($(this).attr("data-user-id"));
    });

    const fetchUserRel = (userID) => {
        $.ajax({
            url: `../admin/manageUser/${userID}/all/fetchUserRel`,
            type: "POST",
            beforeSend: function () {},
            success: function (response) {
                console.log(response);
                response = JSON.parse(response);

                if (response.status == "error") {
                    showToast("Error", response.data, "error");
                    $("#usrl-ipsholder").html(`<tr><td colspan="10">${response.data}</td></tr>`);
                    return;
                }

                if (response.data.length === 0) {
                    $("#usrl-ipsholder").html(`<tr><td colspan="10"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);
                    return;
                }

                let markup = "";
                const count = response.data.length;
                response.data.reverse().forEach((data, index) => {
                    markup += `<span>${data.username}</span> ${index == count - 1 ? "" : `<i class="bx bx-chevron-right" style="vertical-align: middle;margin: 0px 10px; font-size:24px;"></i><span>`}`;
                });

                $("#usrl-relholder").html(markup);
            },
            error: function (res, status, error) {},
            complete: function () {
                $("#overlay-loader").hide();
                console.log("Operation Completed Successfully.");
            },
        });
    };

    const translator = JSON.parse(document.getElementById("translation-container").getAttribute("data-translations"));
    const AccountTransactionss = (data) => {
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
            12: { title: translator["Bet Lost"], color: "#FFC107" }, // Amber
        };

        let completes = translator["Completed"];
        const formatTimestamp = (timestamp) => `${timestamp.slice(0, 10)} / ${timestamp.slice(10)}`;

        data.forEach((item) => {
            let username = item.reg_type === "email" ? item.email : item.reg_type === "username" ? item.username : item.contact;

            html += `
        <tr class="trow">
          <td>${"TR" + item.order_id.substring(0, 7)}</td>
          <td>${username.charAt(0).toUpperCase() + username.slice(1)}</td>
            <td><i class='bx bxs-circle' style='color:${statusColor[item.order_type].color};font-size:8px;margin-right:5px;'></i>${statusColor[item.order_type].title}</td>
            <td>${formatMoney(item.account_change) < 0 ? formatMoney(item.account_change) : `+ ${formatMoney(item.account_change)}`}</td>
            <td>${formatMoney(item.balance)}</td>
            <td>${formatTimestamp(item.dateTime)}</td>
            <td>${formatTimestamp(item.date_created)}</td>
            <td>${item.order_id}</td>
            <td><i class='bx bxs-circle' style='color:#1dd846;font-size:8px'></i> ${completes}</td>
            
        </tr>
    `;
        });
        return html;
    };

    const renders = (data) => {
        var html = AccountTransactionss(data);
        $("#accountchange").html(html);
    };

    async function fetchaccount(userid, currentPage, pageLimit) {
        try {
            const response = await fetch(`../admin/useraccountchange/${userid}/${currentPage}/${pageLimit}`);
            const data = await response.json();

            $("#maskaccount").LoadingOverlay("hide");
            if (data.account.length < 1) {
                $("#accountchange").html(`
                <tr class="no-results">
                    <td colspan="9">
                    <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="120px" />
                    </td>
                </tr>
            
                `);
                return;
            }

            renders(data.account);
            tableScrolluserLists();
            // Render pagination
            render(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => fetchaccount(userid, newPage, pageLimit));
            document.getElementById("paging_infolistss").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }

    let userIdacc;
    $(document).on("click", ".acountbtn", function (e) {
        let userid = $(this).attr("data-uid");
        userIdacc = userid;
        $("#viewaccount").modal("show");
        fetchaccount(userid, currentPage, pageLimit);
    });

    function tableScrolluserList() {
        const tableContainerUser = document.querySelector(".table-wrapperuserlist");
        const headerRowUserList = document.querySelector(".headrowuserlist");

        tableContainerUser.addEventListener("scroll", function () {
            if (tableContainerUser.scrollTop > 0) {
                headerRowUserList.classList.add("sticky-headeruserlist");
            } else {
                headerRowUserList.classList.remove("sticky-headeruserlist");
            }
        });
    }
    tableScrolluserList();

    function render(totalPages, currentPage, pageLimit, callback) {
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

        document.getElementById("paginationacc").innerHTML = pagLink;

        // Add click event listeners
        document.querySelectorAll("#paginationacc .page-link").forEach((link) => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                const newPage = +this.getAttribute("data-page");
                if (newPage > 0 && newPage <= totalPages) {
                    $("#maskaccount").LoadingOverlay("show", {
                        background: "rgb(90,106,133,0.1)",
                        size: 3,
                    });
                    callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
                }
            });
        });
    }

    $(".numrowschange").change(function () {
        $("#maskaccount").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3,
        });
        const numrows = $(this).val();
        fetchaccount(userIdacc, currentPage, numrows);
    });

    $(".refreshuseracc").click(function () {
        $(".refresdata").val("");
        $("#maskaccount").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3,
        });
        fetchaccount(userIdacc, currentPage, pageLimit);
    });

    async function filterAccountChange(userIdacc, ordertype, startdateusers, enddateusers, currentPage, pageLimit) {
        try {
            const response = await fetch(`../admin/filterChangeAccount/${userIdacc}/${ordertype}/${startdateusers}/${enddateusers}/${currentPage}/${pageLimit}`);
            const data = await response.json();

            ///console.log(response);

            $(".loaderuseracc").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
            if (data.filteraccount.length < 1) {
                $("#accountchange").html(`
             <tr class="no-results">
            <td colspan="9">
              <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="120px" />
            </td>
             </tr>
       
          `);
                return;
            }
            $("#maskaccount").LoadingOverlay("hide");
            renders(data.filteraccount);

            // Render pagination
            render(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => filterAccountChange(userIdacc, ordertype, startdateusers, enddateusers, newPage, pageLimit));
            document.getElementById("paging_infolistss").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }


    $(document).on("click", ".searchuseraccount", function () {
        if ( $(".orderuserchange").val() == "" && $(".startdateusers").val() == "" ) {
            showToast("Heads up!!", "Select one or more data fields to filter", "info");
            return;
        }
        const ordertype = $(".orderuserchange").val();
        const startdateusers = $(".startdateusers").val();
        const enddateusers = $(".enddateusers").val();
     //   console.log(ordertype);
     
        $(".loaderuseracc").removeClass("bx-check-double").addClass("bx-loader bx-spin");
            filterAccountChange(userIdacc,ordertype, startdateusers, enddateusers, currentPage, pageLimit);
     
    });

});

const lotteriesMarkup = (lottery, blockedLotteries) => {
    const lotteryID = lottery.lt_id;
    const status = blockedLotteries.includes(`${lotteryID}`) ? "Disabled" : "Active";
    const checkedState = status == "Active" ? "checked" : "";
    return `<tr>
                 <td><b class="lottery-name"> ${lottery.name}</b></td>
                 <td><span class="lottery-status">${status}</span></td>
                 <td><input class="form-check-input toggle-lot" type="checkbox" value="${lotteryID}" id="flexCheckDefault" ${checkedState}></td>
             </tr>`;
};
const userIpsMarkup = (data) => {
    const checkedState = data.ip_state === "allowed" ? "checked" : "";
    const ipState = data.ip_state === "allowed" ? "Allowed" : "Blocked";
    return `<tr>
                 <td><b class="">${data.ip} </b></td>
                 <td><span class="lottery-status">${data.login_date} / ${data.login_time}</span></td>
                 <td><span class="">${ipState}</span></td>
                 <td><input class="form-check-input toggle-ip-state" type="checkbox" value="${data.ulog_id}" id="flexCheckDefault" ${checkedState}></td>
                                </tr>`;
};
const showDialog = (btnID) => {
    const modalElement = $("#" + btnID);
    modalElement.hasClass("show") ? modalElement.css({ display: "none" }) : modalElement.css({ display: "block" });
    modalElement.toggleClass("show");
};
