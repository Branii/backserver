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
      console.log(typeof item.modified_odds);
      html += `
                    <tr class="trow">
                        <td>${item.gameplay_name}</td>
                        <td>${item.group_type}</td>
                        <td>${item.name}</td>
                        <td><input type='text' class='form-control' value='${item.modified_odds}'class="oddsone">
                        <input type="range" id="rangeSliderone" min="0" max="100" value="100">
                          <span id="rangeValue">100%</span>
                        </td>
                        <td> <label class="switch gameplaybtn"><input type="checkbox" value ="${item.state}" style="z-index:999"/> <span class="slider"></span></label></td>
                     
                         <td>
                          <input type="text" hidden data='${item.modified_totalbet}' value='${item.modified_totalbet}' min="0" max="10000" step="0.1" class="odds-input" id="oddsInput" />
                      
                            <br>
                          <!-- Range Slider -->
                          <input type="range" value="10" min="0" max="10" step="1" class="odds-slider" id="oddsSlider" />
                            <span class="percentDisplay">100%</span> 
                         </td>
                          
                         <td>${item.modified_totalbet}</td>
                    
                          <td><input type='text' class='form-control finalval' value='${item.modified_totalbet}' disabled></td>
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
      // console.log(data);
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
      // //
      // console.log(response);
      // return
      Object.entries(data).forEach(([key, value]) => {
       // console.log(`${key}: ${value}`);
        renderLotteryParams(value, key)
      });

    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  $(document).on("click", ".executegetparams", function () {
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
      },
      2: {
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
      },
      3: {
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
      },
      5: {
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
      },
      6: {
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
      },
      8: {
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
      },
      10: {
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
    //console.log(chromeTabsParams);

    //console.log(chromeTabsParams);

    //   chromeTabsParams.addTab({
    //     title: "tabName",
    //     favicon: false,
    //     //content: tabContent,
    //  });

    //console.log("object");
    // TabMap.clear()
    // TabMap.forEach((elem) =>{
    //   chromeTabsParams.removeTab()
    // })



    $(".ten").children().remove();
    TabMap.clear()
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

    //console.log(TabMap)
   
    //console.log(gameModelMap[lotterId]['tabs']);
  });





  //max slide


  $(document).on('input','.odds-input', function() {
    let inputValue = parseFloat($(this).val());
    let maxValueDefault = $(this).closest("tr").find(".odds-input").attr('data')
    if (inputValue > maxValueDefault) {
    $(this).val(maxValueDefault);  // Set the input value to maxValue if exceeded
       }
    // Update the slider position based on the input value
    let percentage = (inputValue / maxValue) * 100;
    let sliderValue = (percentage / 100) * 10; // Map percentage to slider range (0 to 10)
    $('.odds-slider').val(sliderValue);
  });

  // When the slider changes, update the input field
  $(document).on('input','.odds-slider', function() {
    let sliderValue = parseFloat($(this).val());
    let maxValueDefault = $(this).closest("tr").find(".odds-input").attr('data')
    let maxValue = 0
    maxValue = maxValueDefault

    let percentage = (sliderValue / 10) * 100; // Map slider value to percentage
    let inputValue = (percentage / 100) * maxValue; // Calculate the value based on the max value
   
    $(this).closest("tr").find(".odds-input").val(inputValue)
    $(this).closest("tr").find(".finalval").val(inputValue)
    $(this).closest("tr").find('.percentDisplay').text(`${Math.round(percentage)}%`);
    $(this).closest("tr").find('.computedValue').text(`Computed Value: ${Math.round(inputValue)}`);
    // console.log(maxValueDefault)
    
  });

  $(document).on('input', '#rangeSliderone', function() {
    // Get the initial values from the input box
    let originalValues =parseFloat($(".oddsone").val());
 console.log(originalValues);
    // Get the current percentage from the range slider
    // let percentage = $(this).val();
    // $("#rangeValue").text(percentage + "%");

    // // Function to update values based on the percentage
    // function updateValues(percentage) {
    //     let scaledValues = originalValues.map(value => (value * percentage / 100).toFixed(2));
    //     $(".oddsone").val(`[${scaledValues.join(", ")}]`);
    // }

    // // Update the values
    // updateValues(percentage);
});

});
