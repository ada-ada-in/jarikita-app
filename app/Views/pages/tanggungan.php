<?= $this->extend('layouth/admin_layout') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
                    <div class="row d-flex justify-content-between ">
                            <div class="col-md-6 col-sm-12">
                                <div class="title">
                                    <h4>Data Tanggungan BPJS</h4>
                                </div>
                                <nav aria-label="breadcrumb" role="navigation">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?= url_to('admin') ?>">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                         Jasa
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-md-3 col-sm-4 text-right">
								<div class="form-group">
									<input class="form-control" id="searchinput" placeholder="Cari....." type="text" />
								</div>
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
										<th>No. PP</th>
										<th>Role</th>
										<th>Email</th>
										<th>No. Handphone</th>
										<th>Alamat</th>
										<th>Status BPJS</th>
										<th>Tanggal Pembayaran Terakhir</th>
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

<?= view('pages/modals/tanggungan/edit-tanggungan-modals') ?>

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
                        <td>${item.username}</td>
                        <td>${item.nopp}</td>
                        <td>${item.role}</td>
                        <td>${item.email}</td>
                        <td>${item.no_handphone}</td>
                        <td>${item.alamat}</td>
                        <td>${item.bpjs_status_pembayaran}</td>
                        <td>${item.bpjs_pembayaran}</td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <button type="button" class="dropdown-item btn-edit-tanggungan" data-toggle="modal" data-target="#edittanggunganmodal"
                                        data-id="${item.id}"
                                        data-username="${item.username}"
                                        data-nopp="${item.nopp}"
                                        data-email="${item.email}"
                                        data-no_handphone="${item.no_handphone}"
                                        data-alamat="${item.alamat}"
                                        data-bpjs_status_pembayaran="${item.bpjs_status_pembayaran}"
                                        data-bpjs_pembayaran="${item.bpjs_pembayaran}"
                                        >
                                        <i class="dw dw-edit2"></i> Edit
                                    </button>
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

        function loadData() {
            $.ajax({
                url: '/api/v1/users',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    filteredData = response.data;
                    console.log("YAYA :",  filteredData)
                    displayTable(filteredData);
                    displayPagination(filteredData.length);
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        loadData();

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

        $(document).on('click', '.btn-edit-tanggungan', function () {
            const button = $(this);
            const id = button.data('id');
            $('#form-edit-tanggungan').data('id', id);
            $('#edittanggunganmodal input[name="id"]').val(button.data('id'));
            $('#edittanggunganmodal input[name="username"]').val(button.data('username'));
            $('#edittanggunganmodal select[name="bpjs_status_pembayaran"]').val(button.data('bpjs_status_pembayaran')).trigger('change');
            $('#edittanggunganmodal input[name="nopp"]').val(button.data('nopp'));
            $('#edittanggunganmodal input[name="email"]').val(button.data('email'));
            $('#edittanggunganmodal input[name="no_handphone"]').val(button.data('no_handphone'));
            $('#edittanggunganmodal input[name="alamat"]').val(button.data('alamat'));
            let tanggal = button.data('bpjs_pembayaran'); 
            if (tanggal) {
                let fixedDate = tanggal.split(" ")[0];
                $('#edittanggunganmodal input[name="bpjs_pembayaran"]').val(fixedDate);
            }
        });

    $('#form-edit-tanggungan').on('submit', function (e) {
    e.preventDefault();

    const id = $(this).data('id'); 
    const form = this;
	const formData = new FormData(form);
    console.log("id", id);

    $.ajax({
            url: `/api/v1/users/${id}`,
            type: 'POST',
            data: formData,
            processData: false,
			contentType: false, 
            success: function (response) {
                console.log(response.data)
                alert(response.message);
                $('#edittanggunganmodal').modal('hide');
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
            item.username.toLowerCase().includes(keyword) ||
            item.nopp.toLowerCase().includes(keyword) ||
            item.email.toLowerCase().includes(keyword) ||
            item.no_handphone.toLowerCase().includes(keyword) ||
            item.alamat.toLowerCase().includes(keyword) ||
            item.bpjs_status_pembayaran.toLowerCase().includes(keyword)
        );

        currentPage = 1; // reset to first page
        displayTable(filtered);
        displayPagination(filtered.length);
    });
    });
</script>

<div id="pagination" class="mt-3 text-center"></div>


<?= $this->endSection() ?> 