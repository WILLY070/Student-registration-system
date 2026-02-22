<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List | Admin System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/script.js"></script>
</head>
<body>
    <header><h1>Student Registration System</h1></header>
    <main>
        <section class="table-container">
            <div class="table-header-top">
                <div>
                    <h2>Registered Students</h2>
                    <p>0 students currently in system</p>
                </div>
                <div class="nav-actions">
                    <a href="index.html" class="btn-primary">+ Register New</a>
                    <button onclick="showLogoutModal()" class="btn-logout">Logout</button>
                </div>
            </div>
            <div class="search-section">
                <form action="" method="get" class="Search-form">
                    <input type="text" name="searchName" placeholder="Search students..." class="search-input">
                    <input type="text" name="SearchID" placeholder="Search Student ID..." class="search-input">
                    <input type="date" name="searchYOB" placeholder="Search DOB ..." class="search-input"> 
                    <select name="searchCourse" class="search-input" >
                        <option value="" disabled selected>Search by course</option>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Information Technology">Information Technology</option>
                        <option value="Business">Business</option>
                    </select>
                    <button type="search" class="btn-search">&#128269;</button>

                </form><!-- <input type="text" placeholder="Search students..." class="search-input"> -->
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Student ID</th>
                            <th>Year of Birth</th>
                            <th>Contact</th>
                            <th>Course</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Alex</td>
                            <td>STU2024001</td>
                            <td>2000</td>
                            <td>+1234567890</td>
                            <td>Computer Science</td>
                            <td>
                                <a href="edit_student.html" class="btn-edit">&#9998;</a>
                                <button class="btn-delete" onclick="showDeleteModal()">&#128465;</button>
                            </td>
                        </tr>
                        <!-- <td colspan="6" class="empty-state">No students found. Click "Register New" to add one.</td> -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeDeleteModal()">&times;</span>
            <h2>Delete Student</h2>
            <p id="deleteMessage">Are you sure you want to delete this student entry? This action cannot be undone.</p>
            <div class="modal-actions">
                <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button class="btn-delete-confirm" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>
    
    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeLogoutModal()">&times;</span>
            <h2>Confirm Logout</h2>
            <p id="logoutMessage">Are you sure you want to log out? You will be redirected to the login page.</p>
            <div class="modal-actions">
                <button class="btn-cancel" onclick="closeLogoutModal()">Stay</button>
                <button class="btn-logout-confirm" onclick="confirmLogout()">Logout</button>
            </div>
        </div>
    </div>
    
    <footer><p>&copy; 2026 Student Management System</p></footer>
</body>
</html>ss