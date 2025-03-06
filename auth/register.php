<?php include(".layouts/header.php"); ?>
<!-- Register Card -->
<div class="card">
  <div class="card-body">
    <!-- Logo -->
    <div class="app-brand justify-content-center">
      <a href="index.html" class="app-brand-link gap-2">
        <span class="app-brand-logo demo"></span>
        <span class="app-brand-text demo text-uppercase fw-bolder">IdeKreatif</span>
      </a>
    </div>
    <!-- /Logo -->

    <form action="register_process.php" class="mb-3" method="POST">

      <!-- Form untuk Pelanggan -->
      <div id="pelanggan-form">
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" class="form-control" name="name" placeholder="Masukkan Nama" />
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required />
        </div>
        <div class="mb-3 form-password-toggle">
          <label class="form-label">Password</label>
          <div class="input-group input-group-merge">
            <input type="password" class="form-control" name="password"
            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
          </div>
          <div class="mb-3">
          <label class="form-label">Alamat</label>
          <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat" ></textarea>
        </div>
        </div>
      </div>

      <!-- Form untuk Admin (Disembunyikan Saat Awal) -->
      <div id="admin-form" style="display: none;">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" class="form-control" name="username" placeholder="Masukkan Username" />
        </div>
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" class="form-control" name="name" placeholder="Masukkan Nama" />
        </div>
        <div class="mb-3 form-password-toggle">
          <label class="form-label">Password</label>
          <div class="input-group input-group-merge">
            <input type="password" class="form-control" name="password"
            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
          </div>
        </div>
      </div>

      <!-- Pilihan Role -->
      <div class="mb-3">
        <label class="form-label">Daftar sebagai:</label>
        <div>
          <input type="radio" name="role" value="pelanggan" checked onclick="switchRole('pelanggan')"> Pelanggan
          <input type="radio" name="role" value="admin" onclick="switchRole('admin')"> Admin
        </div>
      </div>

      <button class="btn btn-primary d-grid w-100" type="submit">Daftar</button>
    </form>
    
    <p class="text-center">
      <span>Sudah memiliki akun?</span><a href="login.php"><span> Masuk</span></a>
    </p>
  </div>
</div>
<!-- Register Card -->
<?php include(".layouts/footer.php"); ?>

<!-- JavaScript untuk Menyesuaikan Form -->
<script>
  function switchRole(role) {
    let adminForm = document.getElementById("admin-form");
    let pelangganForm = document.getElementById("pelanggan-form");

    if (role === "admin") {
      adminForm.style.display = "block";
      pelangganForm.style.display = "none";
      // Pastikan semua input admin tidak disabled
      document.querySelectorAll("#admin-form input").forEach(el => el.removeAttribute("disabled"));
      // Matikan input pelanggan agar tidak terkirim
      document.querySelectorAll("#pelanggan-form input, #pelanggan-form textarea").forEach(el => el.setAttribute("disabled", "true"));
    } else {
      pelangganForm.style.display = "block";
      adminForm.style.display = "none";
      document.querySelectorAll("#pelanggan-form input, #pelanggan-form textarea").forEach(el => el.removeAttribute("disabled"));
      document.querySelectorAll("#admin-form input").forEach(el => el.setAttribute("disabled", "true"));
    }
  }
</script>