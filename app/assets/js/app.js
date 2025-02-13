$(function(){

    const page = 1;
    const limit = 10;

    //accont transaction 
    const keys = ["trans_id", "username", "order_type", "account_change", "balance", "dateTime", "date_created", "order_id", "status"];
    fetchData(`../business/account_transaction`,page,limit,renderTable,"accountTransactionTable","accPageBox", "accPageInfo", {}, keys) 




})
