<?= $this->extend('layouth/staff_layout') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
                    <div class="row d-flex justify-content-between ">
                            <div class="col-md-6 col-sm-12">
                                <div class="title">
                                    <h4>Data Penyedia Jasa</h4>
                                </div>
                                <nav aria-label="breadcrumb" role="navigation">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?= url_to('admin') ?>">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Penyedia Jasa
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-md-3 col-sm-4 text-right">
								<div class="form-group">
									<input class="form-control" id="searchinput" placeholder="Cari....." type="text" />
								</div>
								<button class="btn btn-primary " data-toggle="modal" data-target="#addjasamodal" >+</button>
							</div>
                        </div>

					</div>


					<div class="card-box mb-30">
						<div class="pb-20 table-responsive">
							<table class="data-table table stripe hover data-table-export nowrap">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">No.</th>
										<th>Nama</th>
										<th>Nama Jasa</th>
										<th>Email</th>
										<th>Nomor Handphone</th>
										<th>Lokasi</th>
										<th>Alamat</th>
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

<?= view('pages/modals/jasa/add-jasa-modals') ?>
<?= view('pages/modals/jasa/edit-jasa-modals') ?>

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
                        <td>${item.username_user}</td>
                        <td>${item.nama_jasa}</td>
                        <td>${item.email_user}</td>
                        <td>${item.no_handphone_user}</td>
                        <td>${item.nama_lokasi}</td>
                        <td>${item.alamat}</td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <button type="button" class="dropdown-item btn-edit-jasa" data-toggle="modal" data-target="#editjasamodal"
                                        data-id="${item.id}"
                                        data-user_id="${item.user_id}"
                                        data-lokasi_id="${item.lokasi_id}"
                                        data-deskripsi="${item.deskripsi}"
                                        data-nama_jasa="${item.nama_jasa}"
                                        data-image_url="${item.image_url}"
                                        data-nama_email_user="${item.nama_email_user}"
                                        data-no_handphone_user="${item.no_handphone_user}"
                                        data-nama_lokasi="${item.nama_lokasi}"
                                        data-alamat="${item.alamat}"
                                        data-username_user="${item.username_user}">
                                        <i class="dw dw-edit2"></i> Edit
                                    </button>
                                    <button class="dropdown-item btn-delete" data-id="${item.id}">
                                        <i class="dw dw-delete-3"></i> Delete
                                    </button>
                                    <a class="dropdown-item" href="/profile/${item.id}">
                                        <i class="dw dw-file-3"></i> View
                                    </a>
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
                url: '/api/v1/layanan',
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

        $('#form-add-jasa').on('submit', function (e) {
        e.preventDefault();

        const form = this;
		const formData = new FormData(form);

        $.ajax({
            url: `/api/v1/layanan`,
            type: 'POST',
           data: formData,
			processData: false,
			contentType: false, 
            success: function (response) {
                console.log(response.data);
                alert(response.message);
                $('#form-add-layanan')[0].reset();
                loadData();
                $('#addlayananmodal').modal('hide');
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
                    url: `/api/v1/layanan/${id}`,
                    type: 'DELETE',
                    success: function () {
                        alert('layanan berhasil dihapus!');
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


        // Update

        $(document).on('click', '.btn-edit-jasa', function () {
            const button = $(this);
            $('#editjasamodal input[name="id"]').val(button.data('id'));
            $('#editjasamodal select[name="user_id"]').val(button.data('user_id')).trigger('change');
            $('#editjasamodal select[name="lokasi_id"]').val(button.data('lokasi_id')).trigger('change');
            $('#editjasamodal input[name="nama_jasa"]').val(button.data('nama_jasa'));
            $('#editjasamodal input[name="alamat"]').val(button.data('alamat'));
            $('#editjasamodal input[name="image"]').val(button.data('image_url'));
            $('#editjasamodal textarea[name="deskripsi"]').val(button.data('deskripsi'));
        });

    $('#form-edit-jasa').on('submit', function (e) {
    e.preventDefault();

    const form = this;
	const formData = new FormData(form);
    const id = formData.get('id');

    $.ajax({
            url: `/api/v1/layanan/${id}`,
            type: 'POST',
            data: formData,
            processData: false,
			contentType: false, 
            success: function (response) {
                alert(response.message);
                $('#editjasamodal').modal('hide');
                loadData();
            },
            error: function (xhr) {
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
                        errorMessage = 'Terjadi kesalahan saat update.';
                    }
                    alert(errorMessage);
                } catch (e) {
                    alert('Gagal memproses respons error.');
                }
            }
        });
    });


    $('#searchinput').on('input', function () {
        const keyword = $(this).val().toLowerCase();
        const filtered = filteredData.filter(item =>
            item.nama_jasa.toLowerCase().includes(keyword) ||
            item.alamat.toLowerCase().includes(keyword) ||
            item.deskripsi.toLowerCase().includes(keyword) ||
            item.username_user.toLowerCase().includes(keyword) ||
            item.email_user.toLowerCase().includes(keyword) ||
            item.alamat_user.toLowerCase().includes(keyword) ||
            item.nama_lokasi.toLowerCase().includes(keyword) 
        );

        currentPage = 1; // reset to first page
        displayTable(filtered);
        displayPagination(filtered.length);
    });
    });
</script>

<div id="pagination" class="mt-3 text-center"></div>


<?= $this->endSection() ?> 