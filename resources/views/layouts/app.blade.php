<!doctype html>
<html lang="en">

<head>
    <title>ChartJS</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />


    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }

        footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
        }

        </style>
        @yield('head')
</head>

<body>
    <header>
        @include('layouts.topbar')
    </header>
    <main>
        <div class="container mt-3 mb-3">
            @yield('main')
        </div>

    </main>
    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container text-md-left">
            <div class="row text-md-left">
                <!-- Column 1: Brand -->
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold">YourBrand</h5>
                    <p>We provide solutions to grow your business. Let's make something great together.</p>
                </div>

                <!-- Column 2: Links -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Quick Links</h5>
                    <p><a href="#" class="text-white text-decoration-none">Home</a></p>
                    <p><a href="#" class="text-white text-decoration-none">About</a></p>
                    <p><a href="#" class="text-white text-decoration-none">Services</a></p>
                    <p><a href="#" class="text-white text-decoration-none">Contact</a></p>
                </div>

                <!-- Column 3: Useful -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Resources</h5>
                    <p><a href="#" class="text-white text-decoration-none">FAQ</a></p>
                    <p><a href="#" class="text-white text-decoration-none">Privacy Policy</a></p>
                    <p><a href="#" class="text-white text-decoration-none">Terms of Service</a></p>
                </div>

                <!-- Column 4: Contact -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Contact</h5>
                    <p><i class="fas fa-home me-3"></i> 123 Main Street, KL</p>
                    <p><i class="fas fa-envelope me-3"></i> info@example.com</p>
                    <p><i class="fas fa-phone me-3"></i> +60 12 345 6789</p>
                </div>

            </div>

            <hr class="mb-4">

            <!-- Footer Bottom -->
            <div class="row align-items-center">
                <div class="col-md-7 col-lg-8">
                    <p>© 2025 YourBrand. All Rights Reserved.</p>
                </div>
                <div class="col-md-5 col-lg-4">
                    <div class="text-center text-md-end">
                        <a href="#" class="text-white me-4"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-4"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-4"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @yield('scripts')
</body>

</html>
