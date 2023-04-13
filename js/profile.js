
/**
 * Confirm account deletion with user before proceeding
 * 
 * @returns boolean true if user confirms deletion, false otherwise
 */
function confirmDelete() {
    var result = confirm("Are you sure you want to delete your account?");
    if (result) {
        return true;
    } else {
        return false;
    }
}