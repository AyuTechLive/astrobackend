@extends('frontend.astrologers.layout.master')
<style>
    .table-container {
    max-height: 400px; /* Adjust the maximum height as needed */
    overflow-y: auto;
}
</style>
@section('content')
    <div class="pt-1 pb-1 bg-red d-none d-md-block astroway-breadcrumb">
        <div class="container">
            <div class="row afterLoginDisplay">
                <div class="col-md-12 d-flex align-items-center">
                    <span style="text-transform: capitalize; ">
                        <span class="text-white breadcrumbs">
                            <a href="{{ route('front.astrologerindex') }}" style="color:white;text-decoration:none">
                                <i class="fa fa-home font-18"></i>
                            </a>
                            <i class="fa fa-chevron-right"></i> <a href="{{ route('front.getAstrologerWallet') }}"
                                style="color:white;text-decoration:none">My Wallet</a>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Withdraw Modal --}}

    <div class="modal fade rounded mt-2 mt-md-5 " id="withdraw" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title font-weight-bold">
                        Withdrawal Form
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body pt-0 pb-0">
                    <div class="bg-white body">
                        <div class="row ">

                            <div class="col-lg-12 col-12 ">
                                <div class="mb-3 ">

                                    <form class="px-3 font-14" method="post" id="withdrawForm">
                                        <div class="row">
                                            <div class="col-12 col-md-12 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="Amount">Amount<span class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                           id="Amount" name="withdrawAmount" placeholder="Enter Amount"
                                                           type="text"
                                                          >
                                                          <input type="hidden" name="astrologerId" value="{{astroauthcheck()['astrologerId']}}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="Method">Method<span class="color-red">*</span></label>
                                                    <div style="display: flex; gap: 10px;">
                                                        @foreach($withdrawMethod as $method)
                                                            <div>
                                                                <input type="radio" name="paymentMethod" value="{{ $method->method_id }}" id="method_{{ $method->id }}" class="method-radio" data-method-id="{{ $method->method_id  }}">
                                                                <label for="method_{{ $method->id }}">{{ $method->method_name }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="bankDetails" class="col-12 col-md-12 py-2" style="display: none;">
                                                <div class="form-group mb-0">
                                                    <label for="AccountNumber">Account Number<span class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                           id="AccountNumber" name="accountNumber" placeholder="Enter Account Number"
                                                           type="text">
                                                </div>
                                                <div class="form-group mb-0">
                                                    <label for="IFSCCode">IFSC Code<span class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                           id="IFSCCode" name="ifscCode" placeholder="Enter IFSC Code"
                                                           type="text">
                                                </div>
                                                <div class="form-group mb-0">
                                                    <label for="HolderName">Holder Name<span class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                           id="HolderName" name="accountHolderName" placeholder="Enter Holder Name"
                                                           type="text">
                                                </div>
                                            </div>

                                            <div id="upiDetails" class="col-12 col-md-12 py-2" style="display: none;">
                                                <div class="form-group mb-0">
                                                    <label for="UPIId">UPI Id<span class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                           id="UPIId" name="upiId" placeholder="Enter UPI Id"
                                                           type="text">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 py-3">
                                            <div class="row">
                                                <div class="col-12 pt-md-3 text-center mt-2">
                                                    <button class="font-weight-bold ml-0 w-100 btn btn-chat"
                                                            id="withdrawalloader" type="button" style="display:none;"
                                                            disabled>
                                                        <span class="spinner-border spinner-border-sm" role="status"
                                                              aria-hidden="true"></span> Loading...
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-block btn-chat px-4 px-md-5 mb-2"
                                                            id="withdrawalbtn">Send Withdraw Request</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- End Modal --}}

    {{-- Edit Withdraw Modal --}}

    <div class="modal fade rounded mt-2 mt-md-5 " id="editwithdraw" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title font-weight-bold">
                       Edit Withdrawal Form
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body pt-0 pb-0">
                    <div class="bg-white body">
                        <div class="row ">

                            <div class="col-lg-12 col-12 ">
                                <div class="mb-3 ">

                                    <form class="px-3 font-14" method="post" id="editwithdrawForm">
                                        <div class="row">
                                            <div class="col-12 col-md-12 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="Amount">Amount<span class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                           id="Amount" name="withdrawAmount" placeholder="Enter Amount"
                                                           type="text"
                                                          >
                                                          <input type="hidden" name="astrologerId" value="{{astroauthcheck()['astrologerId']}}">
                                                          <input type="hidden" name="id" value="{{$method->id}}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="Method">Method<span class="color-red">*</span></label>
                                                    <div style="display: flex; gap: 10px;">
                                                        @foreach($withdrawMethod as $method)
                                                            <div>
                                                                <input type="radio" name="paymentMethod" value="{{ $method->method_id }}" id="method_{{ $method->id }}" class="method-radio" data-method-id="{{ $method->method_id  }}">
                                                                <label for="method_{{ $method->id }}">{{ $method->method_name }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="bankDetails" class="col-12 col-md-12 py-2" style="display: none;">
                                                <div class="form-group mb-0">
                                                    <label for="AccountNumber">Account Number<span class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                           id="AccountNumber" name="accountNumber" placeholder="Enter Account Number"
                                                           type="text">
                                                </div>
                                                <div class="form-group mb-0">
                                                    <label for="IFSCCode">IFSC Code<span class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                           id="IFSCCode" name="ifscCode" placeholder="Enter IFSC Code"
                                                           type="text">
                                                </div>
                                                <div class="form-group mb-0">
                                                    <label for="HolderName">Holder Name<span class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                           id="HolderName" name="accountHolderName" placeholder="Enter Holder Name"
                                                           type="text">
                                                </div>
                                            </div>

                                            <div id="upiDetails" class="col-12 col-md-12 py-2" style="display: none;">
                                                <div class="form-group mb-0">
                                                    <label for="UPIId">UPI Id<span class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                           id="UPIId" name="upiId" placeholder="Enter UPI Id"
                                                           type="text">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 py-3">
                                            <div class="row">
                                                <div class="col-12 pt-md-3 text-center mt-2">
                                                    <button class="font-weight-bold ml-0 w-100 btn btn-chat"
                                                            id="editwithdrawalloader" type="button" style="display:none;"
                                                            disabled>
                                                        <span class="spinner-border spinner-border-sm" role="status"
                                                              aria-hidden="true"></span> Loading...
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-block btn-chat px-4 px-md-5 mb-2"
                                                            id="editwithdrawalbtn">Edit Withdraw Request</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- End Modal --}}

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="inpage">
                    <div class="text-left pb-md-4 pb-2">
                        <h1 class="h2 font-weight-bold colorblack">My Wallet</h1>
                        <p>Check your balance, add money and see your complete transaction history here.</p>
                    </div>
                    <div class="d-flex pb-3 align-items-center justify-content-between border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="row flex-nowrap align-items-center">
                                <div class="col-auto pr-0">
                                    <img src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/Payment.svg') }}"
                                        alt="Wallet">
                                </div>
                                <div class="col-auto pr-0">
                                    <h3 class="font22 orangecolor font-weight-semibold m-0 p-0">
                                        <span id="wallbalance"
                                            class="color-red d-flex justify-content-center">{{ $currency['value'] }}{{ $getProfile['data']['totalWalletAmount'] }}</span>

                                    </h3>
                                    <span class="font-12 colorblack font-weight-semi">Current Balance</span>
                                </div>
                                <div class="col-auto pr-0">
                                    <h3 class="font22 orangecolor font-weight-semibold m-0 p-0">
                                        <span id="wallbalance"
                                            class="text-info d-flex justify-content-center">{{ $currency['value'] }}{{ $withdrawlrequest['recordList']['totalEarning'] }}</span>

                                    </h3>
                                    <span class="font-12 colorblack font-weight-semi">Total Earning</span>
                                </div>
                                <div class="col-auto pr-0">
                                    <h3 class="font22 orangecolor font-weight-semibold m-0 p-0">
                                        <span id="wallbalance"
                                            class="text-success d-flex justify-content-center">{{ $currency['value'] }}{{ $withdrawlrequest['recordList']['withdrawAmount'] }}</span>

                                    </h3>
                                    <span class="font-12 colorblack font-weight-semi">Total Withdrawal</span>
                                </div>
                                <div class="col-auto pr-0">
                                    <h3 class="font22 orangecolor font-weight-semibold m-0 p-0">
                                        <span id="wallbalance"
                                            class="text-warning d-flex justify-content-center">{{ $currency['value'] }}{{ $withdrawlrequest['recordList']['totalPending'] }}</span>

                                    </h3>
                                    <span class="font-12 colorblack font-weight-semi">Total Pending</span>
                                </div>
                            </div>
                        </div>
                        <div class=" text-right">
                            <a  class="btn btn-chat" data-toggle="modal"  data-target="#withdraw"  id="btnWithdrawMoney">Withdraw
                                Money</a>

                            <a href="{{ route('front.AstrologerWalletRecharge') }}" class="btn btn-chat" id="btnAddMoney">Add
                                Money</a>
                        </div>
                    </div>

                    <div class="d-flex flex-nowrap nav nav-tabs">
                        <a data-toggle="tab" id="paymentLog" href="#paymentLogsTable"
                            class="text-decoration-none  colorbrown weight500 py-2 py-sm-3 px-2 px-sm-3 d-inline-block border-bottom borderbrown">
                            Payment Logs
                        </a>
                        <a data-toggle="tab" id="walletTransaction" href="#walletTransactionTable"
                            class="text-decoration-none text-dark py-2 py-sm-3 px-2 px-sm-3 d-inline-block">
                            Wallet Transaction
                        </a>
                        <a data-toggle="tab" id="withdrawTransaction" href="#withdrawTransactionTable"
                            class="text-decoration-none text-dark py-2 py-sm-3 px-2 px-sm-3 d-inline-block">
                            Withdraw Request
                        </a>
                    </div>



                    <div class="tab-content mt-3">
                        <div class="table-responsive  tab-pane fade show active" id="paymentLogsTable">
                            <div class="row pt-1 pb-3" id="historydate">
                                <div class="col-md-12">
                                    <h3 class="font16 font-weight-bold py-4">Payment Logs</h3>

                                </div>
                            </div>
                            <div class="table-container">
                            <table class="table">
                                <!-- Payment Logs Table Content -->
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Payment Mode</th>
                                        <th>Amount</th>
                                        <th>Cashback Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getAstrologer['recordList'][0]['payment'] as $walletdata)
                                        @if (!empty($walletdata))
                                            <tr>
                                                <td>{{ $walletdata['orderId'] }}</td>
                                                <td>{{ $walletdata['paymentMode'] }}</td>
                                                <td>{{ $currency['value'] }}{{ number_format($walletdata['amount'], 2) }}
                                                </td>
                                                <td>{{ $currency['value'] }}{{ number_format($walletdata['cashback_amount'], 2) }}
                                                </td>
                                                @if ($walletdata['paymentStatus'] == 'success')
                                                    <td class="text-success">{{ $walletdata['paymentStatus'] }}</td>
                                                @else
                                                    <td class="text-danger">{{ $walletdata['paymentStatus'] }}</td>
                                                @endif
                                                <td>{{ $walletdata['created_at'] }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>

                        <div class="table-responsive  tab-pane fade" id="walletTransactionTable">
                            <div class="row pt-1 pb-3" id="historydate">
                                <div class="col-md-12">
                                    <h3 class="font16 font-weight-bold py-4">Transaction History</h3>

                                </div>
                            </div>
                            <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Transaction Details</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($getAstrologer['recordList'][0]['wallet'] as $walletdata)
                                        @if (!empty($walletdata))
                                            <tr>
                                                <td>
                                                    <div>
                                                        <h5>
                                                            @if ($walletdata['transactionType'] == 'Call' || $walletdata['transactionType'] == 'Chat')
                                                                {{ $walletdata['transactionType'] }} with
                                                                {{ $walletdata['name'] }} for
                                                                {{ $walletdata['totalMin'] }} minutes
                                                            @elseif($walletdata['transactionType'] == 'astromallOrder' && $walletdata['isCredit']==0)
                                                                Product Ordered
                                                            @elseif($walletdata['transactionType'] == 'astromallOrder' && $walletdata['isCredit']==1)
                                                            Product Cancelled
                                                            @elseif($walletdata['transactionType'] == 'Gift')
                                                                Received {{ $walletdata['transactionType'] }} From
                                                                {{ $walletdata['name'] }}
                                                            @else
                                                                {{ $walletdata['transactionType'] }} Received
                                                            @endif
                                                        </h5>
                                                    </div>
                                                    <div class="font-12 text-muted">
                                                        {{ date('j-F-Y H:i a', strtotime($walletdata['created_at'])) }}
                                                    </div>
                                                </td>
                                                @if ($walletdata['transactionType'] == 'Cashback')
                                                <td class="text-success">
                                                    <div class="font-medium">+{{$currency['value']}}{{ $walletdata['amount'] }}</div>
                                                </td>
                                                @elseif($walletdata['transactionType'] == 'KundliView')
                                                <td class="text-danger">
                                                    <div class="font-medium">-{{$currency['value']}}{{ $walletdata['amount'] }}</div>
                                                </td>

                                                @elseif ($walletdata['transactionType'] == 'astromallOrder' && $walletdata['isCredit']==1)
                                                <td class="text-success">
                                                    <div class="font-medium">+{{$currency['value']}}{{ $walletdata['amount'] }}</div>
                                                </td>
                                                 @else
                                                 <td class="text-success">
                                                    <div class="font-medium">+{{$currency['value']}}{{ $walletdata['amount'] }}</div>
                                                </td>
                                                 @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>
                        <div class="table-responsive  tab-pane fade" id="withdrawTransactionTable">
                            <div class="row pt-1 pb-3" id="historydate">
                                <div class="col-md-12">
                                    <h3 class="font16 font-weight-bold py-4">Withdrawal History</h3>

                                </div>
                            </div>
                            <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>

                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th class="text-center">Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdrawlrequest['recordList']['withdrawl'] as $withdrawl)
                                        @if (!empty($withdrawl))

                                            <tr>
                                                <td>{{ $currency['value'] }}{{ number_format($withdrawl['withdrawAmount'], 2) }}
                                                </td>
                                                <td>{{ $withdrawl['created_at'] }}</td>


                                                @if ($withdrawl['status'] == 'Pending')
                                                    <td class="text-warning">{{ $withdrawl['status'] }}</td>
                                                @else
                                                    <td class="text-success">{{ $withdrawl['status'] }}</td>
                                                @endif
                                                @if($withdrawl['status'] == 'Pending')
                                                <td class="text-center">

                                                    <a data-toggle="modal"  data-target="#editwithdraw" id="editwithdraw"  class="btn btn-chat editwithdraw" data-field='@json($withdrawl)'>Edit</a>
                                                </td>
                                                @else
                                                <td class="text-center">-</td>
                                                @endif

                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script>
    $(document).ready(function(){
        $("#paymentLog").on('click',function(){
            $('#paymentLog').addClass("border-bottom borderbrown colorbrown");
            $('#paymentLog').removeClass("text-dark");
            $('#walletTransaction').removeClass("border-bottom borderbrown colorbrown");
            $('#walletTransaction').addClass("text-dark");
            $('#withdrawTransaction').removeClass("border-bottom borderbrown colorbrown");
            $('#withdrawTransaction').addClass("text-dark");
        });

        $("#walletTransaction").on('click',function(){
            $('#walletTransaction').addClass("border-bottom borderbrown colorbrown ");
            $('#walletTransaction').removeClass("text-dark");
            $('#paymentLog').removeClass("border-bottom borderbrown colorbrown");
            $('#paymentLog').addClass("text-dark");
            $('#withdrawTransaction').removeClass("border-bottom borderbrown colorbrown");
            $('#withdrawTransaction').addClass("text-dark");
        });

        $("#withdrawTransaction").on('click',function(){
            $('#withdrawTransaction').addClass("border-bottom borderbrown colorbrown ");
            $('#withdrawTransaction').removeClass("text-dark");
            $('#paymentLog').removeClass("border-bottom borderbrown colorbrown");
            $('#paymentLog').addClass("text-dark");
            $('#walletTransaction').removeClass("border-bottom borderbrown colorbrown");
            $('#walletTransaction').addClass("text-dark");
        });
    });
