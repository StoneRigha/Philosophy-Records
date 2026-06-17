<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register</title>
  <style>body{font-family:system-ui,Segoe UI,Roboto,Helvetica,Arial;margin:2rem}label{display:block;margin-top:.5rem}input{width:100%;padding:.5rem;margin-top:.25rem}button{margin-top:1rem;padding:.5rem 1rem}</style>
</head>
<body>
  <h1>Register</h1>
  <form id="registerForm">
    <label>Name
      <input name="name" type="text" required />
    </label>
    <label>Email
      <input name="email" type="email" required />
    </label>
    <label>Password
      <input name="password" type="password" required />
    </label>
    <label>Confirm Password
      <input name="password_confirmation" type="password" required />
    </label>
    <button type="submit">Register</button>
  </form>

  <pre id="output" style="white-space:pre-wrap;margin-top:1rem;background:#f6f6f6;padding:1rem;border-radius:4px"></pre>

  <script>
    const form = document.getElementById('registerForm');
    const out = document.getElementById('output');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      out.textContent = 'Sending...';

      const data = Object.fromEntries(new FormData(form).entries());

      try {
        const res = await fetch('/api/register', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(data),
        });

        const json = await res.json();
        out.textContent = JSON.stringify({ status: res.status, body: json }, null, 2);
      } catch (err) {
        out.textContent = String(err);
      }
    });
  </script>
</body>
</html>