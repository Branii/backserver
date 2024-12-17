<!-- <nav class="sidebar-nav scroll-sidebar" data-simplebar>
    <ul id="sidebarnav">

    <li class="tab-button sidebar-item" value="modern">
        <a class="sidebar-link" id="get-url" aria-expanded="false">
        <span>
            <i class="ti ti-aperture"></i>
        </span>
        <span class="hide-menu">Modern</span>
        </a>
    </li>

    <li class="tab-button sidebar-item" value="commerce">
        <a class="sidebar-link" aria-expanded="false">
        <span>
            <i class="ti ti-shopping-cart"></i>
        </span>
        <span class="hide-menu">eCommerce</span>
        </a>
    </li>

    <li class="tab-button sidebar-item" value="ntf">
        <a class="sidebar-link"  aria-expanded="false">
        <span>
            <i class="ti ti-currency-dollar"></i>
        </span>
        <span class="hide-menu">NFT</span>
        </a>
    </li>

    <li class="tab-button sidebar-item" value="crypto">
        <a class="sidebar-link"  aria-expanded="false">
        <span>
            <i class="ti ti-cpu"></i>
        </span>
        <span class="hide-menu">Crypto</span>
        </a>
    </li>
    
    <li class="tab-button sidebar-item" value="general">
        <a class="sidebar-link"  aria-expanded="false">
        <span>
            <i class="ti ti-activity-heartbeat"></i>
        </span>
        <span class="hide-menu">General</span>
        </a>
    </li>

    <li class="tab-button sidebar-item" value="music">
        <a class="sidebar-link"  aria-expanded="false">
        <span>
            <i class="ti ti-playlist"></i>
        </span>
        <span class="hide-menu">Music</span>
        </a>
    </li>

    </ul>
</nav> -->
<?php

$adminEmail = (new Controller)->getSeesion("isUserLoggedIn");
$decode = (new Controller)->getUserPermissionSidebars($adminEmail);
$permissions = json_decode($decode,true);
// echo "<pre>";
// print_r($permissions);
$sidebarMenu = [

    1 => ['title'=> $translator['Account Transaction Details'], 'content' => 'account_transaction'],
    2 => ['title'=> $translator['Game Betting Statistics'], 'content' => 'Game'],
    3 => ['title'=> $translator['Lottery Betting Record'], 'content' => 'Lottery'],
    4 => ['title'=> $translator['Track Records'], 'content' => 'Track'],
    5 => ['title'=> $translator['Deposit Record'], 'content' => 'Deposit'],
    6 => ['title'=> $translator['Withdrawal Records'], 'content' => 'Withdrawal'],
    7 => ['title'=> $translator['Finance Fund Changes'], 'content' => 'Finance'],
    8 => ['title'=> $translator['Win/Loss Report'], 'content' => 'Win'],
    9 => ['title'=>  $translator['User List'], 'content' => 'Userlist'],
    10 => ['title'=> $translator['User Logs'], 'content' => 'Userlogs'],
    11 => ['title'=> $translator['Invitation & Referral Links'], 'content' => 'Invitation'],
    12 => ['title'=> $translator['Bank Card List'], 'content' => 'Bank'],
    13 => ['title'=> $translator['Quota Settings'], 'content' => 'quota'],
    14 => ['title'=> $translator['Lottery Basic Parameters'], 'content' => 'lottery_draw_records'],
    15 => ['title'=> 'Lottery Basic Parameters', 'content' => 'lottery_basic_params'],
    16 => ['title'=> $translator['Lottery Bonus Parameters'], 'content' => 'lottery_parameters'],
    17 => ['title'=> $translator['Administrator List'], 'content' => 'administrator_list'],
    18 => ['title'=> 'Backup & Restore', 'content' => 'backup_recovery']
  ];

  $sidebarMain = [
    1 => $translator['Business Flow'],
    2 => $translator['financial Management'],
    3 => $translator['Report Management'],
    4 => $translator['User Management'],
    5 => $translator['Promotion Management'],
    6 => $translator['User Bank Management'],
    7 => $translator['Game Management'],
    8 => $translator['Agent Management'],
    9 => $translator['System Management'],
  ];
  
//   $permission = [
//     1=> [1,2,3,4],
//     2 => [5,6,7],
//     3 => [8],
//     4 => [9,10],
//     5 => [11],
//     6=> [12],
//     7 => [14,15,15],
//     8 => [13],
//     9=> [17,18]
//   ];

foreach ($permissions as $sidebar => $menu) {
    ?>
     <div class="accordion-item">
          <div class="accordion-header" onclick="toggleAccordion(this)">
         <span><?=$sidebarMain[$sidebar]?></span>
          </div>
          <div class="accordion-content">
              <ul class="custom-list">
                <?php 
  
                 foreach ($menu as $item) {
                    ?>
                      <li id="tab1" class="tab-button item" value="<?=$sidebarMenu[$item]['content']?>"><?=$sidebarMenu[$item]['title']?></li>
                    <?php
                 }
                
                ?>
              </ul>
          </div>
      </div>
    <?php
    # code...
  }
?>


