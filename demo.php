<link rel="stylesheet"
href="app/assets/css/sidebar.css" />
<?php 
$sidebarMain = [
  1 => 'Business flow',
  2 => 'Financial Management',
  3 => 'Report Management',
  4 => 'User Management',
  5 => 'Promotion Management',
  6 => 'User Bank Management',
  7 => 'Game Management',
  8 => 'Agent Management',
  9 => 'System Management',
];

$sidebarItems = [
  1 => ['title'=> 'Account Transaction Details', 'content' => 'Account'],
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
  17 => ['title'=> 'Administrator List', 'content' => 'admin'],
  18 => ['title'=> 'Backup & Recovery', 'content' => 'Backup']
];

$permission = [
  1=> [1,2,3,4],
  2 => [5,6,7],
  3 => [8],
  4 => [9,10],
  5 => [11],
  6=> [12],
  7 => [14,15,15],
  8 => [13],
  9=> [17,18]
];

echo PASSWORD_HASH("1234",PASSWORD_BCRYPT);
exit;

foreach ($permission as $sidebar => $menu) {

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
                    <li id="tab1" class="tab-button item" value="account_transaction"><?=$sidebarItems[$item]?></li>
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
<script src="app/assets/js/sidebar.js"></script>