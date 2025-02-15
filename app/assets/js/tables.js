const renderTable = (data, tableId, keys) => {
let html = data
    .map(
    (item) => `
        <tr>
            ${keys.map((key) => `<td>${item[key] || ""}</td>`).join("")}
        </tr>
    `
    )
    .join("");
    document.getElementById(tableId).innerHTML = html;
};

const accountTransactionTable = (data, tableId, keys) => {
let html = "";
data.forEach((item) => {
    const statusColor = betStatus[item.order_type]
    
    html += `
        <tr>
            <td>${item.trans_id}</td>
            <td>${item.username}</td>
            <td><i class='bx bxs-circle' style="font-size:10px;margin-right:10px;color:${statusColor.color}"></i>${statusColor.title}</td>
            <td>${item.account_change}</td>
            <td>${item.balance}</td>
            <td>${item.dateTime}</td>
            <td>${item.date_created}</td>
            <td>${item.order_id}</td>
            <td><span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">Complete</span></td>
            <td><i value='${item.username}_${item.order_id}_${item.game_type}' class='bx bx-info-circle tinfo' style='color:#868c87;font-size:18px;cursor:pointer;'></i></td>
        </tr> 
        `;
});
document.getElementById(tableId).innerHTML = html;
};

const formatAccountTransactionTable = (data, tableId, keys) => {
    let html = "";
    Object.entries(keys).forEach(([key, value]) => {

      html += `
            <tr>
                <td><b>${value}</b></td>
                <td>${data[key]}</td>
            </tr>
            `;
       });
      document.getElementById(tableId).innerHTML = ""
      document.getElementById(tableId).innerHTML = html;
}
