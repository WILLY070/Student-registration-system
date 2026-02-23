<?php
require_once '../includes/auth_check.php';
require_once '../config/database.php';
?>
<?php
$status = $_GET['status'] ?? null;
$messages = [
    'success' => '✅ Student registered successfully!',
    'updated' => '✅ Student updated successfully!',
    'deleted' => '🗑️ Student record deleted successfully!'
];

if (isset($messages[$status])) {
    $displayMessage = $messages[$status];
    
    // Determine colors based on status
    $isDeleted = ($status === 'deleted');
    $bgColor = $isDeleted ? '#f8d7da' : '#d4edda';
    $textColor = $isDeleted ? '#721c24' : '#155724';
    $borderColor = $isDeleted ? '#f5c6cb' : '#c3e6cb';
    ?>
    
    <div id="success-alert" style="padding: 15px; background: <?php echo $bgColor; ?>; color: <?php echo $textColor; ?>; border: 1px solid <?php echo $borderColor; ?>; border-radius: 5px; margin-bottom: 20px;">
        <?php echo $displayMessage; ?>
    </div>

    <script>
        // 1. Clean the URL
        if (typeof window.history.replaceState === 'function') {
            const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.replaceState({path: cleanUrl}, '', cleanUrl);
        }

        // 2. Fade and Remove
        setTimeout(function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);
    </script>
    <?php
}
?>

<?php
// Initialize the base query
$sql = "SELECT * FROM students JOIN courses ON students.course_id = courses.course_id";
$where_clauses = [];
$params = [];
$types = "";

// Check each filter
if (!empty($_GET['searchName'])) {
    $where_clauses[] = "full_name LIKE ?";
    $params[] = "%" . $_GET['searchName'] . "%";
    $types .= "s";
}

if (!empty($_GET['SearchID'])) {
    $where_clauses[] = "student_id LIKE ?";
    $params[] = "%" . $_GET['SearchID'] . "%";
    $types .= "s";
}

if (!empty($_GET['searchYOB'])) {
    $where_clauses[] = "year_of_birth = ?";
    $params[] = (int)$_GET['searchYOB'];
    $types .= "i";
}

if (!empty($_GET['searchCourse'])) {
    $where_clauses[] = "students.course_id = ?";
    $params[] = (int)$_GET['searchCourse'];
    $types .= "i";
}

// Append filters to SQL
if (count($where_clauses) > 0) {
    $sql .= " WHERE " . implode(' AND ', $where_clauses);
}

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Only bind if there are actual parameters
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    die("Query Preparation Failed: " . mysqli_error($conn));
}
?>

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
                    <p><?php echo $result->num_rows; ?> students currently in system</p>
                </div>
                <div class="nav-actions">
                    <a href="register_student.php" class="btn-primary">+ Register New</a>
                    <button onclick="showLogoutModal()" class="btn-logout">Logout</button>
                </div>
            </div>
            <div class="search-section">
                <form action="" method="GET" class="Search-form">
                    <input type="text" name="searchName" value="<?php echo $_GET['searchName'] ?? ''; ?>" placeholder="Search students..." class="search-input">
                    <input type="text" name="SearchID" value="<?php echo $_GET['SearchID'] ?? ''; ?>" placeholder="Search Student ID..." class="search-input">
                    <input type="number" name="searchYOB" value="<?php echo $_GET['searchYOB'] ?? ''; ?>" placeholder="Search DOB ..." class="search-input"> 
                    <select name="searchCourse" class="search-input" >
                        <option value="" disabled selected>Search by course</option>
                            <option value="101">Computer Science</option>
                            <option value="102">Data Analytics</option>
                            <option value="103">Information Technology</option>
                            <option value="104">Cyber Security</option>
                    </select>
                    <button type="submit" class="btn-search">&#128269;</button>
                    <?php if (!empty($_GET)): ?>
                        <a href="dashboard.php" class="btn-clear" style="text-decoration: none; color: #666; font-size: 13px; margin-left: 10px;">
                            ✕ Clear Filters
                        </a>
                    <?php endif; ?>

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
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            // Convert course_id to course name
                            switch ($row['course_id']) {
                                case 101: $course = "Computer Science"; break;
                                case 102: $course = "Data Analytics"; break;
                                case 103: $course = "Information Technology"; break;
                                case 104: $course = "Cyber Security"; break;
                                default: $course = "Unknown";
                            }

                            echo "<tr>
                                    <td>" . htmlspecialchars($row['full_name']) . "</td>
                                    <td>" . htmlspecialchars($row['student_id']) . "</td>
                                    <td>" . htmlspecialchars($row['year_of_birth']) . "</td>
                                    <td>" . htmlspecialchars($row['phone_number']) . "</td>
                                    <td>" . htmlspecialchars($course) . "</td>
                                    <td>
                                        <a class='edit-btn' href='edit_student.php?id=" . (int)$row['id'] . "'>
                                            &#9998;
                                        </a>
                                        <a href='javascript:void(0)' 
                                        class='btn-delete' onclick=\"showDeleteModal(" . (int)$row['id'] . ")\">
                                        &#128465;
                                        </a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='empty-state'>No students found. Click \"Register New\" to add one.</td></tr>";
                    }
                    ?>
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
            <p>Are you sure? This action cannot be undone.</p>
            
            <form action="../action/delete_student.php" method="POST" class="modal-actions">
                <input type="hidden" name="id" id="deleteStudentId">
                
                <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button type="submit" class="btn-delete-confirm">Delete</button>
            </form>
        </div>
    </div>
    
    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeLogoutModal()">&times;</span>
            <h2>Confirm Logout</h2>
            <p id="logoutMessage">Are you sure you want to log out? You will be redirected to the login page.</p>
            
            <!-- Logout form -->
            <form action="../logout.php" method="POST" class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeLogoutModal()">Stay</button>
                <button type="submit" class="btn-logout-confirm">Logout</button>
            </form>
        </div>
    </div>
    
    <footer><p>&copy; 2026 Student Management System</p></footer>
</body>
</html>