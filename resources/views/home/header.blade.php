<header>
    {{-- ✅ Enhanced Marquee Announcement Bar --}}
    <div style="background: linear-gradient(135deg, #3ca090 0%, #2d8072 100%); color: #fff; padding: 12px 0;">
        <div>
            @if(isset($marqueeMessages) && is_array($marqueeMessages) && count($marqueeMessages) > 0)
                @foreach($marqueeMessages as $msg)
                    <span>
                        {{-- Display Font Awesome icon if available --}}
                        @if(is_array($msg) && isset($msg['icon']) && !empty($msg['icon']))
                            <i class="{{ $msg['icon'] }}" style="font-size: 18px; color: #fff; display: inline-block; min-width: 20px; text-align: center;"></i>
                        @elseif(is_object($msg) && isset($msg->icon) && !empty($msg->icon))
                            <i class="{{ $msg->icon }}" style="font-size: 18px; color: #fff; display: inline-block; min-width: 20px; text-align: center;"></i>
                        @endif
                        {{-- Display message text --}}
                        <span>{{ is_array($msg) ? (isset($msg['text']) ? $msg['text'] : '') : (is_object($msg) ? $msg->message : $msg) }}</span>
                    </span>
                @endforeach
                {{-- Duplicate for seamless scroll --}}
                @foreach($marqueeMessages as $msg)
                    <span>
                        @if(is_array($msg) && isset($msg['icon']) && !empty($msg['icon']))
                            <i class="{{ $msg['icon'] }}" style="font-size: 18px; color: #fff; display: inline-block; min-width: 20px; text-align: center;"></i>
                        @elseif(is_object($msg) && isset($msg->icon) && !empty($msg->icon))
                            <i class="{{ $msg->icon }}" style="font-size: 18px; color: #fff; display: inline-block; min-width: 20px; text-align: center;"></i>
                        @endif
                        <span>{{ is_array($msg) ? (isset($msg['text']) ? $msg['text'] : '') : (is_object($msg) ? $msg->message : $msg) }}</span>
                    </span>
                @endforeach
            @else
                {{-- Fallback with Font Awesome icons --}}
                <span>
                    <i class="fas fa-shipping-fast" style="font-size: 18px; color: #fff; display: inline-block; min-width: 20px; text-align: center;"></i>
                    <span>Free Delivery on orders above ₹499</span>
                </span>
                <span>
                    <i class="fas fa-bolt" style="font-size: 18px; color: #fff; display: inline-block; min-width: 20px; text-align: center;"></i>
                    <span>Flash Sale — Up to 50% OFF on selected items!</span>
                </span>
                <span>
                    <i class="fas fa-gift" style="font-size: 18px; color: #fff; display: inline-block; min-width: 20px; text-align: center;"></i>
                    <span>Use code KALPAK10 for 10% off your first order</span>
                </span>
                <span>
                    <i class="fas fa-shipping-fast" style="font-size: 18px; color: #fff; display: inline-block; min-width: 20px; text-align: center;"></i>
                    <span>Free Delivery on orders above ₹499</span>
                </span>
            @endif
        </div>
    </div>

    <style>
        @keyframes scroll-content {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-100%);
            }
        }
        
        header > div:first-child {
            width: 100%;
            overflow: hidden;
        }
        
        header > div:first-child > div {
            display: flex;
            align-items: center;
            gap: 15px;
            animation: scroll-content 40s linear infinite;
            min-width: 200%;
            padding: 0 20px;
        }

        header > div:first-child > div:hover {
            animation-play-state: paused;
        }

        header > div:first-child > div > span {
            flex-shrink: 0;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            header > div:first-child > div {
                animation-duration: 30s;
            }
        }
    </style>
    <div class="container-fluid card shadow">
        <div class="row border-bottom">

            <div
                class="col-sm-4 col-lg-2 text-center text-sm-start d-flex gap-3 justify-content-center justify-content-md-start">
                <div class="d-flex align-items-center my-3 my-sm-0">
                    <a href="{{ route('home.index') }}">
                        <img src="{{ asset('/assets/images/kalpak-logo.png') }}" alt="logo" class="img-fluid">
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <use xlink:href="#menu"></use>
                    </svg>
                </button>
            </div>

            <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-4">

            </div>

            <div class="col-lg-4">

            </div>

            <div
                class="col-sm-8 col-lg-2 d-flex gap-5 align-items-center justify-content-center justify-content-sm-end">
                <ul class="d-flex justify-content-end list-unstyled m-0">
                    <li>
                        @auth
                            @if (Auth::user()->role == 'client')
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle text-dark text-decoration-none"
                                        data-bs-toggle="dropdown">
                                        <svg width="24" height="24">
                                            <use xlink:href="#user"></use>
                                        </svg>
                                        {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('client.profile') }}">My Profile</a></li>
                                        <li><a class="dropdown-item" href="{{ route('client.orders') }}">My Orders</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form action="{{ route('customer.logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        @else
                            <a href="{{ route('customer.login') }}" class="text-dark text-decoration-none">
                                Login <svg width="24" height="24">
                                    <use xlink:href="#user"></use>
                                </svg>

                            </a>
                        @endauth
                    </li>

                    <!--cart-->
                    <li>
                        <a href="{{ route('cart.view') }}" class="position-relative p-2 mx-1" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                            <svg width="24" height="24">
                                <use xlink:href="#shopping-bag"></use>
                            </svg>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count">
                                {{ $cartCount ?? 0 }}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</header>
