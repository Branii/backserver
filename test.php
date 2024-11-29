<aside class="left-sidebar with-vertical">
      <div><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="<?php echo BASE_URL; ?>main/index.html" class="text-nowrap logo-img">
            <img src="<?php echo BASE_URL; ?>assets/images/logos/dark-logo.svg" class="dark-logo" alt="Logo-Dark" />
            <img src="<?php echo BASE_URL; ?>assets/images/logos/light-logo.svg" class="light-logo" alt="Logo-light" />
          </a>
          <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
            <i class="ti ti-x"></i>
          </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
          <ul id="sidebarnav">
     

          </ul>
        </nav>

        <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
          <div class="hstack gap-3">
            <div class="john-img">
              <img src="../assets/images/profile/user-1.jpg" class="rounded-circle" width="40" height="40" alt="modernize-img" />
            </div>
            <div class="john-title">
              <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
              <span class="fs-2">Designer</span>
            </div>
            <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
              <i class="ti ti-power fs-6"></i>
            </button>
          </div>
        </div>

        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
      </div>
    </aside>



    console.log(typeof(response))
       if(users){

        let html = "";
       users.forEach((user) => { 
         html += `<option value="${user.username}">${user.username}</option>`; 
       }); 
       console.log("html  " + html)
       //$("#userDropdown").html(html)
       dropdown.style.display = searchkey && users.length ? "block" : "none"; 

       }else{
        $("#userDropdown").html("<option>no data</option>");
       }


       <div class="accordion">
    <div class="accordion-item">
        <div class="accordion-header" onclick="toggleAccordion(this)">
        <i class='bx bx-menu bx-flip-horizontal' ></i><span> Business Flow</span>
        </div>
        <div class="accordion-content">
            <ul class="custom-list">
                <li id="tab1" class="tab-button item" value="account_transaction">Account Transactions</li>
                <li id="tab2" class="tab-button item" value="game_getting_statistics">Game Betting Statistics</li>
                <li id="tab3" class="tab-button item" value="lottery_betting_record">Lottery Betting Record</li>
                <!-- <li id="tab4" class="item">Tab 4</li>
                    <li id="tab5" class="item">Tab 5</li> -->
            </ul>
        </div>
    </div>
    <div class="accordion-item">
        <div class="accordion-header" onclick="toggleAccordion(this)">
        <i class='bx bx-menu bx-flip-horizontal' ></i><span> Financial Management</span>
        </div>
        <div class="accordion-content">
            <ul class="custom-list">
                <li id="tab6" class="item tab-button" value="tab6">Tab 6</li>
                <li id="tab7" class="item tab-button" value="tab7">Tab 7</li>
                <li id="tab8" class="item tab-button" value="tab8">Tab 8</li>
                <li id="tab9" class="item tab-button" value="tab9">Tab 9</li>
                <li id="tab10" class="item tab-button" value="tab10">Tab 10</li>
            </ul>
        </div>
    </div>
    <div class="accordion-item">
        <div class="accordion-header" onclick="toggleAccordion(this)">
        <i class='bx bx-menu bx-flip-horizontal' ></i><span> Report Management</span>
        </div>
        <div class="accordion-content">
            <ul class="custom-list">
                <li id="tab11" class="item tab-button" value="account_transaction">Tab 11</li>
                <li id="tab12" class="item tab-button" value="account_transaction">Tab 12</li>
                <li id="tab13" class="item tab-button" value="account_transaction">Tab 13</li>
                <li id="tab14" class="item tab-button" value="account_transaction">Tab 14</li>
                <li id="tab15" class="item  tab-button  showPopUP">Tab 15</li>
            </ul>
        </div>
    </div>
    <div class="accordion-item">
        <div class="accordion-header" onclick="toggleAccordion(this)">
        <i class='bx bx-menu bx-flip-horizontal' ></i> <span> User Management</span>
        </div>
        <div class="accordion-content">
            <ul class="custom-list">
            <li id="tab1" class="tab-button item" value="userlist">Userlist</li>
            <li id="tab2" class="tab-button item" value="userlogs">User Logs</li>
               
            </ul>
        </div>
    </div>
    <div class="accordion-item">
        <div class="accordion-header" onclick="toggleAccordion(this)">
        <i class='bx bx-menu bx-flip-horizontal' ></i> <span> Promotion Management</span>
        </div>
        <div class="accordion-content">
            <ul class="custom-list">
                <li id="tab16"  class="tab-button item" value="invitation">Invitation & Referal Links</li>
                <li id="tab17" class="item">Tab 12</li>
                <li id="tab18" class="item">Tab 13</li>
                <li id="tab19" class="item">Tab 14</li>
                <li id="tab20" class="item showPopUP">Tab 15</li>
            </ul>
        </div>
    </div>
    <div class="accordion-item">
        <div class="accordion-header" onclick="toggleAccordion(this)">
        <i class='bx bx-menu bx-flip-horizontal' ></i><span> User Bank Management</span>
        </div>
        <div class="accordion-content">
            <ul class="custom-list">
                <li id="tab16" class="item">Tab 11</li>
                <li id="tab17" class="item">Tab 12</li>
                <li id="tab18" class="item">Tab 13</li>
                <li id="tab19" class="item">Tab 14</li>
                <li id="tab20" class="item showPopUP">Tab 15</li>
            </ul>
        </div>
    </div>
    <div class="accordion-item">
        <div class="accordion-header" onclick="toggleAccordion(this)">
        <i class='bx bx-menu bx-flip-horizontal' ></i><span> Agent Management</span>
        </div>
        <div class="accordion-content">
            <ul class="custom-list">
                <li id="tab16"class="tab-button item" value="quota">Quota Settings</li>
                <li id="tab17" class="item">Tab 12</li>
                <li id="tab18" class="item">Tab 13</li>
                <li id="tab19" class="item">Tab 14</li>
                <li id="tab20" class="item showPopUP">Tab 15</li>
            </ul>
        </div>
    </div>
    <div class="accordion-item">
        <div class="accordion-header" onclick="toggleAccordion(this)">
        <i class='bx bx-menu bx-flip-horizontal' ></i>  <span> Game Management</span>
        </div>
        <div class="accordion-content">
            <ul class="custom-list">
                <li id="tab16" class="item">Tab 11</li>
                <li id="tab17" class="item">Tab 12</li>
                <li id="tab18" class="item">Tab 13</li>
                <li id="tab19" class="item">Tab 14</li>
                <li id="tab20" class="item showPopUP">Tab 15</li>
            </ul>
        </div>
    </div>
    <div class="accordion-item">
        <div class="accordion-header" onclick="toggleAccordion(this)">
        <i class='bx bx-menu bx-flip-horizontal' ></i><span> System Management</span>
        </div>
        <div class="accordion-content">
            <ul class="custom-list">
                <li id="tab11" class="item tab-button" value="administrator_list">Administrator List</li> 
                <li id="tab17" class="item tab-button" value="backup_recovery">Backup & Recovery</li>
                <li id="tab18" class="item">Tab 13</li>
                <li id="tab19" class="item">Tab 14</li>
                <li id="tab20" class="item showPopUP">Tab 15</li>
            </ul>
        </div>
    </div>
</div>