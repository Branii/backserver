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

  const usercarddata = (data) => {
    let html = "";

    data.forEach((item) => {
      html += `
                <tr>
                  <td>${item.username || "N/A"}</td>
                  <td>${item.bank_name_count || 0}</td>
                  <td>${item.bank_type_count || 0}</td>
                  <td>
                    <i class='bx bx-info-circle tuserpayment' data-uid="${
                      item.bkid
                    }" style='color:#868c87;font-size:18px;cursor:pointer;'></i>
                  </td>
                </tr>`;
    });

    return html;
  };

  const renderuserpayment = (data) => {
    const html = usercarddata(data);
    $("#usercardContainer").html(html);
  };



  let currentPage = 1;
  let pageLimit = 20;

async function fetchuserpayment(page, pageLimit) {
  try {
    const response = await fetch(
      `../admin/fetchuserpaymentmethod/${page}/${pageLimit}`
    );
    const jsonData = await response.json();

    if (jsonData && jsonData.data) {
      renderuserpayment(jsonData.data);
    } else {
      renderuserpayment([]);
    }
    $("#maskuserpayment").LoadingOverlay("hide");
  } catch (error) {
    console.error("Error fetching data:", error);
    renderuserpayment([]);
    $("#maskuserpayment").LoadingOverlay("hide");
  }
}

