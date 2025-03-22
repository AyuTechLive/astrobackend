@extends('frontend.astrologers.layout.master')
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
                        <i class="fa fa-chevron-right"></i> <span class="breadcrumbtext">Astrologer Profile Update</span>
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
                <form action="{{route('front.updateAstrologer')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Step 1 -->
                    <input type="hidden" name="userId" value="{{$getAstrologer['recordList']['0']['userId']}}">
                    <input type="hidden" name="id" value="{{$getAstrologer['recordList']['0']['id']}}">
                    <div id="step1"
                        class="categorycontent step-1 sychics-join-form position-relative border px-4 pb-4 step active">
                        <h2 class="py-3 text-center"><small class="font-weight-bold">Personal Details</small></h2>
                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label for="name">Name<span class="color-red font-weight-bold">*</span></label>
                                <input type="text" id="name" value="{{$getAstrologer['recordList']['0']['name']}}"
                                    name="name" class="form-control rounded">

                            </div>
                            <div class="col-6 mb-3">
                                <label for="email">Email Address<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="email" id="email" value="{{$getAstrologer['recordList']['0']['email']}}"
                                    name="email" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="contactNo">Phone No<span class="color-red font-weight-bold">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="countryCode" value="{{$user->countryCode}}"
                                        name="countryCode" class="form-control rounded-left" style="max-width: 60px;">
                                    <input type="text" value="{{$getAstrologer['recordList']['0']['contactNo']}}"
                                        id="contactNo" name="contactNo" class="form-control rounded-right">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="profileImage">Profile<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="file" class="form-control" id="profileImage" name="profileImage"
                                    style="height: 44px">

                                @if ($getAstrologer['recordList'][0]['profileImage'])
                                    <div id="imagePreviewContainer" class="mt-2">
                                        <img id="imagePreview" src="/{{$getAstrologer['recordList'][0]['profileImage']}}"
                                            alt="Current Profile Image" style="max-width: 100%; max-height: 200px;">
                                            <input type="hidden" id="oldProfileImage" name="oldProfileImage" value="{{ $getAstrologer['recordList'][0]['profileImage'] ?? '' }}">
                                    </div>
                                @else
                                    <div id="imagePreviewContainer" class="mt-2" style="display: none;">
                                        <img id="imagePreview" src="#" alt="Profile Image Preview"
                                            style="max-width: 100%; max-height: 200px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2" onclick="nextStep()">Next</a>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div id="step2"
                        class="categorycontent step-2 sychics-join-form position-relative border px-4 pb-4 step">
                        <h2 class="py-3 text-center"><small class="font-weight-bold">Skill Details</small>
                        </h2>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="gender">Gender<span class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value="Male" {{$getAstrologer['recordList'][0]['gender'] === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $getAstrologer['recordList'][0]['gender'] === 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="birthDate">Birth Date<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="date"
                                    value="{{ date('Y-m-d', strtotime($getAstrologer['recordList'][0]['birthDate'])) }}"
                                    name="birthDate" id="birthDate" class="form-control rounded border-pink ">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="astrologerCategoryId">Category<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control select2" name="astrologerCategoryId[]"
                                    id="astrologerCategoryId" multiple>
                                    @foreach($categories as $category)
                                        <option value="{{$category['id']}}" {{ in_array($category['id'], array_column($getAstrologer['recordList'][0]['astrologerCategoryId'], 'id')) ? 'selected' : '' }}>{{$category['name']}}</option>
                                    @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="primarySkill">Primary Skills<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control select2" name="primarySkill[]" id="primarySkill" multiple>
                                    @foreach($skills as $skill)
                                        <option value="{{$skill['id']}}" {{ in_array($skill['id'], array_column($getAstrologer['recordList'][0]['primarySkill'], 'id')) ? 'selected' : '' }}>
                                            {{$skill['name']}}
                                        </option>
                                    @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="allSkill">All Skills<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control select2" name="allSkill[]" id="allSkill" multiple>
                                    @foreach($skills as $skill)
                                        <option value="{{$skill['id']}}" {{ in_array($skill['id'], array_column($getAstrologer['recordList'][0]['allSkill'], 'id')) ? 'selected' : '' }}>
                                            {{$skill['name']}}
                                        </option>
                                    @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="languageKnown">Language<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control select2" name="languageKnown[]" id="languageKnown" multiple>
                                    @foreach($languages as $language)
                                        <option value="{{ $language->id }}" {{ in_array($language->id, array_column($getAstrologer['recordList'][0]['languageKnown'], 'id')) ? 'selected' : '' }}>
                                            {{ $language->languageName }}
                                        </option>
                                    @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="charge">Add your charge(as per min)<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="number" value="{{ $getAstrologer['recordList'][0]['charge']}}" id="charge"
                                    name="charge" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="videoCallRate">Add your video charge(as per min)<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="number" value="{{ $getAstrologer['recordList'][0]['videoCallRate']}}"
                                    id="videoCallRate" name="videoCallRate" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="reportRate">Add your report charge<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="number" value="{{ $getAstrologer['recordList'][0]['reportRate']}}"
                                    id="reportRate" name="reportRate" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="experienceInYears">Experience in years<span
                                        class="color-red font-weight-bold">*</span></label>

                                <input type="number" value="{{ $getAstrologer['recordList'][0]['experienceInYears']}}"
                                    id="experienceInYears" name="experienceInYears" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="dailyContribution">How many hours you can contribute daily?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="number" value="{{ $getAstrologer['recordList'][0]['dailyContribution']}}"
                                    id="dailyContribution" name="dailyContribution" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="hearAboutAstroguru">Where did you hear about {{$appname['value']}}?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ $getAstrologer['recordList'][0]['hearAboutAstroguru']}}"
                                    id="hearAboutAstroguru" name="hearAboutAstroguru" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label>Are you working on any other platform?<span
                                        class="color-red font-weight-bold">*</span></label><br>
                                <input type="radio" id="astro-yes" name="isWorkingOnAnotherPlatform" value="1" {{ isset($getAstrologer['recordList'][0]['isWorkingOnAnotherPlatform']) && $getAstrologer['recordList'][0]['isWorkingOnAnotherPlatform'] == '1' ? 'checked' : '' }}> Yes
                                <input type="radio" id="astro-no" name="isWorkingOnAnotherPlatform" value="0" {{ isset($getAstrologer['recordList'][0]['isWorkingOnAnotherPlatform']) && $getAstrologer['recordList'][0]['isWorkingOnAnotherPlatform'] == '0' ? 'checked' : '' }}> No
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="prevStep()">Previous</a>
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2" onclick="nextStep()">Next</a>
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div id="step3"
                        class="categorycontent step-3 sychics-join-form position-relative border px-4 pb-4 step">
                        <h2 class="py-3 text-center"><small class="font-weight-bold">Other Details</small>
                        </h2>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="whyOnBoard">Why do you think we should onboard you?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" id="awhyOnBoard" name="whyOnBoard" class="form-control rounded"
                                    value="{{ $getAstrologer['recordList'][0]['whyOnBoard']}}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="interviewSuitableTime">What is suitable time for interview?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" id="interviewSuitableTime" name="interviewSuitableTime"
                                    class="form-control rounded"
                                    value="{{ $getAstrologer['recordList'][0]['interviewSuitableTime']}}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="currentCity">Which city do you currently live in?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" id="currentCity" name="currentCity" class="form-control rounded"
                                    value="{{ $getAstrologer['recordList'][0]['currentCity']}}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="mainSourceOfBusiness">Main Source of business(Other than astrology)?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="mainSourceOfBusiness" id="mainSourceOfBusiness">
                                    @foreach ($mainSourceBusiness as $source)
                                        <option value="{{ $source->jobName }}" {{ $getAstrologer['recordList'][0]['mainSourceOfBusiness'] == $source->jobName ? 'selected' : '' }}>
                                            {{ $source->jobName }}
                                        </option>
                                    @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="highestQualification">Select your qualification<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="highestQualification" id="highestQualification">
                                    @foreach ($highestQualification as $highest)
                                        <option value='{{ $highest->qualificationName }}' {{ $getAstrologer['recordList'][0]['highestQualification'] == $highest->qualificationName ? 'selected' : '' }}>
                                            {{ $highest->qualificationName }}
                                        </option>
                                    @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="degree">Degree / Diploma<span
                                        class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="degree" id="degree">
                                    @foreach ($qualifications as $qua)
                                        <option value='{{ $qua->degreeName }}' {{ $getAstrologer['recordList'][0]['degree'] == $highest->degree ? 'selected' : '' }}>
                                            {{ $qua->degreeName }}
                                        </option>
                                    @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="college">College/School/University name<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ $getAstrologer['recordList'][0]['college']}}" id="college"
                                    name="college" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="learnAstrology">From where did you learn Astrology?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ $getAstrologer['recordList'][0]['learnAstrology']}}"
                                    id="learnAstrology" name="learnAstrology" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="instaProfileLink">Instagram profile link<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ $getAstrologer['recordList'][0]['instaProfileLink']}}"
                                    id="instaProfileLink" name="instaProfileLink" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="facebookProfileLink">Facebook profile link<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ $getAstrologer['recordList'][0]['facebookProfileLink'] }}"
                                    id="facebookProfileLink" name="facebookProfileLink" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="linkedInProfileLink">LinkedIn profile link<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ $getAstrologer['recordList'][0]['linkedInProfileLink'] }}"
                                    id="linkedInProfileLink" name="linkedInProfileLink" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="youtubeChannelLink">Youtube profile link<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ $getAstrologer['recordList'][0]['youtubeChannelLink'] }}"
                                    id="youtubeChannelLink" name="youtubeChannelLink" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="websiteProfileLink">Website profile link<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ $getAstrologer['recordList'][0]['websiteProfileLink'] }}"
                                    id="websiteProfileLink" name="websiteProfileLink" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label>Did anybody referred you?<span
                                        class="color-red font-weight-bold">*</span></label><br>
                                <input type="radio" id="astro-yes" name="isAnyBodyRefer" value="1" {{ isset($getAstrologer['recordList'][0]['isAnyBodyRefer']) && $getAstrologer['recordList'][0]['isAnyBodyRefer'] == '1' ? 'checked' : '' }}> Yes
                                <input type="radio" id="astro-no" name="isAnyBodyRefer" value="0" {{ isset($getAstrologer['recordList'][0]['isAnyBodyRefer']) && $getAstrologer['recordList'][0]['isAnyBodyRefer'] == '0' ? 'checked' : '' }}> No
                            </div>

                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="prevStep()">Previous</a>
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2" onclick="nextStep()">Next</a>
                        </div>
                    </div>
                    <!-- Step 4 -->
                    <div id="step4"
                        class="categorycontent step-4 sychics-join-form position-relative border px-4 pb-4 step">
                        <h2 class="py-3 text-center"><small class="font-weight-bold">Other Details</small>
                        </h2>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="minimumEarning">Minimum Earning Expection<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ $getAstrologer['recordList'][0]['minimumEarning'] }}"
                                    id="minimumEarning" name="minimumEarning" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="maximumEarning">Maximum Earning Expection<span
                                        class="color-red font-weight-bold">*</span></label>
                                <input type="text" value="{{ $getAstrologer['recordList'][0]['maximumEarning'] }}"
                                    id="maximumEarning" name="maximumEarning" class="form-control rounded">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="NoofforeignCountriesTravel">Number of the foreign countries you lived/travel
                                    to?<span class="color-red font-weight-bold">*</span></label>
                                <select class="form-control" name="NoofforeignCountriesTravel"
                                    id="NoofforeignCountriesTravel">
                                    @foreach ($countryTravel as $travel)
                                        <option value="{{ $travel->NoOfCountriesTravell }}" {{ $getAstrologer['recordList'][0]['NoofforeignCountriesTravel'] == $travel->NoOfCountriesTravell ? 'selected' : '' }}>
                                            {{ $travel->NoOfCountriesTravell }}
                                        </option>
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
                                        <option value="{{ $working->workName }}" {{ $getAstrologer['recordList'][0]['currentlyworkingfulltimejob'] == $working->workName ? 'selected' : '' }}>
                                            {{ $working->workName }}
                                        </option>
                                    @endforeach
                                    <!-- Add more categories as needed -->
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="loginBio">Long Bio<span class="color-red font-weight-bold">*</span></label>
                                <textarea id="loginBio" name="loginBio"
                                    class="form-control rounded">{{ $getAstrologer['recordList'][0]['loginBio'] }}</textarea>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="goodQuality">What are some good qualities of perfect astrologer?<span
                                        class="color-red font-weight-bold">*</span></label>
                                <textarea id="goodQuality" name="goodQuality"
                                    class="form-control rounded">{{ $getAstrologer['recordList'][0]['goodQuality'] }}</textarea>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="biggestChallenge">What was the biggest challenge you faced and how did you
                                    overcome it?<span class="color-red font-weight-bold">*</span></label>
                                <textarea id="biggestChallenge" name="biggestChallenge"
                                    class="form-control rounded">{{ $getAstrologer['recordList'][0]['biggestChallenge'] }}</textarea>
                            </div>

                            <div class="col-6 mb-3">
                                <label for="whatwillDo">A customer is asking the same question repeatedly: what will you
                                    do?<span class="color-red font-weight-bold">*</span></label>
                                <textarea id="whatwillDo" name="whatwillDo"
                                    class="form-control rounded">{{ $getAstrologer['recordList'][0]['whatwillDo'] }}</textarea>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="prevStep()">Previous</a>
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2" onclick="nextStep()">Next</a>
                        </div>
                    </div>
                    {{-- Step 5 --}}
                    <div id="step5"
                        class="categorycontent step-4 sychics-join-form position-relative border px-4 pb-4 step">
                        <h2 class="py-3 text-center"><small class="font-weight-bold">Your Availability</small>
                        </h2>
                        <div class="row">
                            @php
                                $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                            @endphp

                            @foreach ($daysOfWeek as $index => $day)
                                <div class="col-12 mb-3">
                                    <label>{{ $day }}</label>
                                    <input type="hidden" name="astrologerAvailability[{{ $index }}][day]"
                                        value="{{ $day }}">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="{{ strtolower($day) }}-from">From Time</label>
                                            <input type="time" id="{{ strtolower($day) }}-from"
                                                name="astrologerAvailability[{{ $index }}][time][0][fromTime]"
                                                class="form-control rounded" placeholder="From Time"
                                                value="{{ isset($getAstrologer['recordList'][0]['astrologerAvailability'][$index]['time'][0]['fromTime']) ? date('H:i', strtotime($getAstrologer['recordList'][0]['astrologerAvailability'][$index]['time'][0]['fromTime'])) : '' }}">
                                        </div>
                                        <div class="col-6">
                                            <label for="{{ strtolower($day) }}-to">To Time</label>
                                            <input type="time" id="{{ strtolower($day) }}-to"
                                                name="astrologerAvailability[{{ $index }}][time][0][toTime]"
                                                class="form-control rounded" placeholder="To Time"
                                                value="{{ isset($getAstrologer['recordList'][0]['astrologerAvailability'][$index]['time'][0]['toTime']) ? date('H:i', strtotime($getAstrologer['recordList'][0]['astrologerAvailability'][$index]['time'][0]['toTime'])) : '' }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                onclick="prevStep()">Previous</a>
                            <button class="btn btn-chat btn-chat-lg font-weight-bold px-5 py-2"
                                id="btnSave">Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-6 sychics-join-info pt-lg-0 pt-5">
                <h2><small class="font-weight-bold">BECOME "{{strtoupper($appname['value'])}} VERIFIED" ASTROLOGER</small></h2>
                <p>
                    {{$appname['value']}}, one of the best online astrology portals gives you a chance to be a part of
                    its community
                    of best and top-notch Astrologers. Become a part of the team of Astrologers and offer your
                    consultations to clients from all across the globe, &amp; create an online, personalized brand
                    presence.
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
        $(document).ready(function () {
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const profileImageInput = document.getElementById('profileImage');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');

            profileImageInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.src = '#';
                    imagePreviewContainer.style.display = 'none';
                }
            });
        });
    </script>

    @endsection
