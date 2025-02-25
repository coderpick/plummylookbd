<script src="{{ asset('backend/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('backend/js/popper.min.js') }}"></script>
<script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/js/main.js') }}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="{{ asset('backend/js/plugins/pace.min.js') }}"></script>
<!-- Page specific javascripts-->

<!-- Toastr js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@stack('library-js')
@stack('custom-js')