fetchuserpayment(currentPage, pageLimit);


  $(document).on("click", ".tuserpayment", function () {
    const uid = $(this).data("uid");
    $("#Userpaymentmodal").modal("show");
    const tableBody = $("#uerpaymenttbl tbody");
    tableBody.html("");
    $.ajax({
      url: `../admin/fetchuserpaymentbyuid/${uid}`,
      method: "POST",
      dataType: "json",
      success: function (response) {
        response.forEach(function (item) {
          const row = `
                <tr>
                    <td>${item.name || "N/A"}</td>
                    <td>${item.bank_type || "N/A"}</td>
                    <td>${item.bank_status || "N/A"}</td>
                    <td>
                        <button 
                            class="btn btn-success btn-sm deleteMethod" 
                            data-uid="${item.uid}" 
                            data-bankid="${item.bankid}">
                            Inactive
                        </button>
                    </td>
                </tr>
            `;
          tableBody.append(row);
        });
      },
      error: function () {
        alert("Failed to fetch payment data.");
      }
    });
  });

  // Make the user payment inactive
  $(document).on("click", ".deleteMethod", function () {
    const uid = $(this).data("uid");
    const bankid = $(this).data("bankid");
    $.ajax({
      url: `../admin/Inactiveuserpaymentmethod/${uid}/${bankid}`,
      method: "POST",
      success: function (response) {
        $("#Userpaymentmodal").modal("hide");
        showToast( "Heads up!!","Payment method set to inactive successfully!","success");
        fetchuserpayment(currentPage, pageLimit);
      },
      error: function () {
        $("#Userpaymentmodal").modal("hide");
        showToast("Heads up!!", "Failed to set inactive.", "danger");
      }
    });
  });
  // refresh page

  $(".refreshuserpayment").click(function () {
    // Show loading overlay
    $("#maskuserpayment").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3
    });
    // Clear all input fields
    $("#bl-idholder").val("");
    $("#bl-username").val("");
    $("#bl-bank-type").val("");
    $("#bl-card-number").val("");
    $("#bl-status").val(0);
    $("#transuserpayment").val(""); // Clear the search input
    $(".queryholderuserpayment").hide().html(""); // Hide and clear the select dropdown
    $(".userIdtrans").val(""); // Also clear hidden userId if necessary
    fetchuserpayment(currentPage, pageLimit);
  });

  // filterdata here

  $(document).on("click", ".Searchuserpaymentrans", function () {
    const username = $("#transuserpayment").val().trim();
    const uid = $(".userIdtrans").val();
    const pageNumber = 1;
    const limit = 20;
    if (username === "") {
      showToast("Heads up!!","Select one or more data fields to filter","info");
      return;
    }

    $(".loaderlist")
      .removeClass("bx-check-double")
      .addClass("bx-loader bx-spin");
    $.ajax({
      url: `../admin/filterpaymentdata/${username}/${uid}/${pageNumber}/${limit}`,
      method: "POST",
      success: function (response) {
        $(".loaderlist")
          .removeClass("bx-loader bx-spin")
          .addClass("bx-check-double");
        if (typeof response === "string") {
          response = JSON.parse(response);
        }
        if (response.status && response.data.length > 0) {
          // Render filtered table data
          renderuserpayment(response.data);
        } else {
          $("#usercardContainer").html(`
                    <tr class="no-resultslist">
                        <td colspan="9">
                         
                                <img src="/../admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                        </td>
                    </tr>
                `);
        }
      },
      error: function (xhr, status, error) {
        $(".loaderlist")
          .removeClass("bx-loader bx-spin")
          .addClass("bx-check-double");
        console.error("AJAX Error:", status, error);
      }
    });
  });

  //search the for username
  let debounceTimeout = null;
  let isPastings = false;

  $(document).ready(function () {
    $(document).on("keyup", "#transuserpayment", function () {
      const query = $(this).val().trim();

      // Only trigger if input is more than 2 characters
      if (query.length > 1 && !isPastings) {
        clearTimeout(debounceTimeout); // Clear any existing timeout
        debounceTimeout = setTimeout(fetchbetUser, 500, query); // Call fetchUsers with the query after 500ms delay
      } else {
        $(".queryholderuserpayment").hide();
      }
    });

    $(document).on("paste", "#transuserpayment", function () {
      isPastings = true; // Set the flag to true when paste happens
      $(".queryholderuserpayment").hide();
      setTimeout(function () {
        isPastings = false; // Reset the flag after a short delay (allow paste to finish)
      }, 100); // Delay of 100ms is usually enough for paste operations to finish
    });

    $(document).on("change", ".queryholderuserpayment", function () {
      const selectedOption = $(this).find("option:selected");
      const selectedUserId = selectedOption.val(); // uid
      const selectedUsername = selectedOption.data("username"); // username
      if (selectedUserId) {
        $("#transuserpayment").val(selectedUsername);
        $(".userIdtrans").val(selectedUserId); // ✅ Set UID here
        $(".queryholderuserpayment").hide();
      }
    });

    $(document).on("click", function (e) {
      const $dropdown = $("#userpaymentAccountDropdown");
      if (
        !$(e.target).closest("#transuserpayment, #userpaymentAccountDropdown")
          .length
      ) {
        $dropdown.hide();
      }
    });
    $(document).on("input", "#transuserpayment", function () {
      if (!$(this).val()) {
        $(".userIdtrans").val(""); // Reset user ID if input is cleared
      }
    });
  });
  // Function to fetch and display users

  function fetchbetUser(query) {
    let optionsHtml = "";

    $.post(
      `../admin/Searchusernames/${encodeURIComponent(query)}`,
      function (response) {
        try {
          response =
            typeof response === "string" ? JSON.parse(response) : response;
          console.log("Fetched users:", response);
          response.forEach((user) => {
            const regtype = (user.regtype || "").toLowerCase();
            const username = user.username?.trim() || "";
            const email = user.email?.trim() || "";
            const contact = user.contact?.trim() || "";
            let displayusername = "Unknown";
            let regusername = "";
            if (
              regtype === "email" &&
              query.toLowerCase() === email.toLowerCase()
            ) {
              displayusername = email;
              regusername = email;
            } else if (
              regtype === "username" &&
              query.toLowerCase() === username.toLowerCase()
            ) {
              displayusername = username;
              regusername = username;
            } else if (
              regtype === "contact" &&
              query.toLowerCase() === contact.toLowerCase()
            ) {
              displayusername = contact;
              regusername = contact;
            } else {
              // Fallback logic: show preferred identifier if exact match isn't found
              displayusername = username || email || contact || "Unknown";
              regusername = username || email || contact || "Unknown";
            }
            optionsHtml += `<option class="optionlist" value="${user.uid}" data-username="${regusername}">${displayusername}</option>`;
          });
          if (optionsHtml) {
            $(".queryholderuserpayment").html(optionsHtml).show();
          } else {
            $(".queryholderuserpayment").hide();
          }
        } catch (error) {
          console.error("Error parsing response:", error);
          $(".queryholderuserpayment").hide();
        }
      }
    ).fail(function () {
      console.error("Error fetching users.");
      $(".queryholderuserpayment").hide();
    });
  }

});
