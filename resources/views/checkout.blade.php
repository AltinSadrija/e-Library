@extends('layouts.app')

@section('content')
<div class="container">
    <table id="cart" class="table table-hover table-condensed">
        <thead>
            <tr>
                <th style="width:15%">Book</th>
                <th style="width:35%">Name</th>
                <th style="width:10%">Price</th>
                <th style="width:8%">Quantity</th>
                <th style="width:22%" class="text-center">Subtotal</th>
                <th style="width:10%"></th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0 @endphp
            @if(session('cart'))
            @foreach(session('cart') as $id => $details)
            @php $total += $details['price'] * $details['quantity'] @endphp
            <tr data-id="{{ $id }}">
                <td data-th="Book">
                    <div class="row">
                        <div class="col-sm-3 hidden-xs"><img src="{{URL::to('/public/Image/'. $details['image']) }}" width="100" height="100" class="img-responsive" /></div>

                    </div>
                </td>
                <td data-th="Name">
                    <div class="col-sm-9">
                        <h4 class="nomargin">{{ $details['name'] }}</h4>
                    </div>
                </td>
                <td data-th="Price">${{ $details['price'] }}</td>
                <td data-th="Quantity">
                    {{ $details['quantity'] }}
                </td>
                <td data-th="Subtotal" class="text-center">${{ $details['price'] * $details['quantity'] }}</td>
                <td class="actions" data-th="">
                    <button class="btn btn-danger btn-sm remove-from-cart">Remove</button>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right">
                    <h3><strong>Total ${{ $total }}</strong></h3>
                </td>
            </tr>
            <tr>
                <td colspan="5" class="text-right">
                    <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                    @if(count((array) session('cart'))<=3) <form action="{{route('checkout')}}" method="post">
                        @csrf
                        @foreach(session('cart') as $id => $details)
                        <input type="text" hidden name="books_id[]" value="{{$details['book_id']}}">
                        <input type="text" hidden name="client_id" value="{{ Auth::user()->id}}">
                        @endforeach
                        <button class="btn btn-success mt-2">Checkout</button>
                        </form>


                        @else
                        <button disabled class="btn btn-secondary muted">Checkout</button>
                        <h6>You have added more than 3 books!</h6>
                        @endif
                </td>
            </tr>
        </tfoot>
    </table>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $(".update-cart").change(function (e) {
        e.preventDefault();

        var ele = $(this);

        $.ajax({
            url: '{{ route('updatecart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}',
                id: ele.parents("tr").attr("data-id"),
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();

        var ele = $(this);

        if(confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route('removefromcart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });

</script>
@endsection
