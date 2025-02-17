$(function(){

    const page = 1;
    const limit = 10;

    //accont transaction 
    const keys = ["trans_id", "username", "order_type", "account_change", "balance", "dateTime", "date_created", "order_id", "status"];
    const elements = {table: "accountTransactionTable",refresh: "accrefresh", execute: "acctrans", pagination: "accPageBox", paging: "accPageInfo", tableWrapper: "acc_mask"}
    $("#acc_mask").LoadingOverlay("show", { background: "rgb(90,106,133,0.1)", size: 3 });
    fetchData(`../business/account_transaction`,page,limit,accountTransactionTable, elements, {}, keys) 

    let savedLang = localStorage.getItem("selectedLanguage") || "en";
    loadTranslations(savedLang);

})
