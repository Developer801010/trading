@extends('layouts.master')

@section('title', 'Article Creation')

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
@endsection
@section('content')
<section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Article Creation</h4>
                </div>

                <div class="card-body">         

                    @include('layouts.error')           

                    <form action="{{route('articles.store')}}" class="articleForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="itemname">Title</label>
                                <input type="text" class="form-control" name="title" id="title" value="{{old('title')}}" />
                            </div>
                        </div>
                          
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <label class="form-label" for="itemname">Description</label>
                                <div class="quill-toolbar">
                                    <span class="ql-formats">
                                        <select class="ql-header">
                                            <option value="1">Heading</option>
                                            <option value="2">Subheading</option>
                                            <option selected>Normal</option>
                                        </select>
                                        <select class="ql-font">
                                            <option selected>Sailec Light</option>
                                            <option value="sofia">Sofia Pro</option>
                                            <option value="slabo">Slabo 27px</option>
                                            <option value="roboto">Roboto Slab</option>
                                            <option value="inconsolata">Inconsolata</option>
                                            <option value="ubuntu">Ubuntu Mono</option>
                                        </select>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-list" value="ordered"></button>
                                        <button class="ql-list" value="bullet"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-link"></button>
                                        <button class="ql-image"></button>
                                        <button class="ql-video"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-formula"></button>
                                        <button class="ql-code-block"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-clean"></button>
                                    </span>
                                </div>
                                <div class="quill_editor">
                                        
                                </div>                                       
                            </div>
                            <input type="hidden" id="quill_html" name="quill_html"></input>
                        </div>

                        <div class="col-12 mb-1 image_row">
                            <label for="customFile" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image" name="image" />
                        </div>                        
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success" style="margin-right:15px;">Save</button>
                                <a href="{{route('articles.index')}}" class="btn btn-outline-primary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>                
            </div>
        </div>
    
</section>
@endsection
@section('page-script')
<script src="{{asset('app-assets/vendors/js/editors/quill/quill.min.js')}}"></script>
<script>
    $(document).ready(function () {

        var articleForm = $('.articleForm');
        articleForm.validate({
            rules: {
                'title': {
                    required: true
                }
            }
        });

        var quill = new Quill('.quill_editor', {
            modules: {
                toolbar: '.quill-toolbar'
            },
            theme: 'snow'
        });

      
        quill.on('text-change', function(delta, oldDelta, source) {
            document.getElementById("quill_html").value = quill.root.innerHTML; 
        });
        
    });

</script>
@endsection