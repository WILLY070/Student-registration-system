// Open any modal by ID
function showModal(modalId, studentId = null) {
    if (studentId) {
        document.getElementById('deleteStudentId').value = studentId;
    }
    document.getElementById(modalId).style.display = 'block';
}

// Close any modal by ID
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Close modals when clicking outside the content box
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
};

// Aliases for your existing HTML calls (to avoid changing dashboard.php)
const showDeleteModal = (id) => showModal('deleteModal', id);
const closeDeleteModal = () => closeModal('deleteModal');
const showLogoutModal = () => showModal('logoutModal');
const closeLogoutModal = () => closeModal('logoutModal');
const showErrorModal = () => showModal('errorModal');
const closeErrorModal = () => closeModal('errorModal');