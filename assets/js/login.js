document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
  
    form.addEventListener('submit', function (e) {
      const email = form.email.value.trim();
      const password = form.password.value;
  
      if (!email || !password) {
        alert('Please fill in both fields.');
        e.preventDefault();
      }
    });
  });
  