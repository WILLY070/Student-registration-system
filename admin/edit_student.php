<?php
require_once '../includes/auth_check.php';
require_once '../config/database.php';

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Prepare the query
    $query = "SELECT * FROM students WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        // 2. Bind the ID
        mysqli_stmt_bind_param($stmt, "i", $id);

        // 3. Execute
        mysqli_stmt_execute($stmt);

        // 4. Get the result and fetch the data
        $result = mysqli_stmt_get_result($stmt);
        $student = mysqli_fetch_assoc($result);

        // Close statement
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student information | Admin System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/script.js"></script>
</head>
<body>

    <header>
        <h1>Student Registration System</h1>
    </header>

    <main>
        <section class="form-card" style="max-width: 850px;">
            <div class="form-header">
                <a href="../admin/dashboard.php" style="text-decoration: none; color: var(--dark-blue); font-weight: bold;">← Back</a>
                <h2 style="margin-top: 15px;">Edit Student information</h2>
                <p>Update student information in the system</p>
            </div>

            <form action="../action/update_student.php" method="POST">
                <div class="info-box">
                    <h3>Student Information</h3>
                </div>

               <div class="form-grid">
                <input type="hidden" name="internal_id" value="<?php echo htmlspecialchars($student['id']); ?>">
                    <div class="input-group full-width">
                        <label>Full Name *</label>
                        <input type="text" name="fullname" value="<?php echo htmlspecialchars($student['full_name']); ?>" required>
                    </div>

                    <div class="input-group">
                        <label>Year of Birth *</label>
                        <input 
                            type="number" 
                            name="yob" 
                            id="yob"
                            min="<?php echo date('Y') - 100; ?>" 
                            max="<?php echo date('Y') - 16; ?>"
                            value="<?php echo htmlspecialchars($student['year_of_birth']); ?>" 
                            required 
                        >
                    </div>

                    <div class="input-group">
                        <label>Student ID *</label>
                        <input 
                            type="text" 
                            name="student_id" 
                            value="<?php echo htmlspecialchars($student['student_id']); ?>" 
                            pattern="SCT211-(?!0000)\d{4}/\d{4}" 
                            title="Format: SCT211-0001/YYYY"
                            required
                        >
                    </div>

                    <div class="input-group">
                        <label>Contact Number *</label>
                        <input 
                            type="tel" 
                            name="contact_number" 
                            value="<?php echo htmlspecialchars($student['phone_number']); ?>" 
                            required 
                            pattern="\+254[71]\d{8}" 
                            title="Format: +2547XXXXXXXX or +2541XXXXXXXX"
                            placeholder="+254712345678"
                        >
                    </div>

                    <div class="input-group">
                        <label>Course/Program *</label>
                        <select name="course_id" required>
                            <option value="" disabled selected>Select a course</option>
                            <option value="101" <?php echo ($student['course_id'] == 101) ? 'selected' : ''; ?>>Computer Science</option>
                            <option value="102" <?php echo ($student['course_id'] == 102) ? 'selected' : ''; ?>>Data Analytics</option>
                            <option value="103" <?php echo ($student['course_id'] == 103) ? 'selected' : ''; ?>>Information Technology</option>
                            <option value="104" <?php echo ($student['course_id'] == 104) ? 'selected' : ''; ?>>Cyber Security</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="../admin/dashboard.php" class="btn-cancel" style="line-height: 1.5;">Cancel</a>
                    <button type="submit" class="btn-primary" id="editStudentBtn">Update Student</button>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Student Management System. Administrator Access Only.</p>
    </footer>

</body>
</html>