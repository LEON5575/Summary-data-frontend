<!-- app/Views/report_sql.php -->
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
                        <h2 style="color: black; background-color: whitesmoke;"><b>SQL Report</b></h2>
                    </div>
                    <div class="col-sm-6 text-right">
                    <a href="<?php echo site_url('summary_data') ?>" class="btn btn-danger" role="button">SQL Hourly Report</a>
                        <a href="#filterModal" data-toggle="modal">
                            <button type="button" class="btn btn-dark">Filter</button>
                        </a>
                        <a href="<?php echo site_url('spreadsheet') ?>" class="btn btn-primary" role="button">Download Logger Report</a>
                        <!-- <a href="<?php echo site_url('spreadsheet_1') ?>" class="btn btn-warning" role="button">Download Summary Report</a> -->
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
                    <?php if ($users && !isset($users['error'])): ?>
                        <?php foreach ($users as $user): ?>
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
                    <?php else: ?>
                        <tr>
                            <td colspan="16" class="text-center">No records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Filter Modal -->
<!-- Filter Modal -->
<div class="modal fade" id="filterModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= site_url('filter') ?>" method="GET">
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
                            <option value="AutoFail">AutoFail</option>
                            <option value="AutoDrop">AutoDrop</option>
                            <option value="Dispose">Dispose</option>
                            <option value="Missed">Missed</option>
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

            <div class="d-flex justify-content-center align-items-center">
                <ul class="pagination">
                    <?php if (isset($pager) && $pager['total'] > 1): ?>
                        <?php
                        $currentPage = $pager['current'];
                        $totalPages = $pager['total'];
                        $startPage = max(1, $currentPage - 1);
                        $endPage = min($totalPages, $currentPage + 1);

                        if ($currentPage == 1) {
                            $endPage = min(3, $totalPages);
                        } elseif ($currentPage == $totalPages) {
                            $startPage = max(1, $totalPages - 2);
                        }
                        ?>

                        <li class="page-item <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo max(1, $currentPage - 1); ?>">Previous</a>
                        </li>

                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <li class="page-item <?php echo ($currentPage == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo min($totalPages, $currentPage + 1); ?>">Next</a>
                        </li>

                        <li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $totalPages; ?>">Last</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>