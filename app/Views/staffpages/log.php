<?= $this->extend('layouth/staff_layout') ?>
<?= $this->section('content') ?>

<div class="pd-ltr-20 xs-pd-20-10">
    
				<div class="min-height-200px">
					<div class="page-header">
                    <div class="row d-flex justify-content-between ">
                            <div class="col-md-6 col-sm-12">
                                <div class="title">
                                    <h4>Data Log Info</h4>
                                </div>
                                <nav aria-label="breadcrumb" role="navigation">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?= url_to('admin') ?>">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Log Info
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
										<th style="width: 40%;">Deskripsi</th>
										<th>Nomor Handphone</th>
										<th>Email</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody id="data-log">
									<!-- data log -->
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

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
                        <td>${item.deskripsi}</td>
                        <td>${item.no_handphone}</td>
                        <td>${item.email}</td>
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

            $('#data-log').html(row);
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
                url: '/api/v1/log',
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

        // Delete

        $(document).on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            if (confirm('Apakah kamu yakin ingin menghapus log ini?')) {
                $.ajax({
                    url: `/api/v1/log/${id}`,
                    type: 'DELETE',
                    success: function () {
                        alert('Log berhasil dihapus!');
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


    $('#searchinput').on('input', function () {
        const keyword = $(this).val().toLowerCase();
        const filtered = filteredData.filter(item =>
            item.deskripsi.toLowerCase().includes(keyword) ||
            item.email.toLowerCase().includes(keyword) ||
            item.no_handphone.toLowerCase().includes(keyword)
        );

        currentPage = 1; // reset to first page
        displayTable(filtered);
        displayPagination(filtered.length);
    });
    });
</script>

<div id="pagination" class="mt-3 text-center"></div>


<?= $this->endSection() ?>