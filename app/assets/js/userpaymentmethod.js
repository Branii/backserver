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
    const states = {
      1: "In Force",
      2: "Not Active",
      3: "Terminated",
      4: "Deleted"
    };
    let html = "";

    data.forEach((item) => {
      html += `<tr>
              
                   <td>${item.username}</td>
                    <td>${item.bank_name_count}</td>
                    <td>${item.bank_type_count}</td>
                   <td><i class='bx bx-info-circle tuserpayment' data-uid="${item.bkid}" style='color:#868c87;font-size:18px;cursor:pointer;'></i></td>    
                    </tr>
                  `;
    });
    return html;
  };
  const renderuserpayment = (data) => {
    //  console.log("Fetched Data:", data);
    var html = usercarddata(data);
    // console.log("Generated HTML:", html);
    $("#usercardContainer").html(html);
  };

  let currentPage = 1;
  let pageLimit = 20;

  async function fetchuserpayment(page, pageLimit) {
    try {const response = await fetch(`../admin/fetchuserpaymentmethod/${page}/${pageLimit}`);
      const data = await response.json();
      renderuserpayment(data.data);
      $("#maskuserpayment").LoadingOverlay("hide");
      //  renderfinacesPagination(data.totalPages, page, pageLimit, (newPage, pageLimit) => fetchUserlinks(newPage, pageLimit));
      //  document.getElementById("paging_inforeferal").innerHTML = "Page " + page + " of " + data.totalPages + " pages";
    } catch (error) {
      console.error("Error fetching data:", error);
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
        showToast(
          "Heads up!!",
          "Payment method set to inactive successfully!",
          "success"
        );
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
    // $(".query").val("");
    $("#maskuserpayment").LoadingOverlay("show", {
      background: "rgb(90,106,133,0.1)",
      size: 3
    });

    $("#bl-idholder").val("");
    $("#bl-username").val("");
    $("#bl-bank-type").val("");
    $("#bl-card-number").val("");
    $("#bl-status").val(0);
    fetchuserpayment(currentPage, pageLimit);
  });


$(document).on("keyup click", "#transuserpayment, .Searchuserpaymentrans", function () {
    const username = $("#transuserpayment").val().trim().toLowerCase();

    if (username === "") {
        fetchuserpayment(currentPage, pageLimit); // fallback to full data
        return;
    }

    console.log("Username input:", username);

    $.ajax({
        url: `../admin/filterpaymentdata/${username}`,  // <-- correct use of template literal
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status && response.data.length > 0) {
                $("#usercardContainer").html(renderTableRow(response.data));
                console.log("Fetched Data:", response.data);
            } else {
                $("#usercardContainer").html(`
                    <tr class="no-resultslist">
                        <td colspan="9">
                            <img src="assets/images/not_found.jpg" class="dark-logo" alt="No results found" />
                        </td>
                    </tr>
                `);
            }
        }
    });
});

function renderTableRow(data) {
    let html = "";

    data.forEach(item => {
        html += `
            <tr>
                <td>${item.username}</td>
                <td>${item.bank_name_count}</td>
                <td>${item.bank_type_count}</td>
                <td>
                    <i class='bx bx-info-circle tuserpayment' 
                       data-uid="${item.bkid}" 
                       style='color:#868c87;font-size:18px;cursor:pointer;'></i>
                </td>
            </tr>
        `;
    });

    return html;
}


});
