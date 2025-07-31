<style>
    .pager {
        position: relative;
        /* Sets positioning context for absolute elements inside */
        padding: 20px;
        height: 80px;
        background-color: #f9f9f9;
    }

    .pager1 {
        position: relative;
        /* Sets positioning context for absolute elements inside */
        padding: 20px;
        height: 80px;
        background-color: #f9f9f9;
    }

    .top-left-btn {
        position: absolute;
        top: 10px;
        /* Distance from the top */
        left: 10px;
        /* Distance from the left */
        padding: 5px 10px;
        /* background-color: red; */
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .top-center {
        position: absolute;
        top: 50%;
        /* Vertically centers the button */
        left: 50%;
        /* Horizontally centers the button */
        transform: translate(-50%, -50%);
        /* Adjusts for button size */
        padding: 5px 15px;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .top-right-btn {
        position: absolute;
        top: 10px;
        /* Distance from the top */
        right: 10px;
        /* Distance from the right */
        padding: 5px 10px;
        /* background-color: red; */
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        /* Optional: Adds space between elements */
        align-items: center;
        /* Optional: Vertically centers the elements */
    }

    .topp-right {
        position: absolute;
        top: 10px;
        /* Distance from the top */
        right: 10px;
        /* Distance from the right */
        padding: 5px 10px;
        /* background-color: #28a745; */
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .queryholder {
        width: 19%;
        margin-right: 5px;
        background-color: #fff;
    }

    .option {
        text-align: left;
        border-bottom: solid 1px #eee;
        padding: 5px;
    }

    .option:hover {
        background-color: #eee;
    }

    .no-results {
        text-align: center;
        /* Center horizontally */
        vertical-align: middle;
        /* Center vertically */
        height: 20px;
        /* Set a minimum height to ensure centering */
        border: none;
    }

    .no-results img {
        position: relative;
        top: 100px;
    }

    /* Custom Scrollbar for Webkit Browsers */
    .table-wrapperbaic::-webkit-scrollbar {
        width: 5px;
        /* Slimmer scrollbar width */
        height: 5px;
        /* Slimmer scrollbar height for horizontal scrolling */
    }

    .table-wrapperbaic::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Lighter background for track */
        border-radius: 5px;
    }

    .table-wrapperbaic::-webkit-scrollbar-thumb {
        background-color: #ccc;
        /* Blue color for thumb */
        border-radius: 10px;
        cursor: pointer;
    }

    .table-wrapperbaic::-webkit-scrollbar-thumb:hover {
        background-color: #aaa;
        /* Darker blue on hover */
    }

    .table-wrapperbaic {
        overflow: hidden;
        /* Hide the default scrollbar */
        white-space: nowrap;
        max-width: 100%;
        /* Adjust based on your needs */
        margin-bottom: 10px;
        top: 0;
        left: 0;
        right: 0;
        height: 10px;
        background: rgb(38, 57, 77) 0px 20px 30px -10px;
        /* Ensure it doesn't interfere with content */
        z-index: 10;
    }

    .sticky-headerbasic {
        position: relative;
        bottom: 1px;
        background-color: red;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
    }

    .left-element {
        position: relative;
        bottom: 8px;
        height: 35px;
        background-color: #fff;
        margin-right: 5px;
    }

    .active > .page-link {
        background-color: orangered !important;
        border: none;
    }

    .tbl-headerbasic {
        position: sticky;
        top: 0;
    }

    .pins {
        padding: 5px;
        border-bottom: solid 1px rgb(110, 129, 146, 0.1);
    }
</style>

<span id="turnon-text" data-translation="<?= $translator['Turn On']; ?>" style="display: none;"></span>
<span id="turnoff-text" data-translation="<?= $translator['Turn Off']; ?>" style="display: none;"></span>
<span id="Edit-text" data-translation="<?= $translator['Edit']; ?>" style="display: none;"></span>
<span id="error_text" style="display: none;"><?= $translator['ERROR']; ?></span>
<span id="success_text" style="display: none;"><?= $translator['SUCCESS']; ?></span>
<span id="lottery_already_text" style="display: none;"><?= $translator['LOTTERY_ALREADY']; ?></span>
<span id="turned_on_text" style="display: none;"><?= $translator['TURNED_ON']; ?></span>
<span id="turned_off_text" style="display: none;"><?= $translator['TURNED_OFF']; ?></span>
<span id="lottery_status_updated_text" style="display: none;"><?= $translator['LOTTERY_STATUS_UPDATED']; ?></span>
<span id="lottery_updated_text" style="display: none;"><?= $translator['LOTTERY_UPDATED']; ?></span>
<span id="confirm_toggle_text" style="display: none;"><?= $translator['CONFIRM_TOGGLE']; ?></span>
<span id="turn_on_text" style="display: none;"><?= $translator['TURN_ON']; ?></span>
<span id="turn_off_text" style="display: none;"><?= $translator['TURN_OFF']; ?></span>
<span id="state_on" style="display: none;"><?= $translator['state_on'] ?></span>
<span id="state_off" style="display: none;"><?= $translator['state_off'] ?></span>

<span id="trans-page" style="display: none;" class="hidden"><?= $translator['Page'] ?? 'Page' ?></span>
<span id="trans-of" style="display: none;" class="hidden"><?= $translator['of'] ?? 'of' ?></span>
<span id="trans-pages" style="display: none;" class="hidden"><?= $translator['pages'] ?? 'Pages' ?></span>

<span id="trans-turnedon" style="display: none;" class="hidden"><?= $translator['Turned On'] ?? 'Turned On' ?></span>
<span id="trans-turnedoff" style="display: none;" class="hidden"><?= $translator['Turned Off'] ?? 'Turned Off' ?></span>

<div id="lb-edit" class="modal fade" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $translator['Edit Lottery']; ?></h5>
                <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
            </div>
            <div class="scrollable-container">
                <div class="card border">
                    <div class="card-body">
                        <h4 class="card-title"><?= $translator['Lottery Info']; ?></h4>
                        <form id="accountDetailsForm">
                            <div class="row">
                                <input type="hidden" value="" id="lb-id-holder" />
                                <input type="hidden" value="" id="lb-lottery-type" />
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="lb-dialog-mx-prize" class="form-label"><?= $translator['Maximum Prize Amount Per Bet']; ?></label>
                                        <input type="text" class="form-control" id="lb-dialog-mx-prize" placeholder="<?= $translator['Maximum Prize Amount Per Bet']; ?>" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="lb-dialog-mx-win" class="form-label"><?= $translator['Maximum Winnings Per Person Per Issue']; ?></label>
                                        <input type="text" class="form-control" id="lb-dialog-mx-win" placeholder="<?= $translator['Maximum Winnings Per Person Per Issue']; ?>" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="lb-dialog-mx-amt" class="form-label"><?= $translator['Maximum Bet Amount Per Issue']; ?></label>
                                        <input type="text" class="form-control" id="lb-dialog-mx-amt" placeholder="<?= $translator['Maximum Bet Amount Per Issue']; ?>" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="lb-dialog-mn-amt" class="form-label"><?= $translator['Minimum Bet Amount Per Issue']; ?></label>
                                        <input type="text" class="form-control" id="lb-dialog-mn-amt" placeholder="<?= $translator['Minimum Bet Amount Per Issue']; ?>" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="lb-dialog-clsing" class="form-label"><?= $translator['Lock Time for Closing Bets']; ?></label>
                                        <input type="text" class="form-control" id="lb-dialog-clsing" placeholder="<?= $translator['Lock Time for Closing Bets']; ?>" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="lb-dialog-sorting-weight" class="form-label"><?= $translator['Sorting Weight']; ?></label>
                                        <input type="text" class="form-control" id="lb-dialog-sorting-weight" placeholder="<?= $translator['Sorting Weight']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-primary" id="lb-update-lottery"><?= $translator['Save']; ?></button>
                                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal"><?= $translator['Cancel']; ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="lb-toggle-lottery" class="modal fade" tabindex="-1" aria-modal="true" role="dialog" style="display: none; top: 363px; left: 191px;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="width: 75%;">
            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-infos" style="color: #2a3547;"><?= $translator['Toggle Lottery']; ?></h5>
                        <i class="bx bx-message-square-x lb-tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i>
                    </div>
                </div>
                <form>
                    <div class="modal-body scrollable-container">
                        <div style="overflow: hidden; text-align: center; font-size: large; font-weight: 400;">
                            <p id="toggle-lottery-msg"></p>
                        </div>
                    </div>
                    <div class="d-md-flex align-items-center">
                        <div class="mt-3 mt-md-0 ms-auto">
                            <button type="button" class="btn hstack gap-6 update-lottery-state-btn" style="border: solid 1px #ccc; color: #2a3547 !important;">
                                <?= $translator['Confirm']; ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"><?= $translator['Lottery Basic Parameters']; ?></h4>
    </div>

    <div class="px-4 py-3 border-bottom pagerlist1">
        <span class="top-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example " style="padding: 5px; width: 110%;">
                <select name="betsate" class="form-control form-select queryholderlistt lotteryTypes depositestate" data-bs-placeholder="Select Type" id="lottery" style="width: 70%;">
                <option value="">--<?= $translator['Select Lottery']; ?>--</option>
                   
                </select>

                <select name="lotteryname" class="form-control form-select queryholderlistt selectpartner" style="width: 70%;"> </select>
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topplist-right" id="paginations" aria-label="Page navigation example">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <button type="button" class="btn bg-white-subtle addnewlottery" value="" aria-label="Search" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="add new lottery">
                    <i class="bx bx-plus loaderlist" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle player lb-refreshlist" value="" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class="bx bx-refresh" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle fetch-lotter-basic-records" value="" aria-label="Search" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Search">
                    <i class="bx bx-check-double loaderlist" style="font-size: 20px;"></i>
                </button>
            </div>
        </span>
    </div>

    <!-- These spans are invisible but hold the translation text -->

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperbaic" id="masklotterygames" style="height: 530px; overflow-y: scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered table-hover">
                <thead class="text-dark fs-4 tbl-headerbasic">
                    <tr class="headrowbasic">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['ID']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Lottery Icon']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Sorting Weight']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Lottery Name']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Lottery Source']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Lottery Description']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Lottery Code']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Max Prize Per Ticket']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Max Prize Many Tickets']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Max Bet Amount Per Ticket']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Min Bet Amount Per Ticket']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Lock Time For Closing Bets']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Lottery Status']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class="bx bx-dots-vertical-rounded"></i></h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="lot-basic-dtholder" class="tbl-content">
                    <tr class="no-results">
                        <td colspan="9">
                            <img src="<?php echo BASE_URL; ?>assets/images/notfound.png" class="dark-logo" alt="Logo-Dark" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="px-4 py-3 border-top pager">
        <span class="top-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <button type="button" class="btn bg-white-subtle lb_data_scroll" value="leftb">
                    <i class="bx bx-chevron-left" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle lb_data_scroll" value="rightb">
                    <i class="bx bx-chevron-right" style="font-size: 20px;"></i>
                </button>
            </div>
        </span>
        <span class="top-center" aria-label=" navigation example">
            <span id="paging_info_drawsw" style="color: #aaa;">---</span>
        </span>

        <span id="lb-pagination-pages-wrapper" class="top-right-btn" aria-label="Page navigation example">
            <select class="left-element form-control numrows" style="font-size: 12px;">
                <!-- <option value="5" class="fromnumrows">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="500">500</option> -->

                <option value="5" class="fromnumrows"><?= $translator['5'] ?></option>
                <option value="10"><?= $translator['10'] ?? '10' ?></option>
                <option value="20"><?= $translator['20'] ?? '20' ?></option>
                <option value="50"><?= $translator['50'] ?? '50' ?></option>
                <option value="100"><?= $translator['100'] ?? '100' ?></option>
                <option value="200"><?= $translator['200'] ?? '200' ?></option>
                <option value="500"><?= $translator['500'] ?? '500' ?></option>
            </select>
            <span id="lb-pagination" class="right-element"> </span>
        </span>
    </div>
