
<div class="col-md-7 buttons-bar">
    <button type="button" class="btn btn-outline-success m-w-120" data-toggle="modal" data-target="#add-article">{{ __('site.add_article') }}</button>

    <div id="add-article" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                        <i class="zmdi zmdi-close"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                            <h3 class="m-y-0">{{ __('site.add_article') }}</h3>
                            </div>
                            <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                <form class="form-material" action="" id="article-form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- @method('POST') --}}
                                    {{-- @include('includes.errors') --}}

                                    {{-- title --}}
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="title" placeholder="{{ __('site.title') }}" required='required'>
                                        <small id="title_error" class="form-text text-danger"></small>
                                    </div>

                                    {{-- content --}}
                                    <div class="form-group">
                                        <textarea class="form-control" name="content" placeholder="{{ __('site.content') }}" required='required'></textarea>
                                        <small id="content_error" class="form-text text-danger"></small>
                                    </div>

                                    {{-- image --}}
                                    <div class="form-group">
                                        <label> {{ __('site.image') }} </label>
                                        <input type='file' id="imgInp" name="image" class="form-image " />
                                        <img id="image" src="" alt="{{ __('site.pick_image') }}" />
                                        <small id="image_error" class="form-text text-danger"></small>

                                    </div>

                                    {{-- video --}}
                                    <div class="form-group">
                                        <label> {{ __('site.video') }} </label>
                                        <input type="file" name="video" class="file_multi_video" accept="video/*">

                                        <video class="video-preview" controls>
                                            <source src="" id="video_here">
                                            {{ __('site.pick_video') }}
                                        </video>
                                        <small id="video_error" class="form-text text-danger"></small>
                                    </div>

                                    {{-- copied_from --}}
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="copied_from" placeholder="{{ __('site.copied_from') }}">
                                        <small id="copied_from_error" class="form-text text-danger"></small>
                                    </div>

                                    {{-- category --}}
                                    <div class="form-group">
                                        <select id="form-control-3" name="cat_id" class="custom-select" data-error="This field is required." required='required'>
                                            <option value="" selected="selected">{{ __('site.choose_category') }}</option>
                                            @foreach ($article_categories as $article_category)
                                                <option value="{{ $article_category->id }}">{{ $article_category->name }}</option>
                                            @endforeach
                                        </select>
                                        <small id="cat_id_error" class="form-text text-danger"></small>
                                    </div>

                                    {{-- submit --}}
                                    <div class="m-y-30">
                                        <button type="submit" class="btn btn-success" id="continue">{{ __('site.continue') }}</button>
                                        <button type="button" data-dismiss="modal" class="btn btn-default">{{ __('site.close') }}</button>
                                    </div>

                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).on('click','#continue',function (event) {
    //to prevent all things might run and run only the ajax
    event.preventDefault();

    var formData = new FormData($('#article-form')[0]);

    $.ajax({
        type: 'POST',
        url:'{{ route("articles.store") }}',
        data: formData,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        success:function (data) {

            if (data.status==true){
                location.reload();
                $("#article-form")[0].reset();
            }

        },
        error:function (data) {
            var errors = data.responseJSON;

            $.each( errors.errors, function( key, value ) {
                $('#'+key+"_error").text(value[0]);
            });
        },
    });
});
</script>
