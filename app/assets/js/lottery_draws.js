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
        const status = {
          1: { title: "Deposit", color: "#4CAF50" }, // Green
          2: { title: "Win Bonus", color: "#FF9800" }, // Orange
          3: { title: "Bet Awarded", color: "#03A9F4" }, // Light Blue
          4: { title: "Withdrawal", color: "#F44336" }, // Red
          5: { title: "Bet Cancelled", color: "#9E9E9E" }, // Grey
          6: { title: "Bet Deduct", color: "#E91E63" }, // Pink
          7: { title: "Rebates", color: "#8BC34A" }, // Light Green
          8: { title: "Self Rebate", color: "#00BCD4" }, // Cyan
          9: { title: "Send Red Envelope", color: "#FF5722" }, // Deep Orange
          10: { title: "Receive Red Envelope", color: "#795548" }, // Brown
          11: { title: "Bet Refund", color: "#FFC107" }, // Amber
        };
    
        data.forEach((item) => {
          html += `
                    <tr class="trow">
                        <td>${item.backup_id}</td>

                        <td> 
                           <div class="d-flex align-items-center"> <i class='bx bx-sushi' style="font-size:30px"></i> </div>
                        </td>
    
                        <td>${item.backup_name}</td>
                        <td>${item.backup_type}</td>
                        <td>${item.backup_path}</td>
                        <td>${item.backup_size}</td>
                        <td>${item.encryption}</td>
                        <td>${item.backup_date}</td>
                        <td>${item.backup_time}</td>
                        <td> <span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">${item.backup_status}</span></td>
                        <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                             <i value='' class='bx bx-dots-vertical-rounded'' style='color:#868c87;font-size:18px;cursor:pointer;'></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li value='${JSON.stringify(
                              item
                            )}' class='admin_pro'>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view-profile">
                                <i class='bx bx-refresh' style='font-size:20px;'></i>Restore Backup
                              </a>
                            </li>
                            <li value='${JSON.stringify(
                              item
                            )}' class='admin_logs'>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#view-activity-logs">
                                <i class='bx bx-envelope' style='font-size:20px;'></i>Email Backup
                              </a>
                            </li>
                             <li value='${JSON.stringify(
                              item
                            )}' class='admin_per'>
                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#view-permissions">
                                <i class='bx bx-trash' style='font-size:20px;'></i>Delete Backup
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                      
                    </tr>
                `;
        });
        return html;
    };

    const renderAllBackups = (data) => {
        var html = backupTable(data);
        $("#dataContainerDraw").html(html);
    };

    let currentPage = 1;
    let pageLimit = 50;
    let sibling = ''

    async function getAllGames() {
        try {
          const response = await fetch(`../admin/getAllgames`);
          const data = await response.json();
          let html = ""
          data.forEach((item) => {
             html += `<option value='${item.gt_id}'>${item.name}</option>`
          })
          //renderAllBackups(data.backups);
          //showToast("Success", "Backup created successfully", "success") 
          //sibling.removeClass("bx-loader bx-spin").addClass("bx-plus");
        } catch (error) {
          console.error("Error fetching data:", error);
        }
      }
      getAllGames() 

      async function getAllBackups(currentPage, pageLimit) {
        try {
          const response = await fetch(`../admin/getAllBackups/${currentPage}/${pageLimit}`);
          const data = await response.json();
          //console.log(data);
          renderAllBackups(data.backups);
          $("#maskk").LoadingOverlay("hide")
          //Render pagination
          renderPaginationForBackups(data.totalPages, currentPage);
          document.getElementById("paging_info_backup").innerHTML =
          "Page " + currentPage + " of " + data.totalPages + " pages";
        } catch (error) {
          console.error("Error fetching data:", error);
        }
      }
      //getAllBackups(currentPage, pageLimit);

      function renderPaginationForBackups(totalPages, currentPage) {
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
    
        document.getElementById("paginationBackup").innerHTML = pagLink;
    
        // Add click event listeners
        document.querySelectorAll("#paginationBackup .page-link").forEach((link) => {
          link.addEventListener("click", function (e) {
            e.preventDefault();
            const newPage = +this.getAttribute("data-page");
            if (newPage > 0 && newPage <= totalPages) {
              getAllBackups(newPage, pageLimit);
            }
          });
        });
      }


    $(".createnew").on("click",function(){
      sibling = $(this).find('.bx-plus')
      sibling.removeClass("bx-plus").addClass("bx-loader bx-spin");
      createNewBackup()
    })

    $(".refreshh").on("click",function(){
      $("#maskk").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3
      });
      getAllBackups(currentPage, pageLimit);
    })

    $(".numrowsbackup").change(function(){ 
      const numrow = $(this).val();
      getAllBackups(currentPage,numrow);
    })

})