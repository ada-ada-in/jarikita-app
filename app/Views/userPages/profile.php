<!DOCTYPE html>
<html lang="en">
<?= view('userPages/layout/header') ?>
<body style="background-color: #f8f9fa;">

<?= view('userPages/layout/navbar') ?>

<div class="container my-5">

  <div class="row align-items-center mb-5">
    <div class="col-md-6 text-center text-md-left">
      <h1 class="display-4 font-weight-bold text-jari mb-3">PT. Maju Bersama</h1>
      <p class="lead text-muted mb-4">
        Jasa konstruksi, renovasi, dan desain interior terpercaya di Jakarta.
      </p>
      <a href="tel:+6281234567890" class="btn btn-gradient btn-lg shadow d-none d-md-inline-block">
        <i class="fas fa-phone"></i> Hubungi: +62 812-3456-7890
      </a>
    </div>
    <div class="col-md-6 text-center">
      <img src="https://plus.unsplash.com/premium_photo-1661721799629-7b6643f49fa0?q=80&w=1170&auto=format&fit=crop"
           alt="Gambar Perusahaan"
           class="img-fluid rounded-lg shadow hero-img">
    </div>
  </div>

  <!-- Deskripsi Usaha -->
  <div class="row mb-5">
    <div class="col text-center">
      <h2 class="mb-3 font-weight-bold">Tentang Kami</h2>
      <p class="text-muted mb-4 px-md-5">
        PT. Maju Bersama adalah perusahaan yang bergerak di bidang jasa konstruksi, renovasi, dan desain interior.
        Dengan pengalaman lebih dari 10 tahun, kami telah melayani ratusan klien dengan hasil memuaskan.
        Tim profesional kami siap memberikan pelayanan terbaik untuk mewujudkan rumah atau gedung impian Anda.
      </p>
      <a href="tel:+6281234567890" class="btn btn-gradient btn-lg shadow d-inline-block d-md-none">
        <i class="fas fa-phone"></i> Hubungi: +62 812-3456-7890
      </a>
    </div>
  </div>

  <!-- Lokasi & Review -->
  <div class="row mb-5">
    <!-- Alamat & Google Map -->
    <div class="col-md-5 mb-4">
    <div class="card shadow border-0 rounded-lg overflow-hidden">
        <div class="card-body">
        <h4 class="card-title mb-3">📍 Alamat</h4>
        <p class="mb-0">Jl. Merdeka No. 123</p>
        <p class="mb-3">Jakarta Pusat, DKI Jakarta</p>
        </div>
        <!-- Google Map Embed -->
        <!-- <div class="map-container">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.650234597286!2d106.823556!3d-6.174465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e0c8b4ef7f%3A0x301576d14feb460!2sJl.%20Merdeka%20No.%20123%2C%20Jakarta!5e0!3m2!1sid!2sid!4v1692345678901"
            allowfullscreen
            loading="lazy">
        </iframe>
        </div> -->
    </div>
    </div>

    <!-- Review -->
    <div class="col-md-7">
      <h4 class="mb-3">💬 Review Pelanggan</h4>

      <!-- Container Review -->
      <div id="review-container" class="mb-3"></div>

      <!-- Form Tambah Review -->
      <form id="review-form" action="javascript:void(0);" class="p-3 bg-white rounded-lg shadow-sm">
        <div class="form-group mb-2">
          <input type="text" id="review-input" class="form-control" placeholder="Tulis ulasan Anda..." required>
        </div>
        <button type="submit" class="btn btn-gradient btn-block shadow">Kirim</button>
      </form>

      <!-- Lihat Review Sebelumnya -->
      <button id="load-more" class="btn btn-link mt-2 p-0">⬇ Lihat review sebelumnya...</button>
    </div>
  </div>
</div>

<!-- Styles -->
<style>

.text-jari {
  background: linear-gradient(45deg, #007bff, #00c6ff);
  -webkit-background-clip: text; 
  -webkit-text-fill-color: transparent; 
  background-clip: text; 
}


  .btn-gradient {
    background: linear-gradient(45deg, #007bff, #00c6ff);
    border: none;
    color: white !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .btn-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0px 8px 20px rgba(0,0,0,0.15);
  }
  .rounded-lg {
    border-radius: 1rem !important;
  }
  .hero-img {
    transition: transform 0.4s ease;
  }
  .hero-img:hover {
    transform: scale(1.05);
  }
  #review-container .card {
    border: none;
    border-radius: 1rem;
    background: white;
    transition: all 0.3s ease;
  }
  #review-container .card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 10px 25px rgba(0,0,0,0.1);
  }

  .map-container {
  width: 100%;
  overflow: hidden;
}

.map-container iframe {
  width: 100%;
  height: 100%;
  border: 0;
  object-fit: cover; /* mirip efek object-fit di gambar */
}

</style>

<!-- Script -->
<script>
  const oldReviews = [
    { text: "Harga terjangkau, kualitas oke!", name: "Budi" },
    { text: "Tim sangat profesional.", name: "Rina" },
    { text: "Hasil renovasi sesuai harapan.", name: "Agus" }
  ];

  let savedReviews = JSON.parse(localStorage.getItem('reviews')) || [
    { text: "Pelayanan sangat memuaskan!", name: "Andi" },
    { text: "Proses cepat dan hasil rapi.", name: "Sinta" }
  ];

  function addReview(text, name, save = true) {
    const card = document.createElement('div');
    card.className = 'card mb-3 shadow-sm';
    card.innerHTML = `
      <div class="card-body">
        <p class="mb-2 font-italic text-dark">"${text}"</p>
        <small class="text-muted">- ${name}</small>
      </div>
    `;
    document.getElementById('review-container').prepend(card);

    if (save) {
      savedReviews.unshift({ text, name });
      localStorage.setItem('reviews', JSON.stringify(savedReviews));
    }
  }

  savedReviews.forEach(r => addReview(r.text, r.name, false));

  document.getElementById('review-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const reviewInput = document.getElementById('review-input');
    const newReview = reviewInput.value.trim();
    if (newReview) {
      addReview(newReview, "Pengunjung");
      reviewInput.value = '';
    }
  });

  document.getElementById('load-more').addEventListener('click', function() {
    oldReviews.forEach(r => addReview(r.text, r.name));
    this.style.display = 'none';
  });
</script>

    <script src="/template/js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="/template/js/plugins.js"></script>
    <script src="/template/js/script.js"></script>

</body>
</html>
