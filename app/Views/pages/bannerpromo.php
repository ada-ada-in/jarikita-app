<?= $this->extend('layouth/admin_layout') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
                    <div class="row d-flex justify-content-between ">
                            <div class="col-md-6 col-sm-12">
                                <div class="title">
                                    <h4>Data Banner Promo</h4>
                                </div>
                                <nav aria-label="breadcrumb" role="navigation">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?= url_to('admin') ?>">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Banner Promo 
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-md-3 col-sm-4 text-right">
								<div class="form-group">
									<input class="form-control" id="searchinput" placeholder="Cari....." type="text" />
								</div>
								<button class="btn btn-primary " data-toggle="modal" data-target="#addbannermodal" >+</button>
							</div>
                        </div>

					</div>


					<div class="card-box mb-30">
						<div class="pb-20 table-responsive">
							<table class="data-table table stripe hover data-table-export nowrap">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">No.</th>
										<th>Gambar Banner</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody id="data-jasa">
									<!--  -->
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

<?= view('pages/modals/banner/add-banner-modals') ?>

<script>
    $(function () {
        let currentPage = 1;
        const rowsPerPage = 10;
        let filteredData = [];

        function displayTable(data) {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const paginatedItems = data.slice(start, end);

            let row = '';
            paginatedItems.forEach((item, i) => {
                row += `
                    <tr>
                        <td class="table-plus">${start + i + 1}</td>
                        <td><img src="/${item.image_link}" width="80" alt="avatar" style="border-radius: 5px;" /></td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <button class="dropdown-item btn-delete" data-id="${item.id}">
                                        <i class="dw dw-delete-3"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
            });

            $('#data-jasa').html(row);
            $('#pageInfo').text(`Page ${currentPage} of ${Math.ceil(data.length / rowsPerPage)}`);
        }

        // Paginasi

        function displayPagination(totalItems) {
            const totalPages = Math.ceil(totalItems / rowsPerPage);
            let paginationButtons = '';

            for (let i = 1; i <= totalPages; i++) {
                paginationButtons += `
                    <button class="btn btn-sm ${i === currentPage ? 'btn-primary' : 'btn-secondary'}" data-page="${i}">
                        ${i}
                    </button>
                `;
            }

            $('#pagination').html(paginationButtons);
        }

        $(document).on('click', '#pagination button', function () {
            currentPage = parseInt($(this).data('page'));
            displayTable(filteredData);
            displayPagination(filteredData.length);
        });

        // Fetch Data

        function loadData() {
            $.ajax({
                url: '/api/v1/bannerpromo',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    filteredData = response.data;
                    console.log('Data fetched successfully:', filteredData);
                    displayTable(filteredData);
                    displayPagination(filteredData.length);
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        loadData();

        $('#form-add-banner').on('submit', function (e) {
        e.preventDefault();

        const form = this;
		const formData = new FormData(form);
        console.log('Form Data:', Array.from(formData.entries()));

        $.ajax({
            url: `/api/v1/bannerpromo`,
            type: 'POST',
           data: formData,
			processData: false,
			contentType: false, 
            success: function (response) {
                console.log(response.data);
                alert(response.message);
                $('#form-add-banner')[0].reset();
                loadData();
                $('#addbannermodal').modal('hide');
            },
            error: function (xhr, status, error) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    let errorMessage = '';
                    if (response.messages) {
                        for (const key in response.messages) {
                            errorMessage += `${response.messages[key]}\n`;
                        }
                    } else if (response.message) {
                        errorMessage = response.message;
                    } else {
                        errorMessage = 'Terjadi kesalahan yang tidak diketahui.';
                    }
                    alert(errorMessage);
                } catch (e) {
                    console.error('Gagal parse response error:', e);
                    alert('Terjadi kesalahan saat memproses respons error.');
                }
            }
        });
    });



        // Delete

        $(document).on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            if (confirm('Apakah kamu yakin ingin menghapus layanan ini?')) {
                $.ajax({
                    url: `/api/v1/bannerpromo/${id}`,
                    type: 'DELETE',
                    success: function () {
                        alert('Banner berhasil dihapus!');
                        loadData(); 
                    },
                    error: function (xhr, status, error) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            let errorMessage = '';
                            if (response.messages) {
                                for (const key in response.messages) {
                                    if (response.messages.hasOwnProperty(key)) {
                                        errorMessage += `${response.messages[key]}\n`;
                                    }
                                }
                            } else if (response.message) {
                                errorMessage = response.message;
                            } else {
                                errorMessage = 'Terjadi kesalahan yang tidak diketahui.';
                            }
                            alert(errorMessage); 
                        } catch (e) {
                            console.error('Gagal parse response error:', e);
                            alert('Terjadi kesalahan saat memproses respons error.');
                        }
                    }
                });
            }
        });

    });
</script>

<div id="pagination" class="mt-3 text-center"></div>


<?= $this->endSection() ?> 