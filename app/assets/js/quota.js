$(function () {
  const QuotaData = (data) => {
    let html = "";

    data.forEach((item) => {
      html += `
                    <tr>
                        <td>${item.rebate}</td>
                        <td>${item.odds_group}</td>
                        <td class="editable">${item.quota}</td>
                        <td>
                        <button class="edit-btn btn btn-lights btn-sm" style="font-size:25px;cursor: pointer;"><i class='bx bxs-edit'></i></button>
                        <button class="update-btn btn btn-lighst btn-sm d-none" rebateid="${item.rebate_id}"><i class='bx bx-check-square' style="font-size:25px;"></i></button>
                        <button class="btn btn-sm btn-secondarys alt-btn"style="font-size:25px;cursor: pointer;"><i class='bx bx-message-square-x'></i></button> <!-- New button -->
                        </td>                       
                    </tr>
                `;
    });
    return html;
  };

  const renderquota = (data) => {
    var html = QuotaData(data);
    $("#quotaContainer").html(html);
  };

  let currentPagequota = 1;
  let pageLimit = 151;

  async function fetchquota(pagequota) {
    try {
      const response = await fetch(
        `../admin/fetchquota/${pagequota}/${pageLimit}`
      );
      const data = await response.json();
      console.log(response);
      // return
      $("#maskquota").LoadingOverlay("hide");
      renderquota(data.quota);

      // // Render pagination
       renderPaginationquota(data.totalPages, pagequota, 'normal');
       document.getElementById("paging_infoquota").innerHTML = 'Page ' + pagequota + ' of ' + data.totalPages + ' pages'
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }


  function renderPaginationquota(
    totalPages,
    currentPagequota,
    pagingType = "",
    username = "",
    startdate = "",
    enddate = ""
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
      currentPagequota - 1,
      `<i class='bx bx-chevron-left'></i>`,
      currentPagequota === 1
    );

    // Page numbers with ellipsis
    for (let i = 1; i <= totalPages; i++) {
      if (i === 1 || i === totalPages || Math.abs(i - currentPagequota) <= 2) {
        pagLink += createPageLink(i, i, false, i === currentPagequota);
      } else if (i === currentPagequota - 3 || i === currentPagequota + 3) {
        pagLink += createPageLink(i, "...", true);
      }
    }

    // Next Button
    pagLink += createPageLink(
      currentPagequota + 1,
      `<i class='bx bx-chevron-right'></i>`,
      currentPagequota === totalPages
    );
    pagLink += "</ul>";

    document.getElementById("paginationquota").innerHTML = pagLink;

    // Add click event listeners
    document.querySelectorAll("#paginationquota .page-link").forEach((link) => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        const newPage = +this.getAttribute("data-page");
        if (newPage > 0 && newPage <= totalPages) {
          pagingType === "search"
            ? filterUserlinks(newPage, username, startdate, enddate)
            : fetchUserlinks(newPage);
        }
      });
    });
  }

  fetchquota(currentPagequota);


  $(".refreshquota").click(function () {
    $(".queryholderlogs").val("");
    $("#masklogs").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3,
    });
    fetchquota(currentPagequota)
  });

 

    $(document).on("click", ".edit-btn", function () {
        const $row = $(this).closest("tr"); $row.find(".editable").attr("contenteditable", "true").addClass("editing")
        .first()
        .focus(); // Enable editing and focus
        $(this).addClass("d-none"); // Hide "Edit" button
        $row.find(".update-btn").removeClass("d-none"); // Show "Update" button
    });

    $(document).on("click", ".update-btn", function () {
        const $row = $(this).closest("tr"); // Get the current row
        const $editableField = $row.find(".editable.editing"); 
        const updatedValue = $editableField.text().trim(); 
        const rebateId = $(this).attr('rebateid');
        EditSingleQuota(rebateId,updatedValue)
        // Disable editing and reset buttons
        $editableField.removeAttr("contenteditable").removeClass("editing"); 
        $(this).addClass("d-none"); // Hide "Update" button
        $row.find(".edit-btn").removeClass("d-none"); 
    });


    $(document).on("click", ".alt-btn", function () {
        const $row = $(this).closest("tr"); // Get the current row
        $row.find(".update-btn").addClass("d-none");
        $row.find(".edit-btn").removeClass("d-none");
    });


    async function EditSingleQuota(rebatid,quota) {
        try {
        const response = await fetch(`../admin/updatequota/${rebatid}/${quota}`);
        // const data = await response.json();
        console.log(response);
        } catch (error) {
        console.error("Error fetching data:", error);
        }
    }

    
        $(document).on("click", ".setallquota", function () {
            $("#addContactModal").modal("show");
        });

        $(document).on("click", "#btn-setallquota", function (){
            const  quotaval = $("#c-quota").val()
            try {
              $.post(`../admin/UpdateAllquota/${quotaval}`,
                function(response) {
                  if(response){
                    alert("updated")
                    fetchquota(currentPagequota);
                  }
                });
                // const data = await response.json();
                
                } catch (error) {
                console.error("Error fetching data:", error);
                }

         });
  

         $(document).on("keyup", ".userrebate", function () {
            const datarebate = $(this).val();
            if (datarebate === "") {
                console.log("Input is empty. Resetting results.");
                renderquota([]); // Reset or clear results
                let html = `
                <tr class="no-results" >
                <td colspan="9">
                     <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                </td>
             </tr>`;
          $("#quotaContainer").html(html);
          return
            }
             try {
                  $.post(`../admin/filterRebate/${datarebate}`,
                     function(response) {
                        console.log(response)
                        const data = JSON.parse(response);
                        renderquota(data.filterquota);  
                    });
          
                } catch (error) {
                  console.error("Error fetching data:", error);
                 }
          });
        
    
});
