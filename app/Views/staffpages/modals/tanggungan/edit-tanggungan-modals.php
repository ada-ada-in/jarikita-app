<div class="modal fade" id="edittanggunganmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="staticBackdropLabel">Ubah Tanggungan BPJS</h3>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="basic-form">
                    <form id="form-edit-tanggungan">
                        <div class="row">
                            <input type="number" id="id" name="id" hidden>
                            <div class="col-12 mt-3">
                                <input type="text" class="form-control" name="username" placeholder="Nama Pelanggan" required>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="number" class="form-control" name="nopp" placeholder="No. PP" required>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="number" class="form-control" name="no_handphone" placeholder="Nomor Handphone" required>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="text" class="form-control" name="alamat" placeholder="Alamat" required>
                            </div>
                            <div class="col-12 mt-3">
                                <select name="bpjs_status_pembayaran" id="" class="form-control">
                                    <option value="" selected disabled>Silahkan pilih status pembayaran BPJS</option>
                                    <option value="itw">ITW</option>
                                    <option value="itb">ITB</option>
                                </select>
                            </div>
                             <div class="col-12 mt-3">
                                <input type="date" class="form-control" name="bpjs_pembayaran" placeholder="Tanggal Pembayaran">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>