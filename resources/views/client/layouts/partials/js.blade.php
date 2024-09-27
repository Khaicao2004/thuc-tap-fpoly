 <!-- Js Plugins -->
 <script src="/theme/client/js/jquery-3.3.1.min.js"></script>
 <script src="/theme/client/js/bootstrap.min.js"></script>
 <script src="/theme/client/js/jquery.nice-select.min.js"></script>
 <script src="/theme/client/js/jquery.nicescroll.min.js"></script>
 <script src="/theme/client/js/jquery.magnific-popup.min.js"></script>
 <script src="/theme/client/js/jquery.countdown.min.js"></script>
 <script src="/theme/client/js/jquery.slicknav.js"></script>
 <script src="/theme/client/js/mixitup.min.js"></script>
 <script src="/theme/client/js/owl.carousel.min.js"></script>
 <script src="/theme/client/js/main.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
     @if (session('alert-message'))
         Swal.fire({
             icon: "{{ session('alert-type') }}",
             title: '{{ ucfirst(session('alert-type')) }}',
             text: "{{ session('alert-message') }}",
         });
     @endif
 </script>
