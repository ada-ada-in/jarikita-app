<!DOCTYPE html>
<html lang="en">
    <?= view('userPages/layout/header') ?>
  <body>

   <?= view('userPages/layout/navbar') ?>

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
            <div class="dropdown">
              <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Sort By
              </button>
              <ul class="dropdown-menu" aria-labelledby="sortDropdown" id="sort-options"> 
                <li>
                 <a href="/" class="dropdown-item fs-6">All</a>
                </li>
              </ul>
            </div>
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
    const pathSegments = window.location.pathname.split('/');
    const id = pathSegments[pathSegments.length - 1];
    $.ajax({
      url: `/api/v1/layanan/lokasi/${id}`,
      method: "GET",
      dataType: "json",
      success: function (response) {
        const jasaList = Array.isArray(response.data) ? response.data : [];
        console.log(jasaList);
        const jasaContainer = $('#jasa-list');

        jasaList.forEach(function (jasa) {
          const jasaItem = `
            <div class="col"> 
              <div class="product-item shadow">
                <figure style="width:100%; height:250px; overflow:hidden; display:flex; justify-content:center; align-items:center;">
                  <a href="/profile/${jasa.id}" title="${jasa.nama_jasa}" style="display:block; width:100%; height:100%;">
                    <img src="/${jasa.image_url}" alt="${jasa.nama_jasa}" 
                        style="width:100%; height:100%; object-fit:cover; border-radius:8px;">
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

  $(document).ready(function() {
        $.ajax({
          url: "/api/v1/lokasi",
          method: "GET",
          dataType: "json",
          success: function(response) {
            const lokasiList = response.data;
            console.log(lokasiList);
            const lokasiContainer = $('#sort-options');
            lokasiList.forEach(function(lokasi) {
              const lokasiItem = `
              <a href="/lokasi/${lokasi.id}" class="dropdown-item fs-6">${lokasi.lokasi}</a>
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

    <?= view('userPages/layout/footer') ?>

  </body>
</html>s