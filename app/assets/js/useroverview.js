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
  
    const UserOverviewData = (data) => {
        let html = "";
  
     //   data.forEach((item) => {
    
            // let username = item.reg_type === "email" ? item.email : item.reg_type === "username" ? item.username : item.contact;
            html += `
                    <tr>
                        <td>${data.team_size}</td>
                        <td>${data.active_number}</td>
                        <td>${data.efective_number}</td>
                        <td>${data.new_users}</td>
                        <td>${data.recharge}</td>
                        <td>${data.withdrawals}</td>
                        <td>${data.winning}</td>
                        <td>${data.betting}</td>
                        <td>${data.rebate_activity}</td>
                        <td>${data.new_profit}</td>
                        <td>${data.team_balance}</td>
                    </tr>
                `;
      //  });
        return html;
    };
  
    const renderuseroverview = (data) => {
        var html = UserOverviewData(data);
        $("#useroverviewContainer").html(html);
    };
  
    let currentPage = 1;
    let pageLimit = 20;
  
    // async function fetchuseroverview() {
    //     try {
    //         const response = await fetch(`../admin/userviewdata`);
    //         const data = await response.json();
    //            console.log(response);
    //         //   return
    //         $("#maskoverview").LoadingOverlay("hide");
    //         renderuseroverview(data.overview);
    //         // renderuserlogPagination(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchuseroverview(newPage, pageLimit));
    //         // document.getElementById("paging_infologs").innerHTML = "Page " + page + " of " + data.totalPages + " pages";
    //     } catch (error) {
    //         console.error("Error fetching data:", error);
    //     }
    // }
  
    // fetchuseroverview(currentPage, pageLimit);
  
    async function fetchuseroverview(usernamelog, startdatelog, enddatelog) {
        try {
            const response = await fetch("https://winsstarts.com/chairman_test/api/v1/limvo/myteamgraph", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    uid: usernamelog,
                    from: startdatelog,
                    to: enddatelog
                })
            });
    
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
    
            const data = await response.json();
            console.log(data.stats);

         // return
  
            $(".loaderover").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
            if (data.stats.length < 1) {
                let html = `
              <tr class="no-results" >
              <td colspan="9">
                <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
              </td>
              </tr>`;
                $("#useroverviewContainer").html(html);
                return;
            }
            $("#maskoverview").LoadingOverlay("hide");
            renderuseroverview(data.stats);
           // renderuserlogs(data.userloggs);
  
            // Render pagination
            // renderuserlogPagination(data.totalPages, currentPage, pageLimit, (newPage, pageLimit) => filterUserlogs(usernamelog, startdatelog, enddatelog, newPage, pageLimit));
            // document.getElementById("paging_infologs").innerHTML = "Page " + currentPage + " of " + data.totalPages + " pages";
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }
  
    function renderuserlogPagination(totalPages, currentPage, pageLimit, callback) {
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
  
        document.getElementById("paginationlogs").innerHTML = pagLink;
  
        // Add click event listeners
        document.querySelectorAll("#paginationlogs .page-link").forEach((link) => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                const newPage = +this.getAttribute("data-page");
                if (newPage > 0 && newPage <= totalPages) {
                    $("#maskoverview").LoadingOverlay("show", {
                        background: "rgb(90,106,133,0.1)",
                        size: 3,
                    });
                    callback(newPage, pageLimit); // Call the provided callback with new page and pageLimit
                }
            });
        });
    }
  
    $(".playerlogs").click(function () {
        let direction = $(this).val();
        const tableWrapper = $(".table-wrapperlogs");
        const tableWrappers = document.querySelector(".table-wrapperlogs");
        const scrollAmount = 1000; // Adjust as needed
        const scrollOptions = {
            behavior: "smooth",
        };
        if (tableWrapper.length) {
            switch (direction) {
                case "leftlogs":
                    tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
                    break;
                case "rightlogs":
                    tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
                    break;
                case "startlogs":
                    // Scroll to the absolute start (leftmost position)
                    tableWrapper.animate({ scrollLeft: 0 }, "slow");
                    break;
                case "endlogs":
                    const maxScrollLeft = tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
                    tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
                    break;
                default:
                    break;
            }
        }
    });
  
    $(".refreshlogs").click(function () {
        $(".queryholderlogs").val("");
        $("#maskoverview").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3,
        });
        fetchUserlogs(currentPage, pageLimit);
    });
  
    $(".numrowslog").change(function () {
        $("#maskoverview").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3,
        });
        const numrow = $(this).val();
        fetchUserlogs(currentPage, numrow);
    });
  
    $(document).on("click", ".executeuseroverview", function () {
        if ($("#userloginputs").val() == "" && $(".startdateover").val() == "") {
            showToast("Heads up!!", "Select one or more data fields to filter", "info");
            return;
        }
        const usernamelog = $(".userover").val();
        const startdateover = $(".startdateover").val();
        const enddateover = $(".enddateover").val();
        console.log(usernamelog,startdateover,enddateover);
    //    return
         $(".loaderover").removeClass("bx-check-double").addClass("bx-loader bx-spin");
         fetchuseroverview(usernamelog, startdateover, enddateover, currentPage, pageLimit);
    
    });
  
    $(document).on("click", function () {
        $(".queryholderxxx").hide();
    });
  
    let debounceTimeoutlogs = null;
  
    $(document).ready(function () {
        // Event listener for keyup on #myInput
        $(document).on("keyup", "#userloginputs", function () {
            const query = $(this).val().trim();
  
            // Only trigger if input is more than 2 characters
            if (query.length > 1) {
                clearTimeout(debounceTimeoutlogs); // Clear any existing timeout
                debounceTimeoutlogs = setTimeout(fetchUserslogss, 500, query); // Call fetchUsers with the query after 500ms delay
            } else {
                $(".userlogdropdowns").hide(); // Hide dropdown if input is less than 3 characters
            }
        });
  
        // Handle dropdown item selection
        $(document).on("change", ".userlogdropdowns", function () {
            const selectedOption = $(this).find("option:selected");
            const selectedUserId = selectedOption.val();
            const selectedUsername = selectedOption.data("username");
            // console.log(selectedUserId);
  
            if (selectedUserId) {
                $("#userloginputs").val(selectedUsername);
                $(".userover").val(selectedUserId);
                $(".userlogdropdowns").hide();
            }
        });
  
        $(document).on("click", function (e) {
            const $dropdown = $("#userfinaceuserlogss");
            if (!$(e.target).closest("#userloginputs, #userfinaceuserlogss").length) {
                $dropdown.hide();
            }
        });
        // Handle manual input clearing
        $(document).on("input", "#userloginputs", function () {
            if (!$(this).val()) {
                $(".userover").val(""); // Reset user ID if input is cleared
            }
        });
    });
  
    // Function to fetch and display users
    function fetchUserslogss(query) {
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
                        regnames = "no data found..";
                    }
                    optionsHtml += `<option class="optionlist" value="${user.uid}" data-username="${regnames}">${displayValues}</option>`;
                });
  
                $(".userlogdropdowns").html(optionsHtml).show();
            } catch (error) {
                console.error("Error parsing response: ", error);
                $(".userlogdropdowns").hide();
            }
        }).fail(function () {
            console.error("Error fetching users.");
            $(".userlogdropdowns").hide();
        });
    }
  
    function tableScrollUserLogs() {
        const tableContainerUserLogs = document.querySelector(".table-wrapperuserlogs");
        const headerRowUserLogs = document.querySelector(".userlogheadrow");
  
        tableContainerUserLogs.addEventListener("scroll", function () {
            if (tableContainerUserLogs.scrollTop > 0) {
                headerRowUserLogs.classList.add("sticky-userloghead");
            } else {
                headerRowUserLogs.classList.remove("sticky-userloghead");
            }
        });
    }
    tableScrollUserLogs();
 
  });
  