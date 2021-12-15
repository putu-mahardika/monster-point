@extends('layouts.main')
@section('meta')

@endsection

@section('css')

@endsection

@section('title', 'Billings')

@section('content')
    <div class="row">
        @if (auth()->user()->is_admin)
            <div class="col-md-4">
                <div class="card rounded-xxl" style="min-height: calc(100vh - 10.3rem);">
                    <div class="card-body">
                        <div id="merchantTable"></div>
                    </div>
                </div>
            </div>
        @endif

        <div class="{{ auth()->user()->is_admin ? 'col-md-8' : 'col' }}">
            <div class="card rounded-xxl" style="min-height: calc(100vh - 10.3rem);">
                <div class="card-body">
                    <h5 id="merchantLabel"></h5>
                    <div id="billingTable"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{
        !config('services.midtrans.isProduction') ? 'https://app.sandbox.midtrans.com/snap/snap.js' : 'https://app.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('services.midtrans.clientKey')
    }}"></script>
    <script>
        let billingTable = null;
        let merchantTable = null;
        let selectedMerchant = {{ auth()->user()->is_admin ? 0 : auth()->user()->merchant->Id }};
        let selectedMerchantName = '{{ auth()->user()->is_admin ? '' : auth()->user()->merchant->Nama }}';

        @if (auth()->user()->is_admin)
            function loadBillingByMerchant() {
                billingTable.option('dataSource', `{{ url('dx/billings') }}/${selectedMerchant}`);
                billingTable.refresh();
                $('#merchantLabel').text(selectedMerchantName);
            }
        @endif

        $(document).ready(() => {
            $('#merchantLabel').text(selectedMerchantName);

            $('#addMerchantModal').on('shown.bs.modal', function () {
                $(this).find('#merchant_name').focus();
            });

            $('#addMemberModal').on('shown.bs.modal', function () {
                $(this).find('#member_key').focus();
            });

            @if (auth()->user()->is_admin)
                merchantTable = $('#merchantTable').dxDataGrid({
                    dataSource: `{{ route('dx.merchants') }}`,
                    keyExpr: 'Id',
                    columnAutoWidth: true,
                    hoverStateEnabled: true,
                    selection: {
                        mode: "single" // or "multiple" | "none"
                    },
                    columns: [
                        {
                            caption: 'No',
                            width: 40,
                            cellTemplate: function(container, options) {
                                container.html(`${options.row.rowIndex + 1}`);
                            }
                        },
                        {
                            dataField: 'Nama',
                        }
                    ],
                    onSelectionChanged(selectedItems) {
                        selectedMerchant = selectedItems.currentSelectedRowKeys[0].Id;
                        selectedMerchantName = selectedItems.currentSelectedRowKeys[0].Nama;
                        // console.log(row.getAttribute('aria-rowindex'));
                        loadBillingByMerchant();
                    },
                    showBorders: false,
                    showColumnLines: false,
                    showRowLines: true,
                    activeStateEnabled: true,
                }).dxDataGrid('instance');
            @endif

            billingTable = $('#billingTable').dxDataGrid({
                dataSource: `{{ url('dx/billings') }}/${selectedMerchant}`,
                keyExpr: 'Id',
                columnAutoWidth: true,
                hoverStateEnabled: true,
                columns: [
                    {
                        caption: '#',
                        cellTemplate: function(container, options) {
                            container.html(`${options.row.rowIndex + 1}`);
                        }
                    },
                    {
                        dataField: 'CreateDate',
                        caption: 'Month',
                        dataType: 'date',
                        format: 'MMMM'
                    },
                    {
                        dataField: 'TotalSukses',
                        caption: 'Clicks'
                    },
                    {
                        dataField: 'TotalBiaya',
                        caption: 'Bill'
                    },
                    {
                        dataField: 'TerbayarTanggal',
                        caption: 'Paid At'
                    },
                    {
                        dataField: 'payStatus',
                        caption: '',
                        cellTemplate: function (container, options) {
                            container.html(`${options.value}`);
                        }
                    },
                    {
                        caption: '',

                    }
                ],
                showBorders: false,
                showColumnLines: false,
                showRowLines: true,
            }).dxDataGrid('instance');
            // var myVal = $('#billingTable option:last').val();


            $('button').click(function(){
                alert( "Handler for .click() called." );
            });
        });

        function memberCellTemplate(container, options) {
            container.html(`${options.value}<i class="fas fa-chevron-right ms-5"></i>`);
        }


        function payment(id){
            console.log(id);
            snap.show();
            var action_btn = document.getElementById('data-'+id);
            console.log(action_btn.innerHTML);

            $.post("/billing-details/payment", {
                idBilling: id
            },
            function (data, status) {
                console.log(data.snap_token);
                if(!data.snap_token){
                    snap.hide();
                } else {
                    action_btn.innerHTML = `<button onclick="snap.pay('`+data.snap_token+`')" class="btn btn-sm btn-primary rounded-xl px-2 button-pay">ANU</button>`

                    snap.pay(data.snap_token, {
                        // Optional
                        onSuccess: function (result) {
                            console.log(JSON.stringify(result, null, 2));
                            location.replace('/');
                        },
                        // Optional
                        onPending: function (result) {
                            console.log(JSON.stringify(result, null, 2));
                            location.replace('/');
                        },
                        // Optional
                        onError: function (result) {
                            console.log(JSON.stringify(result, null, 2));
                            location.replace('/');
                        }
                    });
                }
                return false;
            });
        }

    </script>
@endsection
