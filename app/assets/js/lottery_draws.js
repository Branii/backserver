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

  const drawTable = (data) => {
      let html = "";
      data.forEach((item) => {
        html += `
                  <tr class="trow">
                      <td>${item.draw_id}</td>
                      <td>${item.period}</td>
                      <td>${item.draw_number}</td>
                      <td>${item.total_bet_amount}</td>
                      <td>${item.total_won_amount}</td>
                      <td>${item.closing_time}</td>
                      <td>${item.time_added}</td>
                      <td>${item.closing_time}</td>
                      <td> <span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">${item.draw_status}</span></td>
                  </tr>
              `;
      });
      return html;
  };

  const renderDrawTable = (data) => {
      var html = drawTable(data);
      $("#dataContainerDraws").html(html);
  };

  let currentPage = 1;
  let pageLimit = 50;
  let sibling = ''

  async function getAllGames() {
      try {
        const response = await fetch(`../admin/getAllgames`);
        const data = await response.json();
        let html = ""
        html += `<option>Select Game</option>`
        data.forEach((item) => {
           html += `<option value='${item.gt_id}'>${item.name}</option>`
        })
        $("#allGameNames").html(html)
      } catch (error) {
        console.error("Error fetching data:", error);
      }
  }
  getAllGames() 

    async function getAllSpecificDraws(currentPage, pageLimit, gameId, datefrom, dateto) {
      try {
        const response = await fetch(`../admin/getSpecificDraws/${gameId}/${datefrom}/${dateto}/${currentPage}/${pageLimit}`);
        const data = await response.json();
        console.log(data);
        renderDrawTable(data.gameDraws);
        $("#maskkk").LoadingOverlay("hide")
        renderPaginationForDraws(data.totalPages, currentPage,gameId, datefrom, dateto);
        document.getElementById("paging_info_draws").innerHTML =
        "Page " + currentPage + " of " + data.totalPages + " pages";
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
    //getAllBackups(currentPage, pageLimit);

    function renderPaginationForDraws(totalPages, currentPage, gameId, datefrom, dateto) {
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
  
      document.getElementById("paginationDraws").innerHTML = pagLink;
  
      // Add click event listeners
      document.querySelectorAll("#paginationDraws .page-link").forEach((link) => {
        link.addEventListener("click", function (e) {
          e.preventDefault();
          const newPage = +this.getAttribute("data-page");
          if (newPage > 0 && newPage <= totalPages) {
            //getAllBackups(newPage, pageLimit);
            getAllSpecificDraws(newPage, pageLimit, gameId, datefrom, dateto) 
          }
        });
      });
    }


  $(".executegetdraws").on("click",function(){
    let params = [$("#drawfrom").val(),$("#drawto").val()]
    let gameId = $("#allGameNames").val()
    console.log(gameId)
    //const isEmpty = params.some(param => param === "")
    if(gameId == "Select Game"){
      showToast("Information", "Please select game", "info") 
    }else{
      getAllSpecificDraws(currentPage, pageLimit, gameId, params[0], params[1]) 
    }
  })

  $(".refreshdraws").on("click",function(){
    let params = [$("#drawfrom").val(),$("#drawto").val()]
    let gameId = $("#allGameNames").val()
    console.log(gameId)
    //const isEmpty = params.some(param => param === "")
    if(gameId == "Select Game"){
      showToast("Information", "Please select game", "info") 
    }else{
      $("#maskkk").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3
      });
      getAllSpecificDraws(currentPage, pageLimit, gameId, params[0], params[1]) 
    }
  })

  $(".numrowsbackup").change(function(){ 
    const numrow = $(this).val();
    getAllBackups(currentPage,numrow);
  })

})