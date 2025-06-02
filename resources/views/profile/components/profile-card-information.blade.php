<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title">Personal Information</h4>
            </div>
            <div class="col-auto">
                <a href="#" class="float-end text-muted d-inline-flex text-decoration-underline">
                    <i class="iconoir-edit-pencil fs-18 me-1"></i>Edit
                </a>
            </div>
        </div>
    </div>

    <div class="card-body pt-0">
        <ul class="list-unstyled mb-0">
            <li class="mt-2">
                <i class="las la-user me-2 text-secondary fs-22 align-middle"></i>
                <b>Full Name</b> : {{ $user->name }}
            </li>
            <li class="mt-2">
                <i class="las la-envelope text-secondary fs-22 align-middle me-2"></i>
                <b>Email</b> : {{ $user->email }}
            </li>

            @if(!empty(optional($userDetail)->address))
            <li class="mt-2">
                <i class="las la-map-marked me-2 text-secondary fs-22 align-middle"></i>
                <b>Address</b> : {{ $userDetail->address }}
            </li>
            @endif

            @if(!empty(optional($userDetail)->phone))
            <li class="mt-2">
                <i class="las la-phone me-2 text-secondary fs-22 align-middle"></i>
                <b>Phone</b> : {{ $userDetail->phone }}
            </li>
            @endif

            @if(!empty(optional($userDetail)->facebook))
            <li class="mt-2">
                <i class="lab la-facebook me-2 text-secondary fs-22 align-middle"></i>
                <b>Facebook</b> : {{ $userDetail->facebook }}
            </li>
            @endif

            @if(!empty(optional($userDetail)->instagram))
            <li class="mt-2">
                <i class="lab la-instagram me-2 text-secondary fs-22 align-middle"></i>
                <b>Instagram</b> : {{ $userDetail->instagram }}
            </li>
            @endif

            @if(!empty(optional($userDetail)->x))
            <li class="mt-2">
                <i class="lab la-twitter me-2 text-secondary fs-22 align-middle"></i>
                <b>X (Twitter)</b> : {{ $userDetail->x }}
            </li>
            @endif

            @if(!empty(optional($userDetail)->website))
            <li class="mt-2">
                <i class="las la-globe me-2 text-secondary fs-22 align-middle"></i>
                <b>Website</b> : {{ $userDetail->website }}
            </li>
            @endif

            @if(!empty(optional($userDetail)->bio))
            <li class="mt-2">
                <i class="las la-info-circle me-2 text-secondary fs-22 align-middle"></i>
                <b>Bio</b> : {{ $userDetail->bio }}
            </li>
            @endif
        </ul>
    </div>
</div>
