@extends('frontend.layout.master')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@section('content')
    <style>
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }
    </style>
    <div class="pt-1 pb-1 bg-red d-none d-md-block astroway-breadcrumb">
        <div class="container">
            <div class="row afterLoginDisplay">
                <div class="col-md-12 d-flex align-items-center">

                    <span style="text-transform: capitalize; ">
                        <span class="text-white breadcrumbs">
                            <a href="{{ route('front.home') }}" style="color:white;text-decoration:none">
                                <i class="fa fa-home font-18"></i>
                            </a>
                            <i class="fa fa-chevron-right"></i> <span class="breadcrumbtext">Astrologer Registration</span>
                        </span>
                    </span>

                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="container py-5">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('success') }}
                </div>
            @endif
        <div class="row pt-3 pb-lg-5">
            <div class="col-lg-6 col-12 order-lg-1">
                <form action="{{route('front.astrologerstore')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Step 1 -->
                    <div id="step1"
                        class="categorycontent step-1 sychics-join-form position-relative border px-4 pb-4 step active">
                        <h2 class="py-3 text-center"><small class="font-weight-bold">Astrologer Sign Up - Personal
                                Details</small></h2>
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="name">Name<span class="color-red font-weight-bold">*</span></label>
                                <input type="text" id="name" value="{{ old('name') }}" name="name" class="form-control rounded"  >

                            </div>
                            <div class="col-6 mb-3">
                                <label for="email">Email Address<span class="color-red font-weight-bold">*</span></label>
                                <input type="email" id="email" value="{{ old('email') }}" name="email" class="form-control rounded"  >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="contactNo">Phone No<span class="color-red font-weight-bold">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="countryCode" value="{{ old('countryCode') }}" placeholder="+91" name="countryCode"
                                        class="form-control rounded-left" style="max-width: 60px;"  >
                                    <input type="text" value="{{ old('contactNo') }}" id="contactNo" name="contactNo" class="form-control rounded-right"
                                         >
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="profileImage">Profile<span class="color-red font-weight-bold">*</span></label>
                                <input type="file" class="form-control" value="{{ old('profileImage') }}" id="profileImage" name="profileImage" style="height: 44px">
                            </div>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="nextStep()">Next</a>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div id="step2"
                        class="categorycontent step-2 sychics-join-form position-relative border px-4 pb-4 step">
                        <h2 class="py-3 text-center"><small class="font-weight-bold">Astrologer Sign Up - Step 2</small>
                        </h2>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="gender">Gender<span class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="birthDate">Birth Date<span class="color-red font-weight-bold">*</span></label>
                                <input type="date" value="{{ old('birthDate') }}" name="birthDate" id="birthDate"
                                    class="form-control rounded border-pink ">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="astrologerCategoryId">Category<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control select2" name="astrologerCategoryId[]" id="astrologerCategoryId"
                                    multiple>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{ (collect(old('astrologerCategoryId'))->contains($category->id)) ? 'selected' : '' }}>{{$category->name}}</option>
                                   @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="primarySkill">Primary Skills<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control select2" name="primarySkill[]" id="primarySkill" multiple>
                                    @foreach($skills as $skill)
                                    <option value="{{$skill->id}}" {{ (collect(old('primarySkill'))->contains($skill->id)) ? 'selected' : '' }}>{{$skill->name}}</option>
                                    @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="allSkill">All Skills<span class="color-red font-weight-bold">*</span></label>
                                <select class="form-control select2" name="allSkill[]" id="allSkill" multiple>
                                    @foreach($skills as $skill)
                                    <option value="{{$skill->id}}" {{ (collect(old('allSkill'))->contains($skill->id)) ? 'selected' : '' }}>{{$skill->name}}</option>
                                    @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="languageKnown">Language<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control select2" name="languageKnown[]" id="languageKnown" multiple>
                                    @foreach($languages as $language)
                                    <option value="{{$language->id}}" {{ (collect(old('languageKnown'))->contains($language->id)) ? 'selected' : '' }}>{{$language->languageName}}</option>
                                   @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="charge">Add your charge(as per min)<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="number" value="{{ old('charge') }}" id="charge" name="charge" class="form-control rounded"
                                     >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="videoCallRate">Add your video charge(as per min)<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="number" value="{{ old('videoCallRate') }}" id="videoCallRate" name="videoCallRate"
                                    class="form-control rounded"  >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="reportRate">Add your report charge<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="number" value="{{ old('reportRate') }}" id="reportRate" name="reportRate" class="form-control rounded"
                                     >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="experienceInYears">Experience in years<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="number" value="{{ old('experienceInYears') }}" id="experienceInYears" name="experienceInYears"
                                    class="form-control rounded"  >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="dailyContribution">How many hours you can contribute daily?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="number" value="{{ old('dailyContribution') }}" id="dailyContribution" name="dailyContribution"
                                    class="form-control rounded"  >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="hearAboutAstroguru">Where did you hear about {{$appname['value']}}?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ old('hearAboutAstroguru') }}" id="hearAboutAstroguru" name="hearAboutAstroguru"
                                    class="form-control rounded"  >
                            </div>
                            <div class="col-6 mb-3">
                                <label>Are you working on any other platform?<span
                                        class="color-red font-weight-bold">*</span></label><br>
                                <input type="radio" id="astro-yes" name="isWorkingOnAnotherPlatform" value="1"
                                     > Yes
                                <input type="radio" id="astro-no" name="isWorkingOnAnotherPlatform" value="0"
                                     > No
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="prevStep()">Previous</a>
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="nextStep()">Next</a>
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div id="step3"
                        class="categorycontent step-3 sychics-join-form position-relative border px-4 pb-4 step">
                        <h2 class="py-3 text-center"><small class="font-weight-bold">Astrologer Sign Up - Step 3</small>
                        </h2>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="whyOnBoard">Why do you think we should onboard you?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" id="awhyOnBoard" name="whyOnBoard" class="form-control rounded"
                                     >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="interviewSuitableTime">What is suitable time for interview?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ old('interviewSuitableTime') }}" id="interviewSuitableTime" name="interviewSuitableTime" class="form-control rounded"  >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="currentCity">Which city do you currently live in?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ old('currentCity') }}" id="currentCity" name="currentCity" class="form-control rounded"
                                     >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="mainSourceOfBusiness">Main Source of business(Other than astrology)?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="mainSourceOfBusiness" id="mainSourceOfBusiness">
                                    @foreach ($mainSourceBusiness as $source)
                                    <option value='{{ $source->jobName }}' {{ (collect(old('mainSourceOfBusiness'))->contains($source->jobName)) ? 'selected' : '' }}>
                                        {{ $source->jobName }}</option>
                                    @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="highestQualification">Select your qualification<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="highestQualification" id="highestQualification">
                                    @foreach ($highestQualification as $highest)
                                    <option value='{{ $highest->qualificationName }}' {{ (collect(old('highestQualification'))->contains($highest->qualificationName)) ? 'selected' : '' }}>
                                        {{ $highest->qualificationName }}</option>
                                @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="degree">Degree / Diploma<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="degree" id="degree">
                                    @foreach ($qualifications as $qua)
                                    <option value='{{ $qua->degreeName }}' {{ (collect(old('degree'))->contains($qua->degreeName)) ? 'selected' : '' }}>
                                        {{ $qua->degreeName }}</option>
                                @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="college">College/School/University name<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ old('college') }}" id="college" name="college" class="form-control rounded"
                                     >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="learnAstrology">From where did you learn Astrology?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ old('learnAstrology') }}" id="learnAstrology" name="learnAstrology"
                                    class="form-control rounded"  >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="instaProfileLink">Instagram profile link<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ old('instaProfileLink') }}" id="instaProfileLink" name="instaProfileLink"
                                    class="form-control rounded"  >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="facebookProfileLink">Facebook profile link<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ old('facebookProfileLink') }}" id="facebookProfileLink" name="facebookProfileLink"
                                    class="form-control rounded"  >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="linkedInProfileLink">LinkedIn profile link<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ old('linkedInProfileLink') }}" id="linkedInProfileLink" name="linkedInProfileLink"
                                    class="form-control rounded"  >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="youtubeChannelLink">Youtube profile link<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ old('youtubeChannelLink') }}" id="youtubeChannelLink" name="youtubeChannelLink"
                                    class="form-control rounded"  >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="websiteProfileLink">Website profile link<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ old('websiteProfileLink') }}" id="websiteProfileLink" name="websiteProfileLink"
                                    class="form-control rounded"  >
                            </div>
                            <div class="col-6 mb-3">
                                <label>Did anybody referred you?<span
                                        class="color-red font-weight-bold">*</span></label><br>
                                <input type="radio" id="astro-yes" name="isAnyBodyRefer" value="1"  > Yes
                                <input type="radio" id="astro-no" name="isAnyBodyRefer" value="0"  > No
                            </div>

                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="prevStep()">Previous</a>
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="nextStep()">Next</a>
                        </div>
                    </div>
                    <!-- Step 4 -->
                    <div id="step4"
                        class="categorycontent step-4 sychics-join-form position-relative border px-4 pb-4 step">
                        <h2 class="py-3 text-center"><small class="font-weight-bold">Astrologer Sign Up - Step 4</small>
                        </h2>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="minimumEarning">Minimum Earning Expection<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ old('minimumEarning') }}" id="minimumEarning" name="minimumEarning"
                                    class="form-control rounded"  >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="maximumEarning">Maximum Earning Expection<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ old('maximumEarning') }}" id="maximumEarning" name="maximumEarning"
                                    class="form-control rounded"  >
                            </div>
                            <div class="col-6 mb-3">
                                <label for="NoofforeignCountriesTravel">Number of the foreign countries you lived/travel
                                    to?<span class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="NoofforeignCountriesTravel"
                                    id="NoofforeignCountriesTravel">
                                    @foreach ($countryTravel as $travel)
                                    <option value='{{ $travel->NoOfCountriesTravell }}' {{ (collect(old('NoofforeignCountriesTravel'))->contains($travel->NoOfCountriesTravell)) ? 'selected' : '' }}>
                                        {{ $travel->NoOfCountriesTravell }}</option>
                                @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="currentlyworkingfulltimejob">Are you currently working a fulltime job?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="currentlyworkingfulltimejob"
                                    id="currentlyworkingfulltimejob">
                                    @foreach ($jobs as $working)
                                            <option value='{{ $working->workName }}' {{ (collect(old('currentlyworkingfulltimejob'))->contains($working->workName)) ? 'selected' : '' }}>
                                                {{ $working->workName }}</option>
                                        @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="loginBio">Long Bio<span class="color-red font-weight-bold">*</span></label>
                                <textarea id="loginBio"  name="loginBio" class="form-control rounded">{{ old('loginBio') }}</textarea>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="goodQuality">What are some good qualities of perfect astrologer?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <textarea id="goodQuality"  name="goodQuality" class="form-control rounded">{{ old('goodQuality') }}</textarea>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="biggestChallenge">What was the biggest challenge you faced and how did you
                                    overcome it?<span class="color-red font-weight-bold">*</span></label>
                                <textarea id="biggestChallenge"  name="biggestChallenge" class="form-control rounded">{{ old('biggestChallenge') }}</textarea>
                            </div>

                            <div class="col-6 mb-3">
                                <label for="whatwillDo">A customer is asking the same question repeatedly: what will you
                                    do?<span class="color-red font-weight-bold">*</span></label>
                                <textarea id="whatwillDo"  name="whatwillDo" class="form-control rounded">{{ old('whatwillDo') }}</textarea>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="prevStep()">Previous</a>
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="nextStep()">Next</a>
                        </div>
                    </div>
                    {{-- Step 5 --}}
                    <div id="step5"
                        class="categorycontent step-4 sychics-join-form position-relative border px-4 pb-4 step">
                        <h2 class="py-3 text-center"><small class="font-weight-bold">Astrologer Sign Up - Step 5</small>
                        </h2>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label>Availability<span class="color-red font-weight-bold">*</span></label>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label>Sunday</label>
                                        <input type="hidden" name="astrologerAvailability[0][day]" value="Sunday">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="sunday-from">From Time</label>
                                                <input type="time" id="sunday-from" name="astrologerAvailability[0][time][0][fromTime]"
                                                    class="form-control rounded" placeholder="From Time">
                                            </div>
                                            <div class="col-6">
                                                <label for="sunday-to">To Time</label>
                                                <input type="time" id="sunday-to" name="astrologerAvailability[0][time][0][toTime]"
                                                    class="form-control rounded" placeholder="To Time">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Monday</label>
                                        <input type="hidden" name="astrologerAvailability[1][day]" value="Monday">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="monday-from">From Time</label>
                                                <input type="time" id="monday-from" name="astrologerAvailability[1][time][0][fromTime]"
                                                    class="form-control rounded" placeholder="From Time">
                                            </div>
                                            <div class="col-6">
                                                <label for="monday-to">To Time</label>
                                                <input type="time" id="monday-to" name="astrologerAvailability[1][time][0][toTime]"
                                                    class="form-control rounded" placeholder="To Time">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Tuesday</label>
                                        <input type="hidden" name="astrologerAvailability[2][day]" value="Tuesday">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="tuesday-from">From Time</label>
                                                <input type="time" id="tuesday-from" name="astrologerAvailability[2][time][0][fromTime]"
                                                    class="form-control rounded" placeholder="From Time">
                                            </div>
                                            <div class="col-6">
                                                <label for="tuesday-to">To Time</label>
                                                <input type="time" id="tuesday-to" name="astrologerAvailability[2][time][0][toTime]"
                                                    class="form-control rounded" placeholder="To Time">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Wednesday</label>
                                        <input type="hidden" name="astrologerAvailability[3][day]" value="Wednesday">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="wednesday-from">From Time</label>
                                                <input type="time" id="wednesday-from" name="astrologerAvailability[3][time][0][fromTime]"
                                                    class="form-control rounded" placeholder="From Time">
                                            </div>
                                            <div class="col-6">
                                                <label for="wednesday-to">To Time</label>
                                                <input type="time" id="wednesday-to" name="astrologerAvailability[3][time][0][toTime]"
                                                    class="form-control rounded" placeholder="To Time">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Thursday</label>
                                        <input type="hidden" name="astrologerAvailability[4][day]" value="Thursday">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="thursday-from">From Time</label>
                                                <input type="time" id="thursday-from" name="astrologerAvailability[4][time][0][fromTime]"
                                                    class="form-control rounded" placeholder="From Time">
                                            </div>
                                            <div class="col-6">
                                                <label for="thursday-to">To Time</label>
                                                <input type="time" id="thursday-to" name="astrologerAvailability[4][time][0][toTime]"
                                                    class="form-control rounded" placeholder="To Time">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Friday</label>
                                        <input type="hidden" name="astrologerAvailability[5][day]" value="Friday">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="friday-from">From Time</label>
                                                <input type="time" id="friday-from" name="astrologerAvailability[5][time][0][fromTime]"
                                                    class="form-control rounded" placeholder="From Time">
                                            </div>
                                            <div class="col-6">
                                                <label for="friday-to">To Time</label>
                                                <input type="time" id="friday-to" name="astrologerAvailability[5][time][0][toTime]"
                                                    class="form-control rounded" placeholder="To Time">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Saturday</label>
                                        <input type="hidden" name="astrologerAvailability[6][day]" value="Saturday">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="saturday-from">From Time</label>
                                                <input type="time" id="saturday-from" name="astrologerAvailability[6][time][0][fromTime]"
                                                    class="form-control rounded" placeholder="From Time">
                                            </div>
                                            <div class="col-6">
                                                <label for="saturday-to">To Time</label>
                                                <input type="time" id="saturday-to" name="astrologerAvailability[6][time][0][toTime]"
                                                    class="form-control rounded" placeholder="To Time">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Repeat similar structure for other days of the week -->
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="text-dark">
                                    <small>
                                        <input type="checkbox" id="tandc" class="align-baseline">
                                        I Agree To {{$appname['value']}} <a class="text-dark" style="color:#EE4E5E !important"
                                            href="#" target="_blank">Terms Of Use</a>&nbsp;and&nbsp;<a
                                            class="text-dark" style="color:#EE4E5E !important" href="#"
                                            target="_blank">Privacy Policy</a>
                                    </small>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="prevStep()">Previous</a>
                            <button class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                               >Sign Up</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-6 sychics-join-info pt-lg-0 pt-5">
                <h2><small class="font-weight-bold">BECOME "{{strtoupper($appname['value'])}} VERIFIED" ASTROLOGER: <b
                            class="color-red font-weight-bold">JOIN NOW!</b></small></h2>
                <p>
                    {{$appname['value']}}, one of the best online astrology portals gives you a chance to be a part of its community
                    of best and top-notch Astrologers. Become a part of the team of Astrologers and offer your
                    consultations to clients from all across the globe, &amp; create an online, personalized brand presence.
                </p>
                <div class="row py-2">
                    <div class="col-sm-4 col-12 mb-sm-0 mb-3">
                        <div class="border border-danger rounded text-center p-3 h-100">
                            <img src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/verified-icon.svg') }}"
                                class="mb-1">
                            <span class="d-block font-weight-bold">Verified Expert</span>
                            <p class="mb-0">Astrologers</p>
                        </div>
                    </div>

                    <div class="col-sm-4 col-12 mb-sm-0 mb-3">
                        <div class="border border-danger rounded text-center p-3 h-100">
                            <img src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/24-availability-icon.svg') }}"
                                class="mb-1">
                            <span class="d-block font-weight-bold">24/7</span>
                            <p class="mb-0">Availability</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%' // Ensure Select2 dropdown takes full width of the parent
            });
        });

        let currentStep = 1;
        const totalSteps = 5;

        function nextStep() {
            if (currentStep < totalSteps) {
                document.getElementById('step' + currentStep).classList.remove('active');
                currentStep++;
                document.getElementById('step' + currentStep).classList.add('active');
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                document.getElementById('step' + currentStep).classList.remove('active');
                currentStep--;
                document.getElementById('step' + currentStep).classList.add('active');
            }
        }


    </script>
@endsection