</script>
<script>



    $(document).ready(function() {
        $('input[name="paymentMethod"]').change(function() {
            var methodId = $(this).data('method-id');
            var modal = (this).closest('.modal');
            $('#bankDetails',modal).hide();
            $('#upiDetails',modal).hide();

            if (methodId == '1') {
                $('#bankDetails',modal).show();
            } else if (methodId == '2') {
                $('#upiDetails',modal).show();
            }
        });
    });
    </script>

<script>
    $(document).ready(function() {
        $('#withdrawalbtn').click(function(e) {
            e.preventDefault();
            $('#withdrawalbtn').hide();
                $('#withdrawalloader').show();
                setTimeout(function() {
                    $('#withdrawalbtn').show();
                    $('#withdrawalloader').hide();
                }, 3000);

            @php
                use Symfony\Component\HttpFoundation\Session\Session;
                use Illuminate\Support\Facades\DB;

                $session = new Session();
                $token = $session->get('astrotoken');

            @endphp

            var formData = $('#withdrawForm').serialize();

            $.ajax({
                url: '{{ route('api.sendWithdrawRequest', ['token' => $token]) }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Withdrawal Request Sent Successfully')
                    window.location.reload();
                    // console.log(response);
                },

                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });
    });
</script>
<script>
     $(document).on('click','.editwithdraw',function(e){
        var fields = $(this).data('field');
        $('#editwithdraw [name="withdrawAmount"]').val(fields.withdrawAmount);
        $('#editwithdraw [name="paymentMethod"][value="'+fields.paymentMethod+'"]').click();
        $('#editwithdraw [name="accountNumber"]').val(fields.accountNumber);
        $('#editwithdraw [name="accountNumber"]').val(fields.accountNumber);
        $('#editwithdraw [name="accountHolderName"]').val(fields.accountHolderName);
        $('#editwithdraw [name="ifscCode"]').val(fields.ifscCode);
        $('#editwithdraw [name="upiId"]').val(fields.upiId);
        $('#editwithdraw [name="astrologerId"]').val(fields.astrologerId);
        $('#editwithdraw [name="id"]').val(fields.id);
        });
</script>
<script>
    $(document).ready(function() {
        $('#editwithdrawalbtn').click(function(e) {
            e.preventDefault();
            $('#editwithdrawalbtn').hide();
                $('#editwithdrawalloader').show();
                setTimeout(function() {
                    $('#editwithdrawalbtn').show();
                    $('#editwithdrawalloader').hide();
                }, 3000);

            @php
                $session = new Session();
                $token = $session->get('astrotoken');

            @endphp

            var formData = $('#editwithdrawForm').serialize();
            // console.log(formData);return false;

            $.ajax({
                url: '{{ route('api.updateWithdrawRequest', ['token' => $token]) }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Withdrawal Request Updated Successfully')
                    window.location.reload();
                    // console.log(response);
                },

                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });
    });
</script>



@endsection
