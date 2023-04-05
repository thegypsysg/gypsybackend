<footer class="main-footer">
    <div class="pull-right hidden-xs">
    <strong> <a href="">The Syringe</a>.</strong> All rights
    reserved.
      
    </div>
    <strong>Copyright &copy; 2014-{{date('Y')}}</strong>
  </footer>

  
  
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('backend/js/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->

<!-- <script src="{{ asset('backend/js/jquery-ui.min.js') }}"></script> -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- <script>
  $.widget.bridge('uibutton', $.ui.button);
</script> -->

<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('backend/js/jquery.min.js') }}"></script>

<script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>

<!-- <script src="{{ asset('backend/js/jquery.dataTables.min.js') }}"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-html5-1.6.1/b-print-1.6.1/fh-3.1.6/r-2.2.3/datatables.min.js"></script>

<script src="{{ asset('backend/js/dataTables.bootstrap.min.js') }}"></script>

<script src="{{ asset('backend/js/select2.min.js') }}"></script>

<script src="{{ asset('backend/js/toastr.min.js') }}"></script>

<script src="{{ asset('backend/js/jquery-confirm.js') }}"></script>

<script src="{{ asset('backend/js/adminlte.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('.select2').select2();

    $('.confirm').on('click', function(e){
      e.preventDefault();
      let action = $(this).parent('form').attr('id');
      $.confirm({
            title: 'A secure action',
            content: 'Are You sure to delete this item?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function(){
                        $('#'+action).submit();
                    }
                },
                cancel: function(){
                    return
                }
            }
        });
    });


    $('.btn-toggle').click(function() {
      // $(this).find('.btn').toggleClass('active');  
      
      if ($(this).find('.btn-primary').length>0) {
        $(this).find('.btn').toggleClass('btn-primary');
      }  
    });

  });
</script>

@yield('js')
</body>
</html>