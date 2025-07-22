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
   const translatorScript = document.querySelector(".translations"); // Get the script tag
    const translator = JSON.parse(translatorScript.textContent);
    const LotteryException = (data) => {
           const gamemodel = {
              1: translator["Standard"],
              2: translator["Two Sides"],
              3: translator["Road Bets"],
              4: translator["Long Dragon"],
              5: translator["Many Tables"],
              6: translator["Board Games"],
              7: translator["Fantan"],
              8: translator["Trend"],
          };
        let html = "";

    //   const formatTimestamp = t => t && typeof t === 'string' && t.trim() ? t.trim().replace(' ', ' / ') : 'N/A';

        data.forEach((item) => {
             let formatTimestamp = (timestamp) => `${timestamp.slice(0, 10)} / ${timestamp.slice(10)}`;
            // if (item.unsettled_bets === 0) {
            //  html += '<tr></tr>';
            // return;
            // }
            let timezone = item.timezone ? item.timezone.split(" ") : ["UTC", "+0"];
            timezone = `${timezone[0]}<span style="margin-left: 1rem;">GMT${timezone[1]}</span>`;

            html += `
            <tr class="trow">
               <td>${item.game_type}</td>
                <td>${gamemodel[item.game_model] ?? item.game_model}</td>
                <td>${item.game_label}</td>
                <td>${item.draw_period}</td>
                <td>${item.total_bets}</td>
                <td>${item.settled_bets}</td>
                <td>${item.unsettled_bets}</td>
                <td>${item.cancelled_bets}</td>
                <td>${item.server_date + " / " + item.server_time}</td>
                <td>${timezone}</td>
                <td>
              <button class="setexcepts"  value ="${item.gt_id}|${item.draw_period}|${item.draw_number}"
               style="padding: 6px 12px; background-color: #e9ecef;border: 1px solid #ccc;border-radius: 6px; color: #333;cursor: pointer;font-size: 14px;
              transition: background-color 0.2s ease;"onmouseover="this.style.backgroundColor='#d6d8db';" onmouseout="this.style.backgroundColor='#e9ecef';"">Settle Bet</button>
            </td>
            </tr>`;
        });
        return html;
    };

    const render = (data) => {
    var html = LotteryException(data);
    $("#lotteryexceptionholder").html(html);
    };

     let currentPage = 1;
     let pageLimit = 20;

    async function fetchLotteryException(currentPage, pageLimit) {
        try {
            const response = await fetch(`../game/lotteryexception/${currentPage}/${pageLimit}`);
            const data = await response.json();
            $("#maskexcept").LoadingOverlay("hide");
            render(data.lotexception);
            renderPaginationex(data.totalPages, currentPage, fetchLotteryException);
            document.getElementById("paging_infoexcept").innerHTML = `${translator["Page"]} ${currentPage} ${translator["Of"]} ${data.totalPages} ${translator["Page"]}`;
        } catch (error) {
            console.error("Error fetching data:", error);
            $("#maskexcept").LoadingOverlay("hide");
        }
    }

    fetchLotteryException(currentPage, pageLimit);
    function renderPaginationex(totalPages, currentPage, callback) {
        let pagLink = `<ul class='pagination justify-content-end'>`;

        // Previous Button
        pagLink += `
            <li class='page-item ${currentPage === 1 ? "disabled" : ""}'>
                <a class='page-link' href='#' data-page='${currentPage - 1}'>
                    <i class='bx bx-chevron-left'></i>
                </a>
            </li>
        `;

        for (let i = 1; i <= totalPages; i++) {
            if (i === currentPage) {
                pagLink += `<li class='page-item active'><a class='page-link' href='#'>${i}</a></li>`;
            } else if (i === 1 || i === totalPages || Math.abs(i - currentPage) <= 2) {
                pagLink += `<li class='page-item'><a class='page-link' href='#' data-page='${i}'>${i}</a></li>`;
            } else if (i === currentPage - 3 || i === currentPage + 3) {
                pagLink += `<li class='page-item disabled'><a class='page-link'>...</a></li>`;
            }
        }

        // Next Button
        pagLink += `
            <li class='page-item ${currentPage === totalPages ? "disabled" : ""}'>
                <a class='page-link' href='#' data-page='${currentPage + 1}'>
                    <i class='bx bx-chevron-right'></i>
                </a>
            </li>
        `;

        pagLink += "</ul>";
        document.getElementById("except-pagination").innerHTML = pagLink;

        // Add click events
        document.querySelectorAll("#except-pagination .page-link").forEach((link) => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                const pageAttr = this.getAttribute("data-page");
                if (!pageAttr) return;

                const newPage = parseInt(pageAttr);
                if (newPage > 0 && newPage <= totalPages && newPage !== currentPage) {
                    $("#maskexcept").LoadingOverlay("show", {
                        background: "rgba(90,106,133,0.1)",
                        size: 3,
                    });

                    currentPage = newPage;
                    callback(newPage, pageLimit);
                }
            });
        });
    }

    $(document).on("click",".setexcepts", function(){
            let gametypeId = $(this).val().split("|")[0]
            let drawperiod = $(this).val().split("|")[1]
            let  draw_number =  $(this).val().split("|")[2]
            console.log(gametypeId,drawperiod,draw_number);
            if (draw_number === null) {
                showToast("Heads Up!!!", "no drawnumber or issue number does not exit", "info");
            }
            //https://winsstarts.com
            // https://157.173.97.174 /api/v1/limvo/processBetSlipIfSkipped
           $.ajax({
                url: "http://192.168.1.51/chairman_test/api/v1/limvo/processBetSlipIfSkipped",
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify({
                    gameIds: [parseInt(gametypeId)],
                    period: drawperiod
                }),
                success: function (data) {
                    console.log("Fetched data:", data);
                    if (data === "done") {
                        showToast("Heads Up!!!", "Done", "success");
                        fetchLotteryException(currentPage, pageLimit);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
           });
    })

    $(".playerexcept").click(function () {
        let direction = $(this).val();
        const tableWrapper = $(".table-wrapperexcept");
        const tableWrappers = document.querySelector(".table-wrapperexcept");
        const scrollAmount = 1000; // Adjust as needed
        const scrollOptions = {
            behavior: "smooth",
        };
        if (tableWrapper.length) {
            switch (direction) {
                case "exceptleft":
                    tableWrappers.scrollBy({ left: -scrollAmount, ...scrollOptions });
                    break;
                case "exceptright":
                    tableWrappers.scrollBy({ left: scrollAmount, ...scrollOptions });
                    break;
                case "exceptstart":
                    // Scroll to the absolute start (leftmost position)
                    tableWrapper.animate({ scrollLeft: 0 }, "slow");
                    break;
                case "exceptend":
                    const maxScrollLeft = tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
                    tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
                    break;
                default:
                    break;
            }
        }
    });

    $(".exceptrefresh").click(function () {
        $(".queryholderexcept").val("");
        $(".userIdexcept").val("");
        $("#maskexcept").LoadingOverlay("show", {
            background: "rgb(90,106,133,0.1)",
            size: 3,
        });
      fetchLotteryException(currentPage, pageLimit);
    });

    
     $(".fetchexcept").click(function () {
        if ($(".typelotterys").val() == "" && $("#drawperiod").val() == "" && $("#exceptdate").val() == "" && $("#exceptdates").val() =="") {
              showToast("Heads up!!", "Select one or more data fields to filter", "info");
         //   showToast(headsUpText, selectFieldsText, "info"); == "" 
            return;
        }
         const gamestype = $(".typelotterys").val();
         const drawperiod = $("#drawperiod").val();
         const startsdates = $("#exceptdate").val();
         const endsdates = $("#exceptdates").val();
         filterlotteryexceptdata(gamestype,drawperiod, startsdates, endsdates, currentPage, pageLimit);
         $(".loaderexcept").removeClass("bx bx-check-double").addClass("bx bx-loader bx-spin");
     //  console.log(gametype,drawperiod,startdates,enddates)
    });

   async function filterlotteryexceptdata(gamestype, drawperiod, startsdates, endsdates, currentPage, pageLimit) {
    $.post(`../game/filterlotteryexceptdata/${gamestype}/${drawperiod}/${startsdates}/${endsdates}/${currentPage}/${pageLimit}`, function (response) {
        try {
            const data = JSON.parse(response);
            console.log(data);
            //return

            $(".loaderexcept").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");

            if (data.lotexceptiondata.length < 1) {
                let html = `
                    <tr class="no-results">
                        <td colspan="9">
                            <img src="http://localhost/admin/app/assets/images/not_found1.jpg" width="150px" height="150px" />
                        </td>
                    </tr>`;
                $("#maskbet").LoadingOverlay("hide");
                $("#lotteryexceptionholder").html(html);
                return;
            }

            $("#maskexcept").LoadingOverlay("hide");
            render(data.lotexceptiondata);
            renderPaginationex(data.totalPages, currentPage, filterlotteryexceptdata);
            document.getElementById("paging_infoexcept").innerHTML = `${translator["Page"]} ${currentPage} ${translator["Of"]} ${data.totalPages} ${translator["Page"]}`;
        } catch (error) {
            console.error("Error parsing JSON response:", error);
            $(".loaderexcept").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
        }

        $(".loaderexcept").removeClass("bx bx-loader bx-spin").addClass("bx bx-check-double");
    });
   }


})
