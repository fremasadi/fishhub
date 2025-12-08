<footer class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-fish"></i> Benih Ikan
                </h5>
                <p class="text-white-50">
                    Platform pemesanan benih ikan berkualitas langsung dari peternak terpercaya.
                </p>
                <div class="mt-3">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-whatsapp fa-lg"></i></a>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Menu Cepat</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ url('/') }}" class="text-white-50 text-decoration-none">
                            <i class="fas fa-angle-right"></i> Beranda
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/#stok-benih') }}" class="text-white-50 text-decoration-none">
                            <i class="fas fa-angle-right"></i> Stok Benih
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/#peta-peternak') }}" class="text-white-50 text-decoration-none">
                            <i class="fas fa-angle-right"></i> Peta Peternak
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('login') }}" class="text-white-50 text-decoration-none">
                            <i class="fas fa-angle-right"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Hubungi Kami</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-2">
                        <i class="fas fa-map-marker-alt"></i> 
                        Jawa Timur, Indonesia
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-phone"></i> 
                        +62 812-3456-7890
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-envelope"></i> 
                        info@benihikan.com
                    </li>
                </ul>
            </div>
        </div>
        
        <hr class="bg-white my-4">
        
        <div class="row">
            <div class="col-md-12 text-center">
                <p class="mb-0 text-white-50">
                    &copy; {{ date('Y') }} Benih Ikan. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer>