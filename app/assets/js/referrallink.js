$(function () {

    const UserlinksData = (data) => { 
    
      let html = "";
     
    data.forEach((item) => {
    
        html += `
                    <tr>
                        <td>${item.agent_name}</td>
                        <td class='link-offset-1 text-decoration-underline'>${item.register_link}</td>
                        <td>${item.rebate}</td>
                        <td>${item.register_count + '/' + item.quota_used}</td>
                         <td>${item.date_created + '' + item.time_created}</td>
                         <td>${item.remarks}</td>
                        
                    </tr>
                `;
      });
      return html;
    };

    const renderuserlinks= (data) => {
      var html = UserlinksData(data);
      $("#linksContainer").html(html);
    };
  
    let currentPagelinks = 1;
    let pageLimit = 30;

    async function fetchUserlinks(pagelinks) {
      try {
        const response = await fetch(`../admin/userlinkdata/${pagelinks}/${pageLimit}`);
        const data = await response.json();
        console.log(response);   
        // return
        $("#masklinks").LoadingOverlay("hide")
        renderuserlinks(data.userlinks);
  
        // Render pagination
        renderPaginationlinks(data.totalPages, pagelinks, 'normal');
        document.getElementById("paging_infolinks").innerHTML = 'Page ' + pagelinks + ' of ' + data.totalPages + ' pages'
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
  

    async function filterUserlinks(pagelog, username, startdate, enddate) {
        try {
          const response = await fetch(`../admin/filterUserlinks/${username}/${startdate}/${enddate}/${pagelog}/${pageLimit}`);
           const data = await response.json();
            // console.log(response)
            //  return
        
          $(".loader").removeClass('bx bx-loader bx-spin').addClass('bx bx-check-double');
          if (data.userlinkss.length < 1) {
            let html = `
                <tr class="no-results" >
                <td colspan="9">
                     <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                </td>
             </tr>`
            $("#linksContainer").html(html);
            return
          }
          renderuserlinks(data.userlinkss);
    
          // Render pagination
          renderPaginationlogs(data.totalPages, pagelinks, 'search', username, startdate, enddate);
          document.getElementById("paging_infolinks").innerHTML = 'Page ' + pagelinks + ' of ' + data.totalPages + ' pages'
        } catch (error) {
          console.error("Error fetching data:", error);
        }
      }
   
    function renderPaginationlinks(totalPages, currentPagelinks, pagingType = '', username = '',  startdate = '', enddate = '') {
      const createPageLink = (i, label = i, disabled = false, active = false) =>
        `<li class='page-item ${disabled ? "disabled" : ""} ${active ? "active" : ""}'>
          <a class='page-link' href='#' data-page='${i}'>${label}</a>
        </li>`;
      let pagLink = `<ul class='pagination justify-content-end'>`;
  
      // Previous Button
      pagLink += createPageLink(currentPagelinks - 1, `<i class='bx bx-chevron-left'></i>`, currentPagelinks === 1);
  
      // Page numbers with ellipsis
      for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || Math.abs(i - currentPagelinks) <= 2) {
          pagLink += createPageLink(i, i, false, i === currentPagelinks);
        } else if (i === currentPagelinks - 3 || i === currentPagelinks + 3) {
          pagLink += createPageLink(i, "...", true);
        }
      }
  
      // Next Button
      pagLink += createPageLink(currentPagelinks + 1, `<i class='bx bx-chevron-right'></i>`, currentPagelinks === totalPages);
      pagLink += "</ul>";
  
      document.getElementById("paginationlinks").innerHTML = pagLink;
  
      // Add click event listeners
      document.querySelectorAll("#paginationlinks .page-link").forEach(link => {
        link.addEventListener("click", function (e) {
          e.preventDefault();
          const newPage = +this.getAttribute("data-page");
          if (newPage > 0 && newPage <= totalPages) {
            pagingType === 'search' ? filterUserlinks(newPage, username, startdate, enddate) : fetchUserlinks(newPage);
          }
        });
      });
    }
  
    fetchUserlinks(currentPagelinks);
  
    $(".playerlinks").click(function () {
  
      let direction = $(this).val();
      const tableWrapper = $(".table-wrapperlist");
      const tableWrappers = document.querySelector(".table-wrapperlist");
      const scrollAmount = 1000; // Adjust as needed
      const scrollOptions = {
        behavior: 'smooth',
      };
      if (tableWrapper.length) {
  
        switch (direction) {
          case 'leftlinks':
            tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
            break;
          case 'rightlinks':
            tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
            break;
          case 'startlinks':
            // Scroll to the absolute start (leftmost position)
            tableWrapper.animate({ scrollLeft: 0 }, 'slow');
            break;
          case 'endlinks':
            const maxScrollLeft = tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
            tableWrapper.animate({ scrollLeft: maxScrollLeft }, 'slow');
            break;
          default:
            break;
        }
  
  
      }
    })
  
    $(".refreshlinks").click(function () {
      $(".queryholderlogs").val("")
      $("#masklogs").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3
      });
      fetchUserlinks(currentPagelinks);
    })
  
    let timeout;
    let userId;
    function performSearch() {
      const querylink = $('#selectuserlinks').val();
      $.post(`../admin/filterusername/${querylink}`, function (response) {
    
        if (typeof response === 'string') {
          $(".queryholderlinks").hide();
        } else if (typeof response === 'object') {
          let html = '';
          // Sort users alphabetically by username
          response.sort((a, b) => a.username.localeCompare(b.username));
          // Generate HTML for the select options
          response.forEach((user) => {
            html += `<li value="${user.uid}" class="optionlink">${user.username}</li>`;
          });
  
          // Insert the generated options into the <select> element
          $(".queryholderlinks").html(html).show();
        }
      })
    }
  
    $(document).on("input", '#selectuserlinks', function () {
      clearTimeout(timeout);
      $(".userIds").val("")
      timeout = setTimeout(performSearch, 300);
    })
  
    $(document).on('click', '.optionlink', function () {
      $("#selectuserlinks").val($(this).text())
      userId = $(this).attr('value')
      $(".userIds").val(userId)
      $(".queryholderlinks").hide()
    })

  
    $(document).on('click', '.executeuserlinks', function () {
  
      if ($("#selectuserlinks").val() == "" && $(".states").val() == "") {
        $("#danger-userlinks").modal("show");
        return
      }
      const username = $(".userId").val().trim() === "" ? $("#selectuserlinks").val() : $(".userId").val().trim();
      const startdate = $(".startdate").val()
      const enddate = $(".enddate").val()
      console.log(username)
      $(".loaderlinks").removeClass('bx-check-double').addClass('bx-loader bx-spin');
      setTimeout(() => {
        filterUserlinks(currentPagelinks,username, startdate, enddate);
      }, 100);
    })
  
  
    $(document).on('click', function () {
      $(".queryholderlinks").hide();
    });
  
   
  
  
  });