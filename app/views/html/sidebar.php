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
    1 => ['title'=> 'Account Transaction Details', 'content' => 'account_transaction'],
    2 => ['title'=> 'Game Betting Statistics', 'content' => 'Game'],
    3 => ['title'=> 'Lottery Betting Record', 'content' => 'Lottery'],
    4 => ['title'=> 'Track Records', 'content' => 'Track'],
    5 => ['title'=> 'Deposit Record', 'content' => 'Deposit'],
    6 => ['title'=> 'Withdrawal Records', 'content' => 'Withdrawal'],
    7 => ['title'=> 'Finance Fund Changes', 'content' => 'Finance'],
    8 => ['title'=> 'Win/Loss Report', 'content' => 'Win'],
    9 => ['title'=> 'User List', 'content' => 'Userlist'],
    10 => ['title'=> 'User Logs', 'content' => 'Userlogs'],
    11 => ['title'=> 'Invitation & Referral Links', 'content' => 'Invitation'],
    12 => ['title'=> 'Bank Card List', 'content' => 'Bank'],
    13 => ['title'=> 'Quota Settings', 'content' => 'quota'],
    14 => ['title'=> 'Lottery Draw Records', 'content' => 'lotterydraws'],
    15 => ['title'=> 'Lottery Basic Parameters', 'content' => 'lotterybasic'],
    16 => ['title'=> 'Lottery Bonus Parameters', 'content' => 'lotterybonus'],
    17 => ['title'=> 'Administrator List', 'content' => 'administrator_list'],
    18 => ['title'=> 'Backup & Recovery', 'content' => 'backup_recovery']
  ];

  $sidebarMain = [
    1 => 'Business Flow',
    2 => 'Financial Management',
    3 => 'Report Management',
    4 => 'User Management',
    5 => 'Promotion Management',
    6 => 'User Bank Management',
    7 => 'Game Management',
    8 => 'Agent Management',
    9 => 'System Management',
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


