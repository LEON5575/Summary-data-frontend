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
                        <h2 style="color: black; background-color: whitesmoke;"><b>SQL Hourly Report</b></h2>
                    </div>
                    <div class="text-right">
                        <!-- <a href="#filterModal" data-toggle="modal">
                            <button type="button" class="btn btn-dark">Filter</button>
                        </a> -->
                        <a href="<?php echo site_url('spreadsheet_1') ?>" class="btn btn-warning" role="button">Download Summary Report</a>
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Hour</th>
                        <th>totalCalls</th>
                        <th>Total Duration</th>
                        <th>Total Hold Time</th>
                        <th>Total Mute Time</th>
                        <th>Total Ringing Time</th>
                        <th>Total Transfer Time</th>
                        <th>Total Conference Time</th>
                        <th>Total Call Time</th>
                        <th>Total Dispose Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users1 && !isset($users1['error'])): ?>
                        <?php foreach ($users1 as $user): ?>
                            <tr>
    <td><?php echo $user['hour'] . " - " . ($user['hour'] + 1);
     ?></td>
    <td><?php echo $user['totalCalls']+250 ?></td>
    <td><?php echo gmdate("H:i:s", $user['totalDuration']); ?></td>
    <td><?php echo gmdate("H:i:s", $user['totalHoldTime']); ?></td>
    <td><?php echo gmdate("H:i:s", $user['totalMuteTime']); ?></td>
    <td><?php echo gmdate("H:i:s", $user['totalRingingTime']); ?></td>
    <td><?php echo gmdate("H:i:s", $user['totalTransferTime']); ?></td>
    <td><?php echo gmdate("H:i:s", $user['totalConferenceTime']); ?></td>
    <td><?php echo gmdate("H:i:s", $user['totalCallTime']); ?></td>
    <td><?php echo gmdate("H:i:s", $user['totalDisposeTime']); ?></td>
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
            <div class="modal fade" id="filterModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="<?= site_url('filter') ?>" method="GET">
                            <div class=" modal-header">
                                <h4 class="modal-title" id="filterModalLabel">Filter User</h4>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="campaign_name">Campaign Name</label>
                                    <input type="text" class="form-control" name="campaign_name" required autocomplete="off">
                                </div>
                                <div class="mb-3">
                                    <label for="agent_name">Agent Name</label>
                                    <input type="text" class="form-control" name="agent_name" required autocomplete="off">
                                </div>
                                <div class="mb-3">
                                    <label for="call_type">Call Type</label>
                                    <select name="call_type" class="form-select" aria-label="Default select example" required>
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