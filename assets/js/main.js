function confirmDelete(id) {
    if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        window.location.href = 'delete.php?id=' + id;
    }
}
