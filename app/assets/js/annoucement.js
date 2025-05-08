
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
    function getTimeDifferenceFromNow(dateTime) {
    const now = new Date(); // Get the current date and time
    const difference = now - new Date(dateTime); // Calculate the difference in milliseconds
    const seconds = Math.floor(difference / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const months = Math.floor(days / 30); // Approximate months (30 days per month)
    const years = Math.floor(days / 365); // Approximate years (365 days per year)

    if (seconds < 5) {
        return "Just now";
    } else if (minutes < 1) {
        return `${seconds}s ago`;
    } else if (hours < 1) {
        return `${minutes}m ago`;
    } else if (hours < 24) {
        return `${hours}h ago`;
    } else if (days < 30) {
        return `${days}d ago`;
    } else if (months < 12) {
        return `${months}m ago`;
    } else {
        return `${years}y ago`;
    }
    }

    const AnnoucementData = (data) => {
    let html = "";

    data.forEach((item) => {
        let messagetype = item.ms_type == "general" ? "Announcement" : item.ms_type == "personal" ? "Notification" : item.ms_type == "new_users" ? "Notification" : "";
        var storedDate = item.created_at.trim();  // Clean up any leading/trailing spaces
       
        let timezone = item.timezone.split(" ");
        timezone = timezone[0] + `<span style="margin-left: 1rem;">GMT${timezone[1]}</span>`;
        getTimeDifferenceFromNow(storedDate)
        
        html += `
                <tr>
                    <td>${item.subject}</td>
                    <td style ="max-width: 300px;word-wrap: break-word;overflow-wrap: break-word; white-space: normal;">${item.message}</td>
                    <td>${item.created_at}</td>
                    <td>${timezone}</td>
                    <td>${getTimeDifferenceFromNow(storedDate)}</td>
                    <td>${messagetype}</td>
                    <td>${item.audience}</td> 
                    <td>${item.send_by}</td>     
                    <td>
                    
                <div class="dropdown">
                        <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class='bx bx-dots-vertical-rounded'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                        
                        <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1 editmsg" href="javascript:void(0);" datas ="${item.msg_id}"> 
                            <i class="bx bx-edit fs-5" ></i>Edit
                        </a>
                        
                            <a class="dropdown-item deletemessage cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);" datas="${item.msg_id}">
                            <i class="bx bx-trash fs-5"></i>Delete
                        </a>
                        </div>
                    </div>
                </td>           
                </tr>
            `;
    });
    return html;
    };

    const rendermessage = (data) => {
    var html = AnnoucementData(data);
    $("#messagecontainer").html(html);
    };

    let currentPage = 1;
    let pageLimit = 20;

    async function fetchmessage(page, pageLimit) {
    try {
        const response = await fetch(`../admin/fetchmessage/${page}/${pageLimit}`);
        const data = await response.json();
        // console.log(data);
        $("#maskfinances").LoadingOverlay("hide");
        rendermessage(data.messages);
        renderfinacePaginations(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchmessage(newPage, pageLimit));
        document.getElementById("paging_infofmessage").innerHTML = "Page " + page + " of " + data.totalPages + " pages";
    } catch (error) {
        console.error("Error fetching data:", error);
    }
    }
    fetchmessage(currentPage, pageLimit);

    function renderfinacePaginations(totalPages, currentPage, pageLimit, callback) {
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

    document.getElementById("paginationmessage").innerHTML = pagLink;
    // Add click event listeners
    document.querySelectorAll("#paginationmessage .page-link").forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const newPage = +this.getAttribute("data-page");
            if (newPage > 0 && newPage <= totalPages) {
                $("#maskfinance").LoadingOverlay("show", {
                    background: "rgb(90,106,133,0.1)",
                    size: 3,
                });
                callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
            }
        });
    });
    }

    $(".refreshmessage").click(function () {
    $(".queryholderlistt").val("");
    $("#maskfinances").LoadingOverlay("show", {
    background: "rgb(90,106,133,0.1)",
    size: 3,
    });
    fetchmessage(currentPage, pageLimit);
    });

    //search function
    async function filtermessage(username, messagestype, startfmessage, endmessage, currentPage, pageLimit) {
    $.post(`../admin/filtermessage/${username}/${messagestype}/${startfmessage}/${endmessage}/${currentPage}/${pageLimit}`, function (response) {
    try {
        const data = JSON.parse(response);
        console.log(data);
        //   return
        $(".loaderfinanccs").removeClass("bx-loader bx-spin").addClass("bx-check-double");
        if (data.message.length < 1) {
            $("#messagecontainer").html(`
        <tr class="no-results">
        <td colspan="9">
            <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
        </td>
        </tr>
    `);
            return;
        }
        $("#maskfinances").LoadingOverlay("hide");
        rendermessage(data.message);
        // Render pagination
        renderfinacePaginations(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => filtermessage(username, messagestype, startfmessage, endmessage, newPage, pageLimit));
        document.getElementById("paging_infofmessage").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
    } catch (error) {
        console.error("Error parsing JSON response:", error);
    } finally {
        $(".loaderfinanccs").removeClass("bx-loader bx-spin").addClass("bx-check-double");
    }
    }).fail(function (error) {
    console.error("Error fetching data:", error);
    $(".loaderfinanccs").removeClass("bx-loader bx-spin").addClass("bx-check-double");
    });
    }

    $(document).on("click", ".executemessage", function () {
    if ($("#financeDropdownnotify").val() == "" && $(".messagestype").val() == "" && $(".startfmessage").val() == "") {
    // $("#danger-finance").modal("show");
    showToast("Heads up!!", "Select one or more data fields to filter", "info");
    return;
    }
    const messagestype = $(".messagestype").val();
    const username = $("#financeDropdownnotify").val();
    const startfmessage = $(".startfmessage").val();
    const endmessage = $(".endmessage").val();

    filtermessage(username, messagestype, startfmessage, endmessage, currentPage, pageLimit);
    //   // Show loader
    $(".loaderfinanccs").removeClass("bx-check-double").addClass("bx-loader bx-spin");
    });

    $("#combinedates").parent().hide();
    $("#financeinputnot").parent().hide();
    $(".vipusers").parent().hide();

    $(".messagetype") .on("change", function () {
    if ($(this).val() === "personal") {
    $("#financeinputnot").parent().show();
    $("#combinedates").parent().hide();
    $(".vipusers").parent().hide();
    } else if ($(this).val() === "new_users") {
    $("#combinedates").parent().show();
    $("#financeinputnot").parent().hide();
    $(".vipusers").parent().hide();
    $(".userIdFieldss, #financeinputnot").val("");
    }else if ($(this).val() === "general"){
    $("#combinedates").parent().hide();
    $("#financeinputnot").parent().hide();
    $(".vipusers").parent().hide();
    }else if ($(this).val() === "vipusers") {
    $(".vipusers").parent().show();
    $("#combinedates").parent().hide();
    $("#financeinputnot").parent().hide();
    $(".userIdFieldss, #financeinputnot").val("");
    }
    })
    .trigger("change");

    //add annoucement
    $(document).on("click", ".sendmessagebtn", function () {
    const messagetype = $(".messagetype").val();
    const messagetitle = $("#note-has-title").val();
    const usernames = $(".userIdFieldss").val();
    const description = encodeURIComponent($("#description").val());
    const sendby = $(".sendby").val();
    const notistartdate = $(".notistartdate").val();
    const notienddates = $(".notienddates").val();
    // console.log(usernames + "" + messagetype +""+messagetitle +""+description+""+sendby + ""+combinedates)
    if (messagetitle === "" || description === "" || sendby === "") {
    showToast("Heads up!!", "All field are required", "info");
    return false;
    }

    $("#announcementemodal").modal("hide");
    $(".userIdFieldss, #note-has-title,#description,#financeinputnot").val("");
    $(".loaderfinancc").removeClass("bx-send").addClass("bx-loader-circle bx-spin loader");
    $.post(`../admin/createannoucement/${messagetype}/${messagetitle}/${usernames}/${description}/${notistartdate}/${notienddates}/${sendby}`, function (response) {
    if (response) {
        $(".loaderfinancc").removeClass("bx-loader-circle bx-spin loader").addClass("bx-send");
        showToast("Success", response, "success");
        fetchmessage(currentPage, pageLimit);
    } else {
        showToast("Heads up!!", "failed", "info");
    }
    });
    });

    //delete message
    $(document).on("click", ".deletemessage", function () {
        const messageid = $(this).attr("datas");
        $.post(`../admin/deleteannoucement/${messageid}`, function (response) {
        if (response) {
            showToast("Success", response, "success");
            fetchmessage(currentPage, pageLimit);
        } else {
            showToast("Heads up!!", "failed", "info");
        }
        });
    });

    //edit message
    $(document).on("click", ".editmsg", function () {
    $("#editmessage").modal("show");
    let msgid = $(this).attr("datas");
    $.post(`../admin/editannoucement/${msgid}`, function (response) {
    let data = JSON.parse(response)[0];
    $("#note-has-titles").val(data.subject);
    $("#descriptions").val(data.message);
    $("#updatemsgid").val(data.msg_id);
    });
    });

    $(document).on("click", ".updatemessagebtn", function () {
        const msgtitle = $("#note-has-titles").val();
        const msgcontent = encodeURIComponent($("#descriptions").val());
        const updatemsgid = $("#updatemsgid").val();
        $(".loaderfinanup").removeClass("bx-send").addClass("bx-loader-circle bx-spin loader");
        $("#editmessage").modal("hide");
        $.post(`../admin/updateannoucement/${msgtitle}/${msgcontent}/${updatemsgid}`, function (response) {
        $(".loaderfinanup").removeClass("bx-loader-circle bx-spin loader").addClass("bx-send");
        if (response) {
            showToast("Success", response, "success");
            fetchmessage(currentPage, pageLimit);
        } else {
            showToast("Heads up!!", response, "info");
        }
        });
    });

    //modal
    $(document).on("click", ".messagemodal", function () {
    $("#announcementemodal").modal("show");
    });

    let debounceTimeouts = null;
    $(document).ready(function () {
    // Event listener for keyup on #myInput
    $(document).on("keyup", "#financeDropdownnotify", function () {
    const query = $(this).val().trim();

    // Only trigger if input is more than 2 characters
    if (query.length > 1) {
        clearTimeout(debounceTimeouts); // Clear any existing timeout
        debounceTimeout = setTimeout(fetchUsers, 500, query); // Call fetchUsers with the query after 500ms delay
    } else {
        $(".annoucementDropdown").hide(); // Hide dropdown if input is less than 3 characters
    }
    });

    // Handle dropdown item selection
    $(document).on("change", ".annoucementDropdown", function () {
    const selectedOption = $(this).find("option:selected");
    const selectedUserId = selectedOption.val();
    const selectedUsername = selectedOption.data("username");

    if (selectedUserId) {
        $("#financeDropdownnotify").val(selectedUsername);
        $(".userIdfinance").val(selectedUserId);
        $(".annoucementDropdown").hide();
    }
    });

    $(document).on("click", function (e) {
    const $dropdownbet = $("#userfinaceDropdownnotify");
    if (!$(e.target).closest("#financeDropdownnotify, #userfinaceDropdownnotify").length) {
        $dropdownbet.hide();
    }
    });
    // Handle manual input clearing
    $(document).on("input", "#financeDropdownnotify", function () {
    if (!$(this).val()) {
        $(".userIdfinance").val(""); // Reset user ID if input is cleared
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
                displayValues = "no data found ...";
                regnames = "no data found ..."; // Show contact
            }
            optionsHtml += `<option class="optionlist" value="${user.uid}" data-username="${regnames}">${displayValues}</option>`;
        });

        $(".annoucementDropdown").html(optionsHtml).show();
    } catch (error) {
        console.error("Error parsing response: ", error);
        $(".annoucementDropdown").hide();
    }
    }).fail(function () {
    console.error("Error fetching users.");
    $(".annoucementDropdown").hide();
    });
    }

    $(".numrowsnotfy").change(function () {
    $("#maskfinances").LoadingOverlay("show", {
    background: "rgb(90,106,133,0.1)",
    size: 3,
    });
    const numrows = $(this).val();
    fetchmessage(currentPage, numrows);
    });

    let debounceTimeout = null;
    $(document).ready(function () {
    // Event listener for keyup on #myInput
    $(document).on("keyup", "#financeinputnot", function () {
    const query = $(this).val().trim();

    // Only trigger if input is more than 2 characters
    if (query.length > 1) {
        clearTimeout(debounceTimeout); // Clear any existing timeout
        debounceTimeout = setTimeout(fetchUserss, 500, query); // Call fetchUsers with the query after 500ms delay
    } else {
        $(".financeDropdownu").hide(); // Hide dropdown if input is less than 3 characters
    }
    });

    // Handle dropdown item selection
    $(document).on("change", ".financeDropdownu", function () {
    const selectedOption = $(this).find("option:selected");
    const selectedUserId = selectedOption.val();
    const selectedUsername = selectedOption.data("usernames");

    if (selectedUserId) {
        $("#financeinputnot").val(selectedUsername);
        $(".userIdFieldss").val(selectedUserId);
        $(".financeDropdownu").hide();
    }
    });

    // $(document).on("click", function (e) {
    //     const $dropdownbet = $("#userfinaceDropdownnotify");
    //     if (!$(e.target).closest("#financeinputnot, #userfinaceDropdownnotify").length) {
    //         $dropdownbet.hide();
    //     }
    // });
    // Handle manual input clearing
    $(document).on("input", "#financeinputnot", function () {
    if (!$(this).val()) {
        $(".userIdFieldss").val(""); // Reset user ID if input is cleared
    }
    });
    });

    // Function to fetch and display users
    function fetchUserss(query) {
    let optionsHtml = "";

    $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
    try {
        response = typeof response === "string" ? JSON.parse(response) : response;

        //     console.log(response);

        response.forEach((user) => {
            let displayValue;
            let regname;
            // Display based on regtype
            if (user.regtype === "email") {
                displayValue = user.email;
                regname = user.email; // Show email
            } else if (user.regtype === "username") {
                displayValue = user.username;
                regname = user.username; // Show username
            } else if (user.regtype === "contact") {
                displayValue = user.contact;
                regname = user.contact; // Show contact
            } else {
                displayValue = "no data found ...";
                regname = "no data found ..."; // Show contact
            }

            // Append the option to the optionsHtml string
            optionsHtml += `<option class="optionlist" value="${user.uid}" data-usernames="${regname}">${displayValue}</option>`;
        });
        $(".financeDropdownu").html(optionsHtml).show();
    } catch (error) {
        console.error("Error parsing response: ", error);
        $(".financeDropdownu").hide();
    }
    }).fail(function () {
    console.error("Error fetching users.");
    $(".financeDropdownu").hide();
    });
    }

    function tableScrollFinancess() {
    const tableContainerFinances = document.querySelector(".table-wrapperfinances");
    const headerRowFinances = document.querySelector(".financeheadrows");

    tableContainerFinances.addEventListener("scroll", function () {
    if (tableContainerFinances.scrollTop > 0) {
        headerRowFinances.classList.add("sticky-financeheads");
    } else {
        headerRowFinances.classList.remove("sticky-financeheads");
    }
    });
    }
    tableScrollFinancess();
});
