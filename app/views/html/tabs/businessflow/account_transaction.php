
<<<<<<< HEAD
=======
</style>
>>>>>>> refs/remotes/origin/online
<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"><?= $translator['Account Transaction Details']; ?></h4>
    </div>
    <div class="px-4 py-3 border-bottom pager1">
        <span class="top-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: auto;">
                <input type="text" id="transuser" class="form-control queryholdertrans usernames transuser" placeholder="Search usernames" />
                <input name="usernames" type="hidden" class=""/>
                <select class="form-control useraccount" size="5" style="display: none;" id="userAccountDropdown">
                    <!-- Options will be populated dynamically -->
                </select>
                <input type="text" class="form-control queryholdertrans clearitem"  id= "transactionId" aria-describedby="name" placeholder="Enter Transaction ID" />
                
                <select name="order_type" class="form-control form-select queryholdertrans " id="ordertypetrans" data-bs-placeholder="Select Type">
                    <option value="">-<?= $translator['Transaction Type']; ?>-</option>
                    <option value="1"><?= $translator['Deposit']; ?></option>
                    <option value="2"><?= $translator['Win Bonus']; ?></option>
                    <option value="3"> <?= $translator['Bet Awarded']; ?></option>
                    <option value="4"><?= $translator['Withdrawal']; ?></option>
                    <option value="6"><?= $translator['Bet Cancelled']; ?></option>
                    <option value="5"><?= $translator['Bet Deduct']; ?></option>
                    <option value="7"><?= $translator['Rebates']; ?></option>
                    <option value="8"><?= $translator['Self Rebate']; ?></option>
                    <option value="9"><?= $translator['Sending Red Envelope']; ?></option>
                    <option value="10"><?= $translator['Red Envelope Receive']; ?></option>
                    <option value="11"><?= $translator['Bet Refund']; ?></option>
                  
                </select>
                <input type="date" class="form-control queryholdertrans "  id="startdatrans"  aria-describedby="name" placeholder="Name" />
                <input type="date" class="form-control queryholdertrans "  id="enddatetrans" aria-describedby="name" placeholder="Name" />
            </div>
        </span>
        <span class="top-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topp-right" id="paginations" aria-label="Page navigation example">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <button type="button" class="btn bg-white-subtle" value="right" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="PDF">
                    <i class="bx bx-file" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle" value="right" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="XLS">
                    <i class="bx bx-file-blank" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle" value="right">
                    ::
                </button>
                <button type="button" class="btn bg-white-subtle accountrefresh" value="right" aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class="bx bx-refresh" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle executetrans" value="end" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class="bx bx-check-double loader" style="font-size: 20px;"></i>
                </button>
            </div>
        </span>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapper" id="mask" style="height: 530px; overflow-y: scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered table-hover">
                <thead class="text-dark fs-4 tbl-header">
                    <tr class="accheaderrow">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['ID Number']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Username']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Transaction Type']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Amount']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Balance']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Bet Stake Time']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Server Time']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Transaction ID']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Status']; ?></h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class="bx bx-dots-vertical-rounded"></i></h6>
                        </th>
                    </tr>
                </thead>

                <tbody id="dataContainer" class="tbl-content">
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
                <!-- <button type="button" class="btn bg-white-subtle player" value="start">
                    <i class="bx bx-chevrons-left" style="font-size: 20px;"></i>
                </button> -->
                <button type="button" class="btn bg-white-subtle player" value="left">
                    <i class="bx bx-chevron-left" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle player" value="right">
                    <i class="bx bx-chevron-right" style="font-size: 20px;"></i>
                </button>
                <!-- <button type="button" class="btn bg-white-subtle player" value="end">
                    <i class="bx bx-chevrons-right" style="font-size: 20px;"></i>
                </button> -->
            </div>
        </span>
        <span class="top-center" aria-label=" navigation example">
            <span id="paging_info" style="color: #aaa;">---</span>
        </span>
        <span class="top-right-btn" aria-label="Page navigation example">
            <select class="left-element form-control numrowstrans" style="font-size: 12px;">
             
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="500">500</option>
            </select>
            <span id="pagination" class="right-element">--pagination--- </span>
        </span>
    </div>
</div>

<div id="signup-modal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between">
                        <div><?= $translator['Transaction Info']; ?></div>
                        <div><i class="bx bx-message-square-x tclose" style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
                    </div>
                </div>
                <form>
                    <div class="row" id="viewbetdatahide">
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <tbody id="row1"></tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <tbody id="row2"></tbody>
                            </table>
                        </div>
                    </div>
                </form>

                <div id="loadingIndicator" class="spinner-border text-primary" role="status" style="display: none; position: relative; left: 40%;">
                    <span class="sr-only">Loading...</span>
                </div>

                <div id="transacttbl">
                    <table class="table table-hover table-bordered text-nowrap mb-0 table-responsive" id="transtbl">
                        <thead>
                            <tr>
                                <!-- <th class="font-weight-normal">#</th> -->
                                <th class="font-weight-normal"><?= $translator['Username']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Level']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Deposit/Withdrawal Type']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Transaction Amount']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Balance']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Transaction Time']; ?></th>
                                <!-- <th class="font-weight-normal"><?= $translator['Turnover Requirement']; ?></th> -->
                                <!-- <th class="font-weight-normal">Bet Slip</th> -->
                                <th class="font-weight-normal"><?= $translator['Reviews']; ?></th>
                            </tr>
                        </thead>
                        <tbody class="">
                            <?php

                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="loadingIndicator" class="spinner-border text-primary" role="status" style="display: none; position: relative; left: 40%;">
                    <span class="sr-only">Loading...</span>
                </div>
                <div id="transredenvelop">
                    <table class="table table-hover table-bordered text-nowrap mb-0 table-responsive" id="transtbls">
                        <thead>
                            <tr>
                                <th class="font-weight-normal"><?= $translator['ID Number']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Username']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Transaction Type']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Amount']; ?></th>
                                <!-- <th class="font-weight-normal"><?= $translator['Credit Amount']; ?></th> -->
                                <th class="font-weight-normal"><?= $translator['Balance']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Date/Time']; ?></th>
                                <!-- <th class="font-weight-normal"><?= $translator['Game']; ?></th> -->
                                <th class="font-weight-normal"><?= $translator['Transaction ID']; ?></th>
                                <th class="font-weight-normal"><?= $translator['Status']; ?></th>
                                <!-- <th class="font-weight-normal"><?= $translator['Reviews']; ?></th> -->
                            </tr>
                        </thead>
                        <tbody class="">
                            <?php

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script id="translations" type="application/json">
    <?= json_encode($translator); ?>
</script>