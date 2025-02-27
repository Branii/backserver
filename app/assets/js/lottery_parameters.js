$(function () {
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
          duration: 3000, // auto-dismiss after 3s
      });
  }

  const lotteryParamTable = (data) => {

      let html = "";
      data.forEach((item) => {

          html += `
          <tr class="trow">
              <td>${item.gameplay_name}</td>
              <td>${item.group_type}</td>
              <td>${item.name}</td>
                 data-updated-percentage-one
                <td>
                <input type="text" class="form-control oddsone" value="${item.modified_odds}" data-original="${item.odds}" readonly>
                    <br>
                <input type="range" class="rangeSliderone" min="0" max="100" value="${item.oddspercentage}">
                <span class="rangeValue" style="margin-left:10px">${item.oddspercentage}%</span>
                </td>
                  <td>
                <div class="form-check form-switch mb-0">
                <input class="form-check-input resetCheckbox" style="width:40px;margin:auto"type="checkbox" role="switch" checked/>
                </div>
              </td>

                <td>
                <input type="text" class="form-control oddsoness" value="${item.modified_totalbet}" data-original="${item.total_bets}" readonly>
                    <br>
                <input type="range" class="rangeSlideroness" min="0" max="100" value="${item.totalbetpercentage}">
                <span class="rangeValues" style="margin-left:10px">${item.totalbetpercentage}%</span>
                </td>
                
               
      
                  <td> <button type="button" class="btn btn-light updatethis saveBtn" value ='${item.gn_id}' datas= '${item.model}' >Save</button></td>
          </tr>
      `;
      });
      return html;
  };

  const renderLotteryParams = (data) => {
      var html = lotteryParamTable(data);
      $('#game_name_container').html(html);
      $(document).trigger("dataLoaded");
   
  };

  async function getAllGamesLottery() {
      try {
          const response = await fetch(`../admin/getAllGamesLottery`);
          const data = await response.json();
         //  console.log(data);
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

  async function getLotteryGames(lotterId, models) {
      try {
          const response = await fetch(`../admin/getLotteryGames/${lotterId}/${models}`);
          const data = await response.json();
        //  console.log(response);
          renderLotteryParams(data.bonus);
     
      } catch (error) {
          console.error("Error fetching data:", error);
      }
  }

  $(document).on("click", ".executegetparams", function () {
      let lotteryId = $("#allGameNamesLottery").val();
      let models = $("#allmodels").val();

      if(models == "twosides") return;

      getLotteryGames(lotteryId,models);
 
  });

  //max slide
  $(document).ready(function() {
   
  $(document).on("input", ".rangeSliderone, .rangeSlideroness", function () {
    let row = $(this).closest("tr"); // Get the closest table row
    let percentageOne = row.find(".rangeSliderone").val(); // First slider value
    let percentageTwo = row.find(".rangeSlideroness").val(); // Second slider value

    let originalValuesOne = JSON.parse(row.find(".oddsone").attr("data-original")); // Get original array values
    let originalValueTwo = parseFloat(row.find(".oddsoness").attr("data-original")); // Get original value
    let lastModifiedValuesOne = JSON.parse(row.attr("data-last-modified-values-one") || JSON.stringify(originalValuesOne));
    let lastModifiedValueTwo = parseFloat(row.attr("data-last-modified-value-two") || originalValueTwo);

    let scaledValuesOne, scaledValueTwo;

    // Check if first slider is at 100%, reset to original values
    
    if (percentageOne === "100") {
      scaledValuesOne = [...originalValuesOne]; 
  } else {
      scaledValuesOne = lastModifiedValuesOne.map(value => Math.round((value * percentageOne) / 100));
  }

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
    //console.log(row.attr("data-updated-value-two"))
   // console.log(row.attr("data-updated-percentage-two"))
});



    // Reset checkbox functionality
    $(document).on("change", ".resetCheckbox", function() {
        let row = $(this).closest("tr");
        let isChecked = $(this).is(":checked");

        row.find(".rangeSlideroness").prop("disabled", !isChecked);

        if (!isChecked) {
            row.find(".rangeSlideroness").val(100);
            row.find(".rangeValues").text("100%");
            row.find(".oddsoness").val(row.find(".oddsoness").attr("data-original"));
        }
    });

    // Save button functionality
    $(document).on("click", ".saveBtn", function() {
      let row = $(this).closest("tr");
      let percentageOne = row.attr("data-updated-percentage-one");
      if(percentageOne == undefined){
        showToast("Success", "no changes made", "info");
        return
      }
       let percentageTwo = row.attr("data-updated-percentage-two");
       let scaledValuesOne = JSON.parse(row.attr("data-updated-values-one") || row.find(".oddsone").attr("data-original"));
       let scaledValueTwo = row.attr("data-updated-value-two") || row.find(".oddsoness").attr("data-original");
       let gametypeId = $(this).val();
        let gamemodel = $(this).attr("datas");
        // console.log("Saving:", { percentageOne,scaledValuesOne});
        updateoddstotalbets(gametypeId,gamemodel,percentageOne,scaledValuesOne,percentageTwo,scaledValueTwo)
 
        getLotteryGames(gametypeId, gamemodel)
    });

});

  
    async function updateoddstotalbets(gametypeId,gamemodel,percentageOne,scaledValuesOne,percentageTwo,scaledValueTwo) {
      try {
          const response = await fetch(`../admin/updateoddstotalbets/${gametypeId}/${gamemodel}/${percentageOne}/${scaledValuesOne}/${percentageTwo}/${scaledValueTwo}`);
          const data = await response.json();
          if(data){
            showToast("Success", "updated succesfully", "success");
          }
         
         //  console.log(response);
          // renderLotteryParams(data.data);
           return
         
      } catch (error) {
          console.error("Error fetching data:", error);
      }
  }

  function tableScrollBonus() {
    const tableContainerBonus = document.querySelector(".table-wrapperbonus");
    const headerRowBonus = document.querySelector(".headrowbonus");

    tableContainerBonus.addEventListener("scroll", function () {
        if (tableContainerBonus.scrollTop > 0) {
            headerRowBonus.classList.add("sticky-headerbonus");
        } else {
            headerRowBonus.classList.remove("sticky-headerbonus");
        }
    });
}

tableScrollBonus()

});
