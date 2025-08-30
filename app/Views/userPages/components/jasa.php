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

  .disabled {
    pointer-events: none;
    opacity: 0.6;
  }
</style>

<section>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">

        <div class="bootstrap-tabs product-tabs">
          <div class="tabs-header d-flex justify-content-between border-bottom my-5">
            <h3>Katalog Jasa</h3>
            <div class="dropdown">
              <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Lokasi
              </button>
              <ul class="dropdown-menu" aria-labelledby="sortDropdown" id="sort-options"> 
                <li><a href="/" class="dropdown-item fs-6">All</a></li>
              </ul>
            </div>
          </div>

          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
              <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5" id="jasa-list">
                <!-- Jasa items here -->
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
    const role = "<?= session()->get('role'); ?>";

    $.ajax({
      url: "/api/v1/layanan",
      method: "GET",
      dataType: "json",
        success: function (response) {
          const jasaList = response.data;
          const jasaContainer = $('#jasa-list');

          jasaList.forEach(function (jasa) {
            let badgeClass = '';
            let badgeText = '';
            let isDisabled = false;

            let pembayaranTerakhir = null;
            if (jasa.bpjs_pembayaran_user && jasa.bpjs_pembayaran_user !== "0000-00-00 00:00:00") {
              const [datePart, timePart] = jasa.bpjs_pembayaran_user.split(" ");
              const [year, month, day] = datePart.split("-");
              const [hour, minute, second] = timePart.split(":");
              pembayaranTerakhir = new Date(year, month - 1, day, hour, minute, second);
            }

            if (pembayaranTerakhir) {
              const now = new Date();
              const diffMonths = (now.getFullYear() - pembayaranTerakhir.getFullYear()) * 12 + (now.getMonth() - pembayaranTerakhir.getMonth());

              if (diffMonths <= 1) {
                badgeClass = 'bg-success text-white';
                badgeText = 'On Time';
              } else if (diffMonths >= 3 && diffMonths < 6) {
                badgeClass = 'bg-warning text-dark';
                badgeText = 'Late';
              } else if (diffMonths >= 6) {
                badgeClass = 'bg-danger text-white';
                badgeText = 'Disabled';
                isDisabled = true;
              }
            } else {
              badgeClass = 'bg-secondary text-white';
              badgeText = 'No Payment';
            }

            const jasaItem = `
              <div class="col ${isDisabled ? 'disabled' : ''}"> 
                <div class="product-item shadow">
                  <figure class="position-relative" style="width:100%; height:250px; overflow:hidden; border-radius:8px;">
                    <a href="/profile/${jasa.id}" title="${jasa.nama_jasa}" class="d-block w-100 h-100">
                    ${jasa.discount > 0 ? `<span class="badge bg-primary te xt-white position-absolute top-0 start-0 m-2">Diskon ${jasa.discount}%</span>` : ""}
                      <img src="${jasa.image_url}" alt="${jasa.nama_jasa}" class="w-100 h-100" style="object-fit:cover; border-radius:8px;">
                    </a>
                  </figure>     
                  <h3 class="text-center">${jasa.nama_jasa}</h3>
                  <div class="text-center" id="rating-layanan-${jasa.id}">Loading...</div>
                  <p class="text-center"><span class="badge ${badgeClass}">${badgeText}</span></p>
                  ${role === 'admin' || role === 'staff' ? `<p class="text-center">No. PP : ${jasa.nopp_user}</p>` : ''}
                  ${role === 'admin' || role === 'staff' ? `<p class="text-center">${jasa.bpjs_status_pembayaran_user}</p>` : ''}
                  <p class="text-center">${jasa.nama_lokasi}</p>
                </div>
              </div>
            `;

            jasaContainer.append(jasaItem);

            $.ajax({
              url: `/api/v1/review/rating/${jasa.id}`,
              method: "GET",
              dataType: "json",
              success: function(res) {
                const data = res.data;
                let stars = "";
                for (let i = 1; i <= 5; i++) {
                  stars += i <= Math.round(data.average_rating) ? "★" : "☆";
                }
                $(`#rating-layanan-${jasa.id}`).html(
                  `<span style="color: gold; font-weight: bold; font-size: 16px;">
                    ${stars}
                  </span> 
                  <span style="color: #555; font-size: 14px;">
                    (${data.total_reviews} review)
                  </span>`
                );
              },
              error: function() {
                $(`#rating-layanan-${jasa.id}`).html("No rating");
              }
            });

          });
        }
        ,
      error: function (xhr) {
        console.error("Error fetching jasa data:", xhr);
      }
    });

    $.ajax({
      url: "/api/v1/lokasi",
      method: "GET",
      dataType: "json",
      success: function(response) {
        const lokasiList = response.data;
        const lokasiContainer = $('#sort-options');
        lokasiList.forEach(function(lokasi) {
          const lokasiItem = `<a href="/lokasi/${lokasi.id}" class="dropdown-item fs-6">${lokasi.lokasi}</a>`;
          lokasiContainer.append(lokasiItem);
        });
      },
      error: function(xhr) {
        console.error("Error fetching lokasi data:", xhr);
      }
    });
  });
</script>
