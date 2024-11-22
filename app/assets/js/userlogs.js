$(function () {

    const UserlogsData = (data) => { 
    
      let html = "";
     
    data.forEach((item) => {
    
        // const ipInfo =fetchIpInfo(item.ip);

        // // Extract city from IP information or use a fallback
        // const city = ipInfo?.geoplugin_city || 'Unknown';
    
        html += `
                    <tr>
                        <td>${item.username}</td>
                        <td>${item.login_date + '' + item.login_time}</td>
                        <td>${item.ip}</td>
                        <td></td>
                        <td>${item.browser_info.substring(0, 12)}</td>
                        <td>${item.device_info.substring(0, 15)}</td>
                        <td>${item.app_version}</td>
                    </tr>
                `;
      });
      return html;
    };

    const renderuserlogs= (data) => {
      var html = UserlogsData(data);
      $("#userlogsContainer").html(html);
    };
  
    let currentPagelogs = 1;
    let pageLimit = 30;

    async function fetchUserlogs(pagelog) {
      try {
        const response = await fetch(`../admin/userlogsdata/${pagelog}/${pageLimit}`);
        const data = await response.json();
      //  console.log(response);   
      
        $("#masklogs").LoadingOverlay("hide")
        renderuserlogs(data.userlogs);
  
        // Render pagination
        renderPaginationlogs(data.totalPages, pagelog, 'normal');
        document.getElementById("paging_infologs").innerHTML = 'Page ' + pagelog + ' of ' + data.totalPages + ' pages'
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
  
    async function filterUserlogs(pagelog, username, startdate, enddate) {
      try {
        const response = await fetch(`../admin/filterUserlogs/${username}/${startdate}/${enddate}/${pagelog}/${pageLimit}`);
         const data = await response.json();
          //  console.log(response)
          //  return
      
        $(".loader").removeClass('bx bx-loader bx-spin').addClass('bx bx-check-double');
        if (data.userloggs.length < 1) {
          let html = `
              <tr class="no-results" >
              <td colspan="9">
                   <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
              </td>
           </tr>`
          $("#userlogsContainer").html(html);
          return
        }
        renderuserlogs(data.userloggs);
  
        // Render pagination
        renderPaginationlogs(data.totalPages, pagelog, 'search', username, startdate, enddate);
        document.getElementById("paging_infologs").innerHTML = 'Page ' + pagelog + ' of ' + data.totalPages + ' pages'
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    }
 
    function renderPaginationlogs(totalPages, currentPagelogs, pagingType = '', username = '',  startdate = '', enddate = '') {
      const createPageLink = (i, label = i, disabled = false, active = false) =>
        `<li class='page-item ${disabled ? "disabled" : ""} ${active ? "active" : ""}'>
          <a class='page-link' href='#' data-page='${i}'>${label}</a>
        </li>`;
      let pagLink = `<ul class='pagination justify-content-end'>`;
  
      // Previous Button
      pagLink += createPageLink(currentPagelogs - 1, `<i class='bx bx-chevron-left'></i>`, currentPagelogs === 1);
  
      // Page numbers with ellipsis
      for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || Math.abs(i - currentPagelogs) <= 2) {
          pagLink += createPageLink(i, i, false, i === currentPagelogs);
        } else if (i === currentPagelogs - 3 || i === currentPagelogs + 3) {
          pagLink += createPageLink(i, "...", true);
        }
      }
  
      // Next Button
      pagLink += createPageLink(currentPagelogs + 1, `<i class='bx bx-chevron-right'></i>`, currentPagelogs === totalPages);
      pagLink += "</ul>";
  
      document.getElementById("paginationlogs").innerHTML = pagLink;
  
      // Add click event listeners
      document.querySelectorAll("#paginationlogs .page-link").forEach(link => {
        link.addEventListener("click", function (e) {
          e.preventDefault();
          const newPage = +this.getAttribute("data-page");
          if (newPage > 0 && newPage <= totalPages) {
            pagingType === 'search' ? filterUserlogs(newPage, username, startdate, enddate) : fetchUserlogs(newPage);
          }
        });
      });
    }
  
    fetchUserlogs(currentPagelogs);
  
  
    $(".playerlogs").click(function () {
  
      let direction = $(this).val();
      const tableWrapper = $(".table-wrapperlist");
      const tableWrappers = document.querySelector(".table-wrapperlist");
      const scrollAmount = 1000; // Adjust as needed
      const scrollOptions = {
        behavior: 'smooth',
      };
      if (tableWrapper.length) {
  
        switch (direction) {
          case 'leftlogs':
            tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
            break;
          case 'rightlogs':
            tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
            break;
          case 'startlogs':
            // Scroll to the absolute start (leftmost position)
            tableWrapper.animate({ scrollLeft: 0 }, 'slow');
            break;
          case 'endlogs':
            const maxScrollLeft = tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
            tableWrapper.animate({ scrollLeft: maxScrollLeft }, 'slow');
            break;
          default:
            break;
        }
  
  
      }
    })
  
    $(".refreshlogs").click(function () {
      $(".queryholderlogs").val("")
      $("#masklogs").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3
      });
      fetchUserlogs(currentPagelogs);
    })
  
    let timeout;
    let userId;
    function performSearch() {
      const queryss = $('#selectuserlogs').val();
      $.post(`../admin/filterusername/${queryss}`, function (response) {
    
        if (typeof response === 'string') {
          $(".queryholderxxx").hide();
        } else if (typeof response === 'object') {
          let html = '';
          // Sort users alphabetically by username
          response.sort((a, b) => a.username.localeCompare(b.username));
          // Generate HTML for the select options
          response.forEach((user) => {
            html += `<li value="${user.uid}" class="optionss">${user.username}</li>`;
          });
  
          // Insert the generated options into the <select> element
          $(".queryholderxxx").html(html).show();
        }
      })
    }
  
    $(document).on("input", '#selectuserlogs', function () {
      clearTimeout(timeout);
      $(".userIds").val("")
      timeout = setTimeout(performSearch, 300);
    })
  
    $(document).on('click', '.optionss', function () {
      $("#selectuserlogs").val($(this).text())
      userId = $(this).attr('value')
      $(".userIds").val(userId)
      $(".queryholderxxx").hide()
    })

  
    $(document).on('click', '.executeuserlogs', function () {
  
      if ($("#selectuserlogs").val() == "" && $(".states").val() == "") {
        $("#danger-userlogs").modal("show");
        return
      }
      const username = $(".userId").val().trim() === "" ? $("#selectuserlogs").val() : $(".userId").val().trim();
      const startdate = $(".startdate").val()
      const enddate = $(".enddate").val()
      console.log(username)
      $(".loader").removeClass('bx-check-double').addClass('bx-loader bx-spin');
      setTimeout(() => {
        filterUserlogs(currentPagelogs,username, startdate, enddate);
      }, 100);
    })
  
  
    $(document).on('click', function () {
      $(".queryholderxxx").hide();
    });
  
   
  
    
    // async function fetchIpInfo(ip) {
    //     try {
    //         // Fetch IP information from the API
    //         const url = `http://www.geoplugin.net/json.gp?ip=${ip}`;
    //         const response = await fetch(url);
    //         // Ensure the request is successful
    //         if (!response.ok) {
    //             throw new Error(`Failed to fetch data for IP: ${ip}`);
    //         }
    
    //         // Parse the response as JSON
    //         const data = await response.json();
    //         return data;
    //     } catch (error) {
    //         console.error(`Error fetching IP info for ${ip}:`, error.message);
    //         return null; // Fallback in case of an error
    //     }
    // }

 

      
    
   
  });