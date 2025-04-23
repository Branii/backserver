<style>
.pagerlist {
    position: relative;
    /* Sets positioning context for absolute elements inside */
    padding: 20px;
    height: 80px;
    background-color: #f9f9f9;
}

.pagerlist {
    position: relative;
    /* Sets positioning context for absolute elements inside */
    padding: 20px;
    height: 80px;
    background-color: #f9f9f9;
}

.toplist-left-btn {
    position: absolute;
    top: 10px;
    /* Distance from the top */
    left: 10px;
    /* Distance from the left */
    padding: 5px 10px;
    /* background-color: #007bff; */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.toplist-center {
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

.toplist-right-btn {
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

.topplist-right {
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

.table-wrapperlist {
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

.queryholderquota {
    width: 33%;
    margin-right: 5px;
    background-color: #fff;
}

.queryholderlinks {
    width: 33%;
    position: absolute;
    background-color: #fff;
    color: #aaa;
    max-height: 300px;
    overflow-y: scroll;
    border-radius: 5px;
    padding: 10px;
    top: 90%;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    display: none;
}

.optionlink {
    text-align: left;
    border-bottom: solid 1px #eee;
    padding: 5px;
}

.optionlink:hover {
    background-color: #eee;
}

#userDropdownlist {
    max-height: 300px;
    overflow-y: scroll;
    overflow-x: hidden;
}

.no-resultslist {
    text-align: center;
    /* Center horizontally */
    vertical-align: middle;
    /* Center vertically */
    height: 20px;
    /* Set a minimum height to ensure centering */
    border: none;
}

.no-resultslist img {
    position: relative;
    top: 100px;
}

/* Custom Scrollbar for Webkit Browsers */
.table-wrapperfinances::-webkit-scrollbar {
    width: 5px;
    /* Slimmer scrollbar width */
    height: 5px;
    /* Slimmer scrollbar height for horizontal scrolling */
}

.table-wrapperfinances::-webkit-scrollbar-track {
    background: #f1f1f1;
    /* Lighter background for track */
    border-radius: 5px;
}

.table-wrapperfinances::-webkit-scrollbar-thumb {
    background-color: #ccc;
    /* Blue color for thumb */
    border-radius: 10px;
    cursor: pointer;
}

.table-wrapperfinances::-webkit-scrollbar-thumb:hover {
    background-color: #aaa;
    /* Darker blue on hover */
}

.editable {
    /* cursor: pointer; */
    background-color: #f9f9f9;
}

.editable:focus {
    outline: 1px solid #ccc;
    background-color: #fff;
    /* Optional: Make it stand out */
}

.financeDropdownu {
    width: 100%;
    position: absolute;
    background-color: #fff;
    color: #aaa;
    /* max-height: 500px; */
    overflow-y: scroll;
    border-radius: 5px;
    padding: 10px;
    top: 90%;
    /* z-index: 9999; */
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    display: none;
}

.annoucementDropdown {
    width: 24%;
    position: absolute;
    background-color: #fff;
    color: #aaa;
    max-height: 300px;
    overflow-y: scroll;
    border-radius: 5px;
    padding: 10px;
    top: 90%;
    z-index: 9999;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    display: none;
}

.queryholderlistt {
    width: 29%;
    margin-right: 5px;
    background-color: #fff;
}

/* Style for the scrollbar */
.annoucementDropdown::-webkit-scrollbar {
    width: 3px;
    /* Width of the scrollbar */
}

.annoucementDropdown::-webkit-scrollbar-track {
    background: #f0f0f0;
    /* Background of the scrollbar track */
    border-radius: 5px;
    /* Rounded corners */
}

.annoucementDropdown::-webkit-scrollbar-thumb {
    background: #ccc;
    /* Color of the scrollbar handle */
    border-radius: 5px;
    /* Rounded corners */
}

.annoucementDropdown::-webkit-scrollbar-thumb:hover {
    background: #aaa;
    /* Darker handle color on hover */
}


.tbl-financeheads {
    position: sticky;
    top: 0;
}

.sticky-financeheads {
    position: relative;
    bottom: 1px;
    background-color: red;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
}

.optionlist {
    text-align: left;
    border-bottom: solid 1px #eee;
    padding: 5px;
}

.optionlist:hover {
    background-color: #eee;
}
.arr {
    color: #909aa9;
    margin: 0px 1rem;
    }
</style>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"><span class="partner-name"> </span><span class="arr"> / </span><?= $translator['Announcement List']; ?></h4>
    </div>

    <div class="px-4 py-3 border-bottom pagerlist">
        <span class="top-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example" style="padding: 5px; width: auto;">
                <input type="text" id="financeDropdownnotify" class="form-control queryholderlistt usernames"
                    placeholder=" <?= $translator['Search usernames']; ?>" />
                <input name="usernames" type="hidden" class="userIdfinance" />
                <select class="form-control annoucementDropdown" size="5" style="display: none;" id="userfinaceDropdownnotify">
                    <!-- Options will be populated dynamically -->
                    
                </select>

                <select name="betsate" class="form-control form-select queryholderlistt messagestype"
                    data-bs-placeholder="Select Type">
                    <option value="">-<?= $translator['Message Type']; ?>-</option>
                    <option value="general"><?= $translator['Annoucememnt']; ?></option>
                    <option value="personal"><?= $translator['Notification']; ?></option>
                 
                </select>

                <input name="startdate" type="date" class="form-control queryholderlistt startfmessage"
                    placeholder="Name" />

                <input name="enddate" type="date" class="form-control queryholderlistt endmessage"
                    placeholder="Name" />
            </div>
            <!-- <div class="input-group mb-3">
				<span class="input-group-text" id="basic-addon12" style="background-color:rgb(238,238,238,.4);border:solid 1px #ddd"><i class='bx bx-search' style="font-size:18px;"></i></span>
				<input type="text" class="form-control queryholder userrebate" placeholder="Enter Rebate (%)" aria-label="Username" aria-describedby="basic-addon1" />
			</div> -->
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <!--enter is free-->
        </span>
        <span class="topplist-right" id="paginations" aria-label="Page navigation example">
            <div class="btn-group mb-2" role="group" aria-label="Basic example"
                style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <!-- <i ' ></i> -->
                <button type="button" class="btn bg-white-subtle messagemodal" value="right" aria-label="Refresh"
                    aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Add Message">
                    <i class="bx bx-plus" style="font-size: 20px;"></i>
                </button>

                <button type="button" class="btn bg-white-subtle player refreshmessage" value="right"
                    aria-label="Refresh" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh">
                    <i class="bx bx-refresh" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle executemessage" value="end" aria-label="Execute"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class="bx bx-check-double loaderfinanccs" style="font-size: 20px;"></i>
                </button>
                <!-- <button type="button" class="btn bg-white-subtle executedeposit" value="end" aria-label="Execute" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Execute">
                    <i class="bx bx-check-double loaderdeposit" style="font-size: 20px;"></i>
                </button> -->
            </div>
        </span>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1 table-wrapperfinances" id="maskfinances"
            style="height: 530px; overflow-y: scroll;">
            <table class="table text-nowrap mb-0 align-middle table-bordered">
                <thead class="text-dark fs-4 tbl-financeheads">
                    <tr class="financeheadrows">
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Title']; ?></h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Content']; ?></h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['DateTime']; ?></h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Message Duration']; ?></h6>
                        </th>


                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Message Type']; ?></h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['All User/Personal']; ?></h6>
                        </th>
                      
                      
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><?= $translator['Created By']; ?></h6>
                        </th>
                       
                        
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0"><i class='bx bx-dots-vertical-rounded'></i></h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="messagecontainer">
                    <tr class="no-resultslist">
                        <td colspan="9">
                            <img src="<?php echo BASE_URL; ?>assets/images/notfound.png" class="dark-logo"
                                alt="Logo-Dark" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="px-4 py-3 border-top pagerlist">
        <span class="toplist-left-btn">
            <div class="btn-group mb-2" role="group" aria-label="Basic example"
                style="border: solid 1px #eee; color: #bbb; background-color: #fff;">
                <!-- <button type="button" class="btn bg-white-subtle playerfinance" value="startli">
                    <i class="bx bx-chevrons-left" style="font-size: 20px;"></i>
                </button> -->
                <button type="button" class="btn bg-white-subtle playerfinance" value="leftlin">
                    <i class="bx bx-chevron-left" style="font-size: 20px;"></i>
                </button>
                <button type="button" class="btn bg-white-subtle playerfinance" value="rightlin">
                    <i class="bx bx-chevron-right" style="font-size: 20px;"></i>
                </button>
                <!-- <button type="button" class="btn bg-white-subtle playerfinance" value="endlin">
                    <i class="bx bx-chevrons-right" style="font-size: 20px;"></i>
                </button> -->
            </div>
        </span>
        <span class="toplist-center" aria-label=" navigation example">
            <span id="paging_infofmessage" style="color: #aaa;">---</span>
        </span>
        <span class="top-right-btn" aria-label="Page navigation example">
            <select class="left-element form-control numrowsnotfy" style="font-size: 12px;">
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="500">500</option>
            </select>
            <span class="toplist-right" id="paginationmessage" aria-label="Page navigation example">
                <!--Dynamic pagination-->
            </span>

        </span>

    </div>
</div>


<!-- Modal -->
<div id="announcementemodal" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Modal Header -->
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><?= $translator['Annoucement']; ?></div>
                        <div><i class="bx bx-message-square-x tclose"style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal" aria-label="Close"></i></div>
                    </div>
                </div>

                <!-- Form -->
                <form>
                    <!-- Username Field -->
                    <!-- Rebate Field -->
                    <div class="form-floating mb-3">
                        <select name="deposit" class="form-select form-control borders border-infos messagetype">
                        <option value="general"><?= $translator['General Announcement (All Users)']; ?></option>
                        <option value="new_users">Newly Registered Users Only</option>
                        <option value="personal"><?= $translator['User-Specific Announcement']; ?></option>
                        <option value="vipusers">VIP Users Only</option>
                        </select>
                        <label>
                            <i class="bx bx-list-ul me-2 fs-4 text-infos"></i>
                            <span class="border-start ps-3"><?= $translator['Annoucement Type']; ?></span>
                        </label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" id="financeinputnot" class="form-control" placeholder="<?= $translator['Search usernames']; ?>" />
                        <input type="hidden" class="userIdFieldss" />
                        <select name="usernames" class="form-control financeDropdownu" size="5" style="display: none;"
                            id="userfinaceDropdownl">
                            <!-- Options will be populated dynamically -->
                        </select>

                        <label>
                            <i class="bx bx-user me-2 fs-4 text-infod"></i>
                            <span class="border-start ps-3"><?=$translator['Username']; ?></span>
                        </label>
                    </div>

                    <div class="input-group mb-3">
                    <span class="input-group-text" id="" style="background-color:rgb(238,238,238,.4);border:solid 1px #ddd"><i class='bx bxs-calendar' style="font-size:18px;"></i></span>
                    <input type="date" class="form-control notistartdate" placeholder="Search ..." id="combinedatess" aria-describedby="basic-addon1" />
                    <input type="date" class="form-control notienddates" placeholder="Search ..." id="combinedates" aria-describedby="basic-addon1" />
                    </div>

                    <div class="form-floating mb-3">
                        <select name="deposit" class="form-select form-control borders border-infos vipusers">
                            <option value="1">VIP 1</option>
                            <option value="2">VIP 2</option>
                            <option value="3">VIP 3</option>
                        </select>
                        <label>
                            <i class="bx bx-list-ul me-2 fs-4 text-infos"></i>
                            <span class="border-start ps-3">Audience</span>
                        </label>
                      </div>

                         <div class="col-md-12 mb-3">
                            <div class="note-title">
                              <!-- <label class="form-label">Note Title</label> -->
                              <input type="text" id="note-has-title" class="form-control" minlength="25" placeholder="<?=$translator['Title']; ?>" />
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="note-description">
                              <!-- <label class="form-label">Note Description</label> -->
                              <textarea id="description" class="form-control" minlength="60" placeholder="<?=$translator['Description']; ?>" rows="3"></textarea>
                            </div>
                      </div>
                       <p></p>
                    <div class="form-floating mb-3">
                        <input name="agentname" type="text" class="form-control border sendby "
                            placeholder="Approved by" value="<?php echo $fullname['full_name']; ?>" readonly/>
                        <label>
                            <!-- <i class="bx bx-message me-2 fs-4 text-infod"></i> -->
                            <span class="border-start ps-3"><?=$translator['Approved By']; ?></span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-md-flex align-items-center">
                        <div class="form-check">
                            <!-- <input type="checkbox" class="form-check-input" id="sf2" value="check" /> -->
                            <!-- <label class="form-check-label" for="sf2"><?=$translator['Verify before submit']; ?></label> -->
                        </div>
                        <div class="mt-3 mt-md-0 ms-auto">
                            <button type="button" class="btn hstack gap-6 sendmessagebtn" style="border: solid 1px #ccc;"
                                data-bss-dismiss="modal" aria-label="Close">
                                <i class="bx bx-send loaderfinancc"></i>
                                <?=$translator['Submit']; ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>



<div id="editmessage" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Modal Header -->
                <div class="text-center mt-2 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div> <?=$translator['Edit Annoucement']; ?></div>
                        <div><i class="bx bx-message-square-x tclose"
                                style="color: #868c87; font-size: 25px; cursor: pointer;" data-bs-dismiss="modal"
                                aria-label="Close"></i></div>
                    </div>
                </div>

                <!-- Form -->
                <form>
                    <!-- Username Field -->
                     <input type= "text" id="updatemsgid" hidden/>
                 
                    <!-- <div class="form-floating mb-3">
                        <select name="deposit" class="form-select form-control borders border-infos depositt">
                            <option value="1">All Users</option>
                            <option value="2">VIP Users</option>
                            <option value="3">New Users</option>
                        </select>
                        <label>
                            <i class="bx bx-list-ul me-2 fs-4 text-infos"></i>
                            <span class="border-start ps-3">Audience</span>
                        </label>
                    </div> -->

                     <div class="col-md-12 mb-3">
                            <div class="note-title">
                              <label class="form-label"><?=$translator['Title']; ?></label>
                              <input type="text" id="note-has-titles" class="form-control" minlength="25" placeholder="Title" />
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="note-description">
                              <label class="form-label"><?=$translator['Description']; ?></label>
                              <textarea id="descriptions" class="form-control" minlength="60" placeholder="Description" rows="3"></textarea>
                            </div>
                          </div>
                       <br>
                    <div class="form-floating mb-3">
                        <input name="agentname" type="text" class="form-control border sendby "
                            placeholder="Approved by" value="<?php echo $fullname['full_name']; ?>" readonly/>
                        <label>
                            <!-- <i class="bx bx-message me-2 fs-4 text-infod"></i> -->
                            <span class="border-start ps-3"><?=$translator['Approved By']; ?></span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-md-flex align-items-center">
                        <div class="form-check">
                            <!-- <input type="checkbox" class="form-check-input" id="sf2" value="check" /> -->
                            <!-- <label class="form-check-label" for="sf2"><?=$translator['Verify before submit']; ?></label> -->
                        </div>
                        <div class="mt-3 mt-md-0 ms-auto">
                            <button type="button" class="btn hstack gap-6 updatemessagebtn" style="border: solid 1px #ccc;"
                                data-bss-dismiss="modal" aria-label="Close">
                                <i class="bx bx-send loaderfinanup"></i>
                                <?=$translator['Submit']; ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>