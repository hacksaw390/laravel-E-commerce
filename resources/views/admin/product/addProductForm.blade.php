
@extends('admin.master')

@section('content')
<style>
.form-error {

border: 2px solid #e74c3c;
}
</style>
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left">Form Layouts</h4>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->


        <div class="row">
            <div class="col-md-8 m-auto">

                <div class="card-box">

                        @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <h4 class="m-t-0 m-b-30 header-title">Add Product</h4>

                <form action="{{ url('insert-product') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                        <input type="text" value="{{ old('product_name') }}" name="product_name" class="form-control" id="product_name" placeholder="Product Name">
                        </div>
                        <div class="form-group">
                            {{-- <label for="slug">Slug</label> --}}
                        <input type="text" value="{{ old('product_name') }}" name="slug" class="form-control" id="slug" placeholder="Product Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Category Name</label>
                            <select name="category_id" id="exampleInputEmail1" class="form-control">
                                <option value="">Select One</option>
                                @foreach ($allCategory as $item)
                                @if (old('category_id')==$item->id )
                            <option value="{{ $item->id }}" selected>{{ $item->category_name }}</option>
                                @else
                                <option value="{{ $item->id }}">{{ $item->category_name }}</option>

                                @endif

                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="subdiv">
                            <label for="subcategory_id">Sub-Category Name</label>
                            <select name="subcategory_id" id="category_id" class="form-control">
                                <option value="">Select One</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Summary</label>
                            <textarea name="product_summary"  class="form-control" id="" cols="30" rows="10" placeholder="Product Summary">{{ old('product_summary') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">product Description</label>
                            <textarea name="product_description" class="form-control product_description" id="product_description" cols="30" rows="10" placeholder="product Description">{{ old('product_description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Price</label>
                            <input type="text" name="product_price" value="{{ old('product_price') }}" class="form-control" id="exampleInputEmail1" placeholder="Product Price">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Quantity</label>
                        <input type="text" name="product_quantity" value="{{ old('product_quantity') }}" class="form-control" id="exampleInputEmail1" placeholder="Product Quantity">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alart Quantity</label>
                            <input type="text" value="{{ old('alart_quantity') }}" name="alart_quantity" class="form-control{{($errors->first('alart_quantity') ? " form-error" : "")}}" id="exampleInputEmail1" placeholder="Alart Quantity">
                            <ul><span style="color:red;">{!! $errors->first('alart_quantity') !!}</span></ul>
                            {{-- @error('alart_quantity')
                                <span class="invalid-feedback text-danger">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror --}}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Produdct Image</label>
                            <input type="file" onchange="loadfile(event)" name="product_image" class="form-control {{($errors->first('product_image') ? " form-error" : "")}}" id="exampleInputEmail1" placeholder="Alart Quantity">
                            <img src="" id="preimage" width="200" height="200" alt="">
                            @error('product_image')
                                <span class="invalid-feedback text-danger">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label for="exampleInputEmail1">Image Preview</label>
                            <img id="image" width="150" src="" alt="">
                        </div> --}}
                        <button type="submit" class="btn btn-purple waves-effect waves-light">Submit</button>
                    </form>
                </div>
            </div>
            <!-- end col -->

        </div>
        <!-- end row -->




    </div> <!-- container -->

</div>
<script type="text/javascript">
    function loadfile(event) {
        var output=document.getElementById('preimage');
        output.src=URL.createObjectURL(event.target.files[0]);
    }
</script>

@endsection

@section('footer_js')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script type="text/javascript">
    $(document).ready(function ()
    {
            $('select[name="category_id"]').on('change',function(){
               var categoryId = $(this).val();
               if(categoryId)
               {
                  $.ajax({
                     url : 'ajax/category/' +categoryId,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(categoryId);
                        $('select[name="subcategory_id"]').empty();
                        $.each(data, function(key,value){
                        $('select[name="subcategory_id"]').append('<option value="'+value.id+'">'+value.subcategory_name+'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="subcategory_id"]').empty();
               }
            });

            $(function() {
                $('#subdiv').hide();
                $('select[name="category_id"]').change(function(){
                    if($('select[name="category_id"]')) {
                        $('#subdiv').hide();
                        $('#subdiv').slideDown();
                    } else {
                        $('#subdiv').hide();
                    }
                });
            });

            $('#product_name').keyup(function() {
            $('#slug').val($(this).val().toLowerCase().split(',').join('').replace(/\s/g,"-"));
        });


        var editor_config = {
    path_absolute : "/",
    selector: "textarea.product_description",
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };

  tinymce.init(editor_config);

});


</script>
@endsection
