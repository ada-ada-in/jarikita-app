    <section class="py-3 overflow-hidden">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

            <div class="section-header d-flex flex-wrap justify-content-between mb-5">
              <h2 class="section-title">Lokasi</h2>

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
                <a href="/lokasi/${lokasi.id}" class="nav-link category-item swiper-slide shadow-m">
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