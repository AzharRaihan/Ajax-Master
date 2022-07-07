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
                <th>Discount</th>
                <th>Total Price</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="t-a-body">
              <tr class="tr-item el-1" element="1">
                <td><input type="number" class="form-control qtyItem qty-1" name="qty[]" val="" placeholder="0.00"></td>
                <td><input type="number" class="form-control uPItem unitPrice-1" name="unitPrice[]" val="" placeholder="0.00"></td>
                <td><input type="number" class="form-control disItem discount-1" name="discount[]" val="" placeholder="0.00"></td>
                <td><input type="number" class="form-control tAmount totalPrice-1" name="totalPrice[]" val="" placeholder="0.00" readonly></td>
                <td><button del="1" type="button" class="r-element btn btn-danger">-</button></td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td class="qty-r">0.00</td>
                <td class="u-price-r">0.00</td>
                <td class="discount-r">0.00</td>
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
    let k = 1;
    // Add New Item
    $('#add-item').click(function (e) { 
      k++
      e.preventDefault();
      // Append New Item
      $('#t-a-body').append('<tr class="tr-item el-'+k+'" element="'+k+'">\
        <td><input type="number" class="form-control qtyItem qty-'+k+'" name="qty[]" val="" placeholder="0.00"></td>\
        <td><input type="number" class="form-control uPItem unitPrice-'+k+'" name="unitPrice[]" val="" placeholder="0.00"></td>\
        <td><input type="number" class="form-control disItem discount-'+k+'" name="discount[]" val="" placeholder="0.00"></td>\
        <td><input type="number" class="form-control tAmount totalPrice-'+k+'" name="totalPrice[]" val="" placeholder="0.00" readonly></td>\
        <td><button del="'+k+'" type="button" class="r-element btn btn-danger">-</button></td>\
      </tr>');
      // On Ky Up Trigger, call calculation function
      $('.tr-item').keyup(function (e) { 
        var i = $(this).attr("element");
        calculation(i);
      });
    });

    // Removed Item
    $(document).on('click', '.r-element', function() {
      var totaltr = $('#t-a-body tr').length;
      if(totaltr == 1){
        alert("This Row Can't Delete");
      }else{
        let id = $(this).attr("del");
        $('.el-'+id).remove();
        // Calculation function call for reset calculation
        calculation();
      }
    });

    // Calculation Function
    function calculation(i=null){
      var qty = $('.qty-'+i).val();
      var unitPrice = $('.unitPrice-'+i).val();
      var discount = $('.discount-'+i).val();
      var price = qty * unitPrice
      var discountAmount = (price * discount / 100);
      var total = price - discountAmount;
      $('.totalPrice-'+i).val(total);


      // Indivudually qty, unitprice,discount,amount  Count
      var totalQty = 0;
      var totalUnitPrice = 0;
      var totalDiscount = 0;
      var totalAmount = 0;
      // Quantity Count
      $('.qtyItem').each(function (ind, val) { 
        var qtyItem = parseFloat($(this).val() - 0);
        totalQty += qtyItem;
        $('.qty-r').text(totalQty);
      });
      // Unit Price Count
      $('.uPItem').each(function (ind, val) { 
        var uPItem = parseFloat($(this).val() - 0);
        totalUnitPrice += uPItem;
        $('.u-price-r').text(totalUnitPrice);
      });
      // Discount Count
      $('.disItem').each(function (ind, val) { 
        var disItem = parseFloat($(this).val() - 0);
        totalDiscount += disItem;
        $('.discount-r').text(totalDiscount);
      });
      // Total Amount Count
      $('.tAmount').each(function (ind, val) { 
        var tAmount = parseFloat($(this).val() - 0);
        totalAmount += tAmount;
        $('.t-price-r').text(totalAmount);
      });
    }


    // On Ky Up Trigger, call calculation function
    $('.tr-item').keyup(function (e) { 
      var i = $(this).attr("element");
      calculation(i);
    });
  
  });
</script>
@endpush