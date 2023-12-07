@extends('layouts.master')

@section('title', 'Messages')

@section('page-style')
	<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/katex.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.bubble.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-quill-editor.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/js/editors/summernote/summernote-lite.css') }}">


@endsection

@section('content')
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Messages</h4>
			<a href="javascript:;" class="btn btn-primary btnAdd">Create Message</a>
		</div>

		<div class="table-responsive">
			<table class="table trade-alert-table">
				<thead class="table-light">
					<tr>
						<th>Subject</th>
						<th>Date Posted</th>
						<th>Description</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($messages as $message)
						<tr style="font-weight:bold">
							<td class="text-primary" style="width: 15%">
								{{ $message->trade_title }}
							</td>
							<td style="width: 15%">{{ $message->created_at->format('m/d/Y') }}</td>
							<td style="word-wrap: anywhere;" class="btnPreview fromEdit" data-preview='{{ $message->trade_description }}'
								data-date="{{ $message->created_at->format('F d, Y') }}" data-title="{{ $message->trade_title }}">
								{!! Str::limit(strip_tags($message->trade_description), 150, '...') !!}
							</td>
							<td style="width: 15%">
								{{-- <a href="javascript:;" class="btn btn-success btnEdit" data-description='{{ $message->trade_description }}'
									data-title='{{ $message->trade_title }}' data-id='{{ $message->id }}'
									data-url="{{ route('messages.update', $message->id) }}"
									data-date="{{ $message->created_at->format('F d, Y') }}">
									Edit
								</a> --}}
								<a href="javascript:;" class="btn btn-success btnPreview fromEdit" data-preview='{{ $message->trade_description }}'
									data-date="{{ $message->created_at->format('F d, Y') }}" data-title="{{ $message->trade_title }}">Preview</a>

								{!! Form::open(['method' => 'DELETE', 'class' => 'delete_form', 'route' => ['messages.destroy', $message->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
								{{-- <a href="javascript:;" class="btn btn-danger btnDelete" data-id='{{ $message->id }}'>Delete</a> --}}

							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			{{ $messages->appends(request()->query())->links() }}
		</div>

		<!-- Add Trade Modal -->
		<div class="modal fade" id="addMessage" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered modal-add-trade">
				<div class="modal-content">
					<div class="modal-header bg-transparent">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body pb-5 px-sm-5 pt-50">
						<div class="text-center mb-2">
							<h1 class="modal_trade_title">Add Message</h1>
						</div>

						<form id="addMessageForm" method="post" action="{{ route('messages.store') }}" class="row gy-1 pt-75" enctype="multipart/form-data">
							@csrf
							<div class="col-12">
								<label class="form-label" for="message_title">Subject<span class="text-danger">*</span></label>
								<input type="text" id="message_title" name="message_title" class="form-control" required/>
							</div>

							<div class="col-md-12 mb-5">
								<label class="form-label" for="itemname">Message<span class="text-danger">*</span></label>
								{{-- <div class="quill-toolbar">
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

								</div> --}}
								<textarea id="editor" name="quill_html" required></textarea>
							</div>
							{{-- <input type="hidden" id="quill_html" name="quill_html"> --}}

							<div class="col-12 text-center mt-2 pt-50">
								<button type="reset" class="btn btn-outline-secondary me-1" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
								<button type="button" class="btn btn-success me-1 btnPreview" data-date="{{ date('F d, Y') }}">Preview</button>
								<button type="button" class="btn btn-primary" onclick="submitForm(this);">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!--/ Add Trade Modal -->

		<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered modal-add-trade">
				<div class="modal-content">
					<div class="modal-header bg-transparent">
						<h1></h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body pb-5 px-sm-5 pt-50">
						<div class="mb-2">
							<h1 id="modal_message_title"></h1>
						</div>
						<div id="previewHtml"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('page-script')
	<script src="https://kit.fontawesome.com/8c0eabb613.js" crossorigin="anonymous"></script>
	<script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
	<script src="{{ asset('app-assets/vendors/js/editors/quill/highlight.min.js') }}"></script>
	<script src="{{ asset('app-assets/vendors/js/editors/quill/quill.min.js') }}"></script>
	<script src="{{ asset('app-assets/vendors/js/editors/summernote/summernote-lite.js') }}"></script>
	
	<script>

		$(document).ready(function() {

			$('#editor').summernote({
				height: 150
			});

			$('body').on('click', '.btnAdd', function(e) {

				// var delta = quill_add.clipboard.convert('');
				// quill_add.setContents(delta, 'silent');
				// $('#quill_html').val('');
				$('#message_title').val('');
				$('#editor').summernote('code', '');

				$('button.btnPreview').data('date', "{{ date('F d, Y') }}");

				$('#addMessageForm').attr('action', "{{ route('messages.store') }}")
				$('input[name="_method"]').remove();

				$('.modal_trade_title').html('Add Message');

				$('#addMessage').modal('show');
			});

			$('body').on('click', '.btnEdit', function(e) {
				$('#message_title').val($(this).data('title'));
				// $('#editor').val($(this).data('description'));

				$('#editor').summernote('code', $(this).data('description'));

				// var delta = quill_add.clipboard.convert($(this).data('description'));
				// quill_add.setContents(delta, 'silent');

				$('#addMessageForm').attr('action', $(this).data('url'))
				$('#addMessageForm').prepend(`<input type="hidden" name="_method" value="patch">`);

				$('button.btnPreview').data('date', $(this).data('date'));

				$('.modal_trade_title').html('Edit Message');
				$('#addMessage').modal('show');
			});

			$('#addMessage, #previewModal').draggable({
				handle: ".modal-header"
			});

			$('.btnPreview').click(function(e) {

				if ($(this).hasClass("fromEdit")) {
					var quill_html = $(this).data('preview');
					var title = $(this).data('title');
				} else {
					var quill_html = $('#editor').summernote('code');
					var title = $('#message_title').val();
				}
				$('#previewHtml').html(quill_html);
				$('#modal_message_title').html(title + `: <span style="font-size: 18px;">` + $(this).data('date') + `</span>`);
				$('#previewModal').modal('show');
			});

			// var quill_add = new Quill('.quill_editor', {
			// 	modules: {
			// 		toolbar: '.quill-toolbar'
			// 	},
			// 	theme: 'snow'
			// });

			// quill_add.on('text-change', function(delta, oldDelta, source) {
			// 	document.getElementById("quill_html").value = quill_add.root.innerHTML;
			// });

		});

		function submitForm(_this) {

			$(_this).prop('disabled', true);
			$(_this).html('Saving...');
			
			$('#addMessageForm').submit();
		}
	</script>
@endsection
