<?php
include ("proses/connect.php");
$query = mysqli_query($conn, "SELECT * FROM tb_user");
$result = [];
while ($record = mysqli_fetch_array($query)) {
  $result[] = $record;
}
?>

<div class="col-lg-9 mt-2">
  <div class="card">
    <div class="card-header">
      Halaman User
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col d-flex justify-content-end">
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahUser">Tambah User</button>
        </div>
      </div>

      <!-- Modal Tambah User baru -->
      <div class="modal fade" id="ModalTambahUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-md-down">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah User</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form class="needs-validation" novalidate action="proses/proses_input_user.php" method="POST">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-floating mb-3">
                      <input type="text" name="nama" class="form-control" id="inputNama" placeholder="Your Name"
                        required>
                      <label for="inputNama">Nama</label>
                      <div class="invalid-feedback">Masukkan Nama Anda.</div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-floating mb-3">
                      <input type="email" name="username" class="form-control" id="inputUsername"
                        placeholder="name@example.com" required>
                      <label for="inputUsername">Username</label>
                      <div class="invalid-feedback">Masukkan Username Anda.</div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-floating mb-3">
                      <select name="level" class="form-select" aria-label="Default select example" required>
                        <option selected hidden value="">Pilih level user</option>
                        <option value="1">Owner/Admin</option>
                        <option value="2">Kasir</option>
                        <option value="3">Pelayan</option>
                        <option value="4">Dapur</option>
                      </select>
                      <label for="inputLevel">Level User</label>
                      <div class="invalid-feedback">Pilih level User.</div>
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="form-floating mb-3">
                      <input type="number" name="nohp" class="form-control" id="inputNohp" placeholder="08xxxxxx">
                      <label for="inputNohp">No Hp</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-floating mb-3">
                      <input type="password" name="password" class="form-control" id="inputPassword"
                        placeholder="Password" disabled value="12345">
                      <label for="inputPassword">Password</label>
                    </div>
                  </div>
                </div>
                <div class="form-floating">
                  <textarea class="form-control" id="inputAlamat" style="height:100px" name="alamat"></textarea>
                  <label for="inputAlamat">Alamat</label>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="input_user_validate" value="12345">Save
                    changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Akhir Modal Tambah User baru -->

      <?php if (!empty($result)) { ?>
        <div class="table-responsive mt-2">
          <table class="table table-hover" id="example">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Username</th>
                <th scope="col">Level</th>
                <th scope="col">No Hp</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($result as $row) {
                ?>
                <tr>
                  <th scope="row"><?php echo $no++ ?></th>
                  <td><?php echo $row['nama'] ?></td>
                  <td><?php echo $row['username'] ?></td>
                  <td><?php
                  if ($row['level'] == 1) {
                    echo 'Admin';
                  } else if ($row['level'] == 2) {
                    echo 'Kasir';
                  } else if ($row['level'] == 3) {
                    echo 'Pelayan';
                  } else if ($row['level'] == 4) {
                    echo 'Dapur';
                  }
                  ?></td>
                  <td><?php echo $row['nohp'] ?></td>
                  <td class="d-flex">
                    <button class="btn btn-info btn-sm me-1" data-bs-toggle="modal"
                      data-bs-target="#ModalView<?php echo $row['id'] ?>"><i class="bi bi-eye"></i></button>
                    <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal"
                      data-bs-target="#ModalEdit<?php echo $row['id'] ?>"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-danger btn-sm me-1" data-bs-toggle="modal"
                      data-bs-target="#ModalDelete<?php echo $row['id'] ?>"><i class="bi bi-trash"></i></button>
                    <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                      data-bs-target="#ModalResetPassword<?php echo $row['id'] ?>"><i class="bi bi-key"></i></button>
                  </td>
                </tr>

                <!-- Modal View -->
                <div class="modal fade" id="ModalView<?php echo $row['id'] ?>" tabindex="-1"
                  aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Data User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="needs-validation" novalidate>
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-floating mb-3">
                                <input disabled type="text" name="nama" class="form-control" id="viewNama"
                                  placeholder="Your Name" value="<?php echo $row['nama'] ?>">
                                <label for="viewNama">Nama</label>
                                <div class="invalid-feedback">Masukkan Nama Anda.</div>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-floating mb-3">
                                <input disabled type="email" name="username" class="form-control" id="viewUsername"
                                  placeholder="name@example.com" value="<?php echo $row['username'] ?>">
                                <label for="viewUsername">Username</label>
                                <div class="invalid-feedback">Masukkan Username Anda.</div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="form-floating mb-3">
                                <select disabled class="form-select" aria-label="Default select example">
                                  <?php
                                  $data = array("Owner/Admin", "Kasir", "Pelayan", "Dapur");
                                  foreach ($data as $key => $value) {
                                    if ($row['level'] == $key + 1) {
                                      echo "<option selected value='$key'>$value</option>";
                                    } else {
                                      echo "<option value='$key'>$value</option>";
                                    }
                                  }
                                  ?>
                                </select>
                                <label for="viewLevel">Level User</label>
                                <div class="invalid-feedback">Pilih level User.</div>
                              </div>
                            </div>
                            <div class="col-lg-8">
                              <div class="form-floating mb-3">
                                <input disabled type="number" name="nohp" class="form-control" id="viewNohp"
                                  placeholder="08xxxxxx" value="<?php echo $row['nohp'] ?>">
                                <label for="viewNohp">No Hp</label>
                              </div>
                            </div>
                          </div>
                          <div class="form-floating">
                            <textarea disabled class="form-control" id="viewAlamat" style="height:100px"
                              name="alamat"><?php echo $row['alamat'] ?></textarea>
                            <label for="viewAlamat">Alamat</label>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Akhir Modal View -->

                <!-- Modal Edit -->
                <div class="modal fade" id="ModalEdit<?php echo $row['id'] ?>" tabindex="-1"
                  aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="needs-validation" novalidate action="proses/proses_edit_user.php" method="POST">
                          <input type="hidden" value="<?php echo $row['id'] ?>" name="id">
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-floating mb-3">
                                <input type="text" name="nama" class="form-control" id="editNama" placeholder="Your Name"
                                  required value="<?php echo $row['nama'] ?>">
                                <label for="editNama">Nama</label>
                                <div class="invalid-feedback">Masukkan Nama Anda.</div>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-floating mb-3">
                                <input <?php echo ($row['username'] == $_SESSION['username_pastel']) ? 'disabled' : ''; ?>
                                  type="email" name="username" class="form-control" id="editUsername"
                                  placeholder="name@example.com" required value="<?php echo $row['username'] ?>">
                                <label for="editUsername">Username</label>
                                <div class="invalid-feedback">Masukkan Username Anda.</div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="form-floating mb-3">
                                <select class="form-select" aria-label="Default select example" required name="level"
                                  id="editLevel">
                                  <?php
                                  $data = array("Owner/Admin", "Kasir", "Pelayan", "Dapur");
                                  foreach ($data as $key => $value) {
                                    if ($row['level'] == $key + 1) {
                                      echo "<option selected value=" . ($key + 1) . ">$value</option>";
                                    } else {
                                      echo "<option value=" . ($key + 1) . ">$value</option>";
                                    }
                                  }
                                  ?>
                                </select>
                                <label for="editLevel">Level User</label>
                                <div class="invalid-feedback">Pilih level User.</div>
                              </div>
                            </div>
                            <div class="col-lg-8">
                              <div class="form-floating mb-3">
                                <input type="number" name="nohp" class="form-control" id="editNohp" placeholder="08xxxxxx"
                                  value="<?php echo $row['nohp'] ?>">
                                <label for="editNohp">No Hp</label>
                              </div>
                            </div>
                          </div>
                          <div class="form-floating">
                            <textarea class="form-control" id="editAlamat" style="height:100px"
                              name="alamat"><?php echo $row['alamat'] ?></textarea>
                            <label for="editAlamat">Alamat</label>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="input_user_validate" value="12345">Save
                              changes</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Akhir Modal Edit -->

                <!-- Modal Delete -->
                <div class="modal fade" id="ModalDelete<?php echo $row['id'] ?>" tabindex="-1"
                  aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-md modal-fullscreen-md-down">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="needs-validation" novalidate action="proses/proses_delete_user.php" method="POST">
                          <input type="hidden" value="<?php echo $row['id'] ?>" name="id">
                          <div class="col-lg-12">
                            <?php
                            if ($row['username'] == $_SESSION['username_pastel']) {
                              echo "<div class='alert alert-danger'>You Cannot delete yourself.</div>";
                            } else {
                              echo "Apakah anda yakin ingin menghapus user <b>{$row['username']}</b>?";
                            }
                            ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger" name="input_user_validate" value="12345" <?php echo ($row['username'] == $_SESSION['username_pastel']) ? 'disabled' : ''; ?>>Hapus</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Akhir Modal Delete -->

                <!-- Modal Reset password -->
                <div class="modal fade" id="ModalResetPassword<?php echo $row['id'] ?>" tabindex="-1"
                  aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-md modal-fullscreen-md-down">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Reset Password</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="needs-validation" novalidate action="proses/proses_reset_password.php" method="POST">
                          <input type="hidden" value="<?php echo $row['id'] ?>" name="id">
                          <div class="col-lg-12">
                            <?php
                            if ($row['username'] == $_SESSION['username_pastel']) {
                              echo "<div class='alert alert-danger'>Anda tidak dapat mereset password sendiri.</div>";
                            } else {
                              echo "Apakah anda yakin ingin mereset password user <b>$row[username]</b> menjadi password bawaan sistem yaitu <b>password</b>";
                            }
                            ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" name="input_user_validate" value="12345" <?php echo ($row['username'] == $_SESSION['username_pastel']) ? 'disabled' : '' ?>>Reset
                              Password</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Akhir Modal Reset Password -->
              <?php } ?>
            </tbody>
          </table>
        </div>
      <?php } ?>
    </div>
  </div>
</div>