</div>

<div id="addnewgames" class="modal fade" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog-scrollable modal-lg">
        <div class="modal-content modal-filled" style="background-color: #f9f9f9;">
            <div class="modal-body p-4">
                <div class="container">
                    <form enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="upload_logo">Upload Logo (Preview Below)</label>
                            <input type="file" id="upload_logo" name="upload_logo" accept="image/*" onchange="previewLogo(event)" />
                        </div>

                        <h2>Add New Lottery</h2>

                        <div class="input-flex">
                            <div class="form-group">
                                <label for="name">Lottery Name*</label>
                                <input type="text" id="name" name="name" />
                            </div>
                            <div class="form-group">
                                <label for="logo">Logo*</label>
                                <input type="text" id="logo" name="logo" disabled />
                            </div>
                        </div>

                        <div class="input-flex">
                            <div class="form-group">
                                <label for="num_of_balls">Number of Balls*</label>
                                <input type="number" id="num_of_balls" name="num_of_balls" />
                            </div>
                            <div class="form-group">
                                <label for="seconds_per_issue">Seconds Issue</label>
                                <select id="seconds_per_issue" name="seconds_per_issue">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="60">60</option>
                                    <option value="120">120</option>
                                    <option value="160">160</option>
                                    <option value="200">200</option>
                                    <option value="260">260</option>
                                    <option value="300">300</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="game_group">Game Group*</label>
                                <select id="game_group" name="game_group">
                                    <option value="5d">5D</option>
                                    <option value="pk10">PK10</option>
                                    <option value="3d">3D</option>
                                    <option value="fast3">FAST 3</option>
                                    <option value="11x5">11x5</option>
                                    <option value="mark6">Mark 6</option>
                                    <option value="happy8">Happy 8</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-flex">
                            <div class="form-group">
                                <label for="max_ball">Max Ball*</label>
                                <input type="number" id="max_ball" name="max_ball" />
                            </div>
                            <div class="form-group">
                                <label for="min_ball">Min Ball*</label>
                                <input type="number" id="min_ball" name="min_ball" />
                            </div>
                        </div>

                        <div class="input-flex">
                            <!-- <div class="form-group">
                                <label for="starttime">Start Time*</label>
                                <input type="time" id="starttime" name="starttime" />
                            </div>
                            <div class="form-group">
                                <label for="stoptime">Stop Time*</label>
                                <input type="time" id="stoptime" name="stoptime" />
                            </div> -->
                            <div class="form-group">
                                <label for="starttime">Start Time*</label>
                                <input type="time" id="starttime" name="starttime" step="1" />
                            </div>
                            <div class="form-group">
                                <label for="stoptime">Stop Time*</label>
                                <input type="time" id="stoptime" name="stoptime" step="1" />
                            </div>

                            <div class="form-group">
                                <label for="lottery_model">Lottery Model*</label>
                                <select id="lottery_models" name="lottery_models">
                                    <option value="3">Boardgame</option>
                                    <option value="2">Fantan</option>
                                    <option value="1">Standard</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lottery_type">Lottery Type*</label>
                            <select id="lottery_type" name="lottery_type">
                                <option value="10">Happy 8</option>
                                <option value="8">Mark 6</option>
                                <option value="6">11x5</option>
                                <option value="5">3D</option>
                                <option value="3">Fast 3</option>
                                <option value="2">PK 10</option>
                                <option value="1">5D</option>
                            </select>
                        </div>

                        <button type="submit" class="submit-btn">Submit Lottery</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>

