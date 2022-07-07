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

          <table class="table table-striped">
            <thead>
              <tr>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="t-a-body">
              <tr class="el-1">
                <td><input type="number" class="form-control qty" name="qty[]" val="" placeholder="0.00"></td>
                <td><input type="number" class="form-control unitPrice" name="unitPrice[]" val="" placeholder="0.00"></td>
                <td><input type="number" class="form-control totalPrice" name="totalPrice[]" val="" placeholder="0.00" readonly></td>
                <td><button del="1" type="button" class="r-element btn btn-danger">-</button></td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td class="qty-r">0.00</td>
                <td class="u-price-r">0.00</td>
                <td class="t-price-r">0.00</td>
                <td><button id="add-item" type="button" class="btn btn-success">+</button></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </section>
  

@endsection


@push('script')
<script>
  $(document).ready(function () {
    let k = 2;
    $('#add-item').click(function (e) { 
      k++
      e.preventDefault();
      $('#t-a-body').append('<tr class="el-'+ k +'">\
          <td><input type="number" class="form-control qty" name="qty[]" val="" placeholder="0.00"></td>\
          <td><input type="number" class="form-control unitPrice" name="unitPrice[]" val="" placeholder="0.00"></td>\
          <td><input type="number" class="form-control totalPrice" name="totalPrice[]" val="" placeholder="0.00" readonly></td>\
          <td><button del="'+ k +'" type="button" class="r-element btn btn-danger">-</button></td>\
        </tr>');
        $('.qty').keyup(function (e) { 
          calculation();
        });
        $('.unitPrice').keyup(function (e) { 
          calculation();
        });
    });
    $(document).on('click', '.r-element', function() {
      var totaltr = $('#t-a-body tr').length;
      if(totaltr == 1){
        alert("This Row Can't Delete");
      }else{
        let id = $(this).attr("del");
        $('.el-'+id).remove();
        calculation();
      }
    });

    function calculation(){
      var totalUnitPrice = 0;
      var totalQty = 0;
      $('.qty').each(function (ind, val) { 
        var qty = parseFloat($(this).val() - 0);
        totalQty += qty;
        $('.qty-r').text(totalQty);
      });
      $('.unitPrice').each(function (ind, val) { 
        var getUnitPrice = parseFloat($(this).val() - 0);
        totalUnitPrice += getUnitPrice;
        $('.u-price-r').text(totalUnitPrice);
      });
      var total = totalUnitPrice * totalQty;
      $('.totalPrice').val(total);
    }
    $('.qty').keyup(function (e) { 
      calculation();
    });
    $('.unitPrice').keyup(function (e) { 
      calculation();
    });

    
    
  });
</script>
@endpush