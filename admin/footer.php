<!-- Main Footer -->
<footer class="main-footer">
  <!-- To the right -->
  <div class="float-right d-none d-sm-inline">
    SPS
  </div>
  <!-- Default to the left -->
  Developed By<strong> <a href="#" target="_blank">HOStDOMERS</a></strong>
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../common/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../common/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../common/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="../common/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../common/plugins/toastr/toastr.min.js"></script>
<!-- BS-stepper -->
<script src="../common/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../common/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../common/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../common/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../common/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../common/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../common/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../common/plugins/jszip/jszip.min.js"></script>
<script src="../common/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../common/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../common/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../common/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../common/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(function() {
    $(".data-table").DataTable({
      "responsive": false,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('.data-table_wrapper .col-md-6:eq(0)');
    // $('#example2').DataTable({
    //   "paging": true,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false,
    //   "responsive": true,
    // });
  });
</script>

</body>

</html>