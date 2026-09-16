<?php
// 1. Conect to Database
require_once __DIR__ . '/db.php';

// 2. Fetch ទិន្នន័យសិស្សទាំងអស់ចេញពី Database
$stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Student Management</h2>
            <button id="openModal" class="btn btn-primary">
                + Add Student
            </button>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>DOB</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Major</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($students)): ?>
                        <?php $index = 1; ?>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?= $index++; ?></td>
                                <td><?= htmlspecialchars($student['name']); ?></td>
                                <td><?= htmlspecialchars($student['gender']); ?></td>
                                <td><?= htmlspecialchars($student['dob']); ?></td>
                                <td><?= htmlspecialchars($student['email']); ?></td>
                                <td><?= htmlspecialchars($student['phone']); ?></td>
                                <td><?= htmlspecialchars($student['major']); ?></td>
                                <td>
                                    <button class="btn btn-edit" data-id="<?= $student['id']; ?>"
                                        data-name="<?= htmlspecialchars($student['name']); ?>"
                                        data-gender="<?= htmlspecialchars($student['gender']); ?>"
                                        data-dob="<?= htmlspecialchars($student['dob']); ?>"
                                        data-email="<?= htmlspecialchars($student['email']); ?>"
                                        data-phone="<?= htmlspecialchars($student['phone']); ?>"
                                        data-major="<?= htmlspecialchars($student['major']); ?>">
                                        Edit
                                    </button>
                                    <a href="api/delete-student.php?id=<?= $student['id']; ?>" class="btn btn-delete"
                                        onclick="return confirm('តើអ្នកពិតជាចង់លុបទិន្នន័យនេះមែនទេ?');">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align: center;">No students found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL -->
    <div id="studentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Add Student</h3>
                <span id="closeModal" class="close">&times;</span>
            </div>
            <form id="studentForm" action="api/create-student.php" method="POST">
                <!-- Hidden input សម្រាប់ ID ពេល Edit -->
                <input type="hidden" name="id" id="student_id">

                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input name="name" id="name" type="text" class="form-control" placeholder="Enter student name"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender" id="gender" class="form-control" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" id="dob" class="form-control" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" id="email" type="email" class="form-control"
                                    placeholder="example@gmail.com" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input name="phone" id="phone" type="text" class="form-control" placeholder="012 345 678"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Major</label>
                        <select name="major" id="major" class="form-control" required>
                            <option value="">Select Major</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Software Engineering">Software Engineering</option>
                            <option value="Information Technology">Information Technology</option>
                            <option value="Information Systems">Information Systems</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancelModal" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Student</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById("studentModal");
        const form = document.getElementById("studentForm");
        const modalTitle = document.getElementById("modalTitle");
        const openBtn = document.getElementById("openModal");
        const closeBtn = document.getElementById("closeModal");
        const cancelBtn = document.getElementById("cancelModal");

        // បើកសម្រាប់ Add
        openBtn.addEventListener("click", () => {
            form.reset();
            form.action = "api/create-student.php";
            modalTitle.textContent = "Add Student";
            document.getElementById("student_id").value = "";
            modal.classList.add("show");
        });

        // បើកសម្រាប់ Edit
        document.querySelectorAll(".btn-edit").forEach(button => {
            button.addEventListener("click", () => {
                form.action = "api/update-student.php";
                modalTitle.textContent = "Edit Student";

                document.getElementById("student_id").value = button.dataset.id;
                document.getElementById("name").value = button.dataset.name;
                document.getElementById("gender").value = button.dataset.gender;
                document.getElementById("dob").value = button.dataset.dob;
                document.getElementById("email").value = button.dataset.email;
                document.getElementById("phone").value = button.dataset.phone;
                document.getElementById("major").value = button.dataset.major;

                modal.classList.add("show");
            });
        });

        // បិទ Modal
        closeBtn.addEventListener("click", () => modal.classList.remove("show"));
        cancelBtn.addEventListener("click", () => modal.classList.remove("show"));
        modal.addEventListener("click", (e) => {
            if (e.target === modal) modal.classList.remove("show");
        });
    </script>
</body>

</html>