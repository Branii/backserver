$(function () {
  
  function showToast(title,message,type){
    $.toast({
        position: "bottom-right",
        title: title,
        message: message,
        type: type,
        duration: 3000, // auto-dismiss after 3s
    });
}
  
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
      11: { title: "Bet Refund", color: "#FFC107" }, // Amber
    };

    data.forEach((item) => {

      let first = item.full_name.split(" ")[0][0]
      let last = item.full_name.split(" ")[1][0]

      html += `
                <tr class="trow">
                    
                    <td> 
                       <div class="d-flex align-items-center">
                          <img src="http://localhost/admin/app/assets/images/profile/${item.profile_picture}" class="rounded-circle" width="40" height="40" />    
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
                    <td>${item.two_factor_method}</td>
                    <td><i class='bx bxs-circle' style='color:#1dd846;font-size:8px'></i> ${item.account_status}</td>

                    <td>
                   
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                             <i value='' class='bx bx-dots-vertical-rounded'' style='color:#868c87;font-size:18px;cursor:pointer;'></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class="fs-4 ti ti-plus"></i>Add
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class='bx bx-edit-alt' style='font-size:16px;'></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">
                                <i class='bx bx-trash' style='font-size:16px;'></i>Delete
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

  let currentPage = 1;
  let pageLimit = 50;

  const renderAdmin = (data) => {
    var html = AdminTable(data);
    $("#dataContainerAdmin").html(html);
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

  fetchAdmins(currentPage, pageLimit);

  const request = (url) => {
    $.post(url, function (result) {
      const data = JSON.parse(result);
      console.log(data);
      $(".add-new").modal("hide")
      renderAdmin(data.admins);
      showToast("Success", "New user added successfulyy", "success")
    });
  };

  $(".fullsubmit").on("click", function (evt) {
    evt.preventDefault();
    let params = [$(".fullname").val(),$(".fullemail").val(),$(".fullcontact").val(),$(".fullrole").val()];
    const data = $("#admins").serialize();
    let isEmpty = params.some(param => param === "")
    //console.log(params)
    !isEmpty ? request(`../admin/admins/${data}`) : showToast("Heads up!!", "All fields are mandatory", "info");
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
          fetchAdmins(newPage, pageLimit)
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

  $(".upp").on("click", function(){
    const values = $(this).attr('value')
    $(".profile_picture").val(values)
    $(".ava").hide()
    $(this).siblings(".ava").show();
  })

});
