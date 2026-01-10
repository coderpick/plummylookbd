<!-- Js Plugins -->
<script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/2.2.3/jquery.elevatezoom.min.js"
    integrity="sha512-UH428GPLVbCa8xDVooDWXytY8WASfzVv3kxCvTAFkxD2vPjouf1I3+RJ2QcSckESsb7sI+gv3yhsgw9ZhM7sDw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>
{{-- <script src="https://apps.elfsight.com/p/platform.js" defer></script> --}}
<script src="{{ asset('frontend/js/jquery.slicknav.js') }}"></script>
<!--    <script src="asset('frontend/js/mixitup.min.js')}}"></script>-->
<script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.countdownTimer.min.js') }}"></script>
<script src="{{ asset('frontend/js/main.js?v=1.3.0') }}"></script>
<script src="{{ asset('frontend/js/cart.js') }}"></script>

<script src="{{ asset('frontend/js/bootstrap3-typeahead.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.inputmask.bundle.min.js') }}"></script>

<!-- Toastr js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


@stack('library-js')
@stack('custom-js')
