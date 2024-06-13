@extends('layouts.frontend')
@section('title', $product->name)
@section('content')
    <div class="product-details ptb-100 pb-90">
        @if(session()->has('message'))
            <div class="alert alert-{{ session()->get('alert-type') }} alert-dismissible fade show" role="alert" id="alert-message">
                {{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="product-details-img-content">
                        <div class="product-details-tab mr-70">
                            @if($product->media_count)
                                <div class="product-details-small nav mt-12" role=tablist>
                                    @foreach ($product->media as $media)
                                        <a class="{{ $loop->index == 0 ? 'active' : '' }} mr-12"
                                           href="#pro-details{{ $loop->index }}" data-toggle="tab" role="tab"
                                           aria-selected="true">
                                            <img src="{{ asset('storage/images/products/' . $media->file_name ) }}"
                                                 alt="{{ $product->name }}" class="img-fluid">
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <img src="{{ asset('img/no-img.png' ) }}" alt="{{ $product->name }}" class="img-fluid">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product-details-content">
                        <h3>{{ $product->name }}</h3>
                        
                        <div class="details-price">
                            <span>Rp.{{ number_format($product->price) }}</span>
                        </div>
                        <p>{!! $product->description !!}</p>
                            <form action="{{ route('cart.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="quickview-plus-minus">
                                    <div class="cart-plus-minus">
                                        <input type="number" name="qty" min="1" value="1" class="form-control cart-plus-minus-box" placeholder="qty">
                                    </div>
                                    <div class="quickview-btn-cart">
                                        <button type="submit" class="submit contact-btn btn-hover">add to cart</button>
                                    </div>
                                    <div class="product-list-wishlist">
                                        <a class="btn-hover list-btn-wishlist add-to-fav" title="Favorite"  product-slug="{{ $product->slug }}">
                                            <i class="pe-7s-like"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        <div class="product-details-cati-tag mt-35">
                            <ul>
                                <li class="categories-title">Categories :</li>
                                <li><a class="badge badge-warning text-white" href="{{ route('shop.index', $product->category->slug) }}">{{ $product->category->name }}</a></li>
                            </ul>
                        </div>
                        <div class="product-details-cati-tag mtb-10">
                            <ul>
                                <li class="categories-title">Tags :</li>
                                <li>
                                    @if($product->tags->count() > 0)
                                        @foreach($product->tags as $tag)
                                        <a href="{{ route('shop.tag', $tag->slug) }}">
                                            <span class="badge badge-info">{{ $tag->name }}</span>
                                        </a>
                                        @endforeach
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
@endsection
