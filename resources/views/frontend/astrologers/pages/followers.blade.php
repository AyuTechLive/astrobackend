@extends('frontend.astrologers.layout.master')
<style>
    .profile-card {
        display: flex;
        align-items: center;
        background: #E7F1FF;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #65a9fd;
    }

    .initial {
        width: 100px;
        height: 57px;
        border-radius: 50%;
        /* background-color: #3a3a3a; */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
        margin-right: 10px;
    }

    .profile-info {
        display: flex;
        flex-direction: column;
    }

    .name {
        font-size: 16px;
        font-weight: bold;
    }

    .username {
        font-size: 14px;
        color: #888;
    }
    .inpage {
    background: white !important;
    max-height: 454px;
    height: 454px;
    overflow-y: auto;
}
.avatar {
  vertical-align: middle;
  width: 50px;
  height: 50px;
  border-radius: 50%;
}

</style>
@section('content')

<div class="pt-1 pb-1 bg-red d-none d-md-block astroway-breadcrumb">
    <div class="container">
        <div class="row afterLoginDisplay">
            <div class="col-md-12 d-flex align-items-center">
                <span style="text-transform: capitalize; ">
                    <span class="text-white breadcrumbs">
                        <a href="{{route('front.astrologerindex')}}" style="color:white;text-decoration:none">
                            <i class="fa fa-home font-18"></i>
                        </a>
                        <i class="fa fa-chevron-right"></i> <a href="{{route('front.followerslist')}}"
                            style="color:white;text-decoration:none">Followers</a>
                    </span>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="inpage">
                <div class="text-left pb-md-4 pb-2">
                    <h1 class="h2 font-weight-bold colorblack">My Followers</h1>
                    <p>Check your complete Followers here.</p>
                </div>
                @if (isset($getastrologerfollower) && $getastrologerfollower['totalCount'] > 0)
                    @foreach ($getastrologerfollower['recordList'] as $astrologerFollowers)
                        <div class="col-md-3">
                            <div class="profile-card">
                                @php
                                    $profileImage = !empty($astrologerFollowers['profile']) ? $astrologerFollowers['profile'] : asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/blank-profile.png');
                                @endphp
                                <img class="avatar" src="/{{ $profileImage }}" />&nbsp;&nbsp;
                                <div class="profile-info">
                                    <div class="name">{{ $astrologerFollowers['name'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div >
                        <h3 class="text-center">You have no followers.</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
