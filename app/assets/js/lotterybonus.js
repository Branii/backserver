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

  const maingames = (data) => {
    let htmls = "";

    data.forEach((item) => {
      console.log(item.gameplay);
      htmls += `

             <tr>
                <th rowspan="2">${item.gameplay}</th>
                <td>${item.group_type}</td>
                 <td>${item.name}</td>
                   <td><input type="text" class="form-control" value="${item.modified_odds}" /></td>
                  <td>${item.state}</td>
                  <td><input type="text" class="form-control" value="${item.modified_totalbet}" /></td>
                    <td>${item.modified_totalbet}</td>
              
             </tr>
            <tr>
   
               
             </tr>
                       
          `;
    });
    return htmls;
  };

  //   <tr>
  //   <td>Science</td>
  //   <td>Science</td>
  //   </tr>

  //   <tr>
  //   <th rowspan="2">Subjects</th>
  //   <td>English</td>
  //  </tr>
  //   <tr>
  //   <td>Science</td>
  //   </tr>

  const rendermaingame = (data) => {
    var htmls = maingames(data);
    $(".maingameContainer").html(htmls);
  };

  async function fetchgames() {
    try {
      const response = await fetch(`../admin/fetchgames`); // Await the fetch call
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }

      const data = await response.json(); // Parse JSON response

      let html = `<option value="" class="" >-lottery Type-</option>`;
      data.forEach((maingames) => {
        html += `<option value="${maingames.lt_id}" class="">${maingames.name}</option>`;
      });

      $(".selectmain").html(html);
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }
  fetchgames();

  const tabsgenaerate = [
    { title: "standard", id: "standard-tab-content", tablename: "game_name" },
    { title: "twosides", id: "twosides-tab-content", tablename: "twosides" },
    {
      title: "longdragon",
      id: "standard-tab-content",
      tablename: "longdragon",
    },
    {
      title: "manyatables",
      id: "twosides-tab-content",
      tablename: "manytables",
    },
    {
      title: "boardgmaes",
      id: "standard-tab-content",
      tablename: "boardgames",
    },
    { title: "roadbet", id: "standard-tab-content", tablename: "roadbet" },
    { title: "fantan", id: "twosides-tab-content", tablename: "fantan" },
  ];

  let gameid = "";
  $(document).on("change", ".selectmain", function () {
    const maingameid = $(this).val();
    gameid = maingameid;
    console.log(gameid);
    let html = "";
    // Iterate over the tabsgenaerate array (which contains objects)
    tabsgenaerate.forEach(function (newtab) {
      // Generate buttons for each tab
      html += `<button class="tab-btn btn mb-1 btn-rounded btn-light"data-tables="${newtab.tablename}" data-tabss="${newtab.id}">${newtab.title}</button>`;
    });

    // Append the generated buttons to the container
    $(".showtabss").html(html);

    // // Optionally, show the content for the first tab by default
     $("." + tabsgenaerate[0].id).show();
  });

  // Show content for the clicked tab

  $(document).on("click", ".tab-btn", function () {
    let selectedTabId = $(this).data("tabss");
    let tablename = $(this).data("tables");
    // console.log("Selected Tab ID:", tablename);
    // console.log("Selected Tab ID:", selectedTabId);
    fetchgamebyid(gameid, tablename);
    $(".tab-contentss").hide();

    $("." + selectedTabId).show();
  });

  async function fetchgamebyid(gameid, tablename) {
    try {
      const response = await fetch(
        `../admin/fetchgamebyid/${gameid}/${tablename}`
      );
      const data = await response.json();

      console.log(data);
      //return;

      // $("#maskbet").LoadingOverlay("hide");

      // Render table data
      rendermaingame(data.maingame);
      // return
      // Render pagination
      // renderbetPagination(data.totalPages,page,uidd,gametype,betsate,betstatus,startdates,enddates);
      // document.getElementById("paging_infobet").innerHTML =
      //   "Page " + page + " of " + data.totalPages + " pages";
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }
});
