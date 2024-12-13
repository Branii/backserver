$(function () {
  var el = document.querySelector("#tabheadParams");
  var chromeTabsParams = new ChromeTabs();
  chromeTabsParams.init(el);

  TabArray = [];
  TabMap = new Map();
  let contentEl;
  el.addEventListener("activeTabChange", ({ detail }) =>
    onTabChanged(detail.tabEl)
  );
  el.addEventListener("tabAdd", ({ detail }) => setcurr(detail.tabEl));
  el.addEventListener("tabRemove", ({ detail }) => closeTab(detail.tabEl));

  function showToast(title, message, type) {
    $.toast({
      position: "bottom-right",
      title: title,
      message: message,
      type: type,
      duration: 3000, // auto-dismiss after 3s
    });
  }

  const lotteryParamTable = (data) => {
    let html = "";
    data.forEach((item) => {
      html += `
                    <tr class="trow">
                        <td>${item.gameplay}</td>
                        <td>${item.group_type}</td>
                        <td>${item.name}</td>
                        <td><input type='text' class='form-control' value='${item.modified_odds}'></td>
                        <td>${item.state}</td>
                        <td>${item.modified_totalbet}</td>
                    </tr>
                `;
    });
    return html;
  };

  const renderLotteryParams = (data, container) => {
    var html = lotteryParamTable(data);
    $("." + container + '_container').html(html);
  };

  let currentPage = 1;
  let pageLimit = 50;
  let sibling = "";

  async function getAllGamesLottery() {
    try {
      const response = await fetch(`../admin/getAllGamesLottery`);
      const data = await response.json();
      console.log(data);
      let html = "";
      html += `<option>Select Game</option>`;
      data.forEach((item) => {
        html += `<option value='${item.lt_id}'>${item.name}</option>`;
      });
      $(".lotteryTypes").html(html);
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }
  getAllGamesLottery();



  function setcurr(elem) {
    let contentEl = $(elem).find(".chrome-tab-holder").text().trim();
    TabMap.set(contentEl, elem);
  }

  function addTabStyle(contentEl, elem) {
    TabMap.set(contentEl, elem);
    $(".chrome-tab-drag-handle").removeClass("chromclass");
    $(elem).find(".chrome-tab-drag-handle").addClass("chromclass");
  }

  function onTabChanged(elem) {
    let tabContent = $(elem).find(".chrome-tab-holder").text().trim();
    $(".chrome-tab-drag-handle").removeClass("chromclass");
    $(elem).find(".chrome-tab-drag-handle").addClass("chromclass");
    $(".chrome__tabb").hide();
    $("." + tabContent).show();
    applyCustomScrollbarsToTabs();
  }

  async function getLotteryGames(lotterId,tables){
    try {
      const response = await fetch(`../admin/getLotteryGames/${lotterId}/${tables}`);
      const data = await response.json();
      //
      console.log(data);
      Object.entries(data).forEach(([key, value]) => {
       // console.log(`${key}: ${value}`);
        renderLotteryParams(value, key)
       });

    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  $(".executegetlottery").on("click", function () {
    let lotteryId = $("#allGameNamesLottery").val();

    const gameModelMap = {
      1: {
        title: "5D",
        content: [
          "standard_content",
          "twoside_content",
          "longdragon_content",
          "boardgame_content",
          "roadbet_content",
          "fantan_content",
          "manytable_content"
        ],
        tabs: [
          "Standard",
          "Two Side",
          "Long Dragon",
          "Board Games",
          "Road Bet",
          "Fantan",
          "Many Tables"
        ],
        tables: [
          "game_name",
          "twosides",
          "longdragon",
          "boardgames",
          "roadbet",
          "fantan"
        ]
      }
    };
    const gameTables = gameModelMap[lotteryId]['tables']
    const jsonString = JSON.stringify(gameTables);
    getLotteryGames(lotteryId,JSON.stringify(gameTables))
    $(".chrome__tabb").hide();
    console.log(jsonString);

    //console.log(chromeTabsParams);

    //   chromeTabsParams.addTab({
    //     title: "tabName",
    //     favicon: false,
    //     //content: tabContent,
    //  });

    //console.log("object");

    gameModelMap[lotteryId]["tabs"].forEach((tabName, index) => {
      chromeTabsParams.addTab({
        title: `${tabName}`, // Using the index in the title
        favicon: false,
        content: gameModelMap[lotteryId]["content"][index], // Adding the index to make the content unique
      });
    });

    // //console.log(TabMap);
    chromeTabsParams.setCurrentTab(TabMap.get("standard_content"));
    $(".standard_content").show();
   

    //console.log(gameModelMap[lotterId]['tabs']);
  });

  $(".refreshdraws").on("click", function () {
    let params = [$("#drawfrom").val(), $("#drawto").val()];
    let gameId = $("#allGameNames").val();
    console.log(gameId);
    //const isEmpty = params.some(param => param === "")
    if (gameId == "Select Game") {
      showToast("Information", "Please select game", "info");
    } else {
      $("#maskkk").LoadingOverlay("show", {
        background: "rgb(90,106,133,0.1)",
        size: 3,
      });
      getAllSpecificDraws(currentPage, pageLimit, gameId, params[0], params[1]);
    }
  });

  $(".numrowsbackup").change(function () {
    const numrow = $(this).val();
    getAllBackups(currentPage, numrow);
  });
});
