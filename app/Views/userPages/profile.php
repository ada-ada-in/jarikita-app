<!DOCTYPE html>
<html lang="en">
<?= view('userPages/layout/header') ?>
<body style="background-color: #f8f9fa;">

<?= view('userPages/layout/navbar') ?>

<div class="container my-5">

  <div class="row align-items-center mb-5">
    <div class="col-md-6 text-center text-md-left">
      <h1 class="display-4 font-weight-bold text-jari mb-3" id="nama_jasa"></h1>
      <p class="lead text-muted mb-4" id="bidang_jasa">
        <!-- bidang jasa -->
      </p>
      <a id="sendlog" href="#" class="btn btn-gradient btn-lg shadow d-none d-md-inline-block">
        <i class="fas fa-phone" id="username"></i> Whatsapp
      </a>
    </div>
    <div class="col-md-6 text-center position-relative">
      <p id="diskon"></p>
      <img id="gambar" src=""
           alt="Gambar Perusahaan"
           class="img-fluid rounded-lg shadow hero-img">
    </div>
  </div>

  <!-- Deskripsi Usaha -->
  <div class="row mb-5">
    <div class="col text-center">
      <h2 class="mb-3 font-weight-bold">Tentang Kami</h2>
      <p class="text-muted mb-4 px-md-5" id="deksripsi">
        <!-- deskripsi -->
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
        <p class="mb-0" id="alamat"></p>
        <p class="mb-0 star-rating" id="rating-layanan"></p>
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
          <input type="text" id="review-input" name="komentar" class="form-control" placeholder="Tulis ulasan Anda..." required>
        </div>

        <!-- Rating bintang -->
        <div class="form-group mb-3">
          <label>Rating:</label>
          <div id="star-rating" class="star-rating">
            <span data-value="1">☆</span>
            <span data-value="2">☆</span>
            <span data-value="3">☆</span>
            <span data-value="4">☆</span>
            <span data-value="5">☆</span>
          </div>
          <input type="hidden" id="rating" name="rating" required>
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

/* .star-rating {
  color: #ffc107;
} */

