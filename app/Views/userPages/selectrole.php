<!DOCTYPE html>
<html lang="en">
  <?= view('userPages/layout/header') ?>
  <body style="background-color: #f8f9fa;">
    <?= view('userPages/layout/navbar') ?>
    
    <div class="d-flex flex-wrap container justify-content-around mt-5">
      <!-- Kartu Penawar Jasa -->
      <div class="col-12 col-sm-5 mb-4">
        <div class="card shadow-lg border-0 rounded-4 h-100">
          <div class="card-body text-center">
            <h4 class="card-title fw-bold mb-4">Daftar Sebagai Penawar Jasa</h4>
            <img src="/template/images/customer.png" alt="penawar jasa" class="img-fluid mb-4" style="max-height: 180px;">
            <a href="/auth/register" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm">
              Pilih Sebagai Penawar
            </a>
          </div>
        </div>
      </div>

      <!-- Kartu Pengguna Jasa -->
      <div class="col-12 col-sm-5 mb-4">
        <div class="card shadow-lg border-0 rounded-4 h-100">
          <div class="card-body text-center">
            <h4 class="card-title fw-bold mb-4">Daftar Sebagai Pengguna Jasa</h4>
            <img src="/template/images/group.png" alt="pengguna jasa" class="img-fluid mb-4" style="max-height: 180px;">
            <a href="/auth/userregister" class="btn btn-success px-4 py-2 rounded-pill fw-semibold shadow-sm">
              Pilih Sebagai Pengguna
            </a>
          </div>
        </div>
      </div>
    </div>

    <script src="/template/js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="/template/js/plugins.js"></script>
    <script src="/template/js/script.js"></script>  
  </body>
</html>
