$(function () {
  function showToast(title, message, type) {
    $.toast({
      position: "bottom-right",
      title: title,
      message: message,
      type: type,
      duration: 3000 // auto-dismiss after 3s
    });
  }


  function getTranslation(id, fallback) {
    return document.getElementById(id)?.dataset.translation || fallback;
  }

  const viewprofile_text =
    document.getElementById("viewprofile-text")?.dataset.translation ||
    "View Profile";

  const activity_text = getTranslation("activity-text", "Activity Logs");
  const permission_text = getTranslation("permission-text", "Permissions");

  const AdminTable = (data) => {
    let html = "";
    const status = {
      1: { title: "Deposit", color: "#4CAF50" }, // Green
      2: { title: "Win Bonus", color: "#FF9800" }, // Orange
      3: { title: "Bet Awarded", color: "#03A9F4" }, // Light Blue
      4: { title: "Withdrawal", color: "#F44336" }, // Red
      5: { title: "Bet Cancelled", color: "#9E9E9E" }, // Grey
      6: { title: "Bet Deduct", color: "#E91E63" }, // Pink
      7: { title: "Rebates", color: "#8BC34A" }, // Light Green
      8: { title: "Self Rebate", color: "#00BCD4" }, // Cyan
      9: { title: "Send Red Envelope", color: "#FF5722" }, // Deep Orange
      10: { title: "Receive Red Envelope", color: "#795548" }, // Brown
      11: { title: "Bet Refund", color: "#FFC107" } // Amber
    };

    data.forEach((item) => {
      let nameParts = item.full_name?.split(" ") ?? [];
      let first = nameParts[0]?.[0] ?? "";
      let last = nameParts[1]?.[0] ?? "";
      const status = item.account_status?.toLowerCase() || "";
let badgeClass = "";
let translatedStatus = "";

switch (status) {
  case "active":
    badgeClass = "bg-success-subtle text-success";
    translatedStatus = document.getElementById("trans-status-active").textContent;
    break;
  case "suspended":
    badgeClass = "bg-warning-subtle text-warning";
    translatedStatus = document.getElementById("trans-status-suspended").textContent;
    break;
  case "deactivated":
    badgeClass = "bg-danger-subtle text-danger";
    translatedStatus = document.getElementById("trans-status-deactivated").textContent;
    break;
  default:
    badgeClass = "bg-secondary-subtle text-secondary";
    translatedStatus = status;
}

      html += `
                <tr class="trow">
                    <td> 
                       <div class="d-flex align-items-center">
                          <img src="http://localhost/admin/app/assets/images/profile/${
                            item.profile_picture
                          }" class=" rounded-circle" width="40" height="40" />    
                        </div>
                    </td>

                    <td>${item.username}</td>
                    <td>${item.full_name}</td>

                     <td>
                        <div class="d-flex align-items-center">
                          <a href="javascript:void(0)" class="ini text-white fs-6 round-40 rounded-circle me-n2 card-hover border border-2 border-white d-flex align-items-center justify-content-center">
                            ${first}
                          </a>
                          <a href="javascript:void(0)" class="ini text-white fs-6 round-40 rounded-circle me-n2 card-hover border border-2 border-white d-flex align-items-center justify-content-center">
                          ${last}
                          </a>
                        </div>
                      </td>

                    <td>${item.email}</td>
                    <td>${item.phone_number}</td>
                    <td>${item.two_factor_enabled}</td>
                    <td>
                    ${item.role}
                    </td>
                   
<td>
    <span class="badge fw-semibold py-1 w-85 ${badgeClass}">
      ${translatedStatus}
    </span>
  </td>
                    <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                             <i value='' class='bx bx-dots-vertical-rounded'' style='color:#868c87;font-size:18px;cursor:pointer;'></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li value='${JSON.stringify(
                              item
                            )}' class='admin_pro'>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view-profile">
                                <i class='bx bx-show-alt'></i>${viewprofile_text}
                              </a>
                            </li>
                            <li value='${JSON.stringify(
                              item
                            )}' class='admin_logs'>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#view-activity-logs">
                                <i class='bx bx-history' style='font-size:16px;'></i>${activity_text}
                              </a>
                            </li>
                             <li value='${JSON.stringify(
                               item
                             )}' class='admin_per'>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#view-permissions">
                                <i class='bx bx-edit-alt' style='font-size:16px;'></i>${permission_text}
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                </tr>
            `;
    });
    return html;
  };

  const AdminLogsTable = (data) => {
    let html = "";
    data.forEach((item) => {
      html += `
              <tr class="trow">
                  <td>${item.action_performed}</td>
                  <td>${item.created_date}</td>
                  <td>${item.created_time}</td>
                  <td>${item.ip_address}</td>
                  <td>${item.affected_entity}</td>
                  <td>${item.old_value}</td>
                  <td>${item.new_value}</td>
                  <td><span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">${item.action_status}</span></td>
              </tr>
       `;
    });
    return html;
  };

  let currentPage = 1;
  let pageLimit = 11;

  const renderAdmin = (data) => {
    var html = AdminTable(data);
    $("#dataContainerAdmin").html(html);
  };

  const renderAdminLogs = (data) => {
    var html = AdminLogsTable(data);
    $("#adminLogsContainer").html(html);
  };

  async function fetchAdmins(currentPage, pageLimit) {
    try {
      const response = await fetch(
        `../admin/alladmins/${currentPage}/${pageLimit}`
      );

      const data = await response.json();
      renderAdmin(data.admins);
      // Render pagination
      renderPaginationForAdmin(data.totalPages, currentPage);
      document.getElementById("paging_info_admin").innerHTML =
        "Page " + currentPage + " of " + data.totalPages + " pages";
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  const translations = {
    success: document.getElementById("trans-success").dataset.translation,
    newUser: document.getElementById("trans-new-user").dataset.translation,
    headsUp: document.getElementById("trans-heads-up").dataset.translation,
    mandatory: document.getElementById("trans-mandatory").dataset.translation
  };

  fetchAdmins(currentPage, pageLimit);

  const request = (url) => {
    $.post(url, function (result) {
      const data = JSON.parse(result);
      console.log(data);
      $(".add-new").modal("hide");
      renderAdmin(data.admins);
      // showToast("Success", "New user added successfuly", "success");
      showToast(translations.success, translations.newUser, "success");
    });
  };

  const data = $("#admins").serialize();
  const params = data.split("&").map((item) => item.split("=")[1]); // Extract param values
  let isEmpty = params.some((param) => param === "");

  // const updatePermissions = (url) => {
  //   $.post(url, function (result) {
  //     const data = JSON.parse(result);
  //     console.log(data);
  //     graph = {};
  //     showToast("Success", data, "success");
  //   });
  // };


  // const updatePermissions = (url) => {
  //   $.post(url, function (result) {
  //     const data = JSON.parse(result);
  //     console.log(data);
  //     graph = {};

  //     if (data.status === "success") {
  //       showToast("Success", data.message, "success");
  //       $("#view-permissions").modal("hide");

  //       // 🔄 Update the admin_per button's value to reflect new permissions
  //       const updatedPermissions = JSON.stringify(graph);

  //       $(`.admin_per[value*='"admin_id":${userId}']`).each(function () {
  //         let current = JSON.parse($(this).val());
  //         current.permissions = updatedPermissions;
  //         $(this).val(JSON.stringify(current));
  //       });
  //     } else {
  //       showToast("Error", data.message, "error");
  //     }
  //   });
  // };


  function getMsg(id, fallback) {
  const el = document.getElementById(id);
  return el?.dataset.msg || fallback;
}

const updatePermissions = (url) => {
  $.post(url, function (result) {
    const data = JSON.parse(result);
    console.log(data);
    graph = {};

    if (data.status === "success") {
      showToast(
        getMsg("msg-title-success", "Success"),
        getMsg("msg-success", data.message),
        "success"
      );
      $("#view-permissions").modal("hide");

      const updatedPermissions = JSON.stringify(graph);
      $(`.admin_per[value*='"admin_id":${userId}']`).each(function () {
        let current = JSON.parse($(this).val());
        current.permissions = updatedPermissions;
        $(this).val(JSON.stringify(current));
      });
    } else {
      showToast(
        getMsg("msg-title-error", "Error"),
        getMsg("msg-error", data.message),
        "error"
      );
    }
  });
};

  async function getAdminLogs(currentPage, pageLimit, adminId) {
    try {
      const response = await fetch(
        `../admin/adminlogs/${currentPage}/${pageLimit}/${adminId}`
      );
      const data = await response.json();
      console.log(data.adminLogs);
      renderAdminLogs(data.adminLogs);
      renderPaginationForAdminLogs(data.totalPages, currentPage, adminId);
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  async function filterAdminLogs(
    currentPage,
    pageLimit,
    adminId,
    datefrom,
    dateto
  ) {
    try {
      const response = await fetch(
        `../admin/filterAdminLogs/${currentPage}/${pageLimit}/${adminId}/${datefrom}/${dateto}`
      );
      const data = await response.json();
      console.log(data.adminLogs);
      renderAdminLogs(data.adminLogs);
      renderPaginationForAdminLogsPaging(
        data.totalPages,
        currentPage,
        adminId,
        datefrom,
        dateto
      );
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  async function searchlogs(currentPage, pageLimit, adminId, query) {
    try {
      const response = await fetch(
        `../admin/searchlogs/${currentPage}/${pageLimit}/${adminId}/${query}`
      );
      const data = await response.json();
      console.log(data.adminLogs);
      renderAdminLogs(data.adminLogs);
      renderPaginationForAdminLogsSearch(
        data.totalPages,
        currentPage,
        adminId,
        query
      );
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  $(".fullsubmit").on("click", function (evt) {
    evt.preventDefault();
    let params = [
      $(".fullname").val(),
      $(".fullemail").val(),
      $(".fullcontact").val(),
      $(".fullrole").val()
    ];
    const data = $("#admins").serialize();
    let isEmpty = params.some((param) => param === "");
    //console.log(params)
    !isEmpty
      ? request(`../admin/admins/${data}`)
      : showToast(translations.headsUp, translations.mandatory, "info");
  });

  function renderPaginationForAdmin(totalPages, currentPage) {
    const createPageLink = (i, label = i, disabled = false, active = false) =>
      `<li class='page-item ${disabled ? "disabled" : ""} ${
        active ? "active" : ""
      }'>
            <a class='page-link' href='#' data-page='${i}'>${label}</a>
          </li>`;
    let pagLink = `<ul class='pagination justify-content-end'>`;

    // Previous Button
    pagLink += createPageLink(
      currentPage - 1,
      `<i class='bx bx-chevron-left'></i>`,
      currentPage === 1
    );

    // Page numbers with ellipsis
    for (let i = 1; i <= totalPages; i++) {
      if (i === 1 || i === totalPages || Math.abs(i - currentPage) <= 2) {
        pagLink += createPageLink(i, i, false, i === currentPage);
      } else if (i === currentPage - 3 || i === currentPage + 3) {
        pagLink += createPageLink(i, "...", true);
      }
    }

    // Next Button
    pagLink += createPageLink(
      currentPage + 1,
      `<i class='bx bx-chevron-right'></i>`,
      currentPage === totalPages
    );
    pagLink += "</ul>";

    document.getElementById("paginationAdmin").innerHTML = pagLink;

    // Add click event listeners
    document.querySelectorAll("#paginationAdmin .page-link").forEach((link) => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        const newPage = +this.getAttribute("data-page");
        if (newPage > 0 && newPage <= totalPages) {
          fetchAdmins(newPage, pageLimit);
        }
      });
    });
  }

  function renderPaginationForAdminLogs(totalPages, currentPage, adminId) {
    const createPageLink = (i, label = i, disabled = false, active = false) =>
      `<li class='page-item ${disabled ? "disabled" : ""} ${
        active ? "active" : ""
      }'>
            <a class='page-link' href='#' data-page='${i}'>${label}</a>
          </li>`;
    let pagLink = `<ul class='pagination justify-content-end'>`;

    // Previous Button
    pagLink += createPageLink(
      currentPage - 1,
      `<i class='bx bx-chevron-left'></i>`,
      currentPage === 1
    );

    // Page numbers with ellipsis
    for (let i = 1; i <= totalPages; i++) {
      if (i === 1 || i === totalPages || Math.abs(i - currentPage) <= 2) {
        pagLink += createPageLink(i, i, false, i === currentPage);
      } else if (i === currentPage - 3 || i === currentPage + 3) {
        pagLink += createPageLink(i, "...", true);
      }
    }

    // Next Button
    pagLink += createPageLink(
      currentPage + 1,
      `<i class='bx bx-chevron-right'></i>`,
      currentPage === totalPages
    );
    pagLink += "</ul>";

    document.getElementById("paginationAdminLogs").innerHTML = pagLink;

    // Add click event listeners
    document
      .querySelectorAll("#paginationAdminLogs .page-link")
      .forEach((link) => {
        link.addEventListener("click", function (e) {
          e.preventDefault();
          const newPage = +this.getAttribute("data-page");
          if (newPage > 0 && newPage <= totalPages) {
            getAdminLogs(newPage, pageLimit, adminId);
          }
        });
      });
  }

  function renderPaginationForAdminLogsPaging(
    totalPages,
    currentPage,
    adminId,
    datefrom,
    dateto
  ) {
    const createPageLink = (i, label = i, disabled = false, active = false) =>
      `<li class='page-item ${disabled ? "disabled" : ""} ${
        active ? "active" : ""
      }'>
            <a class='page-link' href='#' data-page='${i}'>${label}</a>
          </li>`;
    let pagLink = `<ul class='pagination justify-content-end'>`;

    // Previous Button
    pagLink += createPageLink(
      currentPage - 1,
      `<i class='bx bx-chevron-left'></i>`,
      currentPage === 1
    );

    // Page numbers with ellipsis
    for (let i = 1; i <= totalPages; i++) {
      if (i === 1 || i === totalPages || Math.abs(i - currentPage) <= 2) {
        pagLink += createPageLink(i, i, false, i === currentPage);
      } else if (i === currentPage - 3 || i === currentPage + 3) {
        pagLink += createPageLink(i, "...", true);
      }
    }

    // Next Button
    pagLink += createPageLink(
      currentPage + 1,
      `<i class='bx bx-chevron-right'></i>`,
      currentPage === totalPages
    );
    pagLink += "</ul>";

    document.getElementById("paginationAdminLogs").innerHTML = pagLink;

    // Add click event listeners
    document
      .querySelectorAll("#paginationAdminLogs .page-link")
      .forEach((link) => {
        link.addEventListener("click", function (e) {
          e.preventDefault();
          const newPage = +this.getAttribute("data-page");
          if (newPage > 0 && newPage <= totalPages) {
            filterAdminLogs(newPage, pageLimit, adminId, datefrom, dateto);
          }
        });
      });
  }

  function renderPaginationForAdminLogsSearch(
    totalPages,
    currentPage,
    adminId,
    query
  ) {
    const createPageLink = (i, label = i, disabled = false, active = false) =>
      `<li class='page-item ${disabled ? "disabled" : ""} ${
        active ? "active" : ""
      }'>
            <a class='page-link' href='#' data-page='${i}'>${label}</a>
          </li>`;
    let pagLink = `<ul class='pagination justify-content-end'>`;

    // Previous Button
    pagLink += createPageLink(
      currentPage - 1,
      `<i class='bx bx-chevron-left'></i>`,
      currentPage === 1
    );

    // Page numbers with ellipsis
    for (let i = 1; i <= totalPages; i++) {
      if (i === 1 || i === totalPages || Math.abs(i - currentPage) <= 2) {
        pagLink += createPageLink(i, i, false, i === currentPage);
      } else if (i === currentPage - 3 || i === currentPage + 3) {
        pagLink += createPageLink(i, "...", true);
      }
    }

    // Next Button
    pagLink += createPageLink(
      currentPage + 1,
      `<i class='bx bx-chevron-right'></i>`,
      currentPage === totalPages
    );
    pagLink += "</ul>";

    document.getElementById("paginationAdminLogs").innerHTML = pagLink;

    // Add click event listeners
    document
      .querySelectorAll("#paginationAdminLogs .page-link")
      .forEach((link) => {
        link.addEventListener("click", function (e) {
          e.preventDefault();
          const newPage = +this.getAttribute("data-page");
          if (newPage > 0 && newPage <= totalPages) {
            filterAdminLogs(newPage, pageLimit, adminId, query);
          }
        });
      });
  }

  function tableScroll() {
    const tableContainerAdmin = document.querySelector(".table-wrappereAdmin");
    const headerRowAdmin = document.querySelector(".headrow");

    tableContainerAdmin.addEventListener("scroll", function () {
      if (tableContainerAdmin.scrollTop > 0) {
        headerRowAdmin.classList.add("sticky-headerAdmin");
      } else {
        headerRowAdmin.classList.remove("sticky-headerAdmin");
      }
    });
  }
  tableScroll();
  $(".upp").on("click", function () {
    const values = $(this).attr("value");
    $(".profile_picture").val(values);
    $(".ava").hide();
    $(this).siblings(".ava").show();
  });

  $(document).on("click", ".admin_pro", function () {
    const adminObject = JSON.parse($(this).attr("value"));
    console.log(adminObject);
    $("#adminprofile").attr(
      "src",
      "http://localhost/admin/app/assets/images/profile/" +
        adminObject.profile_picture
    );
    $("#pro_fullname").text(adminObject.full_name);
    $("#adminusername").val(adminObject.username);
    $("#adminemail").val(adminObject.email);
    $("#admincontact").val(adminObject.phone_number);
    $("#adminrecovery").val(adminObject.recovery_email);
    $("#adminstatus").val(adminObject.account_status);
    $("#adminrole").val(adminObject.role);
  });
  function applyCustomScrollbarsToTabs() {
    const tableWrappers = document.querySelectorAll(".permissionholder");
    tableWrappers.forEach((wrapper) => {
      wrapper.style.overflow = "auto"; // Ensure the overflow is set
      wrapper.scrollTop = 0; // Reset scroll position if needed
      wrapper.scrollLeft = 0;
    });
  }

  let bigArr = [];
  let originalPermissions = []; //permission array
  let graph = {};
  let userId;
  let adminId;
  let timeout;
  $(document).on("click", ".admin_per", function () {
    const userdata = JSON.parse($(this).attr("value"));
    let permissions = JSON.parse(userdata.permissions);
    bigArr = [];
    originalPermissions = [];
    graph = {};
    userId = userdata.admin_id;

    const sidebarMenu = {
      1: {
        title: "Account Transaction Details",
        content: "account_transaction"
      },
      2: { title: "Game Betting Statistics", content: "Game" },
      3: { title: "Lottery Betting Record", content: "Lottery" },
      4: { title: "Track Records", content: "Track" },

      5: { title: "Deposit Record", content: "Deposit" },
      6: { title: "Withdrawal Records", content: "Withdrawal" },
      7: { title: "Finance Fund Changes", content: "Finance" },

      8: { title: "GPP Win/Loss Report", content: "Win" },

      9: { title: "User List", content: "Userlist" },
      10: { title: "User Logs", content: "Userlogs" },

      11: { title: "Invitation & Referral Links", content: "Invitation" },

      12: { title: "Bank Card List", content: "Bank" },

      13: { title: "Quota Settings", content: "quota" },

      14: { title: "Lottery Draw Records", content: "lotterydraws" },
      15: { title: "Lottery Basic Parameters", content: "lotterybasic" },
      16: { title: "Lottery Bonus Parameters", content: "lotterybonus" },

      17: { title: "Administrator List", content: "administrator_list" },
      18: { title: "Backup & Recovery", content: "bacrecovery" },
      19: { title: "NGP Win/Loss Report", content: "backup_recovery" },
      20: { title: "Annoucement List", content: "annouce" },
      21: { title: "User Notification", content: "usernoti" },
      22: { title: "Add Payment Platform", content: "annouces" },
      23: { title: "BensonGames", content: "usernotis" },
      24: { title: "User Overview", content: "overview" },
      23: { title: "Partners", content: "Partners" },
      25: { title: "User Payment Method", content: "usernotsi" }
    };
    const sidebarMain = {
      1: { category: "Business flow", items: [1, 2, 3, 4] },
      2: { category: "Financial Management", items: [5, 6, 7] },
      3: { category: "Report Management", items: [8, 19] },
      4: { category: "User Management", items: [9, 10, 24] },
      5: { category: "Promotion Management", items: [11] },
      6: { category: "User Bank Management", items: [12, 25] },
      7: { category: "Game Management", items: [14, 15, 16] },
      8: { category: "Agent Management", items: [13] },
      9: { category: "System Management", items: [17, 18] },
      10: { category: "System Announcement", items: [20, 21] },
      11: { category: "Payment Platform", items: [22] },
      12: { category: "Partner Management", items: [23] }
    };
    let html = "";
    for (let key in sidebarMain) {
      html += `
      <div class="accordion-item">
          <div class="accordion-header">
             <span class='maintext'>${sidebarMain[key].category}</span>
          </div>
             <div class="accordion-contentt">
              <ul class="custom-list">`;
      // Check if the permissions object has the key
      if (sidebarMain.hasOwnProperty(key)) {
        //console.log(`Value: ${sidebarMain[key].items}`);

        sidebarMain[key].items.forEach((item) => {
          const value = `${key} ${item}`;
          const checked = permissions?.[key]?.includes(item) ? "checked" : "";

          if (checked) {
            bigArr.push(value);
            originalPermissions.push(value);
          }

          html += `
                    <li id="tab1" class="item " value="" style="display: flex; justify-content: space-between;">
                      ${sidebarMenu[item].title}
                      <input class="form-check-input chk" type="checkbox" value="${
                        key + " " + item
                      }"  ${checked}/>
                    </li>`;
        });
      }

      html += `
                      </ul>
                      </div>
                </div>
      `;
    }

    $(".permissionholder").html(html);
    $(".adminName").text(userdata.full_name + " [Permissions]");

    applyCustomScrollbarsToTabs();
  });

  $(document).on("click", ".chk", function () {
    const val = $(this).val();

    if ($(this).is(":checked")) {
      if (!bigArr.includes(val)) bigArr.push(val);
    } else {
      bigArr = bigArr.filter((item) => item !== val);
    }

    // console.log("Updated bigArr:", bigArr);
  });

  // ✅ Fix the SELECT ALL handler — only one handler, clean logic
  $(document).on("change", "#selectAllPermissions", function () {
    const isChecked = $(this).is(":checked");

    bigArr = []; // Always reset and rebuild the array

    $(".chk").each(function () {
      $(this).prop("checked", isChecked);
      const val = $(this).val();
      if (isChecked) {
        if (!bigArr.includes(val)) bigArr.push(val);
      }
    });

    // console.log(
    //   isChecked
    //     ? "✅ All Permissions Selected"
    //     : "🔄 All Permissions Unselected"
    // );
    // console.log("Admin ID:", userId);
    // console.log("Selected Permission IDs:", bigArr);
  });





  $(document).on("click", ".updateperm", function () {
  const graph = {};

  // Get translated messages
  const infoTitle = document.getElementById("translation-info")?.dataset.msg || "Information";
  const noPermMsg = document.getElementById("translation-noperm")?.dataset.msg || "No permissions selected. Update not sent.";

  if (bigArr.length === 0) {
    showToast(infoTitle, noPermMsg, "error");
    return;
  }

  bigArr.forEach((pair) => {
    const [node, connection] = pair.split(" ");
    const connNum = Number(connection);
    if (!graph[node]) graph[node] = [];
    if (!isNaN(connNum) && !graph[node].includes(connNum)) {
      graph[node].push(connNum);
    }
  });

  // console.log("🟢 Updated Graph Sent for Admin ID:", userId);
  // console.log("Graph Data:", graph);

  updatePermissions(`../admin/permissions/${encodeURIComponent(JSON.stringify(graph) )}/${userId}`);
});


  const viewPermissionsModal = document.getElementById("view-permissions");

  // Add zoom when the modal is shown
  viewPermissionsModal.addEventListener("show.bs.modal", function () {
    viewPermissionsModal.classList.add("zoom");
  });

  // Detect click outside modal-content to trigger shake
  viewPermissionsModal.addEventListener("click", function (event) {
    const dialog = viewPermissionsModal.querySelector(".modal-dialog");

    // If the click target is not inside the modal-dialog, it's a backdrop click
    if (!dialog.contains(event.target)) {
      viewPermissionsModal.classList.add("shake");

      setTimeout(() => {
        viewPermissionsModal.classList.remove("shake");
      }, 2000); // Remove shake after 2 seconds
    }
  });

  //chekers

  $(document).on("change", "#selectAllPermissions", function () {
    const isChecked = $(this).is(":checked");

    $(".chk").each(function () {
      $(this).prop("checked", isChecked).trigger("change"); // trigger change to update bigArr
    });
  });

  $(document).on("click", ".admin_logs", function () {
    const userdata = JSON.parse($(this).attr("value"));
    adminId = JSON.parse(userdata.admin_id);
    console.log(adminId);
    $(".logname").text(userdata.full_name);
    getAdminLogs(currentPage, pageLimit, adminId);
  });

  // $(document).on("click", ".rangelogs", function () {
  //   let datefrom = $(".datefrom").val();
  //   let dateto = $(".dateto").val();
  //   if (datefrom == "" && dateto == "") {
  //     showToast("Information", "Select date(s) to filter", "info");
  //   } else if (datefrom != "" && dateto == "") {
  //     dateto = datefrom;
  //     filterAdminLogs(currentPage, pageLimit, adminId, datefrom, dateto);
  //   } else {
  //     filterAdminLogs(currentPage, pageLimit, adminId, datefrom, dateto);
  //   }
  // });

  $(document).on("click", ".rangelogs", function () {
  const infoTitle = document.getElementById("translation-info")?.dataset.msg || "Information";
  const selectDatesMsg = document.getElementById("translation-select-dates")?.dataset.msg || "Select date(s) to filter";

  let datefrom = $(".datefrom").val();
  let dateto = $(".dateto").val();

  if (datefrom === "" && dateto === "") {
    showToast(infoTitle, selectDatesMsg, "info");
  } else if (datefrom !== "" && dateto === "") {
    dateto = datefrom;
    filterAdminLogs(currentPage, pageLimit, adminId, datefrom, dateto);
  } else {
    filterAdminLogs(currentPage, pageLimit, adminId, datefrom, dateto);
  }
});


  $(document).on("keyup", ".searchlogs", function () {
    let query = $(".searchlogs").val();
    clearTimeout(timeout);
    timeout = setTimeout(
      searchlogs(currentPage, pageLimit, adminId, query),
      300
    );
  });
$(document).on("click", ".search-icon-wrapper", function () {
  const username = $("#transuseradmin").val().trim();
  const uid = $(".adminuserIdtrans").val();
  const pageNumber = 1;
  const limit = 20;

  // Get translations from hidden spans

  const headsUpTitle = document.getElementById("trans-heads-up-title").textContent;
const selectAdminMsg = document.getElementById("trans-select-admin-msg").textContent;
// showToast(headsUpTitle, selectAdminMsg, "info");


  if (!username) {
    // showToast("Heads up!", "Please select or type an admin to search.", "info");
 showToast(headsUpTitle, selectAdminMsg, "info");
    return;
  }

  // Hide search icon and show spinner overlay
  $(".search-icon").hide();
  $(".search-icon-overlay").show();

  // Simulate 2-second loading spinner before sending request
  setTimeout(() => {
    $.ajax({
      url: `../admin/filteradmindata/${username}/${uid}/${pageNumber}/${limit}`,
      method: "POST",
      success: function (response) {
        try {
          if (typeof response === "string") {
            response = JSON.parse(response);
          }

          if (response.status && Array.isArray(response.data) && response.data.length > 0) {
            $("#dataContainerAdmin").empty();
            renderAdmin(response.data);
          } else {
            $("#dataContainerAdmin").html(`
              <tr class="no-resultslist">
                <td colspan="10" class="text-center">
                  <img src="/../admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                  <p class="mt-2 mb-0 fw-semibold">No matching admin found.</p>
                </td>
              </tr>
            `);
          }
        } catch (e) {
          console.error("Response parsing error:", e);
        }

        $(".search-icon-overlay").hide();
        setTimeout(() => {
          $(".search-icon").show();
        }, 1000);
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
        $(".search-icon-overlay").hide();
        setTimeout(() => {
          $(".search-icon").show();
        }, 1000);
      }
    });
  }, 2000); // simulate 2s loading
});

  //refresh page
  $(".refreshadminuser").click(function () {
    // Show loading overlay
    $("#maskadmin").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3
    });

    // Clear input and hidden field
    $("#transuseradmin").val(""); // Clear the search input
    $(".adminuserIdtrans").val(""); // Clear the hidden input
    $("#adminuserAccountDropdown").hide(); // Hide the dropdown

    // Fetch updated data
    fetchAdmins(currentPage, pageLimit); // Ensure currentPage/pageLimit are defined

    // Hide loading overlay after 3 seconds
    setTimeout(function () {
      $("#maskadmin").LoadingOverlay("hide");
    }, 3000); // 3000ms = 3 seconds
  });

  let debounceTimeout = null;
  let isPastings = false;

  $(document).ready(function () {
    $(document).on("keyup", "#transuseradmin", function () {
      const query = $(this).val().trim();

      if (query.length > 1 && !isPastings) {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(fetchbetUser, 500, query);
      } else {
        $("#adminuserAccountDropdown").hide(); // ✅ fixed
      }
    });

    $(document).on("paste", "#transuseradmin", function () {
      isPastings = true;
      $("#adminuserAccountDropdown").hide(); // ✅ fixed
      setTimeout(function () {
        isPastings = false;
      }, 100);
    });

    $(document).on("change", "#adminuserAccountDropdown", function () {
      const selectedOption = $(this).find("option:selected");

      const selectedDisplayValue = selectedOption.data("display");
      const selectedUserId = selectedOption.val();

      if (selectedUserId) {
        $("#transuseradmin").val(selectedDisplayValue);
        $(".adminuserIdtrans").val(selectedUserId);
        $("#adminuserAccountDropdown").hide();
      }
    });

    $(document).on("click", function (e) {
      if (
        !$(e.target).closest("#transuseradmin, #adminuserAccountDropdown")
          .length
      ) {
        $("#adminuserAccountDropdown").hide(); // ✅ fixed
      }
    });

    $(document).on("input", "#transuseradmin", function () {
      if (!$(this).val()) {
        $(".adminuserIdtrans").val("");
      }
    });
  });

  function fetchbetUser(query) {
    let optionsHtml = "";

    $.post(
      `../admin/Searchusernamesss/${encodeURIComponent(query)}`,
      function (response) {
        try {
          response =
            typeof response === "string" ? JSON.parse(response) : response;

          // console.log("Fetched admins:", response);

          response.forEach((admin) => {
            const username = admin.username?.trim() || "";
            const email = admin.email?.trim() || "";
            const contact = admin.contact?.trim() || "";
            const fullName = admin.fullname?.trim() || "";
            const adminId = admin.uid;

            // Set display text based on priority
            let displayText = "";
            let matchedValue = "";

            if (fullName.toLowerCase().includes(query.toLowerCase())) {
              displayText = fullName;
              matchedValue = fullName;
            } else if (username.toLowerCase().includes(query.toLowerCase())) {
              displayText = username;
              matchedValue = username;
            } else if (email.toLowerCase().includes(query.toLowerCase())) {
              displayText = email;
              matchedValue = email;
            } else if (contact.toLowerCase().includes(query.toLowerCase())) {
              displayText = contact;
              matchedValue = contact;
            } else {
              displayText =
                fullName || username || email || contact || "Unknown";
              matchedValue = displayText;
            }

            // Create dropdown option
            optionsHtml += `<option class="optionlist" 
                  value="${adminId}" 
                  data-username="${username}" 
                  data-email="${email}"
                  data-contact="${contact}" 
                  data-fullname="${fullName}"
                  data-display="${matchedValue}">
                  ${displayText}
                </option>`;
          });

          if (optionsHtml) {
            $("#adminuserAccountDropdown").html(optionsHtml).show();
          } else {
            $("#adminuserAccountDropdown").hide();
          }
        } catch (error) {
          console.error("Error parsing admin response:", error);
          $("#adminuserAccountDropdown").hide();
        }
      }
    ).fail(function () {
      console.error("Error fetching admins.");
      $("#adminuserAccountDropdown").hide();
    });
  }
});
