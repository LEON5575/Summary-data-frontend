<!-- app/Views/report_sql.php -->
<!-- 
//!download file -->
<div class="container-xl">
    <div class="table-responsive d-flex flex-column">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert w-50 align-self-center alert-success alert-dismissible fade show" role="alert">
                <?php echo session()->getFlashdata('success'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 style="color: black; background-color: whitesmoke;"><b>Elastic Report</b></h2>
                    </div>
                    <div class="col-sm-6 text-right">
                    <a href="#filterModal" data-toggle="modal"> <button type="button" class="btn btn-warning">Filter</button></a>
                        <a href="<?php echo site_url('spreadsheet_elastic') ?>" class="btn btn-info" role="button">Download Logger Report</a>
                        <a href="<?php echo site_url('summary_data_elastic') ?>" class="btn btn-primary" role="button">Elastic Hourly Report</a>
                    </div>
                </div>
            </div>
            
            <table class="table table-bordered">
    <thead>
        <tr>
            <th>Datetime</th>
            <th>Call Type</th>
            <th>Dispose Type</th>
            <th>Duration</th>
            <th>Agent Name</th>
            <th>Campaign Name</th>
            <th>Process Name</th>
            <th>Lead Set ID</th>
            <th>Reference UUID</th>
            <th>Customer UUID</th>
            <th>Hold Time</th>
            <th>Mute Time</th>
            <th>Ringing Time</th>
            <th>Transfer Time</th>
            <th>Conference Time</th>
            <th>Call Time</th>
            <th>Dispose Time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $user): ?>
            <tr>
                <td><?php echo $user['datetime']; ?></td>
                <td><?php echo $user['calltype']; ?></td>
                <td><?php echo $user['disposetype']; ?></td>
                <td><?php echo $user['duration']; ?></td>
                <td><?php echo $user['agentname']; ?></td>
                <td><?php echo $user['campaignname']; ?></td>
                <td><?php echo $user['processname']; ?></td>
                <td><?php echo $user['leadsetid']; ?></td>
                <td><?php echo $user['referenceUuid']; ?></td>
                <td><?php echo $user['customerUuid']; ?></td>
                <td><?php echo $user['holdtime']; ?></td>
                <td><?php echo $user['mutetime']; ?></td>
                <td><?php echo $user['ringingtime']; ?></td>
                <td><?php echo $user['transfertime']; ?></td>
                <td><?php echo $user['conferencetime']; ?></td>
                <td><?php echo $user['calltime']; ?></td>
                <td><?php echo $user['disposetime']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="d-flex justify-content-center align-items-center">
    <ul class="pagination fade-in">
        <?= $pager ?>
    </ul>
</div>

<style>
    .pagination {
        list-style: none;
        padding: 0;
        margin: 20px 0;
        display: flex;
        gap: 10px;
    }

    .pagination li {
        display: inline;
    }

    .pagination a {
        text-decoration: none;
        padding: 10px 15px;
        border: 1px solid darkkhaki;
        color:rgba(123, 255, 0, 0.39);
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    .pagination a:hover {
        background-color: lawngreen;
        color: white;
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>
<!-- //&filter modal -->
<div class="modal fade" id="filterModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= site_url('filterElastic') ?>" method="get">
                <div class="modal-header">
                    <h4 class="modal-title" id="filterModalLabel">Filter User</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="campaign_name">Campaign Name</label>
                        <input type="text" class="form-control" name="campaign_name"  autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="agent_name">Agent Name</label>
                        <input type="text" class="form-control" name="agent_name"  autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="call_type">Call Type</label>
                        <select name="call_type" class="form-select" aria-label="Default select example" >
                            <option selected disabled>Select call type</option>
                            <option value="autofail">AutoFail</option>
                            <option value="autodrop">AutoDrop</option>
                            <option value="dispose">Dispose</option>
                            <option value="missed">Missed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" value="Filter">
                </div>
            </form>
        </div>
    </div>
</div>
        </div>
    </div>
</div>