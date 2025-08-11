<!DOCTYPE html>
<html lang="en">
<?= view('userPages/layout/header') ?>
<body>

<?= view('userPages/layout/navbar') ?>

<!-- Landing Page Jasa Profil Perusahaan -->
<div class="container my-5">

  <!-- Hero Section -->
  <div class="row align-items-center mb-5">
    <div class="col-md-6 text-center text-md-left">
      <h1 class="display-4 font-weight-bold">PT. Maju Bersama</h1>
      <a href="tel:+6281234567890" class="btn btn-primary btn-lg mt-3">
        <i class="fas fa-phone"></i> Hubungi: +62 812-3456-7890
      </a>
    </div>
    <div class="col-md-6 text-center">
      <img src="https://plus.unsplash.com/premium_photo-1661721799629-7b6643f49fa0?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
           alt="Gambar Perusahaan"
           class="img-fluid rounded shadow">
    </div>
  </div>

  <!-- Deskripsi Usaha -->
  <div class="row mb-5">
    <div class="col">
      <h2>Tentang Kami</h2>
      <p class="text-muted">
        PT. Maju Bersama adalah perusahaan yang bergerak di bidang jasa konstruksi, renovasi, dan desain interior.
        Dengan pengalaman lebih dari 10 tahun, kami telah melayani ratusan klien dengan hasil memuaskan.
        Tim profesional kami siap memberikan pelayanan terbaik untuk mewujudkan rumah atau gedung impian Anda.
      </p>
    </div>
  </div>

  <!-- Lokasi & Review -->
  <div class="row mb-5">
    <div class="col-md-6">
      <h4>Alamat</h4>
      <p>Jl. Merdeka No. 123, Jakarta Pusat, DKI Jakarta</p>
    </div>

    <div class="col-md-6">
      <h4>Review Pelanggan</h4>

      <!-- Container Review -->
      <div id="review-container" class="mb-3"></div>

      <!-- Form Tambah Review -->
      <form id="review-form" action="javascript:void(0);">
        <div class="form-group">
          <input type="text" id="review-input" class="form-control mb-2" placeholder="Tulis ulasan Anda..." required>
        </div>
        <button type="submit" class="btn btn-success btn-block">Kirim</button>
      </form>

      <!-- Lihat Review Sebelumnya -->
      <button id="load-more" class="btn btn-link mt-2 p-0">Lihat review sebelumnya...</button>
    </div>
  </div>

</div>

<style>
  /* Efek hover untuk card review */
  #review-container .card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  #review-container .card:hover {
    transform: translateY(-3px);
    box-shadow: 0px 8px 20px rgba(0,0,0,0.15);
  }
</style>

<script>
  // Review awal (hanya muncul saat tombol "lihat review sebelumnya" diklik)
  const oldReviews = [
    { text: "Harga terjangkau, kualitas oke!", name: "Budi" },
    { text: "Tim sangat profesional.", name: "Rina" },
    { text: "Hasil renovasi sesuai harapan.", name: "Agus" }
  ];

  // Ambil review dari localStorage atau buat array kosong
  let savedReviews = JSON.parse(localStorage.getItem('reviews')) || [
    { text: "Pelayanan sangat memuaskan!", name: "Andi" },
    { text: "Proses cepat dan hasil rapi.", name: "Sinta" }
  ];

  // Fungsi untuk menambahkan review ke container
  function addReview(text, name, save = true) {
    const card = document.createElement('div');
    card.className = 'card mb-3 shadow-sm';
    card.innerHTML = `
      <div class="card-body">
        <p class="mb-1">"${text}"</p>
        <small class="text-muted">- ${name}</small>
      </div>
    `;
    document.getElementById('review-container').prepend(card);

    // Simpan ke localStorage kalau perlu
    if (save) {
      savedReviews.unshift({ text, name });
      localStorage.setItem('reviews', JSON.stringify(savedReviews));
    }
  }

  // Render review yang tersimpan
  savedReviews.forEach(r => addReview(r.text, r.name, false));

  // Event submit form
  document.getElementById('review-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const reviewInput = document.getElementById('review-input');
    const newReview = reviewInput.value.trim();
    if (newReview) {
      addReview(newReview, "Pengunjung");
      reviewInput.value = '';
    }
  });

  // Event tombol lihat review lama
  document.getElementById('load-more').addEventListener('click', function() {
    oldReviews.forEach(r => addReview(r.text, r.name));
    this.style.display = 'none'; // sembunyikan tombol
  });
</script>

<?= view('userPages/layout/footer') ?>
</body>
</html>
