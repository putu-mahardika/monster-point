<div class="modal-header px-4">
    <h5 class="modal-title" id="addMerchantModalLabel">
        @if( empty($merchant) )
            Add New Merchant
        @else
            Edit Merchant
        @endif
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
{{-- @dd($merchant->Id) --}}
<div class="modal-body px-4">
    @if ( empty($merchant) )
        <form action="{{ route('merchants.store') }}" method="POST" id="editor-merchant-form">
    @else
        <form action="{{ url('merchants/'. $merchant->Id) }}" method="POST" id="editor-merchant-form">
        @method('PATCH')
    @endif
            @csrf
            <div class="row justify-content-center mb-3">
                <div class="col-md-5">
                    <label for="merchant_name">Merchant Name</label>
                </div>
                <div class="col-md-7">
                    <input type="text" id="merchant_name" name="merchant_name" @if ( !empty($merchant) ) value="{{ old('merchant_name', $merchant->Nama) }}" @endif class="form-control rounded-xl" autofocus autocomplete="off" required>
                </div>
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col-md-5">
                    <label for="merchant_address">Address</label>
                </div>
                <div class="col-md-7">
                    <input type="text" id="merchant_address" name="merchant_address" @if ( !empty($merchant) ) value="{{ old('merchant_address', $merchant->Alamat) }}" @endif class="form-control rounded-xl" autocomplete="off" required>
                </div>
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col-md-5">
                    <label for="merchant_pic">Peron in Charge</label>
                </div>
                <div class="col-md-7">
                    <input type="text" id="merchant_pic" name="merchant_pic" @if ( !empty($merchant) ) value="{{ old('merchant_pic', $merchant->Pic) }}" @endif class="form-control rounded-xl" autocomplete="off" required>
                </div>
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col-md-5">
                    <label for="merchant_pic_phone">PIC Phone</label>
                </div>
                <div class="col-md-7">
                    <input type="text" id="merchant_pic_phone" name="merchant_pic_phone" @if ( !empty($merchant) ) value="{{ old('merchant_pic_phone', $merchant->PicTelp) }}" @endif class="form-control rounded-xl" autocomplete="off" required>
                </div>
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col-md-5">
                    <label for="merchant_pic_email">Email</label>
                </div>
                <div class="col-md-7">
                    <input type="email" id="merchant_pic_email" name="merchant_pic_email" @if ( !empty($merchant) ) value="{{ old('merchant_pic_email', $merchant->Email) }}" @endif class="form-control rounded-xl" autocomplete="off" required>
                </div>
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col-md-5">
                    <label for="use_for">Use For</label>
                </div>
                <div class="col-md-7">
                    <input type="text" id="use_for" name="use_for" @if ( !empty($merchant) ) value="{{ old('use_for', $merchant->Kebutuhan) }}" @endif class="form-control rounded-xl" autocomplete="off" required>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-5">
                <button type="submit" class="btn btn-lg btn-primary px-5 py-1 rounded-xxl">Save</button>
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
            let form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                },
                success: function(data) {
                    if(data.code == 0) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                    } else {
                        $('.modalMerchant').modal('hide');
                        $('.modalMerchant').find('form')[0].reset();
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
