function deleteUser(id) {
    if (!confirm('Are you sure you want to delete this user?')) {
        return;
    }

    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append('userId', id);

    xhr.open('POST', '../helpers/delete_user.php', true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    document.getElementById(`user-row-${id}`).remove();
                } else {
                    alert(response.error || 'Failed to delete user');
                }
            } else {
                alert('An error occurred while deleting the user');
            }
        }
    };

    xhr.send(formData);
}

function updateRole(id, newRole) {
    if (!confirm(`Are you sure you want to change this user's role to ${newRole}?`)) {
        return;
    }

    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append('userId', id);
    formData.append('role', newRole);

    xhr.open('POST', '../helpers/update_role.php', true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.error || 'Failed to update role');
                }
            } else {
                alert('An error occurred while updating the role');
            }
        }
    };

    xhr.send(formData);
}