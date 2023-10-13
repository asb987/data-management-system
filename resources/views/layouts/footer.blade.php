<footer class="main-footer">
    <strong>Copyright &copy; 2014-2023 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>

<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": [/* "copy", */ "csv"/* , "excel", "pdf", "print", "colvis" */]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    // ajax category delete
    $(document).on('click', "button[name^='delete_category']", function() {
      if (!confirm('If you delete categroy, then product within the cateegory will auto deleted. Confirm you want to delete.')) {
        return false;
      } else {
        var id = $(this).attr('data-id');
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url : "{{ url('deleteCategory') }}",
          data : {'id' : id},
          type : 'POST',
          dataType : 'json',
          success : function(result){
            if (result.status == 'ok') {
              $('.delete_category_'+id).hide();
              $('.restore_'+id).show();
              alert(result.msg);
            } else {
              alert('Something went wrong.')
            }
          }
        });
      }
    });

    // ajax Product delete
    $(document).on('click', "button[name^='delete_product_']", function() {
      if (!confirm('Confirm you want to delete.')) {
        return false;
      } else {
        var id = $(this).attr('data-id');
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url : "{{ url('deleteproduct') }}",
          data : {'id' : id},
          type : 'POST',
          dataType : 'json',
          success : function(result){
            if (result.status == 'ok') {
              $('.delete_product_'+id).hide();
              if ($('[name="refresh"]').length <= 0) {
                $('.restore_product_'+id).show();
              }
              alert(result.msg);
              if ($('[name="refresh"]').length > 0) {
                setTimeout(() => {
                  location.reload();
                }, 500);
              }
            } else {
              alert('Something went wrong.')
            }
          }
        });
      }
    });

    // ajax Product view
    $(document).on('click', "[name^='category_modal_']", function() {
      var id = $(this).attr('data-id');
      var id_category = $(this).attr('data-id_category');
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : "{{ url('getProductdetail') }}",
        data : {'id' : id, 'id_category': id_category},
        type : 'POST',
        dataType : 'json',
        success : function(result) {
          if (result.status == 'ok') {
            $('#modal_name').html(result.data.product_name);
            $('#modal_desc').html(result.data.product_description);
            $('#modal_price').html(result.data.product_price);
            $('#modal_img').attr('src', "{{asset('dist/img')}}/" + result.data.product_image);
            $('#modal_category').html(result.data.category_name);
            $('#modal-lg').modal();
          } else {
            alert('Something went wrong.')
          }
        }
      });
    });


    // ajax Category view
    $(document).on('click', "[name^='category_view_modal_']", function() {
      var id_category = $(this).attr('data-id_category');
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : "{{ url('getCategoryDetail') }}",
        data : {'id_category': id_category},
        type : 'POST',
        dataType : 'json',
        success : function(result) {
          if (result.status == 'ok') {
            $('#modal_categroy_name').html(result.data.category_name);
            $('#modal_category_desc').html(result.data.category_description);
            $('#modal-lg').modal();
          } else {
            alert('Something went wrong.')
          }
        }
      });
    });
  });
</script>
