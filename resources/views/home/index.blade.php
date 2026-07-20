@extends('home.app')

@section('content')
    <!-- Hero Section with Image Slider Background -->
    <section class="hero-section-modern">
        <!-- Hero Slider Background -->
        @if(isset($heroSliders) && count($heroSliders) > 0)
            <div id="heroSliderContainer" class="hero-slider-container">
                @foreach($heroSliders as $index => $slider)
                    <div class="hero-slide" data-slide="{{ $index }}" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                        <!-- Background Image -->
                        <div class="hero-slide-background" style="background-image: url('{{ asset($slider->image_path) }}'); background-size: cover; background-position: center; position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
                        
                        
                    </div>
                @endforeach
            </div>

            <!-- Hero Content Overlay -->
            <div class="hero-background">
                <div class="hero-shape hero-shape-1"></div>
                <div class="hero-shape hero-shape-2"></div>
                <div class="hero-shape hero-shape-3"></div>
            </div>
        @else
            <!-- No Hero Sliders - Hide Background Shapes -->
            <div class="hero-background" style="display: none;">
                <div class="hero-shape hero-shape-1"></div>
                <div class="hero-shape hero-shape-2"></div>
                <div class="hero-shape hero-shape-3"></div>
            </div>
        @endif

        <div class="container-lg">
            <div class="row" style="min-height: 60vh;">
               

                <!-- Center Section - Main Content -->
                <div class="col-lg-9 col-md-8">
                    <div class="hero-content-modern" data-aos="fade-up">
                        
                        <div class="hero-buttons-modern">
                            <a href="{{ route('shop') }}" class="btn-primary-modern">
                                Start Shopping
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Section - Video Player -->
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="hero-video-section" data-aos="fade-left" data-aos-delay="200">
                        @if(isset($heroSliders) && count($heroSliders) > 0 && $heroSliders[0]->video_url)
                            <div class="hero-video-player">
                                <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                                    <source src="{{ asset($heroSliders[0]->video_url) }}" type="video/mp4">
                                </video>
                                <div class="video-overlay">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hero Slider CSS & JS: Extracted to assets/css/pages/home.css and assets/js/pages/home.js -->

    <!-- Features Section -->
    <section class="features-section-modern">
        <div class="container-lg">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card-modern">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon-modern feature-icon-1">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                        <h3 class="feature-title-modern">{{ $totalProducts }}+ Products</h3>
                        <p class="feature-description-modern">All your daily needs from edible oil to mobile accessories in
                            one place.</p>
                        <div class="feature-number">01</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card-modern">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon-modern feature-icon-2">
                                <i class="bi bi-shield-check"></i>
                            </div>
                        </div>
                        <!-- {{ $totalCustomers }} use can use later when custor are increase -->
                        <h3 class="feature-title-modern">500+ Customers</h3>
                        <p class="feature-description-modern">Trusted by thousands of happy customers across the region.</p>
                        <div class="feature-number">02</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card-modern">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon-modern feature-icon-3">
                                <i class="bi bi-lightning-charge"></i>
                            </div>
                        </div>
                        <h3 class="feature-title-modern">24/7 Support</h3>
                        <p class="feature-description-modern">Quick and reliable delivery service to your doorstep with
                            care.</p>
                        <div class="feature-number">03</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Section -->
    <section class="category-section-modern">
        <div class="container-lg">
            <div class="section-header-new" data-aos="fade-up">
                <div class="section-subtitle-new">Browse by</div>
                <h2 class="section-title-new">Popular Categories</h2>
                <p class="section-description-new">Discover our wide range of product categories</p>
            </div>

            <div class="category-grid-modern" data-aos="fade-up" data-aos-delay="100">
                @foreach ($categories as $category)
                    <a href="{{ route('shop', ['category' => $category->slug]) }}" class="category-card-modern">
                        <div class="category-image-modern">
                            <img src="{{ !empty($category->cat_image) ? asset('/categoryImage/' . $category->cat_image) : asset('/categoryImage/default_category_img.png') }}"
                                alt="{{ $category->category_name ?? 'Category' }}">
                            <div class="category-overlay-modern"></div>
                        </div>
                        <div class="category-content-modern">
                            <h4 class="category-name-modern">{{ $category->category_name ?? 'Category' }}</h4>
                            <span class="category-link-modern">
                                Explore Now
                                <i class="bi bi-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section-modern" id="products">
        <div class="container-lg">
            <div class="section-header-new" data-aos="fade-up">
                <div class="section-subtitle-new">Shop Now</div>
                <h2 class="section-title-new">Best Selling Products</h2>
                <p class="section-description-new">Top-rated products loved by our customers</p>
            </div>

            <div class="product-grid-modern" data-aos="fade-up" data-aos-delay="100">
                @foreach ($products as $product)
                    @php
                        $discount = $product->selling_price && $product->selling_price > 0 
                            ? round(((float)$product->selling_price - (float)$product->final_price) / (float)$product->selling_price * 100)
                            : 0;
                    @endphp
                    <div class="product-card-modern">
                        <div class="product-image-wrapper-modern">
                            <a href="{{ route('product.details', $product->id) }}">
                                <img src="{{ asset('/' . $product->main_image) }}"
                                    alt="{{ $product->product_name ?? null }}" class="product-image-modern">
                            </a>
                            <div class="product-badge-modern">SALE</div>
                        </div>
                        <div class="product-content-modern">
                            <h3 class="product-title-modern">
                                <a href="{{ route('product.details', $product->id) }}">
                                    {{ $product->product_name ?? null }}
                                </a>
                            </h3>
                            @if($product->unit)
                                <div class="text-muted small mb-2">
                                    <i class="fa-solid fa-box"></i> {{ $product->unit }}
                                </div>
                            @endif
                            <div class="product-price-modern">
                                @if($product->selling_price && $product->selling_price != $product->final_price)
                                    <span class="price-original">&#8377; {{ number_format($product->selling_price, 2) }}</span>
                                @endif
                                <span class="price-current">&#8377; {{ number_format($product->final_price ?? 0, 2) }}</span>
                                @if($discount > 0)
                                    <span class="price-discount">{{ $discount }}% off</span>
                                @endif
                            </div>
                            <div class="product-actions-modern">
                                <div class="quantity-wrapper-modern">
                                    <input type="number" class="quantity-input-modern quantity" value="1"
                                        min="1">
                                </div>
                                <button class="btn-add-cart-modern btn-cart" data-product-id="{{ $product->id }}">
                                    <i class="bi bi-cart-plus"></i>
                                    <span>Add to Cart</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ route('shop') }}" class="btn-view-all-modern">
                    View All Products
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>


    <!-- Benefits Section -->
    <section class="benefits-section-modern">
        <div class="container-lg">
            <div class="benefits-grid-modern">
                <div class="benefit-card-modern" data-aos="fade-up" data-aos-delay="100">
                    <div class="benefit-icon-modern benefit-icon-1">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="benefit-content-modern">
                        <h5 class="benefit-title-modern">Free Delivery</h5>
                        <p class="benefit-text-modern">On orders above ₹500</p>
                    </div>
                </div>
                <div class="benefit-card-modern" data-aos="fade-up" data-aos-delay="200">
                    <div class="benefit-icon-modern benefit-icon-2">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="benefit-content-modern">
                        <h5 class="benefit-title-modern">100% Secure Payment</h5>
                        <p class="benefit-text-modern">Your money is safe with us</p>
                    </div>
                </div>
                <div class="benefit-card-modern" data-aos="fade-up" data-aos-delay="300">
                    <div class="benefit-icon-modern benefit-icon-3">
                        <i class="bi bi-award"></i>
                    </div>
                    <div class="benefit-content-modern">
                        <h5 class="benefit-title-modern">Quality Guarantee</h5>
                        <p class="benefit-text-modern">Premium quality products</p>
                    </div>
                </div>
                <div class="benefit-card-modern" data-aos="fade-up" data-aos-delay="400">
                    <div class="benefit-icon-modern benefit-icon-4">
                        <i class="bi bi-piggy-bank"></i>
                    </div>
                    <div class="benefit-content-modern">
                        <h5 class="benefit-title-modern">Guaranteed Savings</h5>
                        <p class="benefit-text-modern">Best prices guaranteed</p>
                    </div>
                </div>
                <div class="benefit-card-modern" data-aos="fade-up" data-aos-delay="500">
                    <div class="benefit-icon-modern benefit-icon-5">
                        <i class="bi bi-tag"></i>
                    </div>
                    <div class="benefit-content-modern">
                        <h5 class="benefit-title-modern">Daily Offers</h5>
                        <p class="benefit-text-modern">New deals every day</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Large cart/product script: Extracted to assets/js/pages/home.js -->
@endsection
