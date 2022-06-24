@extends('layouts.app')
@section('title')
@endsection
@push('style')
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
        <div class="col-md-8">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addModal">
            Add New
          </button>
          <div id="message"></div>
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th scope="col">#Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>


  <!-- Add Modal -->
  <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Add Modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul id="e-message" class="px-2"></ul>
          <form action="">
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" placeholder="Enter Your Name">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control" id="email" placeholder="email@example.com">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="submit">Submit</button>
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
          <form action="">
            <input type="hidden" id="up-h-id">
            <div class="mb-3">
              <label for="editname" class="form-label">Name</label>
              <input type="text" class="form-control" id="editname" placeholder="Enter Your Name">
            </div>
            <div class="mb-3">
              <label for="editemail" class="form-label">Email address</label>
              <input type="email" class="form-control" id="editemail" placeholder="email@example.com">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="update">Update</button>
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="delete-data">Delete</button>
        </div>
      </div>
    </div>
  </div>


@endsection


@push('script')
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
            $('tbody').append('<tr>\
                <th>'+item.id+'</th>\
                <td>'+item.name+'</td>\
                <td>'+item.email+'</td>\
                <td><button class="btn btn-info me-1" value="'+item.id+'" id="edit-data">Edit</button><button class="btn btn-danger" value="'+item.id+'" id="delete">Delete</button></td>\
              </tr>'
            );
          });
        }
      });
    }
    // Add Data
    $(document).on('click', '#submit', function (e) {
      e.preventDefault();
      var data = {
        "name": $('#name').val(),
        "email": $('#email').val(),
      }
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type: "POST",
        url: "/crude-store/",
        data: data,
        dataType: "json",
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
            $('#editname').val(response.editId.name);
            $('#editemail').val(response.editId.email);
            $('#up-h-id').val(response.editId.id);
          }
        }
      });
    });
    // Update Data
    $(document).on('click', '#update', function (e) {
      e.preventDefault();
      var upId = $('#up-h-id').val();
      var data = {
        "name": $('#editname').val(),
        "email": $('#editemail').val(),
      }
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type: "PUT",
        url: "/crude-update/" + upId,
        data: data,
        dataType: "json",
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
</script>
@endpush