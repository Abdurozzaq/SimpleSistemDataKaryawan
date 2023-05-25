@extends('frontend::layouts.master')

@section('content')
    <div class="container">
        <div class="d-flex bd-highlight mb-4">
            <div class="p-2 w-100 bd-highlight">
                <h5>Kontrak - Sistem Data Karyawan</h5>
            </div>
            <div class="p-2 flex-shrink-0 bd-highlight">
                <button class="btn btn-success" id="btn-add-modal">
                    Tambah Kontrak
                </button>
            </div>
        </div>
        <div>
            <table class="table table-inverse">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kontrak</th>
                        <th>Pegawai</th>
                        <th>Jabatan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tablelist" name="tablelist">
                </tbody>
            </table>

            <!-- ADD MODAL -->
            <div class="modal fade" id="addNewFormModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="addNewFormModalLabel">Create Kontrak</h4>
                        </div>
                        <div class="modal-body">
                            <div id="alert-body-respon"></div>
                            <form id="addnew-form" name="addnew-form" class="form-horizontal" novalidate="">
                                <div class="form-group">
                                    <label>Nama Kontrak</label>
                                    <input type="text" class="form-control" id="nama_kontrak" name="nama_kontrak"
                                            placeholder="Masukan nama kontrak" value="">
                                </div>
                                <div class="form-group">
                                    <label for="id_pegawai">Pilih Pegawai:</label>
                                    <select class="form-control" id="id_pegawai" name="id_pegawai"></select>
                                </div>
                                <div class="form-group">
                                    <label for="id_jabatan">Pilih Jabatan:</label>
                                    <select class="form-control" id="id_jabatan" name="id_jabatan"></select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" id="btn-cancel">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btn-save">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    var deleteAction = null;
    jQuery(document).ready(function($){
        $.ajax('/api/kontrak', {
            success: function (data, status, xhr) {
                data.response.map(function (row) {
                    $('#tablelist').append(
                        `<tr id="datarow-${row.id}">
                            <td id="editid-${row.id}">${row.id}</td>
                            <td id="editidnamakontrak-${row.nama_kontrak}">${row.nama_kontrak}</td>
                            <td id="editidjabatan-${row.id_jabatan}">${row.jabatan}</td>
                            <td id="editidpegawai-${row.id_pegawai}">${row.nama}</td>
                            <td><a href="#" onclick="deleteAction(${row.id})">Delete</a></td>
                        </tr>`
                    );
                });
            }
        });

        $.ajax('/api/pegawai', {
            success: function (data, status, xhr) {
                data.response.map(function (row) {
                    $('#id_pegawai').append(
                        `<option value="${row.id}">${row.nama}</option>`
                    );
                });
            }
        });

        $.ajax('/api/jabatan', {
            success: function (data, status, xhr) {
                data.response.map(function (row) {
                    $('#id_jabatan').append(
                        `<option value="${row.id}">${row.jabatan}</option>`
                    );
                });
            }
        });

        // Open Modal Create
        jQuery('#btn-add-modal').click(function () {
            jQuery('#addnew-form').trigger("reset");
            jQuery('#addNewFormModal').modal('show');
        });

        deleteAction = function (id) {
            var type = "DELETE";
            var ajaxurl = `/api/kontrak/deletebyid/${id}`;
            $.ajax({
                type: type,
                url: ajaxurl,
                dataType: 'json',
                success: function (data) {

                    if (data.status === false) {
                        alert("Gagal Menghapus");
                    } else {
                        alert(data.response);
                        location.reload();
                    }
                    
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

        jQuery('#btn-cancel').click(function () {
            jQuery('#addNewFormModal').modal('hide');
        });

        $("#btn-save").click(function (e) {
            e.preventDefault();
            $("#error-response").remove();
            var formData = {
                nama_kontrak: jQuery('#nama_kontrak').val(),
                id_pegawai: jQuery('#id_pegawai').val(),
                id_jabatan: jQuery('#id_jabatan').val(),
            };
            var type = "POST";
            var ajaxurl = '/api/kontrak/create';
            $.ajax({
                type: type,
                url: ajaxurl,
                data: formData,
                dataType: 'json',
                success: function (data) {

                    if (data.status === false) {
                        $('#alert-body-respon').append(
                            `<div id="error-response" class="alert alert-danger" role="alert">
                                <h5>Error</h5>
                                <ul id="errors-field"></ul>
                            </div>`
                        );

                        Object.keys(data.response).map(function (field) {
                            $('#errors-field').append(
                                `<li>${data.response[field][0]}</li>`
                            );
                        });

                    } else {
                        alert(data.response);
                        jQuery('#addnew-form').trigger("reset");
                        jQuery('#addNewFormModal').modal('hide');
                        location.reload();
                    }
                    
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
    });
    </script>
@endsection
