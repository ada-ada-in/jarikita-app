<div class="modal fade" id="addjasamodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="staticBackdropLabel">Tambah Layanan Jasa</h3>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="basic-form">
                    <form id="form-add-jasa">
                        <div class="row">
                            <input type="text" id="user_id" name="user_id" hidden>
                            <div class="col-12 mt-3">
                                <select id="lokasi" name="lokasi_id" class="form-control select2" required>
                                    <!-- data user -->
                                </select>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="text" class="form-control" name="nama_jasa" placeholder="Nama Layanan Jasa" required>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="text" class="form-control" name="bidang_jasa" placeholder="Jasa anda bergerak di bidang apa" required>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="text" class="form-control" name="alamat" placeholder="Alamat" required>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="number" class="form-control" name="discount" placeholder="isi kan discount berapa % jika ada, kosongkan jika tidak ada">
                            </div>
                            <div class="col-12 mt-3">
                                <input type="file" accept="image/*" class="form-control" name="image" placeholder="Photo" required>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
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

<script>
$(document).ready(function() {

    $('#user_id').val('<?= session()->get('id') ?>');

    $.ajax({
        url: "/api/v1/lokasi",
        method: "GET",  
        dataType: "json",
        success: function(response) {
            const $select = $('select[name="lokasi_id"]');
            $select.empty().append('<option value="" disabled selected>Pilih Lokasi Penempatan</option>');
            $.each(response.data, function(key, value) {
                $select.append('<option value="' + value.id + '">' + value.lokasi + '</option>');
            });
            $select.select2({
                dropdownParent: $('#addjasamodal')
            });
            $select.next('.select2-container').attr('style', 'width: 100%; font-size: 14px; border-radius: 8px;');
        }
    });
});
       
</script>