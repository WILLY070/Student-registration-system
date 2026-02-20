
function checkLoginForm(event) {
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('passwordInput');
    
    if (usernameInput.value.trim() === '' || passwordInput.value.trim() === '') {
         alert('Please fill in both username and password fields.');
        
        return false;
    }
    
    // Prevent form submission and show error modal
    event.preventDefault();
    showErrorModal();
    return false;
}


function showErrorModal() {
    const modal = document.getElementById('errorModal');
    modal.style.display = 'block';
}

function closeErrorModal() {
    const modal = document.getElementById('errorModal');
    modal.style.display = 'none';
}

window.onclick = function(event) {
    const errorModal = document.getElementById('errorModal');
    const deleteModal = document.getElementById('deleteModal');
    const logoutModal = document.getElementById('logoutModal');
    
    if (event.target === errorModal) {
        errorModal.style.display = 'none';
    }
    if (event.target === deleteModal) {
        deleteModal.style.display = 'none';
    }
    if (event.target === logoutModal) {
        logoutModal.style.display = 'none';
    }
}

// ===== DELETE MODAL FUNCTIONS =====
function showDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.style.display = 'block';
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.style.display = 'none';
}

function confirmDelete() {
    // Filler code for backend developer - Replace this with PHP backend logic
    
    console.log('Deleting student...');
    
    // Close the delete modal
    closeDeleteModal();
    
    // Simulate waiting for server confirmation
    // TODO: Backend developer - Replace this with actual delete logic
    // Example: Send DELETE request to delete_student.php
    
    // Simulating server response delay (2 seconds)
    setTimeout(() => {
        // Dummy server confirmation - Replace with actual backend response
        const serverResponse = {
            success: true,
            studentId: 'STU2024001'  // This would come from the actual student being deleted
        };
        
        // If server confirms successful deletion
        if (serverResponse.success) {
            // Show toast notification with student ID
            showToast(`Student ID ${serverResponse.studentId} has been deleted`);
            
            // TODO: Backend developer - Add code here to:
            // 1. Remove the row from the table
            // 2. Update student count
            // 3. Refresh the page or student list
        }
    }, 2000);  // Wait 2 seconds to simulate server response
    
    
}

// ===== TOAST NOTIFICATION FUNCTIONS =====
function showToast(message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.textContent = message;
    
    // Add to page
    document.body.appendChild(toast);
    
    // Trigger animation by adding active class
    setTimeout(() => {
        toast.classList.add('active');
    }, 10);
    
    // Remove toast after 4 seconds
    setTimeout(() => {
        toast.classList.remove('active');
        // Remove element from DOM after animation completes
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 4000);
}

// ===== LOGOUT MODAL FUNCTIONS =====
function showLogoutModal() {
    const modal = document.getElementById('logoutModal');
    modal.style.display = 'block';
}

function closeLogoutModal() {
    const modal = document.getElementById('logoutModal');
    modal.style.display = 'none';
}

function confirmLogout() {
    // Filler code for backend developer - Replace this with PHP backend logic
  
    
    console.log('Logging out...');
    
    // Placeholder: Simulate logout and redirect
    
    window.location.href = 'login.html';
    
}

// ===== STUDENT REGISTRATION TOAST =====
// Only run this code if on the registration page
document.addEventListener('DOMContentLoaded', function() {
    // Registration form toast
    const registerBtn = document.getElementById('registerBtn');
    const studentIdInput = document.getElementById('studentIdInput');
    const registrationForm = registerBtn ? registerBtn.closest('form') : null;
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            setTimeout(() => {
                const serverResponse = {
                    success: true,
                    studentId: studentIdInput ? studentIdInput.value : 'Unknown'
                };
                if (serverResponse.success) {
                    showToast(`Student ID ${serverResponse.studentId} has been added`);
                    setTimeout(() => {
                        window.location.href = 'index.html';
                    }, 1500);
                }
            }, 2000);
        });
    }

    // Edit student form toast & year validation
    const editBtn = document.getElementById('editStudentBtn');
    const editStudentIdInput = document.getElementById('editStudentIdInput');
    const editForm = editBtn ? editBtn.closest('form') : null;
    const yearInput = document.getElementById('editYearOfBirth');
    if (yearInput) {
        yearInput.addEventListener('input', function() {
            const currentYear = new Date().getFullYear();
            if (parseInt(this.value) > currentYear) {
                this.classList.add('input-error');
                this.setCustomValidity('Year of birth cannot be in the future.');
            } else {
                this.classList.remove('input-error');
                this.setCustomValidity('');
            }
        });
    }
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            setTimeout(() => {
                const serverResponse = {
                    success: true,
                    studentId: editStudentIdInput ? editStudentIdInput.value : 'Unknown'
                };
                if (serverResponse.success) {
                    showToast(`Student ID ${serverResponse.studentId} has been updated`);
                    setTimeout(() => {
                        window.location.href = 'students.html';
                    }, 1500);
                }
            }, 2000);
        });
    }
});

// Initialize login form validation if on login page
const usernameInputInit = document.getElementById('username');
const passwordInputInit = document.getElementById('passwordInput');

if (usernameInputInit) {
    usernameInputInit.addEventListener('input', function() {
        validateField(this);
    });
}

if (passwordInputInit) {
    passwordInputInit.addEventListener('input', function() {
        validateField(this);
    });
}

function validateField(field) {
    if (field.value.trim() === '') {
        field.classList.remove('input-valid');
        field.classList.add('input-error');
    } else {
        field.classList.remove('input-error');
        field.classList.add('input-valid');
    }
}