@extends('frontend.astrologers.layout.master')
<style>
    .pac-container:after {
        content: none !important;
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
                            <i class="fa fa-chevron-right"></i> <a href="{{ route('front.getkundali') }}"
                                style="color:white;text-decoration:none">Kundali </a>

                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="astroway-menu py-2 bg-pink border-bottom border-pink">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="list-unstyled d-flex mb-0">
                        <li class="align-self-center">
                            <div class="text-left">
                                <h1 class="font-24">
                                    <span class="d-block cat-heading font-weight-semi-bold">Janam Kundali</span>
                                </h1>
                            </div>
                        </li>
                        <li class="compatibility d-none d-md-block">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="74.197" height="74.198"
                                    viewBox="0 0 74.197 74.198">
                                    <g data-name="Group 19594" transform="translate(.28 .063)">
                                        <path data-name="Path 25893"
                                            d="M36.819 74.135a37.1 37.1 0 1 1 37.1-37.1 37.142 37.142 0 0 1-37.1 37.1Zm0-70.671a33.572 33.572 0 1 0 33.572 33.572A33.609 33.609 0 0 0 36.819 3.464Z"
                                            fill="#ee4e5e"></path>
                                        <path data-name="Path 25894"
                                            d="M6.884 54.761a1.763 1.763 0 0 1-1.509-2.674L35.691 1.866a1.764 1.764 0 0 1 3.029.015l29.553 50.224a1.763 1.763 0 0 1-1.52 2.658Zm56.786-3.526L37.181 6.22 10.006 51.236Z"
                                            fill="#ee4e5e"></path>
                                        <path data-name="Path 25895"
                                            d="M36.43 73.059a1.771 1.771 0 0 1-1.513-.869L5.364 21.967a1.764 1.764 0 0 1 1.52-2.658h59.869a1.763 1.763 0 0 1 1.509 2.675L37.945 72.208a1.772 1.772 0 0 1-1.508.851Zm.026-5.206L63.63 22.835H9.967Z"
                                            fill="#ee4e5e"></path>
                                        <circle data-name="Ellipse 2023" cx="7.254" cy="7.254" r="7.254"
                                            transform="translate(29.565 29.782)"></circle>
                                    </g>
                                </svg>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="ds-head-populararticle bg-white cat-pages">
        <div class="container">
            <div class="row py-3">
                <div class="col-sm-12 mt-4">
                    <div class="row">
                        <div class="col-12 mb-5">
                            <h2 class="cat-heading font-24 font-weight-bold">Get Future Predictions With Free <span
                                    class="color-red">Online Janam Kundali</span></h2>
                            <p class="pt-3 text-center  ">The online Janam Kundali at Astroway is prepared after
                                consulting with experienced Astrologers and is absolutely accurate &amp; authentic. Having
                                doubts in life? Confused about your future? Simply fill in your details and get the online
                                Kundali that will tell you everything about your personality, future &amp; all the
                                other important events in your life.</p>
                        </div>
                        <div class="col-lg-8 col-12 ">
                            <div class="mb-3 shadow-pink">
                                <div class="bg-pink color-red text-center font-weight-semi-bold py-1 px-3">
                                    ENTER DETAILS
                                </div>

                                <form class="px-3 font-14" method="post" id="kundliForm">

                                    <div class="row">
                                        <div class="col-12 col-md-6 py-3">
                                            <div class="form-group mb-0">
                                                <label  class="">Name&nbsp;<span
                                                        class="color-red">*</span></label>
                                                <input class="form-control border-pink matchInTxt shadow-none"
                                                    id="Name" name="kundali[0][name]" placeholder="Enter Name"
                                                    type="text" value="">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 py-3">
                                            <div class="mb-0">

                                                <label  class="">Place of Birth&nbsp;<span
                                                        class="color-red">*</span></label>
                                                <div class="input-group is-invalid">
                                                    <input autocomplete="off"
                                                        class="form-control rounded border-pink shadow-none matchInTxt ui-autocomplete-input"
                                                        id="address" name="kundali[0][birthPlace]"
                                                        placeholder="Place of Birth" type="text">

                                                        <input type="hidden" id="latitude" name="kundali[0][latitude]">
                                                        <input type="hidden" id="longitude" name="kundali[0][longitude]">
                                                        <input type="hidden" id="timezone" name="kundali[0][timezone]">
                                                    <input type="hidden" value="en" name="kundali[0][lang]">

                                                    <input type="hidden" value="false" name="is_match">


                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 py-3">
                                            <div class=" mb-0">
                                                <label class="">Birth Date&nbsp;<span
                                                        class="color-red">*</span></label>
                                                <label class="control-label commonerror float-right color-red"
                                                    id="dateError"></label>
                                                <input type="date" name="kundali[0][birthDate]"
                                                    class="form-control rounded border-pink shadow-none matchInTxt ui-autocomplete-input">

                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 py-3">
                                            <div class="form-group mb-0">
                                                <div>
                                                    <div class="position-relative" style="display:flow-root">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label
                                                                    class="control-label commonerror float-right color-red mb-0"
                                                                    id="timeError"></label>
                                                            </div>
                                                        </div>

                                                        <label class="">Birth Time&nbsp;<span
                                                                class="color-red">*</span></label>
                                                        <input type="time" name="kundali[0][birthTime]"
                                                            class="form-control rounded border-pink shadow-none matchInTxt ui-autocomplete-input">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 py-3">
                                            <div>
                                                <label class="">Gender&nbsp;<span
                                                        class="color-red">*</span></label>
                                                <div class="input-group mb-0">

                                                    <select
                                                        class="form-control font-14 border-pink text-dark shadow-none matchInTxt"
                                                         name="kundali[0][gender]">
                                                        <!-- <option value="">Gender</option> -->
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        @if (astroauthcheck())
                                            @if ($getkundaliprice['isFreeSession'] == false)
                                                <div class="col-12 col-md-6 py-3">
                                                    <label class="">Select Type&nbsp;<span
                                                            class="color-red">*</span></label>
                                                    <select name="kundali[0][pdf_type]" onchange="updateAmount()"
                                                        class="form-control font-14 border-pink text-dark shadow-none matchInTxt"
                                                        id="pdf_type">
                                                        <option>Select Type</option>

                                                        <option value="small"
                                                            data-price="{{ $getkundaliprice['recordList']['SMALL'] }}">
                                                            Small ({{$currency['value']}}{{ $getkundaliprice['recordList']['SMALL'] }})</option>
                                                        <option value="medium"
                                                            data-price="{{ $getkundaliprice['recordList']['MEDIUM'] }}">
                                                            Medium ({{$currency['value']}}{{ $getkundaliprice['recordList']['MEDIUM'] }})</option>
                                                        <option value="large"
                                                            data-price="{{ $getkundaliprice['recordList']['LARGE'] }}">
                                                            Large ({{$currency['value']}}{{ $getkundaliprice['recordList']['LARGE'] }})</option>
                                                    </select>
                                                    <input type="hidden" value="" name="amount" id="amount">

                                                </div>
                                            @else
                                            <input type="hidden" value="0" name="amount">
                                            <input type="hidden" value="small" name="kundali[0][pdf_type]">
                                            @endif
                                        @endif
                                        <div class="col-12 col-md-6 py-3">
                                            <div class="row">

                                                <div class="col-12 pt-md-3 text-center mt-2">
                                                    @if (astroauthcheck())
                                                        <button class="btn btn-block btn-chat px-4 px-md-5 mb-2"
                                                            id="kundaliloaderbtn" type="button" style="display:none;"
                                                            disabled>
                                                            <span class="spinner-border spinner-border-sm" role="status"
                                                                aria-hidden="true"></span> Loading...
                                                        </button>
                                                        <button type="submit" id="showKundalibtn"
                                                            class="btn btn-block btn-chat px-4 px-md-5 mb-2">Show
                                                            Kundali</button>
                                                    @else
                                                        <button type="submit" disabled
                                                            class="btn btn-block btn-chat px-4 px-md-5 mb-2">Login To
                                                            View</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                        {{-- Saved Kundali --}}
                        @if(astroauthcheck())
                        <div class="col-lg-4  ">
                            <div class="mb-3 shadow-pink">
                                <div class="bg-pink color-red text-center font-weight-semi-bold py-1 px-3">
                                    Saved Reports <a href="javascript:void(0)" id="refreshkundalies"
                                        class="color-red float-right" title="Refresh"><i class="fa fa-refresh"
                                            aria-hidden="true"></i></a>
                                </div>

                                {{-- {{dd($getkundali['recordList'])}} --}}
                                    <div id="savedKundalies"
                                        style="height: 399px; overflow-y: overlay; overflow-x: hidden; ">
                                        <div>
                                            <ul class="list-unstyled py-2">
                                                @foreach ($getkundali['recordList'] as $getkundali)
                                                    <li class="ui-menu-item border-bottom px-3 mt-2">
                                                        <div class="row mb-2">
                                                            <div class="col-10">
                                                                <div class="row">
                                                                    <div class="col-auto d-flex">
                                                                        @php
                                                                            $first_character = substr($getkundali['name'],0,1,);
                                                                        @endphp
                                                                        <span
                                                                            class="rounded-25 font-14 text-white p-1 align-self-center text-center"
                                                                            style="background-color:#5E2329;min-width:29px;">
                                                                            {{ $first_character }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="col pl-1">
                                                                        <a href="{{ url('public/' . $getkundali['pdf_link']) }}"
                                                                            class="colorblack">
                                                                            <p
                                                                                class="mb-0 font-13 font-weight-semi-bold small">
                                                                                {{ $getkundali['name'] }}</p>
                                                                            <p class="mb-0 font-12">
                                                                                {{ $getkundali['created_at'] }}</p>
                                                                            <p class="mb-0 font-12">
                                                                                {{ $getkundali['birthPlace'] }}</p>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            {{-- <form class="deletekundaliform">
                                                                <input type="hidden" value="{{ $getkundali['id']}}" name="id">
                                                                <div class="col-2 text-center align-self-center mt-2">
                                                                    <a class="deletekundali">
                                                                        <i class="fa-solid fa-trash color-red"></i>
                                                                    </a>

                                                                </div>
                                                            </form> --}}
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        @else
                       <div class="col-lg-4  ">
                            <div class="mb-3 shadow-pink d-flex" style="height: 430px;">
                                <div class="text-center p-2 align-self-center w-100"
                                    style="overflow-y: overlay; overflow-x: hidden; ">
                                    <p class="text-center font-20 text-light-pink px-4">Login to See Your Saved Kundali!</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>



        <div class="bg-white astrology-services">
            <div class="container pt-5">
                <div class="row">

                    <div class="col-12">

                        <h2 class="heading text-center mt-5">WHY SHOULD YOU GET YOUR JANAM KUNDALI?</h2>
                        <p>A Janam Kundali or Birth Chart is simply a way to get clarity about your future to make better
                            decisions and choices in life. It is a blueprint of the position of the planets and the stars in
                            the Universe at the time of your birth on the basis of which the predictions about your future
                            are made. There are many ways in which your Janam kundali by date of birth and time can help you
                            in your life.</p>
                        <ul>
                            <li>Make better professional decisions and career choices.</li>
                            <li>Gain better clarity about your personality, strengths and weaknesses.</li>
                            <li>Know the favorable and unfavorable time periods of your life.</li>
                            <li>Know how to make better financial choices and attract prosperity in life,</li>
                            <li>Choose the right partner for marriage with Kundali Matching.</li>
                        </ul>

                        <h2 class="heading text-center mt-5">Create Online Janam Kundali</h2>
                        <p>An online Janam Kundli is only accurate when you have exact information about your date of birth
                            and time of birth. A lot of people make the mistake of entering the incorrect birth time, which
                            results in an incorrect Kundali and predictions that are totally irrelevant.</p>
                        <p>It is easy to get a Janam Kundli online. Just enter the appropriate information and hit the
                            submit button. It dates back to the Vedic era when Kundli was used for prediction. The Kundali
                            chart we have provided you is an authentic representation of the Vedic tradition</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@php
$getsystemflag = Http::withoutVerifying()->post(url('/') . '/api/getSystemFlag')->json();
$getsystemflag = collect($getsystemflag['recordList']);
$apikey = $getsystemflag->where('name', 'googleMapApiKey')->first();

@endphp
<script src="https://maps.googleapis.com/maps/api/js?key={{ $apikey['value'] }}&libraries=places">
</script>
<script>
    var input = document.getElementById('address');
    var originLatitude = document.getElementById('latitude');
    var originLongitude = document.getElementById('longitude');
    var originTimezone = document.getElementById('timezone');

    var originAutocomplete = new google.maps.places.Autocomplete(input);

    originAutocomplete.addListener('place_changed', function(event) {
        var place = originAutocomplete.getPlace();
        if (place.hasOwnProperty('place_id')) {
            if (!place.geometry) {
                return;
            }
            originLatitude.value = place.geometry.location.lat();
            originLongitude.value = place.geometry.location.lng();
            getTimezone(originLatitude.value, originLongitude.value);
        } else {
            service.textSearch({
                query: place.name
            }, function(results, status) {
                if (status == google.maps.places.PlacesServiceStatus.OK) {
                    originLatitude.value = results[0].geometry.location.lat();
                    originLongitude.value = results[0].geometry.location.lng();
                    getTimezone(originLatitude.value, originLongitude.value);
                }
            });
        }
    });

    function getTimezone(lat, lng) {
        var timestamp = Math.floor(Date.now() / 1000);
        var timezoneApiUrl = `https://maps.googleapis.com/maps/api/timezone/json?location=${lat},${lng}&timestamp=${timestamp}&key={{ $apikey['value'] }}`;

        fetch(timezoneApiUrl)
            .then(response => response.json())
            .then(data => {
                if (data.status === "OK") {
                    var rawOffsetHours = data.rawOffset / 3600;
                    var dstOffsetHours = data.dstOffset / 3600;
                    var totalOffset = rawOffsetHours + dstOffsetHours;
                    originTimezone.value = totalOffset;
                } else {
                    console.error("Timezone API error:", data.status);
                }
            })
            .catch(error => console.error("Error fetching timezone:", error));
    }
</script>


    <script>
        function updateAmount() {
            var selectElement = document.getElementById('pdf_type');
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var price = selectedOption.getAttribute('data-price');
            document.getElementById('amount').value = price;
        }

        $(document).ready(function() {
            $('#showKundalibtn').click(function(e) {
                e.preventDefault();

                $('#showKundalibtn').hide();
                $('#kundaliloaderbtn').show();
                setTimeout(function() {
                    $('#showKundalibtn').show();
                    $('#kundaliloaderbtn').hide();
                }, 10000);

                @php
                    use Symfony\Component\HttpFoundation\Session\Session;
                    $session = new Session();
                    $token = $session->get('astrotoken');

                @endphp
                var formData = $('#kundliForm').serialize();
                // console.log(formData);

                $.ajax({
                    url: "{{ route('api.addKundali', ['token' => $token]) }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        toastr.success('Form Submitted Successfully');
                        window.location.reload();
                    },

                    error: function(xhr, status, error) {
                        toastr.error(xhr.responseText);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.deletekundali').click(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure you want to delete ',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = $(this).closest('.deletekundaliform').serialize();
                        // console.log(formData);
                        // return false;

                        $.ajax({
                            url: '{{ route("api.deleteKundali",['token' => $token]) }}',
                            type: 'POST',
                            data: formData,

                            success: function(response) {
                                toastr.success('Kundali Deleted Successfully');
                                window.location.reload();
                            },
                            error: function(xhr, status, error) {
                                var errorMessage = JSON.parse(xhr.responseText).error.paymentMethod[0];
                                toastr.error(errorMessage);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
