<?php

/** @var mysqli $koneksi */

session_name('PELANGGAN_SESSION');
session_start();

?>

<style>

.edit-wrap{
    max-width:720px;
    margin:50px auto;
}

.edit-card{
    background:#fff;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 10px 35px rgba(0,0,0,.08);
}

/* HEADER */
.edit-header{
    background:linear-gradient(135deg,#4b240f,#6b3418);
    padding:40px;
    color:white;
    text-align:center;
}

.edit-avatar{
    width:90px;
    height:90px;
    margin:auto;
    border-radius:50%;
    background:#ffffff20;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:2.3rem;
    margin-bottom:18px;
    border:2px solid #ffffff30;
}

.edit-title{
    font-size:1.8rem;
    font-weight:700;
}

.edit-sub{
    opacity:.85;
    margin-top:8px;
}

/* BODY */
.edit-body{
    padding:40px;
}

.form-label{
    font-weight:600;
    margin-bottom:8px;
    color:#333;
}

.form-control{
    border-radius:14px;
    padding:14px 16px;
    border:1.5px solid #e7e7e7;
    transition:.2s;
    box-shadow:none !important;
}

.form-control:focus{
    border-color:#c5975c;
}

.form-text{
    color:#888;
    font-size:.85rem;
}

/* BUTTON */
.btn-wrap{
    display:flex;
    justify-content:space-between;
    gap:15px;
    margin-top:35px;
    flex-wrap:wrap;
}

.btn-modern{
    flex:1;
    border:none;
    border-radius:16px;
    padding:14px;
    font-weight:700;
    transition:.2s;
    text-decoration:none;
    text-align:center;
}

.btn-save{
    background:#c5975c;
    color:white;
}

.btn-save:hover{
    opacity:.9;
}

.btn-back{
    background:#ece7e1;
    color:#444;
}

.btn-back:hover{
    background:#dfd6cd;
}

/* RESPONSIVE */
@media(max-width:768px){

    .edit-body{
        padding:25px;
    }

    .btn-wrap{
        flex-direction:column;
    }
}

</style>

<?php

$id = $_GET['id'];

$data = mysqli_query(
    $koneksi,
    "SELECT * FROM user
     WHERE user_id='$id'"
);

$d = mysqli_fetch_array($data);

?>

<div class="edit-wrap">

    <div class="edit-card">

        <!-- HEADER -->
        <div class="edit-header">

            <div class="edit-avatar">

                <i class="fas fa-user"></i>

            </div>

            <div class="edit-title">
                Edit Akun Saya
            </div>

            <div class="edit-sub">
                Perbarui informasi akun pelanggan kamu
            </div>

        </div>

        <!-- BODY -->
        <div class="edit-body">

            <form method="POST"
                  action="akun_update.php">

                <!-- ID -->
                <input type="hidden"
                       name="user_id"
                       value="<?= $d['user_id']; ?>">

                <!-- USERNAME -->
                <div class="mb-4">

                    <label class="form-label">
                        Username
                    </label>

                    <input type="text"
                           name="username"
                           class="form-control"
                           value="<?= htmlspecialchars($d['username']); ?>"
                           required>

                </div>

                <!-- PASSWORD -->
                <div class="mb-4">

                    <label class="form-label">
                        Password Baru
                    </label>

                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Kosongkan jika tidak diubah">

                    <div class="form-text mt-2">
                        Password lama akan tetap digunakan jika dikosongkan
                    </div>

                </div>

                <!-- NAMA -->
                <div class="mb-4">

                    <label class="form-label">
                        Nama Lengkap
                    </label>

                    <input type="text"
                           name="nama"
                           class="form-control"
                           value="<?= htmlspecialchars($d['nama']); ?>"
                           required>

                </div>

                <!-- EMAIL -->
                <div class="mb-4">

                    <label class="form-label">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           class="form-control"
                           value="<?= htmlspecialchars($d['email']); ?>"
                           required>

                </div>

                <!-- BUTTON -->
                <div class="btn-wrap">

                    <a href="akun.php"
                       class="btn-modern btn-back">

                        ← Kembali

                    </a>

                    <button type="submit"
                            class="btn-modern btn-save">

                        <i class="fas fa-save me-2"></i>
                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>