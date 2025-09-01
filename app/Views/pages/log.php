<?= $this->extend('layouth/admin_layout') ?>
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

        <!-- Filter tanggal + export -->
        <div class="row mb-3">
            <div class="col-md-6 d-flex gap-2 align-items-end">
                <div>
                    <label>Dari Tanggal</label>
                    <input type="date" id="startDate" class="form-control">
                </div>
                <div>
                    <label>Sampai Tanggal</label>
                    <input type="date" id="endDate" class="form-control">
                </div>
                <div>
                    <button id="exportExcel" class="btn btn-success mx-2">
                        <i class="dw dw-download"></i> Export Excel
                    </button>
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
                            <th>Tanggal</th>
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

<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script>
    $(function () {

        $('#exportExcel').on('click', async function () {
            let exportData = [...filteredData];

            const startDate = $('#startDate').val() ? new Date($('#startDate').val()) : null;
            const endDate = $('#endDate').val() ? new Date($('#endDate').val()) : null;

            if (startDate || endDate) {
                exportData = exportData.filter(item => {
                    const itemDate = new Date(item.created_at);
                    if (startDate && itemDate < startDate) return false;
                    if (endDate && itemDate > endDate) return false;
                    return true;
                });
            }

            if (exportData.length === 0) {
                alert("Tidak ada data dalam rentang tanggal yang dipilih.");
                return;
            }

            exportData.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

            // === Mulai bikin file Excel ===
            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet("Log Info");

            // Tambahkan Judul
            worksheet.mergeCells("A1:E1");
            const titleCell = worksheet.getCell("A1");
            titleCell.value = "📑 Laporan Log Info";
            titleCell.font = { size: 16, bold: true, color: { argb: '1E3A8A' } };
            titleCell.alignment = { vertical: "middle", horizontal: "center" };

            // Tambahkan Gambar dari public (sesuaikan path)
            const imageUrl = "<?= base_url('template/images/logo-jari-kita.png') ?>";
            const response = await fetch(imageUrl);
            const blob = await response.blob();
            const arrayBuffer = await blob.arrayBuffer();

            const imageId = workbook.addImage({
                buffer: arrayBuffer,
                extension: 'png',
            });

            worksheet.addImage(imageId, {
                tl: { col: 0, row: 1 },
                ext: { width: 60, height: 60 }
            });

            // Spacer biar tabel tidak dempet
            worksheet.addRow([]);
            const headerRow = worksheet.addRow(["No", "Deskripsi", "Nomor HP", "Email", "Tanggal"]);

            // Style Header
            headerRow.font = { bold: true, size: 12, color: { argb: "FFFFFF" } };
            headerRow.alignment = { horizontal: "center", vertical: "middle" };
            headerRow.height = 25;

            headerRow.eachCell(cell => {
                cell.fill = {
                    type: "pattern",
                    pattern: "solid",
                    fgColor: { argb: "2563EB" } // biru elegan
                };
                cell.border = {
                    top: { style: 'thin' },
                    left: { style: 'thin' },
                    bottom: { style: 'thin' },
                    right: { style: 'thin' }
                };
            });

            // Data isi
            exportData.forEach((item, i) => {
                const row = worksheet.addRow([
                    i + 1,
                    item.deskripsi,
                    item.no_handphone,
                    item.email,
                    new Date(item.created_at).toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    })
                ]);

                // Rapiin alignment
                row.getCell(1).alignment = { horizontal: "center" }; // No
                row.getCell(5).alignment = { horizontal: "center" }; // Tanggal
            });

            // Auto width
            worksheet.columns.forEach(col => {
                let maxLength = 0;
                col.eachCell({ includeEmpty: true }, cell => {
                    const val = cell.value ? cell.value.toString() : "";
                    maxLength = Math.max(maxLength, val.length);
                });
                col.width = maxLength < 20 ? 20 : maxLength + 2;
            });

            // Border semua cell
            worksheet.eachRow((row, rowNumber) => {
                if (rowNumber > 2) { // skip title
                    row.eachCell(cell => {
                        cell.border = {
                            top: { style: 'thin' },
                            left: { style: 'thin' },
                            bottom: { style: 'thin' },
                            right: { style: 'thin' }
                        };
                    });
                }
            });

            // Nama file sesuai tanggal export
            const fileName = `log_info_${new Date().toISOString().slice(0,10)}.xlsx`;

            workbook.xlsx.writeBuffer().then(buffer => {
                saveAs(new Blob([buffer], { type: "application/octet-stream" }), fileName);
            });
        });


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
                        <td>${item.created_at}</td>
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
        }

        // Pagination
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
                    displayTable(filteredData);
                    displayPagination(filteredData.length);
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        loadData();

        // Search
        $('#searchinput').on('input', function () {
            const keyword = $(this).val().toLowerCase();
            const filtered = filteredData.filter(item =>
                item.deskripsi.toLowerCase().includes(keyword) ||
                item.email.toLowerCase().includes(keyword) ||
                item.no_handphone.toLowerCase().includes(keyword)
            );

            currentPage = 1;
            displayTable(filtered);
            displayPagination(filtered.length);
        });

        // Delete
        $(document).on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this log entry?')) {
                $.ajax({
                    url: `/api/v1/log/${id}`,
                    type: 'DELETE',
                    success: function (response) {
                        alert('Log entry deleted successfully.');
                        loadData();
                    },
                    error: function (error) {
                        console.error('Error deleting log entry:', error);
                        alert('Failed to delete log entry.');
                    }
                });
            }
        });
    });
</script>

<div id="pagination" class="mt-3 text-center"></div>

<?= $this->endSection() ?>
