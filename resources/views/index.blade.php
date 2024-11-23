<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" id="add_task_form">
                    @csrf
                    <div class="modal-body p-4 bg-light">
                        <div class="mb-3">
                            <label for="user_id">Assign User</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="" selected disabled>Select User</option>
                                <!-- User options will be dynamically loaded -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Task Title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" placeholder="Task Description"
                                rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="due_date">Due Date</label>
                            <input type="date" name="due_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="priority">Priority</label>
                            <select name="priority" class="form-control" required>
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_completed" id="is_completed">
                            <label class="form-check-label" for="is_completed">Completed</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_paid" id="is_paid">
                            <label class="form-check-label" for="is_paid">Paid</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="add_task_btn" class="btn btn-primary">Add Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Task Modal End -->

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit_task_form" method="POST">
                    @csrf
                    <div class="modal-body p-4 bg-light">
                        <div class="mb-3">
                            <label for="edit_user_id">Assign User</label>
                            <select name="user_id" id="edit_user_id" class="form-control" required>
                                <option value="" selected disabled>Select User</option>
                                <!-- this is hidden filed -->
                                <input type="hidden" id="edit_task_id" name="task_id">
                                <!-- User options will be dynamically loaded -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_title">Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control"
                                placeholder="Task Title" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description">Description</label>
                            <textarea name="description" id="edit_description" class="form-control"
                                placeholder="Task Description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_due_date">Due Date</label>
                            <input type="date" name="due_date" id="edit_due_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_priority">Priority</label>
                            <select name="priority" id="edit_priority" class="form-control" required>
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_completed" id="edit_is_completed">
                            <label class="form-check-label" for="edit_is_completed">Completed</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_paid" id="edit_is_paid">
                            <label class="form-check-label" for="edit_is_paid">Paid</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="edit_task_btn" class="btn btn-primary">Update Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Task Modal End -->

    <div class="container">
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-danger d-flex justify-content-between align-items-center">
                        <h3 class="text-light">Task Management</h3>
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addTaskModal"><i
                                class="bi-plus-circle me-2"></i>New Task</button>
                    </div>
                    <div class="card-body" id="show_all_tasks">
                        <h1 class="text-center text-secondary my-5">Loading...</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Load all users into the dropdown
            function fetchUsers() {
                $.ajax({
                    url: '{{ route("fetchUsers") }}', // Adjust with your route
                    method: 'GET',
                    success: function (res) {
                        console.log(res);
                        let userOptions = '<option value="" selected disabled>Select User</option>';
                        res.users.forEach(user => {
                            userOptions += `<option value="${user.id}">${user.name}</option>`;
                        });
                        $("#user_id, #edit_user_id").html(userOptions); // Populate both Add and Edit modals
                    }
                });
            }

            // Fetch all tasks and display in the table
            function fetchAllTasks() {
                $.ajax({
                    url: '{{ route("fetchAll") }}',
                    method: 'GET',
                    success: function (res) {
                        if (res.status === 200) {
                            $("#show_all_tasks").html(res.html); // Update your DOM with the response
                            $("table").DataTable({ order: [0, 'desc'] }); // Initialize DataTable
                        }
                    }
                });
            }

            fetchUsers();
            fetchAllTasks();

            // Handle form submission for adding a task
            $("#add_task_form").submit(function (e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_task_btn").text('Adding...');
                $.ajax({
                    url: '{{ route("store") }}',
                    method: 'POST',
                    data: fd,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        if (res.status === 200) {
                            Swal.fire('Added!', 'Task added and email sent successfully!', 'success');
                            fetchAllTasks();
                        }
                        $("#add_task_btn").text('Add Task');
                        $("#add_task_form")[0].reset();
                        $("#addTaskModal").modal('hide');
                    }
                    
                });
            });

            // $("#add_task_form").submit(function (e) {
            //     e.preventDefault();
            //     const fd = new FormData(this);
            //     $("#add_task_btn").text('Adding...');
            //     $.ajax({
            //         url: '',
            //         method: 'POST',
            //         data: fd,
            //         cache: false,
            //         processData: false,
            //         contentType: false,
            //         success: function (res) {
            //             if (res.status === 200) {
            //                 Swal.fire('Added!', 'Task Added Successfully!', 'success');
            //                 fetchAllTasks();
            //             }
            //             $("#add_task_btn").text('Add Task');
            //             $("#add_task_form")[0].reset();
            //             $("#addTaskModal").modal('hide');
            //         }
            //     });
            // });

            // Edit task
            $(document).on('click', '.editIcon', function (e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route("edit") }}',
                    method: 'GET',
                    data: { id: id },
                    success: function (res) {
                        console.log(res.status);
                        if (res.status === 200) {
                            console.log(res);
                            // Populate the modal fields with the task data
                            $("#edit_user_id").val(res.user_id);
                            $("#edit_title").val(res.title);
                            $("#edit_description").val(res.description);
                            $("#edit_due_date").val(res.due_date);
                            $("#edit_priority").val(res.priority);
                            $("#edit_is_completed").prop('checked', res.is_completed);
                            $("#edit_is_paid").prop('checked', res.is_paid);
                            $("#edit_task_id").val(res.id);
                            // Show the edit modal
                            $("#editTaskModal").modal('show');
                        } else {
                            //console.log(res);
                            Swal.fire('Error!', 'Failed to fetch task details', 'error');
                        }
                    }
                });
            });

            // Handle form submission for updating a task
            $("#edit_task_form").submit(function (e) {
                e.preventDefault();
                const fd = new FormData(this);

                const taskId = $("#edit_task_id").val(); // Get task ID
                fd.append("task_id", taskId);

                $("#edit_task_btn").text('Updating...');
                $.ajax({
                    url: '{{ route("update") }}',
                    method: 'POST',
                    data: fd,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        console.log(res);
                        if (res.status === 200) {
                            Swal.fire('Updated!', 'Task Updated Successfully!', 'success');
                            fetchAllTasks(); // Reload tasks after updating
                            $("#edit_task_btn").text('Update Task');
                            $("#edit_task_form")[0].reset();
                            $("#editTaskModal").modal('hide');
                        } else {
                            console.log(res);
                            Swal.fire('Error!', 'Failed to update task', 'error');
                        }
                    }
                });
            });

            // Delete task
            $(document).on('click', '.deleteIcon', function (e) {
                e.preventDefault();
                let id = $(this).attr('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("delete") }}',
                            method: 'POST',
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (res) {
                                if (res.status === 200) {
                                    Swal.fire('Deleted!', 'Task has been deleted.', 'success');
                                    fetchAllTasks(); // Reload tasks after deletion
                                } else {
                                    Swal.fire('Error!', 'Failed to delete task', 'error');
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>