<div class="modal-header px-4">
    <h5 class="modal-title" id="addSettingModalLabel">
        @if(!isset($setting))
            Add Setting
        @else
            Edit Setting
        @endif
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body px-4">
    @if (!isset($setting))
        <form action="{{ route('settings.store') }}" method="POST" id="editor-setting-form">
    @else
        <form action="{{ route('settings.update', $setting->Id) }}" method="POST" id="editor-setting-form">
        @method('PATCH')
    @endif
        @csrf
        <div class="row justify-content-center mb-3">
            <div class="col-md-5">
                <label for="code">Code</label>
            </div>
            <div class="col-md-7">
                {{$setting->Kode}}
                {{-- <input type="text" name="code" id="code" class="form-control rounded-xl" autocomplete="off" value="{{ old('code', $setting->Kode ?? '') }}" readonly> --}}
                <x-error-message-field for="code" class="d-none"></x-error-message-field>
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-md-5">
                <label for="value">Value</label>
            </div>
            <div class="col-md-7">
                <input type="number" min="0" name="value" id="value" class="form-control rounded-xl" autocomplete="off" required value="{{ old('value', $setting->Value ?? '') }}">
                <x-error-message-field for="value" class="d-none"></x-error-message-field>
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-md-5">
                <label for="note">Note</label>
            </div>
            <div class="col-md-7">
                <textarea name="note" id="note" class="form-control rounded-xl" cols="30" rows="3" style="resize: none;">{{ old('note', $setting->Keterangan ?? '') }}</textarea>
                <x-error-message-field for="note" class="d-none"></x-error-message-field>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn btn-lg btn-primary px-5 py-1 rounded-xxl">Save</button>
        </div>
    </form>
</div>
<script>

    $('#addSettingModal').on('shown.bs.modal', function () {
        $(this).find('#code').focus();
    });

    $(function() {
        $('#editor-setting-form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(this).find('span.error-text').text('');
                },
                success: function(data) {
                    if(data.code == 0) {
                        $.each(data.error, function(prefix, val) {
                            $(this).find('span.'+prefix+'_error').text(val[0]);
                        });
                    } else {
                        $('.modalSetting').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: data.msg
                        });
                        submitted = true;
                    }
                }
            })
        });
    });
</script>
