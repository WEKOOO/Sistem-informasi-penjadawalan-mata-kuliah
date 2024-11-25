// public/js/mata-kuliah-form.js
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validasi Kode MK
        const kodeMK = document.getElementById('kode_mk');
        if (!kodeMK.value.trim()) {
            setInvalid(kodeMK, 'Kode mata kuliah wajib diisi');
            isValid = false;
        }
        
        // Validasi Nama
        const nama = document.getElementById('nama');
        if (!nama.value.trim()) {
            setInvalid(nama, 'Nama mata kuliah wajib diisi');
            isValid = false;
        }
        
        // Validasi SKS
        const sks = document.getElementById('sks');
        if (!sks.value || sks.value < 1) {
            setInvalid(sks, 'SKS minimal 1');
            isValid = false;
        }
        
        // Validasi Semester
        const semester = document.getElementById('semester');
        if (!semester.value) {
            setInvalid(semester, 'Semester wajib dipilih');
            isValid = false;
        }
        
        // Validasi Program Studi
        const prodi = document.getElementById('prodi_id');
        if (!prodi.value) {
            setInvalid(prodi, 'Program studi wajib dipilih');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });
    
    function setInvalid(element, message) {
        element.classList.add('is-invalid');
        const feedback = element.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.textContent = message;
        }
    }
    
    // Reset validation on input
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
});