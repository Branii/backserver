$(function () {

    const AccountTransactions = (data) => {

        let html = "";
        const status = {
            1: "Deposit",
            2: "Win Bonus",
            3: "Bet Awarded",
            4: "Withdrawal",
            5: "Bet Cancelled",
            6: "Bet Deduct",
            7: "Rebates",
            8: "Self Rebate",
            9: "Send Red Envelope",
            10: "Receive Red Envelope",
            11: "Bet Refund"
        }

        data.forEach((item) => {
            html += `
                      <tr>
                          <td>${item.order_id.substring(0, 7)}</td>
                          <td>${item.username}</td>
                          <td>${status.item.order_type}</td>
                          <td>${item.account_change}</td>
                          <td>${item.balance}</td>
                          <td>${item.dateTime}</td>
                          <td>${item.order_id}</td>
                          <td>Complete</td>
                 
                  
                      </tr>
                  `;
        });
        return html;
    };

    const Gamebetting = (data) => {

        let html = "";
        data.forEach((item) => {
            html += `
                      <tr>
                          <td>${item.uid}</td>
                          <td>${item.username}</td>
                          <td>${item.nickname}</td>
                          <td>${item.user_email}</td>
                          <td>${item.user_dob}</td>
                          <td>${item.user_contact}</td>
                          <td>${item.company}</td>
                          <td>${item.agent}</td>
                          <td>${item.balance}</td>
                          <td>${item.rebate}</td>
                          <td>
                              
                               <div class="dropdown">
                                      <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                       <i class='bx bx-dots-vertical-rounded'></i>
                                      </a>
                                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                        <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                          <i class='bx bx-user-check' ></i>View
                                        </a>
                                        <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                          <i class='bx bx-pencil' ></i>Edit
                                        </a>
                                        <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                          <i class="bx bx-trash fs-5"></i>Delete
                                        </a>
                                      </div>
                                    </div>
                          </td>
                      </tr>
                  `;
        });
        return html;
    };

    const Lottery = (data) => {

        let html = "";
        data.forEach((item) => {
            html += `
                      <tr>
                          <td>${item.uid}</td>
                          <td>${item.username}</td>
                          <td>${item.nickname}</td>
                          <td>${item.user_email}</td>
                          <td>${item.user_dob}</td>
                          <td>${item.user_contact}</td>
                          <td>${item.company}</td>
                          <td>${item.agent}</td>
                          <td>${item.balance}</td>
                          <td>${item.rebate}</td>
                          <td>
                              
                               <div class="dropdown">
                                      <a class="dropdown-toggles" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                       <i class='bx bx-dots-vertical-rounded'></i>
                                      </a>
                                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1"  style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                        <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                          <i class='bx bx-user-check' ></i>View
                                        </a>
                                        <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                          <i class='bx bx-pencil' ></i>Edit
                                        </a>
                                        <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                          <i class="bx bx-trash fs-5"></i>Delete
                                        </a>
                                      </div>
                                    </div>
                          </td>
                      </tr>
                  `;
        });
        return html;
    };


})