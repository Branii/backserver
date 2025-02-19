$(function(){

  function showToast(title, message, type) {
      $.toast({
        position: "bottom-right",
        title: title,
        message: message,
        type: type,
        duration: 3000, // auto-dismiss after 3s
      });
    }



  const drawTables = (data) => {
      let html = "";
      const status = {'done' : 'Settled', 'waiting' : 'Settling'};
      data.forEach((item) => {
        html += `<tr class="trow">
                      <td>${item.lottery_type}</td>
                      <td>${item.lottery_code}</td>
                      <td>${item.issue_number}</td>
                      <td>${item.winning_numbers}</td>
                      <td>${item.total_bet_amount}</td>
                      <td>${item.total_win_amount}</td>
                      <td>${item.draw_time}</td>
                      <td>${item.sales_deadline}</td>
                      <td>${item.actual_draw_time}</td>
                      <td>${item.settlement_completion_time}</td>
                      <td> <span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">${status[item.status]}</span></td>
                  </tr>
              `;
      });
      return html;
  };

  const renderDrawTable = (data) => {

      var html = drawTables(data);
      $("#dataContainerDrawsss").html(html);
  };

  let currentPage = 1;
  let pageLimit = 20;
  let sibling = ''

  async function getAllGames() {
      try {
        const response = await fetch(`../admin/getAllgames`);
        const data = await response.json();
        let html = ""
        html += ``
        data.forEach((item) => {
           html += `<option value='${item.gt_id}'>${item.name}</option>`
        })
        $("#allGameNames").html(html)
      } catch (error) {
        console.error("Error fetching data:", error);
      }
  }
  getAllGames() 


    const  getAllSpecificDraws = (currentPage, pageLimit,element) => {
      const gameID       =  $("#allGameNames").val() ;
      const issueNumber  = $("#ltd-issuenumber").val();
      const status       = $("#ltd-status").val();
      const startDate    = $("#ltd-start-date").val();
      const endDate      = $("#ltd-end-date").val();

      console.log(startDate,endDate);
      try {
        $.ajax({
          url:`../admin/getSpecificDraws/${gameID}/${issueNumber}/${status}/${startDate}/${endDate}/${currentPage}/${pageLimit}`,
          type: "POST",
          beforeSend: function(){
              $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");

          },
          success: function(response){
              console.log(response);
              response  = JSON.parse(response);
              if(response.status === 'error'){
                showToast("Error", response.data, "error");
                return;
              }

              if(response.data.length === 0){
                $("#dataContainerDrawsss").html(`<tr class="no-results"><td colspan="12"><img src="/admin/app/assets/images/notfound.png" class="dark-logo" alt="Logo-Dark"></td></tr>`)
                return;
              }
              const data = response.data;
              console.log(data);
              renderDrawTable(data);
              $("#maskkk").LoadingOverlay("hide")
              const totalPages = Math.ceil(data[0].total_records / pageLimit);
              renderPaginationForDraws(totalPages, currentPage,(currentPage,pageLimit)=> getAllSpecificDraws(currentPage,pageLimit));
              document.getElementById("ltd_paging_info_draws").innerHTML =
              "Page " + currentPage + " of " + totalPages + " pages";
          },
          error: function (xhr,status,error){
            console.log(error);
          },
          complete: function (){
            $($(element).find("i")[0]).removeClass("bx-loader bx-spin").addClass("bx-check-double");
          },
       
        });
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }

    getAllSpecificDraws(currentPage,pageLimit);
    //getAllBackups(currentPage, pageLimit);

    function renderPaginationForDraws(totalPages, currentPage,callback) {
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
  
      document.getElementById("ltd_paginationDraws").innerHTML = pagLink;
  
      // Add click event listeners
      document.querySelectorAll("#ltd_paginationDraws .page-link").forEach((link) => {
        link.addEventListener("click", function (e) {
          e.preventDefault();
          const newPage = +this.getAttribute("data-page");
          if (newPage > 0 && newPage <= totalPages) {
            //getAllBackups(newPage, pageLimit);
            callback(newPage,pageLimit) 
          }
        });
      });
    }


  $(".executegetdrawsb").on("click",function(){
   
    getAllSpecificDraws(currentPage, pageLimit,this) 

  });

  $(".refreshdraws").on("click",function(){
    $("#allGameNames").val(1) ;
    $("#ltd-issuenumber").val("");
    $("#ltd-status").val(0);
    $("#ltd-start-date").val("");
    $("#ltd-end-date").val("");
    getAllSpecificDraws(currentPage, pageLimit,this) 
  })

  $(".numrowsbackup").change(function(){ 
    const numrow = $(this).val();
    getAllBackups(currentPage,numrow);
  })

})