<?php
require_once '../db_connect.php';
require_once '../session.php';
checkLogin();
checkAdminOrManager();
logout();

// Xử lý xóa nhiều phòng ban
if (isset($_POST['delete_multiple']) && $_SESSION['role'] == 'admin') {
    $ids = isset($_POST['options']) ? $_POST['options'] : [];
    if (!empty($ids)) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "DELETE FROM departments WHERE id IN ($placeholders)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($ids);
    }
    header("Location: ./departments.php");
    exit();
}

// Xử lý thêm phòng ban
if (isset($_POST['add_department']) && $_SESSION['role'] == 'admin') {
    $sql = "INSERT INTO departments (name) VALUES (:name)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':name' => $_POST['name']]);
    header("Location: ./departments.php");
    exit();
}

// Xử lý tìm kiếm
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM departments";
if (!empty($search)) {
    $sql .= " WHERE name LIKE :search";
}
$stmt = $conn->prepare($sql);
if (!empty($search)) {
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
}
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quản lý phòng ban</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../style2.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: #fff;
            padding: 15px 25px;
            font-family: 'Roboto', sans-serif;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }
        .sidebar .nav-link.active {
            background-color: #007bff;
        }
        .sidebar .sidebar-brand {
            color: #fff;
            font-size: 1.5rem;
            font-family: 'Varela Round', sans-serif;
            padding: 20px 25px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .dropdown-menu {
            right: 0;
            left: auto;
        }
        .search-form {
            margin-top: 10px;
        }
        .search-form .form-control {
            font-size: 13px;
            padding: 5px 10px;
            height: 34px;
        }
        .search-form .btn {
            padding: 5px 10px;
            font-size: 14px;
        }
        .search-form .material-icons {
            font-size: 18px;
        }
    </style>
    <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        var checkbox = $('table tbody input[type="checkbox"]');
        $("#selectAll").click(function(){
            if(this.checked){
                checkbox.each(function(){
                    this.checked = true;
                });
            } else {
                checkbox.each(function(){
                    this.checked = false;
                });
            }
        });
        checkbox.click(function(){
            if(!this.checked){
                $("#selectAll").prop("checked", false);
            }
        });

        $('.edit').click(function(){
            var id = $(this).data('id');
            $.ajax({
                url: './get_department.php',
                type: 'GET',
                data: {id: id},
                success: function(response){
                    var data = JSON.parse(response);
                    $('#edit_id').val(data.id);
                    $('#edit_name').val(data.name);
                }
            });
        });

        $('#deleteDepartmentModal').on('show.bs.modal', function(){
            var checked = $('table tbody input[type="checkbox"]:checked');
            if(checked.length === 0){
                alert('Vui lòng chọn ít nhất một phòng ban để xóa.');
                return false;
            }
        });
    });
    </script>
</head>
<body>
<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-brand">Quản lý nhân viên</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? ' active' : ''; ?>" href="<?php echo BASE_URL; ?>Employee/dashboard.php">Danh sách nhân viên</a>
        </li>
        <?php if ($_SESSION['role'] == 'admin') { ?>
        <li class="nav-item">
            <a class="nav-link<?php echo basename($_SERVER['PHP_SELF']) == 'departments.php' ? ' active' : ''; ?>" href="<?php echo BASE_URL; ?>Department/departments.php">Quản lý phòng ban</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? ' active' : ''; ?>" href="<?php echo BASE_URL; ?>User/users.php">Quản lý người dùng</a>
        </li>
        <?php } ?>
        <li class="nav-item mt-auto">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown">
                <?php echo $_SESSION['username']; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="?logout=1">Đăng xuất</a>
            </div>
        </li>
    </ul>
</div>
<!-- Content -->
<div class="content">
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Quản lý Phòng ban</h2>
                        </div>
                        <?php if ($_SESSION['role'] == 'admin') { ?>
                        <div class="col-sm-6">
                            <div class="btn-group">
                                <a href="#addDepartmentModal" class="btn btn-success" data-toggle="modal"><i class="material-icons"></i> <span>Thêm phòng ban mới</span></a>
                                <a href="#deleteDepartmentModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons"></i> <span>Xóa</span></a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="row search-form justify-content-end">
                        <div class="col-sm-4">
                            <form method="GET" action="">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i class="material-icons">search</i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <form id="deleteForm" method="POST">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <?php if ($_SESSION['role'] == 'admin') { ?>
                            <th>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="selectAll">
                                    <label for="selectAll"></label>
                                </span>
                            </th>
                            <?php } ?>
                            <th>ID</th>
                            <th>Tên phòng ban</th>
                            <?php if ($_SESSION['role'] == 'admin') { ?>
                            <th>Hành động</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            if ($_SESSION['role'] == 'admin') {
                                echo "<td>
                                    <span class='custom-checkbox'>
                                        <input type='checkbox' name='options[]' value='{$row['id']}'>
                                        <label></label>
                                    </span>
                                </td>";
                            }
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['name']}</td>";
                            if ($_SESSION['role'] == 'admin') {
                                echo "<td>
                                    <a href='#editDepartmentModal' class='edit' data-toggle='modal' data-id='{$row['id']}'><i class='material-icons' data-toggle='tooltip' title='Sửa'></i></a>
                                    <a href='./delete_department.php?id={$row['id']}' class='delete' onclick='return confirm(\"Bạn có chắc muốn xóa?\")'><i class='material-icons' data-toggle='tooltip' title='Xóa'></i></a>
                                </td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Department Modal -->
<div id="addDepartmentModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm phòng ban</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên phòng ban</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Hủy">
                    <input type="submit" name="add_department" class="btn btn-success" value="Thêm">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Department Modal -->
<div id="editDepartmentModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="./edit_department.php">
                <div class="modal-header">
                    <h4 class="modal-title">Sửa phòng ban</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label>Tên phòng ban</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Hủy">
                    <input type="submit" name="edit_department" class="btn btn-info" value="Lưu">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Department Modal -->
<div id="deleteDepartmentModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteMultipleForm" method="POST" action="">
                <div class="modal-header">
                    <h4 class="modal-title">Xóa phòng ban</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc muốn xóa các phòng ban đã chọn không?</p>
                    <p class="text-warning"><small>Hành động này không thể hoàn tác.</small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Hủy">
                    <input type="submit" name="delete_multiple" class="btn btn-danger" value="Xóa">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#deleteDepartmentModal').on('show.bs.modal', function(){
        var checked = $('table tbody input[type="checkbox"]:checked');
        if(checked.length === 0){
            alert('Vui lòng chọn ít nhất một phòng ban để xóa.');
            return false;
        }
        var form = $('#deleteMultipleForm');
        form.find('input[name="options[]"]').remove();
        checked.each(function(){
            form.append('<input type="hidden" name="options[]" value="' + $(this).val() + '">');
        });
    });
});
</script>
</body>
</html>