<!-- add lottery game  modal start -->
<div id="addlottery-modals" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content rounded-4 p-4" style="background-image: url('your-background-image.jpg'); background-size: cover; background-position: center; backdrop-filter: blur(3px);">
            <div class="modal-header border-0">
                <h5 class="modal-title w-100 text-center fw-bold text-dark"><?= $translator['Add New Lottery']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="lotteryForm" name="lotteryForm">
                 
                    <div class="col-md-12">
                        <center>
                            <img id="logoPreview" src="#" alt="Logo Preview" style="max-width: 200px; display: none; max-height: 150px;" />
                        </center>
                    </div>
                 
                    <div class="row g-3">
                        <!-- Row 1 -->
                        <div class="col-md-6">
                            <label class="form-label"><?= $translator['Lottery Name']; ?></label>
                            <input type="text" class="form-control" name="name" id="namee" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><?= $translator['Alias']; ?></label>
                            <input type="text" class="form-control" name="alias" id="alias" />
                        </div>

                        <div class="col-md-4">
                            <label class="form-label"><?= $translator['Lottery Type']; ?></label>

                            <?= $translator['Select Lottery']; ?>

                            <!-- Game Group -->
                            <select class="form-select lotteryTypeSelect game_groups" name="game_groups" id="lottery_types" style="width: 100%;">
                                <option value="" disabled selected><?= $translator['Select Game Group']; ?></option>
                            </select>
                        </div>

                        <!-- Row 2 -->
                        <div class="col-md-4">
                            <label class="form-label"><?= $translator['Number of Balls']; ?></label>
                            <input type="number" class="form-control" name="number_of_balls" id="numm_of_balls" readonly />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?= $translator['Seconds Issue']; ?></label>
                            <select class="form-select secondsselect" name="seconds_per_issue" id="secondss_per_issue">
                                <option value="" disabled selected><?= $translator['Select Seconds']; ?></option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?= $translator['Min Ball']; ?></label>
                            <input type="number" class="form-control" name="minn_ball" id="minn_ball" readonly />
                        </div>
                        <!-- Row 3 -->
                        <div class="col-md-6">
                            <label class="form-label"><?= $translator['Max Ball']; ?></label>
                            <input type="number" class="form-control" name="maxx_ball" id="maxx_ball" readonly />
                        </div>

                        <!-- Row 4 -->
                        <div class="col-md-4">
                            <label class="form-label"><?= $translator['Start time']; ?></label>
                            <input type="time" class="form-control" name="starttime" id="starttimee" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?= $translator['Stop time']; ?></label>
                            <input type="time" class="form-control" name="stoptime" id="stoptimee" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?= $translator['Lottery model']; ?></label>
                            <select class="form-select modelTypess" name="lottery_model" id="lottery_model">
                                <option value="" disabled selected> <?= $translator['Select Game Model']; ?></option>
                            </select>
                        </div>
                        <!-- Row 5 -->
                        <div class="col-md-12">
                            <label class="form-label"> <?= $translator['Select default image']; ?></label>
                            <select id="" class="form-select gameimage" id="lottery_logo_name" style="width: 100%;">
                                <option value="" disabled selected><?= $translator['select corresponding game image']; ?></option>
                                <option value="Royal-5.jpg">Royal-5.jpg</option>
                                <option value="Max-3D.jpg">Max-3D.jpg</option>
                                <option value="Fast-3.jpg">Fast-3.jpg</option>
                                <option value="Royal-Pk-10.jpg">Royal-Pk-10.jpg</option>
                                <option value="Rapid-11x5.jpg">Rapid-11x5.jpg</option>
                                <option value="Radip-Mark6.jpg">Radip-Mark6.jpg</option>
                                <option value="Rapid-Happy-8.jpg">Rapid-Happy-8.jpg</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-4 addLottery"><?= $translator['Submit Lottery']; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add lottery  game Modal ends here -->

<!-- Update game Modal starts here -->
<div id="lb-uploadimage" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="width: 75%;">
            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-info"><?= $translator['Update Image']; ?></h5>
                        <i class="bx bx-message-square-x lb-tclose" data-bs-dismiss="modal" style="cursor: pointer;"></i>
                    </div>
                </div>

                <form id="lotteryImageFormmm">
                    <input type="hidden" name="lottery_game_id" id="lottery_game_id" readonly />
                  
                    <div class="mb-3 text-center">
                        <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-height: 200px;" />
                    </div>
                    <div class="mb-3">
                        <label for="lottery_logo_file" class="form-label"><?= $translator['Select Image']; ?></label>
                        <input type="file" class="form-control" name="lottery_logo_file" id="lottery_logo_file" accept="image/*" required />
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary updateee-game-image-btn" id="upload"><?= $translator['Confirm']; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Update game Modal ends here -->
