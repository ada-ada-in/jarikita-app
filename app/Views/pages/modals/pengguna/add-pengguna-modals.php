<div class="modal fade" id="addpenggunamodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="staticBackdropLabel">Tambah Pengguna</h3>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="basic-form">
                    <form id="form-add-pengguna">
                        <div class="row">
                            <div class="col-12 mt-3">
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="text" class="form-control" name="alamat" placeholder="Alamat" required>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="number" class="form-control" name="no_handphone" placeholder="Nomor Handphone" required>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="file" accept="image/*" class="form-control" name="image" placeholder="Photo" required>
                            </div>
                            <div class="col-12 mt-3">
                                <select name="role" class="form-control" required>
                                    <option value="" selected disabled>Pilih Role</option>
                                    <option value="user">Users</option>
                                    <option value="admin">Admin</option>
                                    <option value="seller">Penawar Jasa</option>
                                </select>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
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