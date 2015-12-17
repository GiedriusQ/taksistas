@if($errors->any())
    <script type="text/javascript">
        $(function () {
            swal_error('Error!', "{{implode('\n',$errors->all())}}");
        });
    </script>
@endif
@if(session('success'))
    <script type="text/javascript">
        $(function () {
            swal_success('Success!', "{{session('success')}}");
        });
    </script>
@endif