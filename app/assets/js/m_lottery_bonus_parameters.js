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
            const element = gameItems[index];
          const labelid      = $(element).attr("id").split("-")[1];
          console.log($(`lbp-odds-${labelid}`));
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
            console.log(response);
            return;
            console.log(response[lotteryType]);
            response = response[lotteryType];
            const gameGroup = response[lotteryGameGroup];
            $("#maskrfeferal").html(twosidesUI(gameGroup))

           
           

            return;
            if (response.status === "error") {
              showToast("Error", "Lottery Data Successfully Updated.","error");
              return;
            }
    
            if(data == 0){
              showToast("Error", "This lottery has already being " + (status === "gameon" ? " Turned On " : " Turned Off "),"error");
              $('.lb-tclose').click();
              return;
            }
      
           $("#lbp_twosides").html(twoSidesModelMarkup(data));
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

        const lotteryType = $('#allGameNamesLottery').val();
        const lotteryModel = $("#allmodels").val();
        const lotteryGameGroup = $("#game_groups").val();
        if(lotteryModel == undefined || lotteryType == undefined || lotteryGameGroup == undefined) return;
        // $("#maskrfeferal").hide();
        // $("#lbp_twosides").show();
        const element = this;

        $.ajax({
            // url: `../admin/fetchBonusTwoSides/${lotteryType}/${lotteryGameGroup}`,
            url: `http://192.168.1.51/chairman_test/api/v1/limvo/twosides?lottery_type_id=${lotteryType}`,
            type: "GET",
            beforeSend: function () {
                $($(element).find("i")[0]).removeClass("bx-check-double").addClass("bx-loader bx-spin");
            },
            success: function (response) {
              if(response === "Game id not found!!"){
                showToast("Error", "Sorry the lottery selected is not yet ready.", "error");
                return;
              }
              console.log(response[lotteryType]);
              response = response[lotteryType];
              const gameGroup = response[lotteryGameGroup];
              // $("#maskrfeferal").html(twosidesUI(gameGroup))
              $("#lbp_twosides").html(twosidesUI(gameGroup))

             
             

              return;
              if (response.status === "error") {
                showToast("Error", "Lottery Data Successfully Updated.","error");
                return;
              }
      
              if(data == 0){
                showToast("Error", "This lottery has already being " + (status === "gameon" ? " Turned On " : " Turned Off "),"error");
                $('.lb-tclose').click();
                return;
              }
        
             $("#lbp_twosides").html(twoSidesModelMarkup(data));
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


      $(document).on("change","#allmodels,#allGameNamesLottery",function(){

        const lotteryModel = $("#allmodels").val();

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
          $("#maskrfeferal").hide();
          $("#lbp_twosides").show();

        }else{
           $("#game_groups").hide();
           $("#maskrfeferal").show();
           $("#lbp_twosides").hide();
        }
           

      });


      const twoSidesModelMarkup = (data) => {

        html = "";

        data.forEach(element => {
           html += `<div class="mt-3 mt-md-0 ms-auto" style="display: inline-flex;margin-left: 5px !important;"><button type="button" class="btn hstack gap-6 fetch_twosides_params" id="twosides_model_${element.gn_id}" style="border: solid 1px #ccc;/* color: #e60e38!important; */"><i class="bx bxs-dice-5"></i>${element.name}</button></div>`
        });
        return  html;
      }

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

const gameGroupsNameV2 =  {
  1: {"Rapido": [] , "all_kinds" : ["First 3","Fixed Place","Last 3","Middle 3","Sum of Dragon/Tiger/Tie"]},
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
    "Row Zodiac Row tail",
    "Row No.",
    "Zodiac&tail",
    "Sum",
    "Optional",
    "Mismatch",
  ],
  10: ["2sides", "Ball No"],
}



const twosidesUI = (data) => {

  let markup = "";
  let fixedPlaceMarkup = "";
  if(data.names === undefined && data.name === undefined){
    data.data.forEach((element)=>{
      if(element.key === "FixedPlace"){
        fixedPlaceMarkup += twosidesUIItemFixedPlace(element);
      }else{
        markup += twosidesUIItem(element);
      }
     //
    });
    return broadBetParentMarkup(markup) + fixedPlaceParentMarkup(fixedPlaceMarkup);
  }


  // const gamesSubNames  = data.names != undefined ? data.names : data.name;
  // markup = "";
  // gamesSubNames.forEach((subName) => {
  //   let innerMarkup = "";
  //   data[subName].data.forEach((element)=>{
  //     innerMarkup += twosidesUIItem(element);
  //   });
  //   markup += broadBetParentMarkup(innerMarkup,subName);
  // });

  // return markup;


  const gamesSubNames  = data.names != undefined ? data.names : data.name;
  markup = "";
  gamesSubNames.forEach((subName) => {
    let innerMarkup = "";
    let subGameGroup = data[subName];
    if(subGameGroup.names === undefined){
     subGameGroup.data.forEach((element)=>{
      innerMarkup += twosidesUIItem(element);
    });
    markup += broadBetParentMarkup(innerMarkup,subName);
    }else{
      const subGameGroupNames = subGameGroup.names;
       subGameGroupNames.forEach((subName) => {
    let innerMarkup = "";
     subGameGroup[subName].data.forEach((element)=>{
      innerMarkup += twosidesUIItem(element);
    });
    markup += broadBetParentMarkup(innerMarkup,subName);
       });
       }
         
  });

  return markup;
 
 

 
};

const broadBetParentMarkup = (markup,title = "") => {
  if(markup.length === 0) return "";
  // title = title.length === 0 ? "" : `<div class="lbp-gamegroup-title"><span class="lbp-center">${title}</span></div>`;
  title = title.length === 0 ? "" : `<span class="lbp-center">${title}</span>`;
 return `<div class="lbp-gamegroup-wrapper"> <div class="lbp-gamegroup-title">${title}<div class="mt-3 mt-md-0 ms-auto" style="margin: 0px !important;"><button type="button" class="btn hstack gap-6  update-gamegroup" >Update</button></div></div><div class="lbp-gameitem-wrapper">${markup}</div></div>`
};


const fixedPlaceParentMarkup = (markup,title = "") => {
  if(markup.length === 0) return "";
  title = title.length === 0 ? "" : `<span class="lbp-center">${title}</span>`;
  return `<div class="lbp-gamegroup-wrapper"><div class="lbp-gamegroup-title">${title}<div class="mt-3 mt-md-0 ms-auto" style="margin: 0px !important;"><button type="button" class="btn hstack gap-6  update-gamegroup" >Update</button></div></div><div class="lbp-gameitem-wrapper">${markup}</div></div>`;
};

const twosidesUIItem = (element) => `<div class="lbp-gameitem-parent" id="gameitem-${element.labelid}">
  <span class="lbp-gameitem-name" style="width:6.5rem;">${element.label}</span>
  <div style="width: 22rem;display:flex;">
  <input type="text"  class="form-control lbp-gameitem-input" placeholder="Odds" value="${element.odds}" id="lbp-odds-${element.labelid}">
  
<input type="text"  class="form-control lbp-gameitem-input" value="${element.max_bet_amount}" id="lbp-max-amt-${element.labelid}" placeholder="Max. amt" ><input type="text" class="form-control lbp-gameitem-input" value="${element.total_max_bet_amount}" id="lbp-max-tot-amt-${element.labelid}" placeholder="Tot. Max. amt"></div></div>`;

const twosidesUIItemFixedPlace = (element) => `<div class="lbp-gameitem-parent" id="gameitem-${element.labelid}">
  <span class="lbp-gameitem-name" style="width:6.5rem;">${element.label}</span>
  <div style="width: 22rem;display:flex;">
  <input type="text"  class="form-control lbp-gameitem-input" placeholder="Odds" value="${element.odds}">
  
<input type="text"  class="form-control lbp-gameitem-input" placeholder="Max. amt" ><input type="text" class="form-control lbp-gameitem-input" placeholder="Tot. Max. amt"></div></div>`;


// <div style="
//     margin: 1rem;
//     padding: 1rem;
//     border-radius: 10px;
//     border: 1px solid #c6cad2;
// ">
//  <div style="
//     /* background-color: aliceblue; */
//     display: flex;
//     align-items: center;
//     padding: 16px 0px;
// "><span style="
//     margin: 0px auto;
// ">Sum Of Top Two</span></div>
//     <div style="
//     /* padding: 10px; */
//     display: flex;
//     /* justify-content: space-between; */
//     flex-wrap: wrap;
//     row-gap: .8rem;
// ">
            
//         <div style="
//     width: 30%;
//     background: #f3f3f3;
//     display: flex;
//     padding: 10px;
//     border-radius: 10px;
//     padding-left: 20px;
//     justify-content: space-evenly;
//     margin-right: 20px;
//     align-items: center;
// ">
//     <span style="
//     margin-right: 50px;
//     color: #333;
//     font-weight: 500;
// ">Big</span>
//     <input type="text" id="transuser" class="form-control" placeholder="odds" style="
//     background-color: #fff;
//     margin-right: 10px;
// ">
    
// <input type="text" id="transuser" class="form-control" placeholder="odds" style="
//     background-color: #fff;
//     margin-right: 10px;
// "><input type="text" id="transuser" class="form-control" placeholder="odds" style="
//     background-color: #fff;
//     margin-right: 10px;
// "></div></div></div>