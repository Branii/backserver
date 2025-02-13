

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

// create custom table here below

const accountTransactionTable = (data, tableId, keys) => {
let html = "";
data.forEach((item) => {
    //  so logics here
    const colors = statusColor[item.uid];
    console.log(colors.color);
    html += `
        <tr>
            <td style="background-color:${colors.color}">${item.uid}</td>
            <td>${item.username}</td>
            <td>${item.nickname}</td>
            <td>${item.email}</td>
            <td>  <button class="view">view</button> </td>
        </tr>
        `;
});
document.getElementById(tableId).innerHTML = html;
};

const sampleFunction = (data, tableId, keys) => {
    console.log()
}
