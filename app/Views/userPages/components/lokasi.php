    <section class="py-3 overflow-hidden">
      <div class="container-fluid">

      <div class="row my-5">
        <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="https://www.creativefabrica.com/wp-content/uploads/2022/12/10/Discount-Banner-Design-Template-Graphics-51400296-1.jpg" class="d-block w-100" style="height:400px; object-fit:cover;"  alt="...">
            </div>
            <div class="carousel-item">
              <img src="https://www.creativefabrica.com/wp-content/uploads/2022/12/10/Discount-Banner-Design-Template-Graphics-51400296-1.jpg" class="d-block w-100" style="height:400px; object-fit:cover;" alt="...">
            </div>
            <div class="carousel-item">
              <img src="https://www.creativefabrica.com/wp-content/uploads/2022/12/10/Discount-Banner-Design-Template-Graphics-51400296-1.jpg" class="d-block w-100" style="height:400px; object-fit:cover;" alt="...">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>

        <div class="row">
          <div class="col-md-12">

            <div class="section-header d-flex flex-wrap justify-content-between mb-1">
              <h2 class="section-title">Jenis Jasa</h2>

              <div class="d-flex align-items-center">
                <a href="#" class="btn-link text-decoration-none">Lihat Semua Lokasi →</a>
                <div class="swiper-buttons">
                  <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
                  <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">

            <div class="category-carousel swiper">
              <div class="swiper-wrapper" id="lokasi-list">
                
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>


    <script>
      $(document).ready(function() {
        $.ajax({
          url: "/api/v1/lokasi",
          method: "GET",
          dataType: "json",
          success: function(response) {
            const lokasiList = response.data;
            console.log(lokasiList);
            const lokasiContainer = $('#lokasi-list');
            lokasiList.forEach(function(lokasi) {
              const lokasiItem = `
                <a href="/lokasi/${lokasi.id}" class="nav-link category-item swiper-slide">
                  <img src="/template/images/google-maps.png" width="50" alt="Category Thumbnail">
                  <h3 class="category-title">${lokasi.lokasi}</h3>
                </a>
              `;
              lokasiContainer.append(lokasiItem);
            });
          },
          error: function(xhr) {
            console.error("Error fetching lokasi data:", xhr);
          }
        });
      });
    </script>