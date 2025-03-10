$(() =>{

  const BASE_URL = '../admin';
  let historyStack  = [];
  let pagesStack    = [];
  let pagingInfo    = [];
 
  function showToast(title, message, type) {
      $.toast({
        position: "bottom-right",
        title: title,
        message: message,
        type: type,
        duration: 3000, // auto-dismiss after 3s
      });
    }

    $(document).on("click",".update-gamegroup",function(){
      const gameItems =  $($($(this).parents(".lbp-gamegroup-wrapper")[0]).find(".lbp-gameitem-wrapper")[0]).find(".lbp-gameitem-parent");
      let data = [];
      for (let index = 0; index < gameItems.length; index++) {
        const element      = gameItems[index];
        const labelid      = $(element).attr("id").split("-")[1];
        const odds         = $(`#lbp-odds-${labelid}`).val();
        const maxAmt       = $(`#lbp-max-amt-${labelid}`).val();
        const maxTotAmt    = $(`#lbp-max-tot-amt-${labelid}`).val();
        data.push({labelid: labelid,odds: odds,max_amt: maxAmt, max_tot_amt: maxTotAmt});
      }



      data = JSON.stringify(data);
      $.ajax({
        url: `../admin/updateGameGroupData/${data}`,
        type: "GET",
        beforeSend: function () {
            // $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
        },
        success: function (response) {
          if(response === "Game id not found!!"){
            showToast("Error", "Sorry the lottery selected is not yet ready.", "error");
            return;
          }
         
          if (response.status === "error") {
            showToast("Error", "Lottery Data Successfully Updated.","error");
            return;
          }
  
          if(data == 0){
            showToast("Error", "Nothing to update","error");
            return;
          }

          showToast("Success", "Lottery Bonus Parameter Successfully updated.", 'success');
        },
        error: function (res, status, error) {
          $(".dataholder").html(
            "<tr><td colspan='12' style='text-align:center;'>An error occured, please try again later.</td></tr>"
          );
        },
        complete: function () {
            // $($(element).find("i")[0]).addClass("bx-check-double").removeClass("bx-loader bx-spin");
        },
      });
  
  


   });

    $(document).on('click', '#lbp_search',function(){

      const lotteryType      = $('#allGameNamesLottery').val();
      let lotteryTextCaps        = $("#allGameNamesLottery option:selected").text();
      let lotteryText        = $("#allGameNamesLottery option:selected").text().toLowerCase()
      const lotteryModel     = $("#allmodels").val();
      const lotteryGameGroup = $("#game_groups").val();
      // if(lotteryModel == undefined || lotteryType == undefined || lotteryGameGroup == undefined) return;
      const element = this;

      let url = "";
      if(lotteryModel === "twosides"){
         url = `https://winsstarts.com/chairman_test/api/v1/limvo/twosides?lottery_type_id=${lotteryType}`;
      }else if(lotteryModel === "boardgames"){
        if(lotteryText === "11x5") lotteryText = "eleven5";
        url = `https://winsstarts.com/chairman_test/api/v1/limvo/boardgame_games/${lotteryText}`;
      }

      $.ajax({ 
          url: url,
          type: "GET",
          beforeSend: function () {
              $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
          },
          success: function (response) {
            if(response === "Game id not found!!"){
              showToast("Error", "Sorry the lottery selected is not yet ready.", "error");
              return;
            }
            if(lotteryModel === "twosides"){
              // console.log(response[lotteryType]);
              response = response[lotteryType];
              const gameGroup = response[lotteryGameGroup];
              $("#lbp_twosides").html(twosidesUI(gameGroup));
            }else if(lotteryModel === "boardgames"){
             lotteryText = lotteryTextCaps === "Mark6" || lotteryTextCaps === "Happy8" ? lotteryTextCaps : lotteryText;
              // console.log(lotteryText);
              // console.log(response)
             response = response[lotteryText];
              // console.log(response);
             const gameGroups = boardGamesGameGroups[lotteryText];
              // console.log(gameGroups);
           
              const groupNames = Object.keys(gameGroups);
              console.log(groupNames);
              // console.log(response);
              let markup = "";
              groupNames.forEach((groupName) => {
                let gameNames = gameGroups[groupName];
                if(gameNames.length > 0){
                     gameNames.forEach((gameName) =>{
                  markup += boardGamesMarkup(response[groupName][gameName],gameName);
                 }); 
                }else{
                  markup += boardGamesMarkup(response[groupName],groupName);
              
                }
               
              });
              // console.log(markup);
              $("#lbp_boardgames").html(markup);
            }
          
          },
          error: function (res, status, error) {
            $(".dataholder").html(
              "<tr><td colspan='12' style='text-align:center;'>An error occured, please try again later.</td></tr>"
            );
          },
          complete: function () {
              $($(element).find("i")[0]).addClass("bx-check-double").removeClass("bx-loader bx-spin");
          },
        });
    
    

      $("#lbl_twosides").prepend();
       

    });


    $(document).on('change', '.lpd-update-lottery',function(){

      const gameID = $(this).attr("id").split("-")[2];
      const element = this;
      $.ajax({ 
          url: `../admin/toggleTwosidesLotteryState/${gameID}`,
          type: "POST",
          beforeSend: function () {
              $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
          },
          success: function (response) {
            response = JSON.parse(response);
            if(response.status === "error"){
              $(element).prop("checked", !$(element).prop("checked"));
              showToast("Error", response.data, "error");
              return;
            }

            if(response.data == 0){
              $(element).prop("checked", !$(element).prop("checked"));
              showToast("Error", "Update unsuccessfull, please try again later.", "error");
              return
            }

            showToast("Success", "Lottery Data updated successfully.", "success");

          },
          error: function (res, status, error) {
            showToast("Error", "Request error, please try again later.", "error");
          },
          complete: function () {
           
          },
        });
    
    

      $("#lbl_twosides").prepend();
       

    });



    $(document).on("change","#allmodels,#allGameNamesLottery",function(){

      const lotteryModel = $("#allmodels").val();
      $(".lpd-table-wrappers").hide();
      $("#game_groups").hide();
      if(lotteryModel === "twosides"){
        const lotteryType = $("#allGameNamesLottery").val();
        let html = "";
        const lotteryGameGroups = gameGroups[parseInt(lotteryType)];
        if(lotteryGameGroups === undefined) return ;
        lotteryGameGroups.forEach((element,index) => {
           html += `<option value="${gameGroupsName[lotteryType][index]}"> ${element}</option>`;
        });
        $("#game_groups").html(html);
        $("#game_groups").show();
        $("#lbp_twosides").show();

      }else if(lotteryModel === "boardgames"){
        $("#lbp_boardgames").show();
      }else if(lotteryModel === "standard"){
         $("#game_groups").hide();
         $("#maskrfeferal").show();
      }
         

    });

  });


