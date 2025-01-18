<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- BOXICONS -->
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/tableStyle.css') }}" />

    <title>@yield('title', 'ApadaStudio - Admin Page')</title>
  </head>

  <body>
    <!-- SIDEBAR -->
    @include('layouts.sidebar') <!-- Include sidebar partial -->

    <!-- HEADER -->
    @include('layouts.header') <!-- Include header partial -->

    <!-- MAIN CONTENT -->
    <section id="main-content" class="col-md-12">
      <div class="main-content px-5" style="margin: 7rem 0 0 18rem;">
        @yield('content') <!-- Content area to be injected here -->
      </div>
    </section>

  <!-- FOOTER -->
    @include('layouts.footer') 
    
    <!-- Scripts -->
    
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- sweetalert configure js-->
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="{{ asset('js/buttonControl.js') }}"></script>
  </body>
</html>
