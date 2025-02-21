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

             
                <td>
                <input type="text" class="form-control oddsone" value="${item.modified_odds}" data-original="${item.modified_odds}" readonly>
                <input type="range" class="rangeSliderone" min="0" max="100" value="100">
                <span class="rangeValue">100%</span>
                </td>
                <td>
                <input type="text" class="form-control oddsoness" value="${item.modified_totalbet}" data-original="${item.modified_totalbet}" readonly>
                <input type="range" class="rangeSlideroness" min="0" max="100" value="100">
                <span id="rangeValues">100%</span>
                </td>
                <td>
                <input type="checkbox" class="resetCheckbox"> Reset to Original Value
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
          // //
        //  console.log(response);
          renderLotteryParams(data.bonus);
          // return
          //Object.entries(data).forEach(([key, value]) => {
           //    console.log(`${key}: ${value}`);
             // renderLotteryParams(data);
       //   });
      } catch (error) {
          console.error("Error fetching data:", error);
      }
  }

  $(document).on("click", ".executegetparams", function () {
      let lotteryId = $("#allGameNamesLottery").val();
      let models = $("#allmodels").val();

      getLotteryGames(lotteryId,models);
 
  });

  //max slide
  $(document).ready(function() {
    // Update first slider values per row
  //   $(document).on("input", ".rangeSliderone", function() {
  //     let row = $(this).closest("tr");
  //     let percentage = $(this).val();
  //     row.find(".rangeValue").text(percentage + "%");

  //     let originalValues = JSON.parse(row.find(".oddsone").attr("data-original-values"));
  //     let updatedValues = originalValues.map(value => Math.round((value * percentage) / 100));

  //     row.find(".oddsone").val(`[${updatedValues.join(", ")}]`);
  // });

  //   // Update second slider value per row
  //   $(document).on("input", ".rangeSlideroness", function() {
  //     let row = $(this).closest("tr");
  //     let percentage = $(this).val();
  //     row.find(".rangeValues").text(percentage + "%");

  //     // Convert to number before performing calculations
  //     let originalValue = Number(row.find(".oddsoness").attr("data-original-value"));
  //     let updatedValue = Math.round((originalValue * percentage) / 100);

  //     row.find(".oddsoness").val(updatedValue);
  // });

//   $(document).on("input", ".rangeSliderone, .rangeSlideroness", function () {
//     let row = $(this).closest("tr"); // Get the closest table row
//     let percentageOne = row.find(".rangeSliderone").val(); // First slider value
//     let percentageTwo = row.find(".rangeSlideroness").val(); // Second slider value

//     let originalValuesOne = JSON.parse(row.find(".oddsone").attr("data-original")); // Get original array values
//     let originalValueTwo = parseFloat(row.find(".oddsoness").attr("data-original")); // Get original value

//     let scaledValuesOne, scaledValueTwo;

//     // Check if first slider is at 100%, reset to original values
//     if (percentageOne === "100") {
//         scaledValuesOne = [...originalValuesOne];
//     } else {
//         scaledValuesOne = originalValuesOne.map(value => Math.round((value * percentageOne) / 100));
//     }
    
//     row.find(".oddsone").val(JSON.stringify(scaledValuesOne)); // Update input
//     row.find(".rangeValue").text(percentageOne + "%");

//     // Check if second slider is at 100%, reset to original value
//     if (percentageTwo === "100") {
//         scaledValueTwo = originalValueTwo;
//     } else {
//         scaledValueTwo = Math.round((originalValueTwo * percentageTwo) / 100);
//     }
    
//     row.find(".oddsoness").val(scaledValueTwo); // Update input
//     row.find("#rangeValues").text(percentageTwo + "%");

//     // Store updated values
//     row.attr("data-updated-percentage-one", percentageOne);
//     row.attr("data-updated-percentage-two", percentageTwo);
//     row.attr("data-updated-values-one", JSON.stringify(scaledValuesOne));
//     row.attr("data-updated-value-two", scaledValueTwo);
// });

$(document).on("input", ".rangeSliderone, .rangeSlideroness", function () {
  let row = $(this).closest("tr"); // Get the closest table row
  let percentageOne = parseFloat(row.find(".rangeSliderone").val()); // First slider value
  let percentageTwo = parseFloat(row.find(".rangeSlideroness").val()); // Second slider value

  let originalValuesOne = JSON.parse(row.find(".oddsone").attr("data-original")); // Get original array values
  let originalValueTwo = parseFloat(row.find(".oddsoness").attr("data-original")); // Get original value

  let scaledValuesOne, scaledValueTwo;

  // If first slider is at 100%, reset to original values; otherwise, scale
  scaledValuesOne = (percentageOne === 100) 
      ? [...originalValuesOne] 
      : originalValuesOne.map(value => Math.round((value * percentageOne) / 100));

  row.find(".oddsone").val(JSON.stringify(scaledValuesOne)); // Update input field
  row.find(".rangeValue").text(percentageOne + "%");

  // If second slider is at 100%, reset to original value; otherwise, scale
  scaledValueTwo = (percentageTwo === 100) 
      ? originalValueTwo 
      : Math.round((originalValueTwo * percentageTwo) / 100);

  row.find(".oddsoness").val(scaledValueTwo); // Update input field
  row.find(".rangeValues").text(percentageTwo + "%");

  // Store updated values for reference
  row.attr({
      "data-updated-percentage-one": percentageOne,
      "data-updated-percentage-two": percentageTwo,
      "data-updated-values-one": JSON.stringify(scaledValuesOne),
      "data-updated-value-two": scaledValueTwo
  });
});


    // Reset checkbox functionality
    $(document).on("change", ".resetCheckbox", function() {
        let row = $(this).closest("tr");
        let isChecked = $(this).is(":checked");

        row.find(".rangeSlideroness").prop("disabled", !isChecked);

        if (!isChecked) {
            row.find(".rangeSlideroness").val(100);
            row.find(".rangeValues").text("100%");
            row.find(".oddsoness").val(row.find(".oddsoness").attr("data-original-value") || row.find(".oddsoness").val());
        }
    });

    // Save button functionality
    $(document).on("click", ".saveBtn", function () {
      let row = $(this).closest("tr");
  
      let percentageOne = row.attr("data-updated-percentage-one") || "100";
      let percentageTwo = row.attr("data-updated-percentage-two") || "100";
  
      let scaledValuesOne = JSON.parse(row.attr("data-updated-values-one") || row.find(".oddsone").attr("data-original"));
      let scaledValueTwo = parseFloat(row.attr("data-updated-value-two") || row.find(".oddsoness").attr("data-original"));
  
      let gametypeId = $(this).val();
      let gamemodel = $(this).attr("datas");
  
      console.log("Saving:", { percentageOne, scaledValuesOne, percentageTwo, scaledValueTwo, gametypeId, gamemodel });
  
      updateoddstotalbets(gametypeId, gamemodel, percentageOne, scaledValuesOne, percentageTwo, scaledValueTwo);
  });

});

  
async function updateoddstotalbets(gametypeId, gamemodel, percentageOne, scaledValuesOne, percentageTwo, scaledValueTwo) {
  try {
      const response = await fetch(`../admin/updateoddstotalbets/${gametypeId}/${gamemodel}/${percentageOne}/${JSON.stringify(scaledValuesOne)}/${percentageTwo}/${scaledValueTwo}`, {
          method: "GET",
          headers: { "Content-Type": "application/json" }
      });

      if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
      }

      const data = await response.json();

      if (data.success) {
          console.log("Update successful!", data.updatedData);

          let row = $(`tr`).find(`[value='${gametypeId}']`).closest("tr");
          let updatedData = data.updatedData; // Assuming this is the returned data

          row.find(".oddsone").val(updatedData.modified_odds);
          row.find(".oddsoness").val(updatedData.modified_totalbet);
          row.find(".rangeSliderone").val(updatedData.oddspercentage);
          row.find(".rangeSlideroness").val(updatedData.totalbetpercentage);
          row.find(".rangeValue").text(updatedData.oddspercentage + "%");
          row.find(".rangeValues").text(updatedData.totalbetpercentage + "%");
      } else {
          console.warn("Update failed:", data.message);
      }
  } catch (error) {
      console.error("Error updating values:", error);
  }
}

//   function fetchValues() {
//     $.ajax({
//         url: "../admin/getLotteryGames/${lotterId}/${models}",
//         method: "GET",
//         success: function (response) {
//             let data = JSON.parse(response);

//             $("tr").each(function () {
//                 let row = $(this);
//                 let gametypeId = row.find(".saveBtn").val();

//                 let rowData = data.find(item => item.gametypeId == gametypeId);
//                 if (!rowData) return;

//                 // Set fetched values
//                 row.find(".oddsone").val(rowData.scaledValuesOne);
//                 row.find(".oddsoness").val(rowData.scaledValueTwo);

//                 // Set sliders to their correct percentage
//                 row.find(".rangeSliderone").val(rowData.percentageOne);
//                 row.find(".rangeSlideroness").val(rowData.percentageTwo);

//                 // Update displayed percentage text
//                 row.find(".rangeValue").text(rowData.percentageOne + "%");
//                 row.find(".rangeValues").text(rowData.percentageTwo + "%");
//             });
//         }
//     });
// }


});
