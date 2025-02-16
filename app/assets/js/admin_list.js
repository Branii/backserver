$(function () {
  function t(t, e, n) {
    $.toast({
      position: "bottom-right",
      title: t,
      message: e,
      type: n,
      duration: 3e3,
    });
  }
  let e = 50;
  const n = (t) => {
      var e = ((t) => {
        let e = "";
        return (
          t.forEach((t) => {
            let n = t.full_name.split(" ")[0][0] ?? "",
              a = t.full_name.split(" ")[1][0] ?? "";
            e += `\n                <tr class="trow">\n                    <td> \n                       <div class="d-flex align-items-center">\n                          <img src="http://localhost/admin/app/assets/images/profile/${
              t.profile_picture
            }" class=" rounded-circle" width="40" height="40" />    \n                        </div>\n                    </td>\n\n                    <td>${
              t.username
            }</td>\n                    <td>${
              t.full_name
            }</td>\n\n                     <td>\n                        <div class="d-flex align-items-center">\n                          <a href="javascript:void(0)" class="ini text-white fs-6 round-40 rounded-circle me-n2 card-hover border border-2 border-white d-flex align-items-center justify-content-center">\n                            ${n}\n                          </a>\n                          <a href="javascript:void(0)" class="ini text-white fs-6 round-40 rounded-circle me-n2 card-hover border border-2 border-white d-flex align-items-center justify-content-center">\n                          ${a}\n                          </a>\n                        </div>\n                      </td>\n\n                    <td>${
              t.email
            }</td>\n                    <td>${
              t.phone_number
            }</td>\n                    <td>${
              t.two_factor_enabled
            }</td>\n                    <td>\n                    ${
              t.role
            }\n                    </td>\n                    <td><span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">${
              t.account_status
            }</span></td>\n\n                    <td>\n                        <div class="dropdown dropstart">\n                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">\n                             <i value='' class='bx bx-dots-vertical-rounded'' style='color:#868c87;font-size:18px;cursor:pointer;'></i>\n                          </a>\n                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">\n                            <li value='${JSON.stringify(
              t
            )}' class='admin_pro'>\n                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view-profile">\n                                <i class='bx bx-show-alt'></i>View Profile\n                              </a>\n                            </li>\n                            <li value='${JSON.stringify(
              t
            )}' class='admin_logs'>\n                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#view-activity-logs">\n                                <i class='bx bx-history' style='font-size:16px;'></i>Activity Logs\n                              </a>\n                            </li>\n                             <li value='${JSON.stringify(
              t
            )}' class='admin_per'>\n                              <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#view-permissions">\n                                <i class='bx bx-edit-alt' style='font-size:16px;'></i>Permissions\n                              </a>\n                            </li>\n                          </ul>\n                        </div>\n                      </td>\n                </tr>\n            `;
          }),
          e
        );
      })(t);
      $("#dataContainerAdmin").html(e);
    },
    a = (t) => {
      var e = ((t) => {
        let e = "";
        return (
          t.forEach((t) => {
            e += `\n              <tr class="trow">\n                  <td>${t.action_performed}</td>\n                  <td>${t.created_date}</td>\n                  <td>${t.created_time}</td>\n                  <td>${t.ip_address}</td>\n                  <td>${t.affected_entity}</td>\n                  <td>${t.old_value}</td>\n                  <td>${t.new_value}</td>\n                  <td><span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">${t.action_status}</span></td>\n              </tr>\n       `;
          }),
          e
        );
      })(t);
      $("#adminLogsContainer").html(e);
    };
  async function i(t, e) {
    try {
      const a = await fetch(`../admin/alladmins/${t}/${e}`),
        i = await a.json();
      n(i.admins),
        l(i.totalPages, t),
        (document.getElementById("paging_info_admin").innerHTML =
          "Page " + t + " of " + i.totalPages + " pages");
    } catch (t) {
      console.error("Error fetching data:", t);
    }
  }
  i(1, e);
  async function s(t, e, n) {
    try {
      const i = await fetch(`../admin/adminlogs/${t}/${e}/${n}`),
        s = await i.json();
      console.log(s.adminLogs), a(s.adminLogs), c(s.totalPages, t, n);
    } catch (t) {
      console.error("Error fetching data:", t);
    }
  }
  async function o(t, e, n, i, s) {
    try {
      const o = await fetch(
          `../admin/filterAdminLogs/${t}/${e}/${n}/${i}/${s}`
        ),
        l = await o.json();
      console.log(l.adminLogs), a(l.adminLogs), r(l.totalPages, t, n, i, s);
    } catch (t) {
      console.error("Error fetching data:", t);
    }
  }
  function l(t, n) {
    const a = (t, e = t, n = !1, a = !1) =>
      `<li class='page-item ${n ? "disabled" : ""} ${
        a ? "active" : ""
      }'>\n            <a class='page-link' href='#' data-page='${t}'>${e}</a>\n          </li>`;
    let s = "<ul class='pagination justify-content-end'>";
    s += a(n - 1, "<i class='bx bx-chevron-left'></i>", 1 === n);
    for (let e = 1; e <= t; e++)
      1 === e || e === t || Math.abs(e - n) <= 2
        ? (s += a(e, e, !1, e === n))
        : (e !== n - 3 && e !== n + 3) || (s += a(e, "...", !0));
    (s += a(n + 1, "<i class='bx bx-chevron-right'></i>", n === t)),
      (s += "</ul>"),
      (document.getElementById("paginationAdmin").innerHTML = s),
      document.querySelectorAll("#paginationAdmin .page-link").forEach((n) => {
        n.addEventListener("click", function (n) {
          n.preventDefault();
          const a = +this.getAttribute("data-page");
          a > 0 && a <= t && i(a, e);
        });
      });
  }
  function c(t, n, a) {
    const i = (t, e = t, n = !1, a = !1) =>
      `<li class='page-item ${n ? "disabled" : ""} ${
        a ? "active" : ""
      }'>\n            <a class='page-link' href='#' data-page='${t}'>${e}</a>\n          </li>`;
    let o = "<ul class='pagination justify-content-end'>";
    o += i(n - 1, "<i class='bx bx-chevron-left'></i>", 1 === n);
    for (let e = 1; e <= t; e++)
      1 === e || e === t || Math.abs(e - n) <= 2
        ? (o += i(e, e, !1, e === n))
        : (e !== n - 3 && e !== n + 3) || (o += i(e, "...", !0));
    (o += i(n + 1, "<i class='bx bx-chevron-right'></i>", n === t)),
      (o += "</ul>"),
      (document.getElementById("paginationAdminLogs").innerHTML = o),
      document
        .querySelectorAll("#paginationAdminLogs .page-link")
        .forEach((n) => {
          n.addEventListener("click", function (n) {
            n.preventDefault();
            const i = +this.getAttribute("data-page");
            i > 0 && i <= t && s(i, e, a);
          });
        });
  }
  function r(t, n, a, i, s) {
    const l = (t, e = t, n = !1, a = !1) =>
      `<li class='page-item ${n ? "disabled" : ""} ${
        a ? "active" : ""
      }'>\n            <a class='page-link' href='#' data-page='${t}'>${e}</a>\n          </li>`;
    let c = "<ul class='pagination justify-content-end'>";
    c += l(n - 1, "<i class='bx bx-chevron-left'></i>", 1 === n);
    for (let e = 1; e <= t; e++)
      1 === e || e === t || Math.abs(e - n) <= 2
        ? (c += l(e, e, !1, e === n))
        : (e !== n - 3 && e !== n + 3) || (c += l(e, "...", !0));
    (c += l(n + 1, "<i class='bx bx-chevron-right'></i>", n === t)),
      (c += "</ul>"),
      (document.getElementById("paginationAdminLogs").innerHTML = c),
      document
        .querySelectorAll("#paginationAdminLogs .page-link")
        .forEach((n) => {
          n.addEventListener("click", function (n) {
            n.preventDefault();
            const l = +this.getAttribute("data-page");
            l > 0 && l <= t && o(l, e, a, i, s);
          });
        });
  }
  function d(t, n, a, i) {
    const s = (t, e = t, n = !1, a = !1) =>
      `<li class='page-item ${n ? "disabled" : ""} ${
        a ? "active" : ""
      }'>\n            <a class='page-link' href='#' data-page='${t}'>${e}</a>\n          </li>`;
    let l = "<ul class='pagination justify-content-end'>";
    l += s(n - 1, "<i class='bx bx-chevron-left'></i>", 1 === n);
    for (let e = 1; e <= t; e++)
      1 === e || e === t || Math.abs(e - n) <= 2
        ? (l += s(e, e, !1, e === n))
        : (e !== n - 3 && e !== n + 3) || (l += s(e, "...", !0));
    (l += s(n + 1, "<i class='bx bx-chevron-right'></i>", n === t)),
      (l += "</ul>"),
      (document.getElementById("paginationAdminLogs").innerHTML = l),
      document
        .querySelectorAll("#paginationAdminLogs .page-link")
        .forEach((n) => {
          n.addEventListener("click", function (n) {
            n.preventDefault();
            const s = +this.getAttribute("data-page");
            s > 0 && s <= t && o(s, e, a, i);
          });
        });
  }
  $(".fullsubmit").on("click", function (e) {
    e.preventDefault();
    let a = [
      $(".fullname").val(),
      $(".fullemail").val(),
      $(".fullcontact").val(),
      $(".fullrole").val(),
    ];
    const i = $("#admins").serialize();
    var s;
    a.some((t) => "" === t)
      ? t("Heads up!!", "All fields are mandatory", "info")
      : ((s = `../admin/admins/${i}`),
        $.post(s, function (e) {
          const a = JSON.parse(e);
          console.log(a),
            $(".add-new").modal("hide"),
            n(a.admins),
            t("Success", "New user added successfulyy", "success");
        }));
  }),
    (function () {
      const t = document.querySelector(".table-wrappereAdmin"),
        e = document.querySelector(".headrow");
      t.addEventListener("scroll", function () {
        t.scrollTop > 0
          ? e.classList.add("sticky-headerAdmin")
          : e.classList.remove("sticky-headerAdmin");
      });
    })(),
    $(".upp").on("click", function () {
      const t = $(this).attr("value");
      $(".profile_picture").val(t),
        $(".ava").hide(),
        $(this).siblings(".ava").show();
    }),
    $(document).on("click", ".admin_pro", function () {
      const t = JSON.parse($(this).attr("value"));
      console.log(t),
        $("#adminprofile").attr(
          "src",
          "http://localhost/admin/app/assets/images/profile/" +
            t.profile_picture
        ),
        $("#pro_fullname").text(t.full_name),
        $("#adminusername").val(t.username),
        $("#adminemail").val(t.email),
        $("#admincontact").val(t.phone_number),
        $("#adminrecovery").val(t.recovery_email),
        $("#adminstatus").val(t.account_status),
        $("#adminrole").val(t.role);
    });
  let m,
    u,
    g,
    p = [],
    f = {};
  $(document).on("click", ".admin_per", function () {
    const t = JSON.parse($(this).attr("value"));
    let e = JSON.parse(t.permissions);
    m = t.admin_id;
    const n = {
        1: {
          title: "Account Transaction Details",
          content: "account_transaction",
        },
        2: { title: "Game Betting Statistics", content: "Game" },
        3: { title: "Lottery Betting Record", content: "Lottery" },
        4: { title: "Track Records", content: "Track" },
        5: { title: "Deposit Record", content: "Deposit" },
        6: { title: "Withdrawal Records", content: "Withdrawal" },
        7: { title: "Finance Fund Changes", content: "Finance" },
        8: { title: "Win/Loss Report", content: "Win" },
        9: { title: "User List", content: "Userlist" },
        10: { title: "User Logs", content: "Userlogs" },
        11: { title: "Invitation & Referral Links", content: "Invitation" },
        12: { title: "Bank Card List", content: "Bank" },
        13: { title: "Quota Settings", content: "quota" },
        14: { title: "Lottery Draw Records", content: "lotterydraws" },
        15: { title: "Lottery Basic Parameters", content: "lotterybasic" },
        16: { title: "Lottery Bonus Parameters", content: "lotterybonus" },
        17: { title: "Administrator List", content: "administrator_list" },
        18: { title: "Backup & Recovery", content: "backup_recovery" },
      },
      a = {
        1: { category: "Business flow", items: [1, 2, 3, 4] },
        2: { category: "Financial Management", items: [5, 6, 7] },
        3: { category: "Report Management", items: [8] },
        4: { category: "User Management", items: [9, 10] },
        5: { category: "Promotion Management", items: [11] },
        6: { category: "User Bank Management", items: [12] },
        7: { category: "Game Management", items: [14, 15, 16] },
        8: { category: "Agent Management", items: [13] },
        9: { category: "System Management", items: [17, 18] },
      };
    let i = "";
    for (let t in a)
      (i += `\n      <div class="accordion-item">\n          <div class="accordion-header">\n             <span class='maintext'>${a[t].category}</span>\n          </div>\n             <div class="accordion-contentt">\n              <ul class="custom-list">`),
        a.hasOwnProperty(t) &&
          a[t].items.forEach(function (a) {
            let s = "";
            null != e &&
              e[t] &&
              e[t].includes(a) &&
              ((s = "checked"), p.push(t + " " + a)),
              (i += `\n                    <li id="tab1" class="item " value="" style="display: flex; justify-content: space-between;">\n                      ${
                n[a].title
              }\n                      <input class="form-check-input chk" type="checkbox" value="${
                t + " " + a
              }" id="flexCheckDefault" ${s}/>\n                    </li>`);
          }),
        (i +=
          "\n                      </ul>\n                      </div>\n                </div>\n      ");
    $(".permissionholder").html(i),
      $(".adminName").text(t.full_name + " [Permissions]"),
      document.querySelectorAll(".permissionholder").forEach((t) => {
        (t.style.overflow = "auto"), (t.scrollTop = 0), (t.scrollLeft = 0);
      });
  }),
    $(document).on("click", ".chk", function () {
      if ($(this).is(":checked"))
        console.log($(this).val()), p.push($(this).val());
      else {
        const t = p.indexOf($(this).val());
        p.splice(t, 1);
      }
    }),
    $(".updateperm").click(function () {
      var e;
      (f = {}),
        p.forEach((t) => {
          const [e, n] = t.split(" ");
          f[e] || (f[e] = []), f[e].includes(Number(n)) || f[e].push(Number(n));
        }),
        (e = `../admin/permissions/${JSON.stringify(f)}/${m}`),
        $.post(e, function (e) {
          const n = JSON.parse(e);
          console.log(n), (f = {}), t("Success", n, "success");
        });
    }),
    $(document).on("click", ".admin_logs", function () {
      const t = JSON.parse($(this).attr("value"));
      (u = JSON.parse(t.admin_id)),
        console.log(u),
        $(".logname").text(t.full_name),
        s(1, e, u);
    }),
    $(document).on("click", ".rangelogs", function () {
      let n = $(".datefrom").val(),
        a = $(".dateto").val();
      "" == n && "" == a
        ? t("Information", "Select date(s) to filter", "info")
        : "" != n && "" == a
        ? ((a = n), o(1, e, u, n, a))
        : o(1, e, u, n, a);
    }),
    $(document).on("keyup", ".searchlogs", function () {
      let t = $(".searchlogs").val();
      clearTimeout(g),
        (g = setTimeout(
          (async function (t, e, n, i) {
            try {
              const s = await fetch(`../admin/searchlogs/${t}/${e}/${n}/${i}`),
                o = await s.json();
              console.log(o.adminLogs),
                a(o.adminLogs),
                d(o.totalPages, t, n, i);
            } catch (t) {
              console.error("Error fetching data:", t);
            }
          })(1, e, u, t),
          300
        ));
    });
});
