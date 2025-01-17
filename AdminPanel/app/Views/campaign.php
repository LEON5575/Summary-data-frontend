
<link rel="stylesheet" href="<?php echo base_url('/public/assets/css/dataTables.dataTables.min.css')?>">
<link href="<?php echo base_url('/public/assets/css/bootstrap.min.css')?>" rel="stylesheet">
<script src="<?php echo base_url("/public/assets/js/jquery-3.6.0.min.js")?>" ></script>
<script src="<?php echo base_url("/public/assets/js/bootstrap.bundle.min.js")?>" ></script>
<script src="<?php echo base_url('/public/assets/js/dataTables.min.js');?>" ></script>
<script>
    $(document).on('click', '.edit', function(e) {
        e.preventDefault();
        var id = $(this).data('id'); // Use data-id attribute
        $.ajax({
            url: "<?php echo base_url(); ?>/getCampaign/" + id, 
            method: "GET",
            success: function(result) {
                if (result.error) {
                    alert(result.error);
                } else {
                    $(".updateId").val(result.id);
                    $(".updateName").val(result.name);
                    $(".updateDescription").val(result.description);
                    $(".updateClient").val(result.client);
                    $(".updateSupervisor").val(result.supervisor);
                    $(".updateStatus").val(result.status);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error fetching campaign data:", textStatus, errorThrown);
                alert("Error fetching campaign data: " + textStatus);
            }
        });
    });

    $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        var confirmation = confirm("Are you sure?");
        if (!confirmation) {
            return;
        }
        var id = $(this).data('id'); // Use data-id attribute
        $.ajax({
            url: "<?php echo base_url(); ?>/deleteCampaign",
            method: "POST",
            data: { id: id },
            success: function(result) {
                if (result.error) {
                    alert(result.error);
                } else {
                    window.location.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error deleting campaign:", textStatus, errorThrown);
                alert("Error deleting campaign: " + textStatus);
            }
        });
    });

    $(document).on('click', '.delete_all_data', function() {
        var checkboxes = $(".data_checkbox:checked");
        if (checkboxes.length > 0) {
            var confirmation = confirm("Are you sure to delete this data?");
            if (!confirmation) {
                return;
            }
            var ids = [];
            checkboxes.each(function() {
                ids.push($(this).val());
            });
            $.ajax({
                url: "<?php echo base_url(); ?>/deleteAllCampaign",
                method: "POST",
                data: { ids: ids },
                success: function(result) {
                    if (result.error) {
                        alert(result.error);
                    } else {
                        checkboxes.each(function() {
                            $(this).closest('tr').hide(1000);
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error deleting campaigns:", textStatus, errorThrown);
                    alert("Error deleting campaigns: " + textStatus);
                }
            });
        } else {
            alert("Please select at least one campaign to delete.");
        }
    });
</script>

<div class="container-xl">
    <div class="table-responsive d-flex flex-column">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert w-50 align-self-center alert-success alert-dismissible fade show" role="alert">
                <?php echo session()->getFlashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 style="color: black; background-color: whitesmoke;"><b>CAMPAIGN DETAILS</b></h2>
                    </div>
                    <div class="col-sm-6">
                            
                        <a href="#addEmployeeModal"  data-toggle="modal"> <button type="button" class="btn btn-info">Add</button></a>
                        <a href="#" class="delete_all_data "> <button type="button" class="btn btn-danger">Delete</button></a>
                        <a href="#filterModal" data-toggle="modal"> <button type="button" class="btn btn-primary">Filter</button></a>
                    </div>
                </div>
            </div>
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th>
                            <span class="custom_checkbox">
                                <input type="checkbox" name="" id="selectAll">
                                <label for="selectAll"></label>
                            </span>
                        </th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Client</th>
                        <th>Supervisor</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($users): ?>
                        <?php foreach($users as $user): ?>
                            <tr>
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <td>
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="data_checkbox_<?php echo $user['id']; ?>" class="data_checkbox" name="data_checkbox" value="<?php echo $user['id']; ?>">
                                        <label for="data_checkbox_<?php echo $user['id']; ?>"></label>
                                    </span>
                                </td>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['name']; ?></td>
                                <td><?php echo $user['description']; ?></td>
                                <td><?php echo $user['client']; ?></td>
                                <td><?php echo $user['supervisor']; ?></td>
                                <td><?php echo $user['status']; ?></td>
                                <td style="display: flex; justify-content: space-between; gap: 10px;">
                                    <a href="#editEmployeeModal"  class="edit" data-toggle="modal" data-id="<?php echo $user['id']; ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="#deleteEmployeeModal" class="delete" data-toggle="modal" data-id="<?php echo $user['id']; ?>"><button type="button" class="btn btn-delete">Delete</button></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center align-items-center">
                <ul class="pagination">
                    <?php echo $pager->links('group2', 'bs_pagination'); ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal HTML -->
<div id="addEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo base_url().'/saveCampaign' ?>" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Add</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">	
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" name="description" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Client</label>
                        <input type="text" class="form-control" name="client" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Supervisor</label>
                        <input type="text" class="form-control" name="supervisor" required autocomplete="off">
                    </div>
                 <label>Status</label>
                        <input type="text" class="form-control" name="status" required autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" name="submit" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-success" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Modal HTML -->
<div id="editEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo base_url().'/updateCampaign' ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Campaign</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="updateId" class="updateId">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control updateName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control updateDescription" name="description" required>
                    </div>			
                    <div class="form-group">
                        <label>Client</label>
                        <input type="text" class="form-control updateClient" name="client" required>
                    </div>	
                    <div class="form-group">
                        <label>Supervisor</label>
                        <input type="text" class="form-control updateSupervisor" name="supervisor" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" class="form-control updateStatus" name="status" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" name="submit" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-info" value="Save">
                </div>
            </form>
        </div>
    </div>
</div><!-- Filter Modal -->
<div class="modal fade" id="filterModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= site_url('campaign') ?>">
                <div class="modal-header">
                    <h4 class="modal-title" id="filterModalLabel">Filter User</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="filterType1">Supervisor</label>
                        <select name="filterType1" class="form-select" aria-label="Default select example">
                            <option selected>Select Supervisor</option>
                            <?php if ($allUsers): ?>
                                <?php foreach ($allUsers as $user): ?>
                                    <option value="<?= $user['supervisor']; ?>"><?= $user['supervisor'];?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>  
                <!-- //~status -->
                <!-- <div class="mb-3">
                        <label for="filterType2">Status</label>
                        <select name="filterType2" class="form-select" aria-label="Default select example" required>
                            <option selected disabled>Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>   -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" value="Filter">
                </div>
            </form>
        </div>
    </div>
</div>
