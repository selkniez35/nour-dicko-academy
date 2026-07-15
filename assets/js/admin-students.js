document.getElementById('student-search').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();
    document.querySelectorAll('.student-row').forEach(function (row) {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});
