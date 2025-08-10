<style>
  .product-item figure {
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    border-radius: 8px; 
  }

  .product-item img {
    width: 100%;
    height: 100%;
    object-fit: cover; 
    display: block;
  }
</style>

<section class="py-2">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">

        <div class="bootstrap-tabs product-tabs">
          <div class="tabs-header d-flex justify-content-between border-bottom my-5">
            <h3>Katalog Jasa</h3>
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a href="#" class="nav-link text-uppercase fs-6 active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all">All</a>
              </div>
            </nav>
          </div>

          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
              <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5" id="jasa-list">
                <!-- Jasa items will be dynamically inserted here -->
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>

<script>
  $(document).ready(function () {
    $.ajax({
      url: "/api/v1/layanan",
      method: "GET",
      dataType: "json",
      success: function (response) {
        const jasaList = response.data;
        console.log(jasaList);
        const jasaContainer = $('#jasa-list');

        jasaList.forEach(function (jasa) {
          const jasaItem = `
            <div class="col shadow-lg"> 
              <div class="product-item">
                <figure>
                  <a href="/jasa/${jasa.id}" title="${jasa.nama_jasa}">
                    <img src="${jasa.image_url}" alt="${jasa.nama_jasa}">
                  </a>
                </figure>
                <h3 class="text-center">${jasa.nama_jasa}</h3>
                <p class="text-center">${jasa.nama_lokasi}</p>
              </div>
            </div>
          `;
          jasaContainer.append(jasaItem);
        });
      },
      error: function (xhr) {
        console.error("Error fetching jasa data:", xhr);
      }
    });
  });
</script>