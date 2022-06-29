@extends('layouts.app')
@section('title')
@endsection
@push('style')
<style>
  
</style>
@endpush

@section('page')
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h3 class="pb-5 text-center">Dropdown</h3>
        <a href="{{ url('state-create') }}" class="btn btn-warning mb-2">Back</a>
        <div class="mb-3">
          <select class="form-select" id="country">
          </select>
        </div>
        <div class="mb-3">
          <select class="form-select" id="state">
            <option>Select State</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection


@push('script')
<script>
  $(document).ready(function () {
    getCountry();
    function getCountry(){
      $.ajax({
        type: "GET",
        url: "d-country",
        dataType: "json",
        success: function (response) {
          $('#country').html('');
          $('#country').append('<option>Select Country</option>');
          $.each(response.country, function (key, val) {
            $('#country').append('<option value="'+val.id+'">'+val.country_name+'</option>');
          });
        }
      });
    }

    $('#country').on('change',function (e) { 
      var countryId = $(this).val();
      $.ajax({
        type: "GET",
        url: "d-state/"+countryId,
        dataType: "json",
        success: function (response) {
          if(response.status == 404){
            $('#state').html('');
            $('#state').append('<option>State Not Available</option>');
          }else{
            $('#state').html('');
            $('#state').append('<option>Select State</option>');
            $.each(response.state, function (key, val) {
              $('#state').append('<option value="'+val.id+'">'+val.state_name+'</option>');
            });
          }
        }
      });
    });
    
  });
</script>
@endpush