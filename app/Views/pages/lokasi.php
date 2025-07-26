<?= $this->extend('layouth/admin_layout') ?>
<?= $this->section('content') ?>

			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
                    <div class="row d-flex justify-content-between ">
                            <div class="col-md-6 col-sm-12">
                                <div class="title">
                                    <h4>Data Arsip</h4>
                                </div>
                                <nav aria-label="breadcrumb" role="navigation">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?= url_to('admin') ?>">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Arsip
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-md-3 col-sm-4 text-right">
                                <div class="form-group">
                                    <label>Datedpicker Range View</label>
                                    <input class="form-control datetimepicker-range" placeholder="Select Month" type="text" />
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
										<th>Nomor Surat</th>
										<th>Jenis Surat</th>
										<th>Pengirim</th>
										<th>Penerima</th>
										<th>Perihal</th>
										<th>Tanggal Surat</th>
										<th>File Surat</th>
										<th>Kategori</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="table-plus">1</td>
										<td>123/ADM/24</td>
										<td>Surat Keputusan</td>
										<td>Dinas Pendidikan</td>
										<td>Kepala Sekolah</td>
										<td>Pemberitahuan Libur Nasional</td>
										<td>2024-01-10</td>
										<td>keputusan123.pdf</td>
										<td>Surat Masuk</td>
										<td>
											<div class="dropdown">
												<a
													class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
													href="#"
													role="button"
													data-toggle="dropdown"
												>
													<i class="dw dw-more"></i>
												</a>
												<div
													class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
												>
													<a class="dropdown-item" href="#"
														><i class="dw dw-eye"></i> View</a
													>
													<a class="dropdown-item" href="#"
														><i class="dw dw-edit2"></i> Edit</a
													>
													<a class="dropdown-item" href="#"
														><i class="dw dw-delete-3"></i> Delete</a
													>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

<?= $this->endSection() ?> 