const sanitizeGameGroupName = (name) => name.toLowerCase(name.replace(" ","_"));
  
const gameGroups =  {
1: ["Rapido", "All Kinds"],
2: ["Rapido", "2 sides", "Fixed Place", "Sum of Top Two"],
3: ["All Kinds", "Fish/Prawn/Crab"],
5: [
  "Rapido",
  "2 sides",
  "1 No. Combo",
  "2 No. Combo",
  "3 No. Combo",
  "Fixed Place 1 No.",
  "Fixed Place 2 No.",
  "Fixed Place 3 No.",
  "Sum of 2 No.",
  "Sum of 3 No.",
  "Group 3",
  "Group 6",
  "Span",
],
6: ["Rapido", "2 sides", "Pick", "Straight"],
8: [
  "Rapido",
  "Extra No.",
  "Ball No.",
  "Specific No.",
  "Row Zodiac Row tail",
  "Row No.",
  "Zodiac&tail",
  "Sum",
  "Optional",
  "Mismatch",
],
10: ["2 sides", "Ball No"],
}
const gameGroupsName =  {
1: ["Rapido" , "all_kinds"],
2: ["Rapido", "2sides", "Fixed Place", "Sum of Top Two"],
3: ["all_kinds", "Fish/Prawn/Crab"],
5: [
  "Rapido",
  "2sides",
  "1 No. Combo",
  "2 No. Combo",
  "3 No. Combo",
  "Fixed Place 1 No.",
  "Fixed Place 2 No.",
  "Fixed Place 3 No.",
  "Sum of 2 No.",
  "Sum of 3 No.",
  "Group 3",
  "Group 6",
  "Span",
],
6: ["Rapido", "2sides", "Pick", "Straight"],
8: [
  "Rapido",
  "Extra No.",
  "Ball No.",
  "Specific No.",
  "Row Zodiac Row Tail",
  "Row No.",
  "Zodiac&tail",
  "Sum",
  "Optional",
  "Mismatch",
],
10: ["2sides", "Ball No"],
}


