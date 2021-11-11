<div class="modal-header px-4">
    <h5 class="modal-title" id="addMemberModalLabel">
        {{-- @if ( empty($member) ) --}}
        @if (request()->route()->getName() == 'members.create')
            Add New Member
        @elseif (request()->route()->getName() == 'members.edit')
            Edit Member
        @endif
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-4">
    @if (request()->route()->getName() == 'members.create')
        <form action="{{ route('members.store') }}" method="POST" id="memberForm">
    @elseif (request()->route()->getName() == 'members.edit')
        <form action="{{ route('members.update', $member->Id) }}" method="POST" id="memberForm">
        @method('PATCH')
    @endif
            @csrf
            <div class="row justify-content-center mb-3">
                <div class="col-md-5">
                    <label for="member_key">Member Key</label>
                </div>
                <div class="col-md-7">
                    <input type="text" name="member_key" id="member_key" @if ( !empty($member) ) value="{{ old('member_key', $member->Point) }}" @endif class="form-control rounded-xl" autofocus autocomplete="off" required>
                </div>
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col-md-5">
                    <label for="member_name">Member Name</label>
                </div>
                <div class="col-md-7">
                    <input type="text" name="member_name" id="member_name" @if ( !empty($member) ) value="{{ old('member_name', $member->Nama) }}" @endif class="form-control rounded-xl" autocomplete="off" required>
                </div>
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col-md-5">
                    <label for="member_note">Note</label>
                </div>
                <div class="col-md-7">
                    <textarea class="form-control rounded-xl" name="member_note" id="member_note" cols="30" rows="3" style="resize: none;">
                        @if ( !empty($member) ) {{ $member->Keterangan }} @endif
                    </textarea>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-5">
                <button type="submit" class="btn btn-lg btn-primary px-5 py-1 rounded-xxl">Save</button>
            </div>
        </form>
</div>
<script>
    $(function () {
        $('#memberForm').on('submit', function(e) {
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
                        $('.modalMember').modal('hide');
                        $('.modalMember').find('form')[0].reset();
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
