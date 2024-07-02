<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CRUD API Data Diri</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-5">CRUD API Data Diri</h1>

    <!-- Form Input -->
    <form id="dataDiriForm">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
            </div>
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option selected disabled>Pilih Jenis Kelamin</option>
                    <option>Laki-laki</option>
                    <option>Perempuan</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="kewarganegaraan">Kewarganegaraan</label>
                <input type="text" class="form-control" id="kewarganegaraan" name="kewarganegaraan" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="agama">Agama</label>
                <input type="text" class="form-control" id="agama" name="agama" required>
            </div>
            <div class="form-group col-md-6">
                <label for="status_perkawinan">Status Perkawinan</label>
                <select class="form-control" id="status_perkawinan" name="status_perkawinan" required>
                    <option selected disabled>Pilih Status Perkawinan</option>
                    <option>Belum Kawin</option>
                    <option>Kawin</option>
                    <option>Cerai Hidup</option>
                    <option>Cerai Mati</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <hr>

    <!-- Data Diri List -->
    <h2 class="mt-5 mb-3">Data Diri List</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Nama Lengkap</th>
                <th scope="col">Email</th>
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">Kewarganegaraan</th>
                <th scope="col">Agama</th>
                <th scope="col">Status Perkawinan</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody id="dataDiriList">
            <!-- Data will be appended here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Diri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editDataDiriForm">
                    <input type="hidden" id="edit_id" name="edit_id">
                    <div class="form-group">
                        <label for="edit_nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" id="edit_nama_lengkap" name="edit_nama_lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="edit_email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control" id="edit_jenis_kelamin" name="edit_jenis_kelamin" required>
                            <option>Laki-laki</option>
                            <option>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_kewarganegaraan">Kewarganegaraan</label>
                        <input type="text" class="form-control" id="edit_kewarganegaraan" name="edit_kewarganegaraan" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_agama">Agama</label>
                        <input type="text" class="form-control" id="edit_agama" name="edit_agama" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_status_perkawinan">Status Perkawinan</label>
                        <select class="form-control" id="edit_status_perkawinan" name="edit_status_perkawinan" required>
                            <option>Belum Kawin</option>
                            <option>Kawin</option>
                            <option>Cerai Hidup</option>
                            <option>Cerai Mati</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to Handle Form Submission, Data Display, Edit Modal, and Delete Confirmation -->
<script>
    $(document).ready(function() {
        // Function to fetch and display data
        function fetchData() {
            $.ajax({
                url: '/api/datadiri',
                method: 'GET',
                success: function(data) {
                    let rows = '';
                    data.forEach(function(item) {
                        rows += `
                            <tr>
                                <td>${item.nama_lengkap}</td>
                                <td>${item.email}</td>
                                <td>${item.jenis_kelamin}</td>
                                <td>${item.kewarganegaraan}</td>
                                <td>${item.agama}</td>
                                <td>${item.status_perkawinan}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary edit-btn" data-id="${item.id}" data-toggle="modal" data-target="#editModal">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="${item.id}">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#dataDiriList').html(rows);
                }
            });
        }

        // Submit form data
        $('#dataDiriForm').on('submit', function(e) {
            e.preventDefault();

            const data = {
                nama_lengkap: $('#nama_lengkap').val(),
                email: $('#email').val(),
                jenis_kelamin: $('#jenis_kelamin').val(),
                kewarganegaraan: $('#kewarganegaraan').val(),
                agama: $('#agama').val(),
                status_perkawinan: $('#status_perkawinan').val()
            };

            $.ajax({
                url: '/api/datadiri',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function() {
                    fetchData(); // Refresh data
                    $('#dataDiriForm')[0].reset(); // Clear form
                }
            });
        });

        // Edit button click (open modal with data)
        $('#dataDiriList').on('click', '.edit-btn', function() {
            const id = $(this).data('id');

            $.ajax({
                url: `/api/datadiri/${id}`,
                method: 'GET',
                success: function(data) {
                    $('#edit_id').val(data.id);
                    $('#edit_nama_lengkap').val(data.nama_lengkap);
                    $('#edit_email').val(data.email);
                    $('#edit_jenis_kelamin').val(data.jenis_kelamin);
                    $('#edit_kewarganegaraan').val(data.kewarganegaraan);
                    $('#edit_agama').val(data.agama);
                    $('#edit_status_perkawinan').val(data.status_perkawinan);
                }
            });
        });

        // Submit edited data
        $('#editDataDiriForm').on('submit', function(e) {
            e.preventDefault();

            const id = $('#edit_id').val();
            const data = {
                nama_lengkap: $('#edit_nama_lengkap').val(),
                email: $('#edit_email').val(),
                jenis_kelamin: $('#edit_jenis_kelamin').val(),
                kewarganegaraan: $('#edit_kewarganegaraan').val(),
                agama: $('#edit_agama').val(),
                status_perkawinan: $('#edit_status_perkawinan').val()
            };

            $.ajax({
                url: `/api/datadiri/${id}`,
                method: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function() {
                    $('#editModal').modal('hide'); // Hide modal
                    fetchData(); // Refresh data
                }
            });
        });

        // Delete button click (confirm and delete)
        $('#dataDiriList').on('click', '.delete-btn', function() {
            if (confirm('Are you sure you want to delete this data?')) {
                const id = $(this).data('id');

                $.ajax({
                    url: `/api/datadiri/${id}`,
                    method: 'DELETE',
                    success: function() {
                        fetchData(); // Refresh data
                    }
                });
            }
        });

        // Initial data fetch
        fetchData();
    });
</script>

</body>
</html>
