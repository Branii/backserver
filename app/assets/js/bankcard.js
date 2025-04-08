$(function () {

    function showToast(title, message, type) {
      $.toast({
        position: "bottom-right",
        title: title,
        message: message,
        type: type,
        duration: 3000, // auto-dismiss after 3s
      });
    }
    const bankcarddata = (data) => { 
        
        const states = {
            1: "In Force",
            2: "Not Active",
            3: "Terminated",
            4: "Deleted",
        
          };
        let html = "";
       
      data.forEach((item) => {
        const username = item.username == '*****' ? item.nickname : item.username;
      
          html += `<tr>
                    <td>${username}</td>
                      <td>${item.bank_type}</td>
                      <td>${item.account_name}</td>
                      <td>${item.card_number}</td>
                      <td>${item.withdrawal_count}</td>
                      <td>${item.bind_time}</td>
                      <td>${states[item.status]}</td> 
                    </tr>
                  `;
        });
        return html;
      };
  

      function tableScrolluserListt() {
        const tableContainerUsert = document.querySelector(".table-wrapperbankcard");
        const headerRowUserListt = document.querySelector(".headrowuserbank");

        tableContainerUsert.addEventListener("scroll", function () {
            if (tableContainerUsert.scrollTop > 0) {
                headerRowUserListt.classList.add("sticky-headeruserbank");
            } else {
                headerRowUserListt.classList.remove("sticky-headeruserbank");
            }
        });
    }
    tableScrolluserListt();

  
    let currentPagebankcard = 1;
    let pageLimit = 20;
  
    async function fetchbankcard(pagebankcard,refresh = false) {
      try {
        const uid         = $("#bl-idholder").val();
        const bank_type   = $("#bl-bank-type").val();
        const card_number = $("#bl-card-number").val();
        const status      = $("#bl-status").val();
        const response = await fetch(
          `../admin/fetchbankcard/${uid}/${bank_type}/${card_number}/${status}/${pagebankcard}/${pageLimit}/1`
        );
         const data = await response.json();
          // console.log(response);
        //   return

        if(data.status === "error"){
          showToast("Error", data.data, "error");
          return ;
        }
        $("#maskbanks").LoadingOverlay("hide");
        $("#bankcardContainer").html(bankcarddata(data.data));
        const totalPages = Math.ceil(data.data[0].total_records / pageLimit);
        // // Render pagination
        renderPaginationlist(totalPages, pagebankcard, pageLimit,(newpage) => fetchbankcard(newpage));
         document.getElementById("paging_infobankcard").innerHTML = 'Page ' + pagebankcard + ' of ' + totalPages + ' pages'
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
  
    fetchbankcard(currentPagebankcard);
  

    // function renderbankcardPagination(totalPages, currentPagebankcard) {
    //   let pagLink = `<ul class='pagination justify-content-end'>`;
    
    //   // Previous Button
    //   pagLink += `
    //     <li class='page-item ${currentPagebankcard === 1 ? "disabled" : ""}'>
    //       <a class='page-link' href='#' data-page='${currentPagebankcard - 1}'><i class='bx bx-chevron-left'></i></a>
    //     </li>
    //   `;
    
    //   // Page numbers with ellipsis
    //   for (let i = 1; i <= totalPages; i++) {
    //     if (i === currentPagebankcard) {
    //       pagLink += `<li class='page-item active'><a class='page-link' href='#'>${i}</a></li>`;
    //     } else if (i === 1 || i === totalPages || Math.abs(i - currentPagebankcard) <= 2) {
    //       pagLink += `<li class='page-item'><a class='page-link' href='#' data-page='${i}'>${i}</a></li>`;
    //     } else if (i === currentPagebankcard - 3 || i === currentPagebankcard + 3) {
    //       pagLink += `<li class='page-item disabled'><a class='page-link'>...</a></li>`;
    //     }
    //   }
    
    //   // Next Button
    //   pagLink += `
    //     <li class='page-item ${currentPagebankcard === totalPages ? "disabled" : ""}'>
    //       <a class='page-link' href='#' data-page='${currentPagebankcard + 1}'><i class='bx bx-chevron-right'></i></a>
    //     </li>
    //   `;
    
    //   pagLink += "</ul>";
    //   document.getElementById("paginationbankcard").innerHTML = pagLink;
    
    //   // Add click event listeners to pagination links
    //   document.querySelectorAll("#paginationbankcard .page-link").forEach((link) => {
    //     link.addEventListener("click", function (e) {
    //       e.preventDefault();
    //       const newPage = parseInt(this.getAttribute("data-page"));
    //       if (newPage > 0 && newPage <= totalPages && newPage !== currentPagebankcard) {
    //         // Update currentPagebankcard and display paging information
    //         currentPagebankcard = newPage;
    //         document.getElementById("paging_infobankcard").innerHTML = `Page ${currentPagebankcard} of ${totalPages} pages`;
            
    //         // Fetch and render new page data
    //         fetchbankcard(currentPagebankcard);
    //       }
    //     });
    //   });
    // }
  
    $(".refreshbankcard").click(function () {
     // $(".query").val("");
      $("#maskbanks").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3,
      });

      $("#bl-idholder").val("");
      $("#bl-username").val("");
      $("#bl-bank-type").val("");
      $("#bl-card-number").val("");
      $("#bl-status").val(0);
      fetchbankcard(currentPagebankcard)
    });
  
   
    let debounceTimeout = 500; // To store the timeout ID
      // Event listener for keyup on #myInput
      $(document).on("keyup", "#bl-username", function () {
          const query = $(this).val().trim();

          // Only trigger if input is more than 2 characters
          if (query.length > 1) {
              clearTimeout(debounceTimeout); // Clear any existing timeout
              debounceTimeout = setTimeout(fetchUsers, 500, query); // Call fetchUsers with the query after 500ms delay
          } else {
              $(".bl-users-wrapper").hide(); // Hide dropdown if input is less than 3 characters
          }
      });
      $(document).on("keyup", "#bl-bank-type", function () {
          const query = $(this).val().trim();

          // Only trigger if input is more than 2 characters
          if (query.length > 1) {
              clearTimeout(debounceTimeout); // Clear any existing timeout
              debounceTimeout = setTimeout(fetchBankTypes, 500, query); // Call fetchUsers with the query after 500ms delay
          } else {
              $(".bl-bank-type-wrapper").hide(); // Hide dropdown if input is less than 3 characters
          }
      });

      // Handle dropdown item selection
      $(document).on("click", "#bl-names-wrapper .name-items", function () {
          const userID = $(this).attr("data-user-id");

          if (userID) {
              $("#bl-username").val($(this).text());
              $("#bl-idholder").val(userID);
              $(".bl-users-wrapper").hide(); 
          }
      });

       // Handle dropdown item selection
       $(document).on("click", "#bl-bank-type-wrapper .name-items", function () {
            $("#bl-bank-type").val($(this).text());
            $(".bl-bank-type-wrapper").hide();
    });

      $(document).on("click", function (e) {
          const $dropdown = $("#userlists");
          if (!$(e.target).closest("#selectuserlist, #userlists").length) {
              $dropdown.hide();
          }
      });
      // Handle manual input clearing
      $(document).on("input", "#bl-username ", function () {
          if (!$(this).val()) {
              $("#bl-idholder").val(""); // Reset user ID if input is cleared
          }
      });



      $(document).on("click", ".bl-search",function (){
        searchBankList(1);
      });


const searchBankList = (currentPage) => {


  try {

    const userID     = $("#bl-idholder").val();
    const bankType   = $("#bl-bank-type").val();
    const cardNumber = $("#bl-card-number").val();
    const state      = $("#bl-status").val();
    const element    = this;
    const pageLimit    = 20;

    if(userID.length == "" && bankType.length == "" && cardNumber.length == "" && state.length == ""){
      showToast("Field Required","Please select at least one field", "info");
      return;
  }
$.ajax({
      url: `../admin/fetchbankcard/${userID}/${bankType}/${cardNumber}/${state}/${currentPage}/${pageLimit}/1`,
      type: "POST",
      beforeSend: function(){
         $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
      },
      success: function(response){
          response  = JSON.parse(response);
          if(response.status === "error"){
              $("#bankcardContainer").html(`<tr class="no-resultslist"><td colspan="13">Error: ${response.data}</td></tr>`); 
              return
          }
         
          if(response.data.length == 0){
              $("#bankcardContainer").html(`<tr class="no-resultslist"><td colspan="13"> <img src="/admin/app/assets/images/not_found.jpg" class="dark-logo" alt="Logo-Dark"></td></tr>`);  
              $("#bl-pagination-wrapper").html("");
              $("#bl-paging_infowl").html("---------");
              return; 
          }
          bankCardObjs   = response.data;
          $("#bankcardContainer").html(bankcarddata(bankCardObjs));
          const totalPages = Math.ceil(bankCardObjs[0].total_records / pageLimit);
  
          // Render pagination
          renderPaginationlist(totalPages, currentPage, pageLimit,(newpage) => searchBankList(newpage));
          document.getElementById("paging_infobankcard").innerHTML = 'Page ' + currentPage + ' of ' + totalPages + ' pages'
          
          },
      error: function(xhr,status,error){
          showToast("Error","An Error occured, please try again later.","info");
      },
      complete: function(){
          $($(element).find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx-check-double");
          $("#wl-pagination").html("")
      }
  });

  

  } catch (error) {
    showToast("Error","Client Script exception, please contact admin", "error");
  }



};

// Function to fetch and display users
const  fetchUsers = (query) =>{
  let optionsHtml = '';

  $.post(`../admin/Searchusername/${encodeURIComponent(query)}`, function (response) {
      try {
           const getDisplayName = (user) => {
               if(user.username !== "" && user.username != undefined && user.username !== "*****") return user.username;
               if(user.email !== undefined && user.email != "") return user.email;
               if(user.contact != undefined && user.contact != "") return user.contact;
          };
          response = typeof response === 'string' ? JSON.parse(response) : response;
          if(response[0].empty != undefined){

            $('#bl-names-wrapper').html(`<li class="name-items" data-user-id="" data-username="">No results found.</li>`);
            $(".bl-users-wrapper").show();
            return;
          }
          for (let index = 0; index < response.length; index++) {
              const user = response[index];
              const username =user[user.regtype];
              optionsHtml += username === undefine ? `<li class="name-items">No Data Found.</li>` : `<li class="name-items" data-user-id="${user.uid}" data-username="${username}">${username}</li>`;
          }
          $('#bl-names-wrapper').html(optionsHtml);
          $(".bl-users-wrapper").show();
       } catch (error) {
          showToast("Error", "Request could not be completed, please try again.","error");
      }
  }).fail(function () {
    showToast("Error", "Request could not be completed, please try again.","error");
  });
}

// Function to fetch and display users
const  fetchBankTypes = (query) =>{

  try {
          const elemennt = this;
  $.ajax({
    url: `../admin/searchBankTypes/${query}`,
    type: "POST",
    beforeSend: function(){
      //  $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
    },
    success: function(response){
      response = JSON.parse(response);
      if(response.status == "error"){
        showToast("Error", "Request could not be completed, please try again.","error");
       
        return;
      }

      const data = response.data;
      if(data.length == 0){
        $('#bl-bank-type-wrapper').html(`<li class="name-items" data-user-id="" data-username="">No results found.</li>`);
        $(".bl-bank-type-wrapper").show();
        return;
      }

      let optionsHtml = "";
      for (let index = 0; index < data.length; index++) {
          const bankType = data[index];
          const bankName = bankType.bank_type;
          optionsHtml += `<li class="name-items" data-bank-id="${bankType.bank_id}" data-bank-name="${bankName}">${bankName}</li>`;
      }

      $('#bl-bank-type-wrapper').html(optionsHtml);
      $(".bl-bank-type-wrapper").show();
    },
    error: function(xhr,status,err){

    },complete: function (){

    }
  });

  } catch (error) {
    showToast("Error", "Request could not be completed, please try again.","error");
}

  
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

  document.getElementById("paginationbankcard").innerHTML = pagLink;

  // Add click event listeners
  document.querySelectorAll(".pagination .page-link").forEach((link) => {
      link.addEventListener("click", function (e) {
          e.preventDefault();
          const newPage = +this.getAttribute("data-page");
          if (newPage > 0 && newPage <= totalPages) {
              $("#maskuserlist").LoadingOverlay("show", {
                  background: "rgb(90,106,133,0.1)",
                  size: 3,
              });
              callback(newPage); // Call the provided callback with new page 
          }
      });
  });
}

    
  });
  