<?php
require_once '../includes/auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Student | Admin System</title>
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
                <a href="dashboard.php" style="text-decoration: none; color: var(--dark-blue); font-weight: bold;">← Back</a>
                <h2 style="margin-top: 15px;">Register Student</h2>
                <p>Enter student information to add to the system</p>
            </div>

            <form action="../action/create_student.php" method="POST">
                <div class="info-box">
                    <h3>Student Information</h3>
                    <p>All fields are required for database entry.</p>
                </div>

                <div class="form-grid">
                    <div class="input-group full-width">
                        <label>Full Name *</label>
                        <input type="text" name="fullname" placeholder="e.g., John Smith" required>
                    </div>

                    <div class="input-group">
                        <label>Year of Birth *</label>
                        <input 
                            type="number" 
                            name="yob" 
                            id="yob"
                            min="<?php echo date('Y') - 100; ?>" 
                            max="<?php echo date('Y') - 16; ?>" 
                            required 
                            placeholder="YYYY"
                        >
                    </div>

                    <div class="input-group">
                        <label>Student ID *</label>
                        <input 
                            type="text" 
                            name="student_id"
                            id="studentIdInput" 
                            required 
                            pattern="SCT211-(?!0000)\d{4}/\d{4}" 
                            title="Format: SCT211-0001/2024 to SCT211-9999/2024. 0000 is not allowed."
                            placeholder="SCT211-0001/2024"
                        >
                    </div>

                    <div class="input-group">
                        <label>Contact Number *</label>
                        <input 
                        type="tel" 
                        name="contact_number" 
                        required 
                        pattern="\+254[71]\d{8}" 
                        title="Format: +254 followed by 7 or 1 and 8 digits (e.g., +254712345678)"
                        placeholder="+254712345678"
                        >
                    </div>

                    <div class="input-group">
                        <label>Course/Program *</label>
                        <select name="course_id" required>
                            <option value="" disabled selected>Select a course</option>
                            <option value="101">Computer Science</option>
                            <option value="102">Data Analytics</option>
                            <option value="103">Information Technology</option>
                            <option value="104">Cyber Security</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="dashboard.php" class="btn-cancel" style="line-height: 1.5;">Cancel</a>
                    <button type="submit" class="btn-primary" id="registerBtn">Register Student</button>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Student Management System. Administrator Access Only.</p>
    </footer>

</body>
</html>