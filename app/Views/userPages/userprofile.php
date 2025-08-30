<!DOCTYPE html>
<html lang="en">
<?= view('userPages/layout/header') ?>
<body style="background-color: #f8f9fa;">

<?= view('userPages/layout/navbar') ?>

<div class="container my-5">
    <form id="profileForm" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="username" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukan nama anda">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukan email anda">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat anda">
                </div>
                <div class="mb-3">
                <div class="row align-items-center">
                    <!-- Foto Profil -->
                    <div class="col-auto">
                    <img id="previewImage" 
                        src="<?= session()->get('avatar_url') ?: 'default.png' ?>" 
                        alt="Profile" 
                        class="rounded-circle border" 
                        width="120" 
                        height="120" 
                        style="object-fit: cover;">
                    </div>

                    <!-- Input Upload -->
                    <div class="col">
                    <label for="image" class="form-label">Ganti Gambar</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="no_handphone" class="form-label">No. Handphone</label>
                    <input type="number" class="form-control" id="no_handphone" name="no_handphone" placeholder="Masukan Nomor Handphone anda">
                </div>
                <div class="mb-3">
                    <label for="nopp" class="form-label">NPP</label>
                    <input type="number" class="form-control" id="nopp" name="nopp" placeholder="Masukan NPP anda">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                </div>
            </div>
        </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<!-- Script -->
    <script>
           $(document).ready(function(){

                // Fetch data user
                $.ajax({
                    url: "/api/v1/users/<?= session()->get('id'); ?>",
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        const user = response.data;
                        console.log(user);
                        $('#username').val(user.username);
                        $('#email').val(user.email);
                        $('#alamat').val(user.alamat);
                        $('#no_handphone').val(user.no_handphone);
                        $('#nopp').val(user.nopp);
                        $('#previewImage').attr('src', '/' + user.avatar_url);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching user data:", error);
                    }
                });

                // Klik gambar -> buka input file
                $('#previewImage').on('click', function() {
                    $('#image').trigger('click');
                });

                // Preview gambar baru kalau user pilih file
                $('#image').on('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#previewImage').attr('src', e.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // Submit form
                $('form').on('submit', function(e){
                    e.preventDefault();
                    const formData = new FormData(this);
                    $.ajax({
                        url: "/api/v1/users/<?= session()->get('id'); ?>",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false, 
                        success: function(response) {
                            alert(response.message);
                            logout();
                        },
                        error: function(xhr, status, error) {
                            console.error("Error updating user data:", error);
                            alert("Error updating profile: " + xhr.responseJSON.message);
                        }
                    });
                });
            });

    </script>
   


<script src="/template/js/jquery-1.11.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="/template/js/plugins.js"></script>
<script src="/template/js/script.js"></script>
</body>
</html>

