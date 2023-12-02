 {{-- Plugins --}}
  <script src="{{ asset('assets/backsite/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/backsite/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <script>
      $.widget.bridge('uibutton', $.ui.button)
  </script>
  <script src="{{ asset('assets/backsite/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/backsite/plugins/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/backsite/plugins/sparklines/sparkline.js') }}"></script>
  <script src="{{ asset('assets/backsite/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
  <script src="{{ asset('assets/backsite/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
  <script src="{{ asset('assets/backsite/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
  <script src="{{ asset('assets/backsite/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/backsite/plugins/daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ asset('assets/backsite/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <script src="{{ asset('assets/backsite/plugins/summernote/summernote-bs4.min.js') }}"></script>
  <script src="{{ asset('assets/backsite/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

  {{-- datatables --}}
<script src="{{ asset('assets/backsite/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backsite/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backsite/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/backsite/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backsite/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/backsite/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backsite/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/backsite/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/backsite/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/backsite/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/backsite/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/backsite/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('assets/backsite/plugins/select2/js/select2.full.min.js') }}"></script>

 {{-- End Plugins --}}

 {{-- Dist --}}
  <script src="{{ asset('assets/backsite/dist/js/adminlte.js') }}"></script>
  <script src="{{ asset('assets/backsite/dist/js/pages/dashboard.js') }}"></script>
  {{-- End Dist --}}
  {{-- Jquery Mask --}}
  <script src="{{ asset('jquery.mask.js') }}"></script>
  {{-- End Jquery Mask --}}
  
  

@stack('javascript-internal')



