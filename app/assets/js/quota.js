
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

  const ALL_FIELDS_REQUIRED = document.getElementById("allfields_text").innerText;
const ENTER_QUOTA_VALUE = document.getElementById("quota_text").innerText;
const SUCCESS_TEXT = document.getElementById("success_text").innerText;
const QUOTA_UPDATED = document.getElementById("quota_success").innerText;

  const QuotaData = (data) => {
      let html = "";

      data.forEach((item) => {
          html += `
                  <tr>
                  <td>${item.odds_group}</td>
                  <td>${item.rebate}</td>
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
          const response = await fetch(`../admin/fetchquota/${pagequota}/${pageLimit}`);
          const data = await response.json();
          $("#maskquota").LoadingOverlay("hide");
          renderquota(data.quota); 
      } catch (error) {
          console.error("Error fetching data:", error);
      }
  }

  fetchquota(currentPagequota, pageLimit);

  $(".refreshquota").click(function () {
      $(".queryholderlogs").val("");
      $("#maskquota").LoadingOverlay("show", {
          background: "rgb(90,106,133,0.1)",
          size: 3,
      });

      fetchquota(currentPagequota, pageLimit);
  });

  $(document).on("click", ".edit-btn", function () {
      const $row = $(this).closest("tr");
      $row.find(".editable").attr("contenteditable", "true").addClass("editing").first().focus(); // Enable editing and focus
      $(this).addClass("d-none"); // Hide "Edit" button
      $row.find(".update-btn").removeClass("d-none"); // Show "Update" button
  });

  $(document).on("click", ".update-btn", function () {
      const $row = $(this).closest("tr"); // Get the current row
      const $editableField = $row.find(".editable.editing");
      const updatedValue = $editableField.text().trim();
      const rebateId = $(this).attr("rebateid");
      EditSingleQuota(rebateId, updatedValue);
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

  async function EditSingleQuota(rebatid, quota) {
      try {
          const response = await fetch(`../admin/updatequota/${rebatid}/${quota}`);
          if (response) {
            //   showToast("Success", "quota updated successfully", "success");
              showToast(SUCCESS_TEXT, QUOTA_UPDATED, "success");
              
          }
      } catch (error) {
          console.error("Error fetching data:", error);
      }
  }

  $(document).on("click", ".setallquota", function () {
      $("#addContactModal").modal("show");
  });

//   $(document).on("click", "#btn-setallquota", function () {
//       const quotaval = $("#c-quota").val();
//       try {
//           $.post(`../admin/UpdateAllquota/${quotaval}`, function (response) {
//               if (response) {
//                   showToast("Success", "quota updated successfully", "success");
//                   fetchquota(currentPagequota, pageLimit);
//               }
//           });
//           // const data = await response.json();
//       } catch (error) {
//           console.error("Error fetching data:", error);
//       }
//   });




// showToast(ALL_FIELDS_REQUIRED, ENTER_QUOTA_VALUE, "error");
// showToast(SUCCESS_TEXT, QUOTA_UPDATED, "success");
$(document).on("click", "#btn-setallquota", function () {
    const quotaval = $("#c-quota").val().trim();

    // ✅ Check if the field is empty
    if (quotaval === "") {
        // showToast("All Fields Required", "Please enter a quota value before saving.", "error");
        showToast(ALL_FIELDS_REQUIRED, ENTER_QUOTA_VALUE, "error");
        return;
    }

    // Proceed to send the POST request
    try {
        $.post(`../admin/UpdateAllquota/${quotaval}`, function (response) {
            if (response) {
                // showToast("Success", "Quota updated successfully", "success");
                showToast(SUCCESS_TEXT, QUOTA_UPDATED, "success");
                fetchquota(currentPagequota, pageLimit);
            }
        });
    } catch (error) {
        console.error("Error updating quota:", error);
    }
});


  $(document).on("keyup", ".userrebatess", function () {
      const inputValue = $(this).val().trim(); 
      let datarebate = parseFloat(inputValue).toFixed(1);
   
      if (isNaN(datarebate)) {
          fetchquota(currentPagequota, pageLimit);
          let html = `
            <tr class="no-results" >
                <td colspan="9">
                     <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                </td>
            </tr>`;
          $("#quotaContainer").html(html);
          return;
      }

      // If valid number, make the API call
      try {
          $.post(`../admin/filterRebate/${datarebate}`, function (response) {
              const data = JSON.parse(response);
              renderquota(data.filterquota);
          });
      } catch (error) {
          console.error("Error fetching data:", error);
      }
  });

  function tableScrollQuota() {
      const tableContainerQuota = document.querySelector(".table-wrapperquota");
      const headerRowQuota = document.querySelector(".headrowquota");

      tableContainerQuota.addEventListener("scroll", function () {
          if (tableContainerQuota.scrollTop > 0) {
              headerRowQuota.classList.add("sticky-headerquota");
          } else {
              headerRowQuota.classList.remove("sticky-headerquota");
          }
      });
  }

  tableScrollQuota();
});
