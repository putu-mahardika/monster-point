<div class="modal-header px-4">
    <h5 class="modal-title" id="addMerchantModalLabel">
        @if(!isset($merchant))
            Add New Merchant
        @else
            Edit Merchant
        @endif
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body px-4">
    @if (!isset($merchant))
        <form action="{{ route('merchants.store') }}" method="POST" id="editor-merchant-form">
    @else
        <form action="{{ route('merchants.update', $merchant->Id) }}" method="POST" id="editor-merchant-form">
        @method('PATCH')
    @endif
        @csrf
        <div class="row justify-content-center mb-3">
            <div class="col-md-5">
                <label for="merchant_name">Merchant Name</label>
            </div>
            <div class="col-md-7">
                <input type="text" id="merchant_name" name="merchant_name" value="{{ old('merchant_name', $merchant->Nama ?? '') }}" class="form-control rounded-xl @error('merchant_name') is-invalid @enderror" autofocus autocomplete="off" required>
                <x-error-message-field for="merchant_name" class="d-none"></x-error-message-field>
            </div>
        </div>
        @if (isset($merchant))
            <div class="row justify-content-center mb-3">
                <div class="col-md-5">
                    <label for="merchant_token">Merchant Token</label>
                </div>
                <div class="col-md-7">
                    <input type="text" id="merchant_token" name="merchant_token" value="{{ old('merchant_token', $merchant->Token ?? '') }}" class="form-control rounded-xl" autofocus autocomplete="off" disabled>
                    <x-error-message-field for="merchant_token" class="d-none"></x-error-message-field>
                </div>
            </div>
        @endif
        <div class="row justify-content-center mb-3">
            <div class="col-md-5">
                <label for="merchant_address">Address</label>
            </div>
            <div class="col-md-7">
                <input type="text" id="merchant_address" name="merchant_address" value="{{ old('merchant_address', $merchant->Alamat ?? '') }}" class="form-control rounded-xl" autocomplete="off" required>
                <x-error-message-field for="merchant_address" class="d-none"></x-error-message-field>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-5">
                <label for="merchant_pic">Person in Charge</label>
            </div>
            <div class="col-md-7">
                <input type="text" id="merchant_pic" name="merchant_pic" value="{{ old('merchant_pic', $merchant->Pic ?? '') }}" class="form-control rounded-xl" autocomplete="off" required>
                <x-error-message-field for="merchant_pic" class="d-none"></x-error-message-field>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-5">
                <label for="merchant_pic_phone">PIC Phone</label>
            </div>
            <div class="col-md-7">
                <input type="text" id="merchant_pic_phone" name="merchant_pic_phone" value="{{ old('merchant_pic_phone', $merchant->PicTelp ?? '') }}"  class="form-control rounded-xl" autocomplete="off" required>
                <x-error-message-field for="merchant_pic_phone" class="d-none"></x-error-message-field>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-5">
                <label for="merchant_pic_email">Email</label>
            </div>
            <div class="col-md-7">
                <input type="email" id="merchant_pic_email" name="merchant_pic_email" value="{{ old('merchant_pic_email', $merchant->Email ?? '') }}" class="form-control rounded-xl" autocomplete="off" required>
                <x-error-message-field for="merchant_pic_email" class="d-none"></x-error-message-field>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-5">
                <label for="use_for">Use For</label>
            </div>
            <div class="col-md-7">
                <input type="text" id="use_for" name="use_for" value="{{ old('use_for', $merchant->Kebutuhan ?? '') }}" class="form-control rounded-xl" autocomplete="off" required>
                <x-error-message-field for="use_for" class="d-none"></x-error-message-field>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-5">
            <button type="submit" id="btnSave" class="btn btn-lg btn-primary px-5 py-1 rounded-xxl">Save</button>
        </div>
    </form>
</div>
<script>
    merchantPicPhone = new Cleave('#merchant_pic_phone', {
        phone: true,
        phoneRegionCode: 'id'
    });

    $('#addMerchantModal').on('shown.bs.modal', function () {
        $(this).find('#merchant_name').focus();
    });

    $(function() {
        $('#editor-merchant-form').on('submit', function(e) {
            e.preventDefault();
            // $('#overlay').css('display', 'block');
            autoDisableSubmitButton();
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
                        $('.modalMerchant').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: data.msg
                        });
                        submitted = true;
                    }
                    removeOverlayPanel();
                },
                error: function (errors) {
                    if (errors.status == 403) {
                        Toast.fire({
                            icon: 'error',
                            title: errors.responseJSON.msg
                        });
                    }
                    else {
                        clearErrorField();
                        showErrorField(errors.responseJSON);
                    }
                    removeOverlayPanel();
                }
            })
        });
    });
</script>
