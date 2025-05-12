document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('registerForm');
  
    form.addEventListener('submit', function (e) {
      const name = form.name.value.trim();
      const email = form.email.value.trim();
      const password = form.password.value;
      const confirmPassword = form.confirmPassword.value;
  
      if (!name || !email || !password || !confirmPassword) {
        alert('Please fill in all fields.');
        e.preventDefault();
        return;
      }
  
      if (!validateEmail(email)) {
        alert('Please enter a valid email address.');
        e.preventDefault();
        return;
      }
  
      if (password !== confirmPassword) {
        alert('Passwords do not match.');
        e.preventDefault();
        return;
      }
  
      if (password.length < 6) {
        alert('Password must be at least 6 characters.');
        e.preventDefault();
        return;
      }
    });
  
    function validateEmail(email) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
  });
  