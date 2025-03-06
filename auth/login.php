<?php include(".layouts/header.php"); ?>

<!-- Login Card -->
<div class="card">
  <div class="card-body">
    <div class="app-brand justify-content-center">
      <a href="index.html" class="app-brand-link gap-2">
        <span class="app-brand-text demo text-uppercase fw-bolder">E-commerce</span>
      </a>
    </div>

    <h4>Selamat Datang di E-commerce!</h4>

    <form action="login_auth.php" method="POST">
      <div class="mb-3">
        <label id="labelUsername" class="form-label">Email</label>
        <input type="text" class="form-control" name="username" id="username" 
          placeholder="Masukkan Email" required autofocus />
      </div>

      <div class="mb-3 form-password-toggle">
        <label class="form-label">Password</label>
        <div class="input-group input-group-merge">
          <input type="password" class="form-control" name="password"
            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
          <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Login sebagai:</label>
        <div>
          <input type="radio" name="role" value="pelanggan" checked onclick="switchRole('pelanggan')"> Pelanggan
          <input type="radio" name="role" value="admin" onclick="switchRole('admin')"> Admin
        </div>
      </div>

      <button class="btn btn-primary d-grid w-100">Masuk</button>
    </form>

    <p class="text-center">
      <span>Belum memiliki akun?</span><a href="register.php"><span> Daftar </span></a>
    </p>
  </div>
</div>

<?php include(".layouts/footer.php"); ?>

<!-- JavaScript untuk Ubah Input -->
<script>
  function switchRole(role) {
    var label = document.getElementById("labelUsername");
    var input = document.getElementById("username");

    if (role === "admin") {
      label.innerText = "Username";
      input.placeholder = "Masukkan Username";
    } else {
      label.innerText = "Email";
      input.placeholder = "Masukkan Email";
    }
  }
</script>