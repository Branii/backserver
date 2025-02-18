const page = 1;
const limit = 10;

$(document).on("click", ".tinfo", function(e) {
    const value = $(this).attr("value");
    const data = value.split("_")[3];
    if(data == "Deposit" || data == "Withdrawal"){
        getDepositsAndWithdrawals(`../business/fetch_deposit_and_withdrawal`, { reference: value.split("_")[1] })
    }else if(data == "Send Red Envelope" || data == "Receive Red Envelope"){
        alert(); //getSingleData(`../business/fetch_red_envelop`, { withdrawal_id: data })
    }else{
        getSingleData(`../business/fetch_lottery`, { betcode: value })
    }
  
})

$(document).on("click", ".accplayer", function(e) {
    const value = $(this).attr("value");
    directions(value, "acctablewrapper")
})

$(document).on("click", ".lang", function(e) {
    const value = $(this).attr("value")
    loadTranslations(value)
})

$(".accrowsort").change(function(){
    const numrow = $(this).val();
    const params = [$("#trans_username").val(),$("#trans_id").val(),$("#trans_datefrom").val(),$("#trans_dateto").val()]
    const isEmpty = params.every(param => param === "");
    if(isEmpty && $("#trans_type").val() == ""){
        const keys = ["trans_id", "username", "order_type", "account_change", "balance", "dateTime", "date_created", "order_id", "status"];
        const elements = {
            table: "accountTransactionTable",refresh: "accrefresh", execute: "acctrans", pagination: "accPageBox", paging: "accPageInfo",tableWrapper: "acc_mask"
        }
        $("#acc_mask").LoadingOverlay("show", { background: "rgb(90,106,133,0.1)", size: 3 });
        fetchData(`../business/account_transaction`, page, numrow, accountTransactionTable, elements, {}, keys)
    }else{
        const filter = {
            username: $("#trans_username").val(),
            transactionid: $("#trans_id").val(),
            transactiontype: $("#trans_type").val(),
            datefrom: $("#trans_datefrom").val(),
            dateto: $("#trans_dateto").val()
        }
        const keys = ["trans_id", "username", "order_type", "account_change", "balance", "dateTime", "date_created", "order_id", "status"];
        const elements = {
             table: "accountTransactionTable",refresh: "accrefresh", execute: "acctrans", pagination: "accPageBox", paging: "accPageInfo",tableWrapper: "acc_mask"
        }
        $("#acc_mask").LoadingOverlay("show", { background: "rgb(90,106,133,0.1)", size: 3 });
        fetchData(`../business/filter_transaction`, page, numrow, accountTransactionTable, elements, filter, keys)
    }

})

$(document).on("click", "#refresh_trans", function(e) {
    const keys = ["trans_id", "username", "order_type", "account_change", "balance", "dateTime", "date_created", "order_id", "status"];
    const elements = {
        table: "accountTransactionTable",refresh: "accrefresh", execute: "acctrans", pagination: "accPageBox", paging: "accPageInfo",tableWrapper: "acc_mask"
    }
    $("#acc_mask").LoadingOverlay("show", { background: "rgb(90,106,133,0.1)", size: 3 });
    fetchData(`../business/account_transaction`, page, limit, accountTransactionTable, elements, {}, keys) 
})

$(document).on("click", "#exec_trans", function(e) {
    params = {
        username: $("#trans_username").val(),
        transactionid: $("#trans_id").val(),
        transactiontype: $("#trans_type").val(),
        datefrom: $("#trans_datefrom").val(),
        dateto: $("#trans_dateto").val()
    }
    const keys = ["trans_id", "username", "order_type", "account_change", "balance", "dateTime", "date_created", "order_id", "status"];
    const elements = {
         table: "accountTransactionTable",refresh: "accrefresh", execute: "acctrans", pagination: "accPageBox", paging: "accPageInfo",tableWrapper: "acc_mask"
    }
    $("#acc_mask").LoadingOverlay("show", { background: "rgb(90,106,133,0.1)", size: 3 });
    fetchData(`../business/filter_transaction`, page, limit, accountTransactionTable, elements, params, keys) 
})

