$(function () {
  const partnerID = $("#partner-holder").attr("data-partner-id");
  // var el = document.querySelector("#tabheadParams");
  // var chromeTabsParams = new ChromeTabs();
  // chromeTabsParams.init(el);

  // TabArray = [];
  // TabMap = new Map();
  // let contentEl;
  // el.addEventListener("activeTabChange", ({ detail }) => onTabChanged(detail.tabEl));
  // el.addEventListener("tabAdd", ({ detail }) => setcurr(detail.tabEl));
  // el.addEventListener("tabRemove", ({ detail }) => closeTab(detail.tabEl));

  function showToast(title, message, type) {
    $.toast({
      position: "bottom-right",
      title: title,
      message: message,
      type: type,
      duration: 3000 // auto-dismiss after 3s
    });
  }


const SUCCESS_TEXT = document.getElementById("success_text").innerText;
const UPDATED_SUCCESSFULLY = document.getElementById("updated_successfully").innerText;
const GAME_STATE_UPDATED = document.getElementById("game_state_updated").innerText;
const NO_CHANGES_MADE = document.getElementById("no_changes_made").innerText;

// showToast(SUCCESS_TEXT, UPDATED_SUCCESSFULLY, "success");
// showToast(SUCCESS_TEXT, GAME_STATE_UPDATED, "info");
// showToast(SUCCESS_TEXT, NO_CHANGES_MADE, "info");

  function getTranslation(id, fallback) {
    return document.getElementById(id)?.dataset.translation || fallback;
  }

  const SaveText =
    document.getElementById("savee-text")?.dataset.translation || "Save";


  const lotteryParamTable = (data) => {

    let html = "";
    const grouped = {};
    
  
      data.forEach(item => {
          const lotteryType = item.lottery_type === 1 ? "5D" :item.lottery_type === 2 ? "Pk10" :
                        item.lottery_type === 3 ? "FAST3" :item.lottery_type === 5 ? "3D" :
                        item.lottery_type === 6 ? "11x5" :item.lottery_type === 8 ? "Mark6" :
                        item.lottery_type === 10 ? "Happy8" :item.lottery_type === 11 ? "PK6" :
                      "Other Games"; 

              if (!grouped[lotteryType]) {
                grouped[lotteryType] = {}; // Initialize empty object for that lotteryType
              }
              // Initialize gameplay_name if not already in grouped[lotteryType]
              if (!grouped[lotteryType][item.gameplay_name]) {
                grouped[lotteryType][item.gameplay_name] = [];
              }
              // Push the item into the appropriate group
              grouped[lotteryType][item.gameplay_name].push(item);
    });

  
    for (const lottery in grouped) {
      const lotteryGroup = grouped[lottery];
      const lotteryStateChecked = lotteryGroup[Object.keys(lotteryGroup)[0]][0]['lottery_state'] === "active" ? "checked" : "";
      //  console.log(lotteryStateChecked)
      // First row with Lottery Type
      html += `
        <tr style="background:#eef;">
          <td colspan="6" style="backgrounds:#eee;">${lottery}</td>
            <td colspan="10"style="backgrounds:#eee;">
              <label class="switch" ">
                <input type="checkbox" class="form-check-input gameslottery" value='' datas='${lotteryGroup[Object.keys(lotteryGroup)[0]][0]['lottery_type']}' role="switch" ${lotteryStateChecked}>
                <span class="slider"></span>
              </label>
            </td>
        
        </tr>
      `;
    for (const gameplay in lotteryGroup) {
      const groupItems = lotteryGroup[gameplay];
      const groupStateChecked  = groupItems[0]['group_state'] === "active" ? "checked" : "";
        //  console.log(groupStateChecked );
            //  return
      // First row with Game Type and button[0]['group_state']
      html += `
        <tr style="background:#eef;">
          <td style="background:#eee;">${gameplay}</td>
              <td colspan="6" style="background:#eee;">
              <label class="switch"  style="left:88%;">
                <input type="checkbox" class="form-check-input gamestates" value='' datas='${groupItems[0]['game_group']}' role="switch" ${groupStateChecked }>
                <span class="slider"></span>
              </label>
            </td>
        </tr>
      `;

      // Rows for each item
      groupItems.forEach(item => {
        // Determine checkbox & slider states based on your logic
        let isChecked = item.state === "active" ? "checked" : "";
        let isCheck = item.totalbetpercentage === "100" ? "" : "checked";
        let disableslider = item.totalbetpercentage === "100" ? "disabled" : "";

        html += `
          <tr>
            <td></td> <!-- empty Game Type cell -->
            <td>${item.group_type}</td>
            <td>${item.label ?? item.name}</td>
            <td>
              <input type="text" class="form-control oddsone" value="${item.currentodds}" data-original="${item.mainSubOdds ?? item.mainOdds}" readonly>
              <br>
              <input type="range" class="rangeSliderone" min="0" max="100" value="${item.subOddsPercentage ?? item.oddspercentage}">
              <span class="rangeValue" style="margin-left:10px">${item.subOddsPercentage ?? item.oddspercentage}%</span>
            </td>

            <td>
              <label class="switches">
                <input type="checkbox" class="resetCheckbox" value='${item.gn_id}' datas='${item.model}' ${isCheck}/>
                <span class="slider1"></span>
              </label>
            </td>

            <td>
              <input type="text" class="form-control oddsoness" value="${item.standardtotalbets}" data-original="${item.total_bets}" readonly>
              <br>
              <input type="range" class="rangeSlideroness" min="0" step="0.1" max="100" value="${item.totalbetpercentage}" ${disableslider}/>
              <span class="rangeValues" style="margin-left:10px">${item.totalbetpercentage}%</span>
            </td>

            <td>
              <label class="switch">
                <input type="checkbox" class="form-check-input gamestatus" value='${item.gn_id}' datas='${item.model}' role="switch" ${isChecked}>
                <span class="slider"></span>
              </label>
            </td>

            <td>
              <button type="button" class="btn btn-light updatethis saveBtn" value='${item.subgame_id ??item.gn_id}|${item.isSpecial}' datas='${item.model}'>${SaveText}</button>
            </td>
          </tr>
        `;
      });
    }
    }
  
    return html;
  };

  const renderLotteryParams = (data) => {
    var html = lotteryParamTable(data);
      tableScrollBonus();
    $("#game_name_container").html(html);

  };

  function getTranslation(key) {
    const span = document.getElementById(`trans-${key.replace(/\s+/g, "")}`);
    return span?.dataset.translation || key;
  }

  // Use in HTML

  async function getAllGamesLottery() {
    try {
      const response = await fetch(`../game/getAllGamesLottery`);
      const data = await response.json();
      let html = "";
      let translatedSelectGame = getTranslation("Select Game");
      html += `<option>${translatedSelectGame}</option>`;
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

  function addTabStyle(contentEl,elem) {
    TabMap.set(contentEl,elem);
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

  async function getLotteryGames(lotterId, models,gametypes) {
    try {
      const response = await fetch(`../game/getLotteryGames/${lotterId}/${models}/${gametypes}`);
      const data = await response.json();
      // console.log(data);
       // return
         renderLotteryParams(data.bonus);
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  let gametypes
  $(document).on("click", ".executegetparams", function () {
    let lotteryId = $("#allGameNamesLottery").val();
    let models = $("#allmodels").val();
     gametypes= $(".gamebonus").val().split("|")[0];
     console.log(lotteryId, models, gametypes);
    // return
    // console.log(lotteryId, models);
    if (models == "twosides" || models === "boardgames" || models === "fantan"){
  
          return;
    }
  
    getLotteryGames(lotteryId, models,gametypes);
  });

    const toArray = (val) => {
      if (Array.isArray(val)) return val;

      try {
        const parsed = JSON.parse(val);
        if (Array.isArray(parsed)) return parsed;
        if (typeof parsed === 'number') return [parsed];
      } catch (e) {
        // Fallback if not valid JSON
      }
      const num = parseFloat(val);
      return isNaN(num) ? [] : [num];
    };

  //max slide

  $(document).on("input", ".rangeSliderone, .rangeSlideroness", function () {
    let row = $(this).closest("tr"); // Get the closest table row
    let percentageOne = row.find(".rangeSliderone").val(); // First slider value
    let percentageTwo = row.find(".rangeSlideroness").val(); // Second slider value
    let rawValue = row.find(".oddsone").attr("data-original");
     let originalValuesOne = toArray(rawValue);
    //let originalValuesOne = JSON.parse(row.find(".oddsone").attr("data-original")); // Get original array values
    let originalValueTwo = parseFloat( row.find(".oddsoness").attr("data-original")); // Get original value
    let lastModifiedValuesOne = JSON.parse(row.attr("data-last-modified-values-one") || JSON.stringify(originalValuesOne));
    let lastModifiedValueTwo = parseFloat(row.attr("data-last-modified-value-two") || originalValueTwo );

    let scaledValuesOne, scaledValueTwo;

    // Check if first slider is at 100%, reset to original values
    if (percentageOne === "100") {
      scaledValuesOne = [...originalValuesOne];
    } else {
      scaledValuesOne = lastModifiedValuesOne.map((value) =>
        Math.round((value * percentageOne) / 100)
      );
    }
   // return

    row.find(".oddsone").val(JSON.stringify(scaledValuesOne)); // Update input field
    row.find(".rangeValue").text(percentageOne + "%");

    // Check if second slider is at 100%, reset to original value
    if (percentageTwo === "100") {
      scaledValueTwo = originalValueTwo;
    } else {
      scaledValueTwo = Math.round((lastModifiedValueTwo * percentageTwo) / 100);
    }

    row.find(".oddsoness").val(scaledValueTwo); // Update input field
    row.find(".rangeValues").text(percentageTwo + "%");

    // // Store updated values
    row.attr("data-updated-percentage-one", percentageOne);
    row.attr("data-updated-percentage-two", percentageTwo);
    row.attr("data-updated-values-one", JSON.stringify(scaledValuesOne));
    row.attr("data-updated-value-two", scaledValueTwo);
 //    console.log(row.attr("data-updated-values-one"))
    //console.log(row.attr("data-updated-value-two"));
  });

  // Reset checkbox functionality
  $(document).on("change", ".resetCheckbox", function () {
    let row = $(this).closest("tr");
    let isChecked = $(this).is(":checked");
    let gametypeId = $(this).val().split("|")[0]
    let gamemodel = $(this).attr("datas");
    row.find(".rangeSlideroness").prop("disabled", !isChecked);

    // console.log(gametypeId,gamemodel)

    if (!isChecked) {
      row.find(".rangeSlideroness").val(100);
      row.find(".rangeValues").text("100%");
      row.find(".oddsoness").val(row.find(".oddsoness").attr("data-original"));

      // Getting the values
      let rangeSliderValue = row.find(".rangeSlideroness").val();
      // let rangeTextValue = row.find(".rangeValues").text();
      let toatalbetValue = row.find(".oddsoness").val();

      resettotalbet(gametypeId, gamemodel, rangeSliderValue, toatalbetValue,gametypes);
    }
  });

  async function resettotalbet( gametypeId, gamemodel,toatalbetValue,rangeSliderValue,gametypes) {
    try {
      const response = await fetch(`../admin/resettotalbet/${gametypeId}/${gamemodel}/${toatalbetValue}/${rangeSliderValue}/${gametypes}`);
      const data = await response.json();
      if (data) {
        // showToast("Success", "updated succesfully", "success");
        showToast(SUCCESS_TEXT, UPDATED_SUCCESSFULLY, "success");
        // getLotteryGames(gametypeId, gamemodel)
      }
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  // Save button functionality
  $(document).on("click", ".saveBtn", function () {
    let row = $(this).closest("tr");
    let percentageOne = row.attr("data-updated-percentage-one");
    if (percentageOne == undefined) {
      // showToast("Success", "no changes made", "info");
     showToast(SUCCESS_TEXT, NO_CHANGES_MADE, "info");
      return;
    }
    let percentageTwo = row.attr("data-updated-percentage-two");
    let scaledValuesOne = JSON.parse(row.attr("data-updated-values-one") ||row.find(".oddsone").attr("data-original"));
    let scaledValueTwo =row.attr("data-updated-value-two") ||row.find(".oddsoness").attr("data-original");
    let gametypeId = $(this).val().split("|")[0]; // Extract gametypeId from button value
    let isSpecial = $(this).val().split("|")[1]; // Extract isSpecial from button value
    let gamemodel = $(this).attr("datas");
   
    updateoddstotalbets(gametypeId,gamemodel,percentageOne,scaledValuesOne,percentageTwo,scaledValueTwo,gametypes,isSpecial);
  });

  async function updateoddstotalbets(gametypeId,gamemodel,percentageOne,scaledValuesOne, percentageTwo, scaledValueTwo,gametypes,isSpecial) {
    try {
      const response = await fetch( `../game/updateoddstotalbets/${gametypeId}/${gamemodel}/${percentageOne}/${scaledValuesOne}/${percentageTwo}/${scaledValueTwo}/${gametypes}/${isSpecial}`);
      const data = await response.json();
      if (data.success) {
        // showToast("Success", "updated succesfully", "success");
        showToast(SUCCESS_TEXT, UPDATED_SUCCESSFULLY, "success");
      }
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  // Game status
  $(document).on("change", ".gamestatus", function () {
    let isChecked = $(this).is(":checked") ? "active" : "inactive"; // Determine status
    let gametypeId = $(this).val();
    let gamemodel = $(this).attr("datas");
    //console.log(gametypeId, gamemodel, isChecked);
    updateGameStatus(gametypeId, gamemodel, isChecked);
  })

  $(document).on("change", ".gamestates", function () {
     let states = $(this).is(":checked") ? "active" : "inactive"; // Determine status
    let gamegroupid = $(this).attr("datas");
    $.post(`../game/updategamegroup/${gamegroupid}/${states}`,function(response){
         const data = JSON.parse(response);
         if (data.success) {
        showToast(SUCCESS_TEXT, GAME_STATE_UPDATED, "success"); 
        }else {
        return false;
       }   
     })
  })

   $(document).on("change", ".gameslottery", function () {
     let lotterystate = $(this).is(":checked") ? "active" : "inactive"; // Determine status
     let lotteryid = $(this).attr("datas");
      $.post(`../game/updategamelottery/${lotteryid}/${lotterystate}`,function(response){
         const data = JSON.parse(response);
         if (data.success) {
        showToast(SUCCESS_TEXT, GAME_STATE_UPDATED, "success"); 
        }else {
        return false;
       }   
     })
  })
  

  async function updateGameStatus(gametypeId, gamemodel, isChecked) {
    try {
      const response = await fetch(`../game/updategamestatus/${gametypeId}/${gamemodel}/${isChecked}`);
      const data = await response.json();
      // console.log(data);
      if (data.success) {
        // Ensure the backend sends { success: true } when the update is successful
        // showToast("Success", "Game state updated", "info");
      showToast(SUCCESS_TEXT, GAME_STATE_UPDATED, "success");

      } else {
        return false;
      }
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }


$(document).on("change", "#allGameNamesLottery", function () {
    let selectedValue = $(this).val();
   // console.log("Selected Lottery Type:", selectedValue);

     const selectedType = Number(selectedValue); // convert to number

    // 1. Filter lottery names based on selectedType
    fetch(`../admin/fetchLotteryname/${partnerID}`)
        .then((res) => res.json())
        .then((data) => {
            let html = "";
            data.forEach((lottery) => {
                if (Number(lottery.lottery_type) === selectedType) {
                    html += `<option value="${lottery.gt_id}|${lottery.lottery_type}">${lottery.name}</option>`;
                }
            });

            if (html === "") {
                html = `<option value="">No lotteries available</option>`;
            }

            $(".gamebonus").html(html);
        })
        .catch((err) => {
            console.error("Error filtering lotteries:", err);
        });
    // 2. Populate the model types dropdown as usual
    const optionsMap = {
        1: ["Standard", "Twosides", "Logdragon", "BoardGames", "Manytables", "Roadbet", "Fantan"],
        2: ["Standard", "Twosides", "Logdragon", "BoardGames", "Roadbet", "Fantan"],
        3: ["Standard", "Twosides", "Logdragon", "BoardGames", "Manytables", "Fantan"],
        5: ["Standard", "Twosides", "Logdragon", "Roadbet"],
        6: ["Standard", "Twosides", "Logdragon", "BoardGames", "Manytables", "Roadbet"],
        8: ["Standard", "Twosides", "Logdragon", "BoardGames", "Roadbet", "Fantan"],
        10: ["Standard", "Twosides", "Logdragon", "BoardGames", "Roadbet", "Fantan"],
        11: ["Standard", "Twosides", "Logdragon", "BoardGames", "Roadbet", "Fantan"]
    };

    const getGameTranslation = (key) => {
     const span = document.getElementById(`trans-${key}`);return span?.dataset.translation || key};
     const secondDropdown = $("#allmodels");
     secondDropdown.empty();
     const options = optionsMap[selectedValue] || [];
    options.forEach((gameKey) => { const translatedLabel = getGameTranslation(gameKey); secondDropdown.append(new Option(translatedLabel, gameKey.toLowerCase()));
    });
});



  // reset all odds
  $(document).on("click", ".resetodds", function () {
    //  $("#maskrfeferal").LoadingOverlay("show", {
    //      background: "rgb(90,106,133,0.1)", size: 3,
    //    });
    $.post(`../game/resetallodds`, function (response) {
       
     const data = JSON.parse(response);
      console.log(data);
     // return
      if (data.status === "success") {
        showToast(SUCCESS_TEXT, UPDATED_SUCCESSFULLY, "success");
           $("#maskrfeferal").LoadingOverlay("hide");
        // Optionally, you can refresh the lottery games after resetting odds
        // let lotteryId = $("#allGameNamesLottery").val();
        // let models = $("#allmodels").val();
        // gametypes= $(".gamebonus").val().split("|")[0];
        // getLotteryGames(lotteryId, models,gametypes);
      } else {
        showToast("Error", "Failed to reset odds", "error");
           $("#maskrfeferal").LoadingOverlay("hide");
      }
    } )
  });


 


  // Sticky header for bonus table
  function tableScrollBonus() {
    const tableContainerBonus = document.querySelector(".table-wrapperbonus");
    const headerRowBonus = document.querySelector(".headrowbonus");

    if (tableContainerBonus && headerRowBonus) {
      tableContainerBonus.addEventListener("scroll", function () {
        if (tableContainerBonus.scrollTop > 0) {
          headerRowBonus.classList.add("sticky-headerbonus");
        } else {
          headerRowBonus.classList.remove("sticky-headerbonus");
        }
      });
    }
  }
  // Initialize sticky scroll
  tableScrollBonus();

  //
});
