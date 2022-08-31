@extends('layouts.app')

@section('content')
<div class="container">
    @if (Auth::user()->role == 'admin')
    <div class="d-flex justify-content-end p-2">
        <a href="#" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#add_book">Add a book</a>
    </div>
    @endif
    <div class="row">
        @forelse ($books as $book)
        <div class="col-12 col-md-6 col-lg-3 pb-2">
            <div class="d-flex justify-content-center">
                <img src="{{ URL::to('/public/Image/' . $book->cover) }}" width="80%" class="img-fluid" alt="">
            </div>
            <div class="d-flex justify-content-center">
                <div class="bookEdit" style="width: 80%">
                    <div class="d-flex justify-content-between">
                        <div hidden class="id">{{$book->id}}</div>
                        <div hidden class="price_edit">{{$book->price}}</div>
                        <h4 class="fw-bold name_edit">{{$book->name}} </h4>
                        <h4 class="d-block">{{$book->price}}$</h4>
                    </div>
                    <h4 class="text-muted author_edit">{{$book->author}}</h4>
                    <a href="{{route('addtocart', $book->id) }}" class="btn d-block btn-outline-success">Add to cart</a>
                    @if (Auth::user()->role == 'admin')
                    <div class="row mt-2">
                        <div class="col-6">
                            {{-- <a class="btn d-block btn-outline-dark">Edit</a> --}}
                            {{-- <a class="btn d-block btn-outline-dark" data-bs-toggle="modal" data-bs-target="#edit_book">Edit</a> --}}
                            <a type="button" class="btn d-block btn-outline-dark bookUpdate" data-id="'.$book->id.'" data-bs-toggle="modal" data-bs-target="#edit_book">
                                Edit
                            </a>

                        </div>

                        <div class="col-6">
                            <a class="btn d-block btn-outline-danger bookDelete" href="#" data-bs-toggle="modal" data-bs-target="#delete_book">
                                Delete</a>
                        </div>

                    </div>
                    @endif

                </div>
            </div>
        </div>
        @empty
        <div class="">No books to show</div>
        @endforelse

    </div>
    <!-- Edit Book Modal -->
    <div class="modal custom-modal fade" id="edit_book" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{route('editbook')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card" style="border-top-left-radius: 0px; border-top-right-radius: 0px;">
                            <div class="card-body">
                                <h3 class="card-title"> Book Information</h3>
                                <input type="hidden" name="id" id="b_id">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name_edit" name="name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Author <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="author_edit" name="author">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Price <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control" id="price_edit" name="price">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Book Cover <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="cover_edit" name="cover">
                                        </div>
                                    </div>





                                    <div class="submit-section">
                                        <button type="submit" class="btn btn-outline-primary mt-2">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Book Modal -->
    <!-- Add Book -->
    <div id="add_book" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    {{-- Add Book --}}
                    <div class="tab-content pt-0">
                        {{-- Book Info --}}
                        <div class="tab-pane fade show active">
                            <form action="{{ route('addbook') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card" style="border-top-left-radius: 0px; border-top-right-radius: 0px;">
                                    <div class="card-body">
                                        <h3 class="card-title"> Book Information</h3>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                                    <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
                                                    @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Author <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" id="author" name="author" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Price <span class="text-danger">*</span></label>
                                                    <input class="form-control" step="0.01" value="0.00" type="number" id="price" name="price" required>
                                                </div>
                                            </div>


                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Book Cover <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="file" name="cover" id="cover">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start pt-3">
                                                <button class="btn  btn-outline-primary submit-btn ml-2" type="submit"><i class="las la-save"></i>
                                                    Save</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- End Book Info --}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Book Modal -->
    <div class="modal custom-modal fade" id="delete_book" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Book</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{route('deletebook')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="d_id" value="">

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-outline-primary continue-btn submit-btn">Delete</button>

                                <a data-bs-dismiss="modal" class="btn btn-outline-primary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Holiday Modal -->

</div>
@section('script')
{{-- update book --}}
<script>
    $(document).on('click', '.bookUpdate', function() {
        var _this = $(this).parents('.bookEdit');
        $('#b_id').val(_this.find('.id').text());
        $('#name_edit').val(_this.find('.name_edit').text());
        $('#price_edit').val(_this.find('.price_edit').text());
        $('#author_edit').val(_this.find('.author_edit').text());

    });
</script>

{{-- delete book --}}
<script>
    $(document).on('click', '.bookDelete', function() {
        var _this = $(this).parents('.bookEdit');
        $('#d_id').val(_this.find('.id').text());
    });
</script>
@endsection
@endsection