const boardGamesGameGroups =  {
"5d": {"Baccarat" : ["Baccarat"] , "Bull":["Bull","BullBSOE","DTT","Maximum","Minimum"], "Stud" : ["Stud","StudFirstThree","StudFirstTwo","StudLastThree","StudMiddleThree"]},
"pk10": {"CrownAsia":[],"GuessWinner" :[],"GuessWinner" :[],"MaximumValue" : [],"MinimunValue" : [],"Speed" : []},
"fast3":  {"combo": ["AnyTripples"], "one": ["FBSOE","Point"],"two": ["AnyTripple","AnyTwo","GuessNumber","OnePair"]},
"eleven5":  {"Tab one" : ["ElevenBSOE","ElevenBull","ElevenDTT","ElevenMax","ElevenMin"]},
"Mark6": {"Tab One" : ["ColorWave","GuessNumbers","MBSOE"],"Tab Two" : ["ElementSeven"]},
"Happy8": {"BSOE" : [], "BSOE1" : [],"HappyElements" : []},

}



const twosidesUI = (data) => {

let markup = "";
if(data.names === undefined && data.name === undefined){
  let innerMarkup = "";
  let gameID = "";
  const lottery = $("#allGameNamesLottery").val();
  const gameGroup = $("#game_groups").val();
  let title = "";
  let key = "";
  let state = "";
  let gameGroupID = "";
   data.data.forEach((element,index)=>{
    if(element.key.trim() != "P/F" ){

    
    key = element.gameid;
    if((lottery == 8  && gameGroup == "Row No.") || (lottery == 6 && gameGroup == "Pick") || (lottery == 8  && gameGroup == "Specific No.") ){
      key = element.key.trim();

    }
    
       if(index == 0){
      gameID = key;
      gameGroupID = element.gameid;
      state = element.state;
      if((lottery == 6 && gameGroup == "Pick") ||  (lottery == 8  && gameGroup == "Specific No.") ){
        title = key;
      }
    }
    if(gameID == key){
      innerMarkup += twosidesUIItem(element);
      if((lottery == 6 && gameGroup == "Pick") || (lottery == 8  && gameGroup == "Specific No.") ){
        title = key;
      }
    }else {
      markup += broadBetParentMarkup(innerMarkup,title,gameGroupID,state);
      gameID = key;
      innerMarkup = twosidesUIItem(element);
      gameGroupID = element.gameid;
      state = element.state;
    }
   if((data.data.length - 1) === index){
      markup += broadBetParentMarkup(innerMarkup,title,gameGroupID,state);
   }
  }
  });
  return markup;
}


const gamesSubNames  = data.names != undefined ? data.names : data.name;
markup = "";
gamesSubNames.forEach((subName) => {
  let innerMarkup = "";
  let subGameGroup = data[subName];
  let gameID = "";
  let state = "";
  if(subGameGroup.names === undefined){
   subGameGroup.data.forEach((element)=>{
    gameID = element.gameid;
    state = element.state;
    innerMarkup += twosidesUIItem(element);
  });
  markup += broadBetParentMarkup(innerMarkup,subName,gameID,state);
  }else{
    const subGameGroupNames = subGameGroup.names;
     subGameGroupNames.forEach((subName) => {
  let innerMarkup = "";
   subGameGroup[subName].data.forEach((element)=>{
    gameID = element.gameid;
    state = element.state;
    innerMarkup += twosidesUIItem(element);
  });
  markup += broadBetParentMarkup(innerMarkup,subName,gameID,state);
     });
     }
       
});

return markup;

};

