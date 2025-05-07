$(function(){

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



  const drawTables = (data) => {
      let html = "";
      console.log(data);
      const status = {'done' : 'Settled', 'waiting' : 'Settling'};
      data.forEach((item) => {
        let timezone = item.timezone.split(" ");
        timezone = timezone[0] + `<span style="margin-left: 1rem;">${timezone[1]}</span>`;
        html += `<tr class="trow">
                      <td>${item.lottery_type}</td>
                      <td>${transformInputLd(item.lottery_code)}</td>
                      <td>${item.issue_number}</td>
                      <td>${item.winning_numbers}</td>
                      <td>${item.total_bet_amount}</td>
                      <td>${item.total_win_amount}</td>
                      <td>${item.draw_time}</td>
                      <td>${item.sales_deadline}</td>
                      <td>${item.actual_draw_time}</td>
                      <td>${timezone}</td>
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
        const response = await fetch(`../admin/getAllgames/${partnerID}`);
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


      try {
        $.ajax({
          url:`../admin/getSpecificDraws/${partnerID}/${gameID}/${issueNumber}/${status}/${startDate}/${endDate}/${currentPage}/${pageLimit}`,
          type: "POST",
          beforeSend: function(){
              $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");

          },
          success: function(response){
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
              renderDrawTable(data);
              $("#maskkk").LoadingOverlay("hide")
              const totalPages = Math.ceil(data[0].total_records / pageLimit);
              renderPaginationForDraws(totalPages, currentPage,(currentPage,pageLimit)=> getAllSpecificDraws(currentPage,pageLimit));
              document.getElementById("ltd_paging_info_draws").innerHTML =
              "Page " + currentPage + " of " + totalPages + " pages";
          },
          error: function (xhr,status,error){
            showToast("Error", "Request Error, please contact admin",'error');
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


$(".ld_data_scroll").click(function () {
  let direction = $(this).val();
  const tableWrapper = $(".ld-table-wrapperDraws");
  const tableWrappers = document.querySelector(".ld-table-wrapperDraws");
  const scrollAmount = 1300; // Adjust as needed
  const scrollOptions = {
      behavior: "smooth",
  };
  if (tableWrapper.length) {
      switch (direction) {
          case "left":
              tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
              break;
          case "right":
              tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
              break;
          // case "startlists":
          //     // Scroll to the absolute start (leftmost position)
          //     tableWrapper.animate({ scrollLeft: 0 }, "slow");
          //     break;
          // case "endlists":
          //     const maxScrollLeft = tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
          //     tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
          //     break;
          default:
              break;
      }
  }
});

const transformInputLd = (str) => {
  // Trim whitespace from both ends
  str = str.trim();

  // Rule 1: If the string starts with digits, an 'x', and then more digits (e.g. "11x5")
  if (/^\d+x\d+/.test(str)) {
    // Take everything before the first space as the prefix
    const prefix = str.split(/\s+/)[0];
    return prefix.charAt(0).toUpperCase() + prefix.slice(1) + "1001";
  } else {
    // Rule 2: Process as a name-like string

    // Remove any trailing digits (e.g., "RoodevFast3" -> "RoodevFast")
    str = str.replace(/\d+$/, "");

    let words = [];

    // If there's a space, split on whitespace
    if (str.includes(" ")) {
      words = str.split(/\s+/);
    } else {
      // Otherwise, try splitting on CamelCase: sequences of capital letter + subsequent lowercase
      const matches = str.match(/[A-Z][a-z]*/g);
      if (matches) {
        words = matches;
      } else {
        // If we can't split (or there's no CamelCase), treat the entire string as one word
        words = [str];
      }
    }

    // If no words found, just return the (trimmed) string as-is
    if (words.length === 0) {
      return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // Build the abbreviation
    // 1) First letter of the first word
    let abbreviation = words[0].charAt(0);

    // 2) Append the first consonant (non-vowel) that follows in the first word
    const vowels = "aeiouAEIOU";
    for (let i = 1; i < words[0].length; i++) {
      if (!vowels.includes(words[0][i])) {
        abbreviation += words[0][i];
        break;
      }
    }

    // 3) If there's a second word, add its first letter;
    // otherwise, if the first word has >= 3 letters, add the third letter
    if (words.length > 1) {
      abbreviation += words[1].charAt(0);
    } else {
      if (words[0].length >= 3) {
        abbreviation += words[0].charAt(2);
      }
    }

    // Capitalize and append "500"
    return abbreviation.charAt(0).toUpperCase() + abbreviation.slice(1) + "500";
  }
}

})






