@extends('layouts.app')
@section('title')
@endsection
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"/>
<style>
  ul li{
    list-style-type: none;
  }
</style>
@endpush

@section('page')
  <section class="py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div id="message"></div>
          <div class="card">
            <div class="card-header">
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fas fa-plus-circle"></i> Add New Item
              </button>
            </div>
            <div class="card-body">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>



  <!-- Add Modal -->
  <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Add New Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul id="e-message" class="px-2"></ul>
          <form enctype="multipart/form-data" id="formData">
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com">
            </div>
            <div class="mb-3">
              <label for="photo" class="form-label">Photo</label>
              <input type="file" class="form-control dropify" id="photo" name="photo">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
          <button type="button" class="btn btn-success btn-sm" id="submit"><i class="fas fa-save"></i> Save</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul id="up-e-message"></ul>
          <form enctype="multipart/form-data" id="upFormData">
            <input type="hidden" id="up-h-id">
            <div class="mb-3">
              <label for="editname" class="form-label">Name</label>
              <input type="text" class="form-control" id="editname" name="name" placeholder="Enter Your Name">
            </div>
            <div class="mb-3">
              <label for="editemail" class="form-label">Email address</label>
              <input type="email" class="form-control" id="editemail" placeholder="email@example.com" name="email">
            </div>
            <div class="mb-3">
              <label for="editphoto" class="form-label">Photo</label>
              <input type="file" class="form-control dropify" id="editphoto" data-default-file="" name="photo">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
          <button type="button" class="btn btn-success btn-sm" id="update"><i class="fas fa-arrow-circle-up"></i> Update</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Delete Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h4>Are you sure?</h4>
          <h5>You want to delete this!</h5>
          <input type="hidden" id="deletingId">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
          <button type="button" class="btn btn-success btn-sm" id="delete-data"><i class="fas fa-trash"></i> Delete</button>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script>
  $(document).ready(function () {
    // Call Funcion For New Inserted Data
    fatchData();
    // Fatch Data Function
    function fatchData(){
      $.ajax({
        type: "GET",
        url: "/crude-index",
        dataType: "json",
        success: function (response) {
          $('tbody').html("");
          $.each(response.allData, function (key, item) { 
            $('tbody').append(`<tr>
                <th>${item.id}item.id</th>
                <td>${item.name}</td>
                <td>${item.email}</td>
                <td><img src="uploads/photo/${item.photo}" height="100" width="100"></td>
                <td><button class="btn btn-warning btn-sm me-1" value="${item.id}" id="edit-data"><i class="fas fa-edit"></i> Edit</button><button class="btn btn-danger btn-sm" value="${item.id}" id="delete"><i class="fas fa-trash"></i> Delete</button></td>
              </tr>`
            );
          });
        }
      });
    }
    // Add Data
    $(document).on('click', '#submit', function (e) {
      e.preventDefault();
      let formData = new FormData($('#formData')[0]);
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type: "POST",
        url: "/crude-store/",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          if(response.status==400){
            $('#e-message').html('');
            $('#e-message').addClass('alert alert-danger');
            $.each(response.errors, function (key, val) { 
              $('#e-message').append('<li>' + val + '</li>');
            });
          }else{
            $('#message').addClass('alert alert-success');
            $('#message').text(response.message);
            $('#addModal').find('input').val('');
            $(".dropify-clear").trigger("click");
            $('#addModal').modal('hide');
            $('#e-message').html('');
            $('#e-message').removeClass('alert alert-success');
            fatchData();
          }
        }
      });
    });
    // Edit Data
    $(document).on('click','#edit-data', function (e) {
      e.preventDefault();
      var editId = $(this).val();
      $('#editModal').modal('show');
      $.ajax({
        type: "GET",
        url: "/crude-edit/" + editId,
        success: function (response) {
          if(status == 404){
            $('#e-message').html('');
            $('#e-message').addClass('alert alert-danger');
            $('#e-message').text(response.message);
            $('#editModal').modal('hide');
          }else{
            var imgPath = "http://127.0.0.1:8000/uploads/photo/"+response.editId.photo;
            $('#editname').val(response.editId.name);
            $('#editemail').val(response.editId.email);
            $('#editphoto').attr('data-default-file', imgPath);
            $('#up-h-id').val(response.editId.id);
          }
        }
      });
    });
    // Update Data
    $(document).on('click', '#update', function (e) {
      e.preventDefault();
      var upId = $('#up-h-id').val();
      var formData = new FormData($('#upFormData')[0]);
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type: "POST",
        url: "/crude-update/" + upId,
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          if(response.status==400){
            $('#up-e-message').html('');
            $('#up-e-message').addClass('alert alert-danger');
            $.each(response.errors, function (key, val) { 
              $('#up-e-message').append('<li>' + val + '</li>');
            });
          }else{
            $('#message').html('');
            $('#message').addClass('alert alert-success');
            $('#message').text(response.message);
            $('#up-e-message').html('');
            $('#up-e-message').removeClass('alert alert-danger');
            $('#editModal').find('input').val('');
            $('#editModal').modal('hide');
            fatchData();
          }
        }
      });
    });

    // Delete Data
    $(document).on('click', '#delete',  function () { 
      var delId = $(this).val();
      $('#deleteModal').modal('show');
      $('#deletingId').val(delId);
    });

    $("#delete-data").click(function (e) { 
      e.preventDefault();
      var id = $("#deletingId").val();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type: "DELETE",
        url: "/crude-delete/" + id,
        dataType: "json",
        success: function (response) {
          if(status==404){
            $('#message').addClass('alert alert-success');
            $('#message').text(response.message);
            $('#deleteModal').modal('hide');

          }else{
            $('#message').html('');
            $('#message').addClass('alert alert-success');
            $('#message').text(response.message);
            $('#deleteModal').modal('hide');
            fatchData();
          }
        }
      });
    });
  });

  // Call Dropify
  $(document).ready(function() {
    $('.dropify').dropify({
      messages: {
        'default': 'Clic For File',
        'replace': 'Drag and drop or click to replace',
        'remove': 'Remove',
        'error': 'Ooops, something wrong appended.'
      },
      error: {
        'fileSize': 'The file size is too big (1M max).'
      }
    });
  });
</script>
@endpush