const broadBetParentMarkup = (markup,title = "",gameID,state) => {
if(markup.length === 0) return "";
// title = title.length === 0 ? "" : `<div class="lbp-gamegroup-title"><span class="lbp-center">${title}</span></div>`;
title = title.length === 0 ? "" : `<span class="lbp-center">${title}</span>`;
return `<div class="lbp-gamegroup-wrapper"> <div class="lbp-gamegroup-title">${title}<div class="" style="
  display: flex;
  width: 13.5rem;
  align-self: end;
  position: relative;
  left: ${title.length == 0 ? "71.5rem" : "0rem"} ;
">
  <label class="lpd-switch" style="
  margin-right: 0.8rem;
"><input type="checkbox" class="lpd-form-check-input lpd-update-lottery" id="lpd-gameid-${gameID}" datas="standard" role="switch" ${state == "active" ? "checked" : ""} >
                  <span class="lpd-slider"></span>
                  </label>
  <div class="mt-3 mt-md-0 ms-auto" style="margin: 0px !important;"><button type="button" class="btn hstack gap-6  update-gamegroup" >Save</button></div></div></div><div class="lbp-gameitem-wrapper">${markup}</div></div>`
};

const twosidesUIItem = (element) => { 

// 1. Define your conditions in code (optional but cleaner)
const condition1 = isNumber(element.label) && ( $("#allGameNamesLottery").val() == 6 || ( $("#allGameNamesLottery").val() == 5 && $("#game_groups").val() == "2 No. Combo") ) && element.label < 10;

const condition2 = isNumber(element.label) && ( $("#allGameNamesLottery").val() == 5 && $("#game_groups").val() == "3 No. Combo") && element.label < 10;

const condition3 = element.label < 100 && element.label > 9 && $("#game_groups").val() != "2 No. Combo" && $("#allGameNamesLottery").val() == 5 ;

// 2. Use if / else if / else
let displayedValue;
if (condition1) {
// console.log(element.key,element.label);
displayedValue = `0${element.label}`;
} else if (condition2) {
displayedValue = `00${element.label}`;
} else if (condition3) {
displayedValue = `0${element.label}`;
} else {
displayedValue = element.label;
}

return `<div class="lbp-gameitem-parent" id="gameitem-${element.labelid}">
<span class="lbp-gameitem-name" style="width:6.5rem;">${displayedValue}</span>
<div style="width: 22rem;display:flex;">
<div class="lpd-gameitem-wrapper"><span style="">odds</span>
<input type="text"  class="form-control lbp-gameitem-input" placeholder="Odds" value="${element.odds}" id="lbp-odds-${element.labelid}"></div>

<div class="lpd-gameitem-wrapper"><span style="">Bet Amt</span>
<input type="text"  class="form-control lbp-gameitem-input" placeholder="Max. amt" value="${element.max_bet_amount}" id="lbp-max-amt-${element.labelid}" ></div>

<div class="lpd-gameitem-wrapper"><span style="">Tot. Bet Amt</span>
<input type="text" class="form-control lbp-gameitem-input" value="${element.total_max_bet_amount}" placeholder="Tot. Max. amt" id="lbp-max-tot-amt-${element.labelid}"></div></div></div>`;

}


const boardGamesMarkup = (games = [],title = "") => {
let markup = "";
let gamesIDs = []; 
let state = "";
games.forEach((element) => {
    gamesIDs.push(element.gameId);
    state = element.state;
   markup += `<div class="lbp-gameitem-parent" id="gameitem-${element.gameId}">
<span class="lbp-gameitem-name" style="width:6.5rem;">${element.name}</span>
<div style="width: 22rem;display:flex;">
<div class="lpd-gameitem-wrapper"><span style="">odds</span>
<input type="text"  class="form-control lbp-gameitem-input" placeholder="Odds" value="${element.odds}" id="lbp-boargames-odds-${element.gameId}"></div>

<div class="lpd-gameitem-wrapper"><span style="">Bet Amt</span>
<input type="text"  class="form-control lbp-gameitem-input" placeholder="Max. amt" value="${element.max_bet_amount}" id="lbp-boardgames-max-amt-${element.gameId}" ></div>

<div class="lpd-gameitem-wrapper"><span style="">Tot. Bet Amt</span>
<input type="text" class="form-control lbp-gameitem-input" value="${element.total_max_bet_amount}" placeholder="Tot. Max. amt" id="lbp-boardgames-max-tot-amt-${element.gameId}"></div></div></div>`;
  
});

return broadBetParentMarkup(markup,title,gamesIDs.join(","),state);

};

const  isNumber  = (value)  => typeof value === "number" && !Number.isNaN(value);
