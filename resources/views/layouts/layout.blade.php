<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Page title -->
    <title>Inventory @yield('title')</title>

    <!-- Vendor styles -->
    
    {!!Html::style('vendor/fontawesome/css/font-awesome.css')!!}
    
    {!!Html::style('vendor/animate.css/animate.css')!!}
    
    {!!Html::style('vendor/bootstrap/css/bootstrap.css')!!}
    
    {!!Html::style('vendor/toastr/toastr.min.css')!!}

    <!-- App styles -->
    
    {!!Html::style('styles/pe-icons/pe-icon-7-stroke.css')!!}
    {!!Html::style('styles/pe-icons/helper.css')!!}
    {!!Html::style('styles/stroke-icons/style.css')!!}
    {!!Html::style('styles/style.css')!!}
    {!!Html::style('styles/bbn.css')!!}
    {!!Html::style('styles/custom-components.css')!!}

    {!!Html::style('fontello/css/fontello.css')!!}
    
    {!!Html::style('iconfont/material-icons.css')!!}
    
     <!--<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>-->
    <link href="images/bbn-dart.svg" rel="icon">
</head>
<body>

<!-- Wrapper-->
<div class="wrapper bg-default">

    <!-- Header-->
    @include('layouts.header.header')

    <!-- End header-->


    <!-- Navigation-->
    @include('layouts.header.nav')

    <!-- End navigation-->

    <!-- Main content-->
    @yield('content')

    <!-- End main content-->

</div>
<!-- End wrapper-->

<div id="scrpt">
<!-- Vendor scripts -->

{!!Html::script('vendor/pacejs/pace.min.js')!!}

{!!Html::script('vendor/jquery/dist/jquery.min.js')!!}

{!!Html::script('vendor/bootstrap/js/bootstrap.min.js')!!}

{!!Html::script('vendor/toastr/toastr.min.js')!!}

{!!Html::script('vendor/sparkline/index.js')!!}

{!!Html::script('vendor/flot/jquery.flot.min.js')!!}

{!!Html::script('vendor/flot/jquery.flot.resize.min.js')!!}

{!!Html::script('vendor/flot/jquery.flot.spline.js')!!}



{!!Html::script('js/app.js')!!}

<!-- App scripts -->
<!-- <script src="scripts/luna.js"></script>

<script src="res/js/extra.js"></script>

<script src="res/js/extra-account.js"></script> -->

<!--<script src="res/js/messages.js"></script>-->

<!-- <script src="js/app.js"></script> -->

<script>

    $(document).ready(function($) {

        $('#rgb').hide();

      $('#add-product-is-rgb').on('click', function() {
        if ($(this).prop('checked') == true )
        {
            // alert('Clicked');
            $('#rgb').show();
            $('#nrgb').hide();
        }
        else
        {
            $('#rgb').hide();
            $('#nrgb').show();
        }

      });

      $('#add-product-save').on('click', function(e) {
          var content = $('#add-product-content').val();
          var bottle = $('#add-product-bottle').val();
          var qty = $('#add-product-qty').val();


          // var check = $('#is-rgb').prop('checked');
          // alert(check+' save Clicked '+bottle+' hj');

          if ($('#add-product-is-rgb').prop('checked') == false )
        {
            if (qty === '')
            {
                alert('All Fields are required');
                e.preventDefault();
                // return;
            }
        }
        else if ($('#add-product-is-rgb').prop('checked') == true )
        {
            if (content === '' || bottle === '')
            {
                alert('All Fields are required');
                e.preventDefault();
                // return;
            }
        }

      });

      $('#delete-add-item').on('click', function(e) {
        
      });

    })
</script>
</div>
</body>

</html>