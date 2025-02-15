    function showToast(title, message, type) {
        $.toast({
            position: "bottom-right",
            title: title,
            message: message,
            type: type,
            duration: 3000, // auto-dismiss after 3s
        });
    }

    async function fetchData(url,page,pageLimit,renderCallback,element={}, params = {},keys = []) {
        try {
            //const query = new URLSearchParams({page,pageLimit,...params,}).toString();
            const response = await fetch(`${url}/${page}/${pageLimit}/${JSON.stringify(params)}`);
            const result = await response.json();
         
            $("#" + element.table).LoadingOverlay("hide");
            renderCallback(result.data, element.table, keys);
            renderPagination(result.totalPages, page, pageLimit, element.pagination, element.table, (newPage, newLimit) =>
                fetchData(url, newPage, newLimit, renderCallback, element, params, keys)
            );
            document.getElementById(element.paging).innerHTML = `Page ${page} Of ${result.totalPages} Pages`;
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }

    function renderPagination(totalPages, currentPage, pageLimit, paginationContainer, tableId, callback, ) {
        const createPageLink = (i, label = i, disabled = false, active = false) =>
            `<li class='page-item ${disabled ? "disabled" : ""} ${active ? "active" : ""}'>
            <a class='page-link' href='#' data-page='${i}'>${label}</a>
        </li>`;

        let pagLink = `<ul class='pagination justify-content-end'>`;
        pagLink += createPageLink(
            currentPage - 1,
            `<i class='bx bx-chevron-left'></i>`,
            currentPage === 1
        );
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || Math.abs(i - currentPage) <= 2) {
                pagLink += createPageLink(i, i, false, i === currentPage);
            } else if (i === currentPage - 3 || i === currentPage + 3) {
                pagLink += `<li class='page-item disabled'><span class='page-link'>...</span></li>`;
            }
        }
        pagLink += createPageLink(
            currentPage + 1,
            `<i class='bx bx-chevron-right'></i>`,
            currentPage === totalPages
        );
        pagLink += "</ul>";

        document.getElementById(paginationContainer).innerHTML = pagLink;
        document.querySelectorAll("#"+ paginationContainer +" .page-link").forEach((link) => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                const newPage = +this.getAttribute("data-page");
                if (newPage > 0 && newPage <= totalPages) {
                    $("#" + tableId).LoadingOverlay("show", { background: "rgb(90,106,133,0.1)", size: 3 });
                    callback(newPage, pageLimit);
                }
            });
        });
    }

    function directions(elementDirection, Wrapper) {
        let direction = elementDirection;
        const tableWrapper = $("." + Wrapper);
        const tableWrappers = document.querySelector("." + Wrapper);
        const scrollAmount = 1000; // Adjust as needed
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
            case "start":
                tableWrapper.animate({ scrollLeft: 0 }, "slow");
                break;
            case "end":
                const maxScrollLeft =
                tableWrapper[0].scrollWidth - tableWrapper[0].clientWidth;
                tableWrapper.animate({ scrollLeft: maxScrollLeft }, "slow");
                break;
            default:
                break;
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const tableContainer = document.querySelector('.table-wrapper');
        const headerRow = document.querySelector('thead tr');

        tableContainer.addEventListener('scroll', function() {
          if (tableContainer.scrollTop > 0) {
            headerRow.classList.add('sticky-header');
          } else {
            headerRow.classList.remove('sticky-header');
          }
        });
    });

   //async function 

   async function getSingleData(url,params = {}) {
    try {
        const response = await fetch(`${url}/${JSON.stringify(params)}`);
        const result = await response.json();
        formatAccountTransactionTable(result.data, "firstrow", firstRow)
        formatAccountTransactionTable(result.data, "secondrow", secondRow)
        MicroModal.show("modal-1");
    } catch (error) {
        console.error("Error fetching data:", error);
    }
   }



