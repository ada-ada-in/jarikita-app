<section class="py-3 overflow-hidden">
  <div class="container-fluid">

    <div class="row my-5">
      <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false">
        <div class="carousel-inner" id="banner-list">
          <!-- banner list -->
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

  </div>
</section>

<script>
$(document).ready(function() {

  // Ambil Banner Promo
  $.ajax({
    url: "/api/v1/bannerpromo",
    method: "GET",
    dataType: "json",
    success: function(response) {
      const banners = response.data;
      const bannerContainer = $('#banner-list'); // tempat carousel-inner

      bannerContainer.empty();

      // loop per 4 item → 1 slide (kolase 2x2)
      // loop per 4 item → 1 slide
      for (let i = 0; i < banners.length; i += 4) {
        const isActive = i === 0 ? 'active' : '';
        let imgs = '';

        const chunk = banners.slice(i, i + 4);

        chunk.forEach(banner => {
          imgs += `
            <img src="${banner.image_link}" 
                style="width:100%; height:100%; object-fit:contain; background:#f8f9fa;" 
                alt="">
          `;
        });

        // kalau kurang dari 4, tambahin placeholder biar grid tetap rapat
        if (chunk.length < 4) {
          for (let j = chunk.length; j < 4; j++) {
            imgs += `
              <div style="width:100%; height:100%; background:#f0f0f0;"></div>
            `;
          }
        }

        const bannerItem = `
          <div class="carousel-item ${isActive}">
            <div style="
                height:400px; 
                display:grid; 
                grid-template-columns: repeat(2, 1fr); 
                gap:10px; 
                background:#fff; 
                padding:10px;">
              ${imgs}
            </div>
          </div>
        `;

        bannerContainer.append(bannerItem);
      }

    },
    error: function(xhr) {
      console.error("Error fetching banner data:", xhr);
    }
  });

  // Ambil Lokasi
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
