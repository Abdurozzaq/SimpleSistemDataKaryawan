@extends('frontend::layouts.master')

@section('content')
    <div class="container">
        <div class="d-flex bd-highlight mb-4">
            <div class="p-2 w-100 bd-highlight">
                <h5>Jabatan - Sistem Data Karyawan</h5>
            </div>
            <div class="p-2 flex-shrink-0 bd-highlight">
                <button class="btn btn-success" id="btn-add-modal">
                    Tambah Jabatan
                </button>
            </div>
        </div>
        <div>
            <table class="table table-inverse">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jabatan</th>
                        <th>Deskripsi</th>
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
                            <h4 class="modal-title" id="addNewFormModalLabel">Create Jabatan</h4>
                        </div>
                        <div class="modal-body">
                            <div id="alert-body-respon"></div>
                            <form id="addnew-form" name="addnew-form" class="form-horizontal" novalidate="">
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan"
                                            placeholder="Masukan jabatan" value="">
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                        <input type="text" class="form-control" id="deskripsi" name="deskripsi"
                                            placeholder="Masukan deskripsi" value="">
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

             <!-- UPDATE MODAL -->
             <div class="modal fade" id="updateFormModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="updateFormModalLabel">Update Jabatan</h4>
                        </div>
                        <div class="modal-body">
                            <div id="alert-body-respon-update"></div>
                            <form id="addnew-form" name="addnew-form" class="form-horizontal" novalidate="">
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <input type="text" class="form-control" id="editjabatan" name="editjabatan"
                                            placeholder="Masukan jabatan" value="">
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                        <input type="text" class="form-control" id="editdeskripsi" name="editdeskripsi"
                                            placeholder="Masukan deskripsi" value="">
                                </div>
                                <input type="hidden" id="editid" name="editid" value="">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" id="btn-cancel-update">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btn-save-update">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    var editAction = null;
    var deleteAction = null;
    jQuery(document).ready(function($){

        $.ajax('/api/jabatan', {
            success: function (data, status, xhr) {
                data.response.map(function (row) {
                    $('#tablelist').append(
                        `<tr id="datarow-${row.id}">
                            <td id="editid-${row.id}">${row.id}</td>
                            <td id="editjabatan-${row.id}">${row.jabatan}</td>
                            <td id="editdeskripsi-${row.id}">${row.deskripsi}</td>
                            <td><a href="#" onclick="editAction(${row.id})">Edit</a> | <a href="#" onclick="deleteAction(${row.id})">Delete</a></td>
                        </tr>`
                    );
                });
            }
        });

        // Open Modal Create
        jQuery('#btn-add-modal').click(function () {
            jQuery('#addnew-form').trigger("reset");
            jQuery('#addNewFormModal').modal('show');
        });

        editAction = function (id) {
            jQuery('#update-form').trigger("reset");
            jQuery("#editid").val(jQuery(`#editid-${id}`).text());
            jQuery("#editjabatan").val(jQuery(`#editjabatan-${id}`).text());
            jQuery("#editdeskripsi").val(jQuery(`#editdeskripsi-${id}`).text());
            jQuery('#updateFormModal').modal('show');
        }

        deleteAction = function (id) {
            var type = "DELETE";
            var ajaxurl = `/api/jabatan/deletebyid/${id}`;
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

        jQuery('#btn-cancel-update').click(function () {
            jQuery('#updateFormModal').modal('hide');
        });

        $("#btn-save").click(function (e) {
            e.preventDefault();
            $("#error-response").remove();
            var formData = {
                jabatan: jQuery('#jabatan').val(),
                deskripsi: jQuery('#deskripsi').val(),
            };
            var type = "POST";
            var ajaxurl = '/api/jabatan/create';
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

        $("#btn-save-update").click(function (e) {
            e.preventDefault();
            $("#error-response-update").remove();
            var formData = {
                id: jQuery('#editid').val(),
                jabatan: jQuery('#editjabatan').val(),
                deskripsi: jQuery('#editdeskripsi').val()
            };
            var type = "POST";
            var ajaxurl = '/api/jabatan/updatebyid';
            $.ajax({
                type: type,
                url: ajaxurl,
                data: formData,
                dataType: 'json',
                success: function (data) {

                    if (data.status === false) {
                        $('#alert-body-respon-update').append(
                            `<div id="error-response-update" class="alert alert-danger" role="alert">
                                <h5>Error</h5>
                                <ul id="errors-field-update"></ul>
                            </div>`
                        );

                        Object.keys(data.response).map(function (field) {
                            $('#errors-field-update').append(
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
