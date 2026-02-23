
function checkLoginForm(event) {
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('passwordInput');

    if (usernameInput.value.trim() === '' || passwordInput.value.trim() === '') {
        alert('Please fill in both username and password fields.');
        event.preventDefault();
        return false;
    }

    return true; // allow form submission
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
function showDeleteModal(id) {
    // Put the ID into the hidden input field
    document.getElementById('deleteStudentId').value = id;
    // Show the modal
    document.getElementById('deleteModal').style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
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

// ===== STUDENT REGISTRATION TOAST =====

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