.star-rating span {
  font-size: 1.5rem;
  cursor: pointer;
  transition: color 0.2s;
}
.star-rating span.hover,
.star-rating span.selected {
  color: #ffc107;
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


    <script src="/template/js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="/template/js/plugins.js"></script>
    <script src="/template/js/script.js"></script>
    <script>

    $(document).ready(function(){
      const pathSegments = window.location.pathname.split('/');
      const id = pathSegments[pathSegments.length - 1];
      const email = '<?= session()->get('email') ?>';
      const no_handphone = '<?= session()->get('no_handphone') ?>';
      const username = '<?= session()->get('username') ?>';
      console.log(id, email, no_handphone, username);
      let namaJasa = '';
      let deskripsi = '';
      let allReviews = [];  
      let visibleCount = 3;
      // Ambil data layanan
      $.ajax({
        url: `/api/v1/layanan/${id}`,
        dataType: 'json',
        success: function(response) {
        const data = response.data; 
        console.log(data)
        namaJasa = data.nama_jasa;
        deskripsi = `pengguna dengan nama ${username} melakukan penawaran dengan jasa ${namaJasa}`;


          $('#nama_jasa').text(data.nama_jasa);
          $('#deksripsi').text(data.deskripsi);
          $('#username').text(data.username);
          $('#alamat').text(data.alamat);
          $('#gambar').attr('src', '/' + data.image_url);
          $('#bidang_jasa').text(data.bidang_jasa);
          if(parseInt(data.discount) > 0){
            $('#diskon').html(`
              <span class="badge bg-primary text-white position-absolute top-0 start-0 m-4 p-2">
                Diskon ${data.discount}%
              </span>
            `);
          } else {
            $('discount').empty();
          }


          console.log(data);

          const whatsappLink = `https://api.whatsapp.com/send?phone=${data.no_handphone_user}&text=Halo, saya ${username} ingin menanyakan tentang layanan ${namaJasa}.`;
          $('#sendlog').attr('href', whatsappLink);

          console.log(whatsappLink)

        },
        error: function(xhr, status, error) {
          console.error('Error fetching layanan data:', error);
          $('#nama_jasa').text('Layanan tidak ditemukan');
        }
      });

       const rating = (id) => {
        $.ajax({
        url: `/api/v1/review/rating/${id}`,
        method: "GET",
        contentType: "application/json",
        dataType: "json",
        success: function(response) {
          const data = response.data;
          let stars = '';
          for (let i = 1; i <= 5; i++) {
            if (i <= data.average_rating) {
              stars += "★";
            } else {
              stars += "☆";
            }
          }
          $("#rating-layanan").html(stars);
        },
      })
      }

      rating(id);


      const review = () => {
        $.ajax({
        url: `/api/v1/review/layanan/${id}`,
        method: "GET",
        contentType: "application/json",
        dataType: "json",
        success: function(response) {
          const reviews = response.data;
          if (reviews.length === 0) {
            $('#review-container').html('<p class="text-muted">Belum ada review.</p>');
            return;
          }
          let reviewHtml = '';
          const toShow = allReviews.slice(0, visibleCount);
          reviews.forEach(review => {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
              stars += i <= review.rating ? '⭐' : '☆';
            }
            reviewHtml += `
              <div class="card mb-3 shadow-sm">
              <div class="d-flex align-items-center p-3">
                <img src="/${review.upload_url}" alt="User" class="rounded-circle me-3" width="50" height="50">
                <div>
                  <p class="mb-2 font-italic text-dark">"${review.komentar}"</p>
                  <p class="mb-1">${stars}</p>
                  <small class="text-muted">- ${review.username} (${review.email})</small>
                </div>
              </div>
            </div>
            `;
        }),
          $('#review-container').html(reviewHtml);
        },
      })
      }
      
      review();

      // Klik kirim log
      $('#sendlog').on('click', function(e) {
        e.preventDefault();

        const formData = {
          email: email,
          no_handphone: no_handphone,
          deskripsi: deskripsi
        };  
        console.log(formData);

        $.ajax({
          url: `/api/v1/log`,
          type: 'POST',
          dataType: 'json',
          contentType: 'application/json',
          data: JSON.stringify(formData),
          success: function(response) {
            console.log('Log entry created:', response.message);
            window.open($('#sendlog').attr('href'), '_blank');
          },
          error: function(xhr, status, error) {
            console.error('Error creating log entry:', error);
          }
        });
      });

      let selectedRating = 0;

      $('#star-rating span').hover(
        function() {
          const value = $(this).data('value');
          $('#star-rating span').each(function() {
            $(this).toggleClass('hover', $(this).data('value') <= value);
          });
        },
        function() {
          $('#star-rating span').removeClass('hover');
        }
      );

      $('#star-rating span').click(function() {
        selectedRating = $(this).data('value');
        $('#rating').val(selectedRating);

        $('#star-rating span').removeClass('selected');

        $('#star-rating span').each(function() {
          if ($(this).data('value') <= selectedRating) {
            $(this).addClass('selected');
          }
        });
      });

      $('#review-form').on('submit', function(e) {
        e.preventDefault();

        const formData = {
          user_id: '<?= session()->get('id') ?>',
          layanan_id: id,
          komentar: $('#review-input').val(),
           rating: selectedRating
        };  

        console.log(formData);

        $.ajax({
          url: `/api/v1/review`,
          type: 'POST',
          dataType: 'json',
          contentType: 'application/json',
          data: JSON.stringify(formData),
          success: function(response) {
            $('#review-input').val('');
            selectedRating = 0;
            $('#rating').val('');
            $('#star-rating span').removeClass('selected');
            review();
          },
          error: function(xhr, status, error) {
            console.error('Error creating log entry:', error);
          }
        });
      });
    });

    
  </script>

</body>
</html>

