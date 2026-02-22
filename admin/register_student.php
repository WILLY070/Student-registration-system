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
                <a href="students.html" style="text-decoration: none; color: var(--dark-blue); font-weight: bold;">← Back</a>
                <h2 style="margin-top: 15px;">Register Student</h2>
                <p>Enter student information to add to the system</p>
            </div>

            <form action="process.php" method="POST">
                <div class="info-box">
                    <h3>Student Information</h3>
                    <p>All fields are required for database entry.</p>
                </div>

                <div class="form-grid">
                    <div class="input-group full-width">
                        <label>Full Name *</label>
                        <input type="text" name="username" placeholder="e.g., John Smith" required>
                    </div>

                    <div class="input-group">
                        <label>Year of Birth *</label>
                        <input type="number" name="year_of_birth" placeholder="e.g., 2000" required>
                    </div>

                    <div class="input-group">
                        <label>Student ID *</label>
                        <input type="text" name="student_id" id="studentIdInput" placeholder="e.g., STU2024001" required>
                    </div>

                    <div class="input-group">
                        <label>Contact Number *</label>
                        <input type="tel" name="contact" placeholder="e.g., +1234567890" required minlength="10" maxlength="11">
                    </div>

                    <div class="input-group">
                        <label>Course/Program *</label>
                        <select name="course" required>
                            <option value="" disabled selected>Select a course</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Information Technology">Information Technology</option>
                            <option value="Business">Business</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="students.html" class="btn-cancel" style="line-height: 1.5;">Cancel</a>
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