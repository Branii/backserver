<?php
$controller = new Controller;
$adminEmail = $controller->getSeesion("isUserLoggedIn");
$userPermissions = $controller->getUserPermissions($adminEmail);
$definedPermissions = $controller->getPermissionSidebars();
$partners = $definedPermissions["partners"];

foreach ($userPermissions as $sidebar => $menu): ?>
    <div class="accordion-item accord-item">  
        <div class="accordion-header" onclick="toggleAccordion(this)">
            <span style="margin-left:15px"><?= $definedPermissions['title'][$sidebar]['icon'] ?>
              <span style="font-size:16px"><?= $translator[$definedPermissions['title'][$sidebar]['title']] ?></span>
            </span>
        </div>
        <div class="accordion-content">
            <?php if ($translator[$definedPermissions['title'][$sidebar]['title']] != "Partner Management" && $translator[$definedPermissions['title'][$sidebar]['title']] != "Payment Platform"): ?>
            <?php foreach ($partners as $partnerKey => $partnerName): ?>
                <div class="accordion-item partner-item">
                    <div class="accordion-header pn-wrapper" onclick="toggleAccordion(this)" id="<?= $partnerName."-".$partnerKey ?>">
                        <span style="margin-left:25px; font-size:15px; font-weight:bold">
                            <?= $partnerName ?>
                        </span>
                    </div>
                    <div class="accordion-content">
                        <ul class="custom-list">
                            <?php foreach ($menu as $item): ?>
                                <li class="tab-button item item-<?= $item ?>" value="<?= $definedPermissions['menu'][$item]['content'] ?>" data-partner="<?= $partnerKey ?>">
                                    <i class="bx bx-radio-circle-marked" style="font-size:20px;margin-left:10px"></i>
                                    <span style="margin-left:7px;font-size:14px">
                                        <?= $translator[$definedPermissions['menu'][$item]['title']] ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($translator[$definedPermissions['title'][$sidebar]['title']] == "Partner Management" || $translator[$definedPermissions['title'][$sidebar]['title']] == "Payment Platform"): ?>
                <div class="accordion-content">
                        <ul class="custom-list">
                            <?php foreach ($menu as $item): ?>
                                <li class="tab-button item item-<?= $item ?>" value="<?= $definedPermissions['menu'][$item]['content'] ?>" data-partner="<?= $partnerKey ?>">
                                    <i class="bx bx-radio-circle-marked" style="font-size:20px;margin-left:10px"></i>
                                    <span style="margin-left:7px;font-size:14px">
                                        <?= $translator[$definedPermissions['menu'][$item]['title']] ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
