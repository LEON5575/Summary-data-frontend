
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
            url: "<?php echo base_url(); ?>/getUser/" + id, 
            method: "GET",
            success: function(result) {
                if (result.error) {
                    alert(result.error);
                } else {
                    $(".updateId").val(result.id);
                    $(".updateEmail").val(result.email);
                    $(".updateRole").val(result.role);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error fetching data:", textStatus, errorThrown);
                alert("Error fetching data: " + textStatus);
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
            url: "<?php echo base_url(); ?>/deleteUser",
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
                console.error("Error deleting :", textStatus, errorThrown);
                alert("Error deleting : " + textStatus);
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
                url: "<?php echo base_url(); ?>/deleteAll",
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
                    console.error("Error deleting :", textStatus, errorThrown);
                    alert("Error deleting : " + textStatus);
                }
            });
        } else {
            alert("Please select at least one  to delete.");
        }
    });

    //!filter
    // Filter users
$(document).on('click', '#filterBtn', function(e) {
  e.preventDefault();
  var filterType1 = $('select[name="filterType1"]').val();
  var searchTerm1 = $('input[name="searchTerm1"]').val();
  var filterType2 = $('select[name="filterType2"]').val();
  var searchTerm2 = $('input[name="searchTerm2"]').val();

  $.ajax({
    url: "<?php echo site_url('filterUser')?>",
    method: "POST",
    data: {
      filterType1: filterType1,
      searchTerm1: searchTerm1,
      filterType2: filterType2,
      searchTerm2: searchTerm2
    },
    success: function(result) {
      console.log(result);
      $('#myTable tbody').html(result);
    }
  });
});
</script>
<!-- //nave -->

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
                        <h2 style="color: black; background-color: whitesmoke;"><b>Admin</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="#addEmployeeModal"  data-toggle="modal" data-toggle="tooltip"> <button type="button" class="btn btn-danger">Add</button></a>
                        <a href="#" class="delete_all_data "> <button type="button" class="btn btn-secondary">Delete</button></a>
                        <a href="#filterModal" data-toggle="modal"> <button type="button" class="btn btn-dark">Filter</button></a>
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
                        <th>Email</th>
                        <th>Role</th>
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
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['role']; ?></td>
                                <td style="display: flex; justify-content: space-between; gap: 10px;">
                                    <a href="#editEmployeeModal"  class="edit" data-toggle="modal" data-id="<?php echo $user['id']; ?>"><button type="button" class="btn btn-info">Edit</button></a>
                                    <a href="#deleteEmployeeModal" class="delete" data-toggle="modal" data-id="<?php echo $user['id']; ?>"><button type="button" class="btn btn-delete">Delete</button></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center align-items-center">
                <ul class="pagination">
                    <?php echo $pager->links('group1', 'bs_pagination'); ?>
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
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" class="form-control" name="role" required autocomplete="off">
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
            <form action="<?php echo base_url().'/updateUser' ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Edit </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="updateId" class="updateId">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control updateEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" class="form-control updateRole" name="role" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" name="submit" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-info" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- filter -->
<!-- Filter Modal -->
<!-- <div  id="filterModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<? echo base_url('/') ?>">
                <div class="modal-header">
                    <h4 class="modal-title" id="filterModalLabel">Filter Users</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&;</button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control" id="email" value="<?= isset($filterEmail) ? $filterEmail : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="role">Role</label>
                        <select name="role" class="form-select" id="role">

                            <option value="">Select Role</option>
                            <?php foreach($allUsers as $allUser) { ?>
                            <option value="TL" <?= (isset($filterRole) && $filterRole == 'TL') ? 'selected' : ''; ?>>TL</option>
                            <option value="Agent" <?= (isset($filterRole) && $filterRole == 'Agent') ? 'selected' : ''; ?>>Agent</option>
                            <option value="Supervisor" <?= (isset($filterRole) && $filterRole == 'Supervisor') ? 'selected' : ''; ?>>Supervisor</option>
                            <?php } ?>
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
</div> -->
<!-- //!filter modal -->
<!-- <div class="modal fade" id="filterModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= site_url('/') ?>">
                <div class="modal-header">
                    <h4 class="modal-title" id="filterModalLabel">Filter User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="filterType1">Role</label>
                        <select name="filterType1" class="form-select" aria-label="Default select example">
                            <option selected>Select Role</option>
                            <?php if ($allUsers): ?>
                                <?php foreach ($allUsers as $user): ?>
                                    <option value="<?= $user['role']; ?>"><?= $user['role'];?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>  
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" value="Filter">
                </div>
            </form>
        </div>
    </div>
</div> -->
<div class="modal fade" id="filterModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= site_url('/') ?>" method="GET">
                <div class="modal-header">
                    <h4 class="modal-title" id="filterModalLabel">Filter User</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="filterType1">Role</label>
                        <select name="filterType1" class="form-select" aria-label="Default select example" required>
                            <option selected disabled>Select Role</option>
                            <option value="TL">TL</option>
                            <option value="Agent">Agent</option>
                            <option value="Supervisor">Supervisor</